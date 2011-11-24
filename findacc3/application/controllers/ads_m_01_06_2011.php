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
	function update($title='',$id=0)
	{
		$this->create($title,$id);
	}
	
	// create - ad
	function create($title='',$id=0)
	{			
		
		// check user is loggedin or not
		if( empty($_SESSION['user_id']))
		{
			// redirect to login page
			$msg = "You must logged-in to add your ad!";
			$_SESSION['request_page'] = '/ads/create/';
			redirect('/user/signin/?message=' . urlencode($msg), 'refresh');
		}	
		/*
		$this->assetlibpro->add_css('css/createAd.css');
		
		$this->assetlibpro->add_js('js/checklist/src/ui.dropdownchecklist.js');
		$this->assetlibpro->add_js('js/newSelect/msdropdown/js/jquery.dd.js');
		$this->assetlibpro->add_js('js/mydocumentready.js');		
		*/
		$userData = array();
		$userData['adsImages'] = array();
		
		$userData['editFlag'] = 0;
		$this->load->model('ads_model');
		
		// update ad
		
		$ads_id = intval($id);
		if($ads_id>0)
		{
			$adsfullData	=	$this->ads_model->ads_detail($ads_id);			
			if(is_array($adsfullData) && count($adsfullData)>0 && $_SESSION['user_id']==$adsfullData['user_id']){
				$userData['editFlag'] = 1;
				$userData['adsfullData'] = $adsfullData;				
				$adsImages	=	$this->ads_model->ads_Images($ads_id);				
				$userData['adsImages'] = $adsImages;	

				$utl_bills	=	$this->ads_model->adsMetaData($ads_id,1);	
				//print_r($utl_bills);
				$userData['utl_bills'] = $utl_bills;
				$furinished_list	=	$this->ads_model->adsMetaData($ads_id,2);
				//print_r($furinished_list);				
				$userData['furinished_list'] = $furinished_list;				
			}
			else
			{
				// redirect to login page
				$msg = "You are not authorized to update this ads!";
				//$_SESSION['request_page'] = '/ads/create/';
				redirect('/?message=' . urlencode($msg), 'refresh');			
			}						
		}
		
		
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		
			

		// fields
		/*
		adTitle
		emailId
		
		*/
		
		// set validation rules
		
		$this->form_validation->set_rules('adTitle', 'Title of the Ad', 'trim|required|min_length[4]|max_length[300]');
		$this->form_validation->set_rules('emailId', 'Email', 'trim|required|valid_email');		
		$this->form_validation->set_rules('captchaCode', 'Verification code', 'callback_captcha_verification');
		
		$this->form_validation->set_error_delimiters('<label class="validation">', '</label>');
		
		$adsCreateFlag = FALSE;
		$adsCreateMessage = '';
		$adsData = array();
		
		$previwFlag = $this->input->post('previwFlag');
		
		if($previwFlag!=1)
		{	
		
			if ($this->form_validation->run() == FALSE)
			{			
				//echo "fail";			
				
			}
			else
			{
				//echo "pass";		
				
				foreach ($_POST as $key=>$val)
				{
				  $adsData[$key] = $this->input->post($key);
				}
				
				//$userData[$field['Field']] = $adsImages;
				//$userData['title'] = $adsImages;
				/*
				$title = '';
				$bestfeature1 = '';
				$bestfeature2 = '';
				$description = '';
				$community = '';
				$first_name = '';
				$last_name = '';
				$phone = '';
				$phone_visibility = false;
				$email = '';
				$email_visibility = false;


				$street_address = '';
				$city = '';
				$state = '';
				$country = '';
				$postal_code = '';
				$address_visibility = false;

				$rent = '';
				$rent_type = '';
				$property_type = '';
				$bond = '';
				$min_stay = '';
				$max_stay = '';
				$availability = '';
				$bills = false;
				$furnished = false;
				$gender = '';
				$smoker = '';

				$age = '';
				$orientation = '';
				$diet = '';
				$surrounding = '';
				$bed_rooms = '';
				$bath_rooms = '';
				$parking = '';

				$utl_bills2 = array();
				$furinished_list2 = array();			
				
				echo "<pre>";
				print_r($adsData);
				echo "</pre>";
				*/
				/*
				$result = mysql_query("SHOW COLUMNS FROM sometable");
				if (!$result) {
					//echo 'Could not run query: ' . mysql_error();
					//exit;
				}
				if (mysql_num_rows($result) > 0) {
					while ($row = mysql_fetch_assoc($result)) {
						//print_r($row);
						//Field
					}
				}	
				
				$fieldList	=	$this->ads_model->get_adFields();
				
				if(is_array($fieldList) && count($fieldList)>0 ){
					foreach($fieldList as $field)
					{
						$userData[$field['Field']] = $adsImages;
					}			
				}			
				*/
				

				
				
				$userData['adsData'] = $adsData;
				
				$previwFlag = $this->input->post('previwFlag');
				
				if($previwFlag!=1)
				{
					
					$adsCreateData = false;
					if($userData['editFlag']==0)
						$adsCreateData	=	$this->ads_model->create_ad($adsData);
					else
						$adsCreateData	=	$this->ads_model->update_ad($adsData);
						
					if(!$adsCreateData)
					{
						$adsCreateMessage = 'We are very sorry, Some system problem occurred, Try after time!';
					}
					else
					{
						$adsCreateFlag = TRUE;	
						if(empty($ads_id) && !($ads_id)>0 && $adsCreateFlag)
							$ads_id = $adsCreateData['ads_id'];					
						//print_r($_FILES);
						
						$image_uploadpath = $this->config->item('image_uploadpath');
						$image_allowed_types = $this->config->item('image_allowed_types');
						$image_max_size = $this->config->item('image_max_size');
						$image_max_width = $this->config->item('image_max_width');
						$image_max_height = $this->config->item('image_max_height');
						
						// upload browsed files
						$config['upload_path'] = './' . $image_uploadpath;
						$config['allowed_types'] = $image_allowed_types;
						$config['max_size']	= $image_max_size;
						$config['max_width']  = $image_max_width;
						$config['max_height']  = $image_max_height;
						
						//print_r($_FILES['browseImage']);
						$staticurl = $this->config->item('static_url');
						
						/*
						$this->load->library('upload', $config);
						echo "<pre>";
						print_r($_FILES['browseImage']);

						if ( $this->upload->do_upload('browseImage') )				
						{
							echo "<br>------11111111222222222222222222222211111111----<br>";
							$upload_data = $this->upload->data();
							print_r($upload_data);
							/*
							
							$adsCreateData['upload_data'] = $upload_data;
							$adsCreateData['upload_data']['upload_path'] = $config['upload_path'];
							$adsCreateData['upload_data']['static_fullurl'] = $staticurl;
							$adsCreateData['upload_data']['static_relativeurl'] = $image_uploadpath;
							// insert uploaded images in DB
							$this->ads_model->add_adImages($adsCreateData);
							*
						}
						else
						{
							echo "<br>------1111111111111111----<br>";
							$upload_data = $this->upload->data();
							print_r($upload_data);				
						}
						*/
						
						/*
						Array
						(
							[name] => Array
								(
									[0] => Sunset.jpg
									[1] => Winter.jpg
								)
							[type] => Array
								(
									[0] => image/jpeg
									[1] => image/jpeg
								)
							[tmp_name] => Array
								(
									[0] => D:\xampp\tmp\php1D4.tmp
									[1] => D:\xampp\tmp\php1D5.tmp
								)
							[error] => Array
								(
									[0] => 0
									[1] => 0
								)
							[size] => Array
								(
									[0] => 71189
									[1] => 105542
								)
						)
						*/
						
						if( !empty($_FILES) && count($_FILES)>0 && !empty($_FILES['browseImage']) && count($_FILES['browseImage'])>0 )
						{
							//echo "<br>------1111111111111111----<br>";
							$files = $_FILES['browseImage'];
							
							if( !empty($files['name']) && is_array($files['name']) && count($files['name'])>0 )
							{
								// upload multiple files
								$nfile = count($files['name']);
								for($i=0;$i<$nfile;$i++)
								{
									//echo "<br>------33333333333333333333333----<br>";
									
									if(!empty($files['name'][$i]) && $files['error'][$i]==0  && $files['size'][$i]>0 && $files['size'][$i]<=$config['max_size'] )
									{
										//echo "<br>------44444444444444444444444444----<br>";
										if ( is_uploaded_file($files['tmp_name'][$i]))
										{
											//echo "<br>------55555555555555555555----<br>";
											$file_temp = $files['tmp_name'][$i];
											$file_name = $files['name'][$i];
											
											$file_names = explode('.',$file_name);									
											
											while(file_exists($config['upload_path'] . $file_name))
											{
												$file_name = $file_names[0] .  '_' . mt_rand() . '.' .$file_names[1];
											}
											/*
											 * Move the file to the final destination
											 * To deal with different server configurations
											 * we'll attempt to use copy() first.  If that fails
											 * we'll use move_uploaded_file().  One of the two should
											 * reliably work in most environments
											 */
											if ( ! @copy($file_temp, $config['upload_path'].$file_name))
											{
												if ( ! @move_uploaded_file($file_temp, $config['upload_path'].$file_name))
												{
													
												}
											}

											$adsImgData = array();						
										
											$adsImgData['ads_id'] = $ads_id;
											$adsImgData['adTitle'] = $adsData['adTitle'];
											$adsImgData['propFeature1'] = $adsData['propFeature1'];
											$adsImgData['file_name'] = $file_name;
											
											$adsImgData['static_fullurl'] = $staticurl;
											$adsImgData['upload_path'] = $config['upload_path'];
											$adsImgData['static_relativeurl'] = $image_uploadpath;
											
											$this->ads_model->add_adImages($adsImgData);
										
										}
									}
								}						
							}
							else if( !empty($files['name']) && is_string($files['name']))
							{
								//echo "<br>------222222222222222222----<br>";
								// upload single files
								if( $files['error']==0  && $files['size']>0 && $files['size']<=$config['max_size'] )
								{
									if ( is_uploaded_file($files['tmp_name']))
									{
										$file_temp = $files['tmp_name'];
										$file_name = $files['name'];
										
										$file_names = explode('.',$file_name);									
										
										while(file_exists($config['upload_path'] . $file_name))
										{
											$file_name = $file_names[0] .  '_' . mt_rand() . '.' . $file_names[1];
										}
										/*
										 * Move the file to the final destination
										 * To deal with different server configurations
										 * we'll attempt to use copy() first.  If that fails
										 * we'll use move_uploaded_file().  One of the two should
										 * reliably work in most environments
										 */
										if ( ! @copy($file_temp, $config['upload_path'].$file_name))
										{
											if ( ! @move_uploaded_file($file_temp, $config['upload_path'].$file_name))
											{
												
											}
										}
										$adsImgData = array();						
									
										$adsImgData['ads_id'] = $ads_id;
										$adsImgData['adTitle'] = $adsData['adTitle'];
										$adsImgData['propFeature1'] = $adsData['propFeature1'];
										$adsImgData['file_name'] = $file_name;
										
										$adsImgData['static_fullurl'] = $staticurl;
										$adsImgData['upload_path'] = $config['upload_path'];
										$adsImgData['static_relativeurl'] = $image_uploadpath;
										
										$this->ads_model->add_adImages($adsImgData);
									}
								}						
								
							}					
						}
						
						$adsCreateMessage = 'You have successfully added your ad!';
						
						// redirect to profile page after signedin
						
						//redirect('/user/profile/', 'refresh');
						
					}			
					
					// get form data
				}
			}	
			
		}
		if(empty($ads_id) && !($ads_id)>0 && $adsCreateFlag)
			$ads_id = $adsCreateData['ads_id'];
			
		if($ads_id>0)
		{
			$adsfullData	=	$this->ads_model->ads_detail($ads_id);			
			if(is_array($adsfullData) && count($adsfullData)>0 && $_SESSION['user_id']==$adsfullData['user_id']){
				$userData['editFlag'] = 1;
				$userData['adsfullData'] = $adsfullData;				
				$adsImages	=	$this->ads_model->ads_Images($ads_id);				
				$userData['adsImages'] = $adsImages;	

				$utl_bills	=	$this->ads_model->adsMetaData($ads_id,1);	
				//print_r($utl_bills);
				$userData['utl_bills'] = $utl_bills;
				$furinished_list	=	$this->ads_model->adsMetaData($ads_id,2);
				//print_r($furinished_list);				
				$userData['furinished_list'] = $furinished_list;				
			}
			else
			{
				// redirect to login page
				$msg = "You are not authorized to update this ads!";
				//$_SESSION['request_page'] = '/ads/create/';
				redirect('/?message=' . urlencode($msg), 'refresh');			
			}						
		}		
		
		// set captch session in hidden so without submit form should not be processed
		
		$captchaCode	=	$this->ads_model->getRandomString();
		
		$_SESSION['captchaCode'] = $captchaCode;
		
		$userData['captchaCode'] = $captchaCode;
		
		
		$userData['ads_error_message'] = $adsCreateMessage;
		
		
		// make top tabs on
		/*
			0:home
			1:post free ad
			2:advance search
			3:how it works
		*/
		
		$userData['tabon'] = 1; 
		
		$this->load->view('header',$userData);
		$this->load->view('create_ad');
		$this->load->view('footer');
	} // end of function create 
	
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
	function search($result='')
	{
		/*
			?location=pune
			&community=option1
			&memberType=1
			&head_findBtn.x=39&head_findBtn.y=29
			&searcfrom=1

			?surrAreas=on
			&location=sdsds
			&community=option1&community=option2&community=option3&community=option4
			&memberType=0&head_findBtn.x=30&head_findBtn.y=22
			&searcfrom=1	
			
			?location=pune
			&community=option1
			&memberType=1
			&searchFrom=1
			&resultCount=4
			&page=2&total=4
		*/
		
		//print_r($_GET);
		//print_r($_REQUEST);
		
		$this->searchFlag = 1;		
		$this->searchFrom = (!empty($_REQUEST['searchFrom']))?$_REQUEST['searchFrom']:'';
		
		$this->location = (!empty($_REQUEST['location']))?$_REQUEST['location']:'';
		$this->surrAreas = (!empty($_REQUEST['surrAreas']))?$_REQUEST['surrAreas']:'';
		$this->community = (!empty($_REQUEST['community']))?$_REQUEST['community']:'';
		$this->memberType = (!empty($_REQUEST['memberType']))?$_REQUEST['memberType']:'';		
		
		$this->current_page = (!empty($_REQUEST['page']))?$_REQUEST['page']:1;		
		$this->resultCount = (!empty($_REQUEST['total']))?$_REQUEST['total']:0;		
		
		//$this->current_page = $page;
		//$this->resultCount = $total;
		
		$this->result();
		$this->display();		
	}		
	
	// result
	function result()
	{
		$this->load->model('ads_model');	
		
		$filters = array();
		
		$filters['city'] = $this->city;
		$filters['state'] = $this->state;
		$filters['country'] = $this->country;		
		
		$filters['searchFlag'] = $this->searchFlag;
		$filters['searchFrom'] = $this->searchFrom;
		
		$filters['location'] = $this->location;
		$filters['surrAreas'] = $this->surrAreas;
		$filters['community'] = $this->community;		
		$filters['memberType'] = $this->memberType;		
		
		$filters['per_page'] = $this->per_page;
		$filters['current_page'] = $this->current_page;
		
		// first find total records
		if($this->resultCount==0)
			$this->resultCount = $this->ads_model->filter_adsCount($filters);
		
		// now find current page records data
		$this->result = $this->ads_model->filter_ads($filters);
		
	}
	
	// display
	function display()
	{
		//$this->output->enable_profiler(TRUE);
		
		$this->assetlibpro->add_css('css/shortlistedAds.css');
		$this->assetlibpro->add_css('css/listing.css');
		$this->assetlibpro->add_css('css/pagination.css');	
		
		$data = array();
		

		$data['city'] = $this->city;
		$data['state'] = $this->state;
		$data['country'] = $this->country;		

		$data['result'] = $this->result;
		$data['resultCount'] = $this->resultCount;
		$data['per_page'] = $this->per_page;
		$data['current_page'] = $this->current_page;
		
		$data['location'] = $this->location;
		$data['surrAreas'] = $this->surrAreas;
		$data['community'] = $this->community;		
		$data['memberType'] = $this->memberType;	
		
		$data['searchFlag'] = $this->searchFlag;
		$data['searchFrom'] = $this->searchFrom;
		
		$data['searchFields'] = $this->searchFields;
		$data['searchCommonFields'] = $this->searchCommonFields;
		
		$this->load->view('header',$data);
		$this->load->view('result_display');
		$this->load->view('footer');		
		
	}	
	
	// ad details
	function detail($title='',$ads_id='')
	{
		$data = array();	
		
		$this->load->model('ads_model');	
		
		$adsdata = $this->ads_model->ads_detail($ads_id);
		$data['adsdata'] = $adsdata;

		$adsImages	=	$this->ads_model->ads_Images($ads_id);				
		$userData['adsImages'] = $adsImages;	

		$utl_bills	=	$this->ads_model->adsMetaData($ads_id,1);		
		$userData['utl_bills'] = $utl_bills;
		
		$furinished_list	=	$this->ads_model->adsMetaData($ads_id,2);					
		$userData['furinished_list'] = $furinished_list;		
		
		$this->load->view('header',$data);
		$this->load->view('ads_detail');
		$this->load->view('footer');	
	}
	
	// ad preview
	function preview($title='',$ads_id='')
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
	function shortlist($title='',$ads_id='')
	{
		$url = $_SERVER['HTTP_REFERER'];		
		// check user is loggedin or not
		if( empty($_SESSION['user_id']))
		{
			// redirect to login page
			$msg = "You must logged-in to shortlist ads!";
			$_SESSION['request_page'] = $url;
			redirect('/user/signin/?message=' . urlencode($msg), 'refresh');
		}
		
		// http://localhost/findacc31/index.php/ads/shortlist/Enter-impressive-heading-max-100-chars/6
		/*
		print_r($_SERVER);
		print_r($_COOKIE);
		print_r($_REQUEST);
		*/
		
		// insert into database
		$this->load->model('ads_model');
		$flag = $this->ads_model->addToShortList($ads_id,$_SESSION['user_id']);
		
		if ($flag>0)
			$this->session->set_flashdata('message', 'You have succesfully add this ad in your shortlist!');	
		else
			$this->session->set_flashdata('message', 'You have already shortlisted this ad !');
		redirect($url);		
		
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
		//controllers from AMAN temporary
		// create - ad
	function createfinders($title='',$id=0)
	{			
		
		// check user is loggedin or not
		

		
		$userData['tabon'] = 1; 
		
		$this->load->view('header',$userData);
		$this->load->view('create_finders');
		$this->load->view('footer');
	} // end of function create 
	function contactfrm($title='',$id=0)
	{			
		
		// check user is loggedin or not
		

		
		$userData['tabon'] = 1; 
		
		$this->load->view('contact_frm');
	} // end of function create 	
	
	
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */