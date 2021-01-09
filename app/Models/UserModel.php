<?php namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model{
  protected $table = 'users';
  protected $allowedFields = ['id','firstname','lastname', 'username', 'email', 'password', 'date','mobile','usertype','modified_date','valid','deleted','verified'];
  protected $beforeInsert = ['beforeInsert'];
  protected $beforeUpdate = ['beforeUpdate'];

  protected function beforeInsert(array $data){
    //$data = $this->passwordHash($data);
    $data['data']['date'] = date('Y-m-d H:i:s');
    $data['data']['modified_date'] = date('Y-m-d H:i:s');
    $data['data']['date'] = 'usertype';
    return $data;
  }

  protected function beforeUpdate(array $data){
    //$data = $this->passwordHash($data);
    $data['data']['modified_date'] = date('Y-m-d H:i:s');
    return $data;
  }

  protected function passwordHash(array $data){
    if(isset($data['data']['password']))
      $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);

    return $data;
  }


}