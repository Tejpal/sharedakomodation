<?php

class User extends Controller {

	var $per_page = 20;
	var $current_page = 1;
	var $resultCount = 0;
	var $searchFlag = 0;
	var $searchFrom = 0;

	

	function User()
	{
		parent::Controller();	
		
	}
	
	function index()
	{
		//$this->load->view('welcome_message');
		//$this->load->helper('text');
		$this->load->view('header');
		$this->load->view('welcome_message');
		$this->load->view('footer');		
		
	}
	
	// user - account
	function account()
	{


		$this->assetlibpro->add_css('css/accountSettings.css');
		$this->assetlibpro->add_css('css/amanStyles.css');
		
		
		// check user is loggedin or not
		
		if(!$this->session->userdata('user_id'))
		{
			// redirect to login page
			$this->session->set_flashdata('alert',"<p id='notify_alert_signin_to_account' class='alert_notify'>You must be signed in to access your account.</p>");
		
			$this->session->set_userdata('request_page', '/user/account/');
			redirect('/user/signin', 'refresh');
		}			
		
		
		
		
		if($this->session->userdata('user_id'))
		{
		
		$uid=$this->session->userdata('user_id');
		}
		
		$this->load->model('user_model');
		$this->result1=$this->user_model->myinboxcount($uid);
		$data1['result1']=$this->result1;
		$data1['tabon'] = 4;
		$this->load->view('header',$data1);
		
		
		
	//	$this->load->view('header');
		$this->load->view('account');
		$this->load->view('footer');		
		
		//$this->load->view('profile');
	}	
	
	// user - changeUsername
	function changeUsername()
	{			
		$this->load->view('changeUsername');
	}	
	// user - changePassword
	function changePassword()
	{			
		$this->load->view('changePassword');
	}
	// user - changeEmail
	function changeEmail()
	{			
		$this->load->view('changeEmail');
	}

	// user - changeUsername
	function updateUsername()
	{			
		$this->load->helper(array('form', 'url'));

		$this->load->library('form_validation');

		$this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[4]|max_length[16]|alpha_dash|xss_clean|callback_username_check');
		
		$this->form_validation->set_error_delimiters('', '');
		
		$data = array();
		$status = 0;
		$message = "";
		
		if($this->session->userdata('user_id') && $this->session->userdata('user_id')>0)
		{
			if ($this->form_validation->run() == FALSE)
			{
				$message = validation_errors();				
			}
			else
			{
				// update username			
				
				$this->load->model('user_model');
				
				$username = $this->input->post('username');
				
				$userSignupData	=	$this->user_model->updateUsername($_SESSION['user_id'],$username);

				if(!$userSignupData)
				{
					$message = 'We are very sorry, Some system problem occurred, Try after time!';
					//$message = 'Your corrent password doesnot match!';
				}
				else
				{					
					$status = 1;
					$message = "You have changed your username successfully.";
					$_SESSION['username'] = $username;
				}			
			}
		}
		else
		{
			$message = "You must be signed in to change your username.";		
		}
		$data['status'] = $status;
		$data['message'] = $message;
		
		echo json_encode($data);
	}	

	
	//save search
	function savesearch($url,$location)
	{
		
		if(!$this->session->userdata('user_id'))
		{
			$this->load->helper('url');
			// redirect to login page
			
			//$this->session->set_flashdata('alert','You must signed  to save the search.');
			$this->session->set_flashdata('alert',"<p id='notify_alert_signin_tosavesearch' class='alert_notify'>You must be signed in to save the search.</p>");
		
			$this->session->set_userdata('request_page', '/user/profile/');
			redirect('/user/signin', 'refresh');
		}	

		$this->load->model('user_model');
		$this->user_model->save_search($url,$location);	
	$this->session->set_flashdata('success', "<p id='success_result_display' class='success_notify'>You have succesfully saved this search</p>");			
	redirect('/ads/search?'.$url, 'refresh');
	}
	
	//save search
	function savedsearch()
	{
		
		if(!$this->session->userdata('user_id'))
		{
			$this->load->helper('url');
			// redirect to login page
			
			$this->session->set_flashdata('alert',"<p id='notify_alert_signin_savedsearch' class='alert_notify'>You must be signed in to access your account.</p>");
		
			$this->session->set_userdata('request_page', '/user/account/');
			redirect('/user/signin', 'refresh');
		}	

		$this->load->model('user_model');
		$savedresult['result']=$this->user_model->saved_search();
		$this->load->view('savedsearch',$savedresult);
	
	}
	
