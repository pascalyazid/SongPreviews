<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <title>Deezer Search Artist</title>
    <!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script src="script.js" charset="utf-8"></script>
    <!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<link rel="stylesheet" href="style.css">
  </head>
  <body>


    <div class="container">
      <div class="row">
        <div class="col-5">
          <h1>Search Artist on Deezer</h1>


        </div>
        <div class="col-5">

        </div>
        <div class="col-1">

          <a href="https://github.com/pascalyazid/DeezerArtist" target="_blank">Github: pascalyazid</a>
        </div>
      </div>

    </div>
    <div class="container">
      <nav class="navbar navbar-light bg-light">
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" class="form-inline">
          <div class="container">
            <div class="row">
              <div class="col-5">
                <input class="form-control mr-sm-2" type="text" placeholder="Artist" name="artist">
              </div>
              <div class="col-1">
                <input type="submit" name="submit" value="Search" class="btn btn-outline-success my-2 my-sm-0" onclick="printSongs()">
              </div>
              <div class="col-1">
              </div>
            </div>
          </div>
        </form>

      </nav>
    </div>
    <audio id="audio">
      <source src="default.mp3" type="audio/mpeg">
    </audio>
    <div class="position-fixed bottom-0 start-0">
      <form action="javascript:loadNext()">
        <div class="container">
          <div class="row">
            <div class="col-1">
              <input type="submit" name="submit" value="load Next 25" class="btn btn-outline-success my-2 my-sm-0">
            </div>
            <div class="col-1">
            </div>
          </div>
        </div>
      </form>
      </div>

    </div>


<?php
  session_start();
  $trackCounter = 0;
//Song object to retrieve the data.

  // Function that prints all the songs with  a hyperlink to the song preview.

  function printSongs($data, $trackCounter) {
    $data = trim($data);
    $data = stripslashes($data);
    $artist = htmlspecialchars($data);

    $artist = str_replace(" ", "+", $artist);
    $url = "https://api.deezer.com/search?q=artist:\"" . $artist . "\"&index=" . $trackCounter;
    $json = file_get_contents($url);
    $json = json_decode($json);
    $total = $json->total;

    if($json->total != 0){
      $_SESSION['data'] = $artist;
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

        echo "<tr>";
          echo "<td scope=\"row\">";
          echo "<div class=\"col-2\">". $artistNow . "</div>";
          echo "</td>";
        foreach ($json->data as $key => $value) {
          //echo $trackCounter;

            echo "<tr>";
              echo "<td scope=\"row\">";
                echo"<img src=\"" . $value->album->cover_medium . "\">";
              echo "</td>";

              echo "<td scope=\"row\"  class='align-middle'>" . $value->artist->name . " - " . $value->title_short . "</td>";


              echo "<td scope=\"row\">";
              echo "<button class='btn btn-info' onclick='setSRC(\"" . $value->preview . "\");'>Play</button>";
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
    return $trackCounter;
  }

//Takes the Request from the form, creates the song object and lists the songs.

  if ($_SERVER["REQUEST_METHOD"] == "POST") {

      $trackCounter = printSongs($_POST["artist"], $trackCounter);
  }



?>
  </body>
</html>
