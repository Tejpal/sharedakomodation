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
	
	// signup new user
    function signup($userData)
    {
		
		$userData['encpassword'] = $this->encryptPassword($userData['password']);
		
		$userData['activation_code'] = $this->getRandomString();
		
		
		$sql = "INSERT INTO `users` (`username`, `password`, `email`, `sharing_type`, `user_type`, `activation_code`) 
				VALUES (?,?,?,?,?,?)
				/*Signup new user*/";
		//echo $sql;
		$this->db->query($sql,array($userData['username'],$userData['encpassword'],$userData['email'],$userData['sharing_type'],3,$userData['activation_code']));
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
		$sql = "
				SELECT `user_id` FROM `users` where `username` = ?
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
		/*
		
		$sql = "INSERT INTO mytable (title, name) 
				VALUES (".$this->db->escape($title).", ".$this->db->escape($name).")";

		$this->db->query($sql);

		$affectedFlag = $this->db->affected_rows();	
		
		*/
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
				SELECT `user_id`, `username`, `email`, `sharing_type`, `user_type`, `created_on`, 
				`last_login`, `news_letter`, `matching_alerts`, `status` 
				FROM `users` where `username` = ? and `password` = ?
				/*Signin Check username and passowrd*/";
		//echo $sql;
		$query	=	$this->db->query($sql,array($userData['username'],$userData['encpassword']));
		//echo $str = $this->db->last_query();
		if ($query->num_rows() > 0)
		{		
			
			$row = $query->row_array(); 
			
			$sql = "UPDATE `users` set `last_login`=now()
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
	
	// activate user
    function activate($userData)
    {		
		
		$sql = "UPDATE `users` set `status`='1' 
				where `username`=? and `email`=? and `activation_code`=?
				/*Activate user by email, username and activation code*/";
		//echo $sql;
		$this->db->query($sql,array($userData['username'],$userData['email'],$userData['activation_code']));
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
    function switchAccount($uid,$sharing_type)
    {			
		
		$sql = "UPDATE `users` set `sharing_type`=?
				where `user_id`=? 
				/*Update sharing type by user id*/";
		//echo $sql;
		$this->db->query($sql,array($sharing_type,$uid));
		//echo $str = $this->db->last_query();
		$affectedFlag = $this->db->affected_rows();			
		
		if($affectedFlag>0)
			return true;
		else
			return $affectedFlag;
		
    }

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
		//echo $str = $this->db->last_query();
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
	function locations($data=array())
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
			
		//$sql = " SELECT * FROM `locations` ";
		
		$sql .= " /*get locations list*/ ";
		
		$query = $this->db->query($sql);
		
		//echo $str = $this->db->last_query();
		$results = array();
		
		if ($query->num_rows() > 0)
		{
			$results = $query->result_array();
			
		}
		$query->free_result();		
		
		return $results;
		
	} // end of images		
	
}
