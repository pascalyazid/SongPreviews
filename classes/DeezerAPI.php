<?php

class DeezerAPI {
    private $baseUrl = "https://api.deezer.com/search";

    public function searchQuery($query, $index = 0) {
        $queryEncoded = urlencode(trim(stripslashes($query)));
        $url = $this->baseUrl . "?q=\"" . $queryEncoded . "\"&index=" . $index;

        $json = @file_get_contents($url);
        if ($json === false) {
            return null;
        }

        return json_decode($json);
    }
}
