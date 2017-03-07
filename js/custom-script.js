$(document).ready(function() {

    /*
    * Side nav
    */
    $(".button-collapse").sideNav();

    /*
    * Select box
    */
    $('select').material_select();
    $("select").on("change", function() {
        var length = $(this).val();
        var url = "ajax.php?page=set_pagelength&length=" + length;
        $.ajax({
            method: "GET",
            url: url
        })
        .done(function() {
            window.location.reload();
        });
    });

    /*
    * Live reloading
    */
    var currentUrl = "?" + window.location.search.substring(1);

    $(".side-nav a[data-tofollow=true]").each(function() {
        var $link = $(this);
        var link = $link.attr("href");
        var action = link.replace("log_reader", "log_counter");

        if (currentUrl == link) {
            var linkName = $link.attr("data-name");
            $(".logs-list h5").html(linkName);
        }

        recount(link, action, false);

        setInterval(function() {
            recount(link, action, true);
        }, 5000);
    });
    var currentUrl = "?" + window.location.search.substring(1);


    function recount(link, action, push) {
        var $link = $(".side-nav a[href='" + link + "']");
        var $badge = $link.find(".badge");
        var howMany = $link.attr("data-howmany");

        $.ajax({
            url: "ajax.php" + action,
        }).done(function(howManyNew) {
            if (howManyNew !== howMany) {
                var difference = parseInt(howManyNew) - parseInt(howMany);
                if (push === true) {

                    Push.create('LogHappens!', {
                        body: $link.attr("data-name") + ": " + difference + " new logs!",
                        icon: {
                            x16: 'images/logo.png',
                            x32: 'images/logo.png'
                        },
                        link: $link.attr("href"),
                        timeout: 5000
                    });

                    if (currentUrl == link) {
                        var linkName = $link.attr("data-name");
                        reloadContent(link, linkName);
                    }
                    $badge.addClass("new");
                }

                $badge.html(difference);
                $link.attr("data-howmany", howManyNew);
            } else {
                howMany = $link.attr("data-howmany");
                $badge.html(howMany);
                $badge.removeClass("new");
            }
        });
    }

    function reloadContent(link, linkName, time) {
        setInterval(function() {
            var howMany = $(".logs-list").attr("data-rows");

            $(".log-container").load("ajax.php" + link, function() {
                $(".logs-list h5").html(linkName);
            });
        }, 5000);
    }
});
