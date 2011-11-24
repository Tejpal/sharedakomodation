<?php

class Ads extends Controller {
	
	var $per_page = 2;
	
	var $current_page = 1;
	
	var $city = '';
	var $state = '';
	var $country = '';
	
	var $location = '';
	var $surrAreas = '';
	var $community = '';	
	var $memberType = '';

	var $result = '';
	var $resultCount = 0;
	
	var $searchFlag = 0;
	var $searchFrom = 0;
	
	var $searchFields = array('location','surrAreas','community','memberType');	
	var $searchCommonFields = array('searchFrom','resultCount');	

	function Ads()
	{
		parent::Controller();	
	}
	
	function index()
	{
		//$this->load->view('welcome_message');
		
		$this->load->view('header');
		$this->load->view('welcome_message');
		$this->load->view('footer');		
		
	}
	
	// update
	function update($id=0)
	{	
		$this->create($id);
	}
	function update_finder($id=0)
	{	
		$this->createfinders($id);
	}
	function now()
	{
		echo  date('l jS \of F Y h:i:s A');
	}
	// create - ad
	function create($id=0)
	{	$this->session->unset_userdata('ads_id');
		$this->session->unset_userdata('editFlag');
	
		// check user is loggedin or not
		//if( empty($_SESSION['user_id']))
		if(!$this->session->userdata('user_id'))
		{
			// redirect to login page
			
			$this->session->set_flashdata('alert',"<p id='notify_alert_signin_to_postad' class='alert_notify'>You must be signed in to post your ad!</p>");
			//$_SESSION['request_page'] = '/ads/create/';
			$this->session->set_userdata('request_page', '/ads/create/');
			redirect('/user/signin', 'refresh');
		}	
		
		if(isset($_POST['postAdSubmit']))
			{
			
				
			//$this->session->set_flashdata('success', 'You have succesfully added your ad!');	
		$this->load->helper('url');
		redirect('/user/profile');	
			}
		
		$userData['editFlag'] = 0;
		
				
			$staticurl = $this->config->item('static_url');

			
		//if(isset($_SESSION['user_id']))
		if($this->session->userdata('user_id'))
		{
		//$uid=$_SESSION['user_id'];
		$uid=$this->session->userdata('user_id');
		}
		
		$this->load->model('user_model');
		$this->result1=$this->user_model->myinboxcount($uid);
		$data1['result1']=$this->result1;
		
		
		
		// update ad
		$this->load->model('ads_model');
				$ads_id = intval($id);
					if($ads_id>0)
						{
							$adsfullData	=	$this->ads_model->ads_detail($ads_id);			
							//print_r($adsfullData);
							if(is_array($adsfullData) && count($adsfullData)>0 && $this->session->userdata('user_id')==$adsfullData['user_id'])
							{
								$userData['editFlag'] = 1;
								$userData['adsfullData'] = $adsfullData;				
								$adsImages	=	$this->ads_model->ads_Images($ads_id);				
								$userData['adsImages'] = $adsImages;	
								$utl_bills	=	$this->ads_model->adsMetaData($ads_id,1);	
								$userData['utl_bills'] = $utl_bills;
								$furinished_list	=	$this->ads_model->adsMetaData($ads_id,2);
								$userData['furinished_list'] = $furinished_list;				
							}
							else
							{
								$this->session->set_flashdata('alert', 'You are not authorized to update this ads!');	
								redirect('/user/profile');							
							}						
						}
		
		
		
		
		
		$userData['tabon'] = 1; 
		
		$newData = array_merge($userData, $data1);
		
		$this->load->view('header1',$newData);
		$this->load->view('create_ad');
		$this->load->view('footer');
	} // end of function create 
	
	
	 function upload_file()
{

$this->load->library('qquploadedfilexhr');

// list of valid extensions, ex. array("jpeg", "xml", "bmp")
$image_allowed_types = $this->config->item('image_allowed_types');
$allowedExtensions = explode('|', $image_allowed_types);
// max file size in bytes
$image_max_size = $this->config->item('image_max_size');
$sizeLimit = $image_max_size;

$image_uploadpath = $this->config->item('image_uploadpath');

$uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
$result = $uploader->handleUpload(FCPATH.$image_uploadpath);

// to pass data through iframe you will need to encode all html tags
echo htmlspecialchars(json_encode($result), ENT_NOQUOTES);

}
	
	
	
	
	
	
	function finder_create($id=0)
	{	
	
		// check user is loggedin or not
		//if( empty($_SESSION['user_id']))
		if( !$this->session->userdata('user_id'))
		{
			// redirect to login page
			
			$this->session->set_flashdata('alert',"<p id='notify_alert_signin_to_postad' class='alert_notify'>You must be signed in to post your ad!</p>");
			//$_SESSION['request_page'] = '/ads/finder_create/';
			$this->session->set_userdata('request_page', '/ads/finder_create/');
			redirect('/user/signin', 'refresh');
		}
		
		
		
		//if(isset($_SESSION['user_id']))
		if($this->session->userdata('user_id'))
		{
		//$uid=$_SESSION['user_id'];
		$uid=$this->session->userdata('user_id');
		}
		
		$this->load->model('user_model');
		$this->result1=$this->user_model->myinboxcount($uid);
		$data1['result1']=$this->result1;
		
		
		$this->load->view('header1',$data1);
		$this->load->view('finder_create');
		$this->load->view('footer');
	}	

