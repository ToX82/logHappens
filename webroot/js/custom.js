let datatable;

$(document).ready(function () {
    const baseUrl = $('.baseUrl').html();
    const refresh = parseInt($('.logs-list').attr('data-refresh'), 10);

    bootstrap();

    // Theme switcher
    $('.settings-switcher').on('change', function () {
        const parameter = $(this).attr('id');
        const selected = $(this).val();
        window.location.href = `${baseUrl}writesettings/${parameter}/${selected}`;
    });

    // Recount logs every X seconds
    setInterval(recountAll, refresh * 1000);

    // TruncateLink method
    $('body').on('click', '.btn-openModal', function (e) {
        e.preventDefault();
        const link = $(this).attr('href');
        const $modal = $('#js-confirm');
        $modal.modal('show');

        $modal.find('.yes-btn').off('click').on('click', function () {
            window.location.href = link;
        });
    });

    // When the truncate modal opens, automatically put the focus on the yes button
    $('body').on('shown.bs.modal', '#js-confirm', function () {
        $('.yes-btn', this).focus();
    });

    // Input file change event
    $('#input-file').on('change blur', function () {
        const $input = $(this);
        const filename = $input.val();

        $.ajax({
            url: `${baseUrl}ajax.php?check-file-exists`,
            method: 'POST',
            data: { filename },
        }).done(function (result) {
            $input.removeClass('is-invalid is-valid');
            $input.addClass(result === 'true' ? 'is-valid' : 'is-invalid');
        });
    });

    // Icon preview updater
    if ($('#input-icon').length > 0) {
        setInterval(function () {
            const currentIcon = $('.iconify-preview .iconify').attr('data-icon');
            const currentColor = $('.iconify-preview .iconify').attr('color');
            const icon = $('#input-icon').val();
            const color = $('#input-color').val();

            if (icon !== currentIcon || color !== currentColor) {
                $('.iconify-preview').html(`<i class="iconify" data-width="32" data-icon="${icon}" color="${color}"></i>`);
            }
        }, 300);
    }

    // Icon visibility toggle
    $('i.icon-visibility').on('click', function () {
        const configName = $(this).attr('id');

        $.ajax({
            url: `${baseUrl}ajax.php?change-visibility`,
            method: 'POST',
            data: { configName },
        }).done(function () {
            location.reload();
        });
    });

    // Bootstrap form validation
    (() => {
        'use strict';
        const forms = document.querySelectorAll('.needs-validation');

        Array.from(forms).forEach((form) => {
            form.addEventListener(
                'submit',
                (event) => {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                },
                false
            );
        });
    })();
});

/**
 * Recount logs and trigger warnings when something happens
 *
 * @returns {void}
 */
function recountAll() {
    const baseUrl = $('.baseUrl').html();
    const $sidebar = $('#left-sidebar-nav');
    const currentPage = $('.log-container h4').attr('data-file');
    let notificationText = '';

    $.ajax({
        url: `${baseUrl}ajax.php?countall`,
        dataType: 'json',
    }).done(function (data) {
        notificationText = '';
        $.each(data, function (file, countNew) {
            const $navLink = $sidebar.find(`a[data-file="${file}"]`);
            const isActive = $navLink.parent().hasClass('active');
            const $badge = $navLink.find('.badge');
            let countOld = parseInt($badge.html().trim(), 10) || 0;
            countNew = parseInt(countNew, 10) || 0;

            if (countNew !== countOld) {
                const difference = countNew - countOld;

                if (currentPage === file && datatable.page.info().page === 0) {
                    reloadContent();
                }

                if (isActive) {
                    $('head title').text(`(${countNew}) ${$('.log-title').html()} - LogHappened!`);
                }

                $badge.html(countNew).addClass('badge-highlight');
                notificationText += `${file}: ${difference} new logs!     `;
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
        icon: `${baseUrl}/img/logo.png`,
        timeout: 4000,
        onClick: function () {
            window.focus();
            this.close();
        },
    });
}

/**
 * Refresh the log's list
 *
 * @returns {void}
 */
function reloadContent() {
    const table = $('.datatable').DataTable();
    table.ajax.reload();
}

/**
 * Page bootstrap (here we set datatables settings and maybe more)
 *
 * @returns {void}
 */
function bootstrap() {
    const baseUrl = $('.baseUrl').html();
    const dataTablesLang = $('body').attr('data-language');
    const currentPage = $('.log-container h4').attr('data-file');
    const pageLength = parseInt($('.datatable').attr('data-pagelength'), 10);

    datatable = $('.datatable').DataTable({
        ajax: `${baseUrl}ajax.php?viewlog&file=${currentPage}`,
        ordering: false,
        serverSide: true,
        processing: true,
        stateSave: true,
        pageLength,
        columns: [{ data: 'log' }],
        order: [[0, 'desc']],
        language: {
            url: `https://cdn.datatables.net/plug-ins/1.10.20/i18n/${dataTablesLang}.json`,
        },
    });
}
