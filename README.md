logHappens!
=============
[![Code Climate](https://codeclimate.com/github/ToX82/logHappens/badges/gpa.svg)](https://codeclimate.com/github/ToX82/logHappens)

[Website](https://tox82.github.io/logHappens/)

Bug happens 💩 Every developer knows that. The bad thing is that if you want to see what happened you have to analyze hundreds of lines of log files, written in a format that is anything but human friendly.


##### That's why LogHappens exists!

LogHappens aims to fix exactly this. It's a simple tool that will not prevent you from writing bugs, but it will notify you immediately when something has been logged by your web server, or your favorite framework.


##### Does it handle different log formats?

Of course it does. Every software has its own bugs, and every software has its own way of logging things too. This is why I have tried to make it as simple as possible to let you create your own routine for reading log files, while still providing a few log default parsers that you can immediately use.


##### How do I add a log file to be tracked?

Adding a new file to be tracked is fairly simple with LogHappens. Just add a new record in your config.json file, and set the values according to your preferences. Something like this is enough.

    "apache": {
        "icon": "logos:apache",
        "color": "#104B73",
        "title": "Apache error",
        "file": "/var/log/apache2/error.log",
        "parser": "apache24"
    }

Please visit [iconify.design](https://iconify.design/icon-sets) for more icons.


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
Yes sir! It's not a LogHappens specific function actually, but you could use something [like this](https://gist.github.com/ToX82/20134e5006823360f87ee2b54b95b681) to capture client side JavaScript errors


##### Can I share a new parser file?

Of course! As you can see, there are `apache24`, `CakePHP 3.x` and `CodeIgniter` files in the `parsers` folder. If you have created your own parser, please send it to me and I will be more than happy to include it!


##### What does it look like?

![It looks like this](https://user-images.githubusercontent.com/659492/110930874-eb544b80-8329-11eb-9877-5c86fce0e2ee.png)
