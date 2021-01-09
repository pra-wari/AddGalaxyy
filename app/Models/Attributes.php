<?php namespace App\Models;
use CodeIgniter\Model;

class Attributes extends Model
{
   protected $DBGroup = 'default';
   protected $table = 'attribute_options';
   protected $primaryKey = 'id';
   protected $returnType = 'array';
   protected $useTimestamps = true;
   protected $allowedFields = ['option_name','parent_attribute_id','created_at','modified_at','valid','delated'];
   protected $createdField = 'created_at';
   protected $updatedField = 'modified_at';

}