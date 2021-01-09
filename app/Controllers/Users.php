<?php namespace App\Controllers;
use App\Models\Categories;
use App\Models\Listing;
use App\Models\UserModel;
use App\Models\Plans;
use App\Models\PlansMeta;
use App\Models\Attributes;
use App\Models\Countries;
use App\Models\Invoice;
use App\Models\Enquiry;
use App\Models\Chat;
use App\Models\Settings;
use App\Models\States;
use App\Models\Keywords;
use App\Models\Pages;
use App\Models\Transactions;
use App\Models\MainAttributes;
use App\Models\ListingImages;
use App\Models\UsersPlanRelationship;
use App\Models\RelListingAttribute;
use CodeIgniter\Config\Config;
use CodeIgniter\Controller;
use CodeIgniter\I18n\Time;
use App\Libraries\Captcha;
 

class Users extends Controller
{
	public function login()
	{
	    $db = \Config\Database::connect();
		$session = session();
		$userid = $session->get('id');
      	if($userid){
			return redirect()->to(base_url('/'));
		}
		$data = [];
		$data1= array();
		helper(['form']);


		if ($this->request->getMethod() == 'post') {
			//let's do the validation here
			$rules = [
				'email' => 'required|min_length[6]|max_length[50]|valid_email',
				'password' => 'required|min_length[8]|max_length[255]',
			];

			$errors = [
				'password' => [
					'validateUser' => 'Email or Password don\'t match'
				]
			];

			if (! $this->validate($rules, $errors)) {
				$data['validation'] = $this->validator;
			}else{
			    
				//$model = new UserModel();
				//$model->where('deleted',0);
				//$model->where('valid',1);
				//$model->where('password',$this->request->getVar('password'));
				//$user = $model->where('email', $this->request->getVar('email'))->findAll();
				//$userres = $model->findAll();
				$res = $db->query("Select * from users where email='".$this->request->getVar('email')."' and password='".$this->request->getVar('password')."' and deleted=0 and valid=1 ");
			    $userres = $res->getResult('array');
				
				
				if(isset($userres[0]['id'])){
				    $user=$userres[0];
					$this->setUserSession($user);
					
					if($user['username']=='admin' || $user['usertype']=='admin' || $user['usertype']=='administrator'){
						return redirect()->to('/admin');
					}else{
						return redirect()->to('/dashboard');
					}
				}else{
					$session->setFlashdata('fail', 'This Account Does not exists!');
					return redirect()->to(base_url('/login?status=fail'));
				}
			}
		}
		$settings = new Settings();
		$States = new States();
		$country_id = session()->get("country_id")?session()->get("country_id"):'101';
		$States->where('country_id',$country_id);
		$data1['extras']['states'] = $States->findAll();
		$data1['extras']['hotlinks'] = $settings->findAll();
		$data1['extras']['selectedState'] = session()->get("state_id");
		$requestMain = \Config\Services::request();
    	$data1['currentpage'] = $requestMain->uri->getSegment(2);
		$cat1 = new Categories();
		$data1['categories'] = $cat1->findAll();
		$msg='';
		if(isset($_REQUEST['status']) && $_REQUEST['status']=='fail'){
			$msg = 'User Not exists';
		}else if(isset($_REQUEST['status']) && $_REQUEST['status']=='changed'){
			$msg = 'Password Changed successully';
		}
	    $data1['message'] = $msg;
		echo view('login',$data1);
		
	}
	public function verifyemail(){
		$id= base64_decode($_REQUEST['key']);
		$users = new UserModel();
		$userdata = [
			'id' => $id,
			'verified' => 1,
		];
		$users->save($userdata);
		return redirect()->to(base_url('/')); 
	}

