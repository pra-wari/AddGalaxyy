<?php namespace App\Controllers;
use App\Models\Categories;
use App\Models\Attributes;
use App\Models\AttributesFilter;
use App\Models\Listing;
use App\Models\Filter;
use App\Models\Settings;
use App\Models\States;
use CodeIgniter\Config\Config;
use CodeIgniter\Controller;

class Subcategory extends Controller
{
	public function index()
	{
    $data= array();
    $settings = new Settings();
    $States = new States();
		$country_id = session()->get("country_id")?session()->get("country_id"):'101';
		$States->where('country_id',$country_id);
		$data['extras']['states'] = $States->findAll();
		$data['extras']['hotlinks'] = $settings->findAll();
		$data['extras']['selectedState'] = session()->get("state_id");
		return view('home',$data);
	}
/*-------------------------------------View Table -------------------------------*/
	public function view($viewId){
    $db = \Config\Database::connect();
    $listing = new Listing();
   // $listing->orderBy('id', 'desc');
    $data = array();
    $cat = new Categories();
    $cat1 = new Categories();
	  $data = $cat->findAll();
	  $catArray = array();
	  foreach ($data as $key => $value){
      if($value['parent_id']==0){
         if($value['id']==$viewId){
            $value['current']=true; 
           }else{
            $value['current']=false;
           } 
       $catArray[] = $value; 
      }
    }
    foreach ($catArray as $k => $v) {
      foreach ($data as $key => $value1){
        if($v['id']==$value1['parent_id']){
          if($value1['id']==$viewId){
            $value1['current']=true;  
            $catArray[$k]['current']=true;  
          }else{
            $value1['current']=false;  
            $catArray[$k]['current']=false;  
          } 
        $catArray[$k]['subCategory'][] = $value1; 
        }
      }
    }
    // echo $viewId;

     $query = $db->query("SELECT parent_id FROM categories WHERE id=".$viewId);
        $result = $query->getResult('array');
        // print_r($result);
        if(count($result)){
          $parent_category_id  = $result[0]['parent_id'];
        }else{
          $parent_category_id  = $viewId;
        }

    $queryatt = $db->query("SELECT * FROM attributes WHERE valid=1 AND deleted=0 AND parent_category_id=$parent_category_id");
    $attributes1 = array();
    foreach ($queryatt->getResult() as $rowatt)
    {
      $temp['id'] = $rowatt->id;
      $temp['attribute_name'] = $rowatt->attribute_name;
      $temp['type'] = $rowatt->type;
      $temp['created_at'] = $rowatt->created_at;
      $temp['modified_at'] = $rowatt->modified_at;
      $temp['attribute_type'] = $rowatt->attribute_type;
      $temp['parent_category_id'] = $rowatt->parent_category_id;
      $query_subatt = $db->query("SELECT * FROM attribute_options WHERE valid=1 AND deleted=0 AND parent_attribute_id=".$temp['id']);
      $result_subatt = array();
      $i=0;
      $temp3 = array();
      foreach ($query_subatt->getResult() as $row_subatt)
      {
        $temp2['id'] = $row_subatt->id;
        $temp2['option_name'] = $row_subatt->option_name;
        $temp2['parent_attribute_id'] = $row_subatt->parent_attribute_id;
        $temp2['created_at'] = $row_subatt->created_at;
        $temp2['modified_at'] = $row_subatt->modified_at;
        $temp2['valid'] = $row_subatt->valid;
        $temp2['deleted'] = $row_subatt->deleted;
        array_push($temp3, $temp2);
      $i++;
      }
      $temp['option']=$temp3;
      array_push($attributes1, $temp);
    }

    $att = new Attributes();
    $data = $att->where('parent_attribute_id',$viewId)->findAll();
    $attArray = array();
    foreach ($data as $key => $value){
      if($value['valid']==1 AND $value['deleted']==0){
        $attArray[] = $value;
      }
    }
    $data['attributes'] = $attributes1;	
    $cat = $cat->where('id',$viewId)->findAll();
		if($cat[0]['parent_id']!=0){
			$cat1 = $cat1->where('id',$cat[0]['parent_id'])->findAll();
		}else{
			$cat1 = array();
		}
    $premium = array();
    $freeAds = array();
    //$featured = $listing->where('featured','1')->findAll();
    $queryf = $db->query("SELECT * FROM listing WHERE featured=1 and category_id=$viewId ORDER BY id DESC");
    $featured = $queryf->getResult('array');
    $regionArray = $this->getallregion();
    /*if(count($regionArray)>0){
      $cond_region = 'location in('.implode(",",$regionArray).')';
    }else{
      $cond_region = "1=1";
    }
    
    $regid = session()->get('region_id');
    $cond_state = '';
    if($regid==''){
      $state=session()->get('state_id');
      $city=session()->get('city_id');
      if($state!='' and $city!=''){
        $cond_state = 'OR (state_id='.$state.' and city_id='.$city.')';
      }
    }*/
    $condition ='';
    //$condition = 'premium_status=1';
    $state=session()->get('state_id');
    if($state!=''){
      $condition .= ' AND state_id='.$state.'';
    }
    $city=session()->get('city_id');
    if($city!=''){
     $condition .= ' AND city_id='.$city.'';
    }
    $regid = session()->get('region_id');
    if($regid!=''){
      $condition .= ' AND location='.$regid.'';
    }


    //echo "SELECT * FROM listing WHERE category_id=$viewId $condition ORDER BY id DESC";
    
    $query = $db->query("SELECT * FROM listing WHERE category_id=$viewId $condition ORDER BY id DESC");
    //$query = $db->query("SELECT * FROM listing WHERE $cond_region AND category_id=$viewId");
    $result = array();
    foreach ($query->getResult() as $row)
    {
      $temp['id'] = $row->id;
      $temp['title'] = $row->title;
      $temp['images'] = $row->images;
      $temp['price'] = $row->price;
      $temp['location'] = $row->location;
      $temp['featured'] = $row->featured;
      $temp['category_id'] = $row->category_id;
      $temp['description'] = $this->charlimit($row->description,60);
      $temp['date'] = $row->date;
      $temp['modified_date'] = $row->modified_date;
      $temp['premium'] = $row->premium;
      $temp['user_id'] = $row->user_id;
      $temp['valid'] = $row->valid;
      $temp['deleted'] = $row->deleted;
      array_push($result, $temp);
    }
    $pager = \Config\Services::pager();
    $data['categories'] = $catArray;
    foreach ($result as $key => $vs) {
        if($vs['premium']){
          $premium[] = $vs;
          //unset($result[$key]);
        }
        else
        {
            $freeAds[] = $vs; 
        }
    }
    //$randomkey = rand(0,count($premium)-1);
    //shuffle($featured);
    $premium = $this->addcatBreadcrumb($premium);
    shuffle($premium);
    if(count($premium)>0){
      $data['premiumlisting'] = $premium;
    }else{
      $data['premiumlisting']=array();
    }
    $result=$this->getFrontAttribute($freeAds);
    $query1 = $db->query("Select * from listing where sgallery=1 and `category_id`='".$viewId."'");
    $sgallery = $query1->getResult('array');
    shuffle($sgallery);
    $settings = new Settings();
    $States = new States();
		$country_id = session()->get("country_id")?session()->get("country_id"):'101';
		$States->where('country_id',$country_id);
		$data['extras']['states'] = $States->findAll();
		$data['extras']['hotlinks'] = $settings->findAll();
		$data['extras']['selectedState'] = session()->get("state_id");
    $data['premiumlisting']=$this->getFrontAttribute($data['premiumlisting']);
    $featured=$this->getFrontAttribute($featured);
    $data['listing'] = $this->addcatBreadcrumb($result);
    $data['featured'] = $this->addcatBreadcrumb($featured);
    $data['sgallery'] = $sgallery;
    $requestMain = \Config\Services::request();
    $data['currentpage'] = $requestMain->uri->getSegment(2);
    $data['pageid'] = $viewId;
    $query = $db->query("SELECT option_value FROM settings WHERE option_name='Hide Price Slider'");
      $hideSlider = $query->getResult('array');
      if(isset($hideSlider[0])){
        if(isset($hideSlider[0]['option_value']) && $hideSlider[0]['option_value']!=''){
          $newarr = explode(",",$hideSlider[0]['option_value']);
          if (in_array($viewId, $newarr)){
            $data['hideSlider'] = true;
          }else{
            $data['hideSlider'] = false;
          }
        }else{
          $data['hideSlider'] = false;
        }
      }else{
        $data['hideSlider'] = false;
      }
    $data['mainCategory'] = $cat;
    $data['mainBreadcrumb'] = $this->addmainBreadcrumb($viewId);
    $data['parentCategory'] = $cat1;
		echo view('sub-category',$data);
   }

