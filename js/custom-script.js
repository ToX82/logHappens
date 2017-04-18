$(document).ready(function() {
    /**
     * Side nav
     */
    $('.button-collapse').sideNav();

    /**
     * Select box
     */
    $('select').material_select();
    $('.page-length').on('change', function() {
        var length = $(this).val();
        var url = 'ajax.php?page=set_pagelength&length=' + length;
        $.ajax({
            method: 'GET',
            url: url
        })
        .done(function() {
            window.location.reload();
        });
    });

    /**
     * Live reloading instructions
     */
    var currentUrl = '?' + window.location.search.substring(1);
    $('.side-nav a[data-tofollow=true]').each(function() {
        var $link = $(this);
        var link = $link.attr('href');
        var action = link.replace('log_reader', 'log_counter');

        if (currentUrl === link) {
            var linkName = $link.attr('data-name');
            var filePath = $link.attr('data-fileurl');
            $('.logs-list h5').html(linkName);
            $('.truncateLink').attr('href', $('.truncateLink').attr('href') + filePath);
            $('.viewLink').attr('href', 'file:///' + filePath);
        }

        // Recount logs every X seconds
        setInterval(function() {
            recount(link, true);
        }, 5000);
    });

    /**
     * Recount logs and trigger warnings when something happens
     *
     * @param {string} link The url of the log's page, for refreshing logs
     * @param {bool} push Show push messages or not
     */
    function recount(link, push) {
        var $link = $('.side-nav a[href="' + link + '"]');
        var $badge = $link.find('.badge .conter');
        var howMany = $link.attr('data-howmany');
        var action = link.replace('log_reader', 'log_counter');

        $.ajax({
            url: 'ajax.php' + action
        }).done(function(howManyNew) {
            if (howManyNew !== howMany) {
                var difference = Number(howManyNew) - Number(howMany);
                console.log(link);
                if (push === true) {

                    Push.create('LogHappens!', {
                        body: $link.attr('data-name') + ': ' + difference + ' new logs!',
                        icon: {
                            x16: 'images/logo.png',
                            x32: 'images/logo.png'
                        },
                        link: $link.attr('href'),
                        timeout: 5000
                    });

                    if (currentUrl === link) {
                        reloadContent(link);
                    }
                    $badge.addClass('new');
                }

                $badge.html(difference);
                $link.attr('data-howmany', howManyNew);
            } else {
                howMany = $link.attr('data-howmany');
                $badge.html(howMany);
                $badge.removeClass('new');
            }
        });
    }

    /**
     * Refresh the log's list
     *
     * @param {string} link The url of the log's page, for refreshing logs
     */
    function reloadContent(link) {
        var $link = $('.side-nav a[href="' + link + '"]');
        var colorDefault = $('body').attr('data-color-default');
        var colorNotice = $('body').attr('data-color-notice');

        $('.log-container').load('ajax.php' + link);
        $('.color-themed').addClass(colorNotice).removeClass(colorDefault);

        setTimeout(function() {
            $('.color-themed').addClass(colorDefault).removeClass(colorNotice);
        }, 3000);
    }

    /**
    * TruncateLink method
    *
    */
    $('.truncateLink').on('click', function(e) {
        e.preventDefault();
        var confirm = window.confirm('Are you sure you want to truncate this log file?');
        if (confirm === true) {
            window.location.href = $(this).attr('href');
        }
    });

    /**
    * ViewLink method
    *
    */
    $('.viewLink').on('click', function(e) {
        e.preventDefault();
        copyToClipboard($(this).attr('href'));
        Materialize.toast('This log\'s path has been copied to your clipboard. Please paste it into a new tab to see the log file.', 5000, 'indigo darken-3');
    });

    function copyToClipboard(text) {
        var $temp = $('<input>');
        $('body').append($temp);
        $temp.val(text).select();
        document.execCommand('copy');
        $temp.remove();
    }
});
