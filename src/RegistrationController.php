<?php

namespace Mamad\CurrencyApp;

use Jenssegers\Blade\Blade;

class RegistrationController {

    public $blade;

    public function __construct()
    {
        $this->blade = new Blade('views', 'cache');
    }

    public function index()
    {
        
        echo $this->blade->render('signup');
    }

    private function verify($response)
    {
        if (empty($response["name"])) {
            die("Name is required");
        }

        if ( ! filter_var($response["email"], FILTER_VALIDATE_EMAIL)) {
            die("Valid email is required");
        }

        if (strlen($response["password"]) < 4 ) {
            die("Password must be at least 4 carachter");
        }

        if (! preg_match("/[a-z]/i", $response['password'])) {
            die("password must contain at least a letter");
        }

        if (! preg_match("/[0-9]/", $response['password'])) {
            die("password must contain at least a number");
        }

        if ( $response["password"] !== $response["password_confirmation"]) {
            die("Passwords must match");
        }

        $password_hash = password_hash($response["password"], PASSWORD_DEFAULT);
        return $password_hash;
    }

    public function create() {
        $this->verify($_POST);
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password_hash = $this->verify($_POST);

        $db = new DBController();
        $sql = pg_send_query($db->con, "INSERT INTO users (name, email, password_hash) 
        VALUES ('$name', '$email', '$password_hash')");

        if ($sql) {
            $res=pg_get_result($db->con);
            if ($res) {
                $state = pg_result_error_field($res, PGSQL_DIAG_SQLSTATE);
                if ($state==0) {
                    Header("location: /views/home.blade.php");
                }
                else {
                    if ($state=="23505") { 
                        echo "email is already taken";
                    }
                }
                }            
        }
    }

    public function loginIndex() {
        echo $this->blade->render('login', ['is_invalid' => '0']);
    }

    public function login() {
        $is_invalid = false;
        $db = new DBController();
        $sql = sprintf("SELECT * FROM users WHERE email = '%s'", $_POST['email']);
        $res = pg_query($db->con, $sql);
        $user = pg_fetch_assoc($res);
        if($user){
            if (password_verify($_POST['password'], $user['password_hash'])) {
                session_start();
                $_SESSION["user_id"] = $user["id"];
                $username = $user['name'];
                echo $this->blade->render('home', ['name' => $username]);
            } 
            else {
                echo $this->blade->render('login', ['is_invalid' => '1']);
            }
            } 
            else {
                echo $this->blade->render('login', ['is_invalid' => '1']);
            }
        
    }

    public function logout() {
        
        session_start();
        session_destroy();
        Header("location: /views/home.blade.php");
        
    }

}