<?

/**

*/

class User_model extends Model 
{

	// init 
    function User_model()
    {
        parent::Model();
    }
	
	// encript a string : for passowrd ecryption
	
	function encryptPassword($password)
	{
		return sha1($password);
	}
	
	function getRandomString($length = 6) {
		//$validCharacters = "abcdefghijklmnopqrstuxyvwzABCDEFGHIJKLMNOPQRSTUXYVWZ+-*#&@!?";
		$validCharacters = "0123456789abcdefghijklmnopqrstuxyvwzABCDEFGHIJKLMNOPQRSTUXYVWZ";
		$validCharNumber = strlen($validCharacters);
	 
		$result = "";
	 
		for ($i = 0; $i < $length; $i++) {
			$index = mt_rand(0, $validCharNumber - 1);
			$result .= $validCharacters[$index];
		}
	 
		return $result;
	}

//update adsmessages table, delete deleted msgs
	function update_adsmessages()
	{
	$sql="delete from `adsmessages` where `sent`='0' and `received`='0'";
	$query = $this->db->query($sql);
	}
	
	
//myinbox
	function myinbox($uid,$offset,$limit)
	{
	 $sql1="select * from adsmessages where users_id=$uid AND `received`='1' order BY contact_date desc limit $offset,$limit";
	$query = $this->db->query($sql1);
	//echo "<br>" .$str = $this->db->last_query();exit;
	$results = array();
	
	$idnum=$query->num_rows();
	if ($query->num_rows() > 0)
		{
			$results = $query->result_array();
			
		}
		$query->free_result();
		
		return $results;
	}
	
	
	function myinboxcount_all($uid)
	{
	$user_id=$uid;
	
	$sql1="select * from adsmessages where users_id=$user_id and `received`='1'";
	$query = $this->db->query($sql1);
	//echo "<br>" .$str = $this->db->last_query();exit;
	$results = array();
	if($query){
	if ($query->num_rows() > 0)
		{
			$results = $query->num_rows();
			
		}}
		$query->free_result();
		//print_r($results);exit;
		return $results;
	}
	
	function sentmessagecount_all($uid)
	{
	$user_id=$uid;
	$sql1="select * from adsmessages where sender_user_id=$user_id and `sent`='1'";
	$query = $this->db->query($sql1);
	//echo "<br>" .$str = $this->db->last_query();exit;
	$results = array();
	if($query){
	if ($query->num_rows() > 0)
		{
			$results = $query->num_rows();
			
		}}
		$query->free_result();
		//print_r($results);exit;
		return $results;
	}
	
	function myinboxcount($uid)
	{
	$user_id=$uid;
	$sql1="select * from adsmessages where users_id=$user_id AND adsmessages.read=0 AND adsmessages.received='1'";
	$query = $this->db->query($sql1);
	//echo "<br>" .$str = $this->db->last_query();exit;
	$results = array();
	if($query){
	if ($query->num_rows() > 0)
		{
			$results = $query->num_rows();
			
		}}
		//$query->free_result();
		return $results;
	}
	
	
	//sentmsg 
	function sentmsg_model($uid,$offset,$limit)
	{
	 $sql1="select * from adsmessages where sender_user_id=$uid and `sent`='1' order BY contact_date desc limit $offset,$limit";
	$query = $this->db->query($sql1);
	//echo "<br>" .$str = $this->db->last_query();exit;
	$results = array();
	
	$idnum=$query->num_rows();
	if ($query->num_rows() > 0)
		{
			$results = $query->result_array();
			
		}
		$query->free_result();
		
		return $results;
	}
	
	function thread_model($threadid)
	{
	 $sql1="select * from adsmessages where thread_id=$threadid order BY contact_date asc ";
	$query = $this->db->query($sql1);
	//echo "<br>" .$str = $this->db->last_query();//exit;
	$results = array();
	
	$idnum=$query->num_rows();
	if ($query->num_rows() > 0)
		{
			$results = $query->result_array();
			
		}
		$query->free_result();
		
		return $results;
	}
	
	
	function getsubject($threadid)
	{
	
	$sql1="select subject from adsmessages where thread_id=$threadid order BY contact_date asc limit 0,1";
	$query = $this->db->query($sql1);
	//echo "<br>" .$str = $this->db->last_query();exit;
	$results = array();
	
	if ($query->num_rows() > 0)
		{
			$results = $query->result_array();
		}
		$query->free_result();
		
		//print_r($results);exit;
		return $results;
	}
	
	
	
