<script src="/storage/js/fallback/1.1.9/fallback.min.js"></script>
<script>
    fallback.load({
        // Include your stylesheets, this can be an array of stylesheets or a string!
        global_css: ['{{ asset('css/app.css') }}'],

        jQuery: [
            '//ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js',
            '//cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js',
            '{{ asset('js/jquery/3.5.1/jquery.min.js') }}'
        ],

        'tinymce': [
            '//cdnjs.cloudflare.com/ajax/libs/tinymce/5.5.1/tinymce.min.js'


        ],

        'bootstrap': [
            '//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.3/js/bootstrap.min.js'
        ],

        'font-awesome': [
            'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'
        ],

        callback: function(success, failed) {
            // success - object containing all libraries that loaded successfully.
            // failed - object containing all libraries that failed to load.

            // All of my libraries have finished loading!

            // Execute my code that applies to all of my libraries here!
        }
    });

    fallback.ready(['jQuery', 'tinymce'], function() {
        console.log('Scripts loaded');
    });
</script>








