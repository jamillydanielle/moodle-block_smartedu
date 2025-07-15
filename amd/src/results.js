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

                    // Clean feedbacks
                    const feedbackA_div = question.find('.feedback-A');
                    const feedbackB_div = question.find('.feedback-B');
                    const feedbackC_div = question.find('.feedback-C');
                    const feedbackD_div = question.find('.feedback-D');
                    feedbackA_div.addClass('d-none');
                    feedbackB_div.addClass('d-none');
                    feedbackC_div.addClass('d-none');
                    feedbackD_div.addClass('d-none');

                    let feedback_div;
                    if (!selected || selected === correct) {
                        feedback_div =  question.find('.feedback-' + correct);
                    } else {
                        feedback_div =  question.find('.feedback-' + selected);
                    }
                    feedback_div.removeClass('d-none');
                });
            });
        }
    };

});
