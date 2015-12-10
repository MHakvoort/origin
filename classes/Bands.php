<?php

class Bands
{
    public function get($id)
    {
        $con = new Config();
        $con = $con->connectDB();

        $sql = "SELECT * FROM bands
                WHERE bands_id = :id";
        $stmt = $con->prepare($sql);
        $stmt->bindValue("id", $id, PDO::PARAM_STR);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user) {
            return $user;
        }
    }

    public function get_all()
    {
        $con = new Config();
        $con = $con->connectDB();

        $sql = "SELECT *
                FROM bands";
        $stmt = $con->prepare($sql);
        $stmt->execute();

        $bands = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($bands) {
            return $bands;
        }
    }

    public function edit($band, $naam, $genre_id, $woonplaats, $website, $telefoon)
    {
        $con = new Config();
        $con = $con->connectDB();

        $date = new DateTime();
        $date = $date->format('Y-m-d h:i:s');

        $sql = "UPDATE bands
                SET
                naam = ?,
                genre_id = ?,
                website = ?,
                woonplaats = ?,
                telefoon = ?,
                date_changed = ?
                WHERE
                bands_id = ?";

        $stmt = $con->prepare($sql);
        $stmt->execute(array($naam, $genre_id, $website, $woonplaats, $telefoon, $date, $band));

        return true;
    }

    public function add($naam, $genre_id, $website, $woonplaats, $telefoon, $user)
    {
        $con = new Config();
        $con = $con->connectDB();

        $date = new DateTime();
        $date = $date->format('Y-m-d h:i:s');

        $sql = "INSERT INTO bands
                (naam, genre_id, website, woonplaats, telefoon, admin_id, date_created)
                VALUES
                ('$naam', '$genre_id', '$website', '$woonplaats', '$telefoon', '$user', '$date')";
        $stmt = $con->prepare($sql);
        $stmt->execute();

        return $con->lastInsertId();
    }
}
