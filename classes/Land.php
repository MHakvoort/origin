<?php

class Land {
    public function get_all()
    {
        $con = new Config();
        $con = $con->connectDB();

        $sql = "SELECT * FROM land";
        $stmt = $con->prepare($sql);
        $stmt->execute();

        $land = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($land) {
            return $land;
        }
    }
}
