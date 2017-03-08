<ul id="slide-out" class="side-nav fixed leftside-navigation col s12 m3 no-padding grey lighten-5">
    <li class="user-details color-themed <?= $colors["default"] ?> darken-3 white-text no-padding">
        <div class="row">
            <div class="col col s8 m8 l8">
                <p class="sidebar-title no-margin">Please choose a log</p>
            </div>
        </div>
    </li>
    <li>
        <a href="?page=info" class="waves-effect">
            <i class="material-icons">equalizer</i>
            Home page
        </a>
    </li>
    <li>
        <a href="?page=log_reader&logic=apache24" class="waves-effect waves-red" data-tofollow="true" data-howmany="0" data-name="Apache's error.log">
            <i class="material-icons red-text text-darken-2">build</i>
            <span class="badge">0</span>Apache's error.log
        </a>
    </li>
    <li>
        <a href="?page=log_reader&logic=fattura-errors" class="waves-effect waves-green" data-tofollow="true" data-howmany="0" data-name="Fatturazione error.log">
            <i class="material-icons teal-text text-darken-2">send</i>
            <span class="badge">0</span>Fatturazione error.log
        </a>
    </li>
    <li>
        <a href="?page=log_reader&logic=fattura-debug" class="waves-effect waves-green" data-tofollow="true" data-howmany="0" data-name="Fatturazione debug.log">
            <i class="material-icons teal-text text-darken-2">send</i>
            <span class="badge">0</span>Fatturazione debug.log
        </a>
    </li>
    <li>
        <a href="?page=log_reader&logic=papiro-errors" class="waves-effect waves-orange" data-tofollow="true" data-howmany="0" data-name="Il Papiro Web error.log">
            <i class="material-icons orange-text text-darken-2">palette</i>
            <span class="badge">0</span>Il Papiro Web error.log
        </a>
    </li>
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
