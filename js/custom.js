$(document).ready(function() {
    bootstrap();

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

    /**
     * Live reloading instructions
     */
    $('#left-sidebar-nav a[data-tracked=true]').each(function() {
        var link = $(this).attr('href');

        // First recount...
        recount(link, true);

        // Recount logs every X seconds
        setInterval(function() {
            recount(link, true);
        }, 5000);
    });
});

/**
 * Recount logs and trigger warnings when something happens
 *
 * @param {string} link The url of the log's page, for refreshing logs
 * @param {bool} push Show push messages or not
 */
function recount(link, push) {
    var baseUrl = $('.baseUrl').html();
    var $link = $('#left-sidebar-nav a[href="' + link + '"]');
    var $badge = $link.find('.badge');
    var file = $link.attr('data-file');
    var howMany = $link.attr('data-howmany');
    var currentFile = $('.log-container h4').attr('data-file');

    $.ajax({
        url: baseUrl + 'ajax.php?countlog&file=' + file
    }).done(function(howManyNew) {
        if (howManyNew !== howMany) {
            var difference = Number(howManyNew) - Number(howMany);
            if (push === true) {
                Push.create('LogHappens!', {
                    body: file + ': ' + difference + ' new logs!',
                    icon: baseUrl + '/img/logo.png',
                    timeout: 4000,
                    onClick: function () {
                        window.focus();
                        this.close();
                    }
                });
            }

            if (currentFile === file) {
                reloadContent(file);
            }
            $badge.addClass('badge-highlight');

            $badge.html(howManyNew);
            $link.attr('data-howmany', howManyNew);
        } else {
            $badge.removeClass('badge-highlight');
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
