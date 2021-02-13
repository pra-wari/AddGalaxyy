<?php

namespace App\Controllers;

use App\Models\Categories;
use App\Models\Settings;
use App\Models\States;
use App\Models\Countries;
use App\Models\Cities;
use App\Models\Keywords;
use App\Models\Plans;
use CodeIgniter\Config\Config;
use CodeIgniter\Controller;
use CodeIgniter\I18n\Time;

class Home extends BaseController
{
  public function setLocation(){
    $data = [
       'country_id' => "101",
      'state_id' => "10",
      'city_id' => "706",
      'region_id' => ""
    ];
    $session = \Config\Services::session();
    $db = \Config\Database::connect();
    // $ip = $_SERVER['REMOTE_ADDR'];
    // $ip_address = isset($_SERVER['HTTP_X_REAL_IP'])?$_SERVER['HTTP_X_REAL_IP']:'45.248.31.9';

    // $query1 = json_decode(file_get_contents("https://tools.keycdn.com/geo.json?host=".$ip_address),true);
    // $query = $query1['data']['geo'];
    
    //   $resquery = $db->query("Select id from countries where sortname='".$query['country_code']."'");
    //   $result = $resquery->getResult('array');
      // if(count($result)>0){
      //   $data['country_id']=$result[0]['id'];
      // }
      // $resquery1 = $db->query("Select id from states where name='".$query['region_name']."'");
      // $result1 = $resquery1->getResult('array');
      // if(count($result1)>0){
      //   $data['state_id']=$result1[0]['id'];
      // }
      // $resquery2 = $db->query("Select id from cities where name='".$query['city']."'");
      // $result2 = $resquery2->getResult('array');
      // if(count($result2)>0){
      //   $data['city_id']=$result2[0]['id'];
      // }
      session()->set($data);
  }

