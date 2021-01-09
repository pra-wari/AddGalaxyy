<?php namespace App\Models;
use CodeIgniter\Model;

class Invoice extends Model
{
   protected $DBGroup = 'default';
   protected $table = 'invoice';
   protected $primaryKey = 'id';
   protected $returnType = 'array';
   protected $useTimestamps = true;
   protected $allowedFields = ['id','user_id','plan_id','upr_id','price','listing_id','created_at','modified_at','valid','deleted'];
   protected $createdField = 'created_at';
   protected $updatedField = 'modified_at';

}