
(function ($) {

    function createCORSRequest(method, url) {
        var xhr = new XMLHttpRequest();
        if ("withCredentials" in xhr) {
            xhr.open(method, url, true);
        } else if (typeof XDomainRequest != "undefined") {
            xhr = new XDomainRequest();
            xhr.open(method, url);
        } else {
            xhr = null;
        }
        return xhr;
    }

    $(document).ready(function () {
        let setting = $('script[data-setting]').data('setting');
        if (setting == null || typeof setting == 'undefined') {
            setting = 'default';
        }
        let xhr = createCORSRequest('GET', 'https://themekit.dev/tools/sidebar/sidebar.php?setting=' + setting);
        if (!xhr) {
            console.log('Themekit Sidebar: CORS not supported.');
            return;
        }
        xhr.onload = function () {
            $('body').append(xhr.responseText);
            let head = document.getElementsByTagName('head')[0];
            let link = document.createElement('link');
            link.id = 'themekit-sidebar';
            link.rel = 'stylesheet';
            link.type = 'text/css';
            link.href = 'https://themekit.dev/tools/sidebar/sidebar.css';
            link.media = 'all';
            head.appendChild(link);
            setTimeout(function () {
                $('.themekit-sidebar-cnt').removeAttr('style').addClass('themekit-init');
            }, 300);
        };
        xhr.onerror = function () {
            console.log('Themekit Sidebar: CORS error.');
        };
        xhr.send();

        $('body').on('click', '.themekit-colors ul li', function () {
            let selector = ($(this).closest('.themekit-colors').hasClass('themekit-colors-2') ? '-2' : '');
            $('#themekit-css' + selector).html($('#themekit-colors' + selector).val().replace(/themekit-color/g, $(this).data('color')));
        });

        $('body').on('click', '.themekit-colors > div > i', function () {
            let color = $(this).parent().find('input').val();
            if (color != '') {
                let selector = ($(this).closest('.themekit-colors').hasClass('themekit-colors-2') ? '-2' : '');
                $('#themekit-css' + selector).html($('#themekit-colors' + selector).val().replace(/themekit-color/g, color));
            }
        });


        $("body").on("click", ".themekit-button", function () {
            $(this).parent().toggleClass('themekit-active');
        });

    });
}(jQuery)); 
