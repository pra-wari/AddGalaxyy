<?php namespace App\Controllers;
use App\Models\Categories;
use App\Models\Listing;
use CodeIgniter\Config\Config;
use CodeIgniter\Controller;

class Subcategory extends Controller
{
	public function index()
	{
		return view('home');
	}

	public function view($viewId){
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
      
      	
      $cat = $cat->where('id',$viewId)->findAll();
		if($cat[0]['parent_id']!=0){
			$cat1 = $cat1->where('id',$cat[0]['parent_id'])->findAll();
		}else{
			$cat1 = array();
		}
      $premium = array();
      $featured = $listing->where('featured','1')->findAll();
      $result = $listing->where('category_id',$viewId)->findAll();
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
      //$data['message'] = $message;
      $data['premiumlisting'][0] = $premium[$randomkey];
      $data['listing'] = $result;
      $data['featured'] = $featured;
      $data['mainCategory'] = $cat;
      $requestMain = \Config\Services::request();
      $data['currentpage'] = $requestMain->uri->getSegment(2);
      $data['parentCategory'] = $cat1;
		echo view('sub-category',$data);
	 }


	//--------------------------------------------------------------------

}