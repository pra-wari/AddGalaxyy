<?php namespace App\Models;
use CodeIgniter\Model;

class RelListingAttribute extends Model
{
   protected $DBGroup = 'default';
   protected $table = 'rel_listing_attributes';
   protected $primaryKey = 'id';
   protected $returnType = 'array';
   protected $useTimestamps = true;
   protected $allowedFields = ['id','listing_id','attribute_id','created_at','updated_at'];

}