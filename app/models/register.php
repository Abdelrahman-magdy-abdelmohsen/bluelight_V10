<?php
namespace MVC\models;

use MVC\core\model;

class register extends model
{
    public function register($data)
    {
        $data = model::db()->insert('user', $data);
        return $data;
    }

    public function checkemail($email)
    {
        $count = model::db()->count("SELECT email FROM user WHERE email = ?", [$email]);
        return $count; // Return the count of emails found
    }

    public function checkusername($username)
    {
        $count = model::db()->count("SELECT username FROM user WHERE username = ?", [$username]);
        return $count; // Return the count of usernames found
    }
}
?>