	// inbox
	function inbox($offset=0){
	if(!empty($_REQUEST['per_page'])){$offset=$_REQUEST['per_page'];}
	
	
	if(!$this->session->userdata('user_id'))
		{
			// redirect to login page
			
			$this->session->set_flashdata('alert',"<p id='notify_alert_signin_inbox' class='alert_notify'>You must be signed in to access your account.</p>");
	
			$this->session->set_userdata('request_page', '/user/inbox/');
			redirect('/user/signin', 'refresh');
		}		
	
	
	
		if($this->session->userdata('user_id'))
		{
	
		$uid=$this->session->userdata('user_id');
		}
		
		$this->searchFlag = 1;
		 if(!empty($_REQUEST['page']))
		 {$this->current_page =$_REQUEST['page'];}
		 
		$this->load->library('pagination');
		
		$result_per_page = 15;
		
		$this->load->model('user_model');
		
		$total_rows=$this->user_model->myinboxcount_all($uid);
		 if(!empty($total_rows)){
		$baseurl = site_url() . '/';
		$config['base_url'] = $baseurl.'user/inbox/?';
		$config['per_page'] = $result_per_page;
		$config['total_rows']=$total_rows;
		$config['num_links'] = 2;
		$config['prev_link'] = 'Prev';
		$config['next_link'] = 'Next';
		$config['first_link'] = False;
		$config['last_link'] = False;
		
		$this->pagination->initialize($config);
		}
		$this->result=$this->user_model->myinbox($uid,$offset,$result_per_page);
		
		$this->result1=$this->user_model->myinboxcount($uid);
		
		//update adsmessages table,delete deleted msgs
		$this->user_model->update_adsmessages();
		
		
		$inboxdata['result']=$this->result;
		$inboxdata['result1']=$this->result1;
		$this->load->helper('text');
		
		
		$this->load->view('header',$inboxdata);
		$this->load->view('inbox');	
		$this->load->view('footer');
		
	}
	
	
	
	// inbox message read
	function readmessage($msgid=''){
	
	if(!$this->session->userdata('user_id'))
		{
			// redirect to login page
			
			$this->session->set_flashdata('alert',"<p id='notify_alert_signin_readmsg' class='alert_notify'>You must be signed in to access your account.</p>");
	
			$this->session->set_userdata('request_page', '/user/inbox/');
			redirect('/user/signin', 'refresh');
		}	
if(isset($_POST['reply'])){
$ads_id=$_POST['adsid'];
$sender_id=$_POST['senderid'];
$threadid=$_POST['threadid'];
$message=$_POST['message'];

$this->load->model('user_model');
$result=$this->user_model->getsubject($threadid);

$subject="RE: ".$result[0]['subject'];


$data['ads_id']=$ads_id;
$data['sender_id']=$sender_id;
$data['subject']=$subject;
$data['message']=$message;
$data['threadid']=$threadid;
$data['msgid']=$msgid;


$this->reply($data);
$data['message']='msg';

}		
	
	
		//if(isset($_SESSION['user_id']))
		if($this->session->userdata('user_id'))
		{
	
		$uid=$this->session->userdata('user_id');
		}
		
		
		
		
		
		$this->load->model('user_model');
		$this->result=$this->user_model->readmessage_model($msgid);
		$this->result1=$this->user_model->myinboxcount($uid);
		$data1['result1']=$this->result1;
		
		$data['result']=$this->result;
		
		$this->load->view('header',$data1);
		$this->load->view('read_message',$data);
		$this->load->view('footer');		
		
		
	}
	
	
	
	// reply
	function reply($data='')
	{
	$ads_id=$data['ads_id'];
	$ruid=$data['sender_id'];
	$threadid=$data['threadid'];
	$subject=$data['subject'];
	$message=$data['message'];
	$msgid=$data['msgid'];
	
	
	
	
	
	if($this->session->userdata('user_id'))
	{
	
	$uid=$this->session->userdata('user_id');
	}
	
	$this->load->model('user_model');
	
	$sinfo=$this->user_model->reply_info($uid);
	$replydata['ads_id']=$ads_id;
	$replydata['contact_email']=$sinfo[0]['email'];
	$replydata['firstname']=$sinfo[0]['firstname'].' '.$sinfo[0]['lastname'];
	$replydata['sender_user_id']=$uid;
	$replydata['subject']=$subject;
	$replydata['message']=$message;
	
	
	
	if($ruid!=0){
	$rinfo=$this->user_model->reply_info($ruid);
	$replydata['user_id']=$ruid;
	$replydata['r_name']=$rinfo[0]['firstname'].' '.$rinfo[0]['lastname'];
	$replydata['r_email']=$rinfo[0]['email'];
	$replydata['thread_id']=$threadid;
	$this->result=$this->user_model->reply_model($replydata);}
	else 
	{
	$this->load->model('user_model');
	$result22=$this->user_model->readmessage_model($msgid);
	}
	
	$youremail=$replydata['contact_email'];
	$firstname=$replydata['firstname'];
	if($ruid!=0){
	$toemail=$replydata['r_email'];}
	else{$toemail=$result22[0]['contact_email'];}
	
		$this->load->library('email');
				
		$this->email->from($youremail, $firstname);
		$this->email->to($toemail);
		$this->email->subject('Contacted for Accomodation for '.$subject);
		$this->email->message($message);	
		$this->email->send();
	//echo $this->email->print_debugger();	
	
	}
	