	public function index()
   {
   
    // $uri = $this->request->uri;
    // $city = $uri->getPath();
    //echo $city;
    
    
    
    $sessionStateId= session()->get('state_id');
     //var_dump($sessionStateId);
    
     if(!isset($sessionStateId) || $sessionStateId==''){
        $this->setLocation();
     }
    
    $db = \Config\Database::connect();
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
    // echo "<pre>";
    // var_dump($catArray);
    // echo "</pre>";
    foreach ($catArray as $k => $v) {
      foreach ($data as $key => $value1){
        if($v['id']==$value1['parent_id']){
          $catArray[$k]['subCategory'][] = $value1; 
        }else{
          //$catArray[$k]['subCategory'][] = array(); 
        }
      }
    }
    $count = array();
    foreach ($catArray as $key => $value) {
      $catArray[$key]['count']=0;
      foreach ($value['subCategory'] as $k1 => $v1) {
     
        $state_id = session()->get('state_id');
        $city_id = session()->get('city_id');

        $res = $db->query("select count(*) from listing where category_id='".$v1['id']."' 
        and deleted=0 and  state_id = '".$state_id."' and city_id = '".$city_id."' 
        ");
        foreach ($res->getResult('array') as $row) {
          $catArray[$key]['subCategory'][$k1]['count'] = $row['count(*)'];
          $catArray[$key]['count'] += $row['count(*)'];
        }
      }
    }

    $city = new Cities();
    $city_row = $city->where(array('id'=>session()->get('city_id')))->findAll();
    $state = new States();
    $state_row = $state->where('id',session()->get('state_id'))->findAll();
    $country = new Countries();
    $country_row = $country->where('id',session()->get('country_id'))->findAll();
    $city_name = $city_row[0]['name'];
    $state_name = $state_row[0]['name'];
    $country_name = $country_row[0]['name'];
    $data['location'] = "$city_name , $state_name , $country_name";
   

    $settings = new Settings();
    $States = new States();
		$country_id = session()->get("country_id")?session()->get("country_id"):'101';
		$States->where('country_id',$country_id);
		$data['extras']['states'] = $States->findAll();
		$data['extras']['hotlinks'] = $settings->findAll();
		$data['extras']['selectedState'] = session()->get("state_id");
    $data['categories'] = $catArray;
    $requestMain = \Config\Services::request();
    $data['currentpage'] = 'home';
    $pager = \Config\Services::pager();
    $data['message'] = $message;
    //$data['location'] = "NEPAL";
    
    echo view('home', $data);
  }


  public function search()
  {
    $keywords = new Keywords();
    $data = array();
    $results = array();
    $listingIds = array();
    $db = \Config\Database::connect();
    if ($this->request->getMethod() == 'post') {
      $request = $this->request->getVar();
      $condition='';
      if($request['region']!=''){
        $condition="state_id='".$request['region']."' and ";
      }
      if($request['category']=='all'){
        
        $query_keyword = $db->query("Select listing_id from keywords where $condition keywords like '%".$request['keyword']."%'");

        $query_keyword1 = $db->query("Select id from listing where $condition category_id IN (Select id from categories where parent_id ='".$request['category']."') and title like '%".$request['keyword']."%' or description like '%".$request['keyword']."%'");
        

      }else{
        
        // $query_keyword = $db->query("Select listing_id from keywords where $condition category_id='".$request['category']."' and keywords like '%".$request['keyword']."%'");
        $query_keyword = $db->query("Select listing_id from keywords where $condition category_id IN (Select id from categories where parent_id ='".$request['category']."') and keywords like '%".$request['keyword']."%'");

        $query_keyword1 = $db->query("Select id from listing where $condition category_id IN (Select id from categories where parent_id ='".$request['category']."') and title like '%".$request['keyword']."%' or description like '%".$request['keyword']."%'");
      }
      foreach ($query_keyword->getResult('array') as $row) {
        $listingIds[] = $row['listing_id'];
      }
      foreach ($query_keyword1->getResult('array') as $row) {
        $listingIds[] = $row['id'];
      }
    }
    if(count($listingIds)>0){
        $listingIds1 = implode(',',$listingIds);
        $query = $db->query("Select * from listing where id IN (".$listingIds1.")");
        $result = $query->getResult('array');
		$data['listing'] = $result;
    }else{
        $result=array();
        $data['listing'] = $result;
    }
    $request = \Config\Services::request();
		
		$viewId=0;
		$session = session();
		$userid = $session->get('id');
		$cat = new Categories();
		$cat1 = new Categories();
		$data1 = $cat->findAll();
		$catArray = array();
		foreach ($data1 as $key => $value){
			if($value['parent_id']==0){
				$value['current']=false;
				$catArray[] = $value; 
			}
		}
		
		foreach ($catArray as $k => $v) {
			foreach ($data1 as $key => $value1){
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
    $cat2 = array();
		$cat2[0]['id']='0';
		$cat2[0]['name']='asd';
		$cat2[0]['parent_id']='0';
		$settings = new Settings();
		$States = new States();
		$country_id = session()->get("country_id")?session()->get("country_id"):'101';
		$States->where('country_id',$country_id);
		$data['extras']['states'] = $States->findAll();
		$data['extras']['hotlinks'] = $settings->findAll();
		$data['extras']['selectedState'] = session()->get("state_id");
		$data['categories'] = $catArray;
		$data['mainCategory'] = $cat2;
		$data['attributes'] = array();	
		$data['sgallery'] = array();
		$data['premiumlisting']=array();
		$data['userid']=$userid;
		$data['totalads'] = count($result);
		$data['currentpage'] = $request->uri->getSegment(2);
		$data['module'] = $request->uri->getSegment(1);
		$data['pager'] = false;
		return view('userads',$data);
  }
  public function country()
  {
    $db = \Config\Database::connect();


    $countrytxt = '<select name="country" id="country-sel"
                      onchange="getState(this.value); setFooterdata(); getCountry(this.value);get_state_modal(this.value)">
                      <option value="">Select</option>
                      <option value="101" onclick="get_state_modal(this.value)">India</option>
                      ';
    $query_country = $db->query("SELECT * FROM countries ORDER BY name ASC");
    foreach ($query_country->getResult() as $row_country) {
      $id = $row_country->id;
      $name = $row_country->name;
      $selected  = "";
      if (session()->get("country_id") == $id) {
        $selected = "selected";
      }

      $countrytxt .= '<option value="' . $id . '" ' . $selected . '>' . $name . '</option>';
    }
    $countrytxt .= " </select>";
    print_r($countrytxt);
  }
  public function getcountry(){
    $country_id = $_POST['con'];
    $db = \Config\Database::connect();
    $statetxt = '';
    $query_state = $db->query("SELECT * FROM countries");
    foreach ($query_state->getResult() as $row_state) {
      $id = $row_state->id;
      $name = $row_state->name;
      $statetxt .= '<option value="' . $id . '">' . $name . '</option>';
    }
    //$statetxt .= " </select>";
    print_r($statetxt);
  }
  public function getState()
  {
    // unset($_SESSION['state']);
    // unset($_SESSION['city']);
    // unset($_SESSION['region']);

    $country_id = $_POST['con'];
    $data = [
      'country_id' => $country_id,
      'state_id' => "",
      'city_id' => "",
      'region_id' => ""
    ];
    session()->set($data);
    $db = \Config\Database::connect();
    $statetxt = '<select name="state" id="state-sel"
                      onchange="getCity(this.value); setFooterdata();">
                      <option value="">Select State</option>
                      ';
    $query_state = $db->query("SELECT * FROM states WHERE country_id = " . $country_id . " ORDER BY name ASC");
    foreach ($query_state->getResult() as $row_state) {
      $id = $row_state->id;
      $name = $row_state->name;
      $statetxt .= '<option value="' . $id . '">' . $name . '</option>';
    }
    $statetxt .= " </select>";
    print_r($statetxt);
  }

  public function getStateforplan()
  {
    $country_id = $_POST['con'];
    $data = [
      'country_id' => $country_id,
      'state_id' => "",
      'city_id' => "",
      'region_id' => ""
    ];
    session()->set($data);
    $db = \Config\Database::connect();
    $statetxt = '';
    $query_state = $db->query("SELECT * FROM states WHERE country_id = " . $country_id . " ORDER BY name ASC");
    foreach ($query_state->getResult() as $row_state) {
      $id = $row_state->id;
      $name = $row_state->name;
      $statetxt .= '<option value="' . $id . '">' . $name . '</option>';
    }
    //$statetxt .= " </select>";
    print_r($statetxt);
  }
  public function getPlans()
  {
    $db = \Config\Database::connect();
    $region = $_POST['con'];
    $plans = new Plans();
    $plans->where('deleted',0);
    $plansData = $plans->findAll();

    $citytxt = '<select name="selectPlan" id="plan-sel"
                      onchange="getPlanmeta(this.value);">
                      <option value="">Select Plan</option>
                      ';
    foreach ($plansData as $row_city) {
      $id = $row_city['id'];
      $name = $row_city['plan_name'];
      $citytxt .= '<option value="' . $id . '">' . $name . '</option>';
    }
    $citytxt .= " </select>";
    print_r($citytxt);
  }
  public function upgrade(){
    $db = \Config\Database::connect();
    print_r($this->request->getVar());
    $request = $this->request->getVar();
    if($request['selectPlanmeta']){
      $res = $db->query("select planindays from plans_meta where id='".$request['selectPlanmeta']."'");
      foreach ($res->getResult('array') as $key1 => $value1) {
        $endtime = new Time('+'.$value1['planindays'].' days');
        $start = Time::now();
        $db->query("update users_plan_relation set plan_id='".$request['upgradeplanId']."',plan_start_date='".$start."',plan_end_date='".$endtime."' where listing_id='".$request['upgradeListingId']."' and plan_id='".$request['upgradeexistingId']."'");
      }
    }
      return redirect()->to(base_url('/admin/allads'));
    
  }

  public function getPlansmeta(){
    $db = \Config\Database::connect();
    $plan_id = $_POST['con'];
    $region = $_POST['region'];
    $db = \Config\Database::connect();
    $citytxt = '<select name="selectPlanmeta" id="plan-sel"
                      onchange="upgrade(this.value);">
                      <option value="">Select Plan Duration</option>
                      ';
    $plansmeta = $db->query("Select * from plans_meta where plan_id='".$plan_id."' and region_id='".$region."'");
    if(count($plansmeta->getResult('array'))>0){
      foreach ($plansmeta->getResult('array') as $key1 => $value1) {
        $citytxt .='<option value="'.$value1['id'].'">'.$value1['plan_duration'].' ('.$value1['plan_price'].')</option>';
      }
    }else{
      $plansmeta1 = $db->query("Select * from plans_meta where plan_id='".$plan_id."' and plan_type='defoult'");
      foreach ($plansmeta1->getResult('array') as $key1 => $value1) {
        $citytxt .='<option value="'.$value1['id'].'">'.$value1['plan_duration'].' (RS '.$value1['plan_price'].')</option>';
      }
    }
    $citytxt .='</select>'; 
    print_r($citytxt);
  }

  public function suggestCity(){
    $db = \Config\Database::connect();
    $pattern = $_POST['pat'];

    $citytxt = '<ul  id="cityText">';
          
    $query_city = $db->query("SELECT * FROM cities WHERE name LIKE  '" . $pattern . "%' ORDER BY name ASC LIMIT 20");
    foreach ($query_city->getResult() as $row_city) {
      $id = $row_city->id;
      
      $query_state = $db->query("SELECT * FROM states WHERE id = $row_city->state_id");
      $row_state = $query_state->getResult();
      $row_state = $row_state[0];
      $state_name = $row_state->name;

      $query_country = $db->query("SELECT * FROM countries WHERE id = $row_state->country_id");
      $row_country = $query_country->getResult();
      $country_name = $row_country[0]->name;

      
      $name = $row_city->name;
      $citytxt .= '<li id="' . $id . '" onclick="selectCity(' . $id . ')" value="' . $id . '">' . $name .' , '. $state_name.' , '. $country_name.'</li>';
    }
     $citytxt .= " </ul>";
     print_r($citytxt);

  }

  public function getCity()
  {
    $db = \Config\Database::connect();
    
    $state_id = $_POST['con'];
    $data = [
      'state_id' => $state_id
    ];
    session()->set($data);

    $citytxt = '<select name="city" id="city-sel"
                      onchange="getRegion(this.value); setFooterdata();">
                      <option value="">Select City</option>
                      ';
    $query_city = $db->query("SELECT * FROM cities WHERE state_id = " . $state_id . " ORDER BY name ASC");
    foreach ($query_city->getResult() as $row_city) {
      $id = $row_city->id;
      $name = $row_city->name;
      $citytxt .= '<option value="' . $id . '">' . $name . '</option>';
    }
    $citytxt .= " </select>";
    print_r($citytxt);
     
  }
  public function selectLocation(){
    $id = $_POST['city_id'];
    $name = $_POST['city_name'];
    $db = \Config\Database::connect();
    $query = $db->query("SELECT * FROM cities WHERE id = ".$id."");
    $row = $query->getResult();
    $state_id = $row[0]->state_id;
    $query = $db->query("SELECT * FROM states WHERE id = ".$state_id."");
    $row = $query->getResult();
    $state_name = $row[0]->name;
    $country_id = $row[0]->country_id;
    $data = [
      'country_id' => "$country_id",
     'state_id' => "$state_id",
     'city_id' => "$id",
     'region_id' => ""
   ];
   session()->set($data);
   echo($state_name);
  }
  public function getcitiesforplan()
  {
    $db = \Config\Database::connect();
    $state_id = $_POST['con'];
    $data = [
      'state_id' => $state_id
    ];
    session()->set($data);

    $citytxt = '';
    $query_city = $db->query("SELECT * FROM cities WHERE state_id = " . $state_id . " ORDER BY name ASC");
    foreach ($query_city->getResult() as $row_city) {
      $id = $row_city->id;
      $name = $row_city->name;
      $citytxt .= '<option value="' . $id . '">' . $name . '</option>';
    }
    $citytxt .= "";
    print_r($citytxt);
  }
  public function getRegionforplan(){
    $db = \Config\Database::connect();
    $city_id = $_POST['con'];
    $data = [
      'city_id' => $city_id
    ];
    session()->set($data);
    $regiontxt = '';
    $query_city = $db->query("SELECT * FROM region WHERE city_id = " . $city_id . " ORDER BY name ASC");
    foreach ($query_city->getResult() as $row_city) {
      $id = $row_city->id;
      $name = $row_city->name;
      $regiontxt .= '<option value="' . $id . '">' . $name . '</option>';
    }
    $regiontxt .= "";
    print_r($regiontxt);
  }

  public function getRegion()
  {
    $db = \Config\Database::connect();
    $city_id = $_POST['con'];
    $data = [
      'city_id' => $city_id
    ];
    session()->set($data);

    $regiontxt = '<select name="region" id="region-sel"
                      onchange="setRegion(this.value);">
                      <option value="">Select Region</option>
                      ';
    $query_city = $db->query("SELECT * FROM region WHERE city_id = " . $city_id . " ORDER BY name ASC");
    foreach ($query_city->getResult() as $row_city) {
      $id = $row_city->id;
      $name = $row_city->name;
      $regiontxt .= '<option value="' . $id . '">' . $name . '</option>';
    }
    $regiontxt .= " </select>";
    print_r($regiontxt);
  }
  public function setFooterData()
  {
    $db = \Config\Database::connect();

    $country_id = session()->get("country_id");
    if ($country_id != "") {

      $dataArray = array();
      $stateArray = array();
      $query_state = $db->query("SELECT * FROM states WHERE country_id = " . $country_id . " ORDER BY name ASC");
      foreach ($query_state->getResult() as $row_state) {
        $temp = array();
        $temp['id'] = $row_state->id;
        $temp['name'] = $row_state->name;
        array_push($stateArray, $temp);
      }
      $dataArray['state'] = $stateArray;

      $state_id = session()->get("state_id");
      if ($state_id != "") {

        $cityArray = array();
        $query_city = $db->query("SELECT * FROM cities WHERE state_id = " . $state_id . " ORDER BY name ASC");
        foreach ($query_city->getResult() as $row_city) {
          $temp = array();
          $temp['id'] = $row_city->id;
          $temp['name'] = $row_city->name;
          array_push($cityArray, $temp);
        }
        $dataArray['city'] = $cityArray;

        $city_id = session()->get("city_id");
      if ($city_id != "") {

        $regionArray = array();
        $query_region = $db->query("SELECT * FROM region WHERE city_id = " . $city_id . " ORDER BY name ASC");
        foreach ($query_region->getResult() as $row_region) {
          $temp = array();
          $temp['id'] = $row_region->id;
          $temp['name'] = $row_region->name;
          array_push($regionArray, $temp);
        }
        $dataArray['region'] = $regionArray;
      }
      }
      print_r(json_encode($dataArray));
    }
  }

  public function setRegion()
  {
    $region_id = $_POST['con'];
    $data = [
      'region_id' => $region_id
    ];
    session()->set($data);

    print_r($_POST['con']);
  }
  public function setCity()
  {
    $city_id = $_POST['con'];
    $data = [
      'city_id' => $city_id,
      'region_id' => ""
    ];
    session()->set($data);

    print_r($_POST['con']);
  }
  public function setState()
  {
    $state_id = $_POST['con'];
    
    $data = [
      'state_id' => $state_id,
      'city_id' => "",
      'region_id' => ""
    ];
    session()->set($data);

    print_r($_POST['con']);
  }
}
