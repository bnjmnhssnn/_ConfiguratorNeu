(function(){
    
    $(document).on('submit', '.configurator-step-form', function(e) {
        return true;
        e.preventDefault();
        return submitHandler(e);
    });

    $(document).on('click', '.info-btn', function(e) {
        toggleHiddenInfo(e);
    });

    var submitHandler = function(e) {
        return true;
    };

    var toggleHiddenInfo = function(e) {
        var target_id = $(e.target).data('target');
        $('#hidden-info-' + target_id ).toggle();
    };



})();


