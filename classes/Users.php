<?php

class Users
{
    public $username = null;
    public $password = null;
    public $firstname = null;
    public $surname = null;
    public $email = null;
    public $type = null;

    public $salt = "Zo4rU5Z1YyKJAASY0PT6EUg7BBYdlEhPaNLuxAwU8lqu1ElzHv0Ri7EM6irpx5w";

    public function __construct($data = array())
    {
        if (isset($data['user-input'])) $this->username = stripslashes(strip_tags($data['user-input']));
        if (isset($data['password-input'])) $this->password = stripslashes(strip_tags($data['password-input']));
        if (isset($data['first_name'])) $this->firstname = stripslashes(strip_tags($data['first_name']));
        if (isset($data['surname'])) $this->surname = stripslashes(strip_tags($data['surname']));
        if (isset($data['email'])) $this->email = stripslashes(strip_tags($data['email']));
        if (isset($data['type'])) $this->type = stripslashes(strip_tags($data['type']));
    }

    public function storeFormValues($params)
    {
        //store the parameters
        $this->__construct($params);
    }

    public function login()
    {
        //success variable will be used to return if the login was successful or not.
        $success = false;

        try {
            //create our pdo object
            $con = new Config();
            $con = $con->connectDB();

            //Query
            $sql = "SELECT * FROM users WHERE username = :username AND password = :password LIMIT 1";

            //prepare the statements
            $stmt = $con->prepare($sql);
            //give value to named parameter :username
            $stmt->bindValue("username", $this->username, PDO::PARAM_STR);
            //give value to named parameter :password
            $stmt->bindValue("password", hash("sha256", $this->password . $this->salt), PDO::PARAM_STR);
            $stmt->execute();

            $valid = $stmt->fetchColumn();

            if ($valid) {
                $success = true;
            }

            $con = null;
            return $success;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return $success;
        }
    }

    public function register()
    {
        $correct = false;

        try {
            $con = new Config();
            $con = $con->connectDB();

            //Bestaat gebruikersnaam al?
            $sql = "SELECT * FROM users WHERE username = :username or email = :email";
            $stmt = $con->prepare($sql);
            $stmt->bindValue("username", $this->username, PDO::PARAM_STR);
            $stmt->bindValue("email", $this->email, PDO::PARAM_STR);
            $stmt->execute();

            $valid = $stmt->fetchColumn();
            if ($valid) {
                return false;
            }

            if (!isset($this->type) && empty($this->type)) {
                $this->type = 'fan';
            }

            $sql = "INSERT INTO users(username, password, first_name, surname, email, " . $this->type . ") VALUES(:username, :password, :first_name, :surname, :email, 1)";

            $stmt = $con->prepare($sql);
            $stmt->bindValue("username", $this->username, PDO::PARAM_STR);
            $stmt->bindValue("password", hash("sha256", $this->password . $this->salt), PDO::PARAM_STR);
            $stmt->bindValue("first_name", $this->firstname, PDO::PARAM_STR);
            $stmt->bindValue("surname", $this->surname, PDO::PARAM_STR);
            $stmt->bindValue("email", $this->email, PDO::PARAM_STR);
            $stmt->execute();

            $lastId = $con->lastInsertId();

            $sql = "INSERT INTO users_profile(users_id) VALUES (:user)";
            $stmt = $con->prepare($sql);
            $stmt->bindValue("user", $lastId);
            $stmt->execute();

            $this->mailUser();
            return true;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function mailUser()
    {
        $headers = "From: <no-reply@mygig.nl>";
        $headers .= "X-Sender: <no-reply@mygig.nl>";
        $headers .= "X-Mailer: PHP";
        $headers .= "X-Priority: 3"; //1 = Spoed bericht, 3 = Normaal bericht
        $headers .= "Return-Path: <no-reply@mygig.nl>";
        $headers .= "Content-type: text/html";
        $onderwerp = "Welkom bij MyGig!";
        $bericht = "Beste " . $this->firstname . ",

        Bedankt voor je registratie, en welkom op MyGig!
        Dit is je geregistreerde gebruikersnaam: " . $this->username . "

        Blijf op de hoogte van de nieuwste updates via onze Facebook pagina,
        en hopelijk zien we je snel terug bij MyGig!";
        mail($this->email, $onderwerp, $bericht, $headers);
    }

    public function get($usr)
    {
        $con = new Config();
        $con = $con->connectDB();

        //Bestaat gebruikersnaam al?
        $sql = "SELECT * FROM users WHERE username = :username";
        $stmt = $con->prepare($sql);
        $stmt->bindValue("username", $usr, PDO::PARAM_STR);
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

        $sql = "SELECT * FROM users";
        $stmt = $con->prepare($sql);
        $stmt->execute();

        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($users) {
            return $users;
        }
    }

    public function get_lid($id)
    {
        $con = new Config();
        $con = $con->connectDB();

        $sql = "SELECT
                u.*,
                up.woonplaats as woonplaats,
                up.provincie as provincie,
                up.avatar as avatar,
                up.website as website
                FROM users u
                JOIN users_profile up
                ON
                u.id = up.users_id
                WHERE u.id = :user";
        $stmt = $con->prepare($sql);
        $stmt->bindValue("user", $id, PDO::PARAM_STR);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user) {
            return $user;
        }
    }

    public function edit($id, $firstname, $surname, $woonplaats, $provincie, $website)
    {
        $con = new Config();
        $con = $con->connectDB();

        $date = new DateTime();
        $date = $date->format('Y-m-d h:i:s');

        $sql = "UPDATE users
                SET
                first_name = ?,
                surname = ?,
                datechanged = ?
                WHERE
                id = ?";
        $stmt = $con->prepare($sql);
        $stmt->execute(array($firstname, $surname, $date, $id));

        $sql = "UPDATE users_profile
                SET
                 woonplaats = ?,
                 provincie = ?,
                 website = ?
                 WHERE
                 users_id = ?
               ";
        $stmt = $con->prepare($sql);
        $stmt->execute(array($woonplaats, $provincie, $website, $id));

        $user = $this->get_lid($id);
        if ($user) {
            return $user;
        }
    }

    public function setAvatar($id, $file)
    {
        $con = new Config();
        $con = $con->connectDB();

        $sql = "UPDATE users_profile
                SET
                 avatar = ?
                 WHERE
                 users_id = ?
               ";
        $stmt = $con->prepare($sql);
        $stmt->execute(array($file, $id));
    }
}

?>
