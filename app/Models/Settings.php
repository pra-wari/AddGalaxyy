<?php namespace App\Models;
use CodeIgniter\Model;

class Settings extends Model
{
   protected $DBGroup = 'default';
   protected $table = 'settings';
   protected $primaryKey = 'id';
   protected $returnType = 'array';
   protected $useTimestamps = true;
   protected $allowedFields = ['id','option_name','option_value','icon_path','valid'];
   protected $createdField = 'date';
   protected $updatedField = 'modified_date';

}