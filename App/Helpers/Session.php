<?php
namespace App\Helpers;

class Session
{
    private static $instances = [];
    private $signedIn = false;
    private $role;
    public $userId;
    public $message;

    public function __construct()
    {
        session_start();
        $this->checkLogin();
        $this->checkMessage();
    }

    private function __clone()
    {
        
    }

    public static function getInstance(): Session
    {
        $cls = static::class;
        if (!isset(self::$instances[$cls])) {
            self::$instances[$cls] = new static();
        }
        return self::$instances[$cls];
    }

    public function isSignedIn()
    {
        return $this->signedIn;
    }

    public function checkLogin()
    {
        if (isset($_SESSION['userId'])) {
            $this->userId = $_SESSION['userId'];
            $this->signedIn = true;
        } else {
            unset($this->userId);
            $this->signedIn = false;
        }
    }
    public function login($user)
    {
        if ($user) {
            $this->userId = $user->id;
            $_SESSION['userId'] = $user->id;

            $this->role = $user->role;
            $_SESSION['role'] = $user->role;
            $this->signedIn = true;
        }
    }
    
    public function getRole()
    {
        if (isset($this->role)) {
            return $this->role;
        }
        return null;
    }

    public function logout()
    {
        unset($_SESSION['userId']);
        unset($this->userId);
        $this->signedIn = false;
    }

    public function message($msg = "")
    {
        if (!empty($msg)) {
            $this->message = $_SESSION['message'] = $msg;
        } else {
            return $this->message;
        }
    }

    public function checkMessage()
    {
        if (isset($_SESSION['message'])) {
            $this->message = $_SESSION['message'];
            unset($_SESSION['message']);
        } else {
            $this->message = "";
        }
    }
}
?>