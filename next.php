
<?php
echo "<div class='container'>";
echo "<div class='row'>";
  echo "<div class='col'></div>";
  echo "<div class='col'>";

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
    echo "<table class='table'>";
    echo "<thead><tr><th></th><th></th><th></th></tr></thead>";
    echo "<tbody>";

    echo "<tr>";
      echo "<td scope=\"row\">";
      echo "</td>";
    foreach ($json->data as $key => $value) {


        echo "<tr>";
          echo "<td scope=\"row\">";
            echo"<img src=\"" . $value->album->cover_medium . "\">";
          echo "</td>";

          echo "<td scope=\"row\"  class='align-middle'>" . $value->artist->name . " - " . $value->title_short . "</td>";


          echo "<td scope=\"row\" class='align-middle'>";
        echo "<button class='btn btn-info align-self-center' onclick='setSRC(\"" . $value->preview . "\");' id='" . $value->preview . "'>Play</button>";
          echo "</td";

        echo "</tr>";
      $trackCounter = $trackCounter + 1;
      $_SESSION['counter'] = $trackCounter;
    }
    echo "</tbody></table>";
    echo "</div>";
    echo "</div>";
    echo "<div class='col'>";
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
