<?

class Ads_model extends Model 
{

	// init 
    function Ads_model()
    {
        parent::Model();
    }

	// generate random string
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
	
	
	
	//submittest start
	function submit_ad($adsData,$code)
	{
	//print_r($adsData);exit;
	if(isset($adsData['ads_id'])){$ads_id=$adsData['ads_id'];}
	if($adsData['editFlag']==1){$this->session->set_userdata('editFlag', $adsData['editFlag']);}
	
		if($code=='stepone')
			{
			
			//if($adsData['editFlag']==0 && !isset($this->session->userdata('ads_id')))
			if($adsData['editFlag']==0 )
				{
					$sql = "INSERT INTO `ads` 
					(	`ads_id` ,`user_id` ,`rent`, `rent_type`, `bond`, `property_type`,`bed_rooms`,`parking`,`availability`,`min_stay`,`max_stay`,`street_address`,`city`,`state`,`postal_code`,`bills`,`furnished`, `expiry_date`, `addedtime`,`updated_date`,`sharing_type`) 
					VALUES (NULL,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?
						,?,?,?)
					/*Create new ad*/";
					//$user_id=$_SESSION['user_id'];
					$user_id=$this->session->userdata('user_id');
					$this->db->query($sql,array($user_id,$adsData['rent'],$adsData['rentDuration'],$adsData['bondSecurity'],$adsData['propertyType'],$adsData['bedrooms'],$adsData['parking'],$adsData['availability'],$adsData['minStay'],$adsData['maxStay'],$adsData['streetAddress'],$adsData['suburb'],$adsData['state'],$adsData['postCode'],$adsData['utilBills'],$adsData['furnish'],$adsData['expiry_date'],$adsData['date'],$adsData['date'],'1'));
				
					$ads_id=mysql_insert_id(); 
					
					
					if($adsData['utilBills']==1)
					{	
						if(!empty($adsData['utilBillsList']))
							{
					
						$utilBillsList = $adsData['utilBillsList'];
						if( !empty($utilBillsList) && is_array($utilBillsList) && count($utilBillsList)>0)
							{
								
								$indx = 0;	
								$meta_type = 1;
								foreach($utilBillsList as $utilBillsList2)
									{
									$indx++;
									$sql2 = "INSERT INTO `adsmetadata` 
								(`ads_meta_id`, `meta_type`, `ads_id`, `name`, `value`, `index`) 
								VALUES (NULL, $meta_type, ?, '$utilBillsList2', '$utilBillsList2', $indx)";						
									$this->db->query($sql2,array($ads_id));			
								
									}
									
							//	echo "<br>" .$str = $this->db->last_query();exit;
							}	
						}
					}
				
					if($adsData['furnish']==1)
					{			
						// furnishList
						if(!empty($adsData['furnishList']))
						{
						$furnishList = $adsData['furnishList'];
				
						if( !empty($furnishList) && is_array($furnishList) && count($furnishList)>0)
							{							
							
								$indx = 0;	
								$meta_type = 2;
								foreach($furnishList as $furnishList2)
									{
									$indx++;
									$sql2 = "INSERT INTO `adsmetadata` 
								(`ads_meta_id`, `meta_type`, `ads_id`, `name`, `value`, `index`) 
								VALUES (NULL, $meta_type, ?, '$furnishList2', '$furnishList2', $indx)";						
									
									$this->db->query($sql2,array($ads_id));
									}
									
								//echo "<br>" .$str = $this->db->last_query();
							}	
						}
					}
				
				}

				//echo "<br>" .$str = $this->db->last_query();
				
			//elseif($adsData['editFlag']==1 || isset($this->session->userdata('ads_id')))
			elseif($adsData['editFlag']==1 || $adsData['editFlag']==2 )
				{
						//if(isset($this->session->userdata('ads_id'))) {$ads_id=$this->session->userdata('ads_id');}
				
					$sql="UPDATE `ads` SET `rent`=?,`rent_type`=?,`bond`=?,`property_type`=?,`bed_rooms`=?,`parking`=?,`availability`=?,`min_stay`=?,`max_stay`=?,`street_address`=?,`city`=?,`state`=?,`postal_code`=?,`bills`=?,`furnished`=?,`updated_date`=? WHERE `ads_id`=?";
					$this->db->query($sql,array($adsData['rent'],$adsData['rentDuration'],$adsData['bondSecurity'],$adsData['propertyType'],$adsData['bedrooms'],$adsData['parking'],$adsData['availability'],$adsData['minStay'],$adsData['maxStay'],$adsData['streetAddress'],$adsData['suburb'],$adsData['state'],$adsData['postCode'],$adsData['utilBills'],$adsData['furnish'],$adsData['date'],$ads_id));
				
					$sql_delete_metadata="delete from `adsmetadata` where `ads_id`=$ads_id";
					$this->db->query($sql_delete_metadata);
			

					if($adsData['utilBills']==1)
						{
							if(!empty($adsData['utilBillsList']))
							{
							$utilBillsList = $adsData['utilBillsList'];
							if( !empty($utilBillsList) && is_array($utilBillsList) && count($utilBillsList)>0)
								{
							
									$indx = 0;	
									$meta_type = 1;
									foreach($utilBillsList as $utilBillsList2)
										{
										$indx++;
										$sql2 = "INSERT INTO `adsmetadata` 
									(`ads_meta_id`, `meta_type`, `ads_id`, `name`, `value`, `index`) 
									VALUES (NULL, $meta_type, ?, '$utilBillsList2', '$utilBillsList2', $indx)";						
									
									$this->db->query($sql2,array($ads_id));					
									}
								
									//echo "<br>" .$str = $this->db->last_query();
								}
							}
						}	



					if($adsData['furnish']==1)
						{			
							// furnishList
							if(!empty($adsData['furnishList']))
							{
							$furnishList = $adsData['furnishList'];
				
							if( !empty($furnishList) && is_array($furnishList) && count($furnishList)>0)
								{							
								
									$indx = 0;	
									$meta_type = 2;
									foreach($furnishList as $furnishList2)
										{
										$indx++;
										$sql2 = "INSERT INTO `adsmetadata` 
									(`ads_meta_id`, `meta_type`, `ads_id`, `name`, `value`, `index`) 
									VALUES (NULL, $meta_type, ?, '$furnishList2', '$furnishList2', $indx)";						
									
									$this->db->query($sql2,array($ads_id));			
									}
								//echo "<br>" .$str = $this->db->last_query();
								}
							}	
						}				
				}
			//echo "<br>" .$str = $this->db->last_query();
			$_SESSION['ads_id']=$ads_id;
			$this->session->set_userdata('ads_id', $ads_id);
			
			}
			
			
			
		//$ads_id=$_SESSION['ads_id'];
		$ads_id=$this->session->userdata('ads_id');
			
		if($code=='steptwo')
			{
			$sql="UPDATE `ads` SET `first_name`=?, `last_name`=?,`phone`=?, `phone_visibility`=?, `email`=?, `email_visibility`=?  WHERE `ads_id`=?";
			$this->db->query($sql,array($adsData['firstName'],$adsData['lastName'],$adsData['phoneNo'],$adsData['phoneVisible'],$adsData['emailId'],$adsData['emailVisible'],$ads_id));
			
			}
		if($code=='stepthree')
		
			{
			
			$comma_separated_communities= implode(",", $adsData['communities']);
			$sql="UPDATE `ads` SET `gender`=?, `smoker`=?, `age`=?, `orientation`=?, `diet`=?,`occupation`=?,`community`='$comma_separated_communities'  WHERE `ads_id`=? ";
			$this->db->query($sql,array($adsData['gender'],$adsData['smoker'],$adsData['age'],$adsData['orientation'],$adsData['diet'],$adsData['occupation'],$ads_id));
			}
			
			
			
			if($code=='stepfour')
			{
			$sql="UPDATE `ads` SET `title`=?,`description`=?,`bestfeature1`=?,`bestfeature2`=?,`status`=? WHERE `ads_id`=?";
			$this->db->query($sql,array($adsData['title'],$adsData['adDescription'],$adsData['propFeature1'],$adsData['propFeature2'],'1',$ads_id));
			$this->session->unset_userdata('ads_id');
			//echo "<br>" .$str = $this->db->last_query();
			
			}
			//echo "<br>" .$str = $this->db->last_query();
			
	}
	//submittest end
	
