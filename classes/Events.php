<?php
if (stream_resolve_include_path('../classes/config/Config.php')) {
    include_once('../classes/config/Config.php');
}

class Events
{
    public function get($id)
    {
        $con = new Config();
        $con = $con->connectDB();

        $sql = "SELECT
                    ev.*,
                    et.naam as events_type,
                    g.naam as genre,
                    l.naam as land
                FROM events ev
                JOIN events_type et
                    ON ev.events_type_id = et.events_type_id
                JOIN land l
                    ON ev.land_id = l.land_id
                JOIN genres g
                    ON ev.genre_id = g.genre_id
                WHERE ev.events_id = :event_id";
        $stmt = $con->prepare($sql);
        $stmt->bindValue("event_id", $id, PDO::PARAM_STR);
        $stmt->execute();

        $event = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($event) {
            return $event;
        }
    }

    public function get_all()
    {
        $con = new Config();
        $con = $con->connectDB();

        $sql = "SELECT
                    ev.*,
                    et.naam as events_type,
                    g.naam as genre,
                    l.naam as land
                FROM events ev
                JOIN events_type et
                    ON ev.events_type_id = et.events_type_id
                JOIN land l
                    ON ev.land_id = l.land_id
                JOIN genres g
                    ON ev.genre_id = g.genre_id
                WHERE finished is false";
        $stmt = $con->prepare($sql);
        $stmt->execute();

        $bands = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($bands) {
            return $bands;
        }
    }

    public function add($event_type_id, $genre_id, $land_id, $plaatsnaam, $naam, $omschrijving, $datum, $user)
    {
        $con = new Config();
        $con = $con->connectDB();

        $date = new DateTime();
        $date = $date->format('Y-m-d h:i:s');

        $sql = "INSERT INTO events
                (events_type_id, genre_id, land_id, plaatsnaam, naam, omschrijving, datum, user_id, date_created)
                VALUES
                ('$event_type_id', '$genre_id', '$land_id', '$plaatsnaam', '$naam', '$omschrijving', '$datum', '$user', '$date')";
        $stmt = $con->prepare($sql);
        $stmt->execute();

        return $con->lastInsertId();
    }

    public function edit($event, $event_type_id, $genre_id, $land_id, $plaatsnaam, $naam, $omschrijving, $datum, $user)
    {
        $con = new Config();
        $con = $con->connectDB();

        $date = new DateTime();
        $date = $date->format('Y-m-d h:i:s');

        $sql = "UPDATE events
                SET
                events_type_id = ?,
                genre_id = ?,
                land_id = ?,
                plaatsnaam = ?,
                naam = ?,
                omschrijving = ?,
                datum = ?,
                user_id = ?,
                date_changed = ?
                WHERE
                events_id = ?";
        $stmt = $con->prepare($sql);
        $stmt->execute(array($event_type_id, $genre_id, $land_id, $plaatsnaam, $naam, $omschrijving, $datum, $user, $date, $event));

        return true;
    }

    public function delete($event)
    {
        $con = new Config();
        $con = $con->connectDB();

        $sql = "DELETE FROM events WHERE events_id =  :event";
        $stmt = $con->prepare($sql);
        $stmt->bindParam(':event', $event, PDO::PARAM_INT);
        $stmt->execute();
    }
}