	//read message
	function readmessage_model($ads_message_id)
	{
	$sql="select * from adsmessages where ads_message_id=$ads_message_id ";
	$query = $this->db->query($sql);
	//echo "<br>" .$str = $this->db->last_query();exit;
	$results = array();
	if ($query->num_rows() > 0)
	{
	$results= $query->result_array();
	}
	if(empty($results)){redirect('user/profile');}
	$userid=$results[0]['users_id'];
	$sqluid="select firstname,lastname from users where user_id=$userid";
	$queryuid = $this->db->query($sqluid);
	//echo "<br>" .$str = $this->db->last_query();exit;
	if ($queryuid->num_rows() > 0)
	{
	$results['rinfo']= $queryuid->result_array();
	}
	
	$adsid=$results[0]['ads_id'];
	$sqlaid="select name from images where ads_id=$adsid limit 0,1";
	$queryadsid = $this->db->query($sqlaid);
	//echo "<br>" .$str = $this->db->last_query();exit;
	if ($queryadsid->num_rows() > 0)
	{
	$results['img_name']= $queryadsid->result_array();
	}
	
	$msgid=$results[0]['ads_message_id'];
	$sqlupdate="UPDATE adsmessages SET `read` = '1' WHERE `adsmessages`.`ads_message_id`=$msgid ";
	$queryupdate = $this->db->query($sqlupdate);
	//echo "<br>" .$str = $this->db->last_query();exit;
	return $results;
	}
	
	//delmsg inbox
	function deletemsg($mid)
	{
	//$sql1="delete from adsmessages where ads_message_id=$mid";
	$sql1="UPDATE adsmessages SET `received` = '0' where ads_message_id=$mid ";
	$query = $this->db->query($sql1);
	//echo "<br>" .$str = $this->db->last_query();exit;
	
	return $query;
	}
	
	//delmsg sent
	function deletemsg_sent($mid)
	{
	//$sql1="delete from adsmessages where ads_message_id=$mid";
	$sql1="UPDATE adsmessages SET `sent` = '0' where ads_message_id=$mid ";
	$query = $this->db->query($sql1);
	//echo "<br>" .$str = $this->db->last_query();exit;
	
	
	}
	
	// multiple delmsg inbox
	function multipledeletemsg($msgid)
	{
	//$sql1="delete from adsmessages where ads_message_id IN ($msgid)";
	$sql1="UPDATE adsmessages SET `received` = '0' where ads_message_id IN ($msgid) ";
	$query = $this->db->query($sql1);
	//echo "<br>" .$str = $this->db->last_query();exit;
	}
	
	// multiple delmsg sent
	function multipledeletemsg_sent($msgid)
	{
	//$sql1="delete from adsmessages where ads_message_id IN ($msgid)";
	$sql1="UPDATE adsmessages SET `sent` = '0' where ads_message_id IN ($msgid) ";
	$query = $this->db->query($sql1);
	//echo "<br>" .$str = $this->db->last_query();exit;
	}
	
	//save search
		function save_search($url,$location)
	{	
	//$id=$_SESSION['user_id'];
	$id=$this->session->userdata('user_id');
	$sql = "INSERT INTO `savedsearches` ( `user_id`,`location`,`url`,`date`) 
							VALUES (?,?,?,?) ";
		
		$this->db->query($sql,array($id,$location,$url,date('Y-m-d H:i:s')));
	}
	
	function saved_search()
	{
	//$id=$_SESSION['user_id'];
	$id=$this->session->userdata('user_id');
	$sql="select * from savedsearches where user_id='$id' order BY date desc";
	
	$query = $this->db->query($sql);
	$result=array();
	if ($query->num_rows() > 0)
	{
	$result= $query->result_array();
	}
	$query->free_result();
	return $result;	
	}
	
	
	//extend ad
	function extendad($id='')
	{	
	
	$sql = "INSERT INTO `adsextendeds` (`ads_id`, `user_id`,`extended_date`) 
							VALUES (?,?,?) ";
		
		$this->db->query($sql,array($id,0,date('Y-m-d H:i:s')));
		
	$slqexp="select expiry_date from ads where ads_id=$id";
	$queryexp = $this->db->query($slqexp);
	if ($queryexp->num_rows() > 0)
	{
	$result= $queryexp->result_array();
	}	
	$expirydate=$result[0]['expiry_date'];
	
	$date=date('Y-m-d H:i:s');
	$sql1="update ads set expiry_date=DATE_ADD($date,INTERVAL 30 DAY) where ads_id=$id";
	$query = $this->db->query($sql1);	
	
	//echo "<br>" .$str = $this->db->last_query();exit;
	}
	