	function submitad1	($code='')
	{
	
	$adsData=array();
		$adsData['editFlag']=$editFlag=$_POST['editFlag'];
		if($editFlag==1)
					{
					$adsData['ads_id']=$ads_id=$_POST['ads_id'];
					
					}
			//
			 if($this->session->userdata('ads_id'))
			{
			$adsData['editFlag']=2;
			$adsData['ads_id']=$ads_id=$this->session->userdata('ads_id');
			} 
			//		
					
		if($code=='stepone')
			{
			$adsData['rent']=$rent=$_POST['rent'];
			$adsData['rentDuration']=$rentDuration=$_POST['rentDuration'];
			$adsData['bondSecurity']=$bondSecurity=$_POST['bondSecurity'];
			$adsData['propertyType']=$propertyType=$_POST['propertyType'];
			$adsData['bedrooms']=$bedrooms=$_POST['bedrooms'];
			$adsData['parking']=$parking=$_POST['parking'];
			$adsData['availability']=$availability=$_POST['availability'];
			$adsData['minStay']=$minStay=$_POST['minStay'];
			$adsData['maxStay']=$maxStay=$_POST['maxStay'];
			$adsData['streetAddress']=$streetAddress=$_POST['streetAddress'];
			$adsData['postCode']=$postCode=$_POST['postCode'];
			$adsData['suburb']=trim($suburb=$_POST['suburb']);
			$adsData['state']=trim($state=$_POST['state']);
			$adsData['date']=date('Y-m-d H:i:s');
			$adsData['expiry_date']=date("Y-m-d H:i:s", strtotime("+30 days"));
			if(isset($_POST['utilBills']))
				{
				$adsData['utilBills']=$utilBills=$_POST['utilBills'];
				}
			if(isset($_POST['furnish']))
				{
				$adsData['furnish']=$furnish=$_POST['furnish'];
				}
			if(isset($_POST['utilBillsList']))
				{
				$adsData['utilBillsList']=$utilBillsList=$_POST['utilBillsList'];
				}
			if(isset($_POST['furnishList']))
				{
				$adsData['furnishList']=$furnishList=$_POST['furnishList'];
				}
			}
		
		
		if($code=='steptwo')
			{
			$adsData['firstName']=$firstName=$_POST['firstName'];
			$adsData['lastName']=$lastName=$_POST['lastName'];
			$adsData['phoneNo']=$phoneNo=$_POST['phoneNo'];
			if(isset($_POST['phoneVisible']))
				{
				$adsData['phoneVisible']=$phoneVisible=$_POST['phoneVisible'];
				}
			else
				{
				$adsData['phoneVisible']=$phoneVisible=0;
				}	
			$adsData['emailId']=$emailId=$_POST['emailId'];
			if(isset($_POST['emailVisible']))
				{
				$adsData['emailVisible']=$emailVisible=$_POST['emailVisible'];
				}
			else
				{
				$adsData['emailVisible']=$emailVisible=0;
				}
			}
		
		if($code=='stepthree')
			{
			$adsData['gender']=$gender=$_POST['gender'];
			$adsData['smoker']=$smoker=$_POST['smoker'];
			$adsData['age']=$age=$_POST['age'];
			$adsData['orientation']=$orientation=$_POST['orientation'];
			$adsData['diet']=$diet=$_POST['diet'];
			$adsData['occupation']=$occupation=$_POST['occupation'];
			if(isset($_POST['communities']))
				{
				$adsData['communities']=$communities=$_POST['communities'];
				}
			else
				{
				$adsData['communities']=$communities=Array(0);
				}
			
			}
			
			if($code=='stepfour')
			{
			$adsData['title']=$Title=$_POST['adTitle'];
			$adsData['propFeature1']=$propFeature1=$_POST['propFeature1'];
			$adsData['propFeature2']=$propFeature2=$_POST['propFeature2'];
			$adsData['adDescription']=$adDescription=$_POST['adDescription'];
			}
			
			
		//print_r($_POST);exit;
		$this->load->model('ads_model');
		$adidf=$this->ads_model->submit_ad_finder($adsData,$code);
	
	}
	function submitad($code='')
	{
	
		$adsData=array();
		$adsData['editFlag']=$editFlag=$_POST['editFlag'];
		if($editFlag==1)
					{
					$adsData['ads_id']=$ads_id=$_POST['ads_id'];
					
					}
			//
			 if($this->session->userdata('ads_id'))
			{
			$adsData['editFlag']=2;
			$adsData['ads_id']=$ads_id=$this->session->userdata('ads_id');
			} 
			//		
					
		if($code=='stepone')
			{
			$adsData['rent']=$rent=$_POST['rent'];
			$adsData['rentDuration']=$rentDuration=$_POST['rentDuration'];
			$adsData['bondSecurity']=$bondSecurity=$_POST['bondSecurity'];
			$adsData['propertyType']=$propertyType=$_POST['propertyType'];
			$adsData['bedrooms']=$bedrooms=$_POST['bedrooms'];
			$adsData['parking']=$parking=$_POST['parking'];
			$adsData['availability']=$availability=$_POST['availability'];
			$adsData['minStay']=$minStay=$_POST['minStay'];
			$adsData['maxStay']=$maxStay=$_POST['maxStay'];
			$adsData['streetAddress']=$streetAddress=$_POST['streetAddress'];
			$adsData['postCode']=$postCode=$_POST['postCode'];
			$adsData['suburb']=trim($suburb=$_POST['suburb']);
			$adsData['state']=trim($state=$_POST['state']);
			$adsData['date']=date('Y-m-d H:i:s');
			$adsData['expiry_date']=date("Y-m-d H:i:s", strtotime("+30 days"));
			if(isset($_POST['utilBills']))
				{
				$adsData['utilBills']=$utilBills=$_POST['utilBills'];
				}
			if(isset($_POST['furnish']))
				{
				$adsData['furnish']=$furnish=$_POST['furnish'];
				}
			if(isset($_POST['utilBillsList']))
				{
				$adsData['utilBillsList']=$utilBillsList=$_POST['utilBillsList'];
				}
			if(isset($_POST['furnishList']))
				{
				$adsData['furnishList']=$furnishList=$_POST['furnishList'];
				}
			}
		
		
		if($code=='steptwo')
			{
			$adsData['firstName']=$firstName=$_POST['firstName'];
			$adsData['lastName']=$lastName=$_POST['lastName'];
			$adsData['phoneNo']=$phoneNo=$_POST['phoneNo'];
			if(isset($_POST['phoneVisible']))
				{
				$adsData['phoneVisible']=$phoneVisible=$_POST['phoneVisible'];
				}
			else
				{
				$adsData['phoneVisible']=$phoneVisible=0;
				}	
			$adsData['emailId']=$emailId=$_POST['emailId'];
			if(isset($_POST['emailVisible']))
				{
				$adsData['emailVisible']=$emailVisible=$_POST['emailVisible'];
				}
			else
				{
				$adsData['emailVisible']=$emailVisible=0;
				}
			}
		
		if($code=='stepthree')
			{
			$adsData['gender']=$gender=$_POST['gender'];
			$adsData['smoker']=$smoker=$_POST['smoker'];
			$adsData['age']=$age=$_POST['age'];
			$adsData['orientation']=$orientation=$_POST['orientation'];
			$adsData['diet']=$diet=$_POST['diet'];
			$adsData['occupation']=$occupation=$_POST['occupation'];
			if(isset($_POST['communities']))
				{
				$adsData['communities']=$communities=$_POST['communities'];
				}
			else
				{
				$adsData['communities']=$communities=Array(0);
				}
			
			}
			
			if($code=='stepfour')
			{
			$adsData['title']=$Title=$_POST['adTitle'];
			$adsData['propFeature1']=$propFeature1=$_POST['propFeature1'];
			$adsData['propFeature2']=$propFeature2=$_POST['propFeature2'];
			$adsData['adDescription']=$adDescription=$_POST['adDescription'];
			}
			
			
		//print_r($_POST);exit;
		$this->load->model('ads_model');
		$adidf=$this->ads_model->submit_ad($adsData,$code);
		
	}
	
	function finder_submitad($code='')
	{
	
	}
	
	
	function adinformation($id='')
	{
	
		$this->load->model('ads_model');
		
		$ad_info['adinfo']=$this->ads_model->ad_information($id);
		$ad_info['adsImages']=$this->ads_model->ads_Images($id);
		//print_r($ad_info);
		$this->load->view('createad/ad_information',$ad_info);
		
	}
	
	function uploadimges($id='')
	{
	if($id<1)
		{
		$id=$this->session->userdata('ads_id');
		}
		$this->load->model('ads_model');
		
		$ad_info['adinfo']=$this->ads_model->ad_information($id);
		$ad_info['adsImages']=$this->ads_model->ads_Images($id);
		$this->load->view('createad/image_upload_content',$ad_info);
		
	}
	
