<?php
class Config
{
    // Settings \\
    private $db_connection = null;

    public $logged_in = false;

    public $errors = '';

    // System Function \\
    public function connectDB()
    {
        try {
            $db_host = 'localhost';  //  hostname
            $db_name = 'matheno_mygig';  //  databasename
            $db_user = 'matheno_marijke';  //  username
            $user_pw = 'Gabruko3';  //  password

            $con = new PDO('mysql:host='.$db_host.'; dbname='.$db_name, $db_user, $user_pw);
            $con->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
            $con->exec("SET CHARACTER SET utf8");  //  return all sql requests as UTF-8

            return $con;
        }
        catch (PDOException $err) {
            echo "harmless error message if the connection fails";
            $err->getMessage() . "<br/>";
            file_put_contents('PDOErrors.txt',$err, FILE_APPEND);  // write some details to an error-log outside public_html
            die();  //  terminate connection
        }

    }
}

?>