	//submit ad finder start
	function submit_ad_finder($adsData,$code)
	{
	//print_r($adsData);exit;
	if(isset($adsData['ads_id'])){$ads_id=$adsData['ads_id'];}
	if($adsData['editFlag']==1){$this->session->set_userdata('editFlag', $adsData['editFlag']);}
	
		if($code=='stepone')
			{
			
			//if($adsData['editFlag']==0 && !isset($this->session->userdata('ads_id')))
			if($adsData['editFlag']==0 )
				{
					$sql = "INSERT INTO `ads` 
					(	`ads_id` ,`user_id` ,`rent`, `rent_type`, `bond`, `property_type`,`bed_rooms`,`parking`,`availability`,`min_stay`,`max_stay`,`street_address`,`city`,`state`,`postal_code`,`bills`,`furnished`, `expiry_date`, `addedtime`,`updated_date`,`sharing_type`) 
					VALUES (NULL,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?
						,?,?,?)
					/*Create new ad*/";
					//$user_id=$_SESSION['user_id'];
					$user_id=$this->session->userdata('user_id');
					$this->db->query($sql,array($user_id,$adsData['rent'],$adsData['rentDuration'],$adsData['bondSecurity'],$adsData['propertyType'],$adsData['bedrooms'],$adsData['parking'],$adsData['availability'],$adsData['minStay'],$adsData['maxStay'],$adsData['streetAddress'],$adsData['suburb'],$adsData['state'],$adsData['postCode'],$adsData['utilBills'],$adsData['furnish'],$adsData['expiry_date'],$adsData['date'],$adsData['date'],'0'));
				
					$ads_id=mysql_insert_id(); 
					
					
					if($adsData['utilBills']==1)
					{	
						if(!empty($adsData['utilBillsList']))
							{
					
						$utilBillsList = $adsData['utilBillsList'];
						if( !empty($utilBillsList) && is_array($utilBillsList) && count($utilBillsList)>0)
							{
								
								$indx = 0;	
								$meta_type = 1;
								foreach($utilBillsList as $utilBillsList2)
									{
									$indx++;
									$sql2 = "INSERT INTO `adsmetadata` 
								(`ads_meta_id`, `meta_type`, `ads_id`, `name`, `value`, `index`) 
								VALUES (NULL, $meta_type, ?, '$utilBillsList2', '$utilBillsList2', $indx)";						
									$this->db->query($sql2,array($ads_id));			
								
									}
									
							//	echo "<br>" .$str = $this->db->last_query();exit;
							}	
						}
					}
				
					if($adsData['furnish']==1)
					{			
						// furnishList
						if(!empty($adsData['furnishList']))
						{
						$furnishList = $adsData['furnishList'];
				
						if( !empty($furnishList) && is_array($furnishList) && count($furnishList)>0)
							{							
							
								$indx = 0;	
								$meta_type = 2;
								foreach($furnishList as $furnishList2)
									{
									$indx++;
									$sql2 = "INSERT INTO `adsmetadata` 
								(`ads_meta_id`, `meta_type`, `ads_id`, `name`, `value`, `index`) 
								VALUES (NULL, $meta_type, ?, '$furnishList2', '$furnishList2', $indx)";						
									
									$this->db->query($sql2,array($ads_id));
									}
									
								//echo "<br>" .$str = $this->db->last_query();
							}	
						}
					}
				
				}

				//echo "<br>" .$str = $this->db->last_query();
				
			//elseif($adsData['editFlag']==1 || isset($this->session->userdata('ads_id')))
			elseif($adsData['editFlag']==1 || $adsData['editFlag']==2 )
				{
						//if(isset($this->session->userdata('ads_id'))) {$ads_id=$this->session->userdata('ads_id');}
				
					$sql="UPDATE `ads` SET `rent`=?,`rent_type`=?,`bond`=?,`property_type`=?,`bed_rooms`=?,`parking`=?,`availability`=?,`min_stay`=?,`max_stay`=?,`street_address`=?,`city`=?,`state`=?,`postal_code`=?,`bills`=?,`furnished`=?,`updated_date`=? WHERE `ads_id`=?";
					$this->db->query($sql,array($adsData['rent'],$adsData['rentDuration'],$adsData['bondSecurity'],$adsData['propertyType'],$adsData['bedrooms'],$adsData['parking'],$adsData['availability'],$adsData['minStay'],$adsData['maxStay'],$adsData['streetAddress'],$adsData['suburb'],$adsData['state'],$adsData['postCode'],$adsData['utilBills'],$adsData['furnish'],$adsData['date'],$ads_id));
				
					$sql_delete_metadata="delete from `adsmetadata` where `ads_id`=$ads_id";
					$this->db->query($sql_delete_metadata);
			

					if($adsData['utilBills']==1)
						{
							if(!empty($adsData['utilBillsList']))
							{
							$utilBillsList = $adsData['utilBillsList'];
							if( !empty($utilBillsList) && is_array($utilBillsList) && count($utilBillsList)>0)
								{
							
									$indx = 0;	
									$meta_type = 1;
									foreach($utilBillsList as $utilBillsList2)
										{
										$indx++;
										$sql2 = "INSERT INTO `adsmetadata` 
									(`ads_meta_id`, `meta_type`, `ads_id`, `name`, `value`, `index`) 
									VALUES (NULL, $meta_type, ?, '$utilBillsList2', '$utilBillsList2', $indx)";						
									
									$this->db->query($sql2,array($ads_id));					
									}
								
									//echo "<br>" .$str = $this->db->last_query();
								}
							}
						}	



					if($adsData['furnish']==1)
						{			
							// furnishList
							if(!empty($adsData['furnishList']))
							{
							$furnishList = $adsData['furnishList'];
				
							if( !empty($furnishList) && is_array($furnishList) && count($furnishList)>0)
								{							
								
									$indx = 0;	
									$meta_type = 2;
									foreach($furnishList as $furnishList2)
										{
										$indx++;
										$sql2 = "INSERT INTO `adsmetadata` 
									(`ads_meta_id`, `meta_type`, `ads_id`, `name`, `value`, `index`) 
									VALUES (NULL, $meta_type, ?, '$furnishList2', '$furnishList2', $indx)";						
									
									$this->db->query($sql2,array($ads_id));			
									}
								//echo "<br>" .$str = $this->db->last_query();
								}
							}	
						}				
				}
			//echo "<br>" .$str = $this->db->last_query();
			$_SESSION['ads_id']=$ads_id;
			$this->session->set_userdata('ads_id', $ads_id);
			
			}
			
			
			
		//$ads_id=$_SESSION['ads_id'];
		$ads_id=$this->session->userdata('ads_id');
			
		if($code=='steptwo')
			{
			$sql="UPDATE `ads` SET `first_name`=?, `last_name`=?,`phone`=?, `phone_visibility`=?, `email`=?, `email_visibility`=?  WHERE `ads_id`=?";
			$this->db->query($sql,array($adsData['firstName'],$adsData['lastName'],$adsData['phoneNo'],$adsData['phoneVisible'],$adsData['emailId'],$adsData['emailVisible'],$ads_id));
			
			}
		if($code=='stepthree')
		
			{
			
			$comma_separated_communities= implode(",", $adsData['communities']);
			$sql="UPDATE `ads` SET `gender`=?, `smoker`=?, `age`=?, `orientation`=?, `diet`=?,`occupation`=?,`community`='$comma_separated_communities'  WHERE `ads_id`=? ";
			$this->db->query($sql,array($adsData['gender'],$adsData['smoker'],$adsData['age'],$adsData['orientation'],$adsData['diet'],$adsData['occupation'],$ads_id));
			}
			
			
			
			if($code=='stepfour')
			{
			$sql="UPDATE `ads` SET `title`=?,`description`=?,`bestfeature1`=?,`bestfeature2`=?,`status`=? WHERE `ads_id`=?";
			$this->db->query($sql,array($adsData['title'],$adsData['adDescription'],$adsData['propFeature1'],$adsData['propFeature2'],'1',$ads_id));
			$this->session->unset_userdata('ads_id');
			//echo "<br>" .$str = $this->db->last_query();
			
			}
			//echo "<br>" .$str = $this->db->last_query();
			
	}
	
