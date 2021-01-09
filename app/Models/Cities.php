<?php namespace App\Models;
use CodeIgniter\Model;

class Cities extends Model
{
   protected $DBGroup = 'default';
   protected $table = 'cities';
   protected $primaryKey = 'id';
   protected $returnType = 'array';
   protected $useTimestamps = true;
   protected $allowedFields = ['id','name','state_id','date','modified_date'];
   protected $createdField = 'date';
   protected $updatedField = 'modified_date';

}