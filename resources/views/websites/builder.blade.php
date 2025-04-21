@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1>Website Builder: {{ $website->name }}</h1>
            <p class="lead">Add sections, customize them, and arrange them to build your website.</p>
        </div>
        <div class="col-md-4 text-end">
            <div class="btn-group">
                <a href="{{ route('websites.show', $website) }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i> Back to Website
                </a>
                <a href="{{ route('websites.preview', $website) }}" class="btn btn-primary" target="_blank">
                    <i class="bi bi-eye"></i> Preview
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Left Sidebar: Section Catalog -->
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Section Library</h5>
                </div>
                <div class="card-body p-0">
                    <div class="accordion" id="sectionAccordion">
                        @foreach($categories as $category)
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading{{ $category->id }}">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $category->id }}" aria-expanded="false" aria-controls="collapse{{ $category->id }}">
                                    {{ $category->name }}
                                </button>
                            </h2>
                            <div id="collapse{{ $category->id }}" class="accordion-collapse collapse" aria-labelledby="heading{{ $category->id }}" data-bs-parent="#sectionAccordion">
                                <div class="accordion-body p-2">
                                    @if($category->sections->count() > 0)
                                        <div class="list-group">
                                            @foreach($category->sections as $section)
                                                <a href="{{ url('/sections/' . $section->id . '?website_id=' . $website->id) }}" class="list-group-item list-group-item-action">
                                                    {{ $section->name }}
                                                    <small class="d-block text-muted">{{ $section->themes->count() }} theme(s)</small>
                                                </a>
                                            @endforeach
                                        </div>
                                    @else
                                        <p class="text-muted small m-2">No sections available in this category.</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Middle: Current Website Sections -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Website Sections</h5>
                    <span class="badge bg-primary">{{ $website->sections->count() }} Sections</span>
                </div>
                <div class="card-body p-0">
                    @if($website->sections->count() > 0)
                        <div class="list-group section-list" id="sortableSections">
                            @foreach($website->sections as $websiteSection)
                                <div class="list-group-item section-item" data-id="{{ $websiteSection->id }}">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            <span class="section-drag-handle me-2">
                                                <i class="bi bi-grip-vertical"></i>
                                            </span>
                                            <div>
                                                <h6 class="mb-0">{{ $websiteSection->section->name }}</h6>
                                                <small class="text-muted">Theme: {{ $websiteSection->theme->name }}</small>
                                            </div>
                                        </div>
                                        <div class="btn-group">
                                            <button class="btn btn-sm btn-outline-primary edit-section-btn" data-id="{{ $websiteSection->id }}">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger delete-section-btn" data-id="{{ $websiteSection->id }}">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="bi bi-clipboard-plus" style="font-size: 3rem;"></i>
                            <h4 class="mt-3">No Sections Added Yet</h4>
                            <p class="text-muted">
                                Browse the section library and click on a section to add it to your website.
                            </p>
                        </div>
                    @endif
                </div>
            </div>

            @if($website->sections->count() > 0)
                <div class="card mt-3">
                    <div class="card-body text-center">
                        <p class="mb-2"><i class="bi bi-info-circle"></i> Drag and drop sections to reorder them.</p>
                        <button id="saveOrderBtn" class="btn btn-success">
                            <i class="bi bi-save"></i> Save Order
                        </button>
                    </div>
                </div>
            @endif
        </div>

        <!-- Right Sidebar: Section Editor -->
        <div class="col-md-3">
            <div class="card" id="sectionEditor">
                <div class="card-header">
                    <h5 class="mb-0">Section Editor</h5>
                </div>
                <div class="card-body">
                    <div id="editorContent">
                        <div class="text-center py-5">
                            <i class="bi bi-pencil-square" style="font-size: 3rem;"></i>
                            <h4 class="mt-3">No Section Selected</h4>
                            <p class="text-muted">
                                Click on the edit button next to a section to customize it.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Section Editor Template -->
<template id="sectionEditorTemplate">
    <form id="sectionVariablesForm">
        <h5 class="section-name"></h5>
        <p class="text-muted theme-name"></p>
        <div class="variables-container mb-3">
            <!-- Variables will be injected here -->
        </div>
        <div class="d-grid">
            <button type="submit" class="btn btn-primary">Save Changes</button>
        </div>
    </form>
</template>

