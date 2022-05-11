<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=0.75, maximum-scale=1, user-scalable=no">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <title>Song Previews</title>
    <!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script src="/js/script.js" charset="utf-8"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<link rel="stylesheet" href="/css/style.css">
<link rel="icon" href="/data/favicon.svg">
  </head>
  <body>

        <audio id="audio">
          <source src="/data/default.mp3" type="audio/mpeg">
        </audio>

        <div class="position-fixed bottom-0 end-0">
          <form action="javascript:loadNext()">
            <div class="container">
              <div class="row">
                <div class="col-1">
                  <input type="submit" name="submit" value="load Next 25" class="btn btn-outline-success my-2 my-sm-0">
                </div>
                <div class="col-4">
                </div>
              </div>
            </div>
          </form>
        </div>

        <div class="container">

          <div class="row">
            <div class="col"></div>
            <div class="col d-flex justify-content-center">
              <h1>Song Previews</h1>
            </div>
            <div class="col"></div>
          </div>

          <div class="row">
            <div class="col"></div>
            <div class="col">


                <nav class="navbar navbar-light bg-light">
                  <div class="container-fluid">
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" class="d-flex">
                      <div class="container">
                        <div class="d-flex justify-content-center">
                          <div class="p-2 flex-fill">
                            <input class="form-control me-5" type="text" placeholder="Search" name="artist">
                          </div>
                          <div class="p-2 flex-fill">
                            <input type="submit" name="submit" value="Search" class="btn btn-outline-success" onclick="printSongs()">
                          </div>
                        </div>
                      </div>
                    </form>
                  </div>
                </nav>

            </div>
            <div class="col"></div>
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
                  $url = "https://api.deezer.com/search?q=\"" . $artist . "\"&index=" . $trackCounter;
                  $json = file_get_contents($url);
                  $json = json_decode($json);
                  $total = $json->total;

                  if($json->total != 0){
                    $_SESSION['data'] = $artist;
                      if($trackCounter < 25){
                          $artistNow = str_replace("+", " ", urldecode($artist));
                        }

                      echo "<h1 class='d-flex justify-content-center'>" . $artistNow . "</h1>";

                      echo "<div class='row'>";
                      echo "<div class='col'></div>";
                      echo "<div class='col'>";
                      echo "<div class='container'>";
                      echo "<table class='table'>";
                      echo "<thead><tr><th></th><th></th><th></th></tr></thead>";
                      echo "<tbody>";

                      echo "<tr>";
                        echo "<td scope=\"row\">";
                        echo "</td>";
                      foreach ($json->data as $key => $value) {
                        //echo $trackCounter;

                          echo "<tr>";
                            echo "<td scope=\"row\">";
                              echo"<img src=\"" . $value->album->cover_medium . "\">";
                            echo "</td>";

                            echo "<td scope=\"row\"  class='align-middle'>" . $value->artist->name . " - " . $value->title_short . "</td>";


                            echo "<td scope=\"row\" class='align-middle'>";
                            echo "<button class='btn btn-info align-self-center' onclick='setSRC(\"" . $value->preview . "\");'>Play</button>";
                            echo "</td";

                          echo "</tr>";
                        $trackCounter = $trackCounter + 1;
                        $_SESSION['counter'] = $trackCounter;
                      }
                      echo "</tbody></table>";
                      echo "</div>";
                      echo "</div>";
                      echo "<div class='col'></div>";
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

          </div>

  </body>
</html>
