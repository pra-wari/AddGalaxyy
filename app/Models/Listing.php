<?php namespace App\Models;
use CodeIgniter\Model;

class Listing extends Model
{
   protected $DBGroup = 'default';
   protected $table = 'listing';
   protected $primaryKey = 'id';
   protected $returnType = 'array';
   protected $useTimestamps = true;
   protected $allowedFields = ['id','title','images','price','location','state_id','city_id','featured','premium','sgallery','featured_status','premium_status','sgallery_status','category_id','description','date','modified_date','valid','deleted','user_id','views'];
   protected $createdField = 'date';
   protected $updatedField = 'modified_date';

}