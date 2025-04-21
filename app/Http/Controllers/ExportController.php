<?php

namespace App\Http\Controllers;

use App\Models\Website;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use ZipArchive;

class ExportController extends Controller
{
    /**
     * Export the website to static HTML, CSS, and JS files.
     */
    public function export(Request $request, Website $website)
    {
        $this->authorize('view', $website);
        
        try {
            // Load website sections with their data
            $website->load('sections.section', 'sections.theme.variables');
            
            // Create export directory
            $exportDir = storage_path('app/exports/' . $website->id . '_' . Str::slug($website->name) . '_' . time());
            
            // Make sure parent directories exist
            if (!File::exists(storage_path('app/exports'))) {
                File::makeDirectory(storage_path('app/exports'), 0755, true);
            }
            
            File::makeDirectory($exportDir, 0755, true);
            
            // Create CSS directory
            $cssDir = $exportDir . '/css';
            File::makeDirectory($cssDir, 0755, true);
            
            // Create JS directory
            $jsDir = $exportDir . '/js';
            File::makeDirectory($jsDir, 0755, true);
            
            // Generate HTML file
            $html = view('exports.index', compact('website'))->render();
            File::put($exportDir . '/index.html', $html);
            
            // Generate CSS file with all compiled SCSS
            $css = $this->generateCss($website);
            File::put($cssDir . '/styles.css', $css);
            
            // Add a placeholder bootstrap CSS if not available
            if (!File::exists(public_path('css/bootstrap.min.css'))) {
                File::put($cssDir . '/bootstrap.min.css', '/* Bootstrap placeholder */');
            } else {
                File::copy(public_path('css/bootstrap.min.css'), $cssDir . '/bootstrap.min.css');
            }
            
            // Add a placeholder bootstrap JS if not available
            if (!File::exists(public_path('js/bootstrap.min.js'))) {
                File::put($jsDir . '/bootstrap.min.js', '/* Bootstrap JS placeholder */');
            } else {
                File::copy(public_path('js/bootstrap.min.js'), $jsDir . '/bootstrap.min.js');
            }
            
            // Create zip file
            $zipPath = storage_path('app/exports/' . $website->id . '_' . Str::slug($website->name) . '.zip');
            
            if (!class_exists('ZipArchive')) {
                // Fallback for when ZipArchive isn't available
                return response()->json([
                    'message' => 'Website export prepared successfully but ZIP creation failed (ZipArchive unavailable)',
                    'download_url' => url($exportDir . '/index.html'),
                ]);
            }
            
            $zipCreated = $this->createZipArchive($exportDir, $zipPath);
            
            if (!$zipCreated) {
                return response()->json([
                    'message' => 'Website export prepared successfully but ZIP creation failed',
                    'download_url' => url($exportDir . '/index.html'),
                ]);
            }
            
            // Update website with export path
            $website->update([
                'export_path' => $zipPath,
            ]);
            
            return response()->json([
                'message' => 'Website exported successfully',
                'download_url' => route('websites.download', $website),
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Export failed: ' . $e->getMessage(),
                'error' => true
            ], 500);
        }
    }
    
    /**
     * Download the exported website as a zip file.
     */
    public function download(Website $website)
    {
        $this->authorize('view', $website);
        
        if (!$website->export_path || !File::exists($website->export_path)) {
            // Check if we have a directory with exported files instead
            $exportDir = glob(storage_path('app/exports/' . $website->id . '_*'));
            
            if (!empty($exportDir)) {
                $latestExportDir = end($exportDir);
                $indexFile = $latestExportDir . '/index.html';
                
                if (File::exists($indexFile)) {
                    return response()->file($indexFile);
                }
            }
            
            // If no export found at all
            return redirect()->route('websites.preview', $website)
                ->with('error', 'No export found. Please export your website first.');
        }
        
        return response()->download(
            $website->export_path,
            Str::slug($website->name) . '.zip'
        );
    }
    
    /**
     * Generate CSS from SCSS templates.
     */
    private function generateCss(Website $website)
    {
        $css = "/* Generated CSS for website: {$website->name} */\n\n";
        
        foreach ($website->sections as $websiteSection) {
            $section = $websiteSection->section;
            $theme = $websiteSection->theme;
            $customVars = $websiteSection->custom_variables;
            
            $sectionCss = $theme->scss_template;
            
            // Replace variables with custom values
            foreach ($theme->variables as $variable) {
                $key = $variable->variable_key;
                $varName = $variable->name;
                
                // Try to get the custom value in different ways
                $value = null;
                
                // First check by variable name (as stored in the custom_variables JSON)
                if (isset($customVars[$varName])) {
                    $value = $customVars[$varName];
                } 
                // Then try by key (fallback)
                elseif (isset($customVars[$key])) {
                    $value = $customVars[$key];
                }
                // Otherwise use default value
                else {
                    $value = $variable->default_value;
                }
                
                $sectionCss = str_replace('$' . $key, $value, $sectionCss);
            }
            
            // Add section ID to all CSS rules to prevent conflicts
            // Split the CSS into separate rules
            preg_match_all('/(.*?)\s*\{([^}]*)\}/s', $sectionCss, $matches, PREG_SET_ORDER);
            
            $scopedCss = "";
            foreach ($matches as $match) {
                if (count($match) >= 3) {
                    $selectors = explode(',', $match[1]);
                    $properties = $match[2];
                    
                    $scopedSelectors = [];
                    foreach ($selectors as $selector) {
                        $selector = trim($selector);
                        // Skip empty selectors
                        if (empty($selector)) continue;
                        
                        // Add the section ID to properly scope the selector
                        $scopedSelectors[] = "#section-{$websiteSection->id} " . $selector;
                    }
                    
                    if (!empty($scopedSelectors)) {
                        $scopedCss .= implode(", ", $scopedSelectors) . " {" . $properties . "}\n";
                    }
                }
            }
            
            $css .= "/* Section: {$section->name} - Theme: {$theme->name} */\n";
            $css .= $scopedCss . "\n\n";
        }
        
        return $css;
    }
    
    /**
     * Create a zip archive from a directory.
     */
    private function createZipArchive($sourceDir, $zipPath)
    {
        $zip = new ZipArchive();
        
        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
            $files = new \RecursiveIteratorIterator(
                new \RecursiveDirectoryIterator($sourceDir),
                \RecursiveIteratorIterator::LEAVES_ONLY
            );
            
            foreach ($files as $file) {
                if (!$file->isDir()) {
                    $filePath = $file->getRealPath();
                    $relativePath = substr($filePath, strlen($sourceDir) + 1);
                    
                    $zip->addFile($filePath, $relativePath);
                }
            }
            
            $zip->close();
            
            // Remove the temporary directory
            File::deleteDirectory($sourceDir);
            
            return true;
        }
        
        return false;
    }
}
