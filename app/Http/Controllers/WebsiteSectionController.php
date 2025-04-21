<?php

namespace App\Http\Controllers;

use App\Models\Section;
use App\Models\SectionTheme;
use App\Models\Website;
use App\Models\WebsiteSection;
use Illuminate\Http\Request;

class WebsiteSectionController extends Controller
{
    /**
     * Store a newly created website section in storage.
     */
    public function store(Request $request, Website $website)
    {
        $this->authorize('update', $website);
        
        $validated = $request->validate([
            'section_id' => 'required|exists:sections,id',
            'section_theme_id' => 'required|exists:section_themes,id',
            'custom_variables' => 'nullable',
        ]);
        
        // Get the highest order and add 1
        $maxOrder = $website->sections()->max('order') ?? 0;
        
        // Process custom_variables if provided
        $customVariables = [];
        if ($request->has('custom_variables')) {
            if (is_string($request->custom_variables)) {
                // If it's a JSON string, decode it
                $customVariables = json_decode($request->custom_variables, true) ?? [];
            } else {
                // If it's already an array
                $customVariables = $request->custom_variables;
            }
        }
        
        $websiteSection = $website->sections()->create([
            'section_id' => $validated['section_id'],
            'section_theme_id' => $validated['section_theme_id'],
            'order' => $maxOrder + 1,
            'custom_variables' => $customVariables, 
        ]);
        
        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Section added successfully',
                'website_section' => $websiteSection->load('section', 'theme')
            ]);
        }
        
        return redirect()->route('websites.builder', $website)
            ->with('success', 'Section added successfully!');
    }

    /**
     * Get a specific website section for editing.
     */
    public function show(Website $website, WebsiteSection $websiteSection)
    {
        $this->authorize('update', $website);
        
        $websiteSection->load('section', 'theme.variables');
        
        return response()->json([
            'section' => $websiteSection->section,
            'theme' => $websiteSection->theme,
            'custom_variables' => $websiteSection->custom_variables ?: [],
        ]);
    }

    /**
     * Update the specified website section in storage.
     */
    public function update(Request $request, Website $website, WebsiteSection $websiteSection)
    {
        $this->authorize('update', $website);
        
        $validated = $request->validate([
            'custom_variables' => 'required|array',
        ]);
        
        \Log::info('Updating section variables:', [
            'section_id' => $websiteSection->id,
            'old_variables' => $websiteSection->custom_variables,
            'new_variables' => $validated['custom_variables'],
        ]);
        
        // Process the custom variables to maintain a consistent format
        $customVariables = [];
        
        // Load theme variables to get their names
        $websiteSection->load('theme.variables');
        $variablesByKey = [];
        
        // Create a map of variable keys to names
        foreach ($websiteSection->theme->variables as $variable) {
            $variablesByKey[$variable->variable_key] = $variable->name;
        }
        
        // Save using variable names as keys (more consistent)
        foreach ($validated['custom_variables'] as $key => $value) {
            // If the key is a variable key, use the variable name instead
            if (isset($variablesByKey[$key])) {
                $customVariables[$variablesByKey[$key]] = $value;
            } else {
                // Otherwise keep as is (it might already be the variable name)
                $customVariables[$key] = $value;
            }
        }
        
        $websiteSection->update([
            'custom_variables' => $customVariables,
        ]);
        
        return response()->json([
            'message' => 'Section updated successfully',
            'website_section' => $websiteSection->fresh()
        ]);
    }

    /**
     * Remove the specified website section from storage.
     */
    public function destroy(Website $website, WebsiteSection $websiteSection)
    {
        $this->authorize('update', $website);
        
        $websiteSection->delete();
        
        // Reorder remaining sections
        $website->sections()->orderBy('order')->get()->each(function ($section, $index) {
            $section->update(['order' => $index + 1]);
        });
        
        return response()->json([
            'message' => 'Section removed successfully'
        ]);
    }
    
    /**
     * Reorder website sections.
     */
    public function reorder(Request $request, Website $website)
    {
        $this->authorize('update', $website);
        
        $validated = $request->validate([
            'sections' => 'required|array',
            'sections.*.id' => 'required|exists:website_sections,id',
            'sections.*.order' => 'required|integer|min:1',
        ]);
        
        foreach ($validated['sections'] as $sectionData) {
            WebsiteSection::where('id', $sectionData['id'])
                ->where('website_id', $website->id)
                ->update(['order' => $sectionData['order']]);
        }
        
        return response()->json([
            'message' => 'Sections reordered successfully'
        ]);
    }

    /**
     * Add a section to a website (alternative route without route parameter)
     */
    public function addToWebsite(Request $request)
    {
        // Log the entire request for debugging
        \Log::info('AddToWebsite Request:', [
            'all' => $request->all(),
            'method' => $request->method(),
            'has_website_id' => $request->has('website_id'),
            'website_id' => $request->input('website_id'),
            'has_custom_variables' => $request->has('custom_variables'),
            'custom_variables_raw' => $request->input('custom_variables'),
        ]);
        
        $validated = $request->validate([
            'website_id' => 'required|exists:websites,id',
            'section_id' => 'required|exists:sections,id',
            'section_theme_id' => 'required|exists:section_themes,id',
            'custom_variables' => 'nullable',
        ]);
        
        $website = \App\Models\Website::findOrFail($validated['website_id']);
        
        // Authorize the user
        $this->authorize('update', $website);
        
        // Get the highest order and add 1
        $maxOrder = $website->sections()->max('order') ?? 0;
        
        // Process custom_variables if provided
        $customVariables = [];
        
        // Load the theme to get variable information
        $theme = \App\Models\SectionTheme::with('variables')->find($validated['section_theme_id']);
        
        if ($request->has('custom_variables') && !empty($request->custom_variables)) {
            try {
                $decodedVariables = null;
                
                if (is_string($request->custom_variables)) {
                    // If it's a JSON string, decode it
                    $decodedVariables = json_decode($request->custom_variables, true);
                    if (json_last_error() !== JSON_ERROR_NONE) {
                        \Log::error('Failed to decode custom variables: ' . json_last_error_msg());
                        \Log::error('Custom variables value: ' . $request->custom_variables);
                        $decodedVariables = null;
                    }
                } else if (is_array($request->custom_variables)) {
                    // If it's already an array
                    $decodedVariables = $request->custom_variables;
                }
                
                if ($decodedVariables && is_array($decodedVariables)) {
                    // Store variables using variable names as keys (more reliable)
                    foreach ($decodedVariables as $key => $value) {
                        $customVariables[$key] = $value;
                    }
                    
                    // Log the processing
                    \Log::info('Processed custom variables:', [
                        'raw' => $request->custom_variables,
                        'decoded' => $decodedVariables,
                        'processed' => $customVariables
                    ]);
                }
            } catch (\Exception $e) {
                \Log::error('Exception processing custom variables: ' . $e->getMessage());
            }
        }
        
        // Debug output to see what's being saved
        \Log::info('Adding section with custom variables: ', [
            'website_id' => $validated['website_id'],
            'section_id' => $validated['section_id'],
            'section_theme_id' => $validated['section_theme_id'],
            'custom_variables' => $customVariables,
        ]);
        
        $websiteSection = $website->sections()->create([
            'section_id' => $validated['section_id'],
            'section_theme_id' => $validated['section_theme_id'],
            'order' => $maxOrder + 1,
            'custom_variables' => $customVariables, 
        ]);
        
        // Log the created section
        \Log::info('WebsiteSection created:', [
            'id' => $websiteSection->id,
            'website_id' => $websiteSection->website_id,
            'section_id' => $websiteSection->section_id,
            'custom_variables' => $websiteSection->custom_variables,
        ]);
        
        // Always redirect to the builder page after adding a section
        return redirect()->route('websites.builder', $website)
            ->with('success', 'Section added successfully with your custom colors!');
    }
}