	function propertydetails($id='')
	{
	if($id<1){$id=$this->session->userdata('ads_id');}
	
		$this->load->model('ads_model');
		
		$ad_info['adinfo']=$this->ads_model->ad_information($id);
		
		$utl_bills	=	$this->ads_model->adsMetaData($id,1);	
		$ad_info['utl_bills'] = $utl_bills;
		
		$furinished_list	=	$this->ads_model->adsMetaData($id,2);
		$ad_info['furinished_list'] = $furinished_list;
		
		//print_r($ad_info);
		$this->load->view('createad/property_details',$ad_info);
		
	}
	
	function providerdetails($id='')
	{	
		if($id<1)
		{
		$id=$this->session->userdata('ads_id');
		}
	
		//if(isset($_SESSION['email']))
		if($this->session->userdata('email'))
		{
		//$ad_info['auto_email']=$_SESSION['email'];
		$ad_info['auto_email']=$this->session->userdata('email');
		$ad_info['firstname']=$this->session->userdata('firstname');
		$ad_info['lastname']=$this->session->userdata('lastname');
		}
	
		$this->load->model('ads_model');
		$ad_info['adinfo']=$this->ads_model->ad_information($id);
		
		
		$this->load->view('createad/provider_details',$ad_info);
		
	}
	
	function providerpref($id='')
	{if($id<1){$id=$this->session->userdata('ads_id');}
	
		$this->load->model('ads_model');
		
		$ad_info['adinfo']=$this->ads_model->ad_information($id);
		if(!empty($ad_info['adinfo'][0]['community']))
		{
		$com=$ad_info['adinfo'][0]['community'];
	/*	}
		if($com)
		{
	*/	$ad_info['communities']=$this->ads_model->community_name($com);
		//print_r($ad_info['communities']);
		
		$count=count($ad_info['communities']);
		
			for($i=0;$i<=$count-1;$i++)
				{
				$ad_info['communities'][$i]=$ad_info['communities'][$i]['community'];
				}
		
		}
		else
		{
		$ad_info['communities'][0]='no communities';
		}
			//print_r($ad_info['communities']);
		$this->load->view('createad/provider_pref',$ad_info);
		
	}
	
	function propertyprefs($id='')
	{
	
	if($id<1){$id=$this->session->userdata('ads_id');}
	
		$this->load->model('ads_model');
		
		$ad_info['adinfo']=$this->ads_model->ad_information($id);
		
		$utl_bills	=	$this->ads_model->adsMetaData($id,1);	
		$ad_info['utl_bills'] = $utl_bills;
		
		$furinished_list	=	$this->ads_model->adsMetaData($id,2);
		$ad_info['furinished_list'] = $furinished_list;
		
		//print_r($ad_info);
		
	
	
	$this->load->view('createad/property_prefs',$ad_info);
	
	}
	
	function finderdetails($id='')
	{
	if($id<1)
		{
		$id=$this->session->userdata('ads_id');
		}
	
		//if(isset($_SESSION['email']))
		if($this->session->userdata('email'))
		{
		//$ad_info['auto_email']=$_SESSION['email'];
		$ad_info['auto_email']=$this->session->userdata('email');
		$ad_info['firstname']=$this->session->userdata('firstname');
		$ad_info['lastname']=$this->session->userdata('lastname');
		}
	
		$this->load->model('ads_model');
		$ad_info['adinfo']=$this->ads_model->ad_information($id);
		
		
	$this->load->view('createad/finder_details',$ad_info);
	
	}
	
	function finderpref($id='')
	{
	
	if($id<1){$id=$this->session->userdata('ads_id');}
	
		$this->load->model('ads_model');
		
		$ad_info['adinfo']=$this->ads_model->ad_information($id);
		if(!empty($ad_info['adinfo'][0]['community']))
		{
		$com=$ad_info['adinfo'][0]['community'];
	/*	}
		if($com)
		{
	*/	$ad_info['communities']=$this->ads_model->community_name($com);
		//print_r($ad_info['communities']);
		
		$count=count($ad_info['communities']);
		
			for($i=0;$i<=$count-1;$i++)
				{
				$ad_info['communities'][$i]=$ad_info['communities'][$i]['community'];
				}
		
		}
		else
		{
		$ad_info['communities'][0]='no communities';
		}
			//print_r($ad_info['communities']);
		
	
	
	$this->load->view('createad/finder_pref',$ad_info);
	
	}
	
	function adinfofinder($id='')
	{
	
	$this->load->model('ads_model');
		
		$ad_info['adinfo']=$this->ads_model->ad_information($id);
		$ad_info['adsImages']=$this->ads_model->ads_Images($id);
		//print_r($ad_info);
		
	
	$this->load->view('createad/ad_info_finder',$ad_info);
	
	}
	
	
	
	// check varification code
	function captcha_verification($captchastr)
	{
		$captchaCode = (empty($_SESSION['captchaCode']))?'&@$':$_SESSION['captchaCode'];
		if($captchastr == '' || $captchastr!=$captchaCode){
			$this->form_validation->set_message('captcha_verification', 'You must click submit button to create your ad.');
			return FALSE;
		} else {
			return TRUE;		
		}		
	} // end of captcha_verification	
	
	// city
	function city($city='',$page=1,$total=0)
	{
		$this->city = $city;
		$this->current_page = $page;
		$this->resultCount = $total;
		
		$this->result();
		$this->display();		
	}

	// state
	function state($state='',$page=1,$total=0)
	{
		$this->state = $state;
		$this->current_page = $page;
		$this->resultCount = $total;
		
		$this->result();
		$this->display();		
	}

	// country
	function country($country='',$page=1,$total=0)
	{
		$this->country = $country;
		$this->current_page = $page;
		$this->resultCount = $total;
		
		$this->result();
		$this->display();		
	}		
	
