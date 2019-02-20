<ul id="slide-out" class="side-nav fixed leftside-navigation col s8 m5 l3 no-padding grey lighten-4">
    <li>
        <a href="?page=info" class="waves-effect">
            <span class="iconify grey-text text-darken-2" data-icon="ant-design:home" data-inline="false" data-width="22" data-height="22"></span>
            Home page
        </a>
    </li>
    <?php foreach ($menuItems as $filename => $item) { ?>
        <li class="<?= ($filename == $logic) ? "active" : "" ?>">
            <a href="?page=log_reader&amp;logic=<?= $filename ?>"
                class="truncate waves-effect waves-<?= $item['color'] ?> <?= ($filename == $logic) ? 'active' : "" ?>"
                data-tracked="true"
                data-howmany="<?= $item['count'] ?>"
                data-name="<?= $item['title'] ?>"
                data-fileurl="<?= $item['file'] ?>"
                >

                <span class="iconify <?= $item['color'] ?>-text text-darken-2" data-height="22" data-width="22" data-icon="<?= $item['icon'] ?>" data-inline="false"></span>
                <span class="badge"><?= $item['count'] ?></span>
                <?= $item['title'] ?>
            </a>
        </li>
    <?php } ?>

    <li>
        <hr>
        <div class="input-field col s12 m10 offset-m1">
            <select class="page-length">
                <option <?= ($_SESSION['pagelength'] == 5) ? 'selected' : "" ?> value="5">Show 5 logs entry per page</option>
                <option <?= ($_SESSION['pagelength'] == 10) ? 'selected' : "" ?> value="10">Show 10 logs entry per page</option>
                <option <?= ($_SESSION['pagelength'] == 25) ? 'selected' : "" ?> value="25">Show 25 logs entry per page</option>
                <option <?= ($_SESSION['pagelength'] == 50) ? 'selected' : "" ?> value="50">Show 50 logs entry per page</option>
                <option <?= ($_SESSION['pagelength'] == 100) ? 'selected' : "" ?> value="100">Show 100 logs entry per page</option>
            </select>
        </div>
    </li>
</ul>