	//sent messages
	function sentmessages($offset=0)
	{if(!empty($_REQUEST['per_page'])){$offset=$_REQUEST['per_page'];}
	
	if(!$this->session->userdata('user_id'))
		{
			// redirect to login page
			$this->session->set_flashdata('alert',"<p id='notify_alert_signin_sentmsg' class='alert_notify'>You must be signed in to access your account.</p>");
	
			$this->session->set_userdata('request_page', '/user/sentmessages/');
			redirect('/user/signin', 'refresh');
		}
	
		if($this->session->userdata('user_id'))
		{
	
		$uid=$this->session->userdata('user_id');
		}
		
		$this->load->library('pagination');
		
		$result_per_page = 15;
		
		$this->load->model('user_model');
		
		$total_rows=$this->user_model->sentmessagecount_all($uid);
		 if(!empty($total_rows)){
		 $baseurl = site_url() . '/';
		$config['base_url'] = $baseurl.'user/sentmessages/?';
		$config['per_page'] = $result_per_page;
		$config['total_rows']=$total_rows;
		$config['num_links'] = 2;
		$config['prev_link'] = 'Prev';
		$config['next_link'] = 'Next';
		$config['first_link'] = False;
		$config['last_link'] = False;
		
		$this->pagination->initialize($config);
		}
		
		$sentdata['result']=$this->user_model->sentmsg_model($uid,$offset,$result_per_page);
		$sentdata['result1']=$this->user_model->myinboxcount($uid);
		
		$this->load->helper('text');
		
		$this->load->view('header',$sentdata);
		$this->load->view('sent_messages');	
		$this->load->view('footer');
	}
	
	
	//Thread messages
	function thread($threadid)
	{
	
	if(!$this->session->userdata('user_id'))
		{
			// redirect to login page
			$this->session->set_flashdata('alert',"<p id='notify_alert_signin_thread' class='alert_notify'>You must be signed in to access your account.</p>");
	
			$this->session->set_userdata('request_page', '/user/inbox/');
			redirect('/user/signin', 'refresh');
		}
	
		if($this->session->userdata('user_id'))
		{
	
		$uid=$this->session->userdata('user_id');
		}
	
		$this->load->model('user_model');
		$threaddata['result']=$this->user_model->thread_model($threadid);
		if(empty($threaddata['result'])){redirect('user/profile');}
		$threaddata['result1']=$this->user_model->myinboxcount($uid);
		
		$this->load->helper('text');
		
		$this->load->view('header',$threaddata);
		$this->load->view('thread');	
		$this->load->view('footer');
	}
	
	
	// delete inbox msg
	function deletemessage_inbox($id='')
	{	
	$ads_id=$id;
		$this->load->helper('url');
		$this->load->model('user_model');
		$this->result=$this->user_model->deletemsg($ads_id);
		$data['result']=$this->result;
		redirect('user/inbox');
		
	}
	
	// delete sent msg
	function deletemessage_sent($id='')
	{	
	$ads_id=$id;
		$this->load->helper('url');
		$this->load->model('user_model');
		$this->user_model->deletemsg_sent($ads_id);
		redirect('user/sentmessages');
	
	}
	
	// delete multiple messages from inbox
	function multipledeletemessage_inbox()
	{   $msgid=(implode(',',$_POST['delete']));
		$this->load->helper('url');
		$this->load->model('user_model');
		$this->user_model->multipledeletemsg($msgid);
		redirect('user/inbox');
		
	}
	
	
	// delete multiple messages from sent box
	function multipledeletemessage_sent()
	{   $msgid=(implode(',',$_POST['delete']));
		$this->load->helper('url');
		$this->load->model('user_model');
		$this->user_model->multipledeletemsg_sent($msgid);
		redirect('user/sentmessages');
		
	}
	
	
	
	// user - updatePassword
	function updatePassword()
	{			
		$this->load->helper(array('form', 'url'));

		$this->load->library('form_validation');

		$this->form_validation->set_rules('currentpassword', 'Current Password', 'trim|required|min_length[6]|max_length[20]');
		$this->form_validation->set_rules('newpassword', 'New Password', 'trim|required|min_length[6]|max_length[20]|matches[retypenewpassword]');
		$this->form_validation->set_rules('retypenewpassword', 'Re-enter New Password', 'trim|required');
				
		$this->form_validation->set_error_delimiters('', '');
		
		$data = array();
		$status = 0;
		$message = "";
		
		if( $this->session->userdata('user_id') && $this->session->userdata('user_id')>0)
		{
			if ($this->form_validation->run() == FALSE)
			{
				$message = validation_errors();				
			}
			else
			{
				// update password			
				
				$this->load->model('user_model');
				
				$currentpassword = $this->input->post('currentpassword');
				$newpassword = $this->input->post('newpassword');
				
				
				$userSignupData	=	$this->user_model->updatePassword($this->session->userdata('user_id'),$currentpassword,$newpassword);

				if(!$userSignupData)
				{
					$message = 'We are very sorry, Some system problem occurred, Try after time!';
					$message = 'Your corrent password doesnot match!';
				}
				else
				{					
					$status = 1;
					$message = "You have changed your password successfully.";
				
				}			
			}
		}
		else
		{
			$message = "You must be signed in to change your password.";		
		}
		$data['status'] = $status;
		$data['message'] = $message;
		
		echo json_encode($data);
	}	
		

	// user - updateEmail
	function updateEmail()
	{			
		$this->load->helper(array('form', 'url'));

		$this->load->library('form_validation');

		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|callback_email_check');
		
		$this->form_validation->set_error_delimiters('', '');
		
		$data = array();
		$status = 0;
		$message = "";
		
		if( $this->session->userdata('user_id') && $this->session->userdata('user_id')>0)
		{
			if ($this->form_validation->run() == FALSE)
			{
				$message = validation_errors();				
			}
			else
			{
				// update email			
				
				$this->load->model('user_model');
				
				$email = $this->input->post('email');
				
				
				$userSignupData	=	$this->user_model->updateEmail($this->session->userdata('user_id'),$email);

				if(!$userSignupData)
				{
					$message = 'We are very sorry, Some system problem occurred, Try after time!';
					//$message = 'Your corrent password doesnot match!';
				}
				else
				{					
					$status = 1;
					$message = "You have changed your email successfully.";
				
					$this->session->set_userdata('email', $email);
				}			
			}
		}
		else
		{
			$message = "You must be signed in to change your email.";		
		}
		$data['status'] = $status;
		$data['message'] = $message;
		
		echo json_encode($data);
	}	
	

