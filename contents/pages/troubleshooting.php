<div class="row">
    <div class="col s8 offset-s2">
        <h5>Troubleshooting</h5>

        <ul class="collapsible">
            <li>
                <div class="collapsible-header active grey lighten-2"><i class="material-icons">lens</i>LogHappens can't read log files!</div>
                <div class="collapsible-body">
                    <p>By default, apache log files are not readable by apache itself. Which is a good thing, at least on a production server. If you are on a development machine though you should give those files the correct permissions if you want to use LogHappens.</p><p>Here's how:</p>

                    <ul class="browser-default bullet-list">
                        <li>Edit /etc/logrotate.d/apache2, find the line saying create 640 root adm and replace with create 777 root adm.</li>
                        <li>Add 777 permissions to the apache logs directory: sudo chmod -R 777 /var/log/apache2/</li>
                    </ul>
                </div>
            </li>
            <li>
                <div class="collapsible-header grey lighten-2"><i class="material-icons">lens</i>How can I tell LogHappens to track a new log file?</div>
                <div class="collapsible-body">
                    <p>Telling LogHappens to track a new log is fairly easy. All you need to do is add a new parser in the <i>logics</i> folder. You can create the parser
                        by copying a file from <i>logics_templates</i>. If none of the templates suits your needs you will have to create a new parser,
                        by using one of the templates as a boilerplate.
                    </p>
                    <p>
                        Remember though that wether you copy a file from the <i>logic_templates</i> or you create a new one, you will have to edit at least the
                        <i>$menu</i> array at the top of the file according to your needs (ie. log file path, name etc.).
                    </p>
                </div>
            </li>
        </ul>
    </div>
</div>