	// search result
	function search($offset=0)
	{
	if(!empty($_REQUEST['per_page'])){$offset=$_REQUEST['per_page'];}		//echo $offset1;
		
	$this->searchFlag = 1;		
	$searchFrom=$this->searchFrom = (!empty($_REQUEST['searchFrom']))?$_REQUEST['searchFrom']:'';
	
	
	
	$location=$this->location = (!empty($_REQUEST['location']))?$_REQUEST['location']:'';
	$location=trim($location);
	$surrAreas=	$this->surrAreas = (!empty($_REQUEST['surrAreas']))?$_REQUEST['surrAreas']:'';
	$community=$this->community = (!empty($_GET['community']))?$_GET['community']:'';
	$communities=$this->communities=(!empty($_GET['communities']))?$_GET['communities']:'';
	//echo $community.'<br>';
	//print_r($communities);
		
		
	
	
	if(!empty($communities)){
	//$comma_separated_communities = implode(",", $communities);
	//$this->load->model('ads_model');
	//$community_array=$this->community_array=$this->ads_model->get_community($comma_separated_communities);
	$community_array=$this->community_array=$communities;
	}
	//print_r($this->community_array);echo '<br>';
	//print_r($community_array);echo '<br>';
		$memberType=$this->memberType =$_REQUEST['memberType'];	
		$this->current_page = (!empty($_REQUEST['page']))?$_REQUEST['page']:1;		
		$this->resultCount = (!empty($_REQUEST['total']))?$_REQUEST['total']:0;		
		
		$this->offset=$offset;
	
// Recent search cookie	
	
	
	
	$base_url = $this->config->item('base_url');
	
	$search_url=$base_url.'index.php/ads/search?location='.$location.'&community='.$community.'&memberType='.$memberType.'&searchFrom='.$searchFrom;
	
	
	$arr=array();
	$arr[0]=$location;
	$arr[1]=htmlentities($search_url);
	
	if(isset($_COOKIE['cookie_search']))
		{
			$cookie_search_count=count($_COOKIE['cookie_search']);
			if($cookie_search_count>=4)
			{
				for($i=0;$i<=2;$i++)
					{
						$location1=$_COOKIE['cookie_search'][$i+1][0];
						$search_url1=$_COOKIE['cookie_search'][$i+1][1];
						if(!(in_array($arr,$_COOKIE['cookie_search']))){
						setcookie("cookie_search[$i][0]",$location1);
						setcookie("cookie_search[$i][1]",$search_url1);
						}
					}
				$cookie_search_count=3;
			}
		// cookie for diff url with  the "location"
			if(!(in_array($arr,$_COOKIE['cookie_search'])))
			{
			setcookie("cookie_search[$cookie_search_count][0]",$location);
			setcookie("cookie_search[$cookie_search_count][1]",htmlentities($search_url));
			}
		}
	else
		{
			$cookie_search_count=0;
			setcookie("cookie_search[$cookie_search_count][0]",$location);
			setcookie("cookie_search[$cookie_search_count][1]",htmlentities($search_url));
		}
			

// Recent search cookie end
		
		$this->result();
		$this->display();		
	}		

	
	// result
	function result()
	{//print_r($this->community_array);echo 'hhhhhhhh'.'<br>';
		$this->load->library('pagination');
		
		$result_per_page =10;
		$this->load->model('ads_model');	
		
		$offset=$this->offset;
		
		$filters = array();
		
		$filters['city'] = $this->city;
		$filters['state'] = $this->state;
		$filters['country'] = $this->country;		
		
		$filters['searchFlag'] = $this->searchFlag;
		$filters['searchFrom'] = $this->searchFrom;
		
	$location=$filters['location'] = $this->location;
	$surrAreas=$filters['surrAreas'] = $this->surrAreas;
	$community=$filters['community'] = $this->community;	
	
	
	
	
	if(!empty($_COOKIE['community']))
		{
		$community_cookie_count=count($_COOKIE['community']);
		
			for($x=0;$x<=$community_cookie_count-1;$x++)
				{
		
				setcookie("community[$x]","",time()-3600,"/");
				
				}
		
		}
	
	
	if(!empty($this->community_array))
	{
	
	$community_array1=$community_array=$this->community_array;
	//print_r($community_array1);
	//
	$com= implode(",", $community_array1);
		$comm1['communities']=$this->ads_model->community_name($com);
		//echo '<pre>';print_r($data['communities']);echo '</pre>';
		//
		$count=count($comm1['communities']);
		//echo $count;
			for($i=0;$i<=$count-1;$i++)
				{
				$comm1['communities'][$i]=$comm1['communities'][$i]['community'];
				}
	//print_r($comm1['communities']);
	//
		$community_array_count=count($community_array);
			

	$community_array=$filters['community_array'] = $community_array;	
	
	
	
		
	$community_array_count=count($community_array1);
	for($y=0;$y<=$community_array_count-1;$y++)
		{
		setcookie("community[$y]",$comm1['communities'][$y],time()+3600,"/");
		
		}
	}
		
		$memberType=$filters['memberType'] = $this->memberType;	

		
		
		$filters['per_page'] =$result_per_page; 
		$filters['offset'] =$offset; 
		
		if($filters['surrAreas']==1)
		{
		$geocode=$this->ads_model->get_geocode($filters);
		if($geocode)
			{
				$city_from_geocode=$this->ads_model->get_city_from_geocode($geocode);
		
				for($i=0;$i<count($city_from_geocode);$i++)
					{
					$city2222[$i]='"'.$city_from_geocode[$i]['City'].'"';
					}
			
				$comma_separated_city = implode(",",$city2222);
		
				$count_result= $this->ads_model->cityCount($comma_separated_city,$filters);
				$this->total_rows=$count_result['rcount'];
				$this->all_ads_id=$count_result['all_ads_id'];
				$total_rows=$this->total_rows;
		
				if(!empty($total_rows))
				{
				$baseurl = site_url() . '/';
				$config['base_url'] = $baseurl.'ads/search?location='.$location.'&community='.$community.'&memberType='.$memberType.'&surrAreas='.$surrAreas;
				$config['per_page'] = $result_per_page;
				$config['total_rows']=$total_rows;
				$config['num_links'] = 2;
				$config['prev_link'] = 'Prev';
				$config['next_link'] = 'Next';
				$config['first_link'] = False;
				$config['last_link'] = False;
		
				$this->pagination->initialize($config);
				}
		
			$this->result = $this->ads_model->city($comma_separated_city,$filters,$offset,$result_per_page);
		//print_r($this->result);
			}
		}
		

else	{	

$rr= $this->ads_model->filter_adsCount($filters);
$this->all_ads_id=$rr['all_ads_id'];
$total_rows=$rr['rcount'];
		
		$this->total_rows=$total_rows;
		// now find current page records data
		if(!empty($total_rows)){
		$baseurl = site_url() . '/';
		$config['base_url'] = $baseurl.'ads/search?location='.$location.'&community='.$community.'&memberType='.$memberType;
		$config['per_page'] = $result_per_page;
		$config['total_rows']=$total_rows;
		$config['num_links'] = 2;
		$config['prev_link'] = 'Prev';
		$config['next_link'] = 'Next';
		$config['first_link'] = False;
		$config['last_link'] = False;
		//$config['uri_segment'] =3; 
		
		$this->pagination->initialize($config);
		}
		
		$this->result = $this->ads_model->filter_ads($filters);
		
		}

		
	}
	
	
	
