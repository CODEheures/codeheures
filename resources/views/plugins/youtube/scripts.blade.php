<script type="text/javascript">
    // 2. This code loads the IFrame Player API code asynchronously.
    var tag = document.createElement('script');

    tag.src = "https://www.youtube.com/iframe_api";
    var firstScriptTag = document.getElementsByTagName('script')[0];
    firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

    // 3. This function creates an <iframe> (and YouTube player)
    //    after the API code downloads.
    var yt;
    function onYouTubeIframeAPIReady() {
        yt = new YT.Player('yt0', {
            height: '315',
            width: '560',
            videoId: 'KGbQIQVFO_w',
            playerVars: {'rel':0, 'showinfo':0},
            events: {
                'onReady': onPlayerReady
            }
        });
    }
    
    function onPlayerReady(event) {
        event.target.setVolume(100);
    }
</script>