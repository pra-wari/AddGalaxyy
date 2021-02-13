<?php namespace App\Controllers;
use App\Models\Categories;
use App\Models\Listing;
use App\Models\UserModel;
use App\Models\Plans;
use App\Models\PlansMeta;
use App\Models\Attributes;
use App\Models\Invoice;
use App\Models\Settings;
use App\Models\States;
use App\Models\Countries;
use App\Models\Cities;
use App\Models\Region;
use App\Models\Pages;
use App\Models\Keywords;
use App\Models\Transactions;
use App\Models\ListingImages;
use App\Models\UsersPlanRelationship;
use App\Models\RelListingAttribute;
use App\Models\MainAttributes;
use App\Models\AdminEnquiry;
use CodeIgniter\Config\Config;
use CodeIgniter\Controller;
use CodeIgniter\I18n\Time;

class Admin extends Controller
{
	public function checkLogin(){
		$session = session();
		$userid = $session->get('id');
		if(!$userid){
			return redirect()->to(base_url('/'));
		}
	}
	public function index()
	{	
		$session = session();
		$userid = $session->get('id');
		if(!$userid){
			return redirect()->to(base_url('/'));
		}
		$data = array();
		$cat1 = new Categories();
	    $data['categories'] = $cat1->findAll(); 
		$request = \Config\Services::request();
		$listing = new Listing();
		$listing->where('deleted',0);
		$listing->where('user_id',$userid);
		$pager = \Config\Services::pager();
		$settings = new Settings();
		$States = new States();
		$country_id = session()->get("country_id")?session()->get("country_id"):'101';
		$States->where('country_id',$country_id);
		$data['extras']['states'] = $States->findAll();
		$data['extras']['hotlinks']=$settings->findAll();
		$data['extras']['selectedState'] = session()->get("state_id");
		
		$data['listing'] = $listing->paginate(6);
		$data['currentpage'] = $request->uri->getSegment(2);
		$data['module'] = $request->uri->getSegment(1);
		$data['pager'] = $listing->pager;
		return redirect()->to(base_url('/admin/allads'));
		//return view('admin-dashboard',$data);
	}
	public function editlisting($listId){
		helper(['form', 'reCaptcha']);
		$session = session();
		$userid = $session->get('id');
		if(!$userid){
			return redirect()->to(base_url('/'));
		}
		$data = array();
		$cat1 = new Categories();
		$cat2 = new Categories();
		$countries = new Countries();
		$request = \Config\Services::request();
		$db = \Config\Database::connect();
		$cat1->where('parent_id',0);
	    $data['categories'] = $cat1->findAll();
		$listing = new Listing();
		$settings = new Settings();
		$States = new States();
		$country_id = session()->get("country_id")?session()->get("country_id"):'101';
		$States->where('country_id',$country_id);
		$data['extras']['states'] = $States->findAll();
		$data['extras']['hotlinks'] = $settings->findAll();
		$data['extras']['selectedState'] = session()->get("state_id");
		$listing->where('deleted',0);
		$result = $listing->where('id',$listId)->findAll();
		foreach($result as $key=>$value){
		    $sql="SELECT * FROM categories WHERE parent_id=(SELECT parent_id FROM categories WHERE id='".$value['category_id']."')";
		    $res = $db->query($sql);
			$result[$key]['subcategories'] = $res->getResult('array');
			$sql1="SELECT * FROM categories WHERE id=(SELECT parent_id FROM categories WHERE id='".$value['category_id']."')";
		    $res1 = $db->query($sql1);
			$result[$key]['parentcategoriesData'] = $res1->getResult('array');
			if(count($result[$key]['parentcategoriesData'])>0){
				$sql2="SELECT * FROM attributes WHERE parent_category_id='".$result[$key]['parentcategoriesData'][0]['id']."'";
				$res2 = $db->query($sql2);
				$result[$key]['attributes'] = $res2->getResult('array');
				foreach ($result[$key]['attributes'] as $key1 => $value1) {
					$sql2="SELECT * FROM attribute_options WHERE parent_attribute_id='".$value1['id']."'";
					$res2 = $db->query($sql2);
					$result[$key]['attributes'][$key1]['options'] = $res2->getResult('array');
				}
			}
			$sql3="SELECT * FROM listing_images WHERE listing_id='".$value['id']."'";
			$res3 = $db->query($sql3);
			$result[$key]['images'] = $res3->getResult('array');
			$sql5="SELECT * FROM keywords WHERE listing_id='".$value['id']."'";
			$res5 = $db->query($sql5);
			$result[$key]['keywords'] = $res5->getResult('array');
			$sql3="SELECT * FROM rel_listing_attributes WHERE listing_id='".$value['id']."'";
			$res3 = $db->query($sql3);
			$attir=array();
			foreach ($res3->getResult('array') as $k21 => $v21) {
				$attir[]=$v21['attribute_id'];
			}
			$result[$key]['selectedAttribute'] = $attir;
		}
		$queryplan = $db->query("SELECT * FROM plans WHERE valid=1 AND deleted=0");
		$planArray = array();
		foreach ($queryplan->getResult() as $rowplan)
		{
			$temp['id'] = $rowplan->id;
			$temp['plan_name'] = $rowplan->plan_name;
			$temp['type'] = $rowplan->type;
			

			$query_planmeta = $db->query("SELECT * FROM plans_meta WHERE valid=1 AND deleted=0 AND state_id='".$result[0]['state_id']."' AND plan_id=".$temp['id']);
			$result_subatt = array();
			$i=0;
			$temp3 = array();
			$resPlanmeta =$query_planmeta->getResult();
			if(count($resPlanmeta)>0){
				foreach ($query_planmeta->getResult() as $row_subatt)
				{
					$temp2['id'] = $row_subatt->id;
					$temp2['plan_duration'] = $row_subatt->plan_duration;
					$temp2['plan_price'] = $row_subatt->plan_price;
					$temp2['plan_id'] = $temp['id'];
					array_push($temp3, $temp2);
					$i++;
				}
			}else{
				$query_planmeta1 = $db->query("SELECT * FROM plans_meta WHERE valid=1 AND deleted=0 AND plan_type='defoult' AND plan_id=".$temp['id']);
				foreach ($query_planmeta1->getResult() as $row_subatt)
				{
					$temp2['id'] = $row_subatt->id;
					$temp2['plan_duration'] = $row_subatt->plan_duration;
					$temp2['plan_price'] = $row_subatt->plan_price;
					$temp2['plan_id'] = $temp['id'];
					array_push($temp3, $temp2);
					$i++;
				}
			}
			$temp['meta']=$temp3;
			array_push($planArray, $temp);
		}
		$data['plans'] = $planArray;
		$data['currentpage'] = $request->uri->getSegment(2);
		$data['module'] = $request->uri->getSegment(1);
		$data['listing'] = $result;
		$data['countries'] = $countries->findAll();
		return view('edit-listing',$data);
	}

	public function deletelisting($listId){
		$request = \Config\Services::request();
		$session = session();
		$userid = $session->get('id');
		if(!$userid){
			return redirect()->to(base_url('/'));
		}
		$listing = new Listing();
		$listingData = [
			'id'=>$listId,
			'deleted' => 1
		];
		$listing->save($listingData);
		$session = session();
        $session->setFlashdata('success', 'Successfully deleted the listing');
		return redirect()->to(base_url('/admin'));
	}

	public function updatepassword($listId){
		$session = session();
		$userid = $session->get('id');
		if(!$userid){
			return redirect()->to(base_url('/'));
		}
		$request = \Config\Services::request();
		$data = array();
		$cat1 = new Categories();
	    $data['categories'] = $cat1->findAll();
		$model = new UserModel();
		$user = $model->where('id', $listId)->first();
		$settings = new Settings();
		$States = new States();
		$country_id = session()->get("country_id")?session()->get("country_id"):'101';
		$States->where('country_id',$country_id);
		$data['extras']['states'] = $States->findAll();
		$data['extras']['hotlinks'] = $settings->findAll();
		$data['extras']['selectedState'] = session()->get("state_id");
		$data['user'] = $user;
		$data['module'] = $request->uri->getSegment(1);
		$data['currentpage'] = $request->uri->getSegment(2);
		return view('update-password',$data);
	}
	
	public function report($listId){
		$session = session();
		$userid = $session->get('id');
		if(!$userid){
			return redirect()->to(base_url('/'));
		}
		$db = \Config\Database::connect();
		$query = $db->query("Select * from report");
		$data = array();
		$request = \Config\Services::request();
		$pages = new Pages();
		$pages->where('deleted',0);
		$pager = \Config\Services::pager();
		$cat1 = new Categories();
		$settings = new Settings();
		$States = new States();
		$response = $query->getResult('array');
		foreach ($response as $key => $value) {
			$query1 = $db->query("Select email from users where id='".$value['owner_id']."'");
			$response[$key]['owner_email'] = $query1->getResult('array');
			$query2 = $db->query("Select email from users where id='".$value['sender_id']."'");
			$response[$key]['sender_email'] = $query2->getResult('array');
			$query3 = $db->query("Select title from listing where id='".$value['ad_id']."'");
			$response[$key]['ad_name'] = $query3->getResult('array');
		}
		$country_id = session()->get("country_id")?session()->get("country_id"):'101';
		$States->where('country_id',$country_id);
		$data['extras']['states'] = $States->findAll();
		$data['extras']['hotlinks'] = $settings->findAll();
		$data['extras']['selectedState'] = session()->get("state_id");
	    $data['categories'] = $cat1->findAll();
		$data['report'] = $response;
		$data['currentpage'] = $request->uri->getSegment(2);
		$data['module'] = $request->uri->getSegment(1);
		$data['pager'] = $pages->pager;
		return view('all-report',$data);
	}

