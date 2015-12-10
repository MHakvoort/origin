<?php

class BandsMusic
{
    public
    function addVideo($video, $band)
    {
        $con = new Config();
        $con = $con->connectDB();

        $date = new DateTime();
        $date = $date->format('Y-m-d h:i:s');

        $sql = "INSERT INTO bands_music
                (bands_id, url, date_created )
                VALUES
                ('$band', '$video', '$date')";

        $stmt = $con->prepare($sql);
        $stmt->execute();

        return $con->lastInsertId();
    }

    public
    function getVideo($band)
    {
        $con = new Config();
        $con = $con->connectDB();

        $sql = "SELECT *
                FROM bands_music
                 WHERE
                bands_id = ?";

        $stmt = $con->prepare($sql);
        $stmt->execute(array($band));

        $video = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($video) {
            return $video;
        }
    }
}

?>
