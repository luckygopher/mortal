<?php
namespace app\admin\model;

use core\lib\Model;


class UserModel extends Model
{
    public $table = 'users';

    public function getUserInfo($id)
    {
        $ret = $this->select($this->table, 'name', ['id' => $id]);
        return $ret;
    }
}