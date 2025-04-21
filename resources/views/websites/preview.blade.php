<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $website->name }} - Preview</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        /* Generated CSS for the website */
        @foreach($website->sections as $websiteSection)
            /* Section: {{ $websiteSection->section->name }} - Theme: {{ $websiteSection->theme->name }} */
            #section-{{ $websiteSection->id }} {
                /* Add base styling to the section wrapper */
                width: 100%;
            }
            
            @php
                // Get the original CSS template
                $originalCss = $websiteSection->theme->scss_template;
                
                // Replace variables with custom values
                $processedCss = $originalCss;
                
                // Only output debug comments in preview, not in export
                $isExport = isset($export) && $export === true;
                
                if (!$isExport) {
                    echo "/* Original variables */\n";
                }
                
                foreach($websiteSection->theme->variables as $variable) {
                    $key = $variable->variable_key;
                    $varName = $variable->name;
                    
                    // Try to get the custom value in different ways
                    $value = null;
                    
                    // First check by variable name (as stored in the custom_variables JSON)
                    if (isset($websiteSection->custom_variables[$varName])) {
                        $value = $websiteSection->custom_variables[$varName];
                        if (!$isExport) {
                            echo "/* Using variable name: $varName = $value */\n";
                        }
                    } 
                    // Then try by key (fallback)
                    elseif (isset($websiteSection->custom_variables[$key])) {
                        $value = $websiteSection->custom_variables[$key];
                        if (!$isExport) {
                            echo "/* Using variable key: $key = $value */\n";
                        }
                    }
                    // Otherwise use default value
                    else {
                        $value = $variable->default_value;
                        if (!$isExport) {
                            echo "/* Using default: $key = $value */\n";
                        }
                    }
                    
                    // Replace in CSS - make sure to handle the $ properly
                    $processedCss = str_replace('$' . $key, $value, $processedCss);
                }
                
                // Convert the CSS to be scoped to this section ID
                // Split the CSS into separate rules
                preg_match_all('/(.*?)\s*\{([^}]*)\}/s', $processedCss, $matches, PREG_SET_ORDER);
                
                $scopedCss = "";
                foreach ($matches as $match) {
                    $selectors = explode(',', $match[1]);
                    $properties = $match[2];
                    
                    $scopedSelectors = [];
                    foreach ($selectors as $selector) {
                        $selector = trim($selector);
                        // Skip empty selectors
                        if (empty($selector)) continue;
                        
                        $scopedSelectors[] = "#section-{$websiteSection->id} " . $selector;
                    }
                    
                    if (!empty($scopedSelectors)) {
                        $scopedCss .= implode(", ", $scopedSelectors) . " {" . $properties . "}\n";
                    }
                }
                
                echo $scopedCss;
            @endphp
        @endforeach
    </style>
</head>
<body>
    <div class="website-preview">
        @if($website->sections->count() > 0)
            @foreach($website->sections as $websiteSection)
                <div id="section-{{ $websiteSection->id }}" class="website-section">
                    {!! $websiteSection->section->html_template !!}
                </div>
                <!-- Debug info (only shown in preview mode, not in export) -->
                @if(config('app.debug') && (!isset($export) || $export !== true))
                <div class="small text-muted m-2 p-2 border-top">
                    <strong>Debug:</strong> 
                    Section ID: {{ $websiteSection->id }}, 
                    Section: {{ $websiteSection->section->name }},
                    Theme: {{ $websiteSection->theme->name }},
                    Custom Variables: {{ json_encode($websiteSection->custom_variables) }}
                </div>
                @endif
            @endforeach
        @else
            <div class="container py-5 text-center">
                <div class="alert alert-info">
                    <h3>No Content Added Yet</h3>
                    <p>Your website doesn't have any sections yet. Go back to the website builder to add some content.</p>
                </div>
                <a href="{{ route('websites.builder', $website) }}" class="btn btn-primary">Go to Website Builder</a>
            </div>
        @endif
    </div>

    <!-- Export Modal -->
    @if(!isset($export) || $export !== true)
    <div class="modal fade" id="exportModal" tabindex="-1" aria-labelledby="exportModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exportModalLabel">Export Website</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Your website is being exported. This may take a few moments...</p>
                    <div class="progress">
                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 100%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Preview Control Panel -->
    <div class="position-fixed bottom-0 start-0 end-0 bg-dark text-white p-3">
        <div class="container d-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-0">{{ $website->name }} - Preview</h5>
                <small>{{ $website->published ? 'Published' : 'Draft' }}</small>
            </div>
            <div class="btn-group">
                <a href="{{ route('websites.builder', $website) }}" class="btn btn-outline-light">
                    <i class="bi bi-pencil"></i> Edit
                </a>
                <button id="exportBtn" class="btn btn-success">
                    <i class="bi bi-download"></i> Export Website
                </button>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Export Button
            const exportBtn = document.getElementById('exportBtn');
            if (exportBtn) {
                exportBtn.addEventListener('click', function() {
                    // Show export modal
                    const modal = new bootstrap.Modal(document.getElementById('exportModal'));
                    modal.show();
                    
                    // Send export request
                    fetch('{{ route("websites.export", $website) }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Server responded with status: ' + response.status);
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.error) {
                            throw new Error(data.message || 'Export failed');
                        }
                        
                        // Hide modal
                        modal.hide();
                        
                        // Show success message
                        alert('Export successful! Downloading file...');
                        
                        // Download file
                        window.location.href = data.download_url;
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        
                        // Update modal with error
                        const modalBody = document.querySelector('#exportModal .modal-body');
                        modalBody.innerHTML = `
                            <div class="alert alert-danger">
                                <h5>Export Failed</h5>
                                <p>${error.message || 'An error occurred during export'}</p>
                            </div>
                            <p>Possible solutions:</p>
                            <ul>
                                <li>Make sure storage/app/exports directory is writable</li>
                                <li>Check that the ZipArchive PHP extension is installed</li>
                                <li>Try again or contact the administrator</li>
                            </ul>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        `;
                    });
                });
            }
        });
    </script>
    @endif
</body>
</html> 