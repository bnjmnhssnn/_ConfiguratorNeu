(function(){
    
    $(document).on('submit', '.configurator-step-form', function(e) {
        return true;
        e.preventDefault();
        return submitHandler(e);
    });

    $(document).on('click', '.info-btn', function(e) {
        toggleHiddenInfo(e);
    });

    $(document).on('change', 'input[name="main_product"]', function(e) {
        toggleOptional(e);
    });

    var submitHandler = function(e) {
        return true;
    };

    var toggleHiddenInfo = function(e) {
        var target_id = $(e.target).data('target');
        $('#hidden-info-' + target_id ).toggle();
    };

    var toggleOptional = function(e) {
        
        var toggle = $(e.target).closest('#hardware-toggle,#cloud-toggle');
        var inputs = toggle.find('input[name="main_product"]');
        inputs.each(
            function() {
                if($(this).is(':checked')) {
                    if(toggle.attr('id') == 'hardware-toggle') {
                        $('#hidden-optional-wrapper').slideDown(200);
                    } else if (toggle.attr('id') == 'cloud-toggle') {
                        $('#hidden-optional-wrapper').slideUp(200);
                    }
                }
            }
        );
    }



})();