	function ad_information($id)
	{
		$sql="select * from ads where ads_id='$id'";
		$query=$this->db->query($sql);
		//echo "<br>" .$str = $this->db->last_query();exit;
		$ad_info=array();
		if($query->num_rows()>0)
			{
				$ad_info=$query->result_array();
			}
		$query->free_result();
		//print_r($ad_info);//exit;
		return $ad_info;
	}
	
	function community_name($com)
	{
		$sql="select community from communities where id IN($com)";
		$query=$this->db->query($sql);
		//echo "<br>" .$str = $this->db->last_query();exit;
		$community=array();
		if($query->num_rows()>0)
			{
				$community=$query->result_array();
			}
		$query->free_result();
		//print_r($ad_info);//exit;
		return $community;
	}
	
	//myinbox
	function myinbox($uid)
	{$user_id=$uid;
	$sql1="select * from adsmessages where users_id=$user_id";
	$query = $this->db->query($sql1);
	//echo "<br>" .$str = $this->db->last_query();exit;
	$results = array();
	if ($query->num_rows() > 0)
		{
			$results = $query->result_array();
			
		}
		$query->free_result();		
		
		return $results;
	}
	
	
	//reciever info
	function recieverinfo($id)
	{
	$sql1="select * from ads where ads_id='$id'";
	$query = $this->db->query($sql1);
	//echo "<br>" .$str = $this->db->last_query();exit;
	$results = array();
	if ($query->num_rows() > 0)
		{
			$results = $query->result_array();
			
		}
		$query->free_result();		
		
		return $results;
	}
	
	
	//contact Adv
	function contactAdv($contactData)
    { 
	$sqlthreadid="select MAX(thread_id) from adsmessages";
	$sqlthreadid1=$this->db->query($sqlthreadid);
	if ($sqlthreadid1->num_rows() > 0)
		{
			$resultthreadid = $sqlthreadid1->result_array();
		}
	
$next_thread_id=$resultthreadid[0]['MAX(thread_id)']+1;	

		$sqluid= "select user_id,street_address,city,state,country,postal_code from ads where ads_id=?";
		$uid1=$this->db->query($sqluid,array($contactData['ads_id']));
		
		if ($uid1->num_rows() > 0)
		{
			$resultuid = $uid1->result_array();
			
		}
		
$sqlemail="select email from ads where user_id=?";
		$uemail=$this->db->query($sqlemail,array($resultuid[0]['user_id']));
		
		if ($uemail->num_rows() > 0)
		{
			$resultuemail = $uemail->result_array();
			
		}//print_r($resultuemail);exit;
		
		$subject=$resultuid[0]['street_address'].",".$resultuid[0]['city'].",".$resultuid[0]['state'].",".$resultuid[0]['postal_code'];
	
	$sql = "INSERT INTO `adsmessages` (`ads_id`, `users_id`,`sender_user_id`,`firstname`,`r_name`, `contact_email`,`r_email`, `subject`, `message`, `contact_date`, `read`, `thread_id`) 
							VALUES (?,?,?,?,?,?,?,?,?,?,?,?) ";
		
		$this->db->query($sql,array($contactData['ads_id'],$resultuid[0]['user_id'],$contactData['sender_uid'],$contactData['firstname'],$contactData['r_name'],$contactData['youremail'],$contactData['r_email'],$subject,$contactData['yourmessage'],date('Y-m-d H:i:s'),0,$next_thread_id));
		//echo "<br>" .$str = $this->db->last_query();exit;
	$resultuemail['subject']=$subject;
	
	return $resultuemail;
	
	}
	
	//adsviews
	function adsviews($ads_id)
    { 
	
	$sql = "INSERT INTO `adsviews` (`ads_id`, `user_id`,`view_date`) 
							VALUES (?,?,?) ";
		
		$this->db->query($sql,array($ads_id,0,date('Y-m-d H:i:s')));
		//echo "<br>" .$str = $this->db->last_query();exit;
	}
	
	
	//adscontact
	function adscontact($ads_id)
    { 
	
	$sql = "INSERT INTO `adscontacts` (`ads_id`, `user_id`,`contact_date`) 
							VALUES (?,?,?) ";
		
		$this->db->query($sql,array($ads_id,0,date('Y-m-d H:i:s')));
		//echo "<br>" .$str = $this->db->last_query();exit;
	}
	
	
	// get provider and finder list for home page
	function ads_home_list($n=4)
	{
		// description 	bestfeature1 Best feature 1 	bestfeature2
		
		//$sql = "SELECT ads_id,title,city,description,bestfeature1,bestfeature2,sharing_type,rent,rent_type FROM `ads` where status='1' order by sharing_type desc LIMIT 0 , $n ";
		//$sql .= " union ";
		$sql = " SELECT addedtime,ads_id,title,state,postal_code,city,description,bestfeature1,bestfeature2,sharing_type,rent,rent_type FROM `ads` where status='1' and sharing_type='1' order by addedtime DESC LIMIT 0 , $n /*get provider list for home page*/";
		$query = $this->db->query($sql);
		//echo $str = $this->db->last_query();//exit;
		$results = array();
		
		if ($query->num_rows() > 0)
		{
			$results['providers'] = $query->result_array();
			
			$num_results=$query->num_rows();
			for($i=0;$i<$num_results;$i++)
			{
			$sqlimg="select name from images WHERE `images`.`ads_id`=?  limit 0,1";
			$queryimg = $this->db->query($sqlimg,array($results['providers'][$i]['ads_id']));
			//echo "<br>" .$str = $this->db->last_query();exit;
			if ($queryimg->num_rows() > 0)
			{
			$results['providers'][$i]['image'] = $queryimg->result_array();
			}$queryimg->free_result();
			}
		}
		$query->free_result();
		
		$sql = " SELECT ads_id,title,city,description,bestfeature1,bestfeature2,sharing_type,rent,rent_type FROM `ads` where status='1' and sharing_type='0' order by addedtime DESC LIMIT 0 , $n /*get finder list for home page*/";
		//$sql = " SELECT ads.ads_id,ads.title,ads.city,ads.description,ads.bestfeature1,ads.bestfeature2,ads.sharing_type,ads.rent,ads.rent_type,images.name FROM `ads` JOIN images ON(ads.ads_id=images.ads_id)where ads.status='1' and ads.sharing_type='0' LIMIT 0 , $n /*get finder list for home page*/";
		
		$query = $this->db->query($sql);
		//echo "<br>" .$str = $this->db->last_query();exit;
		if ($query->num_rows() > 0)
		{
			$results['finders'] = $query->result_array();			
			$num_results=$query->num_rows();
			for($i=0;$i<$num_results;$i++)
			{
			$sqlimg="select name from images WHERE `images`.`ads_id`=?  limit 0,1";
			$queryimg = $this->db->query($sqlimg,array($results['finders'][$i]['ads_id']));
			//echo "<br>" .$str = $this->db->last_query();exit;
			if ($queryimg->num_rows() > 0)
			{
			$results['finders'][$i]['image'] = $queryimg->result_array();
			}$queryimg->free_result();
			}
			
			
		}
		$query->free_result();		
		
		
		return $results;
		
	} // end of 

	// filter results
	// by city, state, country
	
	
	
	function adsviewscount($ads_id)
	{
		
		$sql = " SELECT * FROM `adsviews` where ads_id=$ads_id";
		
		$query = $this->db->query($sql);
		//echo $str = $this->db->last_query();
		//$results = array();
		
		$results=$query->num_rows();
			
		return $results;
		
	} 
	
	
	function adscontactcount($ads_id)
	{
		
		$sql = " SELECT * FROM `adscontacts` where ads_id=$ads_id";
		
		$query = $this->db->query($sql);
		//echo $str = $this->db->last_query(); exit;
		//$results = array();
		
		$results=$query->num_rows();
			
		return $results;
		
	}
	
