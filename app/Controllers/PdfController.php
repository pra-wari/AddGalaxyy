<?php 
namespace App\Controllers;
use CodeIgniter\Controller;
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
use App\Models\Transactions;
use App\Models\UsersPlanRelationship;
use App\Models\MainAttributes;
use CodeIgniter\Config\Config;
use CodeIgniter\I18n\Time;

class PdfController extends Controller
{

    public function index() 
	{
        return view('pdf_view');
    }

    function htmlToPDF($invoiceid){
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
        $data['image'] = $this->encode_img_base64('/home/glamouri/public_html/public/images/logo.png');
		$viewData = view('download-invoice',$data);
		$dompdf = new \Dompdf\Dompdf(); 
		$options = $dompdf->getOptions();
		$options->set('isRemoteEnabled', TRUE);
		$dompdf->setOptions($options);
		$contxt = stream_context_create([ 
			'ssl' => [ 
				'verify_peer' => FALSE, 
				'verify_peer_name' => FALSE,
				'allow_self_signed'=> TRUE
			] 
		]);
		$dompdf->setHttpContext($contxt);
		$dompdf->loadHtml($viewData);
		//$dompdf->setPaper('A4','portrait');
		$customPaper = array(0,0,800,800);
        $dompdf->set_paper($customPaper);
		$dompdf->render();

        $dompdf->stream();
    }
    function encode_img_base64( $img_path = false, $img_type = 'png' ){
    if( $img_path ){
        //convert image into Binary data
        $img_data = fopen ( $img_path, 'rb' );
        $img_size = filesize ( $img_path );
        $binary_image = fread ( $img_data, $img_size );
        fclose ( $img_data );

        //Build the src string to place inside your img tag
        $img_src = "data:image/".$img_type.";base64,".str_replace ("\n", "", base64_encode($binary_image));

        return $img_src;
    }

    return false;
}

}