	// display
	function display()
	{
		//$this->output->enable_profiler(TRUE);
		
		$this->assetlibpro->add_css('css/shortlistedAds.css');
		$this->assetlibpro->add_css('css/listing.css');
		$this->assetlibpro->add_css('css/pagination.css');	
		
		$data = array();
		
		$data['all_ads_id'] = $this->all_ads_id;
		$data['city'] = $this->city;
		$data['state'] = $this->state;
		$data['country'] = $this->country;		

		$data['result'] = $this->result;
		if(isset($data['result']['city']))
		{
		$data['city'] =$data['result']['city'];
		unset($data['result']['city']); 
		}
		
		$data['resultCount'] = $this->resultCount;
		if(isset($this->total_rows))
		{
		$data['total_rows'] = $this->total_rows;
		}else{ $data['total_rows']=0; }
		$data['per_page'] = $this->per_page;
		$data['current_page'] = $this->current_page;
		
		$data['location'] = $this->location;
		$data['surrAreas'] = $this->surrAreas;
		$data['community'] = $this->community;		
		
		if(!empty($this->community_array))
		{
		$community_array=$this->community_array;
		$community_array_count=count($community_array);
			for($i=0;$i<=$community_array_count-1;$i++)
			{
				//$community_array[$i]=$community_array[$i]['community'];
			}
		$data['community_array'] = $community_array;
		$com= implode(",", $data['community_array']);
		$data['communities']=$this->ads_model->community_name($com);
		//echo '<pre>';print_r($data['communities']);echo '</pre>';
		//
		$count=count($data['communities']);
		//echo $count;
			for($i=0;$i<=$count-1;$i++)
				{
				$data['communities'][$i]=$data['communities'][$i]['community'];
				}
		//print_r($data['communities']);
		//
		//echo 'controller ';print_r($community_array);
		}
		$data['memberType'] = $this->memberType;	
		
		$data['searchFlag'] = $this->searchFlag;
		$data['searchFrom'] = $this->searchFrom;
		
		$data['searchFields'] = $this->searchFields;
		$data['searchCommonFields'] = $this->searchCommonFields;
		
		
		
		//if(isset($_SESSION['user_id']))
		if($this->session->userdata('user_id'))
		{
		//$uid=$_SESSION['user_id'];
		$uid=$this->session->userdata('user_id');
		
		$this->load->model('user_model');
		$this->result1=$this->user_model->myinboxcount($uid);
		$data1['result1']=$this->result1;
		$newData = array_merge($data,$data1);
		
		$this->load->view('header',$newData);
		}
		else
		{$this->load->view('header',$data);}
		
		
		$this->load->view('result_display',$data);
		$this->load->view('footer');		
		
	}	
	
	
	//advance search
	function advsearch()
	{
	
	//if(isset($_SESSION['user_id']))
	if($this->session->userdata('user_id'))
		{
			//$uid=$_SESSION['user_id'];
			$uid=$this->session->userdata('user_id');
			$this->load->model('user_model');
			$advresult['result1']=$this->user_model->myinboxcount($uid);
			$advresult['tabon'] = 2;
			$this->load->view('header',$advresult);
			$this->load->view('adv');
			$this->load->view('footer');
		}	
	else
		{$advresult['tabon'] = 2;
			$this->load->view('header',$advresult);
			$this->load->view('adv');
			$this->load->view('footer');
		}
	}
	
	function advsearch1($offset=0)
	{
	
		if(!empty($_REQUEST['per_page'])){$offset=$_REQUEST['per_page'];}
	
		$this->assetlibpro->add_css('css/listing.css');			
		$this->load->helper('form');
		$community = $this->input->post('community');
		$advData['community'] = $community;
		
		$propertytype = $this->input->post('propertytype');
		$advData['propertytype'] = $propertytype;
	
		$bedrooms = $this->input->post('bedrooms');
		$advData['bedrooms'] = $bedrooms;

		$bathrooms = $this->input->post('bathrooms');
		$advData['bathrooms'] = $bathrooms;
		
		$Parking = $this->input->post('parking');
		$advData['parking'] = $Parking;
		
	$this->load->model('ads_model');
	$this->load->model('user_model');
	
	
	$total_rows=$advresult['total_rows']=$this->totalrows=$this->ads_model->adv_search_count($advData);
	
	
		$this->load->library('pagination');
		
		$result_per_page = 10;

	if(!empty($total_rows)){
		$baseurl = site_url() . '/';
		$config['base_url'] = $baseurl.'ads/advsearch1/?';
		$config['per_page'] = $result_per_page;
		$config['total_rows']=$total_rows;
		$config['num_links'] = 2;
		$config['prev_link'] = 'Prev';
		$config['next_link'] = 'Next';
		$config['first_link'] = False;
		$config['last_link'] = False;
		
		$this->pagination->initialize($config);
		}
	
	
	$advresult['result']=$this->advresult=$this->ads_model->adv_search($advData,$offset,$result_per_page);
	
	//if($_SESSION['user_id'])
	if($this->session->userdata('user_id'))
		{
			//$uid=$_SESSION['user_id'];
			$uid=$this->session->userdata('user_id');
			$advresult['result1']=$this->user_model->myinboxcount($uid);
		}
	
	
	//print_r($advresult);exit;
	$this->load->view('header',$advresult);
	$this->load->view('result_adv_display');
	$this->load->view('footer');
	}
	
	//Refine search
	
	//community
	 function refine_comm($offset=0)
	{
	
	$data=$_GET;
	$results=array();
	$results['location']=$data['location'];
	
	
	if(empty($data['ads_id']))
		{
		$results['total_rows']=0;
		$this->load->view('header',$results);
		$this->load->view('result_display');
		$this->load->view('footer');
		}
	else
		{
		$this->load->library('pagination');
		$result_per_page =10;
		
		if(!isset($data['options']))
			{
			$data['options']=array('0');
			}
		else
			{
			$results['comm']=$data['options'];
			}
		
		$this->load->model('ads_model');
		$count_result=$this->ads_model->r_comm_count($data);
		$result_count=$count_result['rcount'];
		if(!empty($_REQUEST['per_page'])){$offset=$_REQUEST['per_page'];}
	//pagination
	if(!empty($result_count))
				{
				$s='';
foreach($data['options'] as $a=>$b)
{
$s .='options[]='.$b.'&';
}
				
				$baseurl = site_url() . '/';
				$config['base_url'] = $baseurl.'ads/refine_comm?'.$s.'ads_id='.$data['ads_id'].'&location='.$data['location'];
				$config['per_page'] = $result_per_page;
				$config['total_rows']=$result_count;
				$config['num_links'] = 2;
				$config['prev_link'] = 'Prev';
				$config['next_link'] = 'Next';
				$config['first_link'] = False;
				$config['last_link'] = False;
		
				$this->pagination->initialize($config);
				}
	
	//pagination end
		
		
		$results['result']=$this->ads_model->r_comm($data,$offset,$result_per_page);
		$results['total_rows']=$result_count;
		$results['all_ads_id']=$count_result['all_ads_id'];
		
	
		$this->load->view('header',$results);
		$this->load->view('result_display');
		$this->load->view('footer');
		}
	} 
	
	//price range
	function refine_price($offset=0)
	{
	//print_r($_GET);exit;
	$data=$_GET;
	
	//print_r($data);
	$results=array();
	$results['min_type']=array($data['min_pricerange']);
	$results['max_type']=array($data['max_pricerange']);
	$results['rent_type']=array($data['rentType']);
	$results['location']=$data['location'];
	
	if(empty($data['ads_id']))
	{
	$results['total_rows']=0;
	$this->load->view('header',$results);
	$this->load->view('result_display');
	$this->load->view('footer');
	}
	else
	{
	$this->load->library('pagination');
	$result_per_page =10;
	
	$this->load->model('ads_model');
	$count_result=$this->ads_model->r_price_count($data);
	$result_count=$count_result['rcount'];
	
	if(!empty($_REQUEST['per_page'])){$offset=$_REQUEST['per_page'];}
	//pagination
	if(!empty($result_count))
				{
				$baseurl = site_url() . '/';
				$config['base_url'] = $baseurl.'ads/refine_price?min_pricerange='.$data['min_pricerange'].'&max_pricerange='.$data['max_pricerange'].'&rentType='.$data['rentType'].'ads_id='.$data['ads_id'].'&location='.$data['location'];
				$config['per_page'] = $result_per_page;
				$config['total_rows']=$result_count;
				$config['num_links'] = 2;
				$config['prev_link'] = 'Prev';
				$config['next_link'] = 'Next';
				$config['first_link'] = False;
				$config['last_link'] = False;
		
				$this->pagination->initialize($config);
				}
	
	//pagination end
	
	
	//print_r($result_count);
	$results['result']=$this->ads_model->r_price($data,$offset,$result_per_page);
	$results['total_rows']=$result_count;
	$results['all_ads_id']=$count_result['all_ads_id'];
	//print_r($results);
	
	$this->load->view('header',$results);
	$this->load->view('result_display');
	$this->load->view('footer');
	}
	} 
	
