<?php namespace App\Models;
use CodeIgniter\Model;

class ListingMeta extends Model
{
   protected $DBGroup = 'default';
   protected $table = 'listing_meta';
   protected $primaryKey = 'id';
   protected $returnType = 'array';
   protected $useTimestamps = true;
   protected $allowedFields = ['id','listing_id','category_id','attribute_id','attribute_option_id','created_at','modified_at','valid','deleted'];
   protected $createdField = 'created_at';
   protected $updatedField = 'modified_at';

}