<?php namespace App\Models;
use CodeIgniter\Model;

class States extends Model
{
   protected $DBGroup = 'default';
   protected $table = 'states';
   protected $primaryKey = 'id';
   protected $returnType = 'array';
   protected $useTimestamps = true;
   protected $allowedFields = ['id','name','country_id','created_at','modified_at'];
   protected $createdField = 'created_at';
   protected $updatedField = 'modified_at';

}