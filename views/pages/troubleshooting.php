<div class="row">
    <div class="col-8 offset-2">
        <div class="card border-secondary mb-3">
            <div class="card-header">
                Troubleshooting
            </div>
            <div class="card-body">
                <p>Here is a short list of issues you might be facing when using LogHappens:</p>
                <ul>
                    <li class="mb-3">
                        <strong>LogHappens can't read apache's error.log!</strong>
                        <div>
                            <p>By default, apache log files are not readable by apache itself. Which is a good
                                thing, at least on a production server. If you are on a development machine
                                though you might want to give those files the correct permissions in order to be
                                usable with LogHappens.<br>Here's how you do it:</p>

                            <ul>
                                <li>Edit /etc/logrotate.d/apache2, find the line saying create 640 root adm and
                                    replace with create 777 root adm.</li>
                                <li>Add 777 permissions to the apache logs directory: sudo chmod -R 777 /var/log/apache2/</li>
                            </ul>
                        </div>
                    </li>
                    <li class="mb-3">
                        <strong>LogHappens can't read my application's log files!</strong>
                        <div>
                            <p>Just set that file's permissions to 777, so that LogHappens can both read and write (truncate) that file.
                            </p>
                        </div>
                    </li>
                    <li class="mb-3">
                        <strong>How do I add a log file to be tracked?</strong>
                        <div>
                            <p>Just add a new record in your config.json file, and set the values according to your preferences.
                            </p>
                        </div>
                    </li>
                    <li class="mb-3">
                        <strong>Can I share a new parser?</strong>
                        <div>
                            <p>Of course! If you have created your own parser, please send it
                                to me, I will be glad to add it to the other parsers!
                            </p>
                        </div>
                    </li>
                    <li class="mb-3">
                        <strong>Is there any kind of support with LogHappens?</strong>
                        <div>
                            <p>If you find some technical issues, please open an issue on <a href='https://github.com/ToX82/logHappens/issues'>GitHub</a>.
                            </p>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
