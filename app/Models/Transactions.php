<?php namespace App\Models;
use CodeIgniter\Model;

class Transactions extends Model
{
   protected $DBGroup = 'default';
   protected $table = 'transaction';
   protected $primaryKey = 'id';
   protected $returnType = 'array';
   protected $useTimestamps = true;
   protected $allowedFields = ['id','user_id','plan_id','upr_id','transaction_id','listing_id','transaction_response','transaction_status','transaction_date','updated_at'];
   protected $createdField = 'transaction_date';

}