  function getFrontAttribute($listing){
    $db = \Config\Database::connect();
    foreach ($listing as $k1 => $v1) {
      $query = $db->query("SELECT attributes.`attribute_name`,attribute_options.`option_name`,attributes.`show_in_listing` FROM rel_listing_attributes 
      INNER JOIN attribute_options ON rel_listing_attributes.`attribute_id` = attribute_options.id
      INNER JOIN attributes ON attributes.id = attribute_options.`parent_attribute_id`
      WHERE rel_listing_attributes.listing_id='".$v1['id']."' AND attributes.`show_in_listing`=1");
      $listing[$k1]['front_attributes'] = $query->getResult('array');
    }
    return $listing;
  }
/*-------------------------------------get Region Table ----------------------------------------------*/
function getallregion(){
     
  $db = \Config\Database::connect();
$locationArray = array();
session()->get();
// print_r(session()->get('state'));
if(isset($_SESSION['region_id']) && $_SESSION['region_id']!=""){
  // echo "region";
  $locationArray[0] = $_SESSION['region_id'];
}else if(isset($_SESSION['city_id']) && $_SESSION['city_id']!=""){

  $query = $db->query("SELECT id FROM region WHERE city_id=".$_SESSION['city_id']);
  $result = array();
  $i=0;
  foreach ($query->getResult() as $row)
  {
    array_push($result, $row->id);
  }
  // echo "city";
  $locationArray = $result;
}else if(isset($_SESSION['state_id']) && $_SESSION['state_id']!=""){
  $state_id = $_SESSION['state_id'];
  $query = $db->query("SELECT id FROM region WHERE city_id IN(SELECT city_id FROM cities WHERE state_id =".$state_id.")");
  $result = array();
  $i=0;
  foreach ($query->getResult() as $row)
  {
    
    array_push($result, $row->id);
  }
  // echo "state";
  $locationArray = $result;
    
  }else if(isset($_SESSION['country_id']) && $_SESSION['country_id']!=""){
    $country_id = $_SESSION['country_id'];
    // echo "SELECT id FROM region WHERE city_id IN(SELECT id FROM cities WHERE state_id IN(SELECT id FROM states WHERE country_id=".$country_id."))";
    $query = $db->query("SELECT id FROM region WHERE city_id IN(SELECT id FROM cities WHERE state_id IN(SELECT id FROM states WHERE country_id=".$country_id."))");
    $result = array();
    $i=0;
    foreach ($query->getResult() as $row)
    {
      
      array_push($result, $row->id);
    }
    $locationArray = $result;
      
  }else{
    $locationArray = array();
  }
  return $locationArray;
 
}

/*-------------------------------------Filter Table ----------------------------------------------*/
public function filter(){
  $db = \Config\Database::connect();
  $mainCategoryId = $_POST['mainCategoryId'];
  $fromRupees = $_POST['fromRupees'];
  $toRupees = $_POST['toRupees'];
  $regionArray = $this->getallregion();
  if(count($regionArray)>0){
  $cond_region = ' AND location in('.implode(",",$regionArray).')';
  }else{
  $cond_region = "";
  }
  $allattname = explode(",", $_POST['allattname']);  
  
  $allattributes = array();
  foreach ($allattname as $key => $value) {
    if(isset($_POST[$value])){
      if(is_array($_POST[$value])){
        foreach ($_POST[$value] as $key1 => $value1) {
          $allattributes[$value][] = $value1;
          // array_push($allattributes[$value], $value1);
        }
      }else{
        $allattributes[$value] = $_POST[$value];
        // array_push($allattributes[$value], $_POST[$value]);
      }
    }  
  }
  if(isset($_POST['images'])){
    $allattributes['images'] = $_POST['images'];
  }
  $mainCategoryId = $_POST['mainCategoryId'];
  $fromRupees = $_POST['fromRupees'];
  $toRupees = $_POST['toRupees'];
  $filter = new Filter();
  $data = array();
  $cat = new Categories();
  $cat1 = new Categories();
  $att_filterArray = array();
  $i=0;
  if($_POST['parent_id']>0){
    $condition = " and category_id=".$_POST['mainCategoryId'];
  }else{
    $condition = " and category_id IN (SELECT id FROM categories WHERE parent_id='".$_POST['mainCategoryId']."')";
  }
  foreach ($allattributes as $key2 => $value2) {
    if($key2=='images'){
      $result = array();
      foreach ($value2 as $kv1 => $vv1) {
        if($vv1==0){
          $query = $db->query("SELECT id FROM listing WHERE images LIKE '%default-image%' ".$condition);
          foreach ($query->getResult() as $row)
          {
            array_push($result, $row->id);
          }
        }else{
          $query = $db->query("SELECT id FROM listing WHERE images NOT LIKE '%default-image%' ".$condition);
          foreach ($query->getResult() as $row)
          {
            array_push($result, $row->id);
          }
        }
      }
      $att[$i] = $result;
    }else{
    $att_filter = new AttributesFilter();
    if(is_array($value2)){
      if(count($value2)>1){
        $query = $db->query("SELECT listing_id FROM rel_listing_attributes WHERE attribute_id in(".implode(',', $value2).")");
        $result = array();
        foreach ($query->getResult() as $row)
        {
          array_push($result, $row->listing_id);
        }
        $att[$i] = $result;
      }else{
        $data = $att_filter->where('attribute_id',$value2)->findAll();
        $temp =array();
        foreach ($data as $key => $value){

            array_push($temp, $value['listing_id']);
        }
        $att[$i] = $temp;
      }
    }else{
      $data = $att_filter->where('attribute_id',$value2)->findAll();
      $temp =array();
      foreach ($data as $key => $value){
          // $att_filterArray[] = $value['listing_id'];
          array_push($temp, $value['listing_id']);
      }
      $att[$i] = $temp;
    }
  }
    $i++;
  }
if(isset($att[0])){
  $att_filterArray = $att[0];
  // print_r($att_filterArray);
  for($i = 1; $i < count($att); $i++){
    $att_filterArray = array_intersect($att_filterArray, $att[$i]);
  }
}
 //echo "@@";
 //print_r($att_filterArray);
 //echo "@@";
$data = $cat->findAll();
$catArray = array();
foreach ($data as $key => $value){
  if($value['parent_id']==0){
      if($value['id']==$mainCategoryId){
        $value['current']=true; 
        }else{
        $value['current']=false;
        } 
    $catArray[] = $value; 
  }
}
foreach ($catArray as $k => $v) {
  foreach ($data as $key => $value1){
    if($v['id']==$value1['parent_id']){
      if($value1['id']==$mainCategoryId){
        $value1['current']=true;  
        $catArray[$k]['current']=true;  
        }else{
        $value1['current']=false;  
        $catArray[$k]['current']=false;  
        } 
    $catArray[$k]['subCategory'][] = $value1; 
    }
  }
}
$att = new Attributes();
$data = $att->where('parent_attribute_id',$mainCategoryId)->findAll();
$attArray = array();
foreach ($data as $key => $value){
  if($value['valid']==1 AND $value['deleted']==0){
    $attArray[] = $value;
  }
}
  $data['attributes'] = $attArray;

        
    $cat = $cat->where('id',$mainCategoryId)->findAll();
    if($cat[0]['parent_id']!=0){
      $cat1 = $cat1->where('id',$cat[0]['parent_id'])->findAll();
    }else{
      $cat1 = array();
    }
      $premium = array();
      $featured = $filter->where('featured','1')->findAll();
      // $result = $filter->where('category_id',$mainCategoryId)->findAll();
// print_r($att_filterArray);
if(count($att_filterArray)>0){
  $att_cond =  " AND id in(".implode(',', $att_filterArray).")";
}else{
  $att_cond = " AND 1=1";
}
$catArray1 = $this->getsubcategories($mainCategoryId);
if(count($catArray1)>0){
  $cat_cond =  "AND category_id IN (".(implode(", ",$catArray1)).")";
}else{
  $cat_cond =  "AND category_id ='".$mainCategoryId."'";

}

$condition = '';
    $state=session()->get('state_id');
    if($state!=''){
      $condition .= ' AND state_id='.$state.'';
    }
    $city=session()->get('city_id');
    if($city!=''){
      $condition .= ' AND city_id='.$city.'';
    }
    $regid = session()->get('region_id');
    if($regid!=''){
      $condition .= ' AND location='.$regid.'';
    }
// echo $cat_cond;
// echo "SELECT * FROM listing WHERE price between $fromRupees AND $toRupees $cat_cond".$att_cond;
$query = $db->query("SELECT * FROM listing WHERE price between $fromRupees AND $toRupees $condition $cat_cond".$att_cond);

$result = array();
foreach ($query->getResult() as $row)
{
  $temp['id'] = $row->id;
  $temp['title'] = $row->title;
  $temp['images'] = $row->images;
  $temp['price'] = $row->price;
  $temp['location'] = $row->location;
  $temp['featured'] = $row->featured;
  $temp['category_id'] = $row->category_id;
  $temp['description'] = $row->description;
  $temp['date'] = $row->date;
  $temp['modified_date'] = $row->modified_date;
  $temp['premium'] = $row->premium;
  $temp['user_id'] = $row->user_id;
  $temp['valid'] = $row->valid;
  $temp['deleted'] = $row->deleted;
  array_push($result, $temp);
}
  $pager = \Config\Services::pager();
  $data['categories'] = $catArray;  
  foreach ($result as $key => $vs) {
      if($vs['premium']){
        $premium[] = $vs;
        //unset($result[$key]);
      }
  }
  $randomkey = rand(0,count($premium)-1);
  if(count($premium)>0){
    $premium = $this->addcatBreadcrumb($premium);
    $data['premiumlisting'][0] = $premium[$randomkey];
  }else{
    $data['premiumlisting']=array();
  }
  shuffle($featured);
  $cat1 = new Categories();
  //$data['categories'] = $cat1->findAll();
  $settings = new Settings();
  $States = new States();
  $country_id = session()->get("country_id")?session()->get("country_id"):'101';
  $States->where('country_id',$country_id);
  $data['extras']['states'] = $States->findAll();
  $data['extras']['hotlinks'] = $settings->findAll();
  $data['extras']['selectedState'] = session()->get("state_id");
  $requestMain = \Config\Services::request();
  $data['currentpage'] = $requestMain->uri->getSegment(2);
  $data['listing'] = $this->addcatBreadcrumb($result);
  $data['featured'] = $this->addcatBreadcrumb($featured);
  $data['mainCategory'] = $cat;
  $data['parentCategory'] = $cat1;
  echo view('filter', $data);
  }
	/*-------------------------------------addcatBreadcrumb Table ----------------------------------------------*/
  public function addcatBreadcrumb($listingArr){
    $db = \Config\Database::connect();
    foreach ($listingArr as $key => $value) {
      $query = $db->query("SELECT m.name AS parent_cat,e.name AS child_cat FROM categories e INNER JOIN categories m ON e.parent_id = m.id WHERE e.id='".$value['category_id']."'");
      $listingArr[$key]['categories'] = $query->getResult('array');
    }
    return $listingArr;
   }

   public function addmainBreadcrumb($catid){
    $db = \Config\Database::connect();
    $query = $db->query("SELECT m.id AS parent_id,m.name AS parent_cat,e.id AS child_id,e.name AS child_cat FROM categories e INNER JOIN categories m ON e.parent_id = m.id WHERE e.id='".$catid."'");
    return $query->getResult('array');
   }

   public function getsubcategories($category_id){
      $db = \Config\Database::connect();
      $catArray = array();
        $query = $db->query("SELECT id FROM categories WHERE parent_id=".$category_id);
        $result = $query->getResult('array');
        foreach ($result as $key => $value) {
          array_push($catArray, $value['id']);
        }
        // print_r($catArray);
        return $catArray;
      // return $listingArr;
   }

   public function charlimit($string, $limit) {
    return substr($string, 0, $limit) . (strlen($string) > $limit ? "..." : '');
  }
}