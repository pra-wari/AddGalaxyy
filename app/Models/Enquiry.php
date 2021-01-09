<?php namespace App\Models;
use CodeIgniter\Model;

class Enquiry extends Model
{
   protected $DBGroup = 'default';
   protected $table = 'enquiry';
   protected $primaryKey = 'id';
   protected $returnType = 'array';
   protected $useTimestamps = true;
   protected $allowedFields = ['id','ad_id','owner_id','sender_id','sender_name','sender_email','sender_mobile','created_date','modified_date','read'];
   protected $createdField = 'created_date';
   protected $updatedField = 'modified_date';

}