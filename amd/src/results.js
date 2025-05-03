define(['jquery'], function($) {

    return {
        init: function() {

            $('#send_responses').click(function() {
                $('.question').each(function() {
                    const question = $(this);
                    const correct = question.data('correct');

                    const selected = question.find('input[type=radio]:checked').val();

                    const correct_div = question.find('.correct');
                    const wrong_div = question.find('.wrong');

                    if (!selected || selected !== correct) {
                        correct_div.addClass('d-none');
                        wrong_div.removeClass('d-none');
                    } else {
                        wrong_div.addClass('d-none');
                        correct_div.removeClass('d-none');
                    }

                });
            });
        }
    };

});
