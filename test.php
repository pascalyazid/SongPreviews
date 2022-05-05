
<?php
session_start();
$data = $_SESSION['data'];
$data = stripslashes($data);
$artist = htmlspecialchars($data);
$trackCounter = $_SESSION['counter'];
$artist = str_replace(" ", "+", $artist);
$url = "https://api.deezer.com/search?q=artist:\"" . $artist . "\"&index=" . $trackCounter;
$json = file_get_contents($url);
$json = json_decode($json);
$total = $json->total;

if($json->total != 0){
    if($trackCounter < 25){
        $artistNow = str_replace("+", " ", urldecode($artist));
      }
    echo "<div class='container'>";
    echo "<div class='row'>";
    echo "<div class='col-4'>";
    echo "</div>";
    echo "<div class='col'>";

    echo "<table class='table'>";
    echo "<thead><tr><th></th><th></th><th></th></tr></thead>";
    echo "<tbody>";

    foreach ($json->data as $key => $value) {
      //echo $trackCounter;

        echo "<tr>";
          echo "<td scope=\"row\">";
            echo"<img src=\"" . $value->album->cover_medium . "\">";
          echo "</td>";

          echo "<td scope=\"row\"  class='align-middle'>" . $value->artist->name . " - " . $value->title_short . "</td>";


          echo "<td scope=\"row\">";
          echo "<button onclick='setSRC(\"" . $value->preview . "\");'>Play</button>";
          echo "</td";

        echo "</tr>";
      $trackCounter = $trackCounter + 1;
      $_SESSION['counter'] = $trackCounter;
    }
    echo "</tbody></table>";
    echo "</div>";
    echo "<div class='col-3'></div>";
    echo "</div>";
    echo "</div>";
}

else {

  //When nothing is found by the search parameter, the following message is shown.

  if($trackCounter < 25) {
    $artistNow = str_replace("+", " ", urldecode($artist));
    echo "<div class=\"container\">" . "<br> Nothing found by " . $artistNow . "</div>";
  }
}
 ?>
