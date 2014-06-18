(function ($, window) {

    var defaults = {
        ratio: 16/9, // usually either 4/3 or 16/9 -- tweak as needed
        videoId: 'ZCAnLxRvNNc', // toy robot in space is a good default, no?
        mute: false,
        repeat: true,
        width: jQuery(window).width(),
        wrapperZIndex: 1,
        start: 0,
        poster:'',
        stop:'',
    };

    var tubular = function(node, options) { // should be called on the wrapper div
        var options = $.extend({}, defaults, options),
            $node = jQuery(node); // cache wrapper node
        var rand = Math.floor(Math.random()*90000) + 10000;
        if(options.poster!=''){
            options.poster='<img src='+options.poster+' alt="video_poster"/>'
        }         
        var tubularContainer = '<div id="tubular-container'+rand+'" style="overflow: hidden; z-index: 1; width: 100%; height: 100%"><div id="tubular-player'+rand+'">'+options.poster+'</div></div><div id="tubular-shield'+rand+'" style="width: 100%; height: 100%; z-index: 2; "></div>';

        //options.width = jQuery(node).width() - 300;
        //console.log(options);
        //console.log(jQuery(node).outerWidth());
        $node.prepend(tubularContainer);
        $node.css({position: 'absolute', 'z-index': options.wrapperZIndex});
        window.player;
        window.onYouTubeIframeAPIReady = function() {
            player = new YT.Player('tubular-player'+rand+'', {
                //width: options.width,
               // height: Math.ceil(options.width / options.ratio),
                videoId: options.videoId,
                playerVars: {
                    controls: 0,
                    showinfo: 0,
                    modestbranding: 1,
                    wmode: 'transparent',
                    autoplay:0,                    
                    disablekb:1,
                    end:options.stop,
                    fs:0,
                    iv_load_policy:0,
                    rel:0,
                    showinfo:0,
                    start:options.start,
                },
                events: {
                    'onReady': onPlayerReady,
                    'onStateChange': onPlayerStateChange
                }
            });
            jQuery('#tubular-player'+rand).attr('src',jQuery('#tubular-player'+rand).attr('src')+'&end='+options.stop)

        }

        window.onPlayerReady = function(e) {
            resize();
            if (options.mute) e.target.mute();
            e.target.seekTo(options.start);
            e.target.playVideo();
        }

        window.onPlayerStateChange = function(state) {
            if (state.data === 0 && options.repeat) { // video ended and repeat option is set true
                player.seekTo(options.start); // restart
            }
        }
        var resize = function() {
            var width = jQuery(node).outerWidth();
            var height = (width*9)/16;
            var width = jQuery(node).width();
            var tubularPlayer = jQuery('#tubular-player'+rand+'');
            tubularPlayer.css({'width':width+'px','height':height});
            if(jQuery(node).outerHeight() > tubularPlayer.outerHeight()){
                height = jQuery(node).outerHeight();
                width = (height*16)/9;
                tubularPlayer.css({'width':width+'px','height':height});
            }
        }
        jQuery(window).on('resize.tubular', function() {
            resize();
        })
    }
    var tag = document.createElement('script');
    tag.src = "//www.youtube.com/iframe_api";
    var firstScriptTag = document.getElementsByTagName('script')[0];
    firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

    $.fn.tubular = function (options) {
        return this.each(function () {
                $.data(this, 'tubular_instantiated', 
                tubular(this, options));
        });
    }
})(jQuery, window);
//if ( ! jQuery.browser.mobile){
    jQuery(document).ready(function(){
        jQuery('.upb_video_class .utube').each(function(){
           // jQuery(this).bsf_appear(function(){
                var selector = jQuery(this);
                var uvdo = selector.data('vdo');        
                var umuted =selector.data('muted');
                var uloop =selector.data('loop');               
                var uposter =selector.data('poster');       
                var ustart = selector.data('start');
                var ustop = selector.data('stop');
                var options = { videoId: uvdo, start: ustart, mute:umuted,repeat:uloop, poster:uposter, stop:ustop };             
                selector.tubular(options);    
                })
          //  })
    })
//}