	//delete ad
	function delete_ad($adsid)
	{
	$sql="delete from ads where ads_id='$adsid'";
	
	$query=$this->db->query($sql);
	}
	
	//delete ad images
	function delete_ad_images($adsid)
	{
	$staticurl = $this->config->item('static_url');
	
	$sql1="select name from images where ads_id='$adsid'";
	
	$query1=$this->db->query($sql1);
	$result=array();
	if($query1->num_rows()>0)
		{
			$numrows=$query1->num_rows();
			$result=$query1->result_array();
	/*		echo '<pre>'; print_r($result); echo '</pre><br>';
			echo $numrows; exit;
	*/		
			for($i=0;$i<=$numrows-1;$i++)
			{
			unlink('static/ads_upload/'.$result[$i]['name']);
			unlink('static/ads_upload/img1_'.$result[$i]['name']);			
			unlink('static/ads_upload/img2_'.$result[$i]['name']);			
			unlink('static/ads_upload/img3_'.$result[$i]['name']);			
			}
		}
	$sql="delete from images where ads_id='$adsid'";
	$query=$this->db->query($sql);
	}
	
	//activate ad
	function activatead($id='')
	{
	$sql1="update ads set status='1' where ads_id=$id";
	$query = $this->db->query($sql1);
	//echo "<br>" .$str = $this->db->last_query();exit;
	
	return $query;
	}
	
	
	//deactivate
	function deactivatead($id='')
	{
	$sql1="update ads set status='0' where ads_id=$id";
	$query = $this->db->query($sql1);
	//echo "<br>" .$str = $this->db->last_query();exit;
	
	return $query;
	}
	
	//Get title
	function get_title($id='')
	{
	$sql1="select title from ads where ads_id=$id";
	$query = $this->db->query($sql1);
	//echo "<br>" .$str = $this->db->last_query();exit;
	$results= array();
	if ($query->num_rows() > 0)
		{
			$results = $query->result_array();
			
		}
		$query->free_result();
	return $results;
	}
	
	
	//reply
	function reply_model($replydata)
	{
	
	$sql = "INSERT INTO `adsmessages` (`ads_id`, `users_id`,`sender_user_id`,`firstname`,`r_name`, `contact_email`,`r_email`, `subject`, `message`, `contact_date`, `read`,`thread_id`) 
							VALUES (?,?,?,?,?,?,?,?,?,?,?,?) ";
		
		$this->db->query($sql,array($replydata['ads_id'],$replydata['user_id'],$replydata['sender_user_id'],$replydata['firstname'],$replydata['r_name'],$replydata['contact_email'],$replydata['r_email'],$replydata['subject'],$replydata['message'],date('Y-m-d H:i:s'),0,$replydata['thread_id']));
	//echo "<br>" .$str = $this->db->last_query();exit;
	
	}
	
	//reply_info
	function reply_info($uid)
	{
	
	$sql = "select user_id,firstname,lastname,email from users where user_id=$uid";
	$query = $this->db->query($sql);
		
	//echo "<br>" .$str = $this->db->last_query();exit;
	$results = array();
	if ($query->num_rows() > 0)
		{
			$results = $query->result_array();
			
		}
		$query->free_result();
		//print_r($results);exit;
		return $results;
	}
	
	
	
	// signup new user
    function signup($userData)
    {
		$userData['encpassword'] = $this->encryptPassword($userData['password']);	
		$userData['activation_code'] = $this->getRandomString();
		$sql = "INSERT INTO `users` (`firstname`,`lastname`, `password`, `email`, `user_type`, `activation_code`) 
				VALUES (?,?,?,?,?,?)
				/*Signup new user*/";
		//echo $sql;
		$this->db->query($sql,array($userData['firstname'],$userData['lastname'],$userData['encpassword'],$userData['email'],3,$userData['activation_code']));
		//echo $str = $this->db->last_query();
		$affectedFlag = $this->db->affected_rows();	
		
		if($affectedFlag>0)
			return $userData;
		else
			return $affectedFlag;
		
    }	
	
