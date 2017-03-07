<div class="row">
    <div class="col s8 offset-s2">
        <h5>Bug happens...</h5>
        <p>
            Every developer knows that. The nasty thing is that
            if you want to see what happened, you have to crawl between hundred
            lines log files, written in txt format, with no options to see them
            in an easier format, perhaps grouped by time.
        </p>

        <h5>That's why LogHappens exists</h5>
        <p>
            LogHappens aims to fix this lack. It is a simple tool, it will not
            try to avoid writing bugs, but it will notify you immediately when
            something has been logged by your web server or your favourite
            framework.
        </p>

        <h5>Does it handle different log formats?</h5>
        <p>
            Of course it does. While it is true that every software has its own
            bugs, every software have its own way of logging things too. This is
            why I have tried to make it as simple as possible to let you create
            your own routine for reading log files. No fancy regex strings: if
            you just want to read the file, you can group log entries by date/time
            and print the rest of the file. If you are feeling adventurous, you
            can possibly do whatever you want: highlight words, create tags, split
            errors... the only limit is your fantasy. Which is unlimited, isn't it? ;)
            <br><br>
            This is an example of an apache 2.4 log file reader:
            <pre style="font-size: 13px; border: 1px solid #aaa; padding: 10px;">
    $content = <span style="color:#400000;">file</span>(<span style="color:#0000e6;">"/var/log/apache2/error.log"</span>);

    <span style="color:#797997;">$log</span> = [];
    <span style="color:#400000;font-weight: bold;">foreach</span> (<span style="color:#797997;">$content</span> <span style="color:#400000;font-weight: bold;">as</span> <span style="color:#797997;">$line</span>) {
        <span style="color: #555;">// Grab the log's time and group logs by time</span>
        <span style="color:#797997;">$time</span> = <span style="color:#400000;">substr</span>(<span style="color:#797997;">$line</span>, <span style="color:#008c00;">1</span>, <span style="color:#008c00;">19</span>);

        <span style="color: #555;">// Remove date-time from the log details</span>
        <span style="color:#797997;">$line</span> = <span style="color:#400000;">substr</span>(<span style="color:#797997;">$line</span>, <span style="color:#008c00;">34</span>);
        <span style="color:#797997;">$line</span> = <span style="color:#400000;">trim</span>(<span style="color:#797997;">$line</span>);

        <span style="color: #555;">// Save the log entry</span>
        <span style="color:#797997;">$log</span>[<span style="color:#797997;">$time</span>][] = <span style="color:#797997;">$line</span>;
    }

    <span style="color: #555;">// Reverse the logs, so that we can see last errors first</span>
    <span style="color:#797997;">$logs</span> = <span style="color:#400000;">array_reverse</span>(<span style="color:#797997;">$log</span>);</pre>
            If it looks simple, it's because it is actually simple. What you see
            is a basic configuration, which outputs something like this:
            <img src="images/logHappened.png" alt="log example">
        </p>

        <h5>Future plans?</h5>
        <p>
            While not currently supported, I am planning to add support for remote
            logs too. Maybe through SFTP, I don't know yet... I'm open for ideas!
        </p>
    </div>
</div>
