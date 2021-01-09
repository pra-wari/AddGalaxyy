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

class Category extends Controller
{
	public function index()
   {
      $session = \Config\Services::session();
      $message = $session->getFlashdata('message');
	   $cat = new Categories();
	   $data = $cat->findAll();
	   $catArray = array();
	   foreach ($data as $key => $value){
		  if($value['parent_id']==0){
			$catArray[] = $value; 
		  }
	   }
     
      foreach ($catArray as $k => $v) {
         foreach ($data as $key => $value){
            if($value['parent_id']==$v['parent_id']){
               $catArray[$k]['subCategory'][] = $value; 
            }
         }
      }
      $settings = new Settings();
      $States = new States();
      $country_id = session()->get("country_id")?session()->get("country_id"):'101';
      $States->where('country_id',$country_id);
      $data['extras']['states'] = $States->findAll();
      $data['extras']['hotlinks'] = $settings->findAll();
      $data['extras']['selectedState'] = session()->get("state_id");
      $data['categories'] = $catArray;
      $requestMain = \Config\Services::request();
      $data['currentpage'] = $requestMain->uri->getSegment(2);
      $pager = \Config\Services::pager();
      $data['message'] = $message;
      echo view('home',$data);

      //var_dump($results);
      //echo 'index Students';
   }