	// user - switchAccount
	function switchAccount()
	{	

		$data = array();
		$status = 0;
		$message = "";
		
		if( $this->session->userdata('user_id') && $this->session->userdata('user_id')>0)
		{
			$sharing_type = $this->input->post('sharing_type');			
			
			if ($sharing_type == 0 || $sharing_type == 1)
			{
				// update sharing type			
				
				$this->load->model('user_model');				
				
			
				$userSignupData	=	$this->user_model->switchAccount($this->session->userdata('user_id'),$sharing_type);

				if(!$userSignupData)
				{
					$message = 'We are very sorry, Some system problem occurred, Try after time!';
					//$message = 'Your corrent password doesnot match!';
				}
				else
				{					
					$status = 1;
					$message = "You have switched your account successfully.";
					$_SESSION['sharing_type'] = $sharing_type;
				}			
			}
			else
			{
				$message = "You must choose sharing type!";				
			}			
		}
		else
		{
			$message = "You must be signed in to switch your account.";		
		}
		$data['status'] = $status;
		$data['message'] = $message;
		
		echo json_encode($data);
	}	
	
	// user - updateNewsAndAlerts
	function updateNewsAndAlerts()
	{	

		$data = array();
		$status = 0;
		$message = "";
		
		if( $this->session->userdata('user_id') && $this->session->userdata('user_id')>0)
		{
			$yesNo1 = $this->input->post('yesNo1');

			$yesNo2 = $this->input->post('yesNo2');	
			
			if ($yesNo1 == 0 || $yesNo1 == 1 || $yesNo2 == 1 || $yesNo2 == 1  )
			{
				// update sharing type			
				
				$this->load->model('user_model');				
				
			
				$userSignupData	=	$this->user_model->updateNewsAndAlerts($this->session->userdata('user_id'), $yesNo1, $yesNo2);

				if(!$userSignupData)
				{
					$message = 'We are very sorry, Some system problem occurred, Try after time!';
					//$message = 'Your corrent password doesnot match!';
				}
				else
				{					
					$status = 1;
					$message = "You have updated news and alerts successfully.";
				
					$this->session->set_userdata('news_letter', $yesNo2);
				
					$this->session->set_userdata('matching_alerts', $yesNo1);
					
				}			
			}
			else
			{
				$message = "You must choose at least one!";				
			}			
		}
		else
		{
			$message = "You must be signed in to update news and alerts.";		
		}
		$data['status'] = $status;
		$data['message'] = $message;
		
		echo json_encode($data);
	}	
	