	function get_geocode($filters)
	{//print_r($filters);exit;
		if(isset($filters['location']))
		{
		$location=$filters['location'];
		}

		//$sql="select Lat,Lng form GeoPC where City like '$location'";
		$sql="SELECT Lat,Lng FROM `GeoPC` WHERE `City` LIKE '$location' or `ISO2` LIKE '%$location' or `Zip` LIKE SUBSTRING('$location', -4) limit 0,1";
		//$sql="SELECT  CONCAT(City,', ',RIGHT(ISO2, 3) as cp,'',Zip),Lat,Lng  FROM `GeoPC` WHERE `cp`='$location'";
		$query = $this->db->query($sql);
		//echo $str = $this->db->last_query(); //exit;
		$results = array();
		
		if ($query->num_rows() > 0)
		{
			$results = $query->result_array();
		}
		return $results;
	}
	
	function get_city_from_geocode($geocode)
	{
	//print_r($geocode);exit;
		if(isset($geocode[0]['Lat']))
		{
		$lat=$geocode[0]['Lat'];
		}
		if(isset($geocode[0]['Lng']))
		{
		$lng=$geocode[0]['Lng'];
		}

		
		//$sql="SELECT City FROM `GeoPC` WHERE (`Lat` BETWEEN $lat-0.05 AND $lat+0.05 ) and (`Lng` BETWEEN $lng-0.05 AND $lng+0.05 )";
		$sql="SELECT City, ( 6371 * acos( cos( radians($lat) ) * cos( radians( lat ) ) * cos( radians( lng ) - radians(lng) ) + sin( radians($lat) ) * sin( radians( lat ) ) ) ) AS distance FROM GeoPC HAVING distance < 5 ";
		$query = $this->db->query($sql);
		//echo $str = $this->db->last_query(); //exit;
		$results = array();
		
		if ($query->num_rows() > 0)
		{
			$results = $query->result_array();
		}
		//print_r($results); exit;
		return $results;
	}
	
	function filter_ads($filters)
	{//print_r($filters);exit;
		$per_page=$filters['per_page']; 
		$offset=$filters['offset'];
		
//test start
$sql1 = " 	SELECT * FROM `ads` where ";
		$sql = "";
		if(!empty($filters['city']))			
			$sql .= "( city like '" . $filters['city'] . "%' and	";		
		if(!empty($filters['state']))			
			$sql .= "( state like '" . $filters['state'] . "%' and	";	
		if(!empty($filters['country']))			
			$sql .= "( country like '" . $filters['country'] . "%' and	";	
			
		// search  
		if(!empty($filters['searchFlag']) && $filters['searchFlag']==1)
		{ 
			$location = $filters['location'];
			$surrAreas = $filters['surrAreas'];
			if(isset($filters['community_array']))
				{
				$community = implode(",", $filters['community_array']);
				}
			$memberType = $filters['memberType'];				
			if(!empty($location))
				{
					$seachStr =trim($location);
					if(is_numeric($seachStr))
					{
					$sql .= " (`postal_code` like '". $seachStr . "%' ";
					}
					else
					{
						$seachStrsInt = intval($seachStr);
						if( !empty($seachStrsInt) && $sql=='' )
						$sql .= "( `postal_code` like '". $seachStrsInt . "%' ";					
						else if(! empty($seachStrsInt) )	
						$sql .= " or `postal_code` like '". $seachStrsInt . "%' ";	
						$seachStrs1 = explode(' ',$seachStr);	
						
						$seachStrs2 = explode(', ',$seachStr);
							//print_r($seachStrs2);
						if(!empty($seachStrs2) && is_array($seachStrs2) && count($seachStrs2)>1)
							{
								foreach($seachStrs2 as $seachStrs22)
									{
										$seachStrs22 = trim($seachStrs22);
										if(!empty($seachStrs22))
										{
											if( $sql=='' )
												$sql .= "( `city` like '" . $seachStrs22 . "%' ";						
											else
												$sql .= " or `city` like '" . $seachStrs22 . "%' ";
											
											if( $sql=='' )
												$sql .= "( `state` like '" . $seachStrs22 . "%' ";						
											else
												$sql .= " or `state` like '" . $seachStrs22 . "%' ";	
										}
									}
							}				
						// street_address 	city 	state 	country 	postal_code					

						if( $sql=='' )
							$sql .= " (`city` like '" . $seachStr . "%' ";						
						else
							$sql .= " or `city` like '" . $seachStr . "%' ";
						if( $sql=='' )
							$sql .= " (`state` like '" . $seachStr . "%' ";						
						else
							$sql .= " or `state` like '" . $seachStr . "%' ";	
						
					}					
					
				}
				$sql.= ")";
				
				if(!empty($community) )
				{
				$sql .= "AND community IN ($community) ";			
									
				}
				
				
				
				if(!empty($memberType) && $memberType==1)
				{
					//$sql .= " and sharing_type='1' and	";
					if( $sql=='' )
						$sql .= " sharing_type='1' ";			
					else
						$sql .= " and sharing_type='1' ";				
				}
				else if($memberType==0)
				{
					//$sql .= " and sharing_type='0' ";		
					if( $sql=='' )
						$sql .= " sharing_type='0' ";			
					else	
						$sql .= " and sharing_type='0' ";					
				}
				
			
		}		
			
		//*/
		if( $sql=='' )
			$sql = $sql1 . "			
							status='1' LIMIT  $offset, $per_page
						/*filter ads count by some filter like city, state, country*/";
		else	
			$sql = $sql1 . ' ' . $sql . "			
							and status='1' LIMIT  $offset, $per_page
						/*filter ads count by some filter like city, state, country*/";	

//test end		
		
		
		
					

		//echo$sql;//exit;
		$query = $this->db->query($sql);
		//echo $str = $this->db->last_query();
		$results = array();
		
		
		
		if ($query->num_rows() > 0)
		{
			$results = $query->result_array();
			$num_results=$query->num_rows();
			$results=images($num_results,$results);
			/* for($i=0;$i<$num_results;$i++)
			{
			$sqlimg="select images.title as img_title, images.description as img_desc, images.name,images.full_url, images.real_path	from images WHERE `images`.`ads_id`=?  limit 0,1";
			$queryimg = $this->db->query($sqlimg,array($results[$i]['ads_id']));
			//echo "<br>" .$str = $this->db->last_query();exit;
			if ($queryimg->num_rows() > 0)
			{
			$results[$i]['image'] = $queryimg->result_array();
			}$queryimg->free_result();
			} */
			
		}
		$query->free_result();		
		//echo "<pre>";print_r($results);echo "</pre>";exit;
		return $results;
		
	} // end of 

	// filter results count
	// count by city, state, country
	function image($num_results,$results)
	{
	for($i=0;$i<$num_results;$i++)
			{
			$sqlimg="select images.title as img_title, images.description as img_desc, images.name,images.full_url, images.real_path	from images WHERE `images`.`ads_id`=?  limit 0,1";
			$queryimg = $this->db->query($sqlimg,array($results[$i]['ads_id']));
			//echo "<br>" .$str = $this->db->last_query();exit;
			if ($queryimg->num_rows() > 0)
			{
			$results[$i]['image'] = $queryimg->result_array();
			}$queryimg->free_result();
			}
			return $results;
	}
	
