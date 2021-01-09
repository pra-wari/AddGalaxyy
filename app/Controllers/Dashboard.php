<?php namespace App\Controllers;
use App\Models\Categories;
use App\Models\Listing;
use App\Models\UserModel;
use App\Models\Settings;
use App\Models\States;
use CodeIgniter\Config\Config;
use CodeIgniter\Controller;
use CodeIgniter\I18n\Time;

class Dashboard extends BaseController
{
	public function index()
	{
		$data = [];
        $session = session();
        $isloggedin = session()->get('isLoggedIn');
        $showlimit = session()->get('dashboard')?session()->get('dashboard'):10; 
        $db = \Config\Database::connect();
        $States = new States();
        if($isloggedin){
            $data = array();
            $request = \Config\Services::request();
            $userid = $session->get('id');
            $listing = new Listing();
            $listing->where('deleted',0);
            $result = $listing->where('user_id',$userid)->paginate($showlimit);
            $pager = \Config\Services::pager(); 
            $cat1 = new Categories();
            foreach ($result as $key1 => $value1) {
                $res = $db->query("Select email from users where id='".$value1['user_id']."'");
			    $result[$key1]['userEmail'] = $res->getResult('array')[0]['email'];
                $res1 = $db->query("SELECT users_plan_relation.id AS relid,plans.`id`,plans.`plan_name`,plans_meta.`id` AS planmeta,users_plan_relation.plan_start_date,users_plan_relation.plan_end_date FROM users_plan_relation 
                INNER JOIN plans_meta ON users_plan_relation.`plan_id`= plans_meta.id
                INNER JOIN plans ON plans_meta.`plan_id` = plans.id
                WHERE users_plan_relation.id IN (SELECT MAX(id) FROM users_plan_relation WHERE listing_id='".$value1['id']."' GROUP BY plan_id)");

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
				if(isset($res->getResult('array')[0]['name'])){
				    $result[$key1]['region'] = $res->getResult('array')[0]['name'];
				}else{
				    $result[$key1]['region'] = '';
				}
			
            }
            $settings = new Settings();
            $States = new States();
            $country_id = session()->get("country_id")?session()->get("country_id"):'101';
            $States->where('country_id',$country_id);
            $data['extras']['states'] = $States->findAll();
            $data['extras']['hotlinks'] = $settings->findAll();
            $data['extras']['selectedState'] = session()->get("state_id");
	        $data['categories'] = $cat1->findAll();
            $data['listing'] = $result;
            $data['currentpage'] = $request->uri->getSegment(2);
            $data['module'] = $request->uri->getSegment(1);
            $data['pager'] = $listing->pager;
            echo view('dashboard',$data);
        }else{
            echo 'entered';
            return redirect()->to('login');
        }
        
    }
    public function showlimit(){
        $request = \Config\Services::request();
        $pagename = $this->request->getVar('pagename');
        $showlimit = $this->request->getVar('showlimit');
        $data = ["$pagename" => $showlimit];
        session()->set($data);
        echo 'success';
    }
    public function setstaticscategory(){
        $request = \Config\Services::request();
        $pagename = $this->request->getVar('pagename');
        $category = $this->request->getVar('category');
        $data = ["staticsCategory" => $category];
        session()->set($data);
        echo 'success';
    }
    public function setstaticslocation(){
        $request = \Config\Services::request();
        $pagename = $this->request->getVar('pagename');
        $location = $this->request->getVar('location');
        if($location==''){
            $data1 = ["staticscities" => ''];
            session()->set($data1);
        }
        $data = ["staticslocation" => $location];
        session()->set($data);
        echo 'success';
    }
    public function setstaticscity(){
        $request = \Config\Services::request();
        $pagename = $this->request->getVar('pagename');
        $cities = $this->request->getVar('cities');
        $data = ["staticscities" => $cities];
        session()->set($data);
        echo 'success';
    }
    public function setstaticstypeads(){
        $request = \Config\Services::request();
        $pagename = $this->request->getVar('pagename');
        $typeofads = $this->request->getVar('typeofads');
        $data = ["staticsTypeAds" => $typeofads];
        session()->set($data);
        echo 'success';
    }
    
    public function dateDiffInDays($date1, $date2)  
	{ 
		if(strtotime($date2)>strtotime($date1)){
			$diff = strtotime($date2) - strtotime($date1); 
			return abs(round($diff / 86400)); 
		}else{
			return 0;
		}
		
    }
    public function fetchdatabyplan(){
        $session = session();
        $db = \Config\Database::connect();
        $response = array();
		$userid = $session->get('id');
        $requestData = $this->request->getVar('planid');
        $showlimit = $session->get('allads')?session()->get('allads'):10;
        $res = $db->query("SELECT * FROM listing WHERE id IN (SELECT DISTINCT listing_id FROM users_plan_relation WHERE plan_id='".$requestData."') LIMIT ".$showlimit);
        $result = $res->getResult('array');
        foreach ($result as $key1 => $value1) {
			$res = $db->query("Select email from users where id='".$value1['user_id']."'");
			$result[$key1]['userEmail'] = $res->getResult('array')[0]['email'];
			$res1 = $db->query("SELECT plans.`plan_name`,users_plan_relation.plan_end_date FROM users_plan_relation 
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
			$result[$key1]['region'] = $res->getResult('array')[0]['name'];
        }
        $response['status'] = 'success';
        $response['msg'] = 'Data fetched Successfully';
        $response['data'] = $result;
        echo json_encode($response);
    }
    
    public function deleteData(){
        $request = \Config\Services::request();
        $requestData = $this->request->getVar();
        $response = array();
        $db = \Config\Database::connect();
        $data = implode(',',$requestData['data']);
        if($requestData['page']=='allads'){
            if($data){
                $db->query("update listing set deleted=1 where id in (".$data.")");
                $response['status'] = 'success';
                $response['msg'] = 'Data Deleted Successfully';
                echo json_encode($response);
            }else{
                $response['status'] = 'failed';
                $response['msg'] = 'Something went wrong. please try later';
                echo json_encode($response);
            }
        }
        if($requestData['page']=='parentcategories'){
            if($data){
                $db->query("update categories set deleted=1 where id in (".$data.")");
                $response['status'] = 'success';
                $response['msg'] = 'Data Deleted Successfully';
                echo json_encode($response);
            }else{
                $response['status'] = 'failed';
                $response['msg'] = 'Something went wrong. please try later';
                echo json_encode($response);
            }
        }
        if($requestData['page']=='childcategories'){
            if($data){
                $db->query("update categories set deleted=1 where id in (".$data.")");
                $response['status'] = 'success';
                $response['msg'] = 'Data Deleted Successfully';
                echo json_encode($response);
            }else{
                    $response['status'] = 'failed';
                    $response['msg'] = 'Something went wrong. please try later';
                    echo json_encode($response);
            }
        }
        if($requestData['page']=='allPlans'){
            if($data){
                $db->query("update plans set deleted=1 where id in (".$data.")");
                $response['status'] = 'success';
                $response['msg'] = 'Data Deleted Successfully';
                echo json_encode($response);
            }else{
                    $response['status'] = 'failed';
                    $response['msg'] = 'Something went wrong. please try later';
                    echo json_encode($response);
            }
        }
        if($requestData['page']=='allattributes'){
            if($data){
                $db->query("update attributes set deleted=1 where id in (".$data.")");
                $response['status'] = 'success';
                $response['msg'] = 'Data Deleted Successfully';
                echo json_encode($response);
            }else{
                    $response['status'] = 'failed';
                    $response['msg'] = 'Something went wrong. please try later';
                    echo json_encode($response);
            }
        }
        if($requestData['page']=='allusers'){
            if($data){
                $db->query("update users set deleted=1 where id in (".$data.")");
                $response['status'] = 'success';
                $response['msg'] = 'Data Deleted Successfully';
                echo json_encode($response);
            }else{
                    $response['status'] = 'failed';
                    $response['msg'] = 'Something went wrong. please try later';
                    echo json_encode($response);
            }
        }
        if($requestData['page']=='allinvoices'){
            if($data){
                $db->query("update invoice set deleted=1 where id in (".$data.")");
                $response['status'] = 'success';
                $response['msg'] = 'Data Deleted Successfully';
                echo json_encode($response);
            }else{
                    $response['status'] = 'failed';
                    $response['msg'] = 'Something went wrong. please try later';
                    echo json_encode($response);
            }
        }
        if($requestData['page']=='localities'){
            if($data){
                $db->query("update region set deleted=1 where id in (".$data.")");
                $response['status'] = 'success';
                $response['msg'] = 'Data Deleted Successfully';
                echo json_encode($response);
            }else{
                    $response['status'] = 'failed';
                    $response['msg'] = 'Something went wrong. please try later';
                    echo json_encode($response);
            }
        }
    }

	//--------------------------------------------------------------------

}