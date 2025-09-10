/**
 * Enhanced Admin JavaScript for Pin Management
 * File: assets/js/pin-admin.js
 */

(function($) {
    'use strict';

    const PinAdmin = {
        
        // Configuration
        config: {
            dragEnabled: false,
            gridSize: 10,
            snapToGrid: false,
            showCoordinates: false
        },
        
        // State
        state: {
            selectedPins: [],
            sortColumn: null,
            sortDirection: 'asc',
            filterType: '',
            searchTerm: ''
        },
        
        // Initialize the admin interface
        init: function() {
            this.bindEvents();
            this.initializeInterface();
            this.setupTableFeatures();
            this.initMapPreview();
        },
        
        // Bind all event handlers
        bindEvents: function() {
            // Toggle forms
            $('#toggle-add-form').on('click', () => this.toggleAddForm());
            $('.cancel-form').on('click', () => this.hideAddForm());
            
            // Bulk operations
            $('#select-all-pins').on('change', (e) => this.selectAllPins(e.target.checked));
            $('.pin-checkbox').on('change', () => this.updateSelectedCount());
            $('#bulk-action').on('change', () => this.toggleBulkOptions());
            $('#apply-bulk-action').on('click', () => this.applyBulkAction());
            
            // Quick actions
            $('#import-pins-btn').on('click', () => this.showImportModal());
            $('#export-pins-btn').on('click', () => this.exportPins());
            $('#toggle-drag-mode').on('click', () => this.toggleDragMode());
            
            // Table features
            $('.sortable').on('click', (e) => this.sortTable(e));
            $('#filter-by-type').on('change', (e) => this.filterByType(e.target.value));
            $('#search-pins').on('input', (e) => this.searchPins(e.target.value));
            
            // Pin actions
            $(document).on('click', '.edit-pin-btn', (e) => this.editPin($(e.target).data('pin-id')));
            $(document).on('click', '.duplicate-pin-btn', (e) => this.duplicatePin($(e.target).data('pin-id')));
            $(document).on('click', '.delete-pin-btn', (e) => this.deletePin($(e.target).data('pin-id')));
            $(document).on('click', '.locate-pin', (e) => this.locatePin($(e.target).data('pin-id')));
            
            // Map preview controls
            $('#show-grid').on('change', (e) => this.toggleGrid(e.target.checked));
            $('#snap-to-grid').on('change', (e) => this.toggleSnapToGrid(e.target.checked));
            $('#show-coordinates').on('change', (e) => this.toggleCoordinates(e.target.checked));
            $('#center-map-view').on('click', () => this.centerMapView());
            $('#zoom-fit').on('click', () => this.fitMapToScreen());
            
            // Form validation
            this.setupFormValidation();
        },
        
        // Initialize interface elements
        initializeInterface: function() {
            this.updateSelectedCount();
            this.setupTooltips();
            this.initializeModals();
        },
        
        // Toggle add form visibility
        toggleAddForm: function() {
            const $form = $('#add-pin-form');
            if ($form.is(':visible')) {
                $form.slideUp();
                $('#toggle-add-form').text('Add New Pin');
            } else {
                $form.slideDown();
                $('#toggle-add-form').text('Cancel');
                $('#pin_title').focus();
            }
        },
        
        // Hide add form
        hideAddForm: function() {
            $('#add-pin-form').slideUp();
            $('#toggle-add-form').text('Add New Pin');
            this.resetForm();
        },
        
        // Reset form fields
        resetForm: function() {
            $('#add-pin-form')[0].reset();
            $('#pin_x, #pin_y').val('');
        },
        
        // Select all pins
        selectAllPins: function(checked) {
            $('.pin-checkbox').prop('checked', checked);
            this.updateSelectedCount();
        },
        
        // Update selected pins count
        updateSelectedCount: function() {
            const selectedCount = $('.pin-checkbox:checked').length;
            this.state.selectedPins = $('.pin-checkbox:checked').map(function() {
                return $(this).val();
            }).get();
            
            $('.selected-count').text(selectedCount + ' selected');
            $('#apply-bulk-action').prop('disabled', selectedCount === 0);
            
            // Update select all checkbox state
            const totalCheckboxes = $('.pin-checkbox').length;
            if (selectedCount === 0) {
                $('#select-all-pins').prop('indeterminate', false).prop('checked', false);
            } else if (selectedCount === totalCheckboxes) {
                $('#select-all-pins').prop('indeterminate', false).prop('checked', true);
            } else {
                $('#select-all-pins').prop('indeterminate', true);
            }
        },
        
        // Toggle bulk operation options
        toggleBulkOptions: function() {
            const action = $('#bulk-action').val();
            const $typeSelect = $('#new-type-select');
            
            if (action === 'change_type') {
                $typeSelect.show();
            } else {
                $typeSelect.hide();
            }
        },
        
        // Apply bulk action
        applyBulkAction: function() {
            const action = $('#bulk-action').val();
            const selectedIds = this.state.selectedPins;
            
            if (selectedIds.length === 0) {
                this.showNotice(nirupPinAdmin.strings.no_pins_selected, 'warning');
                return;
            }
            
            switch (action) {
                case 'delete':
                    this.bulkDeletePins(selectedIds);
                    break;
                case 'change_type':
                    this.bulkChangeType(selectedIds);
                    break;
                case 'export':
                    this.exportSelectedPins(selectedIds);
                    break;
            }
        },
        
        // Bulk delete pins
        bulkDeletePins: function(pinIds) {
            if (!confirm(nirupPinAdmin.strings.confirm_bulk_delete)) {
                return;
            }
            
            this.showLoading();
            
            $.ajax({
                url: nirupPinAdmin.ajax_url,
                type: 'POST',
                data: {
                    action: 'nirup_bulk_delete_pins',
                    pin_ids: pinIds,
                    nonce: nirupPinAdmin.nonce
                },
                success: (response) => {
                    this.hideLoading();
                    if (response.success) {
                        // Remove rows from table
                        pinIds.forEach(id => {
                            $(`.pin-row[data-pin-id="${id}"]`).fadeOut(() => {
                                $(this).remove();
                            });
                        });
                        
                        this.showNotice(`${pinIds.length} pins deleted successfully!`, 'success');
                        this.updateSelectedCount();
                        this.refreshMapPreview();
                    } else {
                        this.showNotice('Error deleting pins: ' + response.data, 'error');
                    }
                },
                error: () => {
                    this.hideLoading();
                    this.showNotice('Network error occurred', 'error');
                }
            });
        },
        
        // Bulk change pin type
        bulkChangeType: function(pinIds) {
            const newType = $('#new-type-select').val();
            
            this.showLoading();
            
            $.ajax({
                url: nirupPinAdmin.ajax_url,
                type: 'POST',
                data: {
                    action: 'nirup_bulk_update_type',
                    pin_ids: pinIds,
                    new_type: newType,
                    nonce: nirupPinAdmin.nonce
                },
                success: (response) => {
                    this.hideLoading();
                    if (response.success) {
                        // Update table rows
                        pinIds.forEach(id => {
                            const $row = $(`.pin-row[data-pin-id="${id}"]`);
                            $row.find('.type-badge')
                                .removeClass('default resort beach restaurant spa activity')
                                .addClass(newType)
                                .text(newType.charAt(0).toUpperCase() + newType.slice(1));
                        });
                        
                        this.showNotice(`${pinIds.length} pins updated successfully!`, 'success');
                        this.updateSelectedCount();
                        this.refreshMapPreview();
                    } else {
                        this.showNotice('Error updating pins: ' + response.data, 'error');
                    }
                },
                error: () => {
                    this.hideLoading();
                    this.showNotice('Network error occurred', 'error');
                }
            });
        },
        
        // Setup table sorting and filtering
        setupTableFeatures: function() {
            // Initialize sorting
            this.state.sortColumn = 'title';
            this.state.sortDirection = 'asc';
            this.updateSortIndicator();
        },
        
        // Sort table by column
        sortTable: function(e) {
            const $header = $(e.currentTarget);
            const column = $header.data('sort');
            
            if (this.state.sortColumn === column) {
                this.state.sortDirection = this.state.sortDirection === 'asc' ? 'desc' : 'asc';
            } else {
                this.state.sortColumn = column;
                this.state.sortDirection = 'asc';
            }
            
            this.performSort();
            this.updateSortIndicator();
        },
        
        // Perform the actual sorting
        performSort: function() {
            const $tbody = $('.pins-table tbody');
            const $rows = $tbody.find('tr').detach();
            
            $rows.sort((a, b) => {
                let aVal, bVal;
                
                switch (this.state.sortColumn) {
                    case 'title':
                        aVal = $(a).find('.pin-title strong').text().toLowerCase();
                        bVal = $(b).find('.pin-title strong').text().toLowerCase();
                        break;
                    case 'position':
                        aVal = parseFloat($(a).find('.position-display').text().split(',')[0]);
                        bVal = parseFloat($(b).find('.position-display').text().split(',')[0]);
                        break;
                    case 'type':
                        aVal = $(a).find('.type-badge').text().toLowerCase();
                        bVal = $(b).find('.type-badge').text().toLowerCase();
                        break;
                    case 'created':
                        aVal = new Date($(a).find('.pin-created').text());
                        bVal = new Date($(b).find('.pin-created').text());
                        break;
                    default:
                        return 0;
                }
                
                if (aVal < bVal) return this.state.sortDirection === 'asc' ? -1 : 1;
                if (aVal > bVal) return this.state.sortDirection === 'asc' ? 1 : -1;
                return 0;
            });
            
            $tbody.append($rows);
        },
        
        // Update sort indicator
        updateSortIndicator: function() {
            $('.sortable').removeClass('sorted-asc sorted-desc');
            $(`.sortable[data-sort="${this.state.sortColumn}"]`)
                .addClass(`sorted-${this.state.sortDirection}`);
        },
        
        // Filter pins by type
        filterByType: function(type) {
            this.state.filterType = type;
            this.applyFilters();
        },
        
        // Search pins
        searchPins: function(term) {
            this.state.searchTerm = term.toLowerCase();
            this.applyFilters();
        },
        
        // Apply all filters
        applyFilters: function() {
            $('.pin-row').each((index, row) => {
                const $row = $(row);
                let show = true;
                
                // Type filter
                if (this.state.filterType && $row.data('type') !== this.state.filterType) {
                    show = false;
                }
                
                // Search filter
                if (this.state.searchTerm) {
                    const title = $row.find('.pin-title strong').text().toLowerCase();
                    const description = $row.find('.pin-description').text().toLowerCase();
                    
                    if (!title.includes(this.state.searchTerm) && !description.includes(this.state.searchTerm)) {
                        show = false;
                    }
                }
                
                $row.toggleClass('filtered-out', !show);
            });
        },
        
        // Initialize map preview features
        initMapPreview: function() {
            this.setupPinHover();
            this.initDragAndDrop();
        },
        
        // Setup pin hover effects
        setupPinHover: function() {
            $('.draggable-preview-pin').hover(
                function() {
                    $(this).addClass('highlighted');
                },
                function() {
                    $(this).removeClass('highlighted');
                }
            );
        },
        
        // Initialize drag and drop for map preview
        initDragAndDrop: function() {
            if (!window.DragDropPinManager) return;
            
            $('.draggable-preview-pin').each(function() {
                $(this).draggable({
                    containment: '.map-preview-container',
                    drag: (event, ui) => {
                        PinAdmin.updatePinCoordinates(ui.helper, ui.position);
                    },
                    stop: (event, ui) => {
                        PinAdmin.savePinPosition(ui.helper, ui.position);
                    }
                });
            });
        },
        
        // Update pin coordinates during drag
        updatePinCoordinates: function($pin, position) {
            const $container = $('.map-preview-container');
            const containerWidth = $container.width();
            const containerHeight = $container.height();
            
            const x = (position.left / containerWidth) * 100;
            const y = (position.top / containerHeight) * 100;
            
            if (this.config.showCoordinates) {
                this.showCoordinates($pin, x, y);
            }
            
            if (this.config.snapToGrid) {
                const snappedX = Math.round(x / this.config.gridSize) * this.config.gridSize;
                const snappedY = Math.round(y / this.config.gridSize) * this.config.gridSize;
                
                $pin.css({
                    left: snappedX + '%',
                    top: snappedY + '%'
                });
            }
        },
        
        // Save pin position after drag
        savePinPosition: function($pin, position) {
            const pinId = $pin.data('pin-id');
            const $container = $('.map-preview-container');
            const containerWidth = $container.width();
            const containerHeight = $container.height();
            
            const x = Math.max(0, Math.min(100, (position.left / containerWidth) * 100));
            const y = Math.max(0, Math.min(100, (position.top / containerHeight) * 100));
            
            $.ajax({
                url: nirupPinAdmin.ajax_url,
                type: 'POST',
                data: {
                    action: 'nirup_update_pin_position',
                    pin_id: pinId,
                    x: x,
                    y: y,
                    nonce: nirupPinAdmin.nonce
                },
                success: (response) => {
                    if (response.success) {
                        this.showNotice(nirupPinAdmin.strings.position_updated, 'success');
                        // Update table display
                        $(`.pin-row[data-pin-id="${pinId}"] .position-display`)
                            .text(`${x.toFixed(1)}%, ${y.toFixed(1)}%`);
                    } else {
                        this.showNotice(nirupPinAdmin.strings.error_updating, 'error');
                    }
                },
                error: () => {
                    this.showNotice(nirupPinAdmin.strings.error_updating, 'error');
                }
            });
        },
        
        // Toggle drag mode
        toggleDragMode: function() {
            this.config.dragEnabled = !this.config.dragEnabled;
            const $button = $('#toggle-drag-mode');
            
            if (this.config.dragEnabled) {
                $button.addClass('button-primary').text('Exit Drag Mode');
                $('.draggable-preview-pin').draggable('enable');
                this.showNotice('Drag mode enabled. Drag pins to reposition them.', 'success');
            } else {
                $button.removeClass('button-primary').text('Drag Mode');
                $('.draggable-preview-pin').draggable('disable');
                this.showNotice('Drag mode disabled.', 'success');
            }
        },
        
        // Toggle grid overlay
        toggleGrid: function(show) {
            $('.map-grid-overlay').toggle(show);
        },
        
        // Toggle snap to grid
        toggleSnapToGrid: function(enabled) {
            this.config.snapToGrid = enabled;
        },
        
        // Toggle coordinate display
        toggleCoordinates: function(show) {
            this.config.showCoordinates = show;
        },
        
        // Show coordinates tooltip
        showCoordinates: function($pin, x, y) {
            // Implementation for coordinate display
        },
        
        // Locate pin in map preview
        locatePin: function(pinId) {
            const $pin = $(`.draggable-preview-pin[data-pin-id="${pinId}"]`);
            if ($pin.length) {
                // Highlight pin
                $pin.addClass('highlighted');
                setTimeout(() => $pin.removeClass('highlighted'), 2000);
                
                // Scroll map into view
                const $container = $('.map-preview-container');
                $container[0].scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        },
        
        // Center map view
        centerMapView: function() {
            const $container = $('.map-preview-container');
            $container.animate({ scrollTop: 0, scrollLeft: 0 }, 300);
        },
        
        // Fit map to screen
        fitMapToScreen: function() {
            const $image = $('.map-preview-image');
            $image.css({
                maxWidth: '100%',
                height: 'auto'
            });
        },
        
        // Refresh map preview
        refreshMapPreview: function() {
            // Reload map preview if needed
            location.reload();
        },
        
        // Setup form validation
        setupFormValidation: function() {
            $('#pin_title').on('input', function() {
                const $submit = $('#submit');
                if ($(this).val().trim()) {
                    $submit.prop('disabled', false);
                } else {
                    $submit.prop('disabled', true);
                }
            });
            
            $('#pin_x, #pin_y').on('input', function() {
                const value = parseFloat($(this).val());
                if (value < 0 || value > 100) {
                    $(this).addClass('error');
                } else {
                    $(this).removeClass('error');
                }
            });
        },
        
        // Setup tooltips
        setupTooltips: function() {
            // Add tooltips to buttons and controls
            $('[title]').tooltip();
        },
        
        // Initialize modals
        initializeModals: function() {
            // Setup modal functionality
        },
        
        // Show loading overlay
        showLoading: function() {
            if (!$('.loading-overlay').length) {
                $('body').append(`
                    <div class="loading-overlay">
                        <div class="loading-spinner"></div>
                    </div>
                `);
            }
        },
        
        // Hide loading overlay
        hideLoading: function() {
            $('.loading-overlay').remove();
        },
        
        // Show admin notice
        showNotice: function(message, type = 'success') {
            const $notice = $(`
                <div class="admin-notice ${type}">
                    ${message}
                </div>
            `);
            
            $('body').append($notice);
            
            // Animate in
            setTimeout(() => $notice.addClass('show'), 100);
            
            // Auto hide after 4 seconds
            setTimeout(() => {
                $notice.removeClass('show');
                setTimeout(() => $notice.remove(), 300);
            }, 4000);
        },
        
        // Export pins
        exportPins: function() {
            window.location.href = `${nirupPinAdmin.ajax_url}?action=nirup_export_pins&nonce=${nirupPinAdmin.nonce}`;
        },
        
        // Export selected pins
        exportSelectedPins: function(pinIds) {
            const form = $('<form>', {
                method: 'POST',
                action: nirupPinAdmin.ajax_url
            });
            
            form.append($('<input>', {
                type: 'hidden',
                name: 'action',
                value: 'nirup_export_selected_pins'
            }));
            
            form.append($('<input>', {
                type: 'hidden',
                name: 'pin_ids',
                value: JSON.stringify(pinIds)
            }));
            
            form.append($('<input>', {
                type: 'hidden',
                name: 'nonce',
                value: nirupPinAdmin.nonce
            }));
            
            $('body').append(form);
            form.submit();
            form.remove();
        },
        
        // Show import modal
        showImportModal: function() {
            // Implementation for import modal
            this.showNotice('Import functionality coming soon!', 'warning');
        },
        
        // Edit pin
        editPin: function(pinId) {
            // Load pin data and show edit modal
            this.showNotice('Edit modal coming soon!', 'warning');
        },
        
        // Duplicate pin
        duplicatePin: function(pinId) {
            $.ajax({
                url: nirupPinAdmin.ajax_url,
                type: 'POST',
                data: {
                    action: 'nirup_duplicate_pin',
                    pin_id: pinId,
                    nonce: nirupPinAdmin.nonce
                },
                success: (response) => {
                    if (response.success) {
                        this.showNotice('Pin duplicated successfully!', 'success');
                        location.reload();
                    } else {
                        this.showNotice('Error duplicating pin: ' + response.data, 'error');
                    }
                }
            });
        },
        
        // Delete pin
        deletePin: function(pinId) {
            if (!confirm(nirupPinAdmin.strings.confirm_delete)) {
                return;
            }
            
            $.ajax({
                url: nirupPinAdmin.ajax_url,
                type: 'POST',
                data: {
                    action: 'nirup_delete_pin',
                    pin_id: pinId,
                    nonce: nirupPinAdmin.nonce
                },
                success: (response) => {
                    if (response.success) {
                        $(`.pin-row[data-pin-id="${pinId}"]`).fadeOut(() => {
                            $(this).remove();
                        });
                        this.showNotice('Pin deleted successfully!', 'success');
                        this.refreshMapPreview();
                    } else {
                        this.showNotice('Error deleting pin: ' + response.data, 'error');
                    }
                }
            });
        }
    };
    
    // Initialize when document is ready
    $(document).ready(function() {
        if ($('.nirup-pins-admin-enhanced').length) {
            PinAdmin.init();
        }
    });
    
    // Make PinAdmin available globally
    window.NirupPinAdmin = PinAdmin;
    
})(jQuery);