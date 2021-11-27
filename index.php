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

  </head>
  <body>


    <div class="container">
      <div class="row">
        <div class="col-5">
          <h1>Search Artist on Deezer</h1>
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
                <input type="submit" name="submit" value="Search" class="btn btn-outline-success my-2 my-sm-0">
              </div>
            </div>
          </div>
        </form>
      </nav>
    </div>



<?php

//Song object to retrieve the data.

  class Song {
      public $url;
      public $total;
      public $artist;
      public $json;
      public $trackCounter;

  // Constructor where the json object is set if an artist is found.

  function __construct($artist) {
    $this->artist = str_replace(" ", "+", $artist);
    $this->artist = urlencode($this->artist);
    $this->trackCounter = 0;



  }
  // Getter and Setter.

  function setJSON($json) {
    $this->json = $json;
  }

  function setURL($url) {
    $this->url = $url;
  }

  function setTotal($total) {
    $this->total = $total;
  }

  function setArtist($artist) {
    $this->artist = $artist;
  }

  function setTrackCounter($trackCounter) {
    $this->trackCounter = $trackCounter;
  }

  function getJSON() {
    return $this->json;
  }

  function getTotal() {
    return $this->total;
  }

  function getURL() {
    return $this->url;
  }

  function getArtist() {
    return $this->artist;
  }

  function getTrackCounter() {
    return $this->trackCounter;
  }

  // Function that prints all the songs with  a hyperlink to the song preview.

  function printSongs() {
    $this->artist = str_replace(" ", "+", $this->artist);
    $this->url = "https://api.deezer.com/search?q=artist:\"" . $this->artist . "\"&index=" . $this->trackCounter;
    $this->json = file_get_contents($this->url);
    $this->json = json_decode($this->json);
    $this->total = $this->json->total;
    if($this->json->total != 0){

        echo "<div class=\"container\">";
        echo "<div class=\"row\">";

        if($this->trackCounter < 25){
            $artistNow = str_replace("+", " ", urldecode($this->artist));
            echo "<div class=\"col-2\">" . "Results for : " . $artistNow . "</div>";
          }
        echo "</div>" . "</div>";


        echo "<div class=\"container\">";
        echo "<table class=\"table table-hover\">";
        echo "<thead>" . "<tr>" . "<th scope=\"col\"></th><th scope=\"col\"></th>" . "</tr>" . "</thead>";
        echo "<tbody>";

        foreach ($this->json->data as $key => $value) {
          $this->trackCounter = $this->trackCounter + 1;
          echo "<tr>" . "<th scope=\"row\">" . " <img src=\"" . $value->album->cover_small .  "\" alt=\"Album\"> " . "</th>";
          echo "<th scope=\"row\">" . "<a href=\"" . $value->preview . "\">" . $value->title .  " - " . $value->artist->name .  "</a>" . "</th></tr>";
        }

        echo "</tbody></div>";


    }

    else {

      //When nothing is found by the search parameter, the following message is shown.

      if($this->trackCounter < 25) {
        $artistNow = str_replace("+", " ", urldecode($this->artist));
        echo "<div class=\"container\">" . "<br> Nothing found by " . $artistNow . "</div>";
      }
    }
  }


  }

//Takes the Request from the form, creates the song object and lists the songs.

  if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $artist = test_input($_POST["artist"]);
  }

  function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    $song = new Song($data);
    $song->printSongs();


  }

?>


  </body>
</html>
