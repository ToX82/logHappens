<div class="row">
    <div class="col s8 offset-s2">
        <h5>Troubleshooting</h5>

        <ul class="collapsible">
            <li>
                <div class="collapsible-header active grey lighten-2">LogHappens can't read log files!</div>
                <div class="collapsible-body">
                    <p>By default, apache log files are not readable by apache itself. Which is a good
                        thing, at least on a production server. If you are on a development machine
                        though you should give those files the correct permissions if you want to use
                        LogHappens.</p><p>Here's how:</p>

                    <ul class="browser-default bullet-list">
                        <li>Edit /etc/logrotate.d/apache2, find the line saying create 640 root adm and
                            replace with create 777 root adm.</li>
                        <li>Add 777 permissions to the apache logs directory: sudo chmod -R 777 /var/log/apache2/</li>
                    </ul>
                </div>
            </li>
            <li>
                <div class="collapsible-header grey lighten-3">How do I add a log file to be tracked?</div>
                <div class="collapsible-body">
                    <p>You can use one of the files you see in the `logic_templates` folder. Edit it
                        according to your needs (e.g. the log path). Move it to the `logic` folder and
                        refresh the page. Voilà. Use as much logics as you like to track more log files,
                        and edit the way they group logs according to your needs.
                    </p>
                </div>
            </li>
            <li>
                <div class="collapsible-header grey lighten-2">Can I share a new template file?</div>
                <div class="collapsible-body">
                    <p>Of course! As you see, I have placed apache24 and CakePHP (2.x, 3.x) log files in the
                        `logic_templates` folder. If you have created your own routine, please send it
                        to me, I will be glad to add it to the other templates!
                    </p>
                </div>
            </li>
        </ul>
    </div>
</div>
