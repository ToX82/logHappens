<?php
$files = glob("logics/*.php");
$menu_items = [];
foreach ($files as $file) {
    include($file);
    $filename = str_replace("logics/", "", $file);
    $filename = str_replace(".php", "", $filename);
    $menu_items[$filename] = $menu;
    $menu_items[$filename]['count'] = count($logs);
}
?>

<ul id="slide-out" class="side-nav fixed leftside-navigation col s12 m3 no-padding grey lighten-5">
    <li>
        <a href="?page=info" class="waves-effect">
            <i class="material-icons">equalizer</i>
            Home page
        </a>
    </li>
    <?php foreach ($menu_items as $filename => $item) { ?>
        <li>
            <a href="?page=log_reader&logic=<?= $filename ?>" class="waves-effect waves-<?= $item['color'] ?>" data-tofollow="true" data-howmany="<?= $item['count'] ?>" data-name="<?= $item['title'] ?>" data-fileurl="<?= $item['file'] ?>">
                <i class="material-icons <?= $item['color'] ?>-text text-darken-2"><?= $item['icon'] ?></i>
                <span class="badge"><?= $item['count'] ?></span>
                <?= $item['title'] ?>
            </a>
        </li>
    <?php } ?>

    <li>
        <hr>
        <div class="input-field col s12 m10 offset-m1">
            <select class="page-length">
                <option <?php if ($_SESSION['pagelength'] == 5) { echo "selected"; } ?> value="5">Show 5 logs entry per page</option>
                <option <?php if ($_SESSION['pagelength'] == 10) { echo "selected"; } ?> value="10">Show 10 logs entry per page</option>
                <option <?php if ($_SESSION['pagelength'] == 25) { echo "selected"; } ?> value="25">Show 25 logs entry per page</option>
                <option <?php if ($_SESSION['pagelength'] == 50) { echo "selected"; } ?> value="50">Show 50 logs entry per page</option>
                <option <?php if ($_SESSION['pagelength'] == 100) { echo "selected"; } ?> value="100">Show 100 logs entry per page</option>
            </select>
        </div>
    </li>
</ul>
