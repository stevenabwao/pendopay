$(function(){

    /*
    if ($('.toggle-password').length) {

        $(".toggle-password").click(function() {

            $(this).toggleClass("fa-eye fa-eye-slash");
            var input = $($(this).attr("toggle"));
            console.log("input... == " + input.val());
            if (input.attr("type") == "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }

        });

    }*/

    if ($('#togglePassword').length) {

        // fa-eye fa-eye-slash
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');

        togglePassword.addEventListener('click', function (e) {
            // toggle the type attribute
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            console.log("type == " + type);
            password.setAttribute('type', type);
            // toggle the icon
            this.classList.toggle('fa-eye-slash');
        });

    }

});
