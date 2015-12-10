<?php

class Genres {
    public function get_all()
    {
        $con = new Config();
        $con = $con->connectDB();

        $sql = "SELECT * FROM genres";
        $stmt = $con->prepare($sql);
        $stmt->execute();

        $genres = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($genres) {
            return $genres;
        }
    }
}