	public function changepassword(){
		$session = session();
		$userid = $session->get('id');
		if(!$userid){
			return redirect()->to(base_url('/'));
		}
		$data = array();
		$cat1 = new Categories();
	    $data['categories'] = $cat1->findAll();
		$request = \Config\Services::request();
		$session = session();
		$id = $this->request->getVar('uid');
		$password = $this->request->getVar('password');
		$confirm_password = $this->request->getVar('confirm_password');
		$UserModel = new UserModel();
		if($password == $confirm_password){
			$userData = [
				'id'=>$id,
				'password' => $password
			];
			$UserModel->save($userData);
			$user = $UserModel->where('id', $id)->first();
			$settings = new Settings();
			$States = new States();
			$country_id = session()->get("country_id")?session()->get("country_id"):'101';
			$States->where('country_id',$country_id);
			$data['extras']['states'] = $States->findAll();
			$data['extras']['hotlinks'] = $settings->findAll();
			$data['extras']['selectedState'] = session()->get("state_id");
			$data['user'] = $user;
			$data['module'] = $request->uri->getSegment(1);
			$data['currentpage'] = $request->uri->getSegment(2);
			$session->setFlashdata('success', 'Password successfully Changed');
			return view('update-password',$data);
		}

	}
	public function editprofile($userid){
		$session = session();
		$userid = $session->get('id');
		if(!$userid){
			return redirect()->to(base_url('/'));
		}
		$request = \Config\Services::request();
		$data = array();
		$model = new UserModel();
		$cat1 = new Categories();
	    $data['categories'] = $cat1->findAll();
		$user = $model->where('id', $userid)->first();
		$settings = new Settings();
		$States = new States();
		$country_id = session()->get("country_id")?session()->get("country_id"):'101';
		$States->where('country_id',$country_id);
		$data['extras']['states'] = $States->findAll();
		$data['extras']['hotlinks'] = $settings->findAll();
		$data['extras']['selectedState'] = session()->get("state_id");
		$data['user'] = $user;
		$data['module'] = $request->uri->getSegment(1);
		$data['currentpage'] = $request->uri->getSegment(2);
		return view('edit-profile',$data);
	}

	public function updateProfile(){
		$session = session();
		$userid = $session->get('id');
		if(!$userid){
			return redirect()->to(base_url('/'));
		}
		$request = \Config\Services::request();
		$uid = $this->request->getVar('uid');
		$sfirstname = $this->request->getVar('sfirstname');
		$slastname = $this->request->getVar('slastname');
		$mobile = $this->request->getVar('mobile');
		$data=array();
		$model = new UserModel();
		$cat1 = new Categories();
	    $data['categories'] = $cat1->findAll();
		$userData = [
			'id'=>$uid,
			'firstname' => $sfirstname,
			'lastname' => $slastname,
			'mobile' => $mobile,
		];
		$model->save($userData);
		$session = session();
		$session->setFlashdata('success', 'Profile successfully Update');
		$user = $model->where('id', $uid)->first();
		$settings = new Settings();
		$States = new States();
		$country_id = session()->get("country_id")?session()->get("country_id"):'101';
		$States->where('country_id',$country_id);
		$data['extras']['states'] = $States->findAll();
		$data['extras']['hotlinks'] = $settings->findAll();
		$data['extras']['selectedState'] = session()->get("state_id");
		$data['user'] = $user;
		$data['module'] = $request->uri->getSegment(1);
		$data['currentpage'] = $request->uri->getSegment(2);
		return view('edit-profile',$data);
	}

	public function logout(){
		$session = session();
		$session->destroy();
		$session->setFlashdata('success', 'Successfully Logout');
		return redirect()->to('/');
	}
    
    public function planactive(){
	
	$session = session();
	$db = \Config\Database::connect();
	$userid = $session->get('id');
	if(!$userid){
			return redirect()->to(base_url('/'));
	}
   $adtype=$this->request->uri->getSegment(3);
   $value=$this->request->uri->getSegment(4);
   $adid=$this->request->uri->getSegment(5);
    //die;
    
    if($adtype=='premium' && $value==0){
        $db->query("update listing set premium=0 where id=$adid");
        $db->query("update listing set premium_status=0 where id=$adid");
    }
    elseif($adtype=='premium' && $value==1){
        $db->query("update listing set premium=1 where id=$adid");
		$db->query("update listing set premium_status=2 where id=$adid");
		
		$x = $db->query("select * from users_plan_relation where listing_id = $adid");
		$res = $x->getResult();
		$date = $res[0]->plan_end_date;
		$days = $this->request->getVar('days');
		
		$updated_date = date('Y-m-d H:i:s',strtotime($date." + $days days"));
		
		$db->query("update users_plan_relation set plan_end_date = '".$updated_date."' where listing_id = $adid");
		
    }
    elseif($adtype=='sgallery' && $value==0){
        $db->query("update listing set sgallery=0 where id=$adid");
        $db->query("update listing set sgallery_status=0 where id=$adid");
    }
    elseif($adtype=='sgallery' && $value==1){
        $db->query("update listing set sgallery=1 where id=$adid");
        $db->query("update listing set sgallery_status=2 where id=$adid");
    }
    elseif($adtype=='featured' && $value==0){
        $db->query("update listing set featured=0 where id=$adid");
        $db->query("update listing set featured_status=0 where id=$adid");
    }
    elseif($adtype=='featured' && $value==1){
        $db->query("update listing set featured=1 where id=$adid");
        $db->query("update listing set featured_status=2 where id=$adid");
    }
    return redirect()->to(base_url('/admin/allads'));
    }
    
