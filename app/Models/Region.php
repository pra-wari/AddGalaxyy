<?php namespace App\Models;
use CodeIgniter\Model;

class Region extends Model
{
   protected $DBGroup = 'default';
   protected $table = 'region';
   protected $primaryKey = 'id';
   protected $returnType = 'array';
   protected $useTimestamps = true;
   protected $allowedFields = ['id','name','city_id','region_id','created_date','modified_date','deleted'];
   protected $createdField = 'created_date';
   protected $updatedField = 'modified_date';

}