	//property type
	 function refine_property_type($offset=0)
	{
	//print_r($_GET);exit;
	$data=$_GET;
	
	$results=array();
	$results['location']=$data['location'];
	//print_r($_GET);
	
	//print_r($data);
	if(empty($data['ads_id']))
	{
	$results['total_rows']=0;
	$this->load->view('header',$results);
	$this->load->view('result_display');
	$this->load->view('footer');
	}
	
	else
	{
	$this->load->library('pagination');
	$result_per_page =10;
	//
	if(!isset($data['options']))
	{
	$data['options']=array('0');
	$results['p_type']=array('0');
	}
	else
	{
	$results['p_type']=$data['options'];
	}
	$this->load->model('ads_model');
	$count_result=$this->ads_model->r_p_type_count($data);
	$result_count=$count_result['rcount'];
		if(!empty($_REQUEST['per_page'])){$offset=$_REQUEST['per_page'];}
	//pagination
	if(!empty($result_count))
				{
				$s='';
foreach($results['p_type'] as $a=>$b)
{
$s .='options[]='.$b.'&';
}
				
				$baseurl = site_url() . '/';
				$config['base_url'] = $baseurl.'ads/refine_property_type?'.$s.'ads_id='.$data['ads_id'].'&location='.$data['location'];
				$config['per_page'] = $result_per_page;
				$config['total_rows']=$result_count;
				$config['num_links'] = 2;
				$config['prev_link'] = 'Prev';
				$config['next_link'] = 'Next';
				$config['first_link'] = False;
				$config['last_link'] = False;
		
				$this->pagination->initialize($config);
				}
	
	//pagination end
	
	
	$results['result']=$this->ads_model->r_p_type($data,$offset,$result_per_page);
	$results['total_rows']=$result_count;
	$results['all_ads_id']=$count_result['all_ads_id'];
	//echo '<pre>';print_r($result);echo '</pre>';exit;
	$this->load->view('header',$results);
	$this->load->view('result_display');
	$this->load->view('footer');
	//
	
	}
	} 
	
	//bedromms
	function refine_bedrooms($offset=0)
	{
	//print_r($_GET);
	$data=$_GET;
	
	$results=array();
	$results['bedroom_type']=$data['options'];
	$results['location']=$data['location'];
	if(empty($data['ads_id']))
	{
	$results['total_rows']=0;
	$this->load->view('header',$results);
	$this->load->view('result_display');
	$this->load->view('footer');
	}
	else
	{
	$this->load->library('pagination');
	$result_per_page =10;
	
	$this->load->model('ads_model');
	$count_result=$this->ads_model->r_bedroom_count($data);
	$result_count=$count_result['rcount'];
		if(!empty($_REQUEST['per_page'])){$offset=$_REQUEST['per_page'];}
	//pagination
	if(!empty($result_count))
				{
				$s='';
foreach($results['bedroom_type'] as $a=>$b)
{
$s .='options[]='.$b.'&';
}
				
				$baseurl = site_url() . '/';
				$config['base_url'] = $baseurl.'ads/refine_bedrooms?'.$s.'ads_id='.$data['ads_id'].'&location='.$data['location'];
				$config['per_page'] = $result_per_page;
				$config['total_rows']=$result_count;
				$config['num_links'] = 2;
				$config['prev_link'] = 'Prev';
				$config['next_link'] = 'Next';
				$config['first_link'] = False;
				$config['last_link'] = False;
		
				$this->pagination->initialize($config);
				}
	
	//pagination end
	
	
	$results['result']=$this->ads_model->r_bedroom($data,$offset,$result_per_page);
	$results['total_rows']=$result_count;
	$results['all_ads_id']=$count_result['all_ads_id'];		
	
	$this->load->view('header',$results);
	$this->load->view('result_display');
	$this->load->view('footer');
	} 
	}
	
	//parking
	function refine_parking($offset=0)
	{
	//print_r($_GET);
	$data=$_GET;
	
	$results=array();
	$results['location']=$data['location'];
	
	if(empty($data['ads_id']))
	{
		$results['total_rows']=0;
		$this->load->view('header',$results);
		$this->load->view('result_display');
		$this->load->view('footer');
	}
	else
	{
	
	$this->load->library('pagination');
	$result_per_page =10;

		if(!isset($data['options']))
		{
			$data['options']=array('0');
			$results['parking_type']=array('0');
		}
		else
		{
		$results['parking_type']=$data['options'];
		}
		
			$this->load->model('ads_model');
			$count_result=$this->ads_model->r_parking_count($data);
			$result_count=$count_result['rcount'];
			if(!empty($_REQUEST['per_page'])){$offset=$_REQUEST['per_page'];}
	//pagination
	if(!empty($result_count))
				{
				$s='';
foreach($results['parking_type'] as $a=>$b)
{
$s .='options[]='.$b.'&';
}
				
				$baseurl = site_url() . '/';
				$config['base_url'] = $baseurl.'ads/refine_parking?'.$s.'ads_id='.$data['ads_id'].'&location='.$data['location'];
				$config['per_page'] = $result_per_page;
				$config['total_rows']=$result_count;
				$config['num_links'] = 2;
				$config['prev_link'] = 'Prev';
				$config['next_link'] = 'Next';
				$config['first_link'] = False;
				$config['last_link'] = False;
		
				$this->pagination->initialize($config);
				}
	
	//pagination end		
			
			
			$results['result']=$this->ads_model->r_parking($data,$offset,$result_per_page);
			$results['total_rows']=$result_count;
			$results['all_ads_id']=$count_result['all_ads_id'];	
			$this->load->view('header',$results);
			$this->load->view('result_display');
			$this->load->view('footer');
	}
	}
	
