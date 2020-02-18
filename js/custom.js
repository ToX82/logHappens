$(document).ready(function() {
    bootstrap();

    // Recount logs every X seconds
    setInterval(function() {
        recountAll();
    }, 5000);

    /**
     * TruncateLink method
     *
     */
    $('body').on('click', '.truncateLink', function(e) {
        e.preventDefault();
        var link = $(this).attr('href');
        var $modal = $("#js-confirm");
        $modal.modal('show');

        $modal.find('.yes-btn').click(function() {
            window.location.href = link;
        });
    });
});

/**
 * Recount logs and trigger warnings when something happens
 *
 */
function recountAll() {
    var baseUrl = $('.baseUrl').html();
    var $sidebar = $('#left-sidebar-nav');
    var currentPage = $('.log-container h4').attr('data-file');
    var notificationText = '';

    $.ajax({
        url: baseUrl + 'ajax.php?countall',
        dataType: 'json'
    }).done(function(data) {
        $.each(data, function(file, countNew) {
            var $navLink = $sidebar.find('a[data-file="' + file + '"]');
            var $badge = $navLink.find('.badge');
            var countOld = $badge.html().trim();

            countNew = (countNew != '') ? parseInt(countNew) : 0;
            countOld = (countOld != '') ? parseInt(countOld) : 0;

            if (countNew !== countOld) {
                var difference = countNew - countOld;

                if (currentPage === file) {
                    reloadContent(file);
                }

                $badge.html(countNew);
                $badge.addClass('badge-highlight');
                notificationText = notificationText + file + ': ' + difference + ' new logs!     ';
            } else {
                $badge.removeClass('badge-highlight');
            }
        });

        if (notificationText !== '') {
            pushNotification(notificationText, baseUrl);
        }
    });
}

/**
 *
 * @param string text The notification's body
 * @param string baseUrl Application's base url
 */
function pushNotification(text, baseUrl) {
    Push.create('LogHappened!', {
        body: text,
        icon: baseUrl + '/img/logo.png',
        timeout: 4000,
        onClick: function () {
            window.focus();
            this.close();
        }
    });
}

/**
 * Refresh the log's list
 *
 * @param {string} file The log's name
 */
function reloadContent(file) {
    var baseUrl = $('.baseUrl').html();
    $('.log-container').load(baseUrl + 'ajax.php?viewlog&file=' + file, function() {
        bootstrap();
    });
}

function bootstrap() {
    $('.datatable').DataTable({
        ordering: false,
        order: [[ 0, "desc" ]],
        stateSave: true
    });
}
