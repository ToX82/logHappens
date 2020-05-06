logHappens!
=============
[![Code Climate](https://codeclimate.com/github/ToX82/logHappens/badges/gpa.svg)](https://codeclimate.com/github/ToX82/logHappens)

Bug happens 💩 Every developer knows that. The bad thing is that if you want to see what happened, more often than not you have to crawl between hundred lines log files, written in a format which is all but human friendly.


##### That's why LogHappens exists!

LogHappens aims to fix exactly this. It is a simple tool, it will not prevent you from writing bugs, but it will notify you immediately when something has been logged by your web server or your favorite framework.


##### Does it handle different log formats?

Of course it does. Every software has its own bugs, and every software have its own way of logging things too. This is why I have tried to make it as simple as possible to let you create your own routine for reading log files. No fancy regex strings: if you just want to read the file, you can group log entries by date/time and print the rest of the file. If you are feeling adventurous, you can possibly do whatever you want: highlight words, create tags, split errors... the only limit is your fantasy.


##### How do I add a log file to be tracked?

Tracking new file is fairly simple with LogHappens. Just add a new record in your config.json file, and set the values according to your preferences. Something like this is enough.

    "apache": {
        "icon": "logos:apache",
        "color": "#104B73",
        "title": "Apache error",
        "file": "/var/log/apache2/error.log",
        "parser": "apache24"
    }

Please visit [iconify.design](https://iconify.design/icon-sets/?query=logos%3Aapache) for more icons.


#### Can I track a remote file (I.E. through a URL)?
If you are not worried for the security issues of having an error log publicly reachable, then yes. Just set the URL in the configuration path.

    "myExampleSite": {
        "icon": "wpf-online",
        "color": "#104B73",
        "title": "My ExampleSite Errors",
        "file": "https://example.com/logs/error.log",
        "parser": "cakephp3"
    }


##### Can I capture the browser's JavaScript errors too?
Yes sir! Though it is not a LogHappens specific function you could use something [like this](https://gist.github.com/ToX82/20134e5006823360f87ee2b54b95b681) to capture client side JavaScript errors


##### Can I share a new parser file?

Of course! As you can see, there are `apache24`, `CakePHP 3.x` and `CodeIgniter` files in the `parsers` folder. If you have created your own routine, please send it to me, I will be more than happy to add it to the other parsers!


##### What does it look like?

![It looks like this](https://user-images.githubusercontent.com/659492/74713643-4439d900-5229-11ea-938d-63ce808ea6fd.png)
