<?php
/**
 * Template Name: Video Page
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */

get_header(); ?>

<script src="https://content.jwplatform.com/libraries/mnOGZ6VM.js"></script>
<script>jwplayer.key="H4hkBtBtRtlne6d9bLvUsxwHPyXKJoeaBnnzJQ=="</script>

<style>
.jw-dock-image {
  background-size: 45%;
  opacity: 1;
  }
  
/*  #player {
    transition: width .5s, height .5s, transform .5s;
} */
.content-area {
  width: 100%;
}
  </style>


<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">
		
<div id="player"></div>
<p class="timeContainer"></p>

<div class="player-options">
    <a class="btn red tertiary-sm" href="javascript:resizePlayer()">Resize the Player</a>
</div>

<div id="log" class="well"></div>


<script type="text/JavaScript">
var playerInstance = jwplayer("player");
playerInstance.setup({
    file: "https://player.vimeo.com/external/169925914.hd.mp4?s=34cb6dfa9ccb64846af2b0fb86fbdcfedd3e633a&profile_id=119",
    mediaid: "xxxxYYYY",
    
autostart: false,

tracks: [{
    file:'http://www.video-demo.dev/wp-content/themes/jgtest/chapters.vtt',
    kind:'chapters'
  }],


});

// TIME OFFSET FUNCTION
var timeIntervalUrl = window.location.href + '#t=30';
var playerContainer = document.querySelector('.timeContainer');

function forceRefresh(){
  location.reload();
}

playerContainer.innerHTML = '<a href="' + timeIntervalUrl + '" onclick="forceRefresh()">Click here</a> to reload the page with a time offset of 30 seconds. The link simply appends #t=30 to the URL.'

var offset;
var shouldPlay;


if(window.location.hash) {
     offset = window.location.hash.substr(3);
     shouldPlay = true;
}

jwplayer("player").on('ready', function(event){
 if(shouldPlay === true){
   jwplayer("player").play();
 }
});

jwplayer("player").on('firstFrame', function() { 
jwplayer("player").seek(offset)
});

// RESIZING FUNCTION

function resizePlayer() {
    if (playerInstance.getWidth() > 674) {
        playerInstance.resize(640, 360);
    } else {
        playerInstance.resize(1200, 675);
    }
}

// RESUME PLAYBACK ON VIDEO

playerInstance.on('time', function(e) {
    $cookie.setItem('resumevideodata-115', Math.floor(e.position) + ':' + playerInstance.getDuration());
});

playerInstance.on('ready', function() {    
    var cookieData = $cookie.getItem('resumevideodata-115');
    if(cookieData) {
        var resumeAt = (cookieData.split(':')[0])-10,
            videoDur = cookieData.split(':')[1];
        if(parseInt(resumeAt) < parseInt(videoDur)) {



playerInstance.seek(resumeAt);   





            logMessage('Resuming at ' + resumeAt); //for demo purposes            
        }
        else if(cookieData && !(parseInt(resumeAt) < parseInt(videoDur))) {
            logMessage('Video ended last time! Will skip resume behavior'); //for demo purposes            
        }        
    }
    else {
        logMessage('No video resume cookie detected. Refresh page.');
    }
});
</script>

<script type="text/javascript">

/**
* Interface for easily setting/getting cookies
* http://stackoverflow.com/questions/14573223/set-cookie-and-get-cookie-with-javascript
**/
	
var $cookie = {
    getItem: function(sKey) {
        return decodeURIComponent(document.cookie.replace(new RegExp("(?:(?:^|.*;)\\s*" + encodeURIComponent(sKey).replace(/[\-\.\+\*]/g, "\\$&") + "\\s*\\=\\s*([^;]*).*$)|^.*$"), "$1")) || null;
    },
    setItem: function(sKey, sValue, vEnd, sPath, sDomain, bSecure) {
        if (!sKey || /^(?:expires|max\-age|path|domain|secure)$/i.test(sKey)) {
            return false;
        }
        var sExpires = "";
        if (vEnd) {
            switch (vEnd.constructor) {
                case Number:
                    sExpires = vEnd === Infinity ? "; expires=Fri, 31 Dec 9999 23:59:59 GMT" : "; max-age=" + vEnd;
                    break;
                case String:
                    sExpires = "; expires=" + vEnd;
                    break;
                case Date:
                    sExpires = "; expires=" + vEnd.toUTCString();
                    break;
            }
        }
        document.cookie = encodeURIComponent(sKey) + "=" + encodeURIComponent(sValue) + sExpires + (sDomain ? "; domain=" + sDomain : "") + (sPath ? "; path=" + sPath : "") + (bSecure ? "; secure" : "");
        return true;
    },
    removeItem: function(sKey, sPath, sDomain) {
        if (!sKey || !this.hasItem(sKey)) {
            return false;
        }
        document.cookie = encodeURIComponent(sKey) + "=; expires=Thu, 01 Jan 1970 00:00:00 GMT" + (sDomain ? "; domain=" + sDomain : "") + (sPath ? "; path=" + sPath : "");
        return true;
    },
    hasItem: function(sKey) {
        return (new RegExp("(?:^|;\\s*)" + encodeURIComponent(sKey).replace(/[\-\.\+\*]/g, "\\$&") + "\\s*\\=")).test(document.cookie);
    },
    keys: /* optional method: you can safely remove it! */ function() {
        var aKeys = document.cookie.replace(/((?:^|\s*;)[^\=]+)(?=;|$)|^\s*|\s*(?:\=[^;]*)?(?:\1|$)/g, "").split(/\s*(?:\=[^;]*)?;\s*/);
        for (var nIdx = 0; nIdx < aKeys.length; nIdx++) {
            aKeys[nIdx] = decodeURIComponent(aKeys[nIdx]);
        }
        return aKeys;
    }
};

var logMessage = function(message) {
    document.getElementById('log').innerHTML += message += '<br />';
}

</script>





			</main><!-- .site-main -->

	<?php get_sidebar( 'content-bottom' ); ?>

</div><!-- .content-area -->

<?php get_footer(); ?>