	// user - profile
	function profile($counter='')
	{
		// check user is loggedin or not
		
		if(!$this->session->userdata('user_id'))
		{
			// redirect to login page
			$this->session->set_flashdata('alert',"<p id='notify_alert_signin_profile' class='alert_notify'>You must be signed in to access your account.</p>");
		
			$this->session->set_userdata('request_page', '/user/profile/');
			redirect('/user/signin', 'refresh');
		}
		
		
		
		
		
		
		if($this->session->userdata('user_id'))
		{
		
		$uid=$this->session->userdata('user_id');
		$this->load->model('user_model');
		$this->load->model('ads_model');
		$adslist	=	$this->ads_model->ads_home_list(4);
		$data1['adslist'] = $adslist;
		$this->result1=$this->user_model->myinboxcount($uid);
		$data1['result1']=$this->result1;
		$this->load->view('header',$data1);
		}
		
		
		if(!$this->session->userdata('user_id'))
		{$this->load->view('header');}
		
		$this->load->view('welcome_message');
		$this->load->view('footer');		
		
		
	}	
	
	
	// user - signin
	function signin()
	{	
	
		if($this->session->userdata('user_id'))
		{
		$this->load->helper('url');
		redirect('user/profile');
		}
	
		$this->assetlibpro->add_css('css/signin.css');
		
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');

		$this->load->model('user_model');
		
		///checking cookie
		if(isset($_COOKIE['email'])){
		$cookie1=$_COOKIE['email'];
		
		$usercookie	=$this->user_model->cookie_check($cookie1);
		if($usercookie){
		$cookie2=$_COOKIE['userid'];
		$usercookieData	=$this->user_model->cookie2_check($cookie2);
		
		
		
	
				
				
				$this->session->set_userdata($usercookieData);		

			// get session request page				
				
				if($this->session->userdata('request_page'))
				{					
				
					$request_page =$this->session->userdata('request_page');
					
				
					$this->session->unset_userdata('request_page');
					
					redirect($request_page, 'refresh');
				}
				else {
				
					redirect('/user/profile/', 'refresh');
					}
				
		
		}
		}
		// fields
		/*
		email
		userpassword
		*/
		
		// set validation rules
		
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
		$this->form_validation->set_rules('userpassword', 'Password', 'trim|required|min_length[6]|max_length[20]');
			
		$this->form_validation->set_error_delimiters('<label class="validation">', '</label>');
		
		$userSigninFlag = FALSE;
		$userSigninMessage = '';
		$userData = array();
		
		if ($this->form_validation->run() == FALSE)
		{			
			//echo "fail";			
			$userSigninMessage = (empty($_REQUEST['message']))?'':$_REQUEST['message'];
		}
		else
		{
			//echo "pass";
			
						
			
			
			
			$email = $this->input->post('email');
			$userData['email'] = $email;
			$userpassword = $this->input->post('userpassword');
			$userData['password'] = $userpassword;
			$rememberMe = $this->input->post('rememberMe');
			$userData['rememberme'] = $rememberMe;			

			$userSigninData	=	$this->user_model->signin($userData);			
			
			if(!$userSigninData)
			{
				//$userSigninMessage = 'We are very sorry, Some system problem occurred, Try after time!';
				$userSigninMessage = 'Your email and passsword combination doesnot match, Try again!';
			}
			else if($userSigninData && $userSigninData['status']!='1')
			{
				switch($userSigninData['status'])
				{
					case '0':
						$userSigninMessage = 'You have not activated your account yet, First activate your account!';
						break;					
					case '2';
						$userSigninMessage = 'Your email and passsword combination doesnot match, Try again!';
						break;
					default:
						$userSigninMessage = 'Your email and passsword combination doesnot match, Try again!';
				}
				
			}
			else			
			{		
				// set user data in session
				
				
				
				$this->session->set_userdata($userSigninData);
				
				
				
				if($rememberMe==1){
				$cookieemail=md5($userSigninData['email']);
				$cookieuserid=$userSigninData['user_id'];
				$domain = $this->config->item('cookie_domain');
				
				setcookie("email", $cookieemail,  time()+3600,"/");
				setcookie("userid", $cookieuserid,  time()+3600,"/");
				$this->user_model->cookie($cookieemail,$cookieuserid);
				}
				// redirect to profile page after signedin
				
				// get session request page				
				
				if($this->session->userdata('request_page'))
				
				{					
					
					$request_page = $this->session->userdata('request_page');
					
					
					
					$this->session->unset_userdata('request_page');
					
					redirect($request_page, 'refresh');
				}
				else 
				
					redirect('/user/profile/', 'refresh');
				
			}
			
		}	
		
		
		$userData['signin_error_message'] = $userSigninMessage;
		
		
		$this->load->view('header');
		$this->load->view('signin',$userData);
		$this->load->view('footer');
	}
	
	// user - logout
	function signout()
	{
		// logout process
		
		// Finally, destroy the session.
		
		$this->session->sess_destroy();
		//deleting the cookies
		setcookie("username", "", time()-3600,"/");
		setcookie("userid", "", time()-3600,"/");
		// redirect after logout
		redirect('/user/signin/', 'refresh');
		
	}	
	
	// user - signup
	function signup()
	{
		$this->assetlibpro->add_css('css/register.css');
		
		//$this->input->post('parent_cat_id');
		
		$this->load->helper(array('form', 'url'));

		$this->load->library('form_validation');
		
		// fields
		
		// set validation rules
		$this->form_validation->set_rules('firstname', 'Firstname', 'trim|required|callback_firstname_check');
		$this->form_validation->set_rules('lastname', 'Lastname', 'trim|required|callback_lastname_check');
		
		$this->form_validation->set_rules('userpassword', 'Password', 'trim|required|min_length[6]|max_length[20]|matches[confirmpassword]');
		$this->form_validation->set_rules('confirmpassword', 'Password Confirmation', 'trim|required');
		$this->form_validation->set_rules('emailid', 'Email', 'trim|required|valid_email|callback_email_check');
		
		$this->form_validation->set_rules('verifycode', 'Verification Code', 'required|callback_captcha_verification');
		
		$this->form_validation->set_error_delimiters('<label class="validation">', '</label>');
		
		$userSignupFlag = FALSE;
		$userSignupMessage = '';
		$userData = array();
		
		if ($this->form_validation->run() == FALSE)
		{
			//$this->load->view('myform');
			//echo "fail";
			//$this->load->model('user_model');
			
			//$usernameExistsFlag	=	$this->user_model->checkUserNameExistence($usernamestr);			
			//$userSignupMessage = 'We are very sorry, Some system problem occurred, Try after time!';
			
		}
		else
		{
			//echo "pass";
			
			$this->load->model('user_model');			
			
			$firstname = $this->input->post('firstname');
			$userData['firstname'] = $firstname;
			$lastname = $this->input->post('lastname');
			$userData['lastname'] = $lastname;
			
			
			$userpassword = $this->input->post('userpassword');
			$userData['password'] = $userpassword;
			$emailid = $this->input->post('emailid');
			$userData['email'] = $emailid;			
			
			
			$userSignupData	=	$this->user_model->signup($userData);

			if(!$userSignupData)
			{
				$userSignupMessage = 'We are very sorry, Some system problem occurred, Try after time!';
			}
			else
			{
				$userSignupFlag = TRUE;
				
				
				
				$this->load->library('common_lib');
				$mail = array();
				$mail = $userData;
				
				
				// template name
				$template['tpl_name'] = 'signup_success.html';
				
				// base url
				$baseurl = site_url() . '/';
				$template['baseurl'] = $baseurl;
				
				// activation link
				
				$linkdata = array();
				$linkdata['email'] = $userData['email'];				
				$linkdata['firstname'] = $userData['firstname'];
				$linkdata['activation_code'] = $userSignupData['activation_code'];
				
				$activation_link = $baseurl . "user/activate/" . urlencode(base64_encode(json_encode($linkdata)));				
				$template['activation_link'] = $activation_link;
				
				$subject = "'Sharedakomodation.com account verification'";				
				$template['subject'] = $subject;
				
				$this->common_lib->send_template($mail,$template);				
				
			}
			//$this->load->view('formsuccess');
			
		}	
		
		//$userSignupMessage = 'We are very sorry, Some system problem occurred, Try after time!';
		
		$userData['signup_error_message'] = $userSignupMessage;
		
		//$this->load->view('signup_success');
		$this->load->view('header');
		if($userSignupFlag)
			$this->load->view('signup_success',$userData);
		else
			$this->load->view('signup',$userData);
		$this->load->view('footer');
	}
	