	//refine sorrounding areas
	function refine_sorr($offset=0)
	{
	//print_r($_GET);
	$data=$_GET;
	
		if(empty($data['ads_id']))
	{
		$results['total_rows']=0;
		$this->load->view('header',$results);
		$this->load->view('result_display');
		$this->load->view('footer');
	}
	else
	{
	$this->load->library('pagination');
	$result_per_page =10;
	
	if(!isset($data['options']))
		{
			$data['options']=array('0');
			$results['city']=array();
			$city=1000;
		}
		else
		{
		foreach($data['options'] as $a=>$b)
		{
		$city_city[]='"'.$b.'"';
		}
		$city_city = array_unique($city_city);
		$city=implode(',',$city_city);
		$results['city']=$data['options'];
		}
	
		$this->load->model('ads_model');
		$count_result=$this->ads_model->r_sorr_count($data,$city);
		$result_count=$count_result['rcount'];
		if(!empty($_REQUEST['per_page'])){$offset=$_REQUEST['per_page'];}
		
		//pagination
		if(!empty($result_count))
				{
				$s='';
		foreach($results['city'] as $a=>$b)
		{
		$s .='options[]='.$b.'&';
		}
		
		$baseurl = site_url() . '/';
				$config['base_url'] = $baseurl.'ads/refine_sorr?'.$s.'ads_id='.$data['ads_id'].'&location='.$data['location'];
				$config['per_page'] = $result_per_page;
				$config['total_rows']=$result_count;
				$config['num_links'] = 2;
				$config['prev_link'] = 'Prev';
				$config['next_link'] = 'Next';
				$config['first_link'] = False;
				$config['last_link'] = False;
		
				$this->pagination->initialize($config);
				}
	
	//pagination end
		
		
		$results['result']=$this->ads_model->r_sorr($data,$city,$offset,$result_per_page);
	
		$results['location']=$data['location'];
		$results['all_ads_id']=$count_result['all_ads_id'];
		$results['total_rows']=$result_count=$count_result['rcount'];
		
		
	
		$this->load->view('header',$results);
		$this->load->view('result_display');
		$this->load->view('footer');
	}
	}
	
	//sort results
	function sort_results($sort='',$offset=0)
	{
	//print_r($_GET);
	$data=$_GET;
	//echo "<h1>Work in progress</h1>$sort";
	//
		if(empty($data['ads_id']))
	{
		$results['total_rows']=0;
		$results['location']=$data['location'];
		$results['sort']=$sort;
		$this->load->view('header',$results);
		$this->load->view('result_display');
		$this->load->view('footer');
	}else
	{
	//
	$this->load->model('ads_model');
	$count_result=$this->ads_model->sort_results_count($sort,$data);
	$results['total_rows']=$result_count=$count_result['rcount'];	
	//pagination
	
	$this->load->library('pagination');
	$result_per_page =10;
	if(!empty($_REQUEST['per_page'])){$offset=$_REQUEST['per_page'];}
	if(!empty($result_count))
				{
				$baseurl = site_url() . '/';
				$config['base_url'] = $baseurl.'ads/sort_results/'.$sort.'?ads_id='.$data['ads_id'].'&location='.$data['location'];
				$config['per_page'] = $result_per_page;
				$config['total_rows']=$result_count;
				$config['num_links'] = 2;
				$config['prev_link'] = 'Prev';
				$config['next_link'] = 'Next';
				$config['first_link'] = False;
				$config['last_link'] = False;
		
				$this->pagination->initialize($config);
				}
	//pagination end
	
	$results['result']=$this->ads_model->sort_results_model($sort,$data,$offset,$result_per_page);
	$results['location']=$data['location'];
	$results['sort']=$sort;
	$results['all_ads_id']=$count_result['all_ads_id'];	
	//echo '<pre>';print_r($results);echo '</pre>';
	//$results['total_rows']=0;
	$this->load->view('header',$results);
	$this->load->view('result_display');
	$this->load->view('footer');
	}
	}
	
	
	/////////////////////preview
// ad details
	function preview()
	{ 
		$ads_id=$this->session->userdata('ads_id');
		$data = array();	
		$data2 = array();
		$data3=array();
		
		$adTitle = $this->input->post('adTitle');
		$propFeature1= $this->input->post('propFeature1');
		$propFeature2 = $this->input->post('propFeature2');
		$adDescription = $this->input->post('adDescription');
		$data3['adTitle']=$adTitle;
		$data3['propFeature1']=$propFeature1;
		$data3['propFeature2']=$propFeature2;
		$data3['adDescription']=$adDescription;
		
		$this->load->helper(array('form', 'url'));
		
		$this->load->model('ads_model');	
			
		$viewdata['ads_id'] = $ads_id;
		//$viewdata['user_id'] = $user_id;
		
		//$this->ads_model->adsviews($ads_id);
		
		$data['adsdata'] = $this->ads_model->ads_detail($ads_id);
		//echo '<pre>';print_r($data['adsdata']);echo '</pre>';
		
		//$data['adsviews'] = $this->ads_model->adsviewscount($ads_id);
		 

		$adsImages	=	$this->ads_model->ads_Images($ads_id);				
		$userData['adsImages'] = $adsImages;	

		$utl_bills	=	$this->ads_model->adsMetaData($ads_id,1);	
				
		$userData['utl_bills'] = $utl_bills;
		
		$furinished_list	=	$this->ads_model->adsMetaData($ads_id,2);					
		$userData['furinished_list'] = $furinished_list;		
		
		$data1=array();
		
		$this->load->model('user_model');
		//if(isset($_SESSION['user_id']))
		if($this->session->userdata('user_id'))
		{
	    //$uid=$_SESSION['user_id'];
	    $uid=$this->session->userdata('user_id');
		$this->result1=$this->user_model->myinboxcount($uid);
		$data1['result1']=$this->result1;
		}
		
		
		
		$newData = array_merge($data,$userData,$data1,$data3);
		
		$this->load->view('header',$newData);
		
	//$this->load->view('ads_detail');
	$this->load->view('ads_preview');
	}

	////////////////////
	
	
	
