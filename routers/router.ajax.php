<?php

declare(strict_types=1);

// Get container instance
$container = \Libs\getContainer();

try {
    // Resolve services from container
    $objParsers = $container->resolve('parsers');
    $objConfig = $container->resolve('configurations');
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Service initialization failed']);
    exit;
}

$return = null;

if (isset($_GET['countall'])) {
    $return = $objParsers->countAll();
    $return = json_encode($return);
}
if (isset($_GET['viewlog'])) {
    $file = (string)filter_var($_GET['file'] ?? '', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $offset = (int)filter_var($_GET['start'] ?? 0, FILTER_SANITIZE_NUMBER_INT);
    $limit = (int)filter_var($_GET['length'] ?? 10, FILTER_SANITIZE_NUMBER_INT);
    $search = (string)filter_var($_GET['search']['value'] ?? '', FILTER_UNSAFE_RAW);
    $return = $objParsers->entries($file, $offset, $limit, $search);
    $return = include(ROOT . 'views/parsers/getdata.php');
}
if (isset($_GET['check-file-exists'])) {
    $filename = (string)filter_var($_POST['filename'] ?? '', FILTER_UNSAFE_RAW);
    $return = $objConfig->checkFileExists($filename);
    $return = json_encode($return);
}
if (isset($_GET['change-visibility'])) {
    $configName = (string)filter_var($_POST['configName'] ?? '', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $return = $objConfig->changeVisibility($configName);
    $return = json_encode($return);
}

if (isset($_GET['update-order'])) {
    $orderRaw = (string)($_POST['order'] ?? '[]');
    $order = json_decode($orderRaw, true);
    if (!is_array($order)) {
        $order = [];
    }
    $ok = $objConfig->updateOrder($order);
    $return = json_encode([
        'success' => (bool)$ok,
        'message' => $ok ? 'Order updated' : 'Order update failed'
    ]);
}

if (isset($_GET['check-version'])) {
    $versionInfo = \Libs\Version::getVersionInfo();
    $return = json_encode($versionInfo);
}
