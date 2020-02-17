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

    $.ajax({
        url: baseUrl + 'ajax.php?countall',
        dataType: 'json'
    }).done(function(data) {
        $.each(data, function(key, countNew) {
            var $navLink = $sidebar.find('a[data-file="' + key + '"]');
            var countOld = parseInt($navLink.find('.badge').html().trim());

            if (countNew !== countOld) {
                var difference = Number(countNew) - Number(countOld);
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

                $badge.html(countNew);
            } else {
                $badge.removeClass('badge-highlight');
            }
        });
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
