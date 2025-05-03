define(['jquery'], function($) {

    return {
        init: function() {

            $('#send_responses').click(function() {
                $('.question').each(function() {
                    const question = $(this);
                    const correct = question.data('correct');

                    const selected = question.find('input[type=radio]:checked').val();

                    const feedback = question.find('.feedback');

                    if (!selected) {
                        feedback.text('Por favor, selecione uma resposta.');
                        feedback.addClass('text-primary card-footer');
                    } else if (selected === correct) {
                        feedback.text('Resposta correta!');
                        feedback.addClass('text-success card-footer');
                    } else {
                        feedback.text('Resposta incorreta.');
                        feedback.addClass('text-danger card-footer');
                    }

                    // eslint-disable-next-line no-console
                    console.log('questão');
                });
            });
        }
    };

});
