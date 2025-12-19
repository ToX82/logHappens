let datatable;
let deferredPrompt;

$(document).ready(function () {
    const baseUrl = $('.baseUrl').html();
    const refresh = parseInt($('.logs-list').attr('data-refresh'), 10);

    bootstrap();
    initPWA();
    initPerplexityButton();
    initVersionCheck();

    // Initialize drag and drop for configurations
    if ($('#configurations-list').length) {
        const list = document.getElementById('configurations-list');
        let draggedItem = null;
        let lastDirection = null;

        // Aggiungi gli event listener a tutti gli elementi draggable
        document.querySelectorAll('.sortable-item').forEach(item => {
            item.addEventListener('dragstart', function(e) {
                draggedItem = this;
                this.classList.add('dragging');
                // Aggiungi un delay per rendere visibile l'effetto di scaling
                setTimeout(() => {
                    this.classList.add('dragging');
                }, 0);
                e.dataTransfer.effectAllowed = 'move';
            });

            item.addEventListener('dragend', function() {
                this.classList.remove('dragging');
                document.querySelectorAll('.sortable-item').forEach(item => {
                    item.classList.remove('drop-above', 'drop-below', 'shift-down', 'shift-up', 'drop-target');
                });
                draggedItem = null;
                lastDirection = null;
            });

            item.addEventListener('dragover', function(e) {
                e.preventDefault();
                if (this !== draggedItem) {
                    const rect = this.getBoundingClientRect();
                    const midY = rect.top + rect.height / 2;
                    const direction = e.clientY < midY ? 'above' : 'below';

                    // Se la direzione è cambiata, aggiorna l'animazione
                    if (direction !== lastDirection) {
                        // Rimuovi tutte le classi di animazione
                        document.querySelectorAll('.sortable-item').forEach(item => {
                            item.classList.remove('drop-above', 'drop-below', 'shift-down', 'shift-up', 'drop-target');
                        });

                        // Aggiungi la classe drop-target all'elemento target
                        this.classList.add('drop-target');

                        // Trova tutti gli elementi tra la posizione corrente e la destinazione
                        const items = Array.from(document.querySelectorAll('.sortable-item'));
                        const currentIndex = items.indexOf(draggedItem);
                        const targetIndex = items.indexOf(this);

                        if (direction === 'above') {
                            this.classList.add('drop-above');
                            // Sposta in giù gli elementi tra target e current
                            for (let i = targetIndex; i < currentIndex; i++) {
                                items[i].classList.add('shift-down');
                            }
                        } else {
                            this.classList.add('drop-below');
                            // Sposta in su gli elementi tra current e target
                            for (let i = currentIndex + 1; i <= targetIndex; i++) {
                                items[i].classList.add('shift-up');
                            }
                        }

                        // Aggiorna la posizione dell'elemento trascinato con un leggero delay
                        setTimeout(() => {
                            if (direction === 'above') {
                                this.parentNode.insertBefore(draggedItem, this);
                            } else {
                                this.parentNode.insertBefore(draggedItem, this.nextSibling);
                            }
                        }, 150);

                        lastDirection = direction;
                    }
                }
            });

            item.addEventListener('dragleave', function(event) {
                if (!draggedItem) return;
                const relatedTarget = event.relatedTarget;
                // Rimuovi le classi solo se usciamo dall'area di drop
                if (!this.contains(relatedTarget) && !relatedTarget?.classList.contains('sortable-item')) {
                    document.querySelectorAll('.sortable-item').forEach(item => {
                        item.classList.remove('drop-above', 'drop-below', 'shift-down', 'shift-up', 'drop-target');
                    });
                }
            });

            item.addEventListener('dragend', function() {
                const order = [];
                document.querySelectorAll('.sortable-item').forEach(item => {
                    order.push(item.dataset.id);
                });

                $.ajax({
                    url: `${baseUrl}ajax.php?update-order`,
                    method: 'POST',
                    dataType: 'json',
                    data: { order: JSON.stringify(order) }
                }).done(function (res) {
                    var ok = !!(res && (res.success === true || res === true));
                    var msg = (res && res.message) ? res.message : (ok ? 'Order updated' : 'Order update failed');
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: ok ? 'success' : 'error',
                            title: msg,
                            timer: 2000,
                            timerProgressBar: true,
                            showCloseButton: true,
                            showConfirmButton: false
                        });
                    }
                }).fail(function () {
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'error',
                            title: 'Order update failed',
                            timer: 2500,
                            timerProgressBar: true,
                            showCloseButton: true,
                            showConfirmButton: false
                        });
                    }
                });
            });
        });
    }

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
        const message = $(this).data('message') || 'Are you sure you want to proceed?';
        $modal.find('.js-confirm-message').text(message);
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
    $('#input-file').on('keyup change', function () {
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

    $('#input-title').on('keyup', function () {
        $('.title-preview').html($(this).val());
    });

    // Icon preview updater
    if ($('#input-icon').length > 0) {
        setInterval(function () {
            const currentIcon = $('.iconify-preview.iconify').data('icon');
            const currentColor = rgbToHex($('.iconify-preview.iconify').css('color'));
            const icon = $('#input-icon').val();
            const color = $('#input-color').val();

            if (icon !== currentIcon || color !== currentColor) {
                $('.iconify-preview').each(function () {
                    const $this = $(this);
                    const width = $this.data('width');
                    const height = $this.data('height');
                    $this.replaceWith(`<span class="iconify-preview iconify" data-inline="false" data-icon="${icon}" style="color: ${color}" data-width="${width}" data-height="${height}"></span>`);
                });
            }
        }, 300);
    }

    // Icon visibility toggle
    $('.icon-visibility').on('click', function () {
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
 * Initialize Perplexity button functionality
 */
function initPerplexityButton() {
    // Show button on hover over log entries
    $(document).on('mouseenter', '.datatable tbody tr', function() {
        const $row = $(this);
        const $card = $row.find('.card');
        showPerplexityButton($card);
    });

    // Hide button when leaving log entry
    $(document).on('mouseleave', '.datatable tbody tr', function() {
        const $row = $(this);
        const $card = $row.find('.card');
        hidePerplexityButton($card);
    });

    // Handle Perplexity button click
    $(document).on('click', '.perplexity-button', function(e) {
        e.preventDefault();
        const errorText = $(this).closest('.card').find('.card-text').text();

        if (errorText) {
            openPerplexityWithError(errorText);
        }
    });

    // Handle Copy button click
    $(document).on('click', '.copy-button', function(e) {
        e.preventDefault();
        const errorText = $(this).closest('.card').find('.card-text').text();

        if (errorText) {
            navigator.clipboard.writeText(errorText).then(function() {
                // Show feedback to user
                const $button = $(e.currentTarget);
                const originalText = $button.html();
                $button.html('<span class="iconify me-1" data-icon="mdi:check" data-inline="true"></span>Copied!');
                $button.addClass('btn-success').removeClass('btn-outline-secondary');

                setTimeout(function() {
                    $button.html(originalText);
                    $button.removeClass('btn-success').addClass('btn-outline-secondary');
                }, 2000);
            }).catch(function(err) {
                console.error('Failed to copy text: ', err);
                // Fallback for older browsers
                const textArea = document.createElement('textarea');
                textArea.value = errorText;
                document.body.appendChild(textArea);
                textArea.select();
                document.execCommand('copy');
                document.body.removeChild(textArea);

                // Show feedback even with fallback
                const $button = $(e.currentTarget);
                const originalText = $button.html();
                $button.html('<span class="iconify me-1" data-icon="mdi:check" data-inline="true"></span>Copied!');
                $button.addClass('btn-success').removeClass('btn-outline-secondary');

                setTimeout(function() {
                    $button.html(originalText);
                    $button.removeClass('btn-success').addClass('btn-outline-secondary');
                }, 2000);
            });
        }
    });
}

/**
 * Show the Perplexity button in the card header
 * @param {jQuery} $card - The card element
 */
function showPerplexityButton($card) {
    const $button = $card.find('.perplexity-button');
    const $copyButton = $card.find('.copy-button');
    if ($button.length) {
        $button.addClass('show');
    }
    if ($copyButton.length) {
        $copyButton.addClass('show');
    }
}

/**
 * Hide the Perplexity button
 * @param {jQuery} $card - The card element
 */
function hidePerplexityButton($card) {
    const $button = $card.find('.perplexity-button');
    const $copyButton = $card.find('.copy-button');
    if ($button.length) {
        $button.removeClass('show');
    }
    if ($copyButton.length) {
        $copyButton.removeClass('show');
    }
}

/**
 * Open Perplexity with the error text
 * @param {string} errorText - The error text to send to Perplexity
 */
function openPerplexityWithError(errorText) {
    const decodedError = decodeURIComponent(errorText);

    // Create a comprehensive query for Perplexity
    const query = `I have this error in my logs: ${decodedError}. Can you help me understand what this error means and how to fix it? Please keep it short and easy to understand.`;

    // Encode the query for URL
    const encodedQuery = encodeURIComponent(query);

    // Open Perplexity in a new tab
    const perplexityUrl = `https://www.perplexity.ai/?q=${encodedQuery}`;
    window.open(perplexityUrl, '_blank');
}

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
            const countOld = parseInt($badge.html().trim(), 10) || 0;
            const countNewValue = parseInt(countNew, 10) || 0;

            handleCountChange(file, countOld, countNewValue, currentPage, $badge, isActive);

            if (countNewValue !== countOld) {
                notificationText += buildNotificationText(file, countNewValue - countOld);
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
 * Updates the count display and triggers a reload if the count has changed and the current page is active.
 *
 * @param {string} file - The file whose count has changed.
 * @param {number} countOld - The old count value.
 * @param {number} countNew - The new count value.
 * @param {string} currentPage - The current active page.
 * @param {jQuery} $badge - The badge element to update.
 * @param {boolean} isActive - Whether the current page is active.
 */
function handleCountChange(file, countOld, countNew, currentPage, $badge, isActive) {
    if (countNew !== countOld) {
        if (currentPage === file && datatable.page.info().page === 0) {
            reloadContent();
        }

        if (isActive) {
            $('head title').text(`(${countNew}) ${$('.log-title').html()} - LogHappened!`);
        }

        $badge.html(countNew).addClass('badge-highlight');
    }
}

/**
 * Builds a notification text with the file name and the number of new logs.
 *
 * @param {string} file - The name of the file.
 * @param {number} difference - The number of new logs.
 * @return {string} The notification text.
 */
function buildNotificationText(file, difference) {
    return `${file}: ${difference} new logs!`;
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
 * Converts an RGB color string to a hexadecimal color string.
 * @param {string} rgb The RGB color string (e.g., "rgb(255, 0, 0)").
 * @returns {string|null} The hexadecimal color string or null if the input is invalid.
 */
function rgbToHex(rgb) {
    const result = rgb.match(/\d+/g);
    if (!result) return null;
    return `#${result.map(function(x) {
        const hex = parseInt(x).toString(16);
        return hex.length === 1 ? `0${hex}` : hex;
    }).join('')}`;
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

    // Highlight the search term in the datatable
    datatable.on('draw', function () {
        const body = $(datatable.table().body());
        body.mark(datatable.search());
    });
}

// PWA Initialization
function initPWA() {
    // Handle install prompt
    window.addEventListener('beforeinstallprompt', (e) => {
        e.preventDefault();
        deferredPrompt = e;

        // Show install prompt after a delay
        setTimeout(() => {
            showInstallPrompt();
        }, 3000);
    });

    // Handle offline/online events
    window.addEventListener('offline', () => {
        showOfflineIndicator();
    });

    window.addEventListener('online', () => {
        hideOfflineIndicator();
    });

    // Install button click
    $('#install-btn').on('click', () => {
        if (deferredPrompt) {
            deferredPrompt.prompt();
            deferredPrompt.userChoice.then((choiceResult) => {
                if (choiceResult.outcome === 'accepted') {
                    console.log('User accepted the install prompt');
                } else {
                    console.log('User dismissed the install prompt');
                }
                deferredPrompt = null;
                hideInstallPrompt();
            });
        }
    });

    // Close install prompt
    $('#install-close').on('click', () => {
        hideInstallPrompt();
    });

    // Check if app is already installed
    if (window.matchMedia('(display-mode: standalone)').matches) {
        console.log('App is running in standalone mode');
    }
}

function showInstallPrompt() {
    if (!localStorage.getItem('installPromptDismissed')) {
        $('#install-prompt').addClass('show');
    }
}

function hideInstallPrompt() {
    $('#install-prompt').removeClass('show');
    localStorage.setItem('installPromptDismissed', 'true');
}

function showOfflineIndicator() {
    $('#offline-indicator').addClass('show');
}

function hideOfflineIndicator() {
    $('#offline-indicator').removeClass('show');
}

// Request notification permission
function requestNotificationPermission() {
    if ('Notification' in window && Notification.permission === 'default') {
        Notification.requestPermission().then((permission) => {
            if (permission === 'granted') {
                console.log('Notification permission granted');
            }
        });
    }
}

// Show notification
function showNotification(title, options = {}) {
    if ('Notification' in window && Notification.permission === 'granted') {
        const notification = new Notification(title, {
            icon: '/img/favicon/icon-192x192.png',
            badge: '/img/favicon/icon-72x72.png',
            ...options
        });

        notification.onclick = function() {
            window.focus();
            notification.close();
        };
    }
}

/**
 * Initialize version check functionality
 */
function initVersionCheck() {
    const baseUrl = $('.baseUrl').html();
    checkForUpdates(baseUrl);
}

/**
 * Check for updates and show notification if available
 * @param {string} baseUrl - The application base URL
 */
function checkForUpdates(baseUrl) {
    console.log('Checking for updates...');
    $.ajax({
        url: `${baseUrl}ajax.php?check-version`,
        method: 'GET',
        dataType: 'json',
        timeout: 10000
    }).done(function(data) {
        if (data.has_update) {
            showUpdateNotification();
        } else {
            console.log('No updates available');
        }
    }).fail(function() {
        console.log('Version check failed');
    });
}

/**
 * Show update notification in header
 */
function showUpdateNotification() {
    console.log(`There is an update available!`);

    const $headerNotification = $('#header-update-notification');

    if ($headerNotification.length) {
        $headerNotification.fadeIn();
    }
}