	function filter_adsCount($filters)
	{
		
		
		$sql1 = " SELECT ads_id FROM `ads` where ";			
		$sql = "";			
		//*			
		if(!empty($filters['city']))			
			$sql .= " (city like '" . $filters['city'] . "%' and	";		
		if(!empty($filters['state']))			
			$sql .= " (state like '" . $filters['state'] . "%' and	";	
		if(!empty($filters['country']))			
			$sql .= " (country like '" . $filters['country'] . "%' and	";	
			
		// search  
		if(!empty($filters['searchFlag']) && $filters['searchFlag']==1)
		{
				$location = $filters['location'];
				$surrAreas = $filters['surrAreas'];
				//$community = $filters['community'];
				if(isset($filters['community_array']))
					{
					$community = implode(",", $filters['community_array']);
					}
				$memberType = $filters['memberType'];				
				
				if(!empty($location))
					{
						$seachStr = trim($location);
						if(is_numeric($seachStr))
							{
								$sql .= " (`postal_code` like '".$seachStr. "%' ";
							}
						else
							{
								$seachStrsInt = intval($seachStr);
							
								if( !empty($seachStrsInt) && $sql=='' )
								$sql .= " (`postal_code` like '". $seachStrsInt . "%' ";					
								else if(! empty($seachStrsInt) )	
								$sql .= " or `postal_code` like '". $seachStrsInt . "%' ";	
							
								$seachStrs1 = explode(' ',$seachStr);	
							
								$seachStrs2 = explode(', ',$seachStr);
								//print_r($seachStrs2);
								if(!empty($seachStrs2) && is_array($seachStrs2) && count($seachStrs2)>1)
									{
										foreach($seachStrs2 as $seachStrs22)
											{
												$seachStrs22 = trim($seachStrs22);
												if(!empty($seachStrs22))
													{
														if( $sql=='' )
														$sql .= "( `city` like '" . $seachStrs22 . "%' ";						
														else
														$sql .= " or `city` like '" . $seachStrs22 . "%' ";
										
														if( $sql=='' )
														$sql .= "( `state` like '" . $seachStrs22 . "%' ";						
														else
														$sql .= " or `state` like '" . $seachStrs22 . "%' ";
										
													}
											}
									}				
						

								if( $sql=='' )
								$sql .= " (`city` like '" . $seachStr . "%' ";						
								else
								$sql .= " or `city` like '" . $seachStr . "%' ";
					
								if( $sql=='' )
								$sql .= "( `state` like '" . $seachStr . "%' ";						
								else
								$sql .= " or `state` like '" . $seachStr . "%' ";
							}					
					
					}
				$sql .=")";
				if(!empty($community) )
				{
				$sql .= "AND community IN ($community) ";			
									
				}
				
				if(!empty($memberType) && $memberType==1)
				{
					
					if( $sql=='' )
						$sql .= " sharing_type='1' ";			
					else
						$sql .= " and sharing_type='1' ";				
				}
				else if($memberType==0)
				{
					
					if( $sql=='' )
						$sql .= " sharing_type='0' ";			
					else	
						$sql .= " and sharing_type='0' ";					
				}
				
			
		}		
			
		
		if( $sql=='' )
			$sql = $sql1 . "			
							status='1'
						/*filter ads count by some filter like city, state, country*/";
		else	
			$sql = $sql1 . ' ' . $sql . "			
							and status='1'
						/*filter ads count by some filter like city, state, country*/";		
		//echo $sql;
		$query = $this->db->query($sql);
		//echo $this->db->last_query();//exit;
		$result = array();
		$rcount = 0;
		if ($query->num_rows() > 0)
		{
			$result = $query->result_array();
			
			//$rcount = $results['rcount'];
			$rcount=$num_results=$query->num_rows();
			for($i=0;$i<$num_results;$i++)
			{
			$result[$i]=$result[$i]['ads_id'];
			} 
			
		}
		$query->free_result();		
		$results['all_ads_id']=$result;
		$results['rcount']=$rcount;
		return $results;
		
	} // end of 

	//advance search
	function adv_search($advData,$offset,$result_per_page)
	{
	$sql="select * from ads where community=? and property_type=? and bed_rooms<=? and bath_rooms<=? and parking=? limit $offset,$result_per_page";
	$query=$this->db->query($sql,array($advData['community'],$advData['propertytype'],$advData['bedrooms'],$advData['bathrooms'],$advData['parking']));
	//echo "<br>" .$str = $this->db->last_query();exit;
	
	$results=array();
		if($query->num_rows()>0)
			{
				$results=$query->result_array();
			
				$num_results=$query->num_rows();
				$results=images($num_results,$results);
				/* for($i=0;$i<$num_results;$i++)
					{
						$sqlimg="select images.title as img_title, images.description as img_desc, images.name,images.full_url, images.real_path	from images WHERE `images`.`ads_id`=?  limit 0,1";
						$queryimg = $this->db->query($sqlimg,array($results[$i]['ads_id']));
						//echo "<br>" .$str = $this->db->last_query();exit;
						if ($queryimg->num_rows() > 0)
							{
								$results[$i]['image'] = $queryimg->result_array();
							}
						$queryimg->free_result();
					} */
			
			
			
			}
	$query->free_result();
	return $results;
	
	}
	
	
	function adv_search_count($advData)
	{
	$sql="select * from ads where community=? and property_type=? and bed_rooms<=? and bath_rooms<=? and parking=?";
	$query=$this->db->query($sql,array($advData['community'],$advData['propertytype'],$advData['bedrooms'],$advData['bathrooms'],$advData['parking']));
	//echo "<br>" .$str = $this->db->last_query();exit;
	
	$results=array();
		if($query->num_rows()>0)
			{
				$results=$query->num_rows();
			}
	$query->free_result();
	
	return $results;
	
	}
	
	// filter my ads
	
	function filter_myads($filters)
	{
		
		
		

////
if(!empty($filters['page_about']) && $filters['page_about']==1){		
			$sql = " 	SELECT 
							ads.ads_id,user_id,ads.title,ads.city,ads.description,ads.bestfeature1,ads.bestfeature2
							,ads.sharing_type,ads.rent,ads.rent_type,ads.availability,ads.updated_date,ads.addedtime,ads.expiry_date,ads.status
													
						FROM 
							ads 							
						where ads.user_id=" . $this->session->userdata('user_id') . ' and (ads.status="1" or ads.status="0" )';
		}
///
		
///		
else if(!empty($filters['page_about']) && $filters['page_about']==2){
		

			$sql = " 	SELECT 
							ads.ads_id,ads.user_id,ads.title,ads.city,ads.description,ads.bestfeature1,ads.bestfeature2
							,ads.sharing_type,ads.rent,ads.rent_type,ads.availability,ads.updated_date,ads.addedtime
							, slad.shortlisted_time
						FROM 
							shortlistedads as slad inner join ads on (ads.ads_id=slad.ads_id)
														
						where  slad.user_id=" . $this->session->userdata('user_id') . ' and ads.status="1" ';
						
		}		
///		
		else if(!empty($filters['page_about']) && $filters['page_about']==3){


		}					
		
		$offset = $filters['offset']; ;		
		
		
		$per_page = $filters['per_page'];
		
		$sql .= " 			
						 ORDER BY `addedtime` desc LIMIT  $offset, $per_page 
					/*filter ads by some filter like city, state, country*/";
		
		$query = $this->db->query($sql);
		//echo $str = $this->db->last_query(); exit;
		$results = array();
		
		if ($query->num_rows() > 0)
		{
			$results = $query->result_array();
			$num_results=$query->num_rows();
			$results=images($num_results,$results);
			/* for($i=0;$i<$num_results;$i++)
			{
			$sqlimg="select images.title as img_title, images.description as img_desc, images.name,images.full_url, images.real_path	from images WHERE `images`.`ads_id`=?  limit 0,1";
			$queryimg = $this->db->query($sqlimg,array($results[$i]['ads_id']));
			//echo "<br>" .$str = $this->db->last_query();exit;
			if ($queryimg->num_rows() > 0)
			{
			$results[$i]['image'] = $queryimg->result_array();
			}$queryimg->free_result();
			} */
			
			
		}
		//$query->free_result();		
		//echo '<pre>';
		//print_r($results);echo '</pre>';exit;
		
		return $results;
		
	} // end of 
	
	
	
	function cityCount($comma_separated_city,$filters)
	{ 
	//print_r($filters);exit;
			
	$memberType=$filters['memberType'];
	$sql="select ads_id from ads where city IN ($comma_separated_city) AND sharing_type='$memberType'"; 
	
	if(isset($filters['community_array']))
					{
						$community = implode(",", $filters['community_array']);
						$sql .=" AND community IN ($community)";
					}
	
	$query = $this->db->query($sql);
	//echo $str = $this->db->last_query();//exit;
	$results=array();
	if ($query->num_rows() > 0)
		{
			$result=$query->result_array();
			//$result=$result[0]['count(ads_id)'];
			$rcount=$num_results=$query->num_rows();
			for($i=0;$i<$num_results;$i++)
			{
				$result[$i]=$result[$i]['ads_id'];
			} 
		$results['all_ads_id']=$result;
		$results['rcount']=$rcount;
		}
		
		$query->free_result();
		//print_r($results);exit;
		return $results;
	}
	
