<?php

use Libs\Flash;

$messages = Flash::consume();

if (!empty($messages)) { ?>
<script>
    (function() {
        const messages = <?php echo json_encode($messages, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP); ?>;

        function typeToIcon(type) {
            switch (type) {
                case 'success': return 'success';
                case 'warning': return 'warning';
                case 'error': return 'error';
                default: return 'info';
            }
        }

        function buildQueue(list) {
            return list.map(function(m) {
                var timer = (m.options && m.options.timer) ? m.options.timer : 3000;
                var showConfirmButton = (m.options && typeof m.options.showConfirmButton !== 'undefined') ? m.options.showConfirmButton : false;
                var toast = (m.options && typeof m.options.toast !== 'undefined') ? !!m.options.toast : true;
                var position = (m.options && m.options.position) ? m.options.position : 'top-end';
                var timerProgressBar = (m.options && typeof m.options.timerProgressBar !== 'undefined') ? m.options.timerProgressBar : true;
                var showCloseButton = (m.options && typeof m.options.showCloseButton !== 'undefined') ? m.options.showCloseButton : true;

                return {
                    toast: toast,
                    position: position,
                    icon: typeToIcon(m.type),
                    title: (m.options && m.options.title) ? m.options.title : m.message,
                    timer: timer,
                    timerProgressBar: timerProgressBar,
                    showConfirmButton: showConfirmButton,
                    showCloseButton: showCloseButton,
                    didOpen: function(toastEl) {
                        if (typeof Swal !== 'undefined' && Swal.stopTimer && Swal.resumeTimer) {
                            toastEl.addEventListener('mouseenter', Swal.stopTimer);
                            toastEl.addEventListener('mouseleave', Swal.resumeTimer);
                        }
                    }
                };
            });
        }

        function showQueueOnceReady() {
            if (typeof Swal === 'undefined') {
                return false;
            }
            var queue = buildQueue(messages);
            if (!Array.isArray(queue) || queue.length === 0) {
                return true;
            }
            function showNext() {
                if (queue.length === 0) { return; }
                var next = queue.shift();
                Swal.fire(next).then(showNext);
            }
            showNext();
            return true;
        }

        if (!showQueueOnceReady()) {
            window.addEventListener('load', function() {
                showQueueOnceReady();
            });

            var attempts = 0;
            var interval = setInterval(function() {
                attempts += 1;
                if (showQueueOnceReady() || attempts > 50) {
                    clearInterval(interval);
                }
            }, 100);
        }
    })();
</script>
<?php } ?>