	// check user chars only allowed chars and also check for user exists in system or not
	function username_check($usernamestr)
	{
		//echo "username_check";
		$usernameRegex = '/^[a-z\d_]{4,16}$/i';		
		if (preg_match($usernameRegex, ($usernamestr))) {
		
			// now check this username exist or not in existing users
			$this->load->model('user_model');
			
			$usernameExistsFlag	=	$this->user_model->checkUserNameExistence($usernamestr);
			
			if($usernameExistsFlag)
			{
				$this->form_validation->set_message('username_check', "This username '$usernamestr' not availabele, You have to choose other username!");
				return FALSE;			
			}
			else
			{
				return TRUE;
			}
			
		} else {
			$this->form_validation->set_message('username_check', 'Username must start with alpha a-zA-Z');
			return FALSE;
		}		
	}

	// check email exists in system or not
	function email_check($emailstr)
	{
		//echo "username_check";
		//$usernameRegex = '/^[a-z\d_]{4,16}$/i';		
		//if (preg_match($usernameRegex, ($usernamestr))) {
		
			// now check this email exist or not in existing users
			$this->load->model('user_model');
			
			$emailExistsFlag	=	$this->user_model->checkEmailExistence($emailstr);
			
			if($emailExistsFlag)
			{
				$this->form_validation->set_message('email_check', "Email '$emailstr' already exists");
				return FALSE;			
			}
			else
			{
				return TRUE;
			}
		/*	
		} else {
			$this->form_validation->set_message('username_check', 'Username must start with alpha a-zA-Z');
			return FALSE;
		}
		*/
		
	}	
	
	// check varification code
	function captcha_verification($captchastr)
	{
		$captchastr=strtoupper($captchastr);
		//echo "callback_verification";
		//$verifycode = $this->input->post('verifycode');
		$session_verifycode = (empty($_SESSION['session_verifycode']))?'':$_SESSION['session_verifycode'];
		if($captchastr == '' || $captchastr!=$session_verifycode){
			$this->form_validation->set_message('captcha_verification', 'The Verification code did not match.');
			return FALSE;
		} else {
			return TRUE;		
		}		
	}
	
	// get captcha image
	function captcha($time)
	{
		// In Controller 
		
		$this->load->library('antispam');
		
		$baseurl = $this->config->item('base_url');
		
		$configs = array(
				'img_path' => './static/captcha/',
				'img_url' => $baseurl . '/static/captcha/',
				'img_height' => '80',
				'img_width'		=> '220',
				'font_path' 	=> './static/fonts/',					
				'font_size'		=> 	15					
			);			
		$captcha = $this->antispam->get_antispam_image($configs);
		//print_r($captcha);	
		// $captcha is an array exmaple
		//  array('word' => 'sfsdf', 'time' => time , 'image' => '<img .... ');
		
		
		// In View Print the $captcha['image'] to show captcha image.
		
		//echo $captcha['image'];
		
		
		// set captcha word text into session
		
		$_SESSION['session_verifycode'] = $captcha['word'];
		
		$this->load->view('captcha',$captcha);
	}
	
	// user - activation

