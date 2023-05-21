logHappens!
=============
[![Code Climate](https://codeclimate.com/github/ToX82/logHappens/badges/gpa.svg)](https://codeclimate.com/github/ToX82/logHappens)

[Website](https://tox82.github.io/logHappens/)

Bug happens 💩 Every developer knows that. The frustrating part is that when you want to figure out what went wrong, you often find yourself sifting through hundreds of lines of log files, written in a format that seems to defy human comprehension.

##### That's why LogHappens exists!

LogHappens is here to solve this very problem. It's a simple tool that won't prevent you from writing bugs, but it will promptly notify you whenever something gets logged by your web server or your favorite framework.


##### Does it handle different log formats?

Of course it does. Every software has its own bugs, and every software has its own unique way of logging events. That's why we've made LogHappens as user-friendly as possible, allowing you to easily create your own log file reading routine. We've even included a few "standard" log parsers that you can use right away.


##### How do I add a log file to be tracked?

Easy peasy! Simply add a new record in your config.json file, and configure the values according to your needs and preferences. This way, LogHappens will start tracking the specified log file effortlessly.

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
        "parser": "cakephp3",
        "disabled": false
    },


##### Can I capture the browser's JavaScript errors too?
Yes sir! It's not a LogHappens specific function actually, but you could use something [like this](https://gist.github.com/ToX82/20134e5006823360f87ee2b54b95b681) to capture client side JavaScript errors


##### Can I share a new parser file?

Absolutely! As you can see, there are `apache24`, `CakePHP 3.x` and `CodeIgniter` files in the `parsers` folder. If you've created your own parser and want to spread the love, please send it our way. We would be more than happy to include it among the other parsers and give credit where credit is due!


##### What does it look like?

![It looks like this](https://user-images.githubusercontent.com/659492/110930874-eb544b80-8329-11eb-9877-5c86fce0e2ee.png)
