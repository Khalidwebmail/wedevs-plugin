;(function($){
    $("#contact-form").validate({
        rules: {
            name: "required",
            email: "required",
            message: "required",
        },

        submitHandler: function(form) {
            $.ajax({
                url: contactForm.url,
                type: form.method,
                data: new FormData(form),
                dataType: 'JSON',
                contentType: false,
                processData: false,
                cache: false,
                beforeSend: function() {
                    $('.btn-submit').attr('disabled', true).val('Loadding...');
                },
                success: function(response) {
                    if (response.success) {
                        form.reset();
                        $(".message").text(response.data.message).css({'color':'green', 'display':'block'});
                    }else{
                        var errors = response.data.errors;
                        var errorFields = Object.keys(errors);

                        errorFields.forEach(function(errorField, key){
                            var inputField = $(`[name="${errorField}"]`);
                            var errorMessage = errors[errorField];

                            if (key === 0) {
                                inputField.focus();
                            }

                            // Show error message
                             if (inputField.next('.error-block').length === 0){
                                inputField.after(`<small class="error-block">${errorMessage} </small>`);
                            }

                            // Remove error message
                            inputField.on('keydown, change', function() {
                                inputField.next('.error-block').remove();
                            });
                        }); 
                    }
                },
                error: function() {
                  $(".message").text(contactForm.error).css({'color':'red', 'display':'block'});
                },
                complete: function(){
                    $('.btn-submit').attr('disabled', false).val('Send Message');
                }
            });
        }

    });


})(jQuery);