	////include sorrounding area search
	function city($comma_separated_city,$filters,$offset,$result_per_page)
	{  
	//print_r($filters);exit;
			
	$memberType=$filters['memberType'];
	$sql="select * from ads where city IN ($comma_separated_city) AND sharing_type='$memberType' ";
	if(isset($filters['community_array']))
					{
						$community = implode(",", $filters['community_array']);
						$sql .="AND community IN ($community) ";
					}
	
	$sql .=" limit $offset,$result_per_page";
	$query = $this->db->query($sql);
	//echo $str = $this->db->last_query();
	$result=array();
	if ($query->num_rows() > 0)
		{
		$result=$query->result_array();
	
	
			$num_results=$query->num_rows();
			$result=images($num_results,$result);
			/* for($i=0;$i<$num_results;$i++)
			{
			$sqlimg="select images.title as img_title, images.description as img_desc, images.name,images.full_url, images.real_path	from images WHERE `images`.`ads_id`=?  limit 0,1";
			$queryimg = $this->db->query($sqlimg,array($result[$i]['ads_id']));
			//echo "<br>" .$str = $this->db->last_query();//exit;
			if ($queryimg->num_rows() > 0)
			{
			$result[$i]['image'] = $queryimg->result_array();
			}
			$result['city'][$i]=$result[$i]['city'];
			//$result['city']=explode(',',$comma_separated_city);
			$queryimg->free_result();
			} */
	
	
		}
		$query->free_result();
		//print_r($result); exit;
		return $result;
	}
	
	////test end
	
	// filter my ads count

	function filter_myadsCount($filters)
	{
		if(!empty($filters['page_about']) && $filters['page_about']==1){
			$sql = " 	SELECT 
							count(ads_id) as rcount 
						FROM 
							`ads` 
						where user_id=" . $this->session->userdata('user_id') . ' and ';
			
			$sql .= " 			
							(ads.status='1' or ads.status='0' )
						/*filter my ads count*/";
		} else if(!empty($filters['page_about']) && $filters['page_about']==2){

			$sql = " 	SELECT 
							count(ads.ads_id) as rcount 
						FROM 
							shortlistedads as slad inner join ads on (ads.ads_id=slad.ads_id)
														
						where  slad.user_id=" . $this->session->userdata('user_id') . ' and ';
			
			$sql .= " 			
							ads.status='1'  
						/*filter my ads count*/";
						
		} else if(!empty($filters['page_about']) && $filters['page_about']==3){

		$sql = " 	SELECT 
							count(ads_id) as rcount 
						FROM 
							`ads` 
						where user_id=" . $this->session->userdata('user_id') . ' and ';
			
			$sql .= " 			
							(ads.status='1' or ads.status='0' )
						/*filter my ads count*/";
		

		}
		
		$query = $this->db->query($sql);
		//echo $str = $this->db->last_query(); exit;
		$results = array();
		$rcount = 0;
		if ($query->num_rows() > 0)
		{
			$results = $query->row_array();
			$rcount = $results['rcount'];
		}
		$query->free_result();		
		
		return $rcount;
		
	} // end of filter_myadsCount

	// get ad details
	function ads_detail($ads_id)
	{
		$sql = " SELECT * FROM `ads` where ads_id=? ";
		
		$query = $this->db->query($sql,array($ads_id));
		
		//echo $str = $this->db->last_query();exit;
		$results_detail = array();
		
		if ($query->num_rows() > 0)
		{
			$results_detail = $query->row_array();
			
		}
		$query->free_result();	
		//echo '<pre>';print_r($results_detail);exit;echo '</pre>';
		
		return $results_detail;
		
	} // end of ads_detail
	
	// get ad images
	function ads_Images($ads_id)
	{
		$sql = " SELECT * FROM `images` where ads_id=? and ";
		
		$sql .= " status='1' /*get ads full details*/ ";
		
		$query = $this->db->query($sql,array($ads_id));
		
		//echo $str = $this->db->last_query();
		$results = array();
		
		if ($query->num_rows() > 0)
		{
			$results = $query->result_array();
			
		}
		$query->free_result();		
		//print_r($results);
		return $results;
		
	} // end of images	
	
	// get ad meta data by meta type
	function adsMetaData($ads_id,$type)
	{
		$sql = " SELECT * FROM `adsmetadata` where ads_id=? and meta_type=? ";
		
		$sql .= " /*get ads full details*/ ";
		
		$query = $this->db->query($sql,array($ads_id,$type));
		
		//echo $str = $this->db->last_query();
		$results = array();
		
		if ($query->num_rows() > 0)
		{
			$results = $query->result_array();
			
		}
		$query->free_result();		
		
		return $results;
		
	} // end of images	
	
	// get Field lists
	function get_adFields($ads_id,$type)
	{
		$sql = " SHOW COLUMNS FROM ads ";
		
		$sql .= " /*get ads fields list*/ ";
		
		$query = $this->db->query($sql);
		
		//echo $str = $this->db->last_query();
		$results = array();
		
		if ($query->num_rows() > 0)
		{
			$results = $query->result_array();			
		}
		
		$query->free_result();

				
		
		return $results;
		
	} // end of get_adFields		
	
	

	// get community list
	function getCommunityList()
	{
		$sql = " SELECT * FROM `communities` order by country, community ";
		
		$sql .= " /*get community list*/ ";
		
		$query = $this->db->query($sql);
		
		//echo $str = $this->db->last_query();
		$results = array();
		
		if ($query->num_rows() > 0)
		{
			$results = $query->result_array();			
		}
		
		$query->free_result();
	
		
		return $results;
		
	} // end of getCommunityList
	
	//get community list form id
	function get_community($comma_separated_communities)
	{
		$sql="select community from communities where id IN($comma_separated_communities)";
		$query=$this->db->query($sql);
		//echo $str = $this->db->last_query();exit;
		$community_array=array();
		if($query->num_rows()>0)
			{
				$community_array=$query->result_array();
			}
		$query->free_result();
		
		return $community_array;
	}
	
	
	
