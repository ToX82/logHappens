var datatable;

$(document).ready(function() {
    bootstrap();
    var refresh = $('.logs-list').attr('data-refresh');

    // Theme switcher
    $('.settings-switcher').on('change', function() {
        var baseUrl = $('.baseUrl').html();
        var parameter = $(this).attr('id');
        var selected = $(this).val();
        window.location.href = baseUrl + 'writesettings/' + parameter + '/' + selected;
    });

    // Recount logs every X seconds
    setInterval(function() {
        recountAll();
    }, refresh * 1000);

    /**
     * TruncateLink method
     *
     * @returns {void}
     */
    $('body').on('click', '.truncateLink', function(e) {
        e.preventDefault();
        var link = $(this).attr('href');
        var $modal = $('#js-confirm');
        $modal.modal('show');

        $modal.find('.yes-btn').click(function() {
            window.location.href = link;
        });
    });

    // When the truncate modal opens, automatically put the focus on the yes button
    $('body').on('shown.bs.modal', '#js-confirm', function () {
        $('.yes-btn', this).focus();
    });
});

/**
 * Recount logs and trigger warnings when something happens
 *
 * @returns {void}
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

                if (currentPage === file && datatable.page.info().page === 0) {
                    reloadContent();
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
 * Creates a push notification for the browser
 *
 * @param {string} text The notification's body
 * @param {string} baseUrl Application's base url
 * @returns {void}
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
 * @returns {void}
 */
function reloadContent() {
    var table = $('.datatable').DataTable();
    table.ajax.reload();
}

/**
 * Page bootstrap (here we set datatables settings and maybe more)
 *
 * @returns {void}
 */
function bootstrap() {
    var baseUrl = $('.baseUrl').html();
    var dataTablesLang = $('body').attr('data-language');
    var currentPage = $('.log-container h4').attr('data-file');
    var pageLength = $('.datatable').attr('data-pagelength');

    datatable = $('.datatable').DataTable({
        ajax: baseUrl + 'ajax.php?viewlog&file=' + currentPage,
        ordering: false,
        serverSide: true,
        processing: true,
        stateSave: true,
        pageLength: pageLength,
        columns: [
            {'data': 'log'},
        ],
        order: [
            [0, 'desc']
        ],
        language: {
            url: 'https://cdn.datatables.net/plug-ins/1.10.20/i18n/' + dataTablesLang + '.json'
        }
    });
}