	function activate($encodeeddata='')
	{
		//$activation_link = $baseurl . "user/activate/" . urlencode(base64_encode(json_encode($linkdata)));
		
		
		$userActivationFlag = FALSE;
		$userActivationMessage = '';
		$decodeddata = '';		
		
		if(!empty($encodeeddata))
		{
		
			$decodeddata = json_decode(base64_decode(urldecode($encodeeddata)));
			/*
			// print_r($decodeddata);			
			// stdClass Object ( [email] => mahesh@nnn.com [username] => mahesh [activation_code] => delW4Z ) 
			
			$decodeddata_array = (array) $decodeddata;
			print_r($decodeddata_array);
			
			echo $decodeddata->email;
			echo "<br>";
			echo $decodeddata->username;
			echo "<br>";
			echo $decodeddata->activation_code;
			*/
			
			if(is_object($decodeddata))
				$decodeddata = (array) $decodeddata;
				
			if(
				is_array($decodeddata) && count($decodeddata)==3
				&& !empty($decodeddata['email'])
				&& !empty($decodeddata['firstname'])
				&& !empty($decodeddata['activation_code'])
				)
			{				
				$this->load->model('user_model');	
				
				$activateFlag = $this->user_model->activate($decodeddata);
				//$activateFlag = TRUE;
				if($activateFlag)
				{
					$userActivationFlag = TRUE;
					
					// send welcome mail after activation success
					
					$this->load->library('common_lib');
					$mail = array();
					$mail = $decodeddata;
					
					
					// template name
					$template['tpl_name'] = 'user_activation.html';
					
					// base url
					$baseurl = site_url() . '/';
					$template['baseurl'] = $baseurl;					

					
					$subject = "'FindAccomodation.com Welcome'";				
					$template['subject'] = $subject;
					
					$this->common_lib->send_template($mail,$template);	
					
					
				}else{
					$userActivationMessage = 'Activation code not correct or it is expired!';	
				}				
				
			}else{
				$userActivationMessage = 'Activation code not present in the url!';	
			}
			
		}else{
			$userActivationMessage = 'Activation code not present in the url!';
		}
		
		$decodeddata['activation_error_message'] = $userActivationMessage;
		$decodeddata['user_activation_flag'] = $userActivationFlag;
		
		//$this->load->view('signup_success');
		$this->load->view('header');
		$this->load->view('activation',$decodeddata);
		$this->load->view('footer');		
	}	
	
	// user - account
	
	// user - forgot username
	function forgotusername()
	{
	
		$this->assetlibpro->add_css('css/signin.css');
		
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');

		// fields
		/*
		email
		*/
		
		// set validation rules
		
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|callback_email_check2');

		
		$this->form_validation->set_error_delimiters('<label class="validation">', '</label>');
		
		$userErrorFlag = FALSE;
		$userErrorMessage = '';
		$userData = array();
		
		if ($this->form_validation->run() == FALSE)
		{			
			//echo "fail";			
			
		}
		else
		{
			//echo "pass";
			
			$this->load->model('user_model');			
			
			
			$email = $this->input->post('email');
			$userData['email'] = $email;
				

			$userFetchedData	=	$this->user_model->getUsernameByEmail($userData);

			if(!$userFetchedData)
			{
				//$userErrorMessage = 'We are very sorry, Some system problem occurred, Try after time!';				
				$userErrorMessage = "This email '$email' is not registered yet, Enter your correct email!";				
			}
			else
			{	
				$userErrorFlag = TRUE;
				
				$userErrorMessage = "You asked your username!";	
				
				
				$userData['username'] = $userFetchedData['username'];
				
				
				// send username to provided email
				
				$this->load->library('common_lib');
				$mail = array();
				$mail = $userData;
				
				
				// template name
				$template['tpl_name'] = 'forgot_username.html';
				
				// base url
				$baseurl = site_url() . '/';
				$template['baseurl'] = $baseurl;					

				
				$subject = "'FindAccomodation.com Username'";				
				$template['subject'] = $subject;
				
				$this->common_lib->send_template($mail,$template);
				
			}
			
		}	
		
		
		$userData['signin_error_message'] = $userErrorMessage;
		$userData['signin_error_flag'] = $userErrorFlag;
		
		$this->load->view('header');
		$this->load->view('forgotusername',$userData);
		$this->load->view('footer');
	}
	
	// check email exists in system or not
	function email_check2($emailstr)
	{
		//echo "username_check";
		//$usernameRegex = '/^[a-z\d_]{4,16}$/i';		
		//if (preg_match($usernameRegex, ($usernamestr))) {
		
			// now check this email exist or not in existing users
			$this->load->model('user_model');
			
			$emailExistsFlag	=	$this->user_model->checkEmailExistence($emailstr);
			
			if($emailExistsFlag)
			{				
				return TRUE;			
			}
			else
			{
				$this->form_validation->set_message('email_check2', "This email '$emailstr' is not registered yet, Enter your correct email!");
				return false;
			}
		/*	
		} else {
			$this->form_validation->set_message('username_check', 'Username must start with alpha a-zA-Z');
			return FALSE;
		}
		*/
		
	}		
	
	// user - forgot password
	function forgotpassword()
	{		
		$this->assetlibpro->add_css('css/signin.css');
		
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');

		// fields
		/*
		email
		*/
		
		// set validation rules
		
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|callback_email_check2');

		
		$this->form_validation->set_error_delimiters('<label class="validation">', '</label>');
		
		$userErrorFlag = FALSE;
		$userErrorMessage = '';
		$userData = array();
		
		if ($this->form_validation->run() == FALSE)
		{			
			//echo "fail";			
			
		}
		else
		{
			//echo "pass";
			
			$this->load->model('user_model');			
			
			
			$email = $this->input->post('email');
			$userData['email'] = $email;
				

			$userFetchedData	=	$this->user_model->getUsernameAndPasswordByEmail($userData);

			if(!$userFetchedData)
			{
				//$userErrorMessage = 'We are very sorry, Some system problem occurred, Try after time!';				
				$userErrorMessage = "This email '$email' is not registered yet, Enter your correct email!";				
			}
			else
			{	
				$userErrorFlag = TRUE;
				
				$userErrorMessage = "You asked your password!";				
				
				$userData['username'] = $userFetchedData['username'];				
				
				// send username to provided email
				
				$this->load->library('common_lib');
				$mail = array();
				$mail = $userData;
				
				
				// template name
				$template['tpl_name'] = 'forgot_password.html';
				
				// base url
				$baseurl = site_url() . '/';
				$template['baseurl'] = $baseurl;

				// change password link
				
				$linkdata = array();
				$linkdata['email'] = $userData['email'];				
				$linkdata['user_id'] = $userFetchedData['user_id'];
				$linkdata['username'] = $userFetchedData['username'];
				$linkdata['forgotten_password_code'] = $userFetchedData['forgotten_password_code'];
				
				$forgotten_password_link = $baseurl . "user/resetpassword/" . urlencode(base64_encode(json_encode($linkdata)));				
				$template['forgotten_password_link'] = $forgotten_password_link;				

				
				$subject = "'FindAccomodation.com forgot password'";				
				$template['subject'] = $subject;
				
				$this->common_lib->send_template($mail,$template);
				
			}
			
		}	
		
		
		$userData['signin_error_message'] = $userErrorMessage;
		$userData['signin_error_flag'] = $userErrorFlag;
		
		$this->load->view('header');
		$this->load->view('forgotpassword',$userData);
		$this->load->view('footer');
	}	

