<?php

namespace App\Http\Controllers;

use App\Models\Section;
use App\Models\SectionCategory;
use App\Models\Website;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    /**
     * Display a listing of the sections.
     */
    public function index(Request $request)
    {
        $categories = SectionCategory::with('sections')->get();
        $categoryId = $request->query('category');
        
        if ($categoryId) {
            $sections = Section::where('category_id', $categoryId)->paginate(12);
        } else {
            $sections = Section::paginate(12);
        }
        
        // Check if we have a website context
        $website = null;
        if ($request->has('website_id')) {
            $website = Website::find($request->website_id);
        }
        
        return view('sections.index', compact('sections', 'categories', 'categoryId', 'website'));
    }

    /**
     * Display the specified section.
     */
    public function show(Request $request, Section $section)
    {
        $section->load('themes.variables');
        
        // Check if we have a website context
        $website = null;
        if ($request->has('website_id')) {
            $website = Website::find($request->website_id);
            if (!$website) {
                return redirect()->route('websites.index')
                    ->with('error', 'Website not found.');
            }
            
            // Check if user is authorized to update this website
            if ($request->user() && !$request->user()->can('update', $website)) {
                return redirect()->route('websites.index')
                    ->with('error', 'You are not authorized to edit this website.');
            }
        }
        
        return view('sections.show', compact('section', 'website'));
    }
}
