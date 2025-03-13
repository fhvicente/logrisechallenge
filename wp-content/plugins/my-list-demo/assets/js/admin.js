(function($) {
    'use strict';

    $(document).ready(function() {
        // Make the list sortable
        $('#mylistdemo-items').sortable({
            placeholder: 'mylistdemo-item-placeholder',
            update: function() {
                updateNoItemsMessage();
            }
        });

        // Add a new item
        $('#mylistdemo-add-item').on('click', function() {
            addNewItem();
        });

        // Allow pressing Enter to add item
        $('#mylistdemo-new-item').on('keypress', function(e) {
            if (e.which === 13) { // Tecla Enter
                e.preventDefault();
                addNewItem();
            }
        });

        // Delete an item
        $(document).on('click', '.mylistdemo-item-delete', function() {
            $(this).parent().fadeOut(300, function() {
                $(this).remove();
                updateNoItemsMessage();
            });
        });

        // Save all items
        $('#mylistdemo-save-items').on('click', function() {
            saveItems();
        });

        // Reset list
        $('#mylistdemo-reset-items').on('click', function() {
            if (confirm('Are you sure you want to reset the list? This will remove all items.')) {
                resetItems();
            }
        });
            
        // Helper function to add a new item
        function addNewItem() {
            const newItemInput = $('#mylistdemo-new-item');
            const newItemText = newItemInput.val().trim();

            if (newItemText === '') {
                showMessage('Please enter some text for the item.', 'error');
                return;
            }

            // Create new item element
            const newItem = $('<li class="mylistdemo-item"></li>');
            newItem.append('<span class="mylistdemo-item-text">' + escapeHtml(newItemText) + '</span>');
            newItem.append('<span class="mylistdemo-item-delete dashicons dashicons-no-alt"></span>');

            $('.mylistdemo-no-items').remove();
            $('#mylistdemo-items').append(newItem);
            
            // Clear the input
            newItemInput.val('').focus();
            
            showMessage('Item added. Don\'t forget to save your changes!', 'success');
        }

        // Helper funciton to scape HTML
        function escapeHtml(text) {
            return text
                .replace(/&/g, "&amp;")
                .replace(/</g, "&lt;")
                .replace(/>/g, "&gt;")
                .replace(/"/g, "&quot;")
                .replace(/'/g, "&#039;");
        }
    });
    
})(jQuery);