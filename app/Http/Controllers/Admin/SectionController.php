<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Section;
use App\Models\SectionCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SectionController extends Controller
{
    /**
     * Display a listing of the sections.
     */
    public function index()
    {
        $sections = Section::with('category')->paginate(10);
        
        return view('admin.sections.index', compact('sections'));
    }

    /**
     * Show the form for creating a new section.
     */
    public function create()
    {
        $categories = SectionCategory::all();
        
        return view('admin.sections.create', compact('categories'));
    }

    /**
     * Store a newly created section in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:section_categories,id',
            'html_template' => 'required|string',
            'thumbnail' => 'nullable|image|max:2048',
        ]);
        
        // Handle thumbnail upload
        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('section-thumbnails', 'public');
            $validated['thumbnail'] = $thumbnailPath;
        }
        
        // Generate slug
        $validated['slug'] = Str::slug($validated['name']);
        
        Section::create($validated);
        
        return redirect()->route('admin.sections.index')
            ->with('success', 'Section created successfully');
    }

    /**
     * Display the specified section.
     */
    public function show(Section $section)
    {
        $section->load('themes');
        
        return view('admin.sections.show', compact('section'));
    }

    /**
     * Show the form for editing the specified section.
     */
    public function edit(Section $section)
    {
        $categories = SectionCategory::all();
        
        return view('admin.sections.edit', compact('section', 'categories'));
    }

    /**
     * Update the specified section in storage.
     */
    public function update(Request $request, Section $section)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:section_categories,id',
            'html_template' => 'required|string',
            'thumbnail' => 'nullable|image|max:2048',
        ]);
        
        // Handle thumbnail upload
        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('section-thumbnails', 'public');
            $validated['thumbnail'] = $thumbnailPath;
        }
        
        // Generate slug
        $validated['slug'] = Str::slug($validated['name']);
        
        $section->update($validated);
        
        return redirect()->route('admin.sections.index')
            ->with('success', 'Section updated successfully');
    }

    /**
     * Remove the specified section from storage.
     */
    public function destroy(Section $section)
    {
        $section->delete();
        
        return redirect()->route('admin.sections.index')
            ->with('success', 'Section deleted successfully');
    }
}
