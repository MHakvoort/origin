<?php
class BandsUsers {
    public function getAllMembers($band)
    {
        $con = new Config();
        $con = $con->connectDB();

        $sql = "SELECT *
                FROM users
                WHERE id NOT IN (SELECT users_id FROM bands_users)";

        $stmt = $con->prepare($sql);
        $stmt->execute();

        $members = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if($members) {
            return $members;
        }
    }

    public function addBandMember($member, $band)
    {
        $con = new Config();
        $con = $con->connectDB();

        $date = new DateTime();
        $date = $date->format('Y-m-d h:i:s');

        $sql = "INSERT INTO bands_users
                (bands_id, users_id, date_created)
                VALUES
                ('$band', '$member', '$date')";

        $stmt = $con->prepare($sql);
        $stmt->execute();

        return $con->lastInsertId();
    }

    public function getBandMembers($band)
    {
        $con = new Config();
        $con = $con->connectDB();

        $sql = "SELECT
                bu.*,
                us.username as gebruikersnaam,
                us.first_name as voornaam,
                us.surname as achternaam,
                us.email as email,
                up.avatar as avatar,
                up.woonplaats as woonplaats,
                up.provincie as provincie,
                up.website as gebruikerwebsite
                FROM bands_users bu
                JOIN users us
                ON us.id = bu.users_id
                JOIN users_profile up
                ON up.users_id = bu.users_id
                WHERE bu.bands_id = :id
        ";

        $stmt = $con->prepare($sql);
        $stmt->bindValue("id", $band, PDO::PARAM_STR);
        $stmt->execute();

        $members = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($members) {
            return $members;
        }
    }
}
?>