	public function updatenewpassword(){
		$data=  $this->request->getVar();
		$users = new UserModel();
		if($data['password']==$data['cpassword']){
			$userdata = [
				'id' => $data['userid'],
				'password' => $data['cpassword'],
			];
			$users->save($userdata);
			return redirect()->to(base_url('/login?status=changed')); 
		}else{
			return redirect()->to(base_url('/login?status=fail')); 
		}
	}
	public function SendEnquiry(){
	    $config=array();
		$config['protocol'] = 'sendmail';
        $config['mailPath'] = '/usr/sbin/sendmail';
        $config['charset']  = 'utf-8';
        $config['wordWrap'] = true;
        $config['mailType'] = 'html';
		$requestMain = \Config\Services::request();
		$db = \Config\Database::connect();
		$name = $this->request->getVar('name');
		$useremail = $this->request->getVar('email');
		$subject = $this->request->getVar('subject');
		$time=Time::now();
		$db->query("INSERT INTO messages (name, email,message,created_date,updated_date)
		VALUES ('".$name."','".$useremail."','".$subject."','".$time."','".$time."')");
		$message='';
		$message = 'Hi Admin <br />';
		$message .= 'You have Recieved an Enquiry'.' <br />';
		$message .= 'Details Are: <br />';
		$message .= 'Name: '.$name.' <br />';
		$message .= 'Email: '.$useremail.' <br />';
		$message .= 'Subject: '.$subject.' <br />';

		$email = \Config\Services::email();
		$email->initialize($config);
		$email->setFrom($useremail, $name);
		$email->setTo('info@addgalaxy.com');
		$email->setSubject('Enquiry');
		$email->setMessage($message);
		$email->send();
		return redirect()->to(base_url('/contact-us?status=success')); 
	}
	
	public function sendforgotpassword(){
	    $config=array();
		$config['protocol'] = 'sendmail';
        $config['mailPath'] = '/usr/sbin/sendmail';
        $config['charset']  = 'utf-8';
        $config['wordWrap'] = true;
        $config['mailType'] = 'html';
		$requestMain = \Config\Services::request();
		$email = $this->request->getVar('email');
		$message='';
		$users = new UserModel();
		$users->where('email=',$email);
		$res = $users->findAll();
		if(count($res)>0){
    		$message = 'Hi '.$res[0]['firstname'].' <br />';
    		$message .= 'Please Click on below link to update Password'.' <br />';
    		$message .= '<a href="'.base_url('/users/emailforgotpassword/?key='.base64_encode($res[0]['id'])).'">'.base_url('/users/emailforgotpassword/?key='.base64_encode($res[0]['id'])).'</a>';
    		$email = \Config\Services::email();
    		$email->initialize($config);
    		$email->setFrom('info@addgalaxy.com', 'Admin');
    		$email->setTo($res[0]['email']);
    		$email->setSubject('Email Verification');
    		$email->setMessage($message);
    		$email->send();
    		return redirect()->to(base_url('/login')); 
		}else{
		    return redirect()->to(base_url('/login?status=fail')); 
		}
	}

	public function contactus(){
		$session = session();
		$userid = $session->get('id');
		$data = [];
		$data1= array();
		helper(['form']);

		$settings = new Settings();
		$States = new States();
		$country_id = session()->get("country_id")?session()->get("country_id"):'101';
		$States->where('country_id',$country_id);
		$data1['extras']['states'] = $States->findAll();
		$data1['extras']['hotlinks'] = $settings->findAll();
		$data1['extras']['selectedState'] = session()->get("state_id");
		$requestMain = \Config\Services::request();
    	$data1['currentpage'] = $requestMain->uri->getSegment(2);
		$cat1 = new Categories();
	    $data1['categories'] = $cat1->findAll();
	    $data1['message'] = (isset($_REQUEST['status']) && $_REQUEST['status']=='success')?'Enquiry Sent Successfully':'';
		echo view('contact',$data1);
	}

	public function emailforgotpassword(){
		$id= base64_decode($_REQUEST['key']);
		$session = session();
		$userid = $session->get('id');
      	if($userid){
			return redirect()->to(base_url('/'));
		}
		$data = [];
		$data1= array();
		helper(['form']);

		$settings = new Settings();
		$States = new States();
		$country_id = session()->get("country_id")?session()->get("country_id"):'101';
		$States->where('country_id',$country_id);
		$data1['extras']['states'] = $States->findAll();
		$data1['extras']['hotlinks'] = $settings->findAll();
		$data1['extras']['selectedState'] = session()->get("state_id");
		$requestMain = \Config\Services::request();
    	$data1['currentpage'] = $requestMain->uri->getSegment(2);
		$cat1 = new Categories();
	    $data1['categories'] = $cat1->findAll();
	    $data1['currentid'] = $id;
		echo view('changepassword',$data1);
	}


	private function setUserSession($user){
		$data = [
			'id' => $user['id'],
			'firstname' => $user['firstname'],
			'lastname' => $user['lastname'],
			'email' => $user['email'],
			'username' => $user['username'],
			'usertype' => $user['usertype'],
			'isLoggedIn' => true,
		];

		session()->set($data);
		return true;
	}
	public function forgotpassword(){
		$session = session();
		$userid = $session->get('id');
      	if($userid){
			return redirect()->to(base_url('/'));
		}
		$data = [];
		$data1= array();
		helper(['form']);

		$settings = new Settings();
		$States = new States();
		$country_id = session()->get("country_id")?session()->get("country_id"):'101';
		$States->where('country_id',$country_id);
		$data1['extras']['states'] = $States->findAll();
		$data1['extras']['hotlinks'] = $settings->findAll();
		$data1['extras']['selectedState'] = session()->get("state_id");
		$requestMain = \Config\Services::request();
    	$data1['currentpage'] = $requestMain->uri->getSegment(2);
		$cat1 = new Categories();
	    $data1['categories'] = $cat1->findAll();
	    $data1['message'] = (isset($_REQUEST['status']) && $_REQUEST['status']=='fail')?'User Not exists':'';
		echo view('forgotpassword',$data1);
	}

	public function register(){
		$data = [];
		$cat1 = new Categories();
	    $data['categories'] = $cat1->findAll();
		helper(['form']);
		if ($this->request->getMethod() == 'post') {
			//let's do the validation here
			$rules = [
				'sfirstname' => 'required|min_length[3]|max_length[20]',
				'email' => 'required|min_length[6]|max_length[50]',
				'password' => 'required|min_length[8]|max_length[255]',
				'password_confirm' => 'matches[password]',
			];

			if (! $this->validate($rules)) {
				$data['validationSignup'] = $this->validator;
				$settings = new Settings();
				$States = new States();
				$country_id = session()->get("country_id")?session()->get("country_id"):'101';
				$States->where('country_id',$country_id);
				$data['extras']['states'] = $States->findAll();
				$data['extras']['hotlinks'] = $settings->findAll();
				$data['extras']['selectedState'] = session()->get("state_id");
				$requestMain = \Config\Services::request();
    			$data['currentpage'] = $requestMain->uri->getSegment(2);
				$cat1 = new Categories();
				$data['categories'] = $cat1->findAll();
				echo view('login',$data);
			}else{
				$model = new UserModel();
				$newData = [
					'firstname' => $this->request->getVar('sfirstname'),
					'lastname' => $this->request->getVar('slastname'),
					'email' => $this->request->getVar('email'),
					'password' => $this->request->getVar('password'),
					'mobile' => $this->request->getVar('mobile'),
				];
				$model->save($newData);
				$session = session();
				$model = new UserModel();
				$user = $model->where('email', $this->request->getVar('email'))->first();
				$this->setUserSession($user);
				$session->setFlashdata('success', 'Successful Registration');
				return redirect()->to('/');
			}
		}else{
			$settings = new Settings();
			$States = new States();
			$country_id = session()->get("country_id")?session()->get("country_id"):'101';
			$States->where('country_id',$country_id);
			$data1['extras']['states'] = $States->findAll();
			$data1['extras']['hotlinks'] = $settings->findAll();
			$data1['extras']['selectedState'] = session()->get("state_id");
			$requestMain = \Config\Services::request();
    		$data['currentpage'] = $requestMain->uri->getSegment(2);
			$cat1 = new Categories();
			$data1['categories'] = $cat1->findAll();
			echo view('login',$data);
		}
	}

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

	public function profile(){
		
		$data = [];
		$cat1 = new Categories();
	    $data['categories'] = $cat1->findAll();
		helper(['form']);
		$model = new UserModel();

		if ($this->request->getMethod() == 'post') {
			//let's do the validation here
			$rules = [
				'firstname' => 'required|min_length[3]|max_length[20]',
				'lastname' => 'required|min_length[3]|max_length[20]',
				];

			if($this->request->getPost('password') != ''){
				$rules['password'] = 'required|min_length[8]|max_length[255]';
				$rules['password_confirm'] = 'matches[password]';
			}


			if (! $this->validate($rules)) {
				$data['validation'] = $this->validator;
			}else{

				$newData = [
					'id' => session()->get('id'),
					'firstname' => $this->request->getPost('firstname'),
					'lastname' => $this->request->getPost('lastname'),
					];
					if($this->request->getPost('password') != ''){
						$newData['password'] = $this->request->getPost('password');
					}
				$model->save($newData);

				session()->setFlashdata('success', 'Successfuly Updated');
				return redirect()->to('/profile');

			}
		}
		$requestMain = \Config\Services::request();
    	$data['currentpage'] = $requestMain->uri->getSegment(2);
		$data['user'] = $model->where('id', session()->get('id'))->first();
		
		echo view('profile');
		
	}
	public function messages($userid){
		$data = array();
		$cat1 = new Categories();
		$chat = new Chat();
		$enquiry = new Enquiry();
		$db = \Config\Database::connect();
		$status_condition = 'owner_id = '.$userid.' or sender_id = '.$userid;
		$enquiry->where($status_condition);
		$result = $enquiry->paginate(10);
		$request = \Config\Services::request();
		
		foreach ($result as $key1 => $value1) {
			$res = $db->query("Select title from listing where id='".$value1['ad_id']."'");
			$listing = $res->getResult('array');
			$result[$key1]['ad_name'] = $listing[0]['title'];
			$res = $db->query("Select message,created_date from chat where enquiry_id='".$value1['id']."' ORDER BY created_date DESC LIMIT 1");
			$listing = $res->getResult('array');
			$result[$key1]['message'] = $listing?$listing[0]['message']:'';
			$result[$key1]['lastmessagedate'] = $listing?$listing[0]['created_date']:'';
		}
		if(count($result)>0){
			$id = isset($_REQUEST['msgid'])?$_REQUEST['msgid']:$result[0]['id'];
			$chat->where('enquiry_id',$id);
			$chat->where('deleted',0);
			$res = $db->query("SELECT title FROM listing WHERE id IN (SELECT ad_id FROM enquiry WHERE id='".$id."');");
			$data['title'] = $res->getResult('array')[0];
			$data['chat'] = $chat->findAll();
			$data['enquiry_id'] = $id;
			$enquiryData = [
				'id' => $id,
				'read'=>1,
			];
			$enquiry->save($enquiryData);
		}
		$settings = new Settings(); 
		$States = new States();
		$country_id = session()->get("country_id")?session()->get("country_id"):'101';
		$States->where('country_id',$country_id);
		$data['extras']['states'] = $States->findAll();
		$data['extras']['hotlinks'] = $settings->findAll();
		$data['extras']['selectedState'] = session()->get("state_id");
		$data['messages'] = $result;
		$data['categories'] = $cat1->findAll();
		$data['currentpage'] = $request->uri->getSegment(2);
		$data['module'] = $request->uri->getSegment(1);
		$data['pager'] = $enquiry->pager;
		echo view('user-messages',$data);
	}

	public function deleteallchat($enquiry_id){
		$db = \Config\Database::connect();
		$userid = session()->get('id');
		$db->query("update chat set deleted=1 WHERE enquiry_id='".$enquiry_id."'");
		return redirect()->to(base_url('users/messages/'.$userid));
	}
	public function sendmessage(){
		$request = \Config\Services::request();
		$chat = new Chat();
		$userid = session()->get('id');
		$requested = $this->request->getVar();
		$chatData = [
			'enquiry_id' => $requested['enquiry_id'],
			'sender_id'=>$requested['sender_id'],
			'message'=>$requested['message'],
			'created_date'=>Time::now(),
			'modified_date'=>Time::now(),
			'deleted'=>0,
		];
		$chat->save($chatData);
		echo 'success';
		//return redirect()->to(base_url('users/messages/'.$userid.'?msgid='.$requested['enquiry_id']));
	}

	public function invoices($userid){
		$session = session();
		$db = \Config\Database::connect();
		$userid = $session->get('id');
		$showlimit = session()->get('invoices')?session()->get('invoices'):10;
		if(!$userid){
			return redirect()->to(base_url('/'));
		}
		$data = array();
		$request = \Config\Services::request();
		$session = session();
		$userid = $session->get('id');
		$invoice = new Invoice();
		$plans = new Plans();
		$users = new UserModel();
		$plansmeta = new PlansMeta();
		$cat1 = new Categories();
		$users = new UserModel();
		$UsersPlanRelationship = new UsersPlanRelationship();
		$transactions = new Transactions();
		$listing = new Listing();
		$data['categories'] = $cat1->findAll();
		$invoice->where('price>',0);
		$invoice->where('deleted',0);
		$invoice->where('user_id',$userid);
		$pager = \Config\Services::pager();
		$result = $invoice->paginate($showlimit);
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
			$transactions->where('upr_id',$value['upr_id']);
			$result[$key]['transactions'] = $transactions->findAll();
		}
		

		foreach ($result as $key => $value) {
			$upr_id = $value['upr_id'];
			/*$UsersPlanRelationship->where('id',$upr_id);
			$relationData = $UsersPlanRelationship->findAll();
			$result[$key]['relationData'] = $relationData;

			$listing->where('id',$relationData[0]['listing_id']);
			$result[$key]['listing'] = $listing->findAll();

			$users->where('id',$value['user_id']);
			$result[$key]['user'] = $users->findAll();*/

			

			$plansmeta->where('id',$value['plan_id']);
			$metaData = $plansmeta->findAll();
			$plans->where('id',$metaData[0]['plan_id']);
			$result[$key]['plansmeta'] = $metaData;
			$result[$key]['plans'] = $plans->findAll();
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
		return view('user-invoice',$data);
	}
	public function fetchDetails(){
		$data = array();
		$db = \Config\Database::connect();
		$request = $this->request->getVar();
		$res = $db->query("SELECT plans.id AS plan_id,plans.plan_name,plans_meta.id AS plans_meta_id,plans_meta.plan_duration,
		plans_meta.plan_duration,plans_meta.`plan_price`,plans_meta.`planindays`
		FROM plans_meta 
		INNER JOIN plans ON plans.`id` = plans_meta.`plan_id`
		WHERE plans_meta.id='".$request['plan']."'");
		$userresult = $res->getResult('array');
		$result = [
			'status'=> 'success',
			'data'=>$userresult,
		];
		echo json_encode($result);
	}
	public function renewplan(){
		try {
			$data = array();
			$request = $this->request->getVar();
			$UserPlanRelationship = new UsersPlanRelationship();
			$session = session();
			$userid = $session->get('id');
			$db = \Config\Database::connect();
			$PlansMeta = new PlansMeta();
			$plans = $PlansMeta->where('id',$request['plan'])->first();
			$myTime = new Time('+'.$plans['planindays'].' days');
			$planData = [
				'user_id' => $userid,
				'plan_id' => $request['plan'],
				'listing_id' => $request['listing'],
				'plan_start_date' => Time::now(),
				'plan_end_date' => $myTime,
				'created_at' => Time::now(),
				'modified_at' => Time::now(),
				'valid' => 1,
			];
			$UserPlanRelationship->save($planData);
			$result = [
				'status'=> 'success',
			];
			echo json_encode($result);
		} catch (\Throwable $th) {
			print_r($th);
			$result = [
				'status'=> 'fail',
			];
			echo json_encode($result);
		}
		
		/*$res = $db->query("SELECT plans.id AS plan_id,plans.plan_name,plans_meta.id AS plans_meta_id,plans_meta.plan_duration,
		plans_meta.plan_duration,plans_meta.`plan_price`,plans_meta.`planindays`
		FROM plans_meta 
		INNER JOIN plans ON plans.`id` = plans_meta.`plan_id`
		WHERE plans_meta.id='".$request['plan']."'");
		//$userresult = $res->getResult('array');
		$result = [
			'status'=> 'success',
			'data'=>$userresult,
		];
		echo json_encode($result);*/
	}

	public function submitad(){
		$db = \Config\Database::connect();
		$data = array();
		if ($this->request->getMethod() == 'post') {
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
				return redirect()->to('/postad?error=captcha');
			}else{
				
				$listing = new Listing();
				$UserPlanRelationship = new UsersPlanRelationship();
				$PlansMeta = new PlansMeta();
				$Transactions = new Transactions();
				$Invoice = new Invoice();
				$keywords = new keywords();
				$ListingImages = new ListingImages();
				$RelListingAttribute = new RelListingAttribute();
				$request = $this->request->getVar();
		/*	echo "<pre>";
			print_r($request);
			die;*/
				$session = session();
				$userid = $session->get('id');
				$listingData = [
					'title' => $request['title'],
					'price' => $request['price'],
					'location' => $request['region'],
					'state_id' => $request['state'],
					'city_id' => $request['city'],
					'category_id' => $request['subcategory']?$request['subcategory']:$request['category'],
					'description' => $this->charlimit($request['desc'],60),
					'user_id' => $userid,
					'featured_status' => $request['plantype4']=='featured'?1:0,
					'premium_status' => $request['plantype3']=='sgallery'?1:0,
					'sgallery_status' => $request['plantype2']=='premium'?1:0,
					'valid' => 1,
					'modified_date' => Time::now(),
				];
			
				$listing->save($listingData);
				$insertedId = $listing->insertID();
		
				if($insertedId){
					$cat_Id = $request['subcategory']?$request['subcategory']:$request['category'];
					$db->query("UPDATE categories SET count = count + 1 WHERE id = '".$cat_Id."'");
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
					if($request['name']){
					foreach ($request['name'] as $ks1 => $vs1) {
						$attrRelation=[
							'listing_id' => $insertedId,
							'attribute_id' => $vs1,
						];
						$RelListingAttribute->save($attrRelation);
					}
					}
					$keywordsMeta = [
						'listing_id' => $insertedId,
						'keywords' => $request['keywords'],
						'state_id' => $request['state'],
						'category_id' => $request['subcategory']?$request['subcategory']:$request['category'],
						'created_date' => Time::now(),
						'modified_date' => Time::now(),
					];
					$keywords->save($keywordsMeta);
					$plans = $PlansMeta->where('id',$request['selectedDuration'])->first();
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
					$Invoice->save($invoiceData);
					$session->setFlashdata('success', 'Your Ad Request successfully Received');
					return redirect()->to('/');
				}
			}
		}
	}
	public function disclaimer(){
		$pages = new Pages();
		$pages->where('deleted',0);
		$pages->where('id',1);
		$data = array();	 
	  	$cat = new Categories();
	  	$countries = new Countries();
	  	$cat->where('deleted',0);
	  	$data = $cat->findAll();
	  	$catArray = array();
	  	foreach ($data as $key => $value){
			if($value['parent_id']==0){
				$catArray[] = $value; 
			}
		}
		foreach ($catArray as $k => $v) {
			foreach ($data as $key => $value1){
				if($v['id']==$value1['parent_id']){
					$catArray[$k]['subCategory'][] = $value1; 
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
   		$data['page'] = $pages->findAll();
		$data['categories'] = $catArray;
		$requestMain = \Config\Services::request();
    	$data['currentpage'] = $requestMain->uri->getSegment(2);   
   		$data['countries'] = $countries->findAll();
		echo view('page',$data);
	}
	public function privacypolicy(){
		$pages = new Pages();
		$pages->where('deleted',0);
		$pages->where('id',2);
		$data = array();	 
	  	$cat = new Categories();
	  	$countries = new Countries();
	  	$cat->where('deleted',0);
	  	$data = $cat->findAll();
	  	$catArray = array();
	  	foreach ($data as $key => $value){
			if($value['parent_id']==0){
				$catArray[] = $value; 
			}
		}
		foreach ($catArray as $k => $v) {
			foreach ($data as $key => $value1){
				if($v['id']==$value1['parent_id']){
					$catArray[$k]['subCategory'][] = $value1; 
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
   		$data['page'] = $pages->findAll();
		$data['categories'] = $catArray;
		$requestMain = \Config\Services::request();
    	$data['currentpage'] = $requestMain->uri->getSegment(2);   
   		$data['countries'] = $countries->findAll();
		echo view('page',$data);
	}
	public function contact(){
		$pages = new Pages();
		$pages->where('deleted',0);
		$pages->where('id',3);
		$data = array();	 
	  	$cat = new Categories();
	  	$countries = new Countries();
	  	$cat->where('deleted',0);
	  	$data = $cat->findAll();
	  	$catArray = array();
	  	foreach ($data as $key => $value){
			if($value['parent_id']==0){
				$catArray[] = $value; 
			}
		}
		foreach ($catArray as $k => $v) {
			foreach ($data as $key => $value1){
				if($v['id']==$value1['parent_id']){
					$catArray[$k]['subCategory'][] = $value1; 
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
   		$data['page'] = $pages->findAll();
		$data['categories'] = $catArray;
		$requestMain = \Config\Services::request();
    	$data['currentpage'] = $requestMain->uri->getSegment(2);   
   		$data['countries'] = $countries->findAll();
		echo view('page',$data);
	}
	public function aboutus(){
		$pages = new Pages();
		$pages->where('deleted',0);
		$pages->where('id',4);
		$data = array();	 
	  	$cat = new Categories();
	  	$countries = new Countries();
	  	$cat->where('deleted',0);
	  	$data = $cat->findAll();
	  	$catArray = array();
	  	foreach ($data as $key => $value){
			if($value['parent_id']==0){
				$catArray[] = $value; 
			}
		}
		foreach ($catArray as $k => $v) {
			foreach ($data as $key => $value1){
				if($v['id']==$value1['parent_id']){
					$catArray[$k]['subCategory'][] = $value1; 
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
   		$data['page'] = $pages->findAll();
		$data['categories'] = $catArray;
		$requestMain = \Config\Services::request();
    	$data['currentpage'] = $requestMain->uri->getSegment(2);   
   		$data['countries'] = $countries->findAll();
		echo view('page',$data);
	}
	public function termscondition(){
		$pages = new Pages();
		$pages->where('deleted',0);
		$pages->where('id',6);
		$data = array();	 
	  	$cat = new Categories();
	  	$countries = new Countries();
	  	$cat->where('deleted',0);
	  	$data = $cat->findAll();
	  	$catArray = array();
	  	foreach ($data as $key => $value){
			if($value['parent_id']==0){
				$catArray[] = $value; 
			}
		}
		foreach ($catArray as $k => $v) {
			foreach ($data as $key => $value1){
				if($v['id']==$value1['parent_id']){
					$catArray[$k]['subCategory'][] = $value1; 
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
   		$data['page'] = $pages->findAll();
		$data['categories'] = $catArray;
		$requestMain = \Config\Services::request();
    	$data['currentpage'] = $requestMain->uri->getSegment(2);   
   		$data['countries'] = $countries->findAll();
		echo view('page',$data);
	}
	public function refundcancellation(){
		$pages = new Pages();
		$pages->where('deleted',0);
		$pages->where('id',7);
		$data = array();	 
	  	$cat = new Categories();
	  	$countries = new Countries();
	  	$cat->where('deleted',0);
	  	$data = $cat->findAll();
	  	$catArray = array();
	  	foreach ($data as $key => $value){
			if($value['parent_id']==0){
				$catArray[] = $value; 
			}
		}
		foreach ($catArray as $k => $v) {
			foreach ($data as $key => $value1){
				if($v['id']==$value1['parent_id']){
					$catArray[$k]['subCategory'][] = $value1; 
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
   		$data['page'] = $pages->findAll();
		$data['categories'] = $catArray;
		$requestMain = \Config\Services::request();
    	$data['currentpage'] = $requestMain->uri->getSegment(2);   
   		$data['countries'] = $countries->findAll();
		echo view('page',$data);
	}
	
	public function pricing(){
		$pages = new Pages();
		$pages->where('deleted',0);
		$pages->where('id',8);
		$data = array();	 
	  	$cat = new Categories();
	  	$countries = new Countries();
	  	$cat->where('deleted',0);
	  	$data = $cat->findAll();
	  	$catArray = array();
	  	foreach ($data as $key => $value){
			if($value['parent_id']==0){
				$catArray[] = $value; 
			}
		}
		foreach ($catArray as $k => $v) {
			foreach ($data as $key => $value1){
				if($v['id']==$value1['parent_id']){
					$catArray[$k]['subCategory'][] = $value1; 
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
   		$data['page'] = $pages->findAll();
		$data['categories'] = $catArray;
		$requestMain = \Config\Services::request();
    	$data['currentpage'] = $requestMain->uri->getSegment(2);   
   		$data['countries'] = $countries->findAll();
		echo view('page',$data);
	}

	public function postad(){

		helper(['form', 'captcha']);
		$db = \Config\Database::connect();
		$data = array();	 
	  	$cat = new Categories();
	  	$countries = new Countries();
	  	$cat->where('deleted',0);
	  	//$countries->where('deleted',0);
	  	$data = $cat->findAll();
	  	$catArray = array();
	  	foreach ($data as $key => $value){
			if($value['parent_id']==0){
				$catArray[] = $value; 
			}
	}
   
   foreach ($catArray as $k => $v) {
      foreach ($data as $key => $value1){
       if($v['id']==$value1['parent_id']){
        $catArray[$k]['subCategory'][] = $value1; 
       }
    }
   }

$queryplan = $db->query("SELECT * FROM plans WHERE valid=1 AND deleted=0");
$planArray = array();
foreach ($queryplan->getResult() as $rowplan)
{
    $temp['id'] = $rowplan->id;
    $temp['plan_name'] = $rowplan->plan_name;
    $temp['type'] = $rowplan->type;
    

    $query_planmeta = $db->query("SELECT * FROM plans_meta WHERE valid=1 AND deleted=0 AND plan_id=".$temp['id']);
    $result_subatt = array();
    $i=0;
    $temp3 = array();
    foreach ($query_planmeta->getResult() as $row_subatt)
    {
            $temp2['id'] = $row_subatt->id;
            $temp2['plan_duration'] = $row_subatt->plan_duration;
            $temp2['plan_price'] = $row_subatt->plan_price;
            array_push($temp3, $temp2);
          $i++;
    }
    $temp['meta']=$temp3;
    // echo "<pre>";
    // print_r($temp);
    // echo "</pre>";
        array_push($planArray, $temp);
}
		$settings = new Settings();
		$States = new States();
		$country_id = session()->get("country_id")?session()->get("country_id"):'101';
		$States->where('country_id',$country_id);
		$data['extras']['states'] = $States->findAll();
		$data['extras']['hotlinks'] = $settings->findAll();
		$data['extras']['selectedState'] = session()->get("state_id");
   		$data['plans'] = $planArray;
		$data['categories'] = $catArray;
		$requestMain = \Config\Services::request();
    	$data['currentpage'] = $requestMain->uri->getSegment(2);   
   		$data['countries'] = $countries->findAll();

   		//captcha 
		$captcha = new Captcha();
		$captcha_code = $captcha->getCaptchaCode(6);
		$captcha->setSession('captcha_code', $captcha_code);
		$imageData = $captcha->createCaptchaImage($captcha_code);
		$data['rand'] = $captcha->renderCaptchaImage($imageData);
		echo view('postad',$data);
	}

	public function editlisting($listId){
		$data = array();
		$listing = new Listing();
		$listing->where('deleted',0);
		$result = $listing->where('id',$listId)->findAll(); 
		$cat1 = new Categories();
		$settings = new Settings();
		$States = new States();
		$country_id = session()->get("country_id")?session()->get("country_id"):'101';
		$States->where('country_id',$country_id);
		$data['extras']['states'] = $States->findAll();
		$data['extras']['hotlinks'] = $settings->findAll();
		$data['extras']['selectedState'] = session()->get("state_id");
	    $data['categories'] = $cat1->findAll();
		$data['listing'] = $result;
		return view('edit-listing',$data);
	}

	public function deletelisting($listId){
		$listing = new Listing();
		$listingData = [
			'id'=>$listId,
			'deleted' => 1
		];
		$listing->save($listingData);
		$session = session();
        $session->setFlashdata('success', 'Successfully deleted the listing');
		return redirect()->to(base_url('/dashboard'));
	}
	public function disablelisting($listId){
		$listing = new Listing();
		$listingData = [
			'id'=>$listId,
			'valid' => 0
		];
		$listing->save($listingData);
		$session = session();
        $session->setFlashdata('success', 'Successfully deleted the listing');
		return redirect()->to(base_url('/dashboard'));
	}
	public function enablelisting($listId){
		$listing = new Listing();
		$listingData = [
			'id'=>$listId,
			'valid' => 1
		];
		$listing->save($listingData);
		$session = session();
        $session->setFlashdata('success', 'Successfully deleted the listing');
		return redirect()->to(base_url('/dashboard'));
	}

	public function updatepassword($listId){
		$request = \Config\Services::request();
		$data = array();
		$model = new UserModel();
		$user = $model->where('id', $listId)->first();
		$data['user'] = $user;
		$cat1 = new Categories();
		$settings = new Settings();
		$States = new States();
		$country_id = session()->get("country_id")?session()->get("country_id"):'101';
		$States->where('country_id',$country_id);
		$data['extras']['states'] = $States->findAll();
		$data['extras']['hotlinks'] = $settings->findAll();
		$data['extras']['selectedState'] = session()->get("state_id");
		$data['categories'] = $cat1->findAll();
		$data['module'] = $request->uri->getSegment(1);
		$data['currentpage'] = $request->uri->getSegment(2);
		return view('update-password',$data);
	}

	public function changepassword(){
		$data = array();
		$request = \Config\Services::request();
		$session = session();
		//print_r($this->request->getVar());
		$id = $this->request->getVar('uid');
		$password = $this->request->getVar('password');
		$confirm_password = $this->request->getVar('confirm_password');
		$UserModel = new UserModel();
		if($password == $confirm_password){
			$userData = [
				'id'=>$id,
				'password' => $password
			];
			//print_r($userData);
			$UserModel->save($userData);
			$user = $UserModel->where('id', $id)->first();
			$data['user'] = $user;
			$cat1 = new Categories();
			$settings = new Settings();
			$States = new States();
			$country_id = session()->get("country_id")?session()->get("country_id"):'101';
			$States->where('country_id',$country_id);
			$data['extras']['states'] = $States->findAll();
			$data['extras']['hotlinks'] = $settings->findAll();
			$data['extras']['selectedState'] = session()->get("state_id");
			$data['categories'] = $cat1->findAll();
			$data['module'] = $request->uri->getSegment(1);
			$data['currentpage'] = $request->uri->getSegment(2);
			$session->setFlashdata('success', 'Password successfully Changed');
			return view('update-password',$data);
		}
	}
	
	public function editprofile($userid){
		$request = \Config\Services::request();
		$data = array();
		$model = new UserModel();
		$user = $model->where('id', $userid)->first();
		$data['user'] = $user;
		$cat1 = new Categories();
		$settings = new Settings();
		$States = new States();
		$country_id = session()->get("country_id")?session()->get("country_id"):'101';
		$States->where('country_id',$country_id);
		$data['extras']['states'] = $States->findAll();
		$data['extras']['hotlinks'] = $settings->findAll();
		$data['extras']['selectedState'] = session()->get("state_id");
	    $data['categories'] = $cat1->findAll();
		$data['module'] = $request->uri->getSegment(1);
		$data['currentpage'] = $request->uri->getSegment(2);
		return view('edit-profile',$data);
	}

	public function updateProfile(){
		$request = \Config\Services::request();
		$uid = $this->request->getVar('uid');
		$sfirstname = $this->request->getVar('sfirstname');
		$slastname = $this->request->getVar('slastname');
		$mobile = $this->request->getVar('mobile');
		$model = new UserModel();
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
		$data['user'] = $user;
		$cat1 = new Categories();
		$settings = new Settings();
		$States = new States();
		$country_id = session()->get("country_id")?session()->get("country_id"):'101';
		$States->where('country_id',$country_id);
		$data['extras']['states'] = $States->findAll();
		$data['extras']['hotlinks'] = $settings->findAll();
		$data['extras']['selectedState'] = session()->get("state_id");
	    $data['categories'] = $cat1->findAll();
		$data['module'] = $request->uri->getSegment(1);
		$data['currentpage'] = $request->uri->getSegment(2);
		//return view('edit-profile',$data);
		return redirect()->to('/users/editprofile/'.$uid);
	}

	public function logout(){
		$session = session();
		session()->destroy();
		$session = session();
		$session->setFlashdata('success', 'Successfully Logout');
		return redirect()->to('/');
	}

	public function fetchpostaddata(){
		$data = array(); 
		$request = \Config\Services::request();
		$catid = $this->request->getVar('id');
		$categories = new Categories();
		$attributes = new MainAttributes();
		$attributesmeta = new Attributes();
		$attributes->where('deleted',0);
		$attributes->where('parent_category_id',$catid);
		$categories->where('parent_id',$catid);
		$categories->where('deleted',0);
		$attributesarray = $attributes->findAll();
		foreach ($attributesarray as $key => $value) {
			$attributesmeta->where('deleted',0);
			$attributesmeta->where('parent_attribute_id',$value['id']);
			$attributesarray[$key]['option'] = $attributesmeta->findAll();
		}
		$settings = new Settings();
		$States = new States();
		$country_id = session()->get("country_id")?session()->get("country_id"):'101';
		$States->where('country_id',$country_id);
		$data['extras']['states'] = $States->findAll();
		$data['extras']['hotlinks'] = $settings->findAll();
		$data['extras']['selectedState'] = session()->get("state_id");
		$data['subCategory'] = $categories->findAll();
		$data['attributes'] = $attributesarray;
		echo json_encode($data);
	}

	public function getMessages(){
		$request = \Config\Services::request();
		$db = \Config\Database::connect();
		$chat = new Chat();
		$enquiry = new Enquiry();
		$id=$_REQUEST['con'];
		$chat->where('enquiry_id',$id);
		$chat->where('deleted',0);
		$user_id = session()->get('id');
		$res = $db->query("SELECT title FROM listing WHERE id IN (SELECT ad_id FROM enquiry WHERE id='".$id."');");
		$data['title'] = $res->getResult('array')[0];
		$data['chat'] = $chat->findAll();
		$data['enquiry_id'] = $id;
		$enquiryData = [
			'id' => $id,
			'read'=>1,
		];
		$enquiry->save($enquiryData);
		$html='';
		$html .= '<div class="card-title"><h5>'.$data['title']['title'].'</h5>
				<a href="'.base_url().'/users/deleteallchat/'.$id.'">Delete Chat</a>
		</div><div class="card-body msg_card_body">';
		foreach ($data['chat'] as $key1=> $value1) {
			$newDate = date("d-m-Y h:i:s A", strtotime($value1['created_date']));
			if($value1['sender_id']==$user_id){
				$html .='<div class="d-flex mb-4 justify-content-end">';
			}else{
				$html .='<div class="d-flex mb-4 justify-content-start">';
			}
			if($value1['sender_id']==$user_id){
				$html .='<div class="msg_cotainer_send">';
			}else{
				$html .='<div class="msg_cotainer">';
			}
			
			
			$html .='<span class="msgbox">'.$value1['message'].'</span>';
			$html .='<span class="msg_time">'.$newDate.'</span>';
			$html .='</div>';
			$html .='</div>';
		}
		$html .= '</div>
		<div class="tightingbox">
				<input type="hidden" id="sender_id" name="sender_id" value="'.$user_id.'">
				<input type="hidden" id="enquiry_id" name="enquiry_id" value="'.$id.'">
				<textarea id="w3review" name="message" rows="2" cols="39"></textarea>
				<button id="submitbtn" class="btn btn-secondary" type="button" name="submit">Send</button>
		</div>';
		print_r($html);
	}
	//--------------------------------------------------------------------

	function charlimit($string, $limit) {

        return substr($string, 0, $limit) . (strlen($string) > $limit ? "..." : '');
    }
}