	public function allads(){
	  
		$session = session();
		$db = \Config\Database::connect();
		$userid = $session->get('id');
		$showlimit = $session->get('allads')?session()->get('allads'):100;
		if(!$userid){
			return redirect()->to(base_url('/'));
		}
		$data = array();
		$plan = new Plans();
		$plan->where('deleted',0);
		$data['allplan'] = $plan->findAll();
		$cat1 = new Categories();
	    $data['categories'] = $cat1->findAll();
		$request = \Config\Services::request();
		$session = session();
		$userid = $session->get('id');
		$listing = new Listing();
		$countries = new Countries();
		$listing->where('deleted',0);
		$listing->orderBy('id', 'desc');
		$pager = \Config\Services::pager();
		if(isset($_REQUEST['plan_id'])){
			$res = $db->query("SELECT * FROM listing WHERE id IN (SELECT DISTINCT listing_id 
			FROM users_plan_relation WHERE plan_id IN (SELECT id FROM plans_meta 
			WHERE plan_id='".$_REQUEST['plan_id']."')) order by id desc LIMIT ".$showlimit);
        	$result = $res->getResult('array');
		}else{
			$result = $listing->paginate($showlimit);
		}
		
		foreach ($result as $key1 => $value1) {
			$res = $db->query("Select email from users where id='".$value1['user_id']."'");
			$result[$key1]['userEmail'] = $res->getResult('array')[0]['email'];
			$res1 = $db->query("SELECT plans.`id`,plans.`plan_name`,users_plan_relation.plan_end_date,users_plan_relation.`plan_id` as currentPlan FROM users_plan_relation 
			INNER JOIN plans_meta ON users_plan_relation.`plan_id`= plans_meta.id
			INNER JOIN plans ON plans_meta.`plan_id` = plans.id
			WHERE users_plan_relation.listing_id='".$value1['id']."'");
			$planRes= $res1->getResult('array');
			foreach ($planRes as $kes1 => $ves1) {
				$planRes[$kes1]['remaining'] = $this->dateDiffInDays(Time::now(),$ves1['plan_end_date']);
			}
			$result[$key1]['plans'] = $planRes;
			$res = $db->query("Select name from categories where id='".$value1['category_id']."'");
			$result[$key1]['categoryName'] = $res->getResult('array')[0]['name'];
			$res = $db->query("SELECT states.* FROM region 
				INNER JOIN cities ON cities.id = region.`city_id`
				INNER JOIN states ON cities.`state_id` = states.`id`
				WHERE region.id='".$value1['location']."'");
				
				$fetchedRes= $res->getResult('array');
				if(count($fetchedRes)>0){
					$result[$key1]['region'] = $fetchedRes[0]['name'];
				}else{
					$result[$key1]['region'] = '';
				}
			
		}
		$settings = new Settings();
		$country_id = session()->get("country_id")?session()->get("country_id"):'101';
		$States = new States();
		$States->where('country_id',$country_id);
		$data['extras']['states'] = $States->findAll();
		$data['extras']['hotlinks'] = $settings->findAll();
		$data['extras']['selectedState'] = session()->get("state_id");
		$data['listing'] = $result;
		$data['currentpage'] = $request->uri->getSegment(2);
		$data['module'] = $request->uri->getSegment(1);
		$data['pager'] = $listing->pager;
		$data['countries'] = $countries->findAll();

		return view('admin-dashboard',$data);
	}
	/*------- Category Section Starts ----------*/
	public function dateDiffInDays($date1, $date2)  
	{ 
		if(strtotime($date2)>strtotime($date1)){
			$diff = strtotime($date2) - strtotime($date1); 
			return abs(round($diff / 86400)); 
		}else{
			return 0;
		}
		
	}
	public function statics(){
		$data = array();
		$catidArray = array();
		$condition ='';
		$condition1 ='';
		$settings = new Settings();
		$db = \Config\Database::connect();
		$country_id = session()->get("country_id")?session()->get("country_id"):'101';
		$showlimit = session()->get('statics')?session()->get('statics'):'0';
		$States = new States();
		$cat1 = new Categories();
		$plans = new Plans();
		$plans->where('deleted',0);
		$request = \Config\Services::request();
	    $data['categories'] = $cat1->findAll();
		$States->where('country_id',$country_id);
		$data['extras']['states'] = $States->findAll();
		$data['extras']['hotlinks'] = $settings->findAll();
		$data['extras']['selectedState'] = session()->get("state_id");
		$data['extras']['adstype'] = $plans->findAll();
		$data['currentpage'] = $request->uri->getSegment(2);
		$data['module'] = $request->uri->getSegment(1);
		$staticsCategory = session()->get('staticsCategory');
		$staticsTypeAds = session()->get('staticsTypeAds');
		$staticslocation = session()->get('staticslocation');
		$staticscities = session()->get('staticscities');
		if($staticslocation){
			$cities = new Cities();
			$cities->where('state_id',$staticslocation);
			$data['extras']['cities'] = $cities->findAll();
		}
		if($staticsCategory){
			$catidArray[] = $staticsCategory;
			$res = $db->query("select * from categories where parent_id='".$staticsCategory."'");
			foreach ($res->getResult('array') as $key1 => $value11) {
				$catidArray[] = $value11['id'];
			}
			$catString = implode(',',$catidArray);
			$condition ="WHERE category_id IN (".$catString.") ";
		}
		if($staticsTypeAds){
			if($staticsTypeAds=='premium'){
				if($condition!=''){
					$condition .="and premium='1'";
				}else{
					$condition ="WHERE premium='1'";
				}
			}
			if($staticsTypeAds=='sgallery'){
				if($condition!=''){
					$condition .="and sgallery='1'";
				}else{
					$condition ="WHERE sgallery='1'";
				}
			}
			if($staticsTypeAds=='featured'){
				if($condition!=''){
					$condition .="and featured='1'";
				}else{
					$condition ="WHERE featured='1'";
				}
			}
		}

		if($staticslocation){
			if($condition!=''){
				$condition .="and listing.`state_id`='".$staticslocation."'";
			}else{
				$condition ="WHERE listing.`state_id`='".$staticslocation."'";
			}
		}
		if($staticscities){
			if($condition!=''){
				$condition .="and listing.`city_id`='".$staticscities."'";
			}else{
				$condition ="WHERE listing.`city_id`='".$staticscities."'";
			}
		}

		$res1 = $db->query("SELECT countries.`name` AS country_name,COUNT(*) AS adscount FROM listing
		INNER JOIN region ON region.`id` = listing.location
		INNER JOIN cities ON cities.`id` = region.`city_id`
		INNER JOIN states ON states.`id` = cities.`state_id`
		INNER JOIN countries ON countries.`id` = states.`country_id` ".$condition."
		GROUP BY countries.`name`");
		$data['countries'] = $res1->getResult('array');
		$adscount = 0;
		foreach ($data['countries'] as $key => $value) {
			$adscount = $adscount+$value['adscount'];
		}
		$data['adscount'] = $adscount;
		return view('statics',$data);
	}
	public function updatesettings(){
		$request = \Config\Services::request();
		$db = \Config\Database::connect();
		$session = session();
		$currentPage = $session->get('currentPage');
		$submitData = $this->request->getVar();
		foreach ($submitData as $key => $value) {
			$db->query("update settings set option_value='".$value."' where icon_path='".$key."'");
		}
		return redirect()->to(base_url('/admin/settings'));
	} 
	public function settings(){
		$session = session();
		$data = array();
		$db = \Config\Database::connect();
		$userid = $session->get('id');
		$States = new States();
		
		if(!$userid){
			return redirect()->to(base_url('/'));
		}
		$settings = new Settings();
		$States = new States();
		$country_id = session()->get("country_id")?session()->get("country_id"):'101';
		$States->where('country_id',$country_id);
		$data['extras']['states'] = $States->findAll();
		$data['extras']['hotlinks'] = $settings->findAll();
		$data['extras']['selectedState'] = session()->get("state_id");
		$request = \Config\Services::request();
		$session = session();
		$userid = $session->get('id');
		$cat1 = new Categories();
	    $data['categories'] = $cat1->findAll();
		$pager = \Config\Services::pager();
		$result = $settings->findAll();
		$data['settings'] = $result;
		$data['currentpage'] = $request->uri->getSegment(2);
		$data['module'] = $request->uri->getSegment(1);
		return view('admin-settings',$data);
	}
	public function addcategory(){
		$request = \Config\Services::request();
		$data = array();
		$session = session();
		$categories = new Categories();
		$categories->where('deleted',0);
		$categories->where('parent_id',0);
		$pager = \Config\Services::pager();
		$settings = new Settings();
		$States = new States();
		$country_id = session()->get("country_id")?session()->get("country_id"):'101';
		$States->where('country_id',$country_id);
		$data['extras']['states'] = $States->findAll();
		$data['extras']['hotlinks'] = $settings->findAll();
		$data['extras']['selectedState'] = session()->get("state_id");
		$data['categories'] = $categories->findAll();
		$data['currentpage'] = $request->uri->getSegment(2);
		$data['module'] = $request->uri->getSegment(1);
		return view('add-categories',$data);
	}
	public function addnewcategory(){
		$request = \Config\Services::request();
		$session = session();
		$categories = new Categories();
		$currentPage = $session->get('currentPage');
		
		$name = $this->request->getVar('name');
		$slug = $this->request->getVar('slug');
		$category = $this->request->getVar('category');
		$desc = $this->request->getVar('desc');
		if($imagefile = $request->getFiles())
		{
			foreach($imagefile['file'] as $img)
			{
				if ($img->isValid() && ! $img->hasMoved())
				{
					$newName = $img->getRandomName();
					$categoriesData = [
						'name' => $name,
						'slug' => $slug,
						'parent_id' => $category,
						'desc' => $desc,
						'icon_path' => 'public/uploads/'.$newName
					];
					$categories->save($categoriesData);
					$img->move(APPPATH.'../public/uploads', $newName);
					$session->setFlashdata('success', 'Category updated Successfully');
					return redirect()->to(base_url($currentPage));
				}else{
					$categoriesData = [
						'name' => $name,
						'slug' => $slug,
						'parent_id' => $category,
						'desc' => $desc
					];
					$categories->save($categoriesData);
					$session->setFlashdata('error', 'Something Went Wrong. Please try again');
					return redirect()->to(base_url($currentPage));
				}
			}
		}
	}
	

	public function editcategories(){
		$request = \Config\Services::request();
		$session = session();
		$currentPage = $session->get('currentPage');
		$categories = new Categories();
		$cid = $this->request->getVar('cid');
		$name = $this->request->getVar('name');
		$slug = $this->request->getVar('slug');
		$category = $this->request->getVar('category');
		$desc = $this->request->getVar('desc');
		if($cid==$category){
			$category = 0;
		}
		if($imagefile = $request->getFiles())
		{
			foreach($imagefile['file'] as $img)
			{
				if ($img->isValid() && ! $img->hasMoved())
				{
					$newName = $img->getRandomName();
					$categoriesData = [
						'id'=>$cid,
						'name' => $name,
						'slug' => $slug,
						'parent_id' => $category,
						'desc' => $desc,
						'icon_path' => 'public/uploads/'.$newName
					];
					$categories->save($categoriesData);
					$img->move(APPPATH.'../public/uploads', $newName);
					$session->setFlashdata('success', 'Category updated Successfully');
					return redirect()->to(base_url($currentPage));
				}else{
					$categoriesData = [
						'id'=>$cid,
						'name' => $name,
						'slug' => $slug,
						'parent_id' => $category,
						'desc' => $desc
					];
					$categories->save($categoriesData);
					$session->setFlashdata('error', 'Something Went Wrong. Please try again');
					return redirect()->to(base_url($currentPage));
				}
			}
		}
	}

	public function parentCategories(){
		$request = \Config\Services::request();
		$session = session();
		$session->set(['currentPage' => $request->uri]);
		$userid = $session->get('id');
		$showlimit = $session->get('parentcategories')?session()->get('parentcategories'):10;
		if(!$userid){
			return redirect()->to(base_url('/'));
		}
		$data = array();
		
		$session = session();
		$userid = $session->get('id');
		$categories = new Categories();
	    $data['categories'] = $categories->findAll();
		$categories->where('deleted',0);
		$categories->where('parent_id',0);
		$pager = \Config\Services::pager();
		$settings = new Settings();
		$States = new States();
		$country_id = session()->get("country_id")?session()->get("country_id"):'101';
		$States->where('country_id',$country_id);
		$data['extras']['states'] = $States->findAll();
		$data['extras']['hotlinks'] = $settings->findAll();
		$data['extras']['selectedState'] = session()->get("state_id");
		$data['categories'] = $categories->paginate($showlimit);
		$data['currentpage'] = $request->uri->getSegment(2);
		$data['module'] = $request->uri->getSegment(1);
		$data['pager'] = $categories->pager;
		return view('all-categories',$data);
	}

	public function childcategories(){
		$request = \Config\Services::request();
		$session = session();
		$session->set(['currentPage' => $request->uri]);
		$userid = $session->get('id');
		$showlimit = $session->get('childcategories')?session()->get('childcategories'):10;
		if(!$userid){
			return redirect()->to(base_url('/'));
		}
		$data = array();
		$request = \Config\Services::request();
		$session = session();
		$userid = $session->get('id');
		$categories = new Categories();
		$categories->where('deleted',0);
		$categories->where('parent_id!=',0);
		$pager = \Config\Services::pager();
		$settings = new Settings();
		$States = new States();
		$country_id = session()->get("country_id")?session()->get("country_id"):'101';
		$States->where('country_id',$country_id);
		$data['extras']['states'] = $States->findAll();
		$data['extras']['hotlinks'] = $settings->findAll();
		$data['extras']['selectedState'] = session()->get("state_id");
		$data['categories'] = $categories->paginate($showlimit);
		$data['currentpage'] = $request->uri->getSegment(2);
		$data['module'] = $request->uri->getSegment(1);
		$data['pager'] = $categories->pager;
		return view('all-categories',$data);
	}

	public function editcategory($catid){
		$session = session();
		$currentPage = $session->get('currentPage');
		$categories = new Categories();
		$categories1 = new Categories();
		$userid = $session->get('id');
		if(!$userid){
			return redirect()->to(base_url('/'));
		}
		$data = array();
		$request = \Config\Services::request();
		$userid = $session->get('id');
		$categories->where('id',$catid);
		$categories1->where('parent_id',0);
		$pager = \Config\Services::pager();
		$settings = new Settings();
		$States = new States();
		$country_id = session()->get("country_id")?session()->get("country_id"):'101';
		$States->where('country_id',$country_id);
		$data['extras']['states'] = $States->findAll();
		$data['extras']['hotlinks'] = $settings->findAll();
		$data['extras']['selectedState'] = session()->get("state_id");
		$data['category'] = $categories->findAll();
		$data['currentpage'] = $request->uri->getSegment(2);
		$data['module'] = $request->uri->getSegment(1);
		$data['categories'] = $categories1->findAll();
		return view('edit-categories',$data);
	}
	public function deletecategory($catid){
		$request = \Config\Services::request();
		$db = \Config\Database::connect();
		$session = session();
		$userid = $session->get('id');
		if(!$userid){
			return redirect()->to(base_url('/'));
		}
		$categories = new Categories();
		$catData = [
			'id'=>$catid,
			'deleted' => '1',
		];
		$categories->save($catData);
		$db->query("update listing set deleted=1 where category_id='".$catid."'");
		$db->query("update listing set deleted=1 where category_id IN (SELECT id FROM categories WHERE parent_id='".$catid."')");
		$session = session();
		$session->setFlashdata('success', 'Category deleted successfully');
		$currentPage = $session->get('currentPage');
		return redirect()->to(base_url($currentPage));
	}
	public function disablecategory($catid){
		$session = session();
		$userid = $session->get('id');
		if(!$userid){
			return redirect()->to(base_url('/'));
		}
		$categories = new Categories();
		$userData = [
			'id'=>$catid,
			'valid' => 0,
		];
		$categories->save($userData);
		$session = session();
		$session->setFlashdata('success', 'Category disabled successfully');
		$currentPage = $session->get('currentPage');
		return redirect()->to(base_url($currentPage));
	}

	public function enablecategory($catid){
		$session = session();
		$userid = $session->get('id');
		if(!$userid){
			return redirect()->to(base_url('/'));
		}
		$categories = new Categories();
		$userData = [
			'id'=>$catid,
			'valid' => 1,
		];
		$categories->save($userData);
		$session = session();
		$session->setFlashdata('success', 'Category disabled successfully');
		$currentPage = $session->get('currentPage');
		return redirect()->to(base_url($currentPage));
	}
	/*---------------------*/
	/*----------- Plans Start -----------*/

	public function allPlans(){
		$session = session();
		$userid = $session->get('id');
		$showlimit = $session->get('allPlans')?session()->get('allPlans'):10;
		if(!$userid){
			return redirect()->to(base_url('/'));
		}
		$data = array();
		$request = \Config\Services::request();
		$plans = new Plans();
		$plans->where('deleted',0);
		$pager = \Config\Services::pager();
		$cat1 = new Categories();
		$settings = new Settings();
		$States = new States();
		$country_id = session()->get("country_id")?session()->get("country_id"):'101';
		$States->where('country_id',$country_id);
		$data['extras']['states'] = $States->findAll();
		$data['extras']['hotlinks'] = $settings->findAll();
		$data['extras']['selectedState'] = session()->get("state_id");
	    $data['categories'] = $cat1->findAll();
		$data['plans'] = $plans->paginate($showlimit);
		$data['currentpage'] = $request->uri->getSegment(2);
		$data['module'] = $request->uri->getSegment(1);
		$data['pager'] = $plans->pager;
		return view('all-plans',$data);
	}
	public function editpage($pageid){
		$session = session();
		$userid = $session->get('id');
		$showlimit = $session->get('allPlans')?session()->get('allPlans'):10;
		if(!$userid){
			return redirect()->to(base_url('/'));
		}
		$data = array();
		$request = \Config\Services::request();
		$pages = new Pages();
		$pages->where('id',$pageid);
		$pager = \Config\Services::pager();
		$cat1 = new Categories();
		$settings = new Settings();
		$States = new States();
		$country_id = session()->get("country_id")?session()->get("country_id"):'101';
		$States->where('country_id',$country_id);
		$data['extras']['states'] = $States->findAll();
		$data['extras']['hotlinks'] = $settings->findAll();
		$data['extras']['selectedState'] = session()->get("state_id");
	    $data['categories'] = $cat1->findAll();
		$data['page'] = $pages->findAll();
		$data['currentpage'] = $request->uri->getSegment(2);
		$data['module'] = $request->uri->getSegment(1);
		$data['pager'] = $pages->pager;
		return view('edit-page',$data);
	}
	public function updatepage(){
		$request = \Config\Services::request();
		$request = $this->request->getVar();
		$pages = new Pages();
		$planData = [
			'id'=>$request['planid'],
			'page_name' => $request['name'],
			'content' => $request['content'],
		];
		$pages->save($planData);
		$session = session();
		$session->setFlashdata('success', 'Page updated successfully');
		return redirect()->to(base_url('/admin/allpages'));
	}	

	public function allpages(){
		$session = session();
		$userid = $session->get('id');
		$showlimit = $session->get('allPlans')?session()->get('allPlans'):10;
		if(!$userid){
			return redirect()->to(base_url('/'));
		}
		$data = array();
		$request = \Config\Services::request();
		$pages = new Pages();
		$pages->where('deleted',0);
		$pager = \Config\Services::pager();
		$cat1 = new Categories();
		$settings = new Settings();
		$States = new States();
		$country_id = session()->get("country_id")?session()->get("country_id"):'101';
		$States->where('country_id',$country_id);
		$data['extras']['states'] = $States->findAll();
		$data['extras']['hotlinks'] = $settings->findAll();
		$data['extras']['selectedState'] = session()->get("state_id");
	    $data['categories'] = $cat1->findAll();
		$data['pages'] = $pages->findAll();
		$data['currentpage'] = $request->uri->getSegment(2);
		$data['module'] = $request->uri->getSegment(1);
		$data['pager'] = $pages->pager;
		return view('all-pages',$data);
	}

	public function enquiries(){
		$session = session();
		$userid = $session->get('id');
		$showlimit = $session->get('allPlans')?session()->get('allPlans'):10;
		if(!$userid){
			return redirect()->to(base_url('/'));
		}
		$data = array();
		$request = \Config\Services::request();
		$adminEnquiry = new AdminEnquiry();
		$adminEnquiry->where('deleted',0)->orderBy('id', 'desc');
		$pager = \Config\Services::pager();
		$cat1 = new Categories();
		$settings = new Settings();
		$States = new States();
		$country_id = session()->get("country_id")?session()->get("country_id"):'101';
		$States->where('country_id',$country_id);
		$data['extras']['states'] = $States->findAll();
		$data['extras']['hotlinks'] = $settings->findAll();
		$data['extras']['selectedState'] = session()->get("state_id");
	    $data['categories'] = $cat1->findAll();
		$data['adminEnquiry'] = $adminEnquiry->findAll();
		$data['currentpage'] = $request->uri->getSegment(2);
		$data['module'] = $request->uri->getSegment(1);
		$data['pager'] = $adminEnquiry->pager;
		return view('admin-enquiry',$data);
	}

	public function localities(){
		$db = \Config\Database::connect();
		$session = session();
		$userid = $session->get('id');
		$showlimit = $session->get('allPlans')?session()->get('allPlans'):10;
		if(!$userid){
			return redirect()->to(base_url('/'));
		}
		$data = array();
		$request = \Config\Services::request();
		$region = new Region();
		$region->where('deleted',0);
		$pager = \Config\Services::pager();
		$cat1 = new Categories();
		$settings = new Settings();
		$States = new States();
		$country_id = session()->get("country_id")?session()->get("country_id"):'101';
		$showlimit = $session->get('localities')?session()->get('localities'):10;
		$States->where('country_id',$country_id);
		$result = $region->where('deleted',0)->paginate($showlimit);
		foreach ($result as $key1 => $value1) {

			$que = $db->query("SELECT cities.name AS cityname,states.name AS statename,countries.name AS countriesname FROM region 
			INNER JOIN cities ON region.`city_id` = cities.`id` 
			INNER JOIN states ON cities.`state_id` = states.`id` 
			INNER JOIN countries ON states.`country_id` = countries.`id` WHERE region.`id`='".$value1['id']."'");
			$result[$key1]['data']=$que->getResult('array')[0];

		}
		$data['extras']['states'] = $States->findAll();
		$data['extras']['hotlinks'] = $settings->findAll();
		$data['extras']['selectedState'] = session()->get("state_id");
	    $data['categories'] = $cat1->findAll();
		$data['region'] = $result;
		$data['currentpage'] = $request->uri->getSegment(2);
		$data['module'] = $request->uri->getSegment(1);
		$data['pager'] = $region->pager;
		return view('all-localities',$data);
	}

	public function deletelocality($catid){
		$request = \Config\Services::request();
		$session = session();
		$userid = $session->get('id');
		if(!$userid){
			return redirect()->to(base_url('/'));
		}
		$region = new Region();
		$regionData = [
			'id'=>$catid,
			'deleted' => '1',
			'modified_date' => Time::now(),
		];
		$region->save($regionData);
		$session = session();
		$session->setFlashdata('success', 'Locality deleted successfully');
		return redirect()->to(base_url('/admin/localities'));
	}

	public function deletepage($catid){
		$request = \Config\Services::request();
		$session = session();
		$userid = $session->get('id');
		if(!$userid){
			return redirect()->to(base_url('/'));
		}
		$pages = new Pages();
		$planData = [
			'id'=>$catid,
			'deleted' => '1',
			'updated_date' => Time::now(),
		];
		$pages->save($planData);
		$session = session();
		$session->setFlashdata('success', 'Page deleted successfully');
		return redirect()->to(base_url('/admin/allpages'));
	}
	public function deleteenquiry($catid){
		$request = \Config\Services::request();
		$session = session();
		$userid = $session->get('id');
		if(!$userid){
			return redirect()->to(base_url('/'));
		}
		$adminEnquiry = new AdminEnquiry();
		$enquiryData = [
			'id'=>$catid,
			'deleted' => '1',
			'updated_date' => Time::now(),
		];
		$adminEnquiry->save($enquiryData);
		$session = session();
		$session->setFlashdata('success', 'Page deleted successfully');
		return redirect()->to(base_url('/admin/enquiries'));
	}
	
	public function addlocality(){
		$request = \Config\Services::request();
		$cat1 = new Categories();
		$settings = new Settings();
		$countries = new Countries();
		$States = new States();
		$country_id = session()->get("country_id")?session()->get("country_id"):'101';
		$States->where('country_id',$country_id);
		$data['extras']['states'] = $States->findAll();
		$data['extras']['hotlinks'] = $settings->findAll();
		$data['extras']['selectedState'] = session()->get("state_id");
	    $data['categories'] = $cat1->findAll();
	    $data['countries'] = $countries->findAll();
		$data['currentpage'] = $request->uri->getSegment(2);
		$data['module'] = $request->uri->getSegment(1);
		return view('add-locality',$data);
	}

	public function editlocality($locid){
		$region = new Region();
		$region->where('deleted',0);
		$region->where('id',$locid);
		$result = $region->findAll();
		$request = \Config\Services::request();
		$db = \Config\Database::connect();
		$cat1 = new Categories();
		$settings = new Settings();
		$countries = new Countries();
		$States = new States();
		$country_id = session()->get("country_id")?session()->get("country_id"):'101';
		$States->where('country_id',$country_id);
		foreach ($result as $key => $value1) {
			$res = $db->query("SELECT countries.id AS countriesid,states.id AS stateid FROM cities 
			INNER JOIN states ON cities.`state_id` = states.`id` 
			INNER JOIN countries ON states.`country_id` = countries.`id` WHERE cities.`id`='".$value1['city_id']."'");
			$ids = $res->getResult('array')[0];
			$res1 = $db->query("select * from states where country_id='".$ids['countriesid']."'");
			$data['states'] = $res1->getResult('array');
			$res2 = $db->query("select * from cities where state_id='".$ids['stateid']."'");
			$data['cities'] = $res2->getResult('array');
			$ids['cityid'] =  $value1['city_id'];
			$data['selected'] = $ids;
		}
		$data['extras']['states'] = $States->findAll();
		$data['extras']['hotlinks'] = $settings->findAll();
		$data['extras']['selectedState'] = session()->get("state_id");
	    $data['categories'] = $cat1->findAll();
	    $data['countries'] = $countries->findAll();
		$data['currentpage'] = $request->uri->getSegment(2);
		$data['module'] = $request->uri->getSegment(1);
		$data['editData'] = $result;
		return view('edit-locality',$data);
	}

	public function enablepage($catid){
		$request = \Config\Services::request();
		$session = session();
		$userid = $session->get('id');
		if(!$userid){
			return redirect()->to(base_url('/'));
		}
		$pages = new Pages();
		$planData = [
			'id'=>$catid,
			'valid' => '1',
			'updated_date' => Time::now(),
		];
		$pages->save($planData);
		$session = session();
		$session->setFlashdata('success', 'Page enable successfully');
		return redirect()->to(base_url('/admin/allpages'));
	}

	public function disablepage($catid){
		$request = \Config\Services::request();
		$session = session();
		$userid = $session->get('id');
		if(!$userid){
			return redirect()->to(base_url('/'));
		}
		$pages = new Pages();
		$planData = [
			'id'=>$catid,
			'valid' => '0',
			'updated_date' => Time::now(),
		];
		$pages->save($planData);
		$session = session();
		$session->setFlashdata('success', 'page disable successfully');
		return redirect()->to(base_url('/admin/allpages'));
	}


	public function addplan(){
		$request = \Config\Services::request();
		$cat1 = new Categories();
		$settings = new Settings();
		$countries = new Countries();
		$States = new States();
		$country_id = session()->get("country_id")?session()->get("country_id"):'101';
		$States->where('country_id',$country_id);
		$data['extras']['states'] = $States->findAll();
		$data['extras']['hotlinks'] = $settings->findAll();
		$data['extras']['selectedState'] = session()->get("state_id");
	    $data['categories'] = $cat1->findAll();
	    $data['countries'] = $countries->findAll();
		$data['currentpage'] = $request->uri->getSegment(2);
		$data['module'] = $request->uri->getSegment(1);
		return view('add-plan',$data);
	}
	/*public function addnewplan(){
		$request = \Config\Services::request();
		$plans = new Plans();
		$plansmeta = new PlansMeta();
		$session = session();
		$name = $this->request->getVar('name');
		$details = $this->request->getVar('details');
		$planData = [
			'plan_name' => $name,
			'created_at' => Time::now(),
			'modified_at' => Time::now(),
			'valid' => 1,
			'deleted' => 0,
		];
		$plans->save($planData);
		$insertedId = $plans->insertID(); 
		if($insertedId){
			foreach ($details as $k1 => $v1) {
				$planMetaData = [
					'plan_id' => $insertedId,
					'plan_duration' => $v1['name'],
					'plan_price' => $v1['price'],
					'created_at' => Time::now(),
					'modified_at' => Time::now(),
					'valid' => 1,
					'deleted' => 0,
				];
				$plansmeta->save($planMetaData);
			}
		}
		return redirect()->to(base_url('/admin/allPlans'));
	}*/
	public function editinvoice($invoiceid){
		//echo $invoiceid;
		$data=array();
		$request = \Config\Services::request();
		$cat1 = new Categories();
		$settings = new Settings();
		$countries = new Countries();
		$States = new States();
		$transactions = new Transactions();
		$invoice = new Invoice();
		$listing = new Listing();
		$plans = new Plans();
		$users = new UserModel();
		$plansmeta = new PlansMeta();
		$UsersPlanRelationship = new UsersPlanRelationship();
		$invoice->where('id',$invoiceid);
		$result = $invoice->findAll();
		
		foreach ($result as $key => $value) {
			$upr_id = $value['upr_id'];
			$UsersPlanRelationship->where('id',$upr_id);
			$relationData = $UsersPlanRelationship->findAll();
			$result[$key]['relationData'] = $relationData;

			$listing->where('id',$relationData[0]['listing_id']);
			$result[$key]['listing'] = $listing->findAll();

			$users->where('id',$value['user_id']);
			$result[$key]['user'] = $users->findAll();

			$transactions->where('upr_id',$value['upr_id']);
			$result[$key]['transactions'] = $transactions->findAll();

			$plansmeta->where('id',$value['plan_id']);
			$metaData = $plansmeta->findAll();
			$plans->where('id',$metaData[0]['plan_id']);
			$result[$key]['plansmeta'] = $metaData;
			$result[$key]['plans'] = $plans->findAll();
			
		}
		$country_id = session()->get("country_id")?session()->get("country_id"):'101';
		$States->where('country_id',$country_id);
		$data['extras']['states'] = $States->findAll();
		$data['extras']['hotlinks'] = $settings->findAll();
		$data['extras']['selectedState'] = session()->get("state_id");
	    $data['categories'] = $cat1->findAll();
	    $data['invoice'] = $result;
	    $data['countries'] = $countries->findAll();
		$data['currentpage'] = $request->uri->getSegment(2);
		$data['module'] = $request->uri->getSegment(1);
		return view('edit-invoice',$data);
	}
	
	public function addnewlocality(){
		$request = \Config\Services::request();
		$db = \Config\Database::connect();
		$region = new Region();
		$details = $this->request->getVar('details');
		$regionname = $this->request->getVar('region');
		$planData = [
			'name' => $regionname,
			'city_id' => $details[0]['cities'],
			'region_id' => $details[0]['states'],
			'created_date' => Time::now(),
			'modified_date' => Time::now(),
			'deleted' => 0,
		];
		$region->save($planData);
		$insertedId = $region->insertID();
		return redirect()->to(base_url('/admin/localities')); 
	}

	public function sendverificationmail($id){
		$message='';
		$config=array();
		$config['protocol'] = 'sendmail';
        $config['mailPath'] = '/usr/sbin/sendmail';
        $config['charset']  = 'utf-8';
        $config['wordWrap'] = true;
        $config['mailType'] = 'html';
        
		$users = new UserModel();
		$users->where('id',$id);
		$res = $users->findAll();
		$message = 'Hi '.$res[0]['firstname'].'<br />';
		$message .= 'Please Click onbelow link to verify email'.'<br />';

		$message .= '<a href="'.base_url('/users/verifyemail/?key='.base64_encode($id)).'">'.base_url('/users/verifyemail/?key='.base64_encode($id)).'</a>';
		$email = \Config\Services::email();
		$email->initialize($config);
		$email->setFrom('info@addgalaxy.com', 'Admin');
		$email->setTo($res[0]['email']);
		$email->setSubject('Email Verification');
		$email->setMessage($message);
		$email->send();
		return redirect()->to(base_url('/admin/allusers')); 
	}

	public function updatelocality(){
		$request = \Config\Services::request();
		$db = \Config\Database::connect();
		$region = new Region();
		$localityid = $this->request->getVar('localityid');
		$details = $this->request->getVar('details');
		$regionname = $this->request->getVar('region');
		$planData = [
			'id' => $localityid,
			'name' => $regionname,
			'city_id' => $details[0]['cities'],
			'region_id' => $details[0]['states'],
			'modified_date' => Time::now(),
			'deleted' => 0,
		];
		$region->save($planData);
		return redirect()->to(base_url('/admin/localities')); 
	}

	public function addnewplan(){
		$request = \Config\Services::request();
		$db = \Config\Database::connect();
		$plans = new Plans();
		$plansmeta = new PlansMeta();
		$details = $this->request->getVar('details');
		$planData = [
			'plan_name' => $this->request->getVar('name'),
			'type' => $this->request->getVar('type'),
			'created_at' => Time::now(),
			'modified_at' => Time::now(),
			'valid' => 1,
			'deleted' => 0,
		];
		$plans->save($planData);
		$insertedId = $plans->insertID(); 
		if($insertedId){
			$planMetaData = [
				'plan_id' => $insertedId,
				'plan_duration' => $this->request->getVar('dduration'),
				'plan_price' => $this->request->getVar('dprice'),
				'planindays' => $this->request->getVar('ddays'),
				'plan_type' => 'defoult',
				'created_at' => Time::now(),
				'modified_at' => Time::now(),
				'valid' => 1,
				'deleted' => 0,
			];
			$plansmeta->save($planMetaData);
			foreach ($details as $k1 => $v1) {
				$planMetaData = [
					'plan_id' => $insertedId,
					'plan_duration' => $v1['name'],
					'plan_price' => $v1['price'],
					'planindays' => $v1['days'],
					'plan_type' => 'main',
					'created_at' => Time::now(),
					'modified_at' => Time::now(),
					'valid' => 1,
					'deleted' => 0,
					'country_id' => $v1['countries'],
					'state_id' => $v1['states'],
					'city_id' => $v1['cities'],
					'region_id' => $v1['region'],
				];
				$plansmeta->save($planMetaData);
			}
		}
		return redirect()->to(base_url('/admin/allPlans'));
	}

	public function updateplan(){
		$request = \Config\Services::request();
		$db = \Config\Database::connect();
		$plans = new Plans();
		$plansmeta = new PlansMeta();
		$planid = $this->request->getVar('planid');
		$name = $this->request->getVar('name');
		$dprice = $this->request->getVar('dprice');
		$dduration = $this->request->getVar('dduration');
		$ddays = $this->request->getVar('ddays');
		$details = $this->request->getVar('details');
		$planData = [
			'id'=>$planid,
			'plan_name' => $name,
			'modified_at' => Time::now(),
		];
		$plans->save($planData);
		$idarray=array();
		foreach ($details as $k1 => $v1) {
			if($v1['id']){
				$idarray[] = $v1['id'];
			}
		}
		$idar1 = implode(',',$idarray);
		$queryupdate = $db->query("update plans_meta set deleted=1 where plan_id='".$planid."' and id not in (".$idar1.")");
		$queryupdate1 = $db->query("update plans_meta set plan_duration='".$dduration."',plan_price='".$dprice."',planindays='".$ddays."' where plan_id='".$planid."' and plan_type='defoult'");
		foreach ($details as $k => $v) {
			$planData = [
				'plan_id' => $planid,
				'plan_duration' => $v['name'],
				'plan_price' => $v['price'],
				'planindays' => $v['days'],
				'country_id' => $v['countries'],
				'state_id' => $v['states'],
				'city_id' => $v['cities'],
				'region_id' => $v['region'],
				'modified_at' => Time::now(),
			];
			if($v['id']){
				$planData['id']=$v['id'];
			}
			$plansmeta->save($planData);

		}
		
		return redirect()->to(base_url('/admin/allPlans'));
		/*
		
		$session = session();
		$currentPage = $session->get('currentPage');
		$categories = new Categories();
		$planid = $this->request->getVar('planid');
		$name = $this->request->getVar('name');
		$details = $this->request->getVar('details');
		$idarray=array();
		foreach ($details as $k => $v) {
			$idarray[] = $v['id'];
			$planData = [
				'id'=>$v['id'],
				'plan_duration' => $v['name'],
				'plan_price' => $v['price'],
				'modified_at' => Time::now(),
			];
			$plansmeta->save($planData);
		}
		$idar1 = implode(',',$idarray);
		$db = $db->query("update plans_meta set deleted=1 where plan_id='".$planid."' and id not in (".$idar1.")");
		return redirect()->to(base_url('/admin/allPlans'));
		*/
	}
	public function getplanbyRegion(){
		$selected = $this->request->getVar('con');
		$db = \Config\Database::connect();
		$plans = new Plans();
		$plans->where('deleted',0);
		$plansmeta = new PlansMeta();
		$plansmeta->where('deleted',0);
		$plansmeta->where('region_id',$selected);
		$res = $plans->findAll();
		foreach ($res as $key1 => $value1) {
			$que = $db->query("Select * from plans_meta where plan_id='".$value1['id']."' and region_id='".$selected."'");
			if(count($que->getResult('array'))>0){
				$res[$key1]['plan']= $que->getResult('array');
			}else{
				$que1 = $db->query("Select * from plans_meta where plan_id='".$value1['id']."' and plan_type='defoult'");
				$res[$key1]['plan']= $que1->getResult('array');
			}
		}
		echo json_encode($res);
	}
	public function getplanbyState(){
		$selected = $this->request->getVar('con');
		$db = \Config\Database::connect();
		$plans = new Plans();
		$plans->where('deleted',0);
		$plansmeta = new PlansMeta();
		$plansmeta->where('deleted',0);
		$plansmeta->where('state_id',$selected);
		$res = $plans->findAll();
		foreach ($res as $key1 => $value1) {
			$que = $db->query("Select * from plans_meta where plan_id='".$value1['id']."' and state_id='".$selected."'");
			if(count($que->getResult('array'))>0){
				$res[$key1]['plan']= $que->getResult('array');
			}else{
				$que1 = $db->query("Select * from plans_meta where plan_id='".$value1['id']."' and plan_type='defoult'");
				$res[$key1]['plan']= $que1->getResult('array');
			}
		}
		echo json_encode($res);
	}

	public function editplan($catid){
		$session = session();
		$plans = new Plans();
		$plansmeta = new PlansMeta();
		$countries = new Countries();
		$states = new States();
		$cities = new Cities();
		$region = new Region();
		$categories = new Categories();
		$categories->where('deleted',0);
		$userid = $session->get('id');
		if(!$userid){
			return redirect()->to(base_url('/'));
		}
		$data = array();
		$request = \Config\Services::request();
		$plans->where('id',$catid);
		$pager = \Config\Services::pager();
		$result = $plans->findAll();
		if(count($result) > 0){
			$plansmeta->where('plan_id',$result[0]['id']);
			$plansmeta->where('deleted',0);
			$metaResult = $plansmeta->findAll();
			$result[0]['meta'] = $metaResult;
			foreach($result[0]['meta'] as $a => $b){
				if($b['country_id']){
					$states->where('country_id',$b['country_id']);
					$result[0]['meta'][$a]['states']=$states->findAll();
				}else{
					$result[0]['meta'][$a]['states']=array();
				}
				if($b['state_id']){
					$cities->where('state_id',$b['state_id']);
					$result[0]['meta'][$a]['cities']=$cities->findAll();
				}else{
					$result[0]['meta'][$a]['cities']=array();
				}
				if($b['city_id']){
					$region->where('city_id',$b['city_id']);
					$result[0]['meta'][$a]['region']=$region->findAll();
				}else{
					$result[0]['meta'][$a]['region']=array();
				}
			}
		}
		$db = \Config\Database::connect();
		$cat1 = new Categories();
		$settings = new Settings();
		$States = new States();
		$defaultQuery = $db->query("Select * from plans_meta where plan_type='defoult' and plan_id='".$catid."'"); 
		$data['default'] = $defaultQuery->getResult('array');;
		$country_id = session()->get("country_id")?session()->get("country_id"):'101';
		$States->where('country_id',$country_id);
		$data['extras']['states'] = $States->findAll();
		$data['extras']['hotlinks'] = $settings->findAll();
		$data['extras']['selectedState'] = session()->get("state_id");
	    $data['categories'] = $cat1->findAll();
		$data['plan'] = $result;
		$data['countries'] = $countries->findAll();
		$data['states'] = $states->findAll();
		$data['cities'] = $cities->findAll();
		$data['region'] = $region->findAll();
		$data['currentpage'] = $request->uri->getSegment(2);
		$data['module'] = $request->uri->getSegment(1);
		$data['categories'] = $categories->findAll();
		return view('edit-plan',$data);
	}

	public function deleteplan($catid){
		$request = \Config\Services::request();
		$session = session();
		$userid = $session->get('id');
		if(!$userid){
			return redirect()->to(base_url('/'));
		}
		$plans = new Plans();
		$planData = [
			'id'=>$catid,
			'deleted' => '1',
			'modified_at' => Time::now(),
		];
		$plans->save($planData);
		$session = session();
		$session->setFlashdata('success', 'Plan deleted successfully');
		return redirect()->to(base_url('/admin/allPlans'));
	}
	public function disablelisting($listid){
		$session = session();
		$userid = $session->get('id');
		if(!$userid){
			return redirect()->to(base_url('/'));
		}
		$listing = new Listing();
		$listingData = [
			'id'=>$listid,
			'valid' => 0,
			'modified_at' => Time::now(),
		];
		$listing->save($listingData);
		$session = session();
		$session->setFlashdata('success', 'Listing disabled successfully');
		return redirect()->to(base_url('/admin/allads'));
	}
	public function enablelisting($listid){
		$session = session();
		$userid = $session->get('id');
		if(!$userid){
			return redirect()->to(base_url('/'));
		}
		$listing = new Listing();
		$listingData = [
			'id'=>$listid,
			'valid' => 1,
			'modified_at' => Time::now(),
		];
		$listing->save($listingData);
		$session = session();
		$session->setFlashdata('success', 'Listing enabled successfully');
		return redirect()->to(base_url('/admin/allads'));
	}

	public function disableplan($planid){
		$session = session();
		$userid = $session->get('id');
		if(!$userid){
			return redirect()->to(base_url('/'));
		}
		$plans = new Plans();
		$planData = [
			'id'=>$planid,
			'valid' => 0,
			'modified_at' => Time::now(),
		];
		$plans->save($planData);
		$session = session();
		$session->setFlashdata('success', 'Plan disabled successfully');
		return redirect()->to(base_url('/admin/allPlans'));
	}

	public function enableplan($planid){
		$session = session();
		$userid = $session->get('id');
		if(!$userid){
			return redirect()->to(base_url('/'));
		}
		$plans = new Plans();
		$planData = [
			'id'=>$planid,
			'valid' => 1,
			'modified_at' => Time::now(),
		];

		$plans->save($planData);
		$session = session();
		$session->setFlashdata('success', 'Plan enabled successfully');
		return redirect()->to(base_url('/admin/allPlans'));
	}

	/*---------------*/
	/*-------All Attribute Start--------*/
	public function allattributes(){
		$session = session();
		$userid = $session->get('id');
		$showlimit = $session->get('allattributes')?session()->get('allattributes'):10;
		if(!$userid){
			return redirect()->to(base_url('/'));
		}
		$data = array();
		$request = \Config\Services::request();
		$session = session();
		$userid = $session->get('id');
		$attributes = new MainAttributes();
		$categories = new Categories();
		$attributes->where('deleted',0);
		$pager = \Config\Services::pager();
		$result = $attributes->paginate($showlimit);
		foreach ($result as $k1 => $v1) {
			$categories->where('id',$v1['parent_category_id']);
			$cat = $categories->findAll();
			$result[$k1]['parent_category_name'] = $cat[0]['name'];
		}
		$cat1 = new Categories();
		$settings = new Settings();
		$States = new States();
		$country_id = session()->get("country_id")?session()->get("country_id"):'101';
		$States->where('country_id',$country_id);
		$data['extras']['states'] = $States->findAll();
		$data['extras']['hotlinks'] = $settings->findAll();
		$data['extras']['selectedState'] = session()->get("state_id");
	    $data['categories'] = $cat1->findAll();
		$data['attributes'] = $result;
		$data['currentpage'] = $request->uri->getSegment(2);
		$data['module'] = $request->uri->getSegment(1);
		$data['pager'] = $attributes->pager;
		return view('all-attributes',$data);
	}
	public function addattributes(){
		$session = session();
		$attributes = new MainAttributes();
		$attributesmeta = new Attributes();
		$categories = new Categories();
		$categories->where('deleted',0);
		$userid = $session->get('id');
		if(!$userid){
			return redirect()->to(base_url('/'));
		}
		$data = array();
		$request = \Config\Services::request();
		$result=array();
		$settings = new Settings();
		$States = new States();
		$country_id = session()->get("country_id")?session()->get("country_id"):'101';
		$States->where('country_id',$country_id);
		$data['extras']['states'] = $States->findAll();
		$data['extras']['hotlinks'] = $settings->findAll();
		$data['extras']['selectedState'] = session()->get("state_id");
		$data['attribute'] = $result;
		$data['currentpage'] = $request->uri->getSegment(2);
		$data['module'] = $request->uri->getSegment(1);
		$data['categories'] = $categories->findAll();
		return view('add-attribute',$data);
	}

	public function editattribute($attrid){
		$session = session();
		$attributes = new MainAttributes();
		$attributesmeta = new Attributes();
		$categories = new Categories();
		$categories->where('deleted',0);
		$userid = $session->get('id');
		if(!$userid){
			return redirect()->to(base_url('/'));
		}
		$data = array();
		$request = \Config\Services::request();
		$attributes->where('id',$attrid);
		$pager = \Config\Services::pager();
		$result = $attributes->findAll();
		if(count($result) > 0){
			$attributesmeta->where('parent_attribute_id',$result[0]['id']);
			$attributesmeta->where('deleted',0);
			$metaResult = $attributesmeta->findAll();
			$result[0]['meta'] = $metaResult;
		}
		$settings = new Settings();
		$States = new States();
		$country_id = session()->get("country_id")?session()->get("country_id"):'101';
		$States->where('country_id',$country_id);
		$data['extras']['states'] = $States->findAll();
		$data['extras']['hotlinks'] = $settings->findAll();
		$data['extras']['selectedState'] = session()->get("state_id");
		$data['attribute'] = $result;
		$data['currentpage'] = $request->uri->getSegment(2);
		$data['module'] = $request->uri->getSegment(1);
		$data['categories'] = $categories->findAll();
		return view('edit-attribute',$data);
	}

	public function updateAttribute(){
		$request = \Config\Services::request();
		$db = \Config\Database::connect();
		$session = session();
		$userid = $session->get('id');
		if(!$userid){
			return redirect()->to(base_url('/'));
		}
		$attributes = new MainAttributes();
		$attributesmeta = new Attributes();
		$categories = new Categories();
		$recievedValues = $this->request->getVar();
		$attrData = [
			'id'=>$recievedValues['attrid'],
			'attribute_name'=>$recievedValues['name'],
			'type'=>$recievedValues['display_type'],
			'attribute_type'=>$recievedValues['attr_type'],
			'parent_category_id'=>$recievedValues['category'],
			'show_in_listing'=>$recievedValues['attr_show'],
			'modified_at' => Time::now(),
		];
		if($recievedValues['attrid']){
			$attrData['id']=$recievedValues['attrid'];
		}
		$attributes->save($attrData);
		if($recievedValues['attrid']){
			$insertedId = $recievedValues['attrid']; 
		}else{
			$insertedId = $attributes->insertID(); 
		}
		
		$idarray=array();
		foreach ($recievedValues['details'] as $k1 => $v1) {
			$idarray[] = $v1['id'];
			$attributesData = [
				'id'=>$v1['id'],
				'option_name' => $v1['name'],
				'parent_attribute_id' => $recievedValues['attrid']?$recievedValues['attrid']:$insertedId,
				'modified_at' => Time::now(),
			];
			$attributesmeta->save($attributesData);
		}
		$idar1 = implode(',',$idarray);
		if($recievedValues['attrid']){
			$db = $db->query("update attribute_options set deleted=1 where parent_attribute_id='".$recievedValues['attrid']."' and id not in (".$idar1.")");
		}
		$session->setFlashdata('success', 'Plan edited successfully');
		return redirect()->to(base_url('/admin/allattributes'));

	}

	public function deleteattribute($attrid){
		$request = \Config\Services::request();
		$session = session();
		$userid = $session->get('id');
		if(!$userid){
			return redirect()->to(base_url('/'));
		}
		$attributes = new MainAttributes();
		$attributesData = [
			'id'=>$attrid,
			'deleted' => '1',
			'modified_at' => Time::now(),
		];
		$attributes->save($attributesData);
		$session = session();
		$session->setFlashdata('success', 'Plan deleted successfully');
		return redirect()->to(base_url('/admin/allattributes'));
	}

	public function disableattribute($attrid){
		$session = session();
		$userid = $session->get('id');
		if(!$userid){
			return redirect()->to(base_url('/'));
		}
		$attributes = new MainAttributes();
		$attributesData = [
			'id'=>$attrid,
			'valid' => 0,
			'modified_at' => Time::now(),
		];
		$attributes->save($attributesData);
		$session = session();
		$session->setFlashdata('success', 'Attribute disabled successfully');
		return redirect()->to(base_url('/admin/allattributes'));
	}

	public function enableattribute($attrid){
		$session = session();
		$userid = $session->get('id');
		if(!$userid){
			return redirect()->to(base_url('/'));
		}
		$attributes = new MainAttributes();
		$attributesData = [
			'id'=>$attrid,
			'valid' => 1,
			'modified_at' => Time::now(),
		];
		$attributes->save($attributesData);
		$session = session();
		$session->setFlashdata('success', 'Attribute enabled successfully');
		return redirect()->to(base_url('/admin/allattributes'));
	}

	/*---------------*/
	/*------User section starts---------*/

	public function allusers(){
		$session = session();
		$db = \Config\Database::connect();
		$userid = $session->get('id');
		$showlimit = $session->get('allusers')?session()->get('allusers'):100;
		if(!$userid){
			return redirect()->to(base_url('/'));
		}
		$data = array();
		$request = \Config\Services::request();
		$session = session();
		$userid = $session->get('id');
		$users = new UserModel();
		$cat1 = new Categories();
	    $data['categories'] = $cat1->findAll();
		$users->where('deleted',0);
		$pager = \Config\Services::pager();
		$result = $users->paginate($showlimit);
		foreach ($result as $k4 => $v4) {
			$res = $db->query("SELECT plan_name FROM plans WHERE id IN (SELECT plan_id FROM plans_meta WHERE id IN (SELECT plan_id FROM users_plan_relation WHERE user_id='".$v4['id']."' AND plan_end_date > CURDATE()))");
			$result[$k4]['purchasePlan'] = $res->getResult('array');
			$res1 = $db->query("SELECT COUNT(*) FROM listing WHERE user_id='".$v4['id']."'");
			$result[$k4]['noofads'] = $res1->getResult('array');
		}
		$settings = new Settings();
		$States = new States();
		$country_id = session()->get("country_id")?session()->get("country_id"):'101';
		$States->where('country_id',$country_id);
		$data['extras']['states'] = $States->findAll();
		$data['extras']['hotlinks'] = $settings->findAll();
		$data['extras']['selectedState'] = session()->get("state_id");
		$data['users'] = $result;
		$data['currentpage'] = $request->uri->getSegment(2);
		$data['module'] = $request->uri->getSegment(1);
		$data['pager'] = $users->pager;
		return view('all-users',$data);
	}
	public function adsbyuser($userid){
		$request = \Config\Services::request();
		$data = array();
		$viewId=0;
		$session = session();
		$userid1 = $session->get('id');
		if(!$userid1){
			return redirect()->to(base_url('/'));
		}
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
		$listing = new Listing();
		$listing->where('user_id',$userid);
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
		$result = $listing->findAll();
		$data['listing'] = $listing->paginate(6);
		$data['totalads'] = count($result);
		$data['currentpage'] = $request->uri->getSegment(2);
		$data['module'] = $request->uri->getSegment(1);
		$data['pager'] = $listing->pager;
		return view('userads',$data);
	}

	public function deleteuser($userid){
		$request = \Config\Services::request();
		$db = \Config\Database::connect();
		$session = session();
		$userid1 = $session->get('id');
		if(!$userid1){
			return redirect()->to(base_url('/'));
		}
		$user = new UserModel();
		$userData = [
			'id'=>$userid,
			'deleted' => '1',
			'modified_date' => Time::now(),
		];
		
		$user->save($userData);
		$db->query("update listing set deleted=1 where user_id='".$userid."'");
		$session = session();
		$session->setFlashdata('success', 'Plan deleted successfully');
		return redirect()->to(base_url('/admin/allusers'));
	}

	public function disableuser($usrid){
		$session = session();
		$userid = $session->get('id');
		if(!$userid){
			return redirect()->to(base_url('/'));
		}
		$user = new UserModel();
		$userData = [
			'id'=>$usrid,
			'valid' => 0,
			'modified_date' => Time::now(),
		];
		$user->save($userData);
		$session = session();
		$session->setFlashdata('success', 'Attribute disabled successfully');
		return redirect()->to(base_url('/admin/allusers'));
	}

	public function enableuser($usrid){
		$session = session();
		$userid = $session->get('id');
		if(!$userid){
			return redirect()->to(base_url('/'));
		}
		$user = new UserModel();
		$userData = [
			'id'=>$usrid,
			'valid' => 1,
			'modified_date' => Time::now(),
		];
		$user->save($userData);
		$session = session();
		$session->setFlashdata('success', 'Attribute enabled successfully');
		return redirect()->to(base_url('/admin/allusers'));
	}

	/*---------------------*/
	public function searchinvoices(){
		$session = session();
		$db = \Config\Database::connect();
		$userid = $session->get('id');
		$showlimit = $session->get('allinvoices')?session()->get('invoices'):100;
		if(!$userid){
			return redirect()->to(base_url('/'));
		}
		$data = array();
		$requested = $this->request->getVar();
		$request = \Config\Services::request();
		$session = session();
		$userid = $session->get('id');
		$invoice = new Invoice();
		$user = new UserModel();
		$plans = new Plans();
		$cat1 = new Categories();
	    $data['categories'] = $cat1->findAll();
		$res = $db->query("Select * from invoice where created_at between '".$requested['startDate']."' and '".$requested['endDate']."'");
		//echo "Select * from invoice where created_at between '".$request['startDate']."' and '".$request['endDate']."'";
		$result = $res->getResult('array');
		foreach ($result as $key => $value) {
			$res = $db->query("Select email from users where id='".$value['user_id']."'");
			$userresult = $res->getResult('array');
			$result[$key]['email'] = $userresult[0]['email'];
			$res1 = $db->query("Select plan_id,plan_duration from plans_meta where id='".$value['plan_id']."'");
			$planresult = $res1->getResult('array');
			$result[$key]['plan_duration'] = $planresult[0]['plan_duration'];
			$res2 = $db->query("Select plan_name from plans where id='".$planresult[0]['plan_id']."'");
			$planresult1 = $res2->getResult('array');
			$result[$key]['plan_name'] = $planresult1[0]['plan_name'];
		}
		$settings = new Settings();
		$States = new States();
		$country_id = session()->get("country_id")?session()->get("country_id"):'101';
		$States->where('country_id',$country_id);
		$data['extras']['states'] = $States->findAll();
		$data['extras']['hotlinks'] = $settings->findAll();
		$data['extras']['selectedState'] = session()->get("state_id");
		$data['invoice'] = $result;
		$data['currentpage'] = $request->uri->getSegment(2);
		$data['module'] = $request->uri->getSegment(1);
		$data['pager'] = $invoice->pager;
		return view('all-invoice',$data);
	}

	public function allinvoices(){
		$session = session();
		$db = \Config\Database::connect();
		$userid = $session->get('id');
		$showlimit = $session->get('allinvoices')?session()->get('invoices'):100;
		if(!$userid){
			return redirect()->to(base_url('/'));
		}
		$data = array();
		$request = \Config\Services::request();
		
		$session = session();
		$userid = $session->get('id');
		$invoice = new Invoice();
		$user = new UserModel();
		$plans = new Plans();
		$cat1 = new Categories();
		$data['categories'] = $cat1->findAll();
		$invoice->where('price>',0);
		$invoice->where('deleted',0)->orderBy('id', 'desc');
		$pager = \Config\Services::pager();
		$result = $invoice->paginate($showlimit);
		$resSum = $db->query("SELECT SUM(price) as total FROM invoice WHERE listing_id IN (SELECT listing_id FROM transaction WHERE transaction_status='success' AND listing_id!='(Null)')");
		$resultSum = $resSum->getResult('array');
		foreach ($result as $key => $value) {
			$res = $db->query("Select email from users where id='".$value['user_id']."'");
			$userresult = $res->getResult('array');
			$result[$key]['email'] = $userresult[0]['email'];
			$res1 = $db->query("Select plan_id,plan_duration from plans_meta where id='".$value['plan_id']."'");
			$planresult = $res1->getResult('array');
			$result[$key]['plan_duration'] = $planresult[0]['plan_duration'];
			$res2 = $db->query("Select plan_name from plans where id='".$planresult[0]['plan_id']."'");
			$planresult1 = $res2->getResult('array');
			$result[$key]['plan_name'] = $planresult1[0]['plan_name'];
		}
		$settings = new Settings();
		$States = new States();
		$country_id = session()->get("country_id")?session()->get("country_id"):'101';
		$States->where('country_id',$country_id);
		$data['extras']['states'] = $States->findAll();
		$data['extras']['hotlinks'] = $settings->findAll();
		$data['extras']['selectedState'] = session()->get("state_id");
		$data['invoice'] = $result;
		if(count($resultSum)>0){
		    $data['total'] = $resultSum[0]['total'];
		}else{
		    $data['total'] = 0;
		}
		$data['currentpage'] = $request->uri->getSegment(2);
		$data['module'] = $request->uri->getSegment(1);
		$data['pager'] = $invoice->pager;
		return view('all-invoice',$data);
	}

	public function deleteinvoice($invoiceid){
		$request = \Config\Services::request();
		$session = session();
		$userid1 = $session->get('id');
		if(!$userid1){
			return redirect()->to(base_url('/'));
		}
		$invoice = new Invoice();
		$invoiceData = [
			'id'=>$invoiceid,
			'deleted' => '1',
			'modified_date' => Time::now(),
		];
		$invoice->save($invoiceData);
		$session = session();
		$session->setFlashdata('success', 'Invoice deleted successfully');
		return redirect()->to(base_url('/admin/allinvoices'));
	}

	public function disableinvoice($invoiceid){
		$session = session();
		$userid = $session->get('id');
		if(!$userid){
			return redirect()->to(base_url('/'));
		}
		$invoice = new Invoice();
		$invoiceData = [
			'id'=>$invoiceid,
			'valid' => 0,
			'modified_date' => Time::now(),
		];
		$invoice->save($invoiceData);
		$session = session();
		$session->setFlashdata('success', 'Attribute disabled successfully');
		return redirect()->to(base_url('/admin/allinvoices'));
	}

	public function enableinvoice($invoiceid){
		$session = session();
		$userid = $session->get('id');
		if(!$userid){
			return redirect()->to(base_url('/'));
		}
		$invoice = new Invoice();
		$invoiceData = [
			'id'=>$invoiceid,
			'valid' => 1,
			'modified_date' => Time::now(),
		];
		$invoice->save($invoiceData);
		$session = session();
		$session->setFlashdata('success', 'Attribute enabled successfully');
		return redirect()->to(base_url('/admin/allinvoices'));
	}

	public function generateInvoice(){
		$session = session();
		$userid = $session->get('id');
		if(!$userid){
			return redirect()->to(base_url('/'));
		}
	}
 public function getPostState()
  {

    $country_id = $_POST['con'];
    $data = [
      'country_id' => $country_id,
      'state_id' => "",
      'city_id' => "",
      'region_id' => ""
    ];
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

  public function getPostCity()
  {
    $db = \Config\Database::connect();
    $state_id = $_POST['con'];
    $data = [
      'state_id' => $state_id
    ];

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
  public function getPostRegion()
  {
    $db = \Config\Database::connect();
    $city_id = $_POST['con'];
    $data = [
      'city_id' => $city_id
    ];

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
  public function deleteimagebyid(){
	$selected = $this->request->getVar('con');
	$db = \Config\Database::connect();
	$que = $db->query("Delete from listing_images where id='".$selected."'");
	echo 'success';
}
	public function updatelisting(){
		if ($this->request->getMethod() == 'post') {
			$request = $this->request->getVar();
			//let's do the validation here
			$rules = [
				'reCaptcha2' => 'required|reCaptcha2[]'
			];

			$errors = [
				'reCaptcha2' => [
					'validateUser' => 'Email or Password don\'t match'
				]
			];
			$captcha_code = $this->request->getVar('code');
			$captcha = new Captcha();
			if (empty($captcha_code) || !$captcha->validateCaptcha($captcha_code)) {
				$data['validation'] = "Captcha Code Miss Match or Empty";
				return redirect()->to('/admin/editlisting/'.$request['tid'].'?error=captcha');
			}else{
			$listing = new Listing();
			$db = \Config\Database::connect();
			//$UserPlanRelationship = new UsersPlanRelationship();
			$PlansMeta = new PlansMeta();
			$Transactions = new Transactions();
			$Invoice = new Invoice();
			$keywords = new keywords();
			$ListingImages = new ListingImages();
			$RelListingAttribute = new RelListingAttribute();
			
			$session = session();
			$userid = $session->get('id');
			$listingData = [
				'id' => $request['tid'],
				'title' => $request['title'],
				'price' => $request['price'],
				//'location' => $request['region'],
				//'state_id' => $request['state'],
				//'city_id' => $request['city'],
				'category_id' => $request['subcategory']?$request['subcategory']:$request['category'],
				'description' => $this->charlimit($request['desc'],100),
				'user_id' => $userid,
				//'featured' => $request['plantype']=='featured'?1:0,
				//'premium' => $request['plantype']=='premium'?1:0,
				//'sgallery' => $request['plantype']=='sgallery'?1:0,
				'valid' => 1,
				'modified_date' => Time::now(),
			];
			$listing->save($listingData);
			$insertedId = $request['tid'];
			if($insertedId){

				if($imagefile = $this->request->getFiles())
				{	
					$i=0;
					foreach($imagefile['file'] as $img)
					{
						if ($img->isValid() && ! $img->hasMoved())
						{
							$i++;
							$newName = $img->getRandomName();
							if($i==1){
								$imageData1 = [
									'id' => $insertedId,
									'images' => 'public/uploads/'.$newName,
								];
								$listing->save($imageData1);
							}
							$imageData = [
								'listing_id' => $insertedId,
								'image_path' => 'public/uploads/'.$newName,
								'created_date' => Time::now(),
								'updated_date' => Time::now(),
							];
							$ListingImages->save($imageData);
							$img->move(APPPATH.'../public/uploads', $newName);
						}else{
							$imageData1 = [
								'id' => $insertedId,
								'images' => 'public/images/default-image.png',
							];
							$listing->save($imageData1);
							$imageData = [
								'listing_id' => $insertedId,
								'image_path' => 'public/images/default-image.png',
								'created_date' => Time::now(),
								'updated_date' => Time::now(),
							];
							$ListingImages->save($imageData);
						}
					}
				}else{
					$imageData1 = [
						'id' => $insertedId,
						'images' => 'public/images/default-image.png',
					];
					$listing->save($imageData1);
					$imageData = [
						'listing_id' => $insertedId,
						'image_path' => 'public/images/default-image.png',
						'created_date' => Time::now(),
						'updated_date' => Time::now(),
					];
					$ListingImages->save($imageData);
				}
				$que = $db->query("Delete from rel_listing_attributes where listing_id='".$insertedId."'");
				foreach ($request['name'] as $ks1 => $vs1) {
					$attrRelation=[
						'listing_id' => $insertedId,
						'attribute_id' => $vs1,
					];
					$RelListingAttribute->save($attrRelation);
				}
				$que = $db->query("Delete from keywords where listing_id='".$insertedId."'");
				$keywordsMeta = [
					'listing_id' => $insertedId,
					'keywords' => $request['keywords'],
					//'state_id' => $request['state'],
					'category_id' => $request['subcategory']?$request['subcategory']:$request['category'],
					'created_date' => Time::now(),
					'modified_date' => Time::now(),
				];
				$keywords->save($keywordsMeta);
				$query_city = $db->query("SELECT state_id FROM listing WHERE id = " . $insertedId);
				foreach ($query_city->getResult() as $row_city) {
					$id = $row_city->state_id;
					$db->query("UPDATE keywords SET state_id='".$id."' WHERE id = " . $insertedId);
				}
				/*$plans = $PlansMeta->where('id',$request['selectedDuration'])->first();
				$myTime = new Time('+'.$plans['planindays'].' days');
				$uniqueId= time().'-'.mt_rand();
				$currentTime = Time::now();
				$currentTime = str_replace(" ","",$currentTime);
				$currentTime = str_replace("-","",$currentTime);
				$currentTime = str_replace(":","",$currentTime);
				$plansData = [
					'user_id' => $userid,
					'plan_id' => $request['selectedDuration'],
					'listing_id' => $insertedId,
					'plan_start_date' => Time::now(),
					'plan_end_date' => $myTime,
					'valid' => 1,
					'created_at' => Time::now(),
					'modified_date' => Time::now(),
				];
				$UserPlanRelationship->save($plansData);
				$uprId = $UserPlanRelationship->insertID();
				$transactionData = [
					'user_id' => $userid,
					'plan_id' => $request['selectedDuration'],
					'listing_id' => $insertedId,
					'upr_id' => $uprId,
					'transaction_id' => $currentTime,
					'transaction_response' => '',
					'transaction_status' => 'success',
					'transaction_date' => Time::now(),
				];
				$Transactions->save($transactionData);
				$invoiceData = [
					'user_id' => $userid,
					'plan_id' => $request['selectedDuration'],
					'listing_id' => $insertedId,
					'upr_id' => $uprId,
					'price' => $plans['plan_price'],
					'valid' => 1,
					'created_at' => Time::now(),
					'modified_at' => Time::now(),
				];
				$Invoice->save($invoiceData);*/
				$session->setFlashdata('success', 'Ad Updated Successfully');
				return redirect()->to('/admin/editlisting/'.$insertedId);
				}
			}
		}
	}
}

function charlimit($string, $limit) {
    return substr($string, 0, $limit) . (strlen($string) > $limit ? "..." : '');
  }