	// check username existence
    function checkUserNameExistence($username)
    {
		/*
		
		$sql = "INSERT INTO mytable (title, name) 
				VALUES (".$this->db->escape($title).", ".$this->db->escape($name).")";

		$this->db->query($sql);

		$affectedFlag = $this->db->affected_rows();	
		
		*/
		$sql = "SELECT `user_id` FROM `users` where `username` = ?
				/*Check UserName Exists or not, $username */";
		//echo $sql;
		$query	=	$this->db->query($sql,array($username));
		//echo $str = $this->db->last_query();
		if ($query->num_rows() > 0)
		{		
			return true;
		}
		else
		{
			return false;
		}
    }	
	
	// check email existence
    function checkEmailExistence($email)
    {
		
		$sql = "
				SELECT `user_id` FROM `users` where `email` = ?
				/*Check Email Exists or not, $email */";
		//echo $sql;
		$query	=	$this->db->query($sql,array($email));
		//echo $str = $this->db->last_query();
		if ($query->num_rows() > 0)
		{		
			return true;
		}
		else
		{
			return false;
		}
    }	
		
	// user signin
    function signin($userData)
    {
		$userData['encpassword'] = $this->encryptPassword($userData['password']);
		
		$sql = "
				SELECT `user_id`,`firstname`,`lastname`, `email`, `sharing_type`, `user_type`, `created_on`, 
				`last_login`, `news_letter`, `matching_alerts`, `status` 
				FROM `users` where `email` = ? and `password` = ?
				/*Signin Check email and passowrd*/";
		//echo $sql;
		$query	=	$this->db->query($sql,array($userData['email'],$userData['encpassword']));
		//echo $str = $this->db->last_query();
		if ($query->num_rows() > 0)
		{		
			
			$row = $query->row_array(); 
			$date=date('Y-m-d H:i:s');
			$sql = "UPDATE `users` set `last_login`=$date
					where `user_id`=?
					/*Reset last login after user signedin*/";
			//echo $sql;
			$this->db->query($sql,array($row['user_id']));			
			
			return $row;
		}
		else
		{
			return false;
		}
    }	
	
	//saving cookie
	function cookie($cookieemail,$cookieuserid)
	{	
	
	$sql = "INSERT INTO `cookies` (user_id,cookie_name) 
							VALUES (?,?) ";
		
		$this->db->query($sql,array($cookieuserid,$cookieemail));
	
	//echo "<br>" .$str = $this->db->last_query();exit;
	}
	
	//checking cookie
	function cookie_check($cookie1)
	{	
	
	$sql = "select * from cookies where cookie_name='$cookie1'";
		
		$query=$this->db->query($sql);
	
	//echo "<br>" .$str = $this->db->last_query();exit;
	if($query){
	if ($query->num_rows() > 0)
		{		
			$row = $query->row_array(); 
			
		return $row;
		}
		else
		{
			return false;
		}}
	
	}
	
	
	//checking cookie
	function cookie2_check($cookie2)
	{	
	
	$sql = "select * from users where user_id='$cookie2' LIMIT 0,1";
		
		$query=$this->db->query($sql);
	
	//echo "<br>" .$str = $this->db->last_query();exit;
	
	if ($query->num_rows() > 0)
		{		
			$row = $query->row_array(); 
		
		return $row;
		}
		else
		{
			return false;
		}
	
	}
	
	
	
	// activate user
    function activate($userData)
    {		
		
		$sql = "UPDATE `users` set `status`='1' 
				where `email`=? and `activation_code`=?
				/*Activate user by email, username and activation code*/";
		//echo $sql;
		$this->db->query($sql,array($userData['email'],$userData['activation_code']));
		//echo $str = $this->db->last_query();
		$affectedFlag = $this->db->affected_rows();			
		
		if($affectedFlag>0)
			return true;
		else
			return $affectedFlag;
		
    }
	