<!-- Section Delete Confirmation Modal -->
<div class="modal fade" id="deleteSectionModal" tabindex="-1" aria-labelledby="deleteSectionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteSectionModalLabel">Confirm Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to remove this section from your website?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete Section</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.14.0/Sortable.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize sortable sections
        const sortableList = document.getElementById('sortableSections');
        if (sortableList) {
            new Sortable(sortableList, {
                handle: '.section-drag-handle',
                animation: 150,
                onEnd: function() {
                    // Update order of sections
                }
            });
        }

        // Save Order Button
        const saveOrderBtn = document.getElementById('saveOrderBtn');
        if (saveOrderBtn) {
            saveOrderBtn.addEventListener('click', function() {
                const sections = document.querySelectorAll('.section-item');
                const orderData = {
                    sections: []
                };

                sections.forEach((section, index) => {
                    orderData.sections.push({
                        id: section.dataset.id,
                        order: index + 1
                    });
                });

                // Send reorder request
                fetch('{{ route("website.sections.reorder", $website) }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify(orderData)
                })
                .then(response => response.json())
                .then(data => {
                    alert('Sections reordered successfully!');
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Failed to reorder sections.');
                });
            });
        }

        // Edit Section Button
        const editButtons = document.querySelectorAll('.edit-section-btn');
        editButtons.forEach(button => {
            button.addEventListener('click', function() {
                const sectionId = this.dataset.id;
                loadSectionEditor(sectionId);
            });
        });

        // Delete Section Button
        const deleteButtons = document.querySelectorAll('.delete-section-btn');
        const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
        let currentSectionId = null;

        deleteButtons.forEach(button => {
            button.addEventListener('click', function() {
                currentSectionId = this.dataset.id;
                const modal = new bootstrap.Modal(document.getElementById('deleteSectionModal'));
                modal.show();
            });
        });

        if (confirmDeleteBtn) {
            confirmDeleteBtn.addEventListener('click', function() {
                if (currentSectionId) {
                    deleteSection(currentSectionId);
                }
            });
        }

        function loadSectionEditor(sectionId) {
            fetch(`/websites/{{ $website->id }}/sections/${sectionId}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                const editorContent = document.getElementById('editorContent');
                const template = document.getElementById('sectionEditorTemplate').content.cloneNode(true);
                
                template.querySelector('.section-name').textContent = data.section.name;
                template.querySelector('.theme-name').textContent = `Theme: ${data.theme.name}`;
                
                const variablesContainer = template.querySelector('.variables-container');
                variablesContainer.innerHTML = '';
                
                // Create form fields for each variable
                data.theme.variables.forEach(variable => {
                    const value = data.custom_variables[variable.variable_key] || variable.default_value;
                    const fieldHtml = createVariableField(variable, value);
                    variablesContainer.insertAdjacentHTML('beforeend', fieldHtml);
                });
                
                // Set form submit handler
                const form = template.querySelector('form');
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    saveSectionVariables(sectionId, form);
                });
                
                // Clear and append the editor content
                editorContent.innerHTML = '';
                editorContent.appendChild(template);
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to load section editor.');
            });
        }
        
        function createVariableField(variable, value) {
            let fieldHtml = `
                <div class="mb-3">
                    <label for="var_${variable.variable_key}" class="form-label">${variable.name}</label>
            `;
            
            if (variable.type === 'color') {
                fieldHtml += `
                    <input type="color" class="form-control form-control-color" 
                           id="var_${variable.variable_key}" 
                           name="${variable.variable_key}" 
                           value="${value}">
                `;
            } else if (variable.type === 'number') {
                fieldHtml += `
                    <input type="number" class="form-control" 
                           id="var_${variable.variable_key}" 
                           name="${variable.variable_key}" 
                           value="${value}">
                `;
            } else {
                fieldHtml += `
                    <input type="text" class="form-control" 
                           id="var_${variable.variable_key}" 
                           name="${variable.variable_key}" 
                           value="${value}">
                `;
            }
            
            if (variable.description) {
                fieldHtml += `<small class="form-text text-muted">${variable.description}</small>`;
            }
            
            fieldHtml += `</div>`;
            return fieldHtml;
        }
        
        function saveSectionVariables(sectionId, form) {
            const formData = new FormData(form);
            const customVariables = {};
            
            for (const [key, value] of formData.entries()) {
                customVariables[key] = value;
            }
            
            fetch(`/websites/{{ $website->id }}/sections/${sectionId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    custom_variables: customVariables
                })
            })
            .then(response => response.json())
            .then(data => {
                alert('Section customization saved successfully!');
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to save section customization.');
            });
        }
        
        function deleteSection(sectionId) {
            fetch(`/websites/{{ $website->id }}/sections/${sectionId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                const modal = bootstrap.Modal.getInstance(document.getElementById('deleteSectionModal'));
                modal.hide();
                window.location.reload();
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to delete section.');
            });
        }
    });
</script>
@endsection 