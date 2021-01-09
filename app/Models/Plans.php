<?php namespace App\Models;
use CodeIgniter\Model;

class Plans extends Model
{
   protected $DBGroup = 'default';
   protected $table = 'plans';
   protected $primaryKey = 'id';
   protected $returnType = 'array';
   protected $useTimestamps = true;
   protected $allowedFields = ['id','plan_name','type','created_at','default_price','default_duration','default_days','modified_at','valid','deleted'];
   protected $createdField = 'created_at';
   protected $updatedField = 'modified_at';

}