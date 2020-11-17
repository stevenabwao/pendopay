<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
{{-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
crossorigin="anonymous"></script> --}}

<script src="{{ asset('js/jquery.min.js') }}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
crossorigin="anonymous"></script>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
crossorigin="anonymous"></script>


<script src="{{ asset('js/main.js') }}"></script>

<script src="{{ asset('js/parallax.min.js') }}"></script>
<script src="{{ asset('js/glide.min.js') }}"></script>
<script src="{{ asset('js/magnific-popup.min.js') }}"></script>
<script src="{{ asset('js/tab-accordion.js') }}"></script>
<script src="{{ asset('js/imagesloaded.min.js') }}"></script>
<script src="{{ asset('js/progress.js') }}" async></script>
<script src="{{ asset('js/contact-form/contact-form.js') }}" async></script>
<script src="{{ asset('js/sticky-kit.min.js') }}" async></script>

<script src="{{ asset('myjs/moment.min.js') }}"></script>

<script src="{{ asset('myjs/jquery.toast.min.js') }}"></script>
<script src="{{ asset('myjs/toast-data.js') }}"></script>
<script src="{{ asset('myjs/jquery.matchHeight.js') }}" type="text/javascript"></script>

<script>

    $(function(){

        'use strict'

        if ($(".equalheight").length) {
            $('.equalheight').matchHeight();
        }

        if ($(".digitsOnly").length) {
            /*numbers only text fields*/
            $(".digitsOnly").keydown(function (e) {
                // Allow: backspace, delete, tab, escape, enter and .
                if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
                // Allow: Ctrl+A
                (e.keyCode == 65 && e.ctrlKey === true) ||
                // Allow: home, end, left, right
                (e.keyCode >= 35 && e.keyCode <= 39)) {
                    // let it happen, don't do anything
                    return;
                }
                // Ensure that it is a number and stop the keypress
                if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                e.preventDefault();
                }
            });
        }

    });

    function load_overlay(overlay_container)
    {
        if (overlay_container)
        {
        $(overlay_container).LoadingOverlay("show", {
            image       : "/images/loader.gif"
        });
        } else {
        $.LoadingOverlay("show", {
            image       : "/images/loader.gif"
        });
        }
    }

    function hide_overlay(overlay_container)
    {
        if (overlay_container)
        {
            $(overlay_container).LoadingOverlay("hide");
        } else {
            $.LoadingOverlay("hide");
        }
    }



  </script>
