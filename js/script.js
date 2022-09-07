$(document).ready(function() {
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
