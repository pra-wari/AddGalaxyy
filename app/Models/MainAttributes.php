<?php namespace App\Models;
use CodeIgniter\Model;

class MainAttributes extends Model
{
   protected $DBGroup = 'default';
   protected $table = 'attributes';
   protected $primaryKey = 'id';
   protected $returnType = 'array';
   protected $useTimestamps = true;
   protected $allowedFields = ['id','attribute_name','type','created_at','modified_at','valid','deleted','attribute_type','attribute_status','parent_category_id','show_in_listing'];
   protected $createdField = 'created_at';
   protected $updatedField = 'modified_at';

}