	// ad details
	function detail($title='',$ads_id='',$status='')
	{ 
		$data = array();	
		$data2 = array();

		$this->load->helper(array('form', 'url'));
		
		$this->load->model('ads_model');	
		
		$adsdata = $this->ads_model->ads_detail($ads_id);
		if(empty($adsdata)){redirect('user/profile');}
		//echo '<pre>';print_r($adsdata);echo '</pre>';
		
		//if($_SESSION['email']!=$adsdata['email'])
		if($this->session->userdata('email')!=$adsdata['email'])
		{$this->ads_model->adsviews($ads_id);}
		
		$viewdata['ads_id'] = $ads_id;
		//$viewdata['user_id'] = $user_id;
		
		
		$data['adsdata'] = $this->ads_model->ads_detail($ads_id);
		
	//	echo '<pre>';print_r($data['adsdata']);echo '</pre>';
		
		$data['adsviews'] = $this->ads_model->adsviewscount($ads_id);
		 

		$adsImages	=	$this->ads_model->ads_Images($ads_id);				
		$userData['adsImages'] = $adsImages;	

		$utl_bills	=	$this->ads_model->adsMetaData($ads_id,1);	
				
		$userData['utl_bills'] = $utl_bills;
		
		$furinished_list	=	$this->ads_model->adsMetaData($ads_id,2);					
		$userData['furinished_list'] = $furinished_list;		
		
		$data1=array();
		
		$this->load->model('user_model');
		//if(isset($_SESSION['user_id'])){
		if($this->session->userdata('user_id')){
	    //$uid=$_SESSION['user_id'];
	    $uid=$this->session->userdata('user_id');
		$this->result1=$this->user_model->myinboxcount($uid);
		$data1['result1']=$this->result1;
		}
		
		if(isset($status))
		{
		switch ($status)
		{
		case 1:
		$data1['status']='Message sent successfully';
		break;
		case 2:
		$data1['status']='Please fill all the required fields to send message';
		break;
		}
		}
		
		$newData = array_merge($data,$userData,$data1);
		
		$this->load->view('header',$newData);
	
	$this->load->view('ads_detail');
		$this->load->view('footer');
	}
	
	
	// ad preview
	function preview_old($title='',$ads_id='')
	{
		$data = array();	
		
		$this->load->model('ads_model');	
		
		$adsdata = $_POST;		

		$data['adsdata'] = $adsdata;			
		
		$this->load->view('header',$data);
		$this->load->view('ads_preview');
		$this->load->view('footer');	
	}	
	
	
	// shortlist ad
	function shortlist($title='',$ads_id='',$user_id)
	{
		$baseurl = site_url() . '/';
		$url=$baseurl.'ads/detail/'.$title.'/'.$ads_id;		
		// check user is loggedin or not
		
		if(!$this->session->userdata('user_id'))
		{
			// redirect to login page
			$this->session->set_flashdata('alert',"<p id='notify_alert_signin_to_shotlistad' class='alert_notify'>You must be signed in to shortlist ads!</p>");
			$this->session->set_userdata('request_page', $url);
			redirect('/user/signin', 'refresh');
		}
		
		
		
		// insert into database
		$this->load->model('ads_model');
		$flag = $this->ads_model->addToShortList($ads_id,$user_id);
		
		if ($flag==1)
			$this->session->set_flashdata('success', 'You have succesfully added this ad in your shortlisted ads!');

		if($flag==2)
			$this->session->set_flashdata('alert', 'You have already shortlisted this ad !');
		redirect($url);		
		
	}
	//controllers from AMAN temporary
		// create - ad
	function createfinders($id=0)
	{			
		// check user is loggedin or not
		
//
$this->session->unset_userdata('ads_id');
		$this->session->unset_userdata('editFlag');
	
		// check user is loggedin or not
		//if( empty($_SESSION['user_id']))
		if(!$this->session->userdata('user_id'))
		{
			// redirect to login page
			
			$this->session->set_flashdata('alert',"<p id='notify_alert_signin_to_postad' class='alert_notify'>You must be signed in to post your ad!</p>");
			//$_SESSION['request_page'] = '/ads/create/';
			$this->session->set_userdata('request_page', '/ads/create/');
			redirect('/user/signin', 'refresh');
		}	
		
		if(isset($_POST['postAdSubmit']))
			{
			
				
			//$this->session->set_flashdata('success', 'You have succesfully added your ad!');	
		$this->load->helper('url');
		redirect('/user/profile');	
			}
		
		$userData['editFlag'] = 0;
		
				
			$staticurl = $this->config->item('static_url');

			
		//if(isset($_SESSION['user_id']))
		if($this->session->userdata('user_id'))
		{
		//$uid=$_SESSION['user_id'];
		$uid=$this->session->userdata('user_id');
		}
		
		$this->load->model('user_model');
		$this->result1=$this->user_model->myinboxcount($uid);
		$data1['result1']=$this->result1;
		
		
		
		// update ad
		$this->load->model('ads_model');
				$ads_id = intval($id);
					if($ads_id>0)
						{
							$adsfullData	=	$this->ads_model->ads_detail($ads_id);			
							
							if(is_array($adsfullData) && count($adsfullData)>0 && $this->session->userdata('user_id')==$adsfullData['user_id'])
							{
								$userData['editFlag'] = 1;
								$userData['adsfullData'] = $adsfullData;				
								$adsImages	=	$this->ads_model->ads_Images($ads_id);				
								$userData['adsImages'] = $adsImages;	
								$utl_bills	=	$this->ads_model->adsMetaData($ads_id,1);	
								$userData['utl_bills'] = $utl_bills;
								$furinished_list	=	$this->ads_model->adsMetaData($ads_id,2);
								$userData['furinished_list'] = $furinished_list;				
							}
							else
							{
								$this->session->set_flashdata('alert', 'You are not authorized to update this ads!');	
								redirect('/user/profile');							
							
							}						
						}
		
		
		
		
		
		$userData['tabon'] = 1; 
		
		$newData = array_merge($userData, $data1);
//



		
		
		
		$this->load->view('header1',$userData);
		$this->load->view('finder_create');
		$this->load->view('footer');
	} // end of function create 
	
	
	function contact($title='',$id=0,$user_id='')
	{
	
		// check user is loggedin or not
		$userData['tabon'] = 1;
		
		$this->load->helper('date');
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->form_validation->set_rules('yourEmail', 'Email', 'trim|required|valid_email');
		$this->form_validation->set_rules('firstName', 'Name', 'trim|required');
		//$this->form_validation->set_rules('lastName', 'Lastame', 'trim|required');
		$this->form_validation->set_rules('yourMessage', 'Message', 'required');
		$this->form_validation->set_error_delimiters('<label class="validation">', '</label>');
		$contactFlag = FALSE;
		$contactMessage = '';
		$contactData = array();
		$contactData['ads_id']=$id;
		$contactData['user_id']=$user_id;
		$this->load->model('ads_model');
		$data=array();
		$data['rinfo']=$this->ads_model->recieverinfo($id);
		//print_r($rinfo);exit;
		//$this->load->view('contact_frm',$data);
		
		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view('contact_frm',$data);		
		}
		else
		{			
			//$this->load->model('ads_model');			
		
			$youremail = $this->input->post('yourEmail');
			$contactData['youremail'] = $youremail;
			$firstname = $this->input->post('firstName');
			$contactData['firstname'] = $firstname;
			$lastname = $this->input->post('lastName');
			$contactData['lastname'] = $lastname;
			$yourmessage = $this->input->post('yourMessage');
			$contactData['yourmessage'] = $yourmessage;
			$sendcopy = $this->input->post('sendCopy');
			$contactData['sendcopy'] = $sendcopy;	
			
			$r_name = $this->input->post('r_name');
			$contactData['r_name'] = $r_name;	
			$r_email = $this->input->post('r_email');
			$contactData['r_email'] = $r_email;	
			$sender_uid = $this->input->post('sender_uid');
			$contactData['sender_uid'] = $sender_uid;	
			
			
			$advContactData	=$this->ads_model->contactAdv($contactData);
			$toemail=$advContactData[0]['email'];
			$subject=$advContactData['subject'];
			
			
			echo "Message sent";
			
				$contactFlag = TRUE;
				
				//simple mail
				$this->load->library('email');
				
				$this->email->from($youremail, $firstname);
				$this->email->to($toemail);

				if($sendcopy)
				{
				$this->email->cc($youremail); 
				}
				
				$this->email->subject('Contacted for Accomodation for '.$subject);
				$this->email->message($contactData['yourmessage']);	

				$this->email->send();
				
			
			
			
			$this->ads_model->adscontact($id);
		}	
		
		
	} // end of function create 	
}

/* End of file ads.php */
/* Location: ./system/application/controllers/ads.php */