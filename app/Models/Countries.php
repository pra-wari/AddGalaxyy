<?php namespace App\Models;
use CodeIgniter\Model;

class Countries extends Model
{
   protected $DBGroup = 'default';
   protected $table = 'countries';
   protected $primaryKey = 'id';
   protected $returnType = 'array';
   protected $useTimestamps = true;
   protected $allowedFields = ['id','sortname','name','phonecode'];
   protected $createdField = 'date';
   protected $updatedField = 'modified_date';

}