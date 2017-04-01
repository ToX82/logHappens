logHappens!
=============

Bug happens. Every developer knows that. The nasty thing is that if you want to see what happened, you have to crawl between hundred lines log files, written in txt format, with no options to see them in an easier format, perhaps grouped by time.


##### That's why LogHappens exists!

LogHappens aims to fix this lack. It is a simple tool, it will not prevent you from writing bugs, but it will notify you immediately when something has been logged.


##### Does it handle different log formats?

Of course it does. While it is true that every software has its own bugs, every software have its own way of logging things too. This is why I have tried to make it as simple as possible to create your own routine for reading log files. No fancy regex strings: if you just want to read the file, you can write a small php routine and group log entries by date/time, just printing the rest of the file. If you are feeling adventurous, you could possibly do whatever you want: highlight words, create tags, split errors... the only limit is your fantasy!


##### How do I add a log file to be tracked?

You can use one of the files you see in the `logic_templates` folder. Edit it according to your needs (e.g. the log path). Move it to the `logic` folder and refresh the page. Voilà. Use as much logics as you like to track more log files, and edit the way they group logs according to your needs. It should be pretty easy, isn't it?


##### Can I share a new template file?

Of course! As you see, I have placed apache24 and CakePHP 3.x log files in the `logic_templates` folder. If you have created your own routine, please send it to me, I will be glad to add it to the other templates!


##### Future plans?

While not currently supported, I am planning to add support for remote logs too. Maybe through SFTP, I don't know yet... I'm open for ideas!


##### What does it look like?

![It looks like this](https://cloud.githubusercontent.com/assets/659492/24559514/47412cee-163f-11e7-91ec-58f61e36ead1.png)
