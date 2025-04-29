define(['jquery'], function($) {

    return {
        init: function() {

            $('#send_responses').click(function() {
                $('.question').each(function() {
                    // eslint-disable-next-line no-console
                    console.log('entrou');
                });
            });
        }
    };

});
