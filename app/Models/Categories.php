<?php namespace App\Models;
use CodeIgniter\Model;

class Categories extends Model
{
   protected $DBGroup = 'default';
   protected $table = 'categories';
   protected $primaryKey = 'id';
   protected $returnType = 'array';
   protected $useTimestamps = true;
   protected $allowedFields = ['id','name','slug','description','date','icon_path','parent_id','modified_date','valid','deleted','count'];
   protected $createdField = 'date';
   protected $updatedField = 'modified_date';

}