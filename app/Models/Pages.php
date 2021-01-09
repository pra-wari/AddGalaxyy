<?php namespace App\Models;
use CodeIgniter\Model;

class Pages extends Model
{
   protected $DBGroup = 'default';
   protected $table = 'pages';
   protected $primaryKey = 'id';
   protected $returnType = 'array';
   protected $useTimestamps = true;
   protected $allowedFields = ['id','page_name','content','created_date','updated_date','valid','deleted'];
   protected $createdField = 'created_date';
   protected $updatedField = 'updated_date';

}