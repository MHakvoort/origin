<?php
    class Main {

          // Settings \\

    private $db_connection = null;

    public $logged_in = false;

    public $errors = '';
    //you can also use an array.


          // System Function \\

    public function __construct() {
        if (session_id() == '' || !isset($_SESSION)){
            session_start();
        }
        if (isset($_POST['submit'])){
        $this->login($_POST['username'],$_POST['password']);
        }
        if (isset($_GET["logout"])) {
            $this->doLogout();
        }
        else if (isset($_SESSION['user_logged_in'])|($_SESSION['user_logged_in'] == 1))
        {
            $this->loginWithSessionData();
        }
    }

    private function databaseConnection() {
        if ($this->db_connection != null)
        {
            return true;
        }
        else
        {
            try
            {
                $this->db_connection = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS);
                return true;
            }

            catch(PDOException $e)
            {
                $this->errors = 'Database error';
                return false;
            }
        }
    }

         // Login Functions

    public function doLogout() {
        session_destroy();
        $this->logged_in = false;
        header("Location:index.php");
        $this->errors ='Uitgelogd';
    }

    public function login($username,$password) {

    if ($this->databaseConnection())
        {
            $query = $this->db_connection->prepare('SELECT * FROM accounts WHERE username=:username AND password=:password');
            $query->bindValue(':username', $username, PDO::PARAM_STR);
            $query->bindValue(':password', $password, PDO::PARAM_STR);
          //$query->bindValue(':password', md5($password), PDO::PARAM_STR);
            //md5 is a bit more secure

            $query->execute();
            $user = $query->fetchObject();
             if ($query->rowCount() == 0)
                {
                    $this->errors = "Username or password is wrong!";
                }
                else {
            /*
                    $update = $this->db_connection->prepare('UPDATE accounts SET lastlogin=now() WHERE id=:id');
                    $update->bindValue(':id', $user->id, PDO::PARAM_STR);
                    $update->execute();
                    */
                    $this->logged_in = true;
                    $_SESSION['user_logged_in'] = 1;
                    $_SESSION['id'] = $user->id;
                }
        }
    }

    public function loginWithSessionData() {
        $this->logged_in = true;
    }
?>
