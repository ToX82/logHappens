<div class="row">
    <div class="col-8 offset-2">
        <div class="card border-secondary mb-3">
            <div class="card-header">
                About LogHappens
            </div>
            <div class="card-body">
                <h5>Bug happens... <span class="iconify" data-icon="emojione-v1:pile-of-poo" data-inline="true" data-width="40"></span></h5>
                <p>
                    Every developer knows that. The bad thing is that
                    if you want to see what happened, more often than not you have to crawl between hundred
                    lines log files, written in a format which is all but human friendly.
                </p>

                <h5>That's why LogHappens exists!</h5>
                <p>
                    LogHappens aims to fix exactly this. It is a simple tool, it will not
                    prevent you from writing bugs, but it will notify you immediately when
                    something has been logged by your web server or your favorite
                    framework.
                </p>

                <h5>Does it handle different log formats?</h5>
                <p>
                    Of course it does. Every software has its own
                    bugs, and every software have its own way of logging things too. This is
                    why I have tried to make it as simple as possible to let you create
                    your own routine for reading log files. No fancy regex strings: if
                    you just want to read the file, you can group log entries by date/time
                    and print the rest of the file. If you are feeling adventurous, you
                    can possibly do whatever you want: highlight words, create tags, split
                    errors... the only limit is your fantasy.

                <h5>Any troubles?</h5>
                <p>
                    In order to use LogHappens you will need to configure a few things. If you
                    have any troubles, please see the <a href="<?= buildUrl("display/start") ?>">Start</a>
                    or the <a href="<?= buildUrl("display/troubleshooting") ?>">Troubleshooting</a>
                    page. And if you find some technical issues, please open an issue on
                    <a href="https://github.com/ToX82/logHappens/issues">GitHub</a>.
                </p>

                <h5>Do you like LogHappens? Spread the word!</h5>
                <p>
                    <a href="https://facebook.com/sharer/sharer.php?u=https%3A%2F%2Floghappens.com" target="_blank"><img src="<?= buildAssetUrl("img/social/facebook.svg") ?>" width="36" height="36" style="background-color:#3B5998"></a>
                    <a href="https://twitter.com/intent/tweet/?text=&amp;url=https%3A%2F%2Floghappens.com" target="_blank"><img src="<?= buildAssetUrl("img/social/twitter.svg") ?>" width="36" height="36" style="background-color:#55ACEE"></a>
                    <a href="https://plus.google.com/share?url=https%3A%2F%2Floghappens.com" target="_blank"><img src="<?= buildAssetUrl("img/social/google_plus.svg") ?>" width="36" height="36" style="background-color:#DD4B39"></a>
                    <a href="https://www.linkedin.com/shareArticle?mini=true&amp;url=https%3A%2F%2Floghappens.com&amp;title=&amp;summary=&amp;source=https%3A%2F%2Floghappens.com" target="_blank"><img src="<?= buildAssetUrl("img/social/linkedin.svg") ?>" width="36" height="36" style="background-color:#007BB5"></a>
                    <a href="whatsapp://send?text=%20https%3A%2F%2Floghappens.com" target="_blank"><img src="<?= buildAssetUrl("img/social/whatsapp.svg") ?>" width="36" height="36" style="background-color:#12AF0A"></a>
                    <a href="mailto:?subject=&amp;body=https%3A%2F%2Floghappens.com" target="_blank"><img src="<?= buildAssetUrl("img/social/email.svg") ?>" width="36" height="36" style="background-color:#0166FF"></a>
                </p>
            </div>
        </div>
    </div>
</div>