	// Get Username By Email
    function getUsernameByEmail($userData)
    {
		$sql = "
				SELECT `username` FROM `users` where `email` = ?
				/*Get Username By Email*/";
		//echo $sql;
		$query	=	$this->db->query($sql,array($userData['email']));
		//echo $str = $this->db->last_query();
		if ($query->num_rows() > 0)
		{					
			$row = $query->row_array(); 			
			return $row;
		}
		else
		{
			return false;
		}
    }	
	
	// Get Username By Email
    function getUsernameAndPasswordByEmail($userData)
    {
		$sql = "
				SELECT `user_id`, `username` FROM `users` where `email` = ?
				/*Get Username By Email for forgot password*/";
		//echo $sql;
		$query	=	$this->db->query($sql,array($userData['email']));
		//echo $str = $this->db->last_query();
		if ($query->num_rows() > 0)
		{					
			$row = $query->row_array(); 

			// set forgotten_password_code

			$forgotten_password_code = $this->getRandomString();	
			
			$row['forgotten_password_code'] = $forgotten_password_code;
			
			$sql = "UPDATE `users` set `forgotten_password_code`=? 
					where `email`=?
					/*set forgotten_password_code by email*/";
			//echo $sql;
			$this->db->query($sql,array($forgotten_password_code, $userData['email']));
			//echo $str = $this->db->last_query();
			$affectedFlag = $this->db->affected_rows();			
			
			if($affectedFlag>0)
				return $row;
			else
				return $affectedFlag;
			
		}
		else
		{
			return false;
		}
    }	

	// Get Username By Email and forgotten password code
    function getUsernameByEmailPasswordCode($userData)
    {
		$sql = "
				SELECT `username` FROM `users` where `user_id` = ? and `username` = ? and `email` = ? and `forgotten_password_code` = ? 
				/*Get Username By Email and forgotten password code*/";
		//echo $sql;
		$query	=	$this->db->query($sql,array($userData['user_id'],$userData['username'],$userData['email'],$userData['forgotten_password_code']));
		//echo $str = $this->db->last_query();
		if ($query->num_rows() > 0)
		{					
			$row = $query->row_array(); 			
			return $row;
		}
		else
		{
			return false;
		}
    }
	
	// reset new password
    function resetpassword($userData)
    {		
	
		$userData['encpassword'] = $this->encryptPassword($userData['password']);	
		
		$sql = "UPDATE `users` set `password`=?
				where `user_id`=? and `username`=? and `email`=? and `forgotten_password_code`=?
				/*Reset password by email, username and forgotten password code*/";
		//echo $sql;
		$this->db->query($sql,array($userData['encpassword'],$userData['user_id'],$userData['username'],$userData['email'],$userData['forgotten_password_code']));
		//echo $str = $this->db->last_query();
		$affectedFlag = $this->db->affected_rows();			
		
		if($affectedFlag>0)
			return $userData;
		else
			return $affectedFlag;
		
    }
	
	
	// update username
    function updateUsername($uid,$username)
    {			
		
		$sql = "UPDATE `users` set `username`=?
				where `user_id`=? 
				/*Update username by user id*/";
		//echo $sql;
		$this->db->query($sql,array($username,$uid));
		//echo $str = $this->db->last_query();
		$affectedFlag = $this->db->affected_rows();			
		
		if($affectedFlag>0)
			return true;
		else
			return $affectedFlag;
		
    }	

	// update password
    function updatePassword($uid,$currentpassword,$newpassword)
    {			
		
		$currentpassword = $this->encryptPassword($currentpassword);
		$newpassword = $this->encryptPassword($newpassword);
		
		$sql = "UPDATE `users` set `password` = ?
				where `user_id`=? and password = ?
				/*Update password by user id and current password*/";
		//echo $sql;
		$this->db->query($sql,array($newpassword, $uid, $currentpassword));
		//echo $str = $this->db->last_query();
		$affectedFlag = $this->db->affected_rows();			
		
		if($affectedFlag>0)
			return true;
		else
			return $affectedFlag;
		
    }
	
	
	// update email
    function updateEmail($uid,$email)
    {			
		
		$sql = "UPDATE `users` set `email`=?
				where `user_id`=? 
				/*Update email by user id*/";
		//echo $sql;
		$this->db->query($sql,array($email,$uid));
		//echo $str = $this->db->last_query();
		$affectedFlag = $this->db->affected_rows();			
		
		if($affectedFlag>0)
			return true;
		else
			return $affectedFlag;
		
    }
	
	
	// switch account
  /* function switchAccount($uid,$sharing_type)
    {			
		
		$sql = "UPDATE `users` set `sharing_type`=?
				where `user_id`=? 
				";
		//echo $sql;
		$this->db->query($sql,array($sharing_type,$uid));
		//echo $str = $this->db->last_query();
		$affectedFlag = $this->db->affected_rows();			
		
		if($affectedFlag>0)
			return true;
		else
			return $affectedFlag;
		
    }*/

