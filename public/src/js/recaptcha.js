$(function () {
    $('#sign-up').submit(function (event) {
        var verified = grecaptcha.getResponse();
        if(verified.length === 0){
            event.preventDefault();
            $(this).onclick(alert('Are you sure you\'re not a robot?'));
        }
    })
});