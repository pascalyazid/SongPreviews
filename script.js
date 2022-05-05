$(document).ready(function() {
});

function loadNext() {
  $.get("next.php", function(data){
    document.body.innerHTML = (document.body.innerHTML + data);
  });
}

function setSRC(url) {
  let audio = document.getElementById('audio');
  audio.pause();
  audio.src = url;
  audio.play();
}