	// add to shortlist
	function addToShortList($ads_id,$user_id)
	{
	
	$chk="select * from shortlistedads where ads_id=$ads_id and user_id=$user_id";
	$chkquery=$this->db->query($chk);
	//echo "<br>" .$str = $this->db->last_query(); exit;
	if ($chkquery->num_rows() > 0)
	{
	$affectedFlag=2;
	return $affectedFlag;
	 } else{
		$sql = "INSERT INTO `shortlistedads` 
				( `shortlisted_ads_id`, `user_id`, `ads_id` ) 
				VALUES (NULL,?,?)
				/*add to shortlist*/";
		//echo $sql;
		try
		{
			$this->db->query($sql,
								array(
									$user_id,$ads_id
									)
							);
		}
		catch(Exceptuin $ex)
		{
			//print $ex;
		}		
		//echo "<br>" .$str = $this->db->last_query();
		$affectedFlag = $this->db->affected_rows();
		return $affectedFlag;		}
	} // end of addToShortList
	
//Refine search

//sorrounding areas
function r_sorr($data,$city,$offset,$result_per_page)
{
	
	$ads_id=$data['ads_id'];
	
	$sql="select * from ads where ads_id IN ($ads_id) and city IN($city)limit $offset,$result_per_page";
	$query=$this->db->query($sql);
	//echo $this->db->last_query();
	
	$results = array();

if ($query->num_rows() > 0)
		{
			$results = $query->result_array();
			$num_results=$query->num_rows();
			$results=images($num_results,$results);
			/* for($i=0;$i<$num_results;$i++)
			{
			$sqlimg="select images.title as img_title, images.description as img_desc, images.name,images.full_url, images.real_path	from images WHERE `images`.`ads_id`=?  limit 0,1";
			$queryimg = $this->db->query($sqlimg,array($results[$i]['ads_id']));
			//echo "<br>" .$str = $this->db->last_query();exit;
			if ($queryimg->num_rows() > 0)
			{
			$results[$i]['image'] = $queryimg->result_array();
			}$queryimg->free_result();
			} */
			
		}
		$query->free_result();		
		//echo "<pre>";print_r($results);echo "</pre>";exit;
		
		return $results;

}
//community
function r_comm($data,$offset,$result_per_page)
{
$count=count($data['options']);
$comm=array();
$ads_id=$data['ads_id'];

if (in_array("0", $data['options']))
{
$sql="select * from ads where ads_id IN($ads_id) limit $offset,$result_per_page";
}
else
{
for($i=0;$i<$count;$i++)
{
$comm[$i]=$data['options'][$i];
}
 $comm=implode(',',$comm);
 


$sql="select * from ads where community IN($comm) AND ads_id IN($ads_id) limit $offset,$result_per_page";
}


$query=$this->db->query($sql);
//echo $this->db->last_query();

$results = array();

if ($query->num_rows() > 0)
		{
			$results = $query->result_array();
			$num_results=$query->num_rows();
			$results=images($num_results,$results);
			/* for($i=0;$i<$num_results;$i++)
			{
			$sqlimg="select images.title as img_title, images.description as img_desc, images.name,images.full_url, images.real_path	from images WHERE `images`.`ads_id`=?  limit 0,1";
			$queryimg = $this->db->query($sqlimg,array($results[$i]['ads_id']));
			//echo "<br>" .$str = $this->db->last_query();exit;
			if ($queryimg->num_rows() > 0)
			{
			$results[$i]['image'] = $queryimg->result_array();
			}$queryimg->free_result();
			} */
			
		}
		$query->free_result();		
		//echo "<pre>";print_r($results);echo "</pre>";exit;
		
		return $results;
}


//price range
 function r_price($data,$offset,$result_per_page)
{
//echo 'hello';

//print_r($data);
//echo '<br>';


$min_pricerange=$data['min_pricerange'];
$max_pricerange=$data['max_pricerange'];
$rentType=$data['rentType'];
$ads_id=$data['ads_id'];

$sql="select * from ads where (rent BETWEEN'$min_pricerange' AND '$max_pricerange') AND rent_type='$rentType' AND  ads_id IN($ads_id) limit $offset,$result_per_page";
$query = $this->db->query($sql);
//echo $this->db->last_query();
$results = array();

if ($query->num_rows() > 0)
		{
			$results = $query->result_array();
			$num_results=$query->num_rows();
			$results=images($num_results,$results);
			/* for($i=0;$i<$num_results;$i++)
			{
			$sqlimg="select images.title as img_title, images.description as img_desc, images.name,images.full_url, images.real_path	from images WHERE `images`.`ads_id`=?  limit 0,1";
			$queryimg = $this->db->query($sqlimg,array($results[$i]['ads_id']));
			//echo "<br>" .$str = $this->db->last_query();exit;
			if ($queryimg->num_rows() > 0)
			{
			$results[$i]['image'] = $queryimg->result_array();
			}$queryimg->free_result();
			} */
			
		}
		$query->free_result();		
		//echo "<pre>";print_r($results);echo "</pre>";exit;
		
		return $results;

}


//property type
 function r_p_type($data,$offset,$result_per_page)
{
//echo 'hello';
//echo '<br>';
//print_r($data['options']);
//echo '<br>';
$count=count($data['options']);
$property_type=array();
$ads_id=$data['ads_id'];
if (in_array("0", $data['options']))
{
$sql="select * from ads where ads_id IN($ads_id) limit $offset,$result_per_page";
}
else
{
for($i=0;$i<$count;$i++)
{
$property_type[$i]="'".$data['options'][$i]."'";
}
 $property_type=implode(',',$property_type);

$sql="select * from ads where property_type IN($property_type) AND ads_id IN($ads_id) limit $offset,$result_per_page";
}


$query = $this->db->query($sql);
//echo $this->db->last_query();
$results = array();

if ($query->num_rows() > 0)
		{
			$results = $query->result_array();
			$num_results=$query->num_rows();
			$results=images($num_results,$results);
			/* for($i=0;$i<$num_results;$i++)
			{
			$sqlimg="select images.title as img_title, images.description as img_desc, images.name,images.full_url, images.real_path	from images WHERE `images`.`ads_id`=?  limit 0,1";
			$queryimg = $this->db->query($sqlimg,array($results[$i]['ads_id']));
			//echo $this->db->last_query();exit;
			if ($queryimg->num_rows() > 0)
			{
			$results[$i]['image'] = $queryimg->result_array();
			}$queryimg->free_result();
			} */
			
		}
		$query->free_result();		
		//echo "<pre>";print_r($results);echo "</pre>";exit;
	
		return $results;




} 



//bedrooms
 function r_bedroom($data,$offset,$result_per_page)
{
//echo 'hello';
//echo '<br>';
//print_r($data);
//echo '<br>';

$count=count($data['options']);
$bedrooms=array();
$ads_id=$data['ads_id'];
if (in_array("0", $data['options']))
{
$sql="select * from ads where ads_id IN($ads_id) limit $offset,$result_per_page";
}
else
{

$bedrooms="'".$data['options'][0]."'";
$sql="select * from ads where bed_rooms=$bedrooms AND ads_id IN($ads_id) limit $offset,$result_per_page";
}


$query = $this->db->query($sql);
//echo $this->db->last_query();
$results = array();

if ($query->num_rows() > 0)
		{
			$results = $query->result_array();
			$num_results=$query->num_rows();
			$results=images($num_results,$results);
			/* for($i=0;$i<$num_results;$i++)
			{
			$sqlimg="select images.title as img_title, images.description as img_desc, images.name,images.full_url, images.real_path	from images WHERE `images`.`ads_id`=?  limit 0,1";
			$queryimg = $this->db->query($sqlimg,array($results[$i]['ads_id']));
			//echo "<br>" .$str = $this->db->last_query();exit;
			if ($queryimg->num_rows() > 0)
			{
			$results[$i]['image'] = $queryimg->result_array();
			}$queryimg->free_result();
			} */
			
		}
		$query->free_result();		
		//echo "<pre>";print_r($results);echo "</pre>";exit;
		
		return $results;




} 


//parking
 function r_parking($data,$offset,$result_per_page)
{
//echo 'hello';
//echo '<br>';
//print_r($data);
//echo '<br>';

$count=count($data['options']);
$parking=array();
$ads_id=$data['ads_id'];
if (in_array("0", $data['options']))
{
$sql="select * from ads where ads_id IN($ads_id) limit $offset,$result_per_page";
}
else
{
for($i=0;$i<$count;$i++)
{
$parking[$i]="'".$data['options'][$i]."'";
}
$parking=implode(',',$parking);


$sql="select * from ads where parking IN($parking) AND ads_id IN($ads_id) limit $offset,$result_per_page";
}


$query = $this->db->query($sql);
//echo $this->db->last_query();
$results = array();

if ($query->num_rows() > 0)
		{
			$results = $query->result_array();
			$num_results=$query->num_rows();
			$results=images($num_results,$results);
			/* for($i=0;$i<$num_results;$i++)
			{
			$sqlimg="select images.title as img_title, images.description as img_desc, images.name,images.full_url, images.real_path	from images WHERE `images`.`ads_id`=?  limit 0,1";
			$queryimg = $this->db->query($sqlimg,array($results[$i]['ads_id']));
			//echo "<br>" .$str = $this->db->last_query();exit;
			if ($queryimg->num_rows() > 0)
			{
			$results[$i]['image'] = $queryimg->result_array();
			}$queryimg->free_result();
			} */
			
		}
		$query->free_result();		
		//echo "<pre>";print_r($results);echo "</pre>";exit;
		
		return $results;

} 

//
function r_parking_count($data)
{
$count=count($data['options']);
$parking=array();

$ads_id=$data['ads_id'];

if (in_array("0", $data['options']))
{
$sql="select * from ads where ads_id IN($ads_id)";
}
else
{
for($i=0;$i<$count;$i++)
{
$parking[$i]="'".$data['options'][$i]."'";
}
$parking=implode(',',$parking);

$sql="select * from ads where parking IN($parking) AND ads_id IN($ads_id)";
}
$query = $this->db->query($sql);
//echo $this->db->last_query();
//
if ($query->num_rows() > 0)
		{
			$result = $query->result_array();
			
			//$rcount = $results['rcount'];
			$rcount=$num_results=$query->num_rows();
			for($i=0;$i<$num_results;$i++)
			{
			$result[$i]=$result[$i]['ads_id'];
			} 
		$results['all_ads_id']=$result;
		$results['rcount']=$rcount;	
		}
		else
		{
		$results['all_ads_id']='';	
		$results['rcount']=0;	
		}
		$query->free_result();		
		
		return $results;
//
//$num=$query->num_rows();
//return $num;

}
//

