<?php

namespace App\Http\Controllers;

use App\Models\SectionTheme;
use App\Models\Website;
use Illuminate\Http\Request;

class ThemeController extends Controller
{
    /**
     * Display the specified theme.
     */
    public function show(Request $request, SectionTheme $theme)
    {
        $theme->load('variables', 'section');
        
        // Verify website_id exists and is valid if provided
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
        
        return view('themes.show', compact('theme', 'website'));
    }
}
