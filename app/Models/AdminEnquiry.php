<?php namespace App\Models;
use CodeIgniter\Model;

class AdminEnquiry extends Model
{
   protected $DBGroup = 'default';
   protected $table = 'messages';
   protected $primaryKey = 'id';
   protected $returnType = 'array';
   protected $useTimestamps = true;
   protected $allowedFields = ['id','name','email','message','created_date','updated_date','deleted'];
   protected $createdField = 'created_date';
   protected $updatedField = 'updated_date';

}