	public function view($viewId){

      $db = \Config\Database::connect();

      $listing = new Listing();
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
   
// echo "SELECT * FROM attributes WHERE valid=1 AND deleted=0 AND parent_category_id=$viewId";
$queryatt = $db->query("SELECT * FROM attributes WHERE valid=1 AND deleted=0 AND parent_category_id=$viewId");
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
    // echo "SELECT * FROM attribute_options WHERE valid=1 AND deleted=0 AND parent_attribute_id=".$temp['id'];
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
    // echo "<pre>";
    // print_r($temp);
    // echo "</pre>";
        array_push($attributes1, $temp);
}
// print_r($attributes1);

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
      $regionArray = $this->getallregion();
      if(count($regionArray)>0){
        $cond_region = 'location in('.implode(",",$regionArray).') and ';
      }else{
        $cond_region = "1=1 and ";
      }
      $premium = array();
      $res = $db->query("SELECT * FROM listing WHERE featured=1 AND category_id IN (SELECT id FROM categories WHERE parent_id=".$viewId.")");
      $featured = $this->addcatBreadcrumb($res->getResult('array'));
      $result = $listing->where('category_id',$viewId)->findAll();
      $pager = \Config\Services::pager();
      $data['categories'] = $catArray;	
      $res = $db->query("SELECT * FROM listing WHERE premium=1 AND category_id IN (SELECT id FROM categories WHERE parent_id=".$viewId.")");
      $premium = $this->addcatBreadcrumb($res->getResult('array'));
      $randomkey = rand(0,count($premium)-1);
      shuffle($featured);
      $query = $db->query("Select * from listing where ".$cond_region." premium=0 and `category_id` In (SELECT m.id FROM categories e INNER JOIN categories m ON e.id = m.parent_id
      where e.id='".$viewId."')");
      $query1 = $db->query("Select * from listing where sgallery=1 and `category_id` In (SELECT m.id FROM categories e INNER JOIN categories m ON e.id = m.parent_id
      where e.id='".$viewId."')");
      $finalResult = $this->addcatBreadcrumb($query->getResult('array'));
      foreach ($finalResult as $ks1 => $vs1) {
       //print_r($vs1);
      }
      $finalResult=$this->getFrontAttribute($finalResult);
      $data['listing'] = $finalResult;
      //$data['message'] = $message;
      if(count($premium)>0){
        $data['premiumlisting'][0] = $premium[$randomkey];
      }else{
        $data['premiumlisting']=array();
      }
      $sgallery = $query1->getResult('array');
      shuffle($sgallery);
      $settings = new Settings();
      $States = new States();
      $country_id = session()->get("country_id")?session()->get("country_id"):'101';
      $States->where('country_id',$country_id);
      $data['extras']['states'] = $States->findAll();
      $data['extras']['hotlinks'] = $settings->findAll();
      $data['extras']['selectedState'] = session()->get("state_id");
      $data['sgallery'] = $sgallery;
      $data['featured'] = $featured;
      $data['mainCategory'] = $cat;
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
      $data['mainBreadcrumb'] =  $this->addmainBreadcrumb($viewId);
      $requestMain = \Config\Services::request();
      $data['currentpage'] = $requestMain->uri->getSegment(2);
      //$data['attributes'] = array();
      echo view('category',$data);
   }
   public function addmainBreadcrumb($catid){
    $db = \Config\Database::connect();
    $query = $db->query("SELECT name FROM categories WHERE id='".$catid."'");
    return $query->getResult('array');
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
/*------------------------Add breadcrumb-------------------*/
   public function addcatBreadcrumb($listingArr){
    $db = \Config\Database::connect();
    foreach ($listingArr as $key => $value) {
      $query = $db->query("SELECT m.name AS parent_cat,e.name AS child_cat FROM categories e INNER JOIN categories m ON e.parent_id = m.id WHERE e.id='".$value['category_id']."'");
      $listingArr[$key]['categories'] = $query->getResult('array');
    }
    return $listingArr;
   }

  public function filter(){
      $db = \Config\Database::connect();
 
$allattname= explode(",", $_POST['allattname']);

// print_r($allattname);

$allattributes = array();

    // echo "<pre>";
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
// print_r($allattributes);

    $mainCategoryId = $_POST['mainCategoryId'];
    $fromRupees = $_POST['fromRupees'];
    $toRupees = $_POST['toRupees'];
    // $mainCategoryId = 99;
// print_r($mainCategoryId);
      $filter = new Filter();
      $data = array();
      $cat = new Categories();
      $cat1 = new Categories();
    $att_filterArray = array();

// $str = "";
// $i=0;
// foreach ($allattributes as $key => $value) {
//   if($i==0){
//    $str = "(attribute_id='".$value."'";
//   }else{
//     $str .= " AND attribute_id='".$value."'";
//   }
//   $i++;
// }
// $str .= ')';

// $query = ;

// foreach ($allattributes as $key4 => $value4) {

  // $queryatt = $db->query("SELECT * From rel_listing_attributes WHERE attribute_id IN ("implode(',', $allattributes)") GROUP BY attribute_id");
  // $result = array();
  // foreach ($queryatt->getResult() as $rowatt)
  // {
  //         print_r($rowatt);
  //         // $temp['id'] = $row->id;
  //         // $temp['title'] = $row->title;
  //         // $temp['images'] = $row->images;
  //         // $temp['price'] = $row->price;
  //         // $temp['location'] = $row->location;
  //         // $temp['featured'] = $row->featured;
  //         // $temp['category_id'] = $row->category_id;
  //         // $temp['description'] = $row->description;
  //         // $temp['date'] = $row->date;
  //         // $temp['modified_date'] = $row->modified_date;
  //         // $temp['premium'] = $row->premium;
  //         // $temp['user_id'] = $row->user_id;
  //         // $temp['valid'] = $row->valid;
  //         // $temp['deleted'] = $row->deleted;
  //         // array_push($result, $temp);

  // }
// }


// print_r($str);
    // foreach ($variable as $key => $value) {
        # code...
    $i=0;
      foreach ($allattributes as $key2 => $value2) {
        $att_filter = new AttributesFilter();
// echo "<pre>";
        // print_r($value2);
        if(is_array($value2)){
          // echo count($value2);
          if(count($value2)>1){

              $query = $db->query("SELECT listing_id FROM rel_listing_attributes WHERE attribute_id in(".implode(',', $value2).")");

              $result = array();
              foreach ($query->getResult() as $row)
              {
                      // print_r($row);
                      
                      // $temp['title'] = $row->title;
                      // $temp['images'] = $row->images;
                      // $temp['price'] = $row->price;
                      // $temp['location'] = $row->location;
                      // $temp['featured'] = $row->featured;
                      // $temp['category_id'] = $row->category_id;
                      // $temp['description'] = $row->description;
                      // $temp['date'] = $row->date;
                      // $temp['modified_date'] = $row->modified_date;
                      // $temp['premium'] = $row->premium;
                      // $temp['user_id'] = $row->user_id;
                      // $temp['valid'] = $row->valid;
                      // $temp['deleted'] = $row->deleted;
                      array_push($result, $row->listing_id);

              }

              $att[$i] = $result;
              // print_r($att);
            // $data = $att_filter->where('attribute_id',$value2)->findAll();
            // $temp =array();
            // foreach ($data as $key => $value){
            //     // $att_filterArray[] = $value['listing_id'];
            //     array_push($temp, $value['listing_id']);
            // }
            // $att[$i] = $temp;

          }else{
            $data = $att_filter->where('attribute_id',$value2)->findAll();
            $temp =array();
            foreach ($data as $key => $value){
                // $att_filterArray[] = $value['listing_id'];
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
// echo "</pre>";
        $i++;
      }

    // }
// echo "<pre>";
  // print_r($att);
  // print_r($att_filterArray);
  // print_r(extract($att));
  // print_r(array_intersect(extract($att)));

$att_filterArray = $att[0];

for ($i = 1; $i < count($att); $i++){
  $att_filterArray = array_intersect($att_filterArray, $att[$i]);
  // print_r($att_filterArray);
}

// echo "</pre>";
// print_r($att_filterArray);

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
    // print_r($attArray);
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

if(count($att_filterArray)>0){
  $att_cond =  " AND id in(".implode(',', $att_filterArray).")";
}else{
  $att_cond = " AND 1=1";
}

// echo "SELECT * FROM listing WHERE category_id=$mainCategoryId".$att_cond;
// echo "SELECT * FROM listing WHERE AND price between $fromRupees AND $toRupees AND category_id=$mainCategoryId".$att_cond;
$query = $db->query("SELECT * FROM listing WHERE price between $fromRupees AND $toRupees AND category_id=$mainCategoryId".$att_cond);

$result = array();
foreach ($query->getResult() as $row)
{
        // print_r($row);
        $temp['id'] = $row->id;
        $temp['title'] = $row->title;
        $temp['images'] = $row->images;
        $temp['price'] = $row->price;
        $temp['location'] = $row->location;
        $temp['featured'] = $row->featured;
        $temp['category_id'] = $row->category_id;
        $temp['description'] = $this->charlimit($row->description, 60);
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
            unset($result[$key]);
         }
      }
      $randomkey = rand(0,count($premium)-1);
      shuffle($featured);

      // print_r($premium[$randomkey]);
      //$data['message'] = $message;
      $cat1 = new Categories();
      $settings = new Settings();
      $States = new States();
      $country_id = session()->get("country_id")?session()->get("country_id"):'101';
      $States->where('country_id',$country_id);
      $data['extras']['states'] = $States->findAll();
      $data['extras']['hotlinks'] = $settings->findAll();
      $data['extras']['selectedState'] = session()->get("state_id");
	    $data['categories'] = $cat1->findAll();
      $data['premiumlisting'][0] = $premium[$randomkey];
      $data['listing'] = $result;
      $data['featured'] = $featured;
      $data['mainCategory'] = $cat;
      $data['parentCategory'] = $cat1;
      $requestMain = \Config\Services::request();
      $data['currentpage'] = $requestMain->uri->getSegment(2);
    echo view('filter', $data);
  }
	//--------------------------------------------------------------------


  public function charlimit($string, $limit) {
    return substr($string, 0, $limit) . (strlen($string) > $limit ? "..." : '');
  }

}