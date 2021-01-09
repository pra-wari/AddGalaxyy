<?php namespace App\Controllers;
use App\Models\Categories;
use App\Models\Listing;
use CodeIgniter\Config\Config;
use CodeIgniter\Controller;
use App\Models\ListingImages;
use App\Models\Enquiry;
use App\Models\Chat;
use App\Models\Settings;
use App\Models\States;
use CodeIgniter\I18n\Time;

class Ads extends Controller
{
	public function view($viewId){
      $db = \Config\Database::connect();
      $listing = new Listing();
      $categories = new Categories();
      $ListingImages = new ListingImages();
      $result = $listing->where('id',$viewId)->findAll();
      $result[0]['images'] = $ListingImages->where('listing_id',$viewId)->findAll();
      $result1 = $categories->where('id',$result[0]['category_id'])->findAll();
      $res = $db->query("SELECT attributes.`attribute_name`,attribute_options.`option_name` FROM attribute_options INNER JOIN attributes ON attributes.`id`=attribute_options.`parent_attribute_id` WHERE attribute_options.id IN (SELECT attribute_id FROM rel_listing_attributes WHERE listing_id='".$result[0]['category_id']."')");
      $result[0]['attributes'] = $res->getResult('array');
      $res1 = $db->query("SELECT region.name AS region,cities.name AS city,states.name AS state,countries.name AS country  FROM region 
      INNER JOIN cities ON region.`city_id` = cities.id
      INNER JOIN states ON cities.`state_id` = states.id
      INNER JOIN countries ON states.`country_id` = countries.id
      WHERE region.`id` = '".$result[0]['location']."'");
      $result[0]['location'] = $res1->getResult('array');
      
      $data = array();
      $settings = new Settings();
      $States = new States();
      $country_id = session()->get("country_id")?session()->get("country_id"):'101';
      $States->where('country_id',$country_id);
      $data['extras']['states'] = $States->findAll();
      $data['extras']['hotlinks'] = $settings->findAll();
      $data['extras']['selectedState'] = session()->get("state_id");
      $category_id=$result[0]['category_id'];
      $data['listing'] = $result;
      $data['categories1'] = $result1;
      $data['mainBreadcrumbs'] =  $this->addmainBreadcrumb($viewId);
      $cat1 = new Categories();
	$data['categories'] = $cat1->findAll();
      $query = $db->query('select * from users where id='.$result[0]['user_id']);
      $data['user'] = $query->getResult();
      $requestMain = \Config\Services::request();
      $data['currentpage'] = $requestMain->uri->getSegment(2);
      $db->query('update listing set views = views+1 where id='.$viewId);
      echo view('ad-detail',$data);
       }

       public function addmainBreadcrumb($adid){
            $db = \Config\Database::connect();
            $query = $db->query("SELECT m.id AS parent_id,m.name AS parent_cat,e.id AS child_id,e.name AS child_cat 
            FROM categories e INNER JOIN categories m ON e.parent_id = m.id 
            INNER JOIN listing ON listing.`category_id` = e.id
            WHERE listing.id='".$adid."'");
            return $query->getResult('array');
       }
       
       public function addReport(){
            $request = $this->request->getVar();
            $response = array();
            $db = \Config\Database::connect();
            $query = $db->query("INSERT INTO report (ad_id, owner_id,sender_id,sender_name,report_message,created_date,modified_date)
		VALUES ('".$request['ad_id']."','".$request['owner_id']."','".$request['sender_id']."','".$request['sender_name']."','".$request['message']."','".Time::now()."','".Time::now()."')");
            //return $query->getResult('array');
            $response['status'] = 'success';
            $response['msg'] = 'Ad Reported Successfully';
            echo json_encode($response);
       }
       
       public function addChat(){
            $request = $this->request->getVar();
            $response = array();
            $enquiry = new Enquiry();
            $chat = new Chat();
            $enquiryData = [
                  'ad_id'=>$request['ad_id'],
                  'owner_id' => $request['owner_id'],
                  'sender_id' => $request['sender_id'],
                  'sender_name' => $request['sender_name'],
                  'sender_email' => $request['sender_email'],
                  'sender_mobile' => $request['sender_mobile'],
                  'created_date' => Time::now(),
                  'modified_date' => Time::now(),
            ];
            $enquiry->save($enquiryData);
            $insertedId = $enquiry->insertID();
            if($insertedId){
                  $chatData = [
                        'enquiry_id'=>$insertedId,
                        'sender_id'=>$request['sender_id'],
                        'message'=>$request['message'],
                        'created_date'=>Time::now(),
                  ];
                  $chat->save($chatData);
                  $chatinsertedId = $chat->insertID();
                  if($chatinsertedId){
                        $response['status'] = 'success';
                        $response['msg'] = 'Enquiry Sent Successfully';
                        echo json_encode($response);
                  }else{
                        $response['status'] = 'failed';
                        $response['msg'] = 'Enquiry failed.';
                        echo json_encode($response);
                  }
            }else{
                  $response['status'] = 'failed';
                  $response['msg'] = 'Enquiry failed.';
                  echo json_encode($response);
            } 
       }

}