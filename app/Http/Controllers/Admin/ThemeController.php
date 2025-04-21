<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Section;
use App\Models\SectionTheme;
use App\Models\ThemeVariable;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ThemeController extends Controller
{
    /**
     * Display a listing of the themes.
     */
    public function index()
    {
        $themes = SectionTheme::with('section')->paginate(10);
        
        return view('admin.themes.index', compact('themes'));
    }

    /**
     * Show the form for creating a new theme.
     */
    public function create()
    {
        $sections = Section::all();
        
        return view('admin.themes.create', compact('sections'));
    }

    /**
     * Store a newly created theme in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'section_id' => 'required|exists:sections,id',
            'scss_template' => 'required|string',
            'thumbnail' => 'nullable|image|max:2048',
        ]);
        
        // Handle thumbnail upload
        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('theme-thumbnails', 'public');
            $validated['thumbnail'] = $thumbnailPath;
        }
        
        // Generate slug
        $validated['slug'] = Str::slug($validated['name']);
        
        $theme = SectionTheme::create($validated);
        
        return redirect()->route('admin.themes.show', $theme)
            ->with('success', 'Theme created successfully. Now add variables to it.');
    }

    /**
     * Display the specified theme.
     */
    public function show(SectionTheme $theme)
    {
        $theme->load('section', 'variables');
        
        return view('admin.themes.show', compact('theme'));
    }

    /**
     * Show the form for editing the specified theme.
     */
    public function edit(SectionTheme $theme)
    {
        $sections = Section::all();
        
        return view('admin.themes.edit', compact('theme', 'sections'));
    }

    /**
     * Update the specified theme in storage.
     */
    public function update(Request $request, SectionTheme $theme)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'section_id' => 'required|exists:sections,id',
            'scss_template' => 'required|string',
            'thumbnail' => 'nullable|image|max:2048',
        ]);
        
        // Handle thumbnail upload
        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('theme-thumbnails', 'public');
            $validated['thumbnail'] = $thumbnailPath;
        }
        
        // Generate slug
        $validated['slug'] = Str::slug($validated['name']);
        
        $theme->update($validated);
        
        return redirect()->route('admin.themes.show', $theme)
            ->with('success', 'Theme updated successfully');
    }

    /**
     * Remove the specified theme from storage.
     */
    public function destroy(SectionTheme $theme)
    {
        $theme->delete();
        
        return redirect()->route('admin.themes.index')
            ->with('success', 'Theme deleted successfully');
    }
    
    /**
     * Store a new variable for the theme.
     */
    public function storeVariable(Request $request, SectionTheme $theme)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'variable_key' => 'required|string|max:255',
            'default_value' => 'required|string|max:255',
            'type' => 'required|in:color,text,number',
            'description' => 'nullable|string',
        ]);
        
        $theme->variables()->create($validated);
        
        return redirect()->route('admin.themes.show', $theme)
            ->with('success', 'Variable added successfully');
    }
    
    /**
     * Update the specified variable.
     */
    public function updateVariable(Request $request, SectionTheme $theme, ThemeVariable $variable)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'variable_key' => 'required|string|max:255',
            'default_value' => 'required|string|max:255',
            'type' => 'required|in:color,text,number',
            'description' => 'nullable|string',
        ]);
        
        $variable->update($validated);
        
        return redirect()->route('admin.themes.show', $theme)
            ->with('success', 'Variable updated successfully');
    }
    
    /**
     * Remove the specified variable.
     */
    public function destroyVariable(SectionTheme $theme, ThemeVariable $variable)
    {
        $variable->delete();
        
        return redirect()->route('admin.themes.show', $theme)
            ->with('success', 'Variable deleted successfully');
    }
}
