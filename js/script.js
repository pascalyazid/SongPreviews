$(document).ready(function() {
  var banner_height = $("#navscroll").height();
  var lastScrollTop = 0;
  $(window).scroll(function() {
    var scroll = $(window).scrollTop();
    var currScrollTop = $(this).scrollTop();
    if (scroll >= banner_height && currScrollTop > lastScrollTop) {
      $("#banner").hide();
    } else {
      $("#banner").show();
    }
    lastScrollTop = currScrollTop;

  });
  if ( window.history.replaceState ) {
    window.history.replaceState( null, null, window.location.href );
  }
});

function loadNext() {
  $.get("next.php", function(data){
    document.body.innerHTML = (document.body.innerHTML + data);
  });
}

function setSRC(url) {
  let audio = document.getElementById('audio');
  audio.volume = 0.3;
  let button = document.getElementById(url);

  if(button.innerHTML == "Play") {
    if(audio.src != "") {
      let old = document.getElementById(audio.src);
      if (old.innerHTML = "Pause") {
        audio.pause;
        old.innerHTML = "Play";
      }
    }

    audio.src = url;
    audio.play();
    button.innerHTML = "Pause";
  }


  else if(button.innerHTML =="Pause") {
    audio.pause();
    button.innerHTML = "Play";
  }
  else {

  }



}

function initPlayerTest() {
  DZ.init({
  appId  : '	540582',
  channelUrl : 'http://localhost:80/SongPreviews/index.php',
  player : {
    onload : function(){
    }
  }
});
}

https://api.npoint.io/7f52a96761f6502449cf
AIzaSyAow-gR3drjiGZ3I5QDztrOTB4cPQ_xdKc
Nzc5MzAzMzA1NTIwMjE4MTIz.GB07Xf.RPHmUDN9p-H07MfngliMeYFZ8xUD3KRoFlPCf8
