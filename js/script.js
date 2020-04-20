$(function(){

    let contactForm = $('#contact-form');

    contactForm.submit(function (e) {
        e.preventDefault();
        $('.error-message').empty();
        let postadata = contactForm.serialize();

        $.ajax({
            type: 'POST',
            url: 'php/contact.php',
            data: postadata,
            dataType: 'json',
            success: function (response) {
                if (response.isSuccess){
                    contactForm.append("<p class=\"success-message\">Votre message a été envoyé avec succèss. Merci de m'avoir contacté.</p>");
                    contactForm[0].reset();
                }else {
                    $('#firstname + .error-message').html(response.firstnameError);
                    $('#lastname + .error-message').html(response.lastnameError);
                    $('#email + .error-message').html(response.emailError);
                    $('#telephone + .error-message').html(response.telephoneError);
                    $('#message + .error-message').html(response.messageError);
                }
            }
        });

    });

    $(".navbar a, #chevron-up").on("click", function(event){
    
        event.preventDefault();
        var hash = this.hash;
        
        $('body,html').animate({scrollTop: $(hash).offset().top} , 900 , function(){window.location.hash = hash;})
        
    });

    // Mobile Links Collapse on Click
    $('.navbar-nav>li>a').on('click', function(){
        $('.navbar-collapse').collapse('hide');
    });

});