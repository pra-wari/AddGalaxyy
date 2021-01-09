<?php namespace App\Models;
use CodeIgniter\Model;

class ListingImages extends Model
{
   protected $DBGroup = 'default';
   protected $table = 'listing_images';
   protected $primaryKey = 'id';
   protected $returnType = 'array';
   protected $useTimestamps = true;
   protected $allowedFields = ['id','listing_id','image_path','created_date','updated_date'];
   protected $createdField = 'created_date';
   protected $updatedField = 'updated_date';

}