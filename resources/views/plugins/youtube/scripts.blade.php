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

//    function stopVideos() {
//        for(var yts in yt){
//            if(typeof yt[yts].stopVideo == 'function'){
//                yt[yts].stopVideo();
//            }
//        }
//    }

//    $(function () {
//        var next = $('.next');
//        var back = $('.back');
//
//        next.click(function () {
//            yt.stopVideo();
//            yt.destroy();
//            var to = this.dataset.to;
//            var videoId;
//            to == 1 ? videoId = 'bLGRLSz-uxU' : videoId = 'zG2iwIMkYRM';
//            yt = new YT.Player('yt'+to, {
//                height: '315',
//                width: '560',
//                videoId: videoId,
//                playerVars: {'rel':0, 'showinfo':0},
//                events: {
//                    'onReady': onPlayerReady
//                }
//            });
//        });
//
//        back.click(function () {
//            yt.stopVideo();
//            yt.destroy();
//            var to = this.dataset.to;
//            var videoId;
//            to == 1 ? videoId = 'bLGRLSz-uxU' : videoId = 'yi07gkcQcRQ';
//            yt = new YT.Player('yt'+to, {
//                height: '315',
//                width: '560',
//                videoId: videoId,
//                playerVars: {'rel':0, 'showinfo':0},
//                events: {
//                    'onReady': onPlayerReady
//                }
//            });
//        });
//    });



</script>