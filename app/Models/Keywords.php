<?php namespace App\Models;
use CodeIgniter\Model;

class Keywords extends Model
{
   protected $DBGroup = 'default';
   protected $table = 'keywords';
   protected $primaryKey = 'id';
   protected $returnType = 'array';
   protected $useTimestamps = true;
   protected $allowedFields = ['id','listing_id','keywords','state_id','category_id','created_date','modified_date'];
   protected $createdField = 'created_date';
   protected $updatedField = 'modified_date';

}