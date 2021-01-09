<?php namespace App\Models;
use CodeIgniter\Model;

class PlansMeta extends Model
{
   protected $DBGroup = 'default';
   protected $table = 'plans_meta';
   protected $primaryKey = 'id';
   protected $returnType = 'array';
   protected $useTimestamps = true;
   protected $allowedFields = ['id','plan_id','plan_duration','plan_price','plan_type','planindays','country_id','state_id','city_id','region_id','created_at','modified_at','valid','deleted'];
   protected $createdField = 'created_at';
   protected $updatedField = 'modified_at';

}