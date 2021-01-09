<?php namespace App\Models;
use CodeIgniter\Model;

class Chat extends Model
{
   protected $DBGroup = 'default';
   protected $table = 'chat';
   protected $primaryKey = 'id';
   protected $returnType = 'array';
   protected $useTimestamps = true;
   protected $allowedFields = ['id','enquiry_id','sender_id','message','created_date','deleted'];
   protected $createdField = 'created_date';
   protected $updatedField = 'modified_date';

}