<?php
namespace MVC\models;

use MVC\core\model;

class verify extends model
{
    public function update_status($id)
    {
        $data = model::db()->update('user', ['status' => 'verified'], ['id' => $id]);
        return $data;
    }
    public function check_token($id,$token){
        $data = model::db()->count("SELECT id,token FROM user WHERE id = ? AND token = ? AND (status IS NULL)", [$id,$token]);
        return $data;
    }
    public function check_verification ($id){
        $data = model::db()->count("SELECT id FROM user WHERE id = ?   AND (status IS NULL)", [$id]);
        return $data;
    }
    public function check_email ($email){
        $data = model::db()->count("SELECT email FROM user WHERE email = ? ", [$email]);
        return $data;
    }
    public function get_token($email){
        $data = model::db()->run("SELECT token FROM user WHERE email = ?  ", [$email])->fetch();
        return $data;
    }
    public function get_user($email){
        $data = model::db()->run("SELECT id,username,email,token,status FROM user WHERE email = ?  ", [$email])->fetch();
        return $data;
    }


}

?>
