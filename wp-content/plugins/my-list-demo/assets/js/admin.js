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

        // Helper function to save items
        function saveItems() {
            const items = [];
            
            // Get all items
            $('#mylistdemo-items .mylistdemo-item-text').each(function() {
                items.push($(this).text());
            });

            // Send AJAX request
            $.ajax({
                url: myListDemoAdmin.ajaxUrl,
                type: 'POST',
                data: {
                    action: 'mylistdemo_save_items',
                    nonce: myListDemoAdmin.nonce,
                    items: items
                },
                beforeSend: function() {
                    showMessage('Saving...', 'info');
                },
                success: function(response) {
                    if (response.success) {
                        showMessage(response.data.message, 'success');
                    } else {
                        showMessage(response.data.message, 'error');
                    }
                },
                error: function() {
                    showMessage('An error occurred while saving.', 'error');
                }
            });
        }

        // Helper function to show messages
        function showMessage(message, type) {
            const messageElement = $('#mylistdemo-message');
            messageElement.html(message);

            // Remove all classes and add the appropriate one
            messageElement.removeClass('success error info');
            messageElement.addClass(type);

            // Show the message
            messageElement.fadeIn();

            // Hide the message after 3 seconds
            setTimeout(function() {
                messageElement.fadeOut();                
            }, 3000);
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