	// update news and alerts
    function updateNewsAndAlerts($uid,$yesNo1, $yesNo2)
    {			
		if(!isset($yesNo1))
			$yesNo1 = 0;
		if(!isset($yesNo2))
			$yesNo2 = 0;		
		$sql = "UPDATE `users` set `news_letter`=?, `matching_alerts`=?
				where `user_id`=? 
				/*Update news and alerts by user id*/";
		//echo $sql;
		$this->db->query($sql,array($yesNo2,$yesNo1,$uid));
		//echo $str = $this->db->last_query();exit;
		$affectedFlag = $this->db->affected_rows();			
		return true;
		/*
		if($affectedFlag>0)
			return true;
		else
			return $affectedFlag;
		*/
		
    }		
	
	
	// get locations list
/*	function locations($data=array())
	{
		$like = '';
		if	   ($data['match'] == "starts")		$like = " like '".$data['data']."%' ";
		elseif ($data['match'] == "ends")		$like = " like '%".$data['data']."' ";
		elseif ($data['match'] == "contains")   $like = " like '%".$data['data']."%' ";
		
		$limit = 10;
		
		if(!empty($data['limit']))
			$limit = $data['limit'];
		if(!empty($like))
			$sql = "select * from `friends` where `name` ".$like." limit ".$limit;	
		else
			$sql = "select * from `friends` limit ".$limit;
			
		
		
		
		
		$query = $this->db->query($sql);
		
		
		$results = array();
		
		if ($query->num_rows() > 0)
		{
			$results = $query->result_array();
			
		}
		$query->free_result();		
		
		return $results;
		
	} */// end of locations

	
	// get locations list
	function locations2($data=array())
	{
	
		$like = '';
		/*
		if	   ($data['match'] == "starts")		$like .= " like '".$data['data']."%' ";
		elseif ($data['match'] == "ends")		$like .= " like '%".$data['data']."' ";
		elseif ($data['match'] == "contains")   $like .= " like '%".$data['data']."%' ";
		*/
		if(!empty($data['data']))
		{
			$seachStr = $data['data'];
			if(is_numeric($seachStr))
			{
				//$like .= " `pcode` like '%" . $seachStr . "%' ";
				$like .= " `Zip` like '%" . $seachStr . "%' ";
			}
			else
			{
			/*	$seachStrsInt = intval($seachStr);
					
				if( !empty($seachStrsInt) && $like=='' )
					//$like .= " `pcode` like '%" . $seachStrsInt . "%' ";					
					$like .= " `Zip` like '%" . $seachStrsInt . "%' ";					
				else if(! empty($seachStrsInt) )	
					//$like .= " or `pcode` like '%" . $seachStrsInt . "%' ";	
					$like .= " or `Zip` like '%" . $seachStrsInt . "%' ";	
			*/		
				//$seachStrs1 = explode(' ',$seachStr);
					$seachStrs1=$seachStr;
				//print_r($seachStrs1);
				//print_r($seachStrs1);				
				if(!empty($seachStrs1) && is_array($seachStrs1) && count($seachStrs1)>0)
				{
					/*foreach($seachStrs1 as $seachStrs11)
					{*/
						$seachStrs11 = trim($seachStrs11);
						if(!empty($seachStrs11))
						{
							if(is_numeric($seachStrs11))
							{
								if( $like=='' )
									//$like .= " `pcode` like '%" . $seachStrs11 . "%' ";
									$like .= " `Zip` like '%" . $seachStrs11 . "%' ";
								else
									//$like .= " or `pcode` like '%" . $seachStrs11 . "%' ";
									$like .= " or `Zip` like '%" . $seachStrs11 . "%' ";
							}
							else
							{				
								if( $like=='' )
									//$like .= " `locality` like '%" . $seachStrs11 . "%' ";
									$like .= " `City` like '" . $seachStrs11 . "%' ";
								else
									//$like .= " or `locality` like '%" . $seachStrs11 . "%' ";
									$like .= " or `City` like '" . $seachStrs11 . "%' ";
								if( $like=='' )
									$like .= " `ISO2` like '___" . $seachStrs11 . "%' ";						
								else
									$like .= " or `ISO2` like '___" . $seachStrs11 . "%' ";						
									
							}
						}
					//}
				}
				
				//$seachStrs2 = explode(', ',$seachStr);
				//print_r($seachStrs2);
				if(!empty($seachStrs2) && is_array($seachStrs2) && count($seachStrs2)>1)
				{
					//foreach($seachStrs2 as $seachStrs22)
					//{
						$seachStrs22 = trim($seachStrs22);
						if(!empty($seachStrs22))
						{
							if(is_numeric($seachStrs22))
							{
								if( $like=='' )
									//$like .= " `pcode` like '%" . $seachStrs22 . "%' ";
									$like .= " `Zip` like '%" . $seachStrs22 . "%' ";
								else
									//$like .= " or `pcode` like '%" . $seachStrs22 . "%' ";
									$like .= " or `Zip` like '%" . $seachStrs22 . "%' ";
							}
							else
							{				
								if( $like=='' )
									//$like .= " `locality` like '%" . $seachStrs22 . "%' ";
									$like .= " `City` like '" . $seachStrs22 . "%' ";
								//else
									//$like .= " or `locality` like '%" . $seachStrs22 . "%' ";
									$like .= " or `City` like '" . $seachStrs22 . "%' ";
								if( $like=='' )
									$like .= " or `ISO2` like '___" . $seachStrs22 . "%' ";						
								else
									$like .= " or `ISO2` like '___" . $seachStrs22 . "%' ";		
							}
						}
					}
				}		
				
				 if( $like=='' )
					//$like .= " `locality` like '%" . $seachStr . "%' ";
					$like .= " `City` like '" . $seachStr . "%' ";
				//else
					//$like .= " or `locality` like '%" . $seachStr . "%' ";
					$like .= " or `City` like '" . $seachStr . "%' ";
				if( $like=='' )
					$like .= " `ISO2` like '___" . $seachStr . "%' ";
				else
					$like .= " or `ISO2` like '___" . $seachStr . "%' ";
					
			//}
		}	
		//else
			//$seachStr = '';
			
		
		$limit = 10;
		
		if(!empty($data['limit']))
			$limit = $data['limit'];
		if(!empty($like))
			//$sql = "select * from `GeoPC` where " . $like . " limit " . $limit;	
			$sql="SELECT * FROM `GeoPC` WHERE " . $like . " limit " . $limit;
		else
			$sql = "select * from `GeoPC` limit " . $limit;
			
		//$sql = " SELECT * FROM `locations` ";
		
		//$sql .= " /*get locations list*/ ";
		//echo $sql;
		
		$query = $this->db->query($sql);
		
		
		//echo $str = $this->db->last_query();
		
		$results = array();
		
		if ($query->num_rows() > 0)
		{
			$results = $query->result_array();
			
		}
		$query->free_result();		
		
		
		
		return $results;
		
		
	} // end of locations


	////post code list start
	function postcode($data=array())
	{
		if(!empty($data['data']))
		{
			$seachStr = $data['data'];
		$like = '';
		
		$like .= " `Zip` like '" . $seachStr . "%' ";	
		}
		$limit = 10;
		
		if(!empty($data['limit']))
			$limit = $data['limit'];
		if(!empty($like))
			//$sql = "select * from `GeoPC` where " . $like . " limit " . $limit;	
			$sql="SELECT * FROM `GeoPC` WHERE " . $like . " limit " . $limit;
		else
			$sql = "select * from `GeoPC` limit " . $limit;
			
		//$sql = " SELECT * FROM `locations` ";
		
		//$sql .= " /*get locations list*/ ";
		//echo $sql;
		
		$query = $this->db->query($sql);
		
		
		//echo $str = $this->db->last_query();
		$results = array();
		
		if ($query->num_rows() > 0)
		{
			$results = $query->result_array();
			
		}
		$query->free_result();		
		
		
		
		return $results;
		
		
	}
	
	
	}
