<div class="row">
    <div class="col-8 offset-2">
        <div class="card border-secondary mb-3">
            <div class="card-header">
                Ooops, that's embarassing...
            </div>
            <div class="card-body">
                <p>I can't create the config.json file for you. But don't worry 🙂<br>
                It's probably just a permissions issue, you can do it yourself
                by manually renaming the config.default.json file to config.json and
                giving it write permissions.<br>
                I'll be here for you, and as soon as I will be able to see the file, I'll let you proceed.</p>
            </div>
        </div>
    </div>
</div>

<script>
setInterval(function() {
    document.location = $('.baseUrl').html() + '/configurations';
}, 3000);
</script>
