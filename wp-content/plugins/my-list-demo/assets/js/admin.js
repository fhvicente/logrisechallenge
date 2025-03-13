(function($) {
    'use-strict';

    $(document).ready(function() {
        // Make the list sortable
        $('#mylistdemo-items').sortable({
            placeholder: 'mylistdemo-item-placeholder',
            update: function() {
                updateNoItemsMessage();
            }
        });
    });
    
})(jQuery);