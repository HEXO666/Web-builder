<?php

namespace App\Http\Controllers;

use App\Models\Section;
use App\Models\SectionCategory;
use App\Models\Website;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WebsiteController extends Controller
{
    /**
     * Display a listing of the user's websites.
     */
    public function index()
    {
        $websites = Auth::user()->websites()->latest()->get();
        
        return view('websites.index', compact('websites'));
    }

    /**
     * Show the form for creating a new website.
     */
    public function create()
    {
        $templates = collect([]); // Empty collection for templates
        
        return view('websites.create', compact('templates'));
    }

    /**
     * Store a newly created website in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);
        
        $website = Auth::user()->websites()->create($validated);
        
        return redirect()->route('websites.builder', $website)
            ->with('success', 'Website created successfully! Now let\'s build it.');
    }

    /**
     * Display the specified website.
     */
    public function show(Website $website)
    {
        $this->authorize('view', $website);
        
        $website->load('sections.section', 'sections.theme');
        
        return view('websites.show', compact('website'));
    }

    /**
     * Show the form for editing the specified website.
     */
    public function edit(Website $website)
    {
        $this->authorize('update', $website);
        
        return view('websites.edit', compact('website'));
    }

    /**
     * Update the specified website in storage.
     */
    public function update(Request $request, Website $website)
    {
        $this->authorize('update', $website);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'published' => 'boolean',
        ]);
        
        $website->update($validated);
        
        return redirect()->route('websites.show', $website)
            ->with('success', 'Website updated successfully.');
    }

    /**
     * Remove the specified website from storage.
     */
    public function destroy(Website $website)
    {
        $this->authorize('delete', $website);
        
        $website->delete();
        
        return redirect()->route('websites.index')
            ->with('success', 'Website deleted successfully.');
    }
    
    /**
     * Show the website builder interface.
     */
    public function builder(Website $website)
    {
        $this->authorize('update', $website);
        
        $website->load('sections.section', 'sections.theme');
        $categories = SectionCategory::with('sections.themes')->get();
        
        return view('websites.builder', compact('website', 'categories'));
    }
    
    /**
     * Preview the website.
     */
    public function preview(Website $website)
    {
        $this->authorize('view', $website);
        
        $website->load('sections.section', 'sections.theme.variables');
        
        return view('websites.preview', compact('website'));
    }
}
