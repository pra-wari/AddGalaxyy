<?php namespace App\Models;
use CodeIgniter\Model;

class UsersPlanRelationship extends Model
{
   protected $DBGroup = 'default';
   protected $table = 'users_plan_relation';
   protected $primaryKey = 'id';
   protected $returnType = 'array';
   protected $useTimestamps = true;
   protected $allowedFields = ['id','user_id','plan_id','listing_id','created_at','modified_at','valid','deleted','plan_start_date','plan_end_date'];
   protected $createdField = 'created_at';
   protected $updatedField = 'modified_at';

}