 function r_bedroom_count($data)
{
$count=count($data['options']);
$bedrooms=array();
$ads_id=$data['ads_id'];
if (in_array("0", $data['options']))
{
$sql="select * from ads where ads_id IN($ads_id)";
}
else
{
$bedrooms="'".$data['options'][0]."'";
$sql="select * from ads where bed_rooms=$bedrooms AND ads_id IN($ads_id)";
}


$query = $this->db->query($sql);
//echo $this->db->last_query().'<br>';
//
$results=array();
if ($query->num_rows() > 0)
		{
			$result = $query->result_array();
			
			//$rcount = $results['rcount'];
			$rcount=$num_results=$query->num_rows();
			for($i=0;$i<$num_results;$i++)
			{
			$result[$i]=$result[$i]['ads_id'];
			} 
		$results['all_ads_id']=$result;	
		$results['rcount']=$rcount;
		}
		else
		{
		$results['all_ads_id']='';	
		$results['rcount']=0;	
		}
		$query->free_result();		
		
		
		//print_r($results);
		return $results;
//
//$num=$query->num_rows();
//return $num;
}


function r_p_type_count($data)
{
$count=count($data['options']);
$property_type=array();
$ads_id=$data['ads_id'];
if (in_array("0", $data['options']))
{
$sql="select * from ads where ads_id IN($ads_id)";
}
else
{
for($i=0;$i<$count;$i++)
{
$property_type[$i]="'".$data['options'][$i]."'";
}
 $property_type=implode(',',$property_type);

$sql="select * from ads where property_type IN($property_type) AND ads_id IN($ads_id)";
}
$query = $this->db->query($sql);
//
if ($query->num_rows() > 0)
		{
			$result = $query->result_array();
			
			//$rcount = $results['rcount'];
			$rcount=$num_results=$query->num_rows();
			for($i=0;$i<$num_results;$i++)
			{
			$result[$i]=$result[$i]['ads_id'];
			} 
		$results['all_ads_id']=$result;
		$results['rcount']=$rcount;
		}
		else
		{
		$results['all_ads_id']='';	
		$results['rcount']=0;	
		}
		
		//print_r($results);
		return $results;
//
//echo $this->db->last_query();
/* $num=$query->num_rows();
return $num; */
}

function r_price_count($data)
{
$min_pricerange=$data['min_pricerange'];
$max_pricerange=$data['max_pricerange'];
$rentType=$data['rentType'];
$ads_id=$data['ads_id'];

$sql="select * from ads where (rent BETWEEN'$min_pricerange' AND '$max_pricerange') AND rent_type='$rentType' AND  ads_id IN($ads_id)";
$query = $this->db->query($sql);
//echo $this->db->last_query();
//
if ($query->num_rows() > 0)
		{
			$result = $query->result_array();
			
			//$rcount = $results['rcount'];
			$rcount=$num_results=$query->num_rows();
			for($i=0;$i<$num_results;$i++)
			{
			$result[$i]=$result[$i]['ads_id'];
			} 
		$results['all_ads_id']=$result;
		$results['rcount']=$rcount;	
		}
		else
		{
		$results['all_ads_id']='';	
		$results['rcount']=0;	
		}
		$query->free_result();		
		
		return $results;
//
//$num=$query->num_rows();
//return $num;
}

 function r_comm_count($data)
{
$count=count($data['options']);
$comm=array();
$ads_id=$data['ads_id'];

if (in_array("0", $data['options']))
{
$sql="select * from ads where ads_id IN($ads_id)";
}
else
{
for($i=0;$i<$count;$i++)
{
$comm[$i]=$data['options'][$i];
}
 $comm=implode(',',$comm);
 $sql="select * from ads where community IN($comm) AND ads_id IN($ads_id)";
}
$query=$this->db->query($sql);
//echo $this->db->last_query();

if ($query->num_rows() > 0)
{
$result = $query->result_array();
$num=$query->num_rows();
for($i=0;$i<$num;$i++)
			{
			$result[$i]=$result[$i]['ads_id'];
			} 
$results['all_ads_id']=$result;
$results['rcount']=$num;			
}
else
		{
		$results['all_ads_id']='';	
		$results['rcount']=0;	
		}
return $results;
}  

//count refine sorrounding count
	function r_sorr_count($data,$city)
	{
	$ads_id=$data['ads_id'];
	$sql="select * from ads where ads_id IN ($ads_id) and city IN($city)";
	$query=$this->db->query($sql);
	//echo $this->db->last_query(); 
	//
	if ($query->num_rows() > 0)
	{
	$result = $query->result_array();
	$num=$query->num_rows();
		for($i=0;$i<$num;$i++)
			{
			$result[$i]=$result[$i]['ads_id'];
			} 
		$results['all_ads_id']=$result;
		$results['rcount']=$num;			
		}
	else
		{
		$results['all_ads_id']='';	
		$results['rcount']=0;	
		}
		//print_R($results);
		return $results;
	//
	}

		
	
	
function sort_results_model($sort,$data,$offset,$result_per_page)
{
	$sql="SELECT *,
CASE rent_type
WHEN '0'
THEN rent /7
WHEN '1'
THEN rent /14
WHEN '2'
THEN rent /30
WHEN '3'
THEN rent /90
WHEN '4'
THEN rent /365
END AS perday
FROM ads where ads_id IN($data[ads_id]) ";

if($sort==2)
$sql .="ORDER BY perday ";
if($sort==1)
$sql .="ORDER BY perday DESC";
$sql .=" limit $offset,$result_per_page";

	$query=$this->db->query($sql);
	//echo $this->db->last_query();
	$results = array();
		
		if ($query->num_rows() > 0)
		{
			$results = $query->result_array();	
			$num_results=$query->num_rows();
			$results=images($num_results,$results);
			/* for($i=0;$i<$num_results;$i++)
			{
			$sqlimg="select images.title as img_title, images.description as img_desc, images.name,images.full_url, images.real_path	from images WHERE `images`.`ads_id`=?  limit 0,1";
			$queryimg = $this->db->query($sqlimg,array($results[$i]['ads_id']));
			//echo "<br>" .$str = $this->db->last_query();exit;
			if ($queryimg->num_rows() > 0)
			{
			$results[$i]['image'] = $queryimg->result_array();
			}$queryimg->free_result();
			} */
			
		}
		
		$query->free_result();
		//echo '<pre>';print_r($results);echo '</pre>';
	return $results;
}



	function sort_results_count($sort,$data)
	{
	$sql="select * from ads  where ads_id IN($data[ads_id])";
	$query = $this->db->query($sql);
	//echo $this->db->last_query();
	//
	if ($query->num_rows() > 0)
		{
			$result = $query->result_array();
			
			//$rcount = $results['rcount'];
			$rcount=$num_results=$query->num_rows();
			for($i=0;$i<$num_results;$i++)
			{
			$result[$i]=$result[$i]['ads_id'];
			} 
			
		}
		$query->free_result();		
		$results['all_ads_id']=$result;
		$results['rcount']=$rcount;
		return $results;
	//
	//$num=$query->num_rows();
	//return $num;
	
	}	
	
}
