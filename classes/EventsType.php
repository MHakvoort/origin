<?php

class EventsType {
    public function get_all()
    {
        $con = new Config();
        $con = $con->connectDB();

        $sql = "SELECT * FROM events_type";
        $stmt = $con->prepare($sql);
        $stmt->execute();

        $eventstype = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($eventstype) {
            return $eventstype;
        }
    }
}
