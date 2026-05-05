<?php

class SongRenderer {
    public static function renderList($data, &$trackCounter, $artistName) {
        if (!$data || $data->total == 0) {
            if ($trackCounter < 25) {
                $artistDecoded = htmlspecialchars(stripslashes($artistName));
                return "<div class='container mt-5 text-center'><h4>Nothing found for \"{$artistDecoded}\"</h4></div>";
            }
            return "";
        }

        $html = "";

        // Add Title if it's the first page
        if ($trackCounter < 25) {
            $artistDecoded = htmlspecialchars(stripslashes($artistName));
            $html .= "<h3 class='d-flex justify-content-center pt-5 mb-4'>{$artistDecoded}</h3>";
        }

        $html .= "<div class='row'>";
        $html .= "<div class='col-md-2'></div>";
        $html .= "<div class='col-md-8'>";
        $html .= "<div class='table-responsive'>";
        $html .= "<table class='table table-hover align-middle'>";
        $html .= "<tbody>";

        foreach ($data->data as $value) {
            $cover = htmlspecialchars($value->album->cover_medium);
            $artist = htmlspecialchars($value->artist->name);
            $title = htmlspecialchars($value->title_short);
            $preview = htmlspecialchars($value->preview);

            $html .= "<tr>";
            $html .= "<td style='width: 80px;'><img src='{$cover}' class='img-thumbnail' alt='cover' width='70'></td>";
            $html .= "<td><strong>{$artist}</strong> - {$title}</td>";
            $html .= "<td class='text-end'>";
            $html .= "<button class='btn btn-primary play-btn' onclick='setSRC(\"{$preview}\", this);' data-src='{$preview}'>Play</button>";
            $html .= "</td>";
            $html .= "</tr>";

            $trackCounter++;
        }

        $html .= "</tbody></table>";
        $html .= "</div>"; // end table-responsive
        $html .= "</div>"; // end col
        $html .= "<div class='col-md-2'></div>";
        $html .= "</div>"; // end row

        return $html;
    }
}
