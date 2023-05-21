<div class="row">
    <div class="col-8 offset-2">
        <div class="card border-secondary mb-3">
            <div class="card-header">
                Troubleshooting
            </div>
            <div class="card-body">
                <p>Encountering a few bumps on your LogHappens journey? Not to worry, we've got your back!
                Check out this handy troubleshooting guide to address some common issues::</p>
                <ul>
                    <li class="mb-3">
                        <strong>LogHappens can't read apache's error.log!</strong>
                        <div>
                            <p>By default, Apache log files are not readable by Apache itself, which is a good
                            security measure for production servers. However, on a development machine, you
                            might want to grant the necessary permissions to make those files accessible to
                            LogHappens. <br>Here's what you can do:</p>

                            <ul>
                                <li>Edit the file /etc/logrotate.d/apache2 and locate the line that says
                                <code>create 640 root adm</code>.<br>
                                Replace it with <code>create 777 root adm</code>.</li>
                                <li>Grant 777 permissions to the Apache logs directory by running the command:<br>
                                <code>sudo chmod -R 777 /var/log/apache2/</code></li>
                            </ul>
                        </div>
                    </li>
                    <li class="mb-3">
                        <strong>LogHappens can't read my application's log files!</strong>
                        <div>
                            <p>
                                No worries! Just make sure the log file has the appropriate permissions for
                                LogHappens to read and write (truncate) it. Set the file's permissions to 777,
                                and LogHappens will be able to do its magic.
                            </p>
                        </div>
                    </li>
                    <li class="mb-3">
                        <strong>How do I add a log file to be tracked?</strong>
                        <div>
                            <p>
                                Easy peasy! Simply add a new record in your config.json file, and configure the values
                                according to your needs and preferences. This way, LogHappens will start tracking
                                the specified log file effortlessly.
                            </p>
                        </div>
                    </li>
                    <li class="mb-3">
                        <strong>Can I share a new parser?</strong>
                        <div>
                            <p>Absolutely! If you've created your own parser and want to spread the love, please send
                            it our way. We would be more than happy to include it among the other parsers and give
                            credit where credit is due!
                            </p>
                        </div>
                    </li>
                    <li class="mb-3">
                        <strong>Is there any kind of support with LogHappens?</strong>
                        <div>
                            <p>
                            If you encounter any technical issues along your LogHappens journey, don't hesitate to
                            open an issue on <a href='https://github.com/ToX82/logHappens/issues'>GitHub</a>.
                            </p>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
