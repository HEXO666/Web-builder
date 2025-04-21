@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-12">
            <!-- Add back to builder button when website is available -->
            @isset($website)
                <a href="{{ route('websites.builder', $website) }}" class="btn btn-primary mb-3 me-2">
                    <i class="bi bi-arrow-left"></i> Back to Website Builder
                </a>
            @endisset
            
            <a href="{{ route('sections.show', $theme->section) }}" class="btn btn-outline-secondary mb-3">
                <i class="bi bi-arrow-left"></i> Back to {{ $theme->section->name }}
            </a>
            
            <h1>{{ $theme->name }}</h1>
            <p class="lead">{{ $theme->description }}</p>
            <p><strong>Section:</strong> {{ $theme->section->name }}</p>
            
            @auth
                @isset($website)
                    <div class="alert alert-info mb-4">
                        <h5><i class="bi bi-info-circle-fill"></i> How to use this page:</h5>
                        <ol>
                            <li>Preview the section with default colors in the preview panel</li>
                            <li>Use the color picker controls on the right to customize colors</li>
                            <li>When satisfied with your changes, click the large green button at the bottom right to add the section with your custom colors</li>
                        </ol>
                    </div>
                    
                    <form action="{{ route('website.add.section') }}" method="POST" class="mt-3">
                        @csrf
                        <input type="hidden" name="website_id" value="{{ $website->id }}">
                        <input type="hidden" name="section_id" value="{{ $theme->section->id }}">
                        <input type="hidden" name="section_theme_id" value="{{ $theme->id }}">
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-plus-circle"></i> Add to Website with Current Settings
                        </button>
                    </form>
                @endisset
            @endauth
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Preview</h5>
                </div>
                <div class="card-body p-0">
                    <div class="theme-preview">
                        <style id="dynamic-theme-style">
                            @php
                                $css = $theme->scss_template;
                                foreach($theme->variables as $variable) {
                                    $css = str_replace('$' . $variable->variable_key, $variable->default_value, $css);
                                }
                            @endphp
                            {{ $css }}
                        </style>
                        <div class="section-preview p-3">
                            {!! $theme->section->html_template !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Theme Variables</h5>
                </div>
                <div class="card-body">
                    @if(count($theme->variables) > 0)
                        @isset($website)
                            <form id="addSectionForm" action="{{ route('website.add.section') }}" method="POST">
                                @csrf
                                <input type="hidden" name="website_id" value="{{ $website->id }}">
                                <input type="hidden" name="section_id" value="{{ $theme->section->id }}">
                                <input type="hidden" name="section_theme_id" value="{{ $theme->id }}">
                                <input type="hidden" id="custom_variables_input" name="custom_variables" value="">
                                
                                <div id="themeCustomizer">
                                    @foreach($theme->variables as $variable)
                                        <div class="mb-3">
                                            <label for="{{ $variable->variable_key }}" class="form-label">{{ $variable->name }}</label>
                                            @if($variable->type == 'color')
                                                <input 
                                                    type="color" 
                                                    class="form-control form-control-color theme-variable-input" 
                                                    id="{{ $variable->variable_key }}" 
                                                    data-variable-key="{{ $variable->variable_key }}"
                                                    data-var-name="{{ $variable->name }}"
                                                    value="{{ $variable->default_value }}"
                                                >
                                            @elseif($variable->type == 'number')
                                                <input 
                                                    type="number" 
                                                    class="form-control theme-variable-input" 
                                                    id="{{ $variable->variable_key }}" 
                                                    data-variable-key="{{ $variable->variable_key }}"
                                                    data-var-name="{{ $variable->name }}"
                                                    value="{{ $variable->default_value }}"
                                                >
                                            @else
                                                <input 
                                                    type="text" 
                                                    class="form-control theme-variable-input" 
                                                    id="{{ $variable->variable_key }}" 
                                                    data-variable-key="{{ $variable->variable_key }}"
                                                    data-var-name="{{ $variable->name }}"
                                                    value="{{ $variable->default_value }}"
                                                >
                                            @endif
                                            <small class="text-muted">{{ $variable->description }}</small>
                                        </div>
                                    @endforeach
                                </div>
                                
                                <div class="d-grid gap-2 mt-4">
                                    <button type="submit" id="addToWebsiteDirectBtn" class="btn btn-success btn-lg" style="padding: 15px; font-size: 1.2rem; margin-top: 20px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                                        <i class="bi bi-plus-circle-fill me-2"></i> Add to Website with These Colors
                                    </button>
                                    <small class="text-muted text-center d-block mt-2">Click to add this section with your custom colors</small>
                                </div>
                            </form>
                        @else
                            <div class="alert alert-warning mt-4">
                                <i class="bi bi-exclamation-triangle"></i> You need to select a website first to add this section.
                            </div>
                        @endisset
                    @else
                        <p class="mb-0">This theme has no customizable variables.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Store theme template and variables for live updates
        const themeTemplate = @json($theme->scss_template);
        const themeVariables = @json($theme->variables);
        
        // Form and inputs reference
        const form = document.getElementById('addSectionForm');
        const customVariablesInput = document.getElementById('custom_variables_input');
        const allInputs = document.querySelectorAll('.theme-variable-input');
        const styleElement = document.getElementById('dynamic-theme-style');
        
        // Function to update the preview with current colors
        function updatePreview() {
            let css = themeTemplate;
            
            // Replace all variables with their current values
            allInputs.forEach(input => {
                const key = input.getAttribute('data-variable-key');
                if (key) {
                    css = css.replace(new RegExp('\\$' + key, 'g'), input.value);
                }
            });
            
            // Update the style element
            styleElement.textContent = css;
            console.log('Preview updated with new styles');
        }
        
        // Function to gather all values for the form submission
        function updateCustomVariables() {
            const variables = {};
            
            // Collect values from all inputs
            allInputs.forEach(input => {
                const variableName = input.getAttribute('data-var-name');
                if (variableName) {
                    variables[variableName] = input.value;
                }
            });
            
            // Set the value in the hidden input as a JSON string
            if (customVariablesInput) {
                customVariablesInput.value = JSON.stringify(variables);
                console.log('Updated custom variables:', customVariablesInput.value);
            }
        }
        
        // Initialize with current values
        updateCustomVariables();
        
        // Update on any input change
        allInputs.forEach(input => {
            input.addEventListener('input', function() {
                updatePreview();
                updateCustomVariables();
            });
            
            input.addEventListener('change', function() {
                updatePreview();
                updateCustomVariables();
            });
        });
        
        // Ensure variables are updated before submission
        if (form) {
            form.addEventListener('submit', function(e) {
                updateCustomVariables();
                console.log('Form submitting with custom variables:', customVariablesInput.value);
            });
        }
    });
</script>
@endsection 