	// user - change password
	function resetpassword($encodeeddata='')
	{
		$this->assetlibpro->add_css('css/signin.css');
		
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');	
	
		//$activation_link = $baseurl . "user/resetpassword/" . urlencode(base64_encode(json_encode($linkdata)));
		
		
		$userActivationFlag = FALSE;
		$userActivationMessage = '';
		$decodeddata = '';		
		
		if(!empty($encodeeddata))
		{
		
			$decodeddata = json_decode(base64_decode(urldecode($encodeeddata)));
			/*
			// print_r($decodeddata);			
			// stdClass Object ( [email] => mahesh@nnn.com [username] => mahesh [activation_code] => delW4Z ) 
			
			$decodeddata_array = (array) $decodeddata;
			print_r($decodeddata_array);
			
			echo $decodeddata->email;
			echo "<br>";
			echo $decodeddata->username;
			echo "<br>";
			echo $decodeddata->activation_code;
			*/
			
			if(is_object($decodeddata))
				$decodeddata = (array) $decodeddata;
				
			if(
				is_array($decodeddata) && count($decodeddata)==4
				&& !empty($decodeddata['email'])
				&& !empty($decodeddata['user_id'])
				&& !empty($decodeddata['username'])
				&& !empty($decodeddata['forgotten_password_code'])
				)
			{
				
				$this->load->model('user_model');

				$userFetchedData	=	$this->user_model->getUsernameByEmailPasswordCode($decodeddata);

				if(!$userFetchedData)
				{
					//$userErrorMessage = 'We are very sorry, Some system problem occurred, Try after time!';				
					//$userErrorMessage = "This email '$email' is not registered yet, Enter your correct email!";
					$userActivationMessage = 'Forgotten password code not correct or it is expired!';
				}
				else
				{		

					// get new password then set 

					// fields
					/*
					userpassword
					confirmpassword
					*/
					
					// set validation rules
					
					$this->form_validation->set_rules('userpassword', 'Password', 'trim|required|min_length[6]|max_length[20]|matches[confirmpassword]');
					$this->form_validation->set_rules('confirmpassword', 'Password Confirmation', 'trim|required');
					
					$this->form_validation->set_error_delimiters('<label class="validation">', '</label>');
					
					//$userErrorFlag = FALSE;
					//$userErrorMessage = '';
					//$userData = array();
					
					if ($this->form_validation->run() == TRUE)					
					{		
						
						$userpassword = $this->input->post('userpassword');
						$decodeddata['password'] = $userpassword;
			
						//$activateFlag = $this->user_model->resetpassword($decodeddata);
						//$activateFlag = TRUE;						
						
						//if($activateFlag)
						$userResetData	=	$this->user_model->resetpassword($decodeddata);

						if(!$userResetData)
						{
							$userActivationMessage = 'We are very sorry, Some system problem occurred, Try after time!';
						}
						else
						{						
							$userActivationFlag = TRUE;
							
							// send welcome mail after activation success
							
							$this->load->library('common_lib');
							$mail = array();
							$mail = $decodeddata;
							
							
							// template name
							$template['tpl_name'] = 'forgot_password_success.html';
							
							// base url
							$baseurl = site_url() . '/';
							$template['baseurl'] = $baseurl;							
							
							
							$subject = "FindAccomodation.com new password";				
							$template['subject'] = $subject;
							
							$this->common_lib->send_template($mail,$template);							
							
						}//else{
						//	$userActivationMessage = 'Forgotten password code not correct or it is expired!';	
						//}
						
					}
					
				}				
				
			}else{				
				$userActivationMessage = 'Forgotten password code not present in the url!';	
			}
			
		}else{
			$userActivationMessage = 'Forgotten password code not present in the url!';	
		}
		
		$decodeddata['activation_error_message'] = $userActivationMessage;
		$decodeddata['user_activation_flag'] = $userActivationFlag;
		
		//$this->load->view('signup_success');
		$this->load->view('header');
		$this->load->view('forgot_password_success',$decodeddata);
		$this->load->view('footer');		
	}	
		
	// user - alerts and emails
	
	// user - switch account
	
	// user - update settings 
	
	
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */