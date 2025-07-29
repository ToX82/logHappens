<!DOCTYPE html>
<html lang="<?= getBrowserLanguage() ?>">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="msapplication-tap-highlight" content="no">

    <!-- PWA Meta Tags -->
    <meta name="theme-color" content="#0D47A1">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="apple-mobile-web-app-title" content="LogHappens">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="application-name" content="LogHappens">
    <meta name="msapplication-TileColor" content="#0D47A1">
    <meta name="msapplication-config" content="/browserconfig.xml">

    <title><?= ($pageTitle) ? $pageTitle . " - " : '' ?>LogHappens</title>

    <!-- Favicons-->
    <link rel="icon" href="<?= buildAssetUrl("webroot/img/favicon/favicon-32x32.png") ?>" sizes="32x32">
    <link rel="apple-touch-icon-precomposed" href="<?= buildAssetUrl("webroot/img/favicon/apple-touch-icon-152x152.png") ?>">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5/dist/css/bootstrap.min.css">
    <?php if (setting('theme') !== 'bootstrap') { ?>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootswatch@5/dist/<?= setting('theme') ?>/bootstrap.min.css">
    <?php } ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/datatables.net-bs4@1/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="<?= buildAssetUrl("webroot/css/layout.css") ?>">

    <!-- PWA Manifest -->
    <link rel="manifest" href="<?= buildAssetUrl("webroot/manifest.json") ?>">

    <!-- Apple Touch Icons -->
    <link rel="apple-touch-icon" href="<?= buildAssetUrl("webroot/img/favicon/icon-152x152.png") ?>">
    <link rel="apple-touch-icon" sizes="152x152" href="<?= buildAssetUrl("webroot/img/favicon/icon-152x152.png") ?>">
    <link rel="apple-touch-icon" sizes="180x180" href="<?= buildAssetUrl("webroot/img/favicon/icon-192x192.png") ?>">

    <!-- Windows Tile Icons -->
    <meta name="msapplication-TileImage" content="<?= buildAssetUrl("webroot/img/favicon/icon-144x144.png") ?>">

    <script rel=preconnect src="https://cdn.jsdelivr.net/npm/@iconify/iconify@1/dist/iconify.min.js"></script>
</head>
<body data-language="<?= getUserLanguage() ?>">
    <?php include(ROOT . 'views/elements/pwa.php') ?>

    <header id="header" class="page-topbar">
        <?php include(ROOT . 'views/elements/header.php') ?>
    </header>

    <main class="container-fluid">
        <div class="row">
            <aside id="left-sidebar-nav" class="col-12 col-md-12 col-lg-3 pt-4">
                <?php include(ROOT . 'views/elements/sidemenu.php') ?>
            </aside>

            <section id="content" class="col-12 col-md-12 col-lg-9">
                <div class="row my-4">
                    <div class="col-12 log-container">
                        <?php foreach ($views as $view) { ?>
                            <?php if (is_file($view)) { ?>
                                <?php include($view); ?>
                            <?php } else { ?>
                                <p class="w-100 text-center">The template <?= $view ?> does not exist.</p>
                            <?php } ?>
                        <?php } ?>
                    </div>
                </div>
            </section>
        </div>
    </main>

    <?php include(ROOT . 'views/elements/confirm_truncate.php') ?>
    <div class="baseUrl d-none"><?= BASE_URL ?></div>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/datatables.net@1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/datatables.net-bs4@1/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/push.js@1/bin/push.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/iconify-select-plugin@1/iconify-select-plugin.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/mark.js@8/dist/jquery.mark.min.js"></script>
    <script type="text/javascript" src="<?= buildAssetUrl("webroot/js/custom.js") ?>"></script>

    <!-- PWA Service Worker Registration -->
    <script>
        // Register service worker for PWA functionality
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', function() {
                navigator.serviceWorker.register('<?= buildAssetUrl("webroot/sw.js") ?>')
                    .then(function(registration) {
                        console.log('SW registered: ', registration);

                        // Check for updates
                        registration.addEventListener('updatefound', function() {
                            const newWorker = registration.installing;
                            newWorker.addEventListener('statechange', function() {
                                if (newWorker.state === 'installed' && navigator.serviceWorker.controller) {
                                    // New content is available, show update notification
                                    showUpdateNotification();
                                }
                            });
                        });
                    })
                    .catch(function(registrationError) {
                        console.log('SW registration failed: ', registrationError);
                    });
            });
        }

        // Show update notification
        function showUpdateNotification() {
            if (confirm('A new version of LogHappens is available. Would you like to update now?')) {
                window.location.reload();
            }
        }

        // Handle offline/online events
        window.addEventListener('online', function() {
            document.body.classList.remove('offline');
            console.log('Application is online');
        });

        window.addEventListener('offline', function() {
            document.body.classList.add('offline');
            console.log('Application is offline');
        });
    </script>
</body>
</html>
