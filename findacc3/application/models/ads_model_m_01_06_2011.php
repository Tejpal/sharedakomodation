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
	
	// create new ad
    function create_ad($adsData)
    {		
		
		$sql = "INSERT INTO `ads` 
				(	`ads_id` ,`user_id`, `first_name`, `last_name`
					, `phone`, `phone_visibility`
					, `email`, `email_visibility`
					, `street_address`, `city`, `state`
					, `country`, `postal_code`, `address_visibility`
					, `rent`, `rent_type`, `property_type`, `bond`
					, `min_stay`, `max_stay`, `availability`
					, `bills`, `furnished`, `gender`, `smoker`, `age`
					, `orientation`, `diet`, `bed_rooms`, `bath_rooms`
					,`title`, `description`, `community`, `bestfeature1`, `bestfeature2`					
					, `addedtime`
				) 
				VALUES (NULL,?,?,?,?,?,?,?
						,?,?,?,?,?,?
						,?,?,?,?
						,?,?,?
						,?,?,?,?,?
						,?,?,?,?
						,?,?,?,?,?
						,now())
				/*Create new ad*/";
		//echo $sql;
		
		$adsData['phoneVisible'] = (!empty($adsData['phoneVisible']) && in_array($adsData['phoneVisible'],array(0,1)))?$adsData['phoneVisible']:0;
		$adsData['emailVisible'] = (!empty($adsData['emailVisible']) && in_array($adsData['emailVisible'],array(0,1)))?$adsData['emailVisible']:0;
		$adsData['addressVisible'] = (!empty($adsData['addressVisible']) && in_array($adsData['addressVisible'],array(0,1)))?$adsData['addressVisible']:0;
		$availability = '0000-00-00';
		if(!empty($adsData['availability']))
		{
			$availabilityd = explode('/',$adsData['availability']);
			// 2011-03-06
			// 2011-03-06
			// 2011-03-15
			// 04/14/2011
			if(is_array($availabilityd) && count($availabilityd)==3)
				$availability = $availabilityd[2] . '-' . $availabilityd[0] . '-' . $availabilityd[1];		
		}
		$adsData['availability'] = $availability;
		
		$adsData['utilBills'] = (!empty($adsData['utilBills']) && in_array($adsData['utilBills'],array(0,1)))?$adsData['utilBills']:0;
		$adsData['furnish'] = (!empty($adsData['furnish']) && in_array($adsData['furnish'],array(0,1)))?$adsData['furnish']:0;
		
		$this->db->query($sql,
							array(
								$_SESSION['user_id'],$adsData['firstName'],$adsData['lastName'],$adsData['phoneNo'],$adsData['phoneVisible'],$adsData['emailId'],$adsData['emailVisible']
								,$adsData['streetAddress'],$adsData['suburb'],$adsData['state'],$adsData['country'],$adsData['postCode'],$adsData['addressVisible']
								,$adsData['rent'],$adsData['rentDuration'],$adsData['propertyType'],$adsData['bondSecurity']
								,$adsData['minStay'],$adsData['maxStay'],$adsData['availability']
								,$adsData['utilBills'],$adsData['furnish'],$adsData['gender'],$adsData['smoker'],$adsData['age']
								,$adsData['orientation'],$adsData['diet'],$adsData['bedrooms'],$adsData['bathrooms']
								,$adsData['adTitle'],$adsData['adDescription'],$adsData['prefCommunity'],$adsData['propFeature1'],$adsData['propFeature2']								
							)
						);
		//echo "<br>" .$str = $this->db->last_query();
		$affectedFlag = $this->db->affected_rows();	
		
		
		if($affectedFlag>0)
		{
			
			$ads_id = $this->db->insert_id();
			
			$adsData['ads_id'] = $ads_id;
			
			// add Utility Bills included in rent? 
			if($adsData['utilBills']==1)
			{			
				// utilBillsList
				$utilBillsList = $adsData['utilBillsList'];
				
				if( !empty($utilBillsList) && is_array($utilBillsList) && count($utilBillsList)>0)
				{							
					$sql2 = "
							INSERT INTO `adsmetadata` 
							(`ads_meta_id`, `meta_type`, `ads_id`, `name`, `value`, `index`) 
							VALUES ";							
							
					$indx = 0;	
					$meta_type = 1;
					foreach($utilBillsList as $utilBillsList2)
					{
						$indx++;
						if($indx>1)
							$sql2 .= ", ";
						$sql2 .= "(NULL, $meta_type, $ads_id, '$utilBillsList2', '$utilBillsList2', $indx)";						
					}
							
					$sql2 .= ";	/*Insert ad's Utility Bills */";							
					//echo $sql2;

					$this->db->query($sql2);			
					//echo "<br>" .$str = $this->db->last_query();
				}
			}
			
			// Room / Property furnished? 
			if($adsData['furnish']==1)
			{			
				// furnishList
				$furnishList = $adsData['furnishList'];
				
				if( !empty($furnishList) && is_array($furnishList) && count($furnishList)>0)
				{							
					$sql2 = "
							INSERT INTO `adsmetadata` 
							(`ads_meta_id`, `meta_type`, `ads_id`, `name`, `value`, `index`) 
							VALUES ";							
							
					$indx = 0;	
					$meta_type = 2;
					foreach($furnishList as $furnishList2)
					{
						$indx++;
						if($indx>1)
							$sql2 .= ", ";
						$sql2 .= "(NULL, $meta_type, $ads_id, '$furnishList2', '$furnishList2', $indx)";						
					}
							
					$sql2 .= ";	/*Insert ad's Room / Property furnished */";							
					//echo $sql2;

					$this->db->query($sql2);			
					//echo "<br>" .$str = $this->db->last_query();
				}
			}			
			
			return $adsData;
		}
		else
			return $affectedFlag;
		
    } // end of create_ad
	
	
	// update ad
    function update_ad($adsData)
    {		

		$sql = " UPDATE `ads` SET ";
		
		$adsData['phoneVisible'] = (!empty($adsData['phoneVisible']) && in_array($adsData['phoneVisible'],array(0,1)))?$adsData['phoneVisible']:0;
		$adsData['emailVisible'] = (!empty($adsData['emailVisible']) && in_array($adsData['emailVisible'],array(0,1)))?$adsData['emailVisible']:0;
		$adsData['addressVisible'] = (!empty($adsData['addressVisible']) && in_array($adsData['addressVisible'],array(0,1)))?$adsData['addressVisible']:0;
		
		$adsData['utilBills'] = (!empty($adsData['utilBills']) && in_array($adsData['utilBills'],array(0,1)))?$adsData['utilBills']:0;
		$adsData['furnish'] = (!empty($adsData['furnish']) && in_array($adsData['furnish'],array(0,1)))?$adsData['furnish']:0;
		
		$upArr = array();
		
		if(!empty($adsData['firstName']))
		{
			$sql .= "  first_name = ? ";
			$upArr[] = $adsData['firstName'];
		}
		if(!empty($adsData['lastName']))
		{
			if(count($upArr)>0)
				$sql .= "  , ";			
			$sql .= "  last_name = ? ";
			$upArr[] = $adsData['lastName'];
		}			
		if(!empty($adsData['phoneNo']))
		{
			if(count($upArr)>0)
				$sql .= "  , ";			
			$sql .= "  phone = ? ";
			$upArr[] = $adsData['phoneNo'];
		}				
		if(!empty($adsData['phoneVisible']))
		{
			if(count($upArr)>0)
				$sql .= "  , ";			
			$sql .= "  phone_visibility = ? ";
			$upArr[] = $adsData['phoneVisible'];
		}	
		if(!empty($adsData['emailId']))
		{
			if(count($upArr)>0)
				$sql .= "  , ";			
			$sql .= "  email = ? ";
			$upArr[] = $adsData['emailId'];
		}
		if(!empty($adsData['email_visibility']))
		{
			if(count($upArr)>0)
				$sql .= "  , ";			
			$sql .= "  email_visibility = ? ";
			$upArr[] = $adsData['email_visibility'];
		}
		if(!empty($adsData['streetAddress']))
		{
			if(count($upArr)>0)
				$sql .= "  , ";			
			$sql .= "  street_address = ? ";
			$upArr[] = $adsData['streetAddress'];
		}	
		if(!empty($adsData['suburb']))
		{
			if(count($upArr)>0)
				$sql .= "  , ";			
			$sql .= "  city = ? ";
			$upArr[] = $adsData['suburb'];
		}	
		if(!empty($adsData['state']))
		{
			if(count($upArr)>0)
				$sql .= "  , ";			
			$sql .= "  state = ? ";
			$upArr[] = $adsData['state'];
		}	
		if(!empty($adsData['country']))
		{
			if(count($upArr)>0)
				$sql .= "  , ";			
			$sql .= "  country = ? ";
			$upArr[] = $adsData['country'];
		}	
		if(!empty($adsData['postCode']))
		{
			if(count($upArr)>0)
				$sql .= "  , ";			
			$sql .= "  postal_code = ? ";
			$upArr[] = $adsData['postCode'];
		}
		if(!empty($adsData['addressVisible']))
		{
			if(count($upArr)>0)
				$sql .= "  , ";			
			$sql .= "  address_visibility = ? ";
			$upArr[] = $adsData['addressVisible'];
		}	
		if(!empty($adsData['rent']))
		{
			if(count($upArr)>0)
				$sql .= "  , ";			
			$sql .= "  rent = ? ";
			$upArr[] = $adsData['rent'];
		}	
		if(!empty($adsData['rentDuration']))
		{
			if(count($upArr)>0)
				$sql .= "  , ";			
			$sql .= "  rent_type = ? ";
			$upArr[] = $adsData['rentDuration'];
		}	
		if(!empty($adsData['propertyType']))
		{
			if(count($upArr)>0)
				$sql .= "  , ";			
			$sql .= "  property_type = ? ";
			$upArr[] = $adsData['propertyType'];
		}	
		if(!empty($adsData['bondSecurity']))
		{
			if(count($upArr)>0)
				$sql .= "  , ";			
			$sql .= "  bond = ? ";
			$upArr[] = $adsData['bondSecurity'];
		}	
		if(!empty($adsData['minStay']))
		{
			if(count($upArr)>0)
				$sql .= "  , ";			
			$sql .= "  min_stay = ? ";
			$upArr[] = $adsData['minStay'];
		}	
		if(!empty($adsData['maxStay']))
		{
			if(count($upArr)>0)
				$sql .= "  , ";			
			$sql .= "  max_stay = ? ";
			$upArr[] = $adsData['maxStay'];
		}

		if(!empty($adsData['availability']))
		{
			if(count($upArr)>0)
				$sql .= "  , ";			
			$sql .= "  availability = ? ";
			$availability = '0000-00-00';

			$availabilityd = explode('/',$adsData['availability']);
			// 2011-03-06
			// 2011-03-06
			// 2011-03-15
			// 04/14/2011
			if(is_array($availabilityd) && count($availabilityd)==3)
				$availability = $availabilityd[2] . '-' . $availabilityd[0] . '-' . $availabilityd[1];		
			
			$upArr[] = $availability;
		}	
		if(!empty($adsData['utilBills']))
		{
			if(count($upArr)>0)
				$sql .= "  , ";			
			$sql .= "  bills = ? ";
			$upArr[] = $adsData['utilBills'];
		}
		if(!empty($adsData['furnish']))
		{
			if(count($upArr)>0)
				$sql .= "  , ";			
			$sql .= "  furnished = ? ";
			$upArr[] = $adsData['furnish'];
		}
		if(!empty($adsData['gender']))
		{
			if(count($upArr)>0)
				$sql .= "  , ";			
			$sql .= "  gender = ? ";
			$upArr[] = $adsData['gender'];
		}
		if(!empty($adsData['smoker']))
		{
			if(count($upArr)>0)
				$sql .= "  , ";			
			$sql .= "  smoker = ? ";
			$upArr[] = $adsData['smoker'];
		}
		if(!empty($adsData['age']))
		{
			if(count($upArr)>0)
				$sql .= "  , ";			
			$sql .= "  age = ? ";
			$upArr[] = $adsData['age'];
		}
		if(!empty($adsData['orientation']))
		{
			if(count($upArr)>0)
				$sql .= "  , ";			
			$sql .= "  orientation = ? ";
			$upArr[] = $adsData['orientation'];
		}
		if(!empty($adsData['diet']))
		{
			if(count($upArr)>0)
				$sql .= "  , ";			
			$sql .= "  diet = ? ";
			$upArr[] = $adsData['diet'];
		}
		if(!empty($adsData['bedrooms']))
		{
			if(count($upArr)>0)
				$sql .= "  , ";			
			$sql .= "  bed_rooms = ? ";
			$upArr[] = $adsData['bedrooms'];
		}
		if(!empty($adsData['bathrooms']))
		{
			if(count($upArr)>0)
				$sql .= "  , ";			
			$sql .= "  bath_rooms = ? ";
			$upArr[] = $adsData['bathrooms'];
		}
		if(!empty($adsData['adTitle']))
		{
			if(count($upArr)>0)
				$sql .= "  , ";			
			$sql .= "  title = ? ";
			$upArr[] = $adsData['adTitle'];
		}
		if(!empty($adsData['adDescription']))
		{
			if(count($upArr)>0)
				$sql .= "  , ";			
			$sql .= "  description = ? ";
			$upArr[] = $adsData['adDescription'];
		}
		if(!empty($adsData['prefCommunity']))
		{
			if(count($upArr)>0)
				$sql .= "  , ";			
			$sql .= "  community = ? ";
			$upArr[] = $adsData['prefCommunity'];
		}
		if(!empty($adsData['propFeature1']))
		{
			if(count($upArr)>0)
				$sql .= "  , ";			
			$sql .= "  bestfeature1 = ? ";
			$upArr[] = $adsData['propFeature1'];
		}
		if(!empty($adsData['propFeature2']))
		{
			if(count($upArr)>0)
				$sql .= "  , ";			
			$sql .= "  bestfeature2 = ? ";
			$upArr[] = $adsData['propFeature2'];
		}
		if(count($upArr)>0)
			$sql .= "  , ";			
		$sql .= "  addedtime = now() ";

		
		$sql .= " where ads_id = ?";
		$upArr[] = $adsData['ads_id'];
		
		$sql .= " /*update ad*/";
		//echo $sql;		
		
		
			
		/*
		$this->db->query($sql,
							array(
								$_SESSION['user_id'],$adsData['firstName'],$adsData['lastName'],$adsData['phoneNo'],$adsData['phoneVisible'],$adsData['emailId'],$adsData['emailVisible']
								,$adsData['streetAddress'],$adsData['suburb'],$adsData['state'],$adsData['country'],$adsData['postCode'],$adsData['addressVisible']
								,$adsData['rent'],$adsData['rentDuration'],$adsData['propertyType'],$adsData['bondSecurity']
								,$adsData['minStay'],$adsData['maxStay'],$adsData['availability']
								,$adsData['utilBills'],$adsData['furnish'],$adsData['gender'],$adsData['smoker'],$adsData['age']
								,$adsData['orientation'],$adsData['diet'],$adsData['bedrooms'],$adsData['bathrooms']
								,$adsData['adTitle'],$adsData['adDescription'],$adsData['prefCommunity'],$adsData['propFeature1'],$adsData['propFeature2']								
							)
						);
		*/
		
		$this->db->query($sql,$upArr);	
		
		//echo "<br>" .$str = $this->db->last_query();
		$affectedFlag = $this->db->affected_rows();	
		
		$ads_id = $adsData['ads_id'];
		
		// DELETE FROM `findacc`.`adsmetadata` WHERE `adsmetadata`.`ads_meta_id` = 15
		$sqln = "delete from adsmetadata where ads_id=$ads_id; /*delete adsmetadata by ads_id :$ads_id*/";
		$this->db->query($sqln);
		
		//if($affectedFlag>0)
		{			
			//$adsData['ads_id'] = $ads_id;
			
			// add Utility Bills included in rent? 
			if($adsData['utilBills']==1 && !empty($adsData['utilBillsList']))
			{			
				// utilBillsList
				$utilBillsList = $adsData['utilBillsList'];
				
				if( !empty($utilBillsList) && is_array($utilBillsList) && count($utilBillsList)>0)
				{							
					$sql2 = "
							INSERT INTO `adsmetadata` 
							(`ads_meta_id`, `meta_type`, `ads_id`, `name`, `value`, `index`) 
							VALUES ";							
							
					$indx = 0;	
					$meta_type = 1;
					foreach($utilBillsList as $utilBillsList2)
					{
						$indx++;
						if($indx>1)
							$sql2 .= ", ";
						$sql2 .= "(NULL, $meta_type, $ads_id, '$utilBillsList2', '$utilBillsList2', $indx)";						
					}
							
					$sql2 .= ";	/*Insert ad's Utility Bills */";							
					//echo $sql2;

					$this->db->query($sql2);			
					//echo "<br>" .$str = $this->db->last_query();
				}
			}
			
			// Room / Property furnished? 
			if($adsData['furnish']==1 && !empty($adsData['furnishList']))
			{			
				// furnishList
				$furnishList = $adsData['furnishList'];
				
				if( !empty($furnishList) && is_array($furnishList) && count($furnishList)>0)
				{							
					$sql2 = "
							INSERT INTO `adsmetadata` 
							(`ads_meta_id`, `meta_type`, `ads_id`, `name`, `value`, `index`) 
							VALUES ";							
							
					$indx = 0;	
					$meta_type = 2;
					foreach($furnishList as $furnishList2)
					{
						$indx++;
						if($indx>1)
							$sql2 .= ", ";
						$sql2 .= "(NULL, $meta_type, $ads_id, '$furnishList2', '$furnishList2', $indx)";						
					}
							
					$sql2 .= ";	/*Insert ad's Room / Property furnished */";							
					//echo $sql2;

					$this->db->query($sql2);			
					//echo "<br>" .$str = $this->db->last_query();
				}
			}			
			
			//return $adsData;
		}
		//else
			return $affectedFlag;
		
    } // end of update_ad	
	
	
	
	// insert uploaded images in DB
    function add_adImages($adsData)
    {		
		/*
		
		
		INSERT INTO `findacc`.`images` 
		(`image_id`, `ads_id`, `title`, `description`, `name`, `full_url`
		, `path`, `real_path`, `added_time`, `updated_time`, `order`, `status`) 
		VALUES (NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NOW(), CURRENT_TIMESTAMP, NULL, '1');		
							
					$adsCreateData['upload_data']['upload_path'] = $config['upload_path'];
					$adsCreateData['upload_data']['static_fullurl'] = $staticurl;
					$adsCreateData['upload_data']['static_relativeurl'] = 'static/ads_upload/';
					
			Array ( 
					[file_name] => Water_lilies1.jpg [file_type] => image/jpeg 
					[file_path] => D:/xampp/htdocs/findacc/static/ads_upload/ 
					[full_path] => D:/xampp/htdocs/findacc/static/ads_upload/Water_lilies1.jpg 
					[raw_name] => Water_lilies1 [orig_name] => Water_lilies.jpg 
					[client_name] => Water lilies.jpg [file_ext] => .jpg 
					[file_size] => 81.83 [is_image] => 1 [image_width] => 800 
					[image_height] => 600 [image_type] => jpeg 
					[image_size_str] => width="800" height="600" ) 		
		
		*/
		$sql = "INSERT INTO `images` 
				(`image_id`, `ads_id`, `title`, `description`, 
				`name`, `full_url`, `path`, `real_path`
				, `added_time`, `updated_time`, `order`, `status`) 
				VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW(), 1, '1')		
				/*insert uploaded images for an ad*/";
		//echo $sql;		
		
		/*
		$this->db->query($sql,
							array(
								$adsData['ads_id'],$adsData['adTitle'],$adsData['propFeature1']
								,$adsData['upload_data']['file_name'],$adsData['upload_data']['static_fullurl'] . $adsData['upload_data']['file_name']
								,$adsData['upload_data']['upload_path'],$adsData['upload_data']['static_relativeurl']								
							)
						);
		*/

		$this->db->query($sql,
							array(
								$adsData['ads_id'],$adsData['adTitle'],$adsData['propFeature1']
								,$adsData['file_name'],$adsData['static_fullurl'] . $adsData['file_name']
								,$adsData['upload_path'],$adsData['static_relativeurl']								
							)
						);
						
		//echo $str = $this->db->last_query();
		$affectedFlag = $this->db->affected_rows();	
		
		
		if($affectedFlag>0)
		{
			return $adsData;
		}
		else
			return $affectedFlag;
		
    } // end of add_adImages

	// get provider and finder list for home page
	function ads_home_list($n=4)
	{
		// description 	bestfeature1 Best feature 1 	bestfeature2
		
		//$sql = "SELECT ads_id,title,city,description,bestfeature1,bestfeature2,sharing_type,rent,rent_type FROM `ads` where status='1' order by sharing_type desc LIMIT 0 , $n ";
		//$sql .= " union ";
		$sql = " SELECT ads_id,title,city,description,bestfeature1,bestfeature2,sharing_type,rent,rent_type FROM `ads` where status='1' and sharing_type='1' order by addedtime LIMIT 0 , $n /*get provider list for home page*/";
		
		$query = $this->db->query($sql);
		
		$results = array();
		
		if ($query->num_rows() > 0)
		{
			$results['providers'] = $query->result_array();
			
		}
		$query->free_result();
		
		$sql = " SELECT ads_id,title,city,description,bestfeature1,bestfeature2,sharing_type,rent,rent_type FROM `ads` where status='1' and sharing_type='0' LIMIT 0 , $n /*get finder list for home page*/";
		
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0)
		{
			$results['finders'] = $query->result_array();			
			
		}
		$query->free_result();		
		
		
		return $results;
		
	} // end of 

	// filter results
	// by city, state, country
	
	function filter_ads($filters)
	{
		//print_r($filters);
		// description 	bestfeature1 Best feature 1 	bestfeature2
		
		//$sql = "SELECT ads_id,title,city,description,bestfeature1,bestfeature2,sharing_type,rent,rent_type FROM `ads` where status='1' order by sharing_type desc LIMIT 0 , $n ";
		//$sql .= " union ";
		//$sql = " SELECT ads_id,title,city,description,bestfeature1,bestfeature2,sharing_type,rent,rent_type FROM `ads` where status='1' and sharing_type='1' LIMIT 0 , $n /*get provider list for home page*/";
		
		
		// title 	description 	name 	full_url real_path
		
		$sql = " 	SELECT 
						ads.ads_id,ads.title,ads.city,ads.description,ads.bestfeature1,ads.bestfeature2
						,ads.sharing_type,ads.rent,ads.rent_type,ads.availability,ads.updated_date
						,images.title as img_title, images.description as img_desc, images.name
						, images.full_url, images.real_path						
					FROM 
						ads left join images on (images.ads_id=`ads`.ads_id)							
					where ";
		///*			
		if(!empty($filters['city']))			
			$sql .= " ads.city like '%" . $filters['city'] . "%' and	";		
		if(!empty($filters['state']))			
			$sql .= " ads.state like '%" . $filters['state'] . "%' and	";	
		if(!empty($filters['country']))			
			$sql .= " ads.country like '%" . $filters['country'] . "%' and	";	
			
		// search  
		if(!empty($filters['searchFlag']) && $filters['searchFlag']==1)
		{
			if(!empty($filters['searchFrom']) && $filters['searchFrom']==1) // normal header search
			{
				$location = $filters['location'];
				$surrAreas = $filters['surrAreas'];
				$community = $filters['community'];
				$memberType = $filters['memberType'];
				
				if(!empty($memberType) && $memberType==1)			
					$sql .= " ads.sharing_type='1' and	";
				else if(!empty($memberType) && $memberType==0)			
					$sql .= " ads.sharing_type='0' and	";

				if(!empty($location))
				{
					// street_address 	city 	state 	country 	postal_code
					$locations = explode(',',$location);
					$sql .= " ( ";
					if(is_array($locations) && count($locations)>0)
					{
						foreach($locations as $locations2)
						{
							$sql .= " ads.street_address like '%" . $locations2 . "%' or ";
							$sql .= " ads.city like '%" . $locations2 . "%' or ";
							$sql .= " ads.state like '%" . $locations2 . "%' or ";
							$sql .= " ads.street_address like '%" . $locations2 . "%' or ";
							$sql .= " ads.postal_code like '%" . $locations2 . "%' ";						
						}
					}
					else
					{
						$sql .= " ads.street_address like '%" . $location . "%' or ";
						$sql .= " ads.city like '%" . $location . "%' or ";
						$sql .= " ads.state like '%" . $location . "%' or ";
						$sql .= " ads.street_address like '%" . $location . "%' or ";
						$sql .= " ads.postal_code like '%" . $location . "%' ";
					}
					$sql .= " ) and ";
				}				
				
				
			}
		}			
			
			
			
		//*/
		
		// 0 , 10	1
		// 10, 10	2
		// 20, 10	3
		$offset = ($filters['current_page']-1) * $filters['per_page'] ;		
		
		
		$per_page = $filters['per_page'];
		
		$sql .= " 			
						ads.status='1' LIMIT  $offset, $per_page 
					/*filter ads by some filter like city, state, country*/";
		
		$query = $this->db->query($sql);
		//echo $str = $this->db->last_query();
		$results = array();
		
		if ($query->num_rows() > 0)
		{
			$results = $query->result_array();
			
		}
		$query->free_result();		
		
		return $results;
		
	} // end of 

	// filter results count
	// count by city, state, country
	
	function filter_adsCount($filters)
	{
		// description 	bestfeature1 Best feature 1 	bestfeature2
		
		//$sql = "SELECT ads_id,title,city,description,bestfeature1,bestfeature2,sharing_type,rent,rent_type FROM `ads` where status='1' order by sharing_type desc LIMIT 0 , $n ";
		//$sql .= " union ";
		//$sql = " SELECT ads_id,title,city,description,bestfeature1,bestfeature2,sharing_type,rent,rent_type FROM `ads` where status='1' and sharing_type='1' LIMIT 0 , $n /*get provider list for home page*/";
		$sql = " 	SELECT 
						count(ads_id) as rcount 
					FROM 
						`ads` 
					where ";
		//*			
		if(!empty($filters['city']))			
			$sql .= " city like '%" . $filters['city'] . "%' and	";		
		if(!empty($filters['state']))			
			$sql .= " state like '%" . $filters['state'] . "%' and	";	
		if(!empty($filters['country']))			
			$sql .= " country like '%" . $filters['country'] . "%' and	";	
			
		// search  
		if(!empty($filters['searchFlag']) && $filters['searchFlag']==1)
		{
			if(!empty($filters['searchFrom']) && $filters['searchFrom']==1) // normal header search
			{
				$location = $filters['location'];
				$surrAreas = $filters['surrAreas'];
				$community = $filters['community'];
				$memberType = $filters['memberType'];
				
				if(!empty($memberType) && $memberType==1)			
					$sql .= " sharing_type='1' and	";
				else if(!empty($memberType) && $memberType==0)			
					$sql .= " sharing_type='0' and	";

				if(!empty($location))
				{
					// street_address 	city 	state 	country 	postal_code
					$locations = explode(',',$location);
					$sql .= " ( ";
					if(is_array($locations) && count($locations)>0)
					{
						foreach($locations as $locations2)
						{
							$sql .= " street_address like '%" . $locations2 . "%' or ";
							$sql .= " city like '%" . $locations2 . "%' or ";
							$sql .= " state like '%" . $locations2 . "%' or ";
							$sql .= " street_address like '%" . $locations2 . "%' or ";
							$sql .= " postal_code like '%" . $locations2 . "%' ";						
						}
					}
					else
					{
						$sql .= " street_address like '%" . $location . "%' or ";
						$sql .= " city like '%" . $location . "%' or ";
						$sql .= " state like '%" . $location . "%' or ";
						$sql .= " street_address like '%" . $location . "%' or ";
						$sql .= " postal_code like '%" . $location . "%' ";
					}
					$sql .= " ) and ";
				}				
				
				
			}
		}		
			
		//*/
		
		$sql .= " 			
						status='1'
					/*filter ads count by some filter like city, state, country*/";
		
		$query = $this->db->query($sql);
		//echo $str = $this->db->last_query();
		$results = array();
		$rcount = 0;
		if ($query->num_rows() > 0)
		{
			$results = $query->row_array();
			$rcount = $results['rcount'];
		}
		$query->free_result();		
		
		return $rcount;
		
	} // end of 


	// filter my ads
	
	function filter_myads($filters)
	{
		//print_r($filters);
		// description 	bestfeature1 Best feature 1 	bestfeature2
		
		//$sql = "SELECT ads_id,title,city,description,bestfeature1,bestfeature2,sharing_type,rent,rent_type FROM `ads` where status='1' order by sharing_type desc LIMIT 0 , $n ";
		//$sql .= " union ";
		//$sql = " SELECT ads_id,title,city,description,bestfeature1,bestfeature2,sharing_type,rent,rent_type FROM `ads` where status='1' and sharing_type='1' LIMIT 0 , $n /*get provider list for home page*/";
		
		
		// title 	description 	name 	full_url real_path
		
		if(!empty($filters['page_about']) && $filters['page_about']==1){		
			$sql = " 	SELECT 
							ads.ads_id,ads.title,ads.city,ads.description,ads.bestfeature1,ads.bestfeature2
							,ads.sharing_type,ads.rent,ads.rent_type,ads.availability,ads.updated_date,ads.addedtime
							,images.title as img_title, images.description as img_desc, images.name
							, images.full_url, images.real_path						
						FROM 
							ads left join images on (images.ads_id=`ads`.ads_id)							
						where ads.user_id=" . $_SESSION['user_id'] . ' and ';
		} else if(!empty($filters['page_about']) && $filters['page_about']==2){

			$sql = " 	SELECT 
							ads.ads_id,ads.title,ads.city,ads.description,ads.bestfeature1,ads.bestfeature2
							,ads.sharing_type,ads.rent,ads.rent_type,ads.availability,ads.updated_date,ads.addedtime
							,images.title as img_title, images.description as img_desc, images.name
							, images.full_url, images.real_path
							, slad.shortlisted_time
						FROM 
							shortlistedads as slad inner join ads on (ads.ads_id=slad.ads_id)
							left join images on (images.ads_id=`ads`.ads_id)							
						where ads.user_id=" . $_SESSION['user_id'] . " and slad.user_id=" . $_SESSION['user_id'] . ' and ';
						
		} else if(!empty($filters['page_about']) && $filters['page_about']==3){


		}					
		/*			
		if(!empty($filters['city']))			
			$sql .= " ads.city like '%" . $filters['city'] . "%' and	";		
		if(!empty($filters['state']))			
			$sql .= " ads.state like '%" . $filters['state'] . "%' and	";	
		if(!empty($filters['country']))			
			$sql .= " ads.country like '%" . $filters['country'] . "%' and	";	
		
		// search  
		if(!empty($filters['searchFlag']) && $filters['searchFlag']==1)
		{
			if(!empty($filters['searchFrom']) && $filters['searchFrom']==1) // normal header search
			{
				$location = $filters['location'];
				$surrAreas = $filters['surrAreas'];
				$community = $filters['community'];
				$memberType = $filters['memberType'];
				
				if(!empty($memberType) && $memberType==1)			
					$sql .= " ads.sharing_type='1' and	";
				else if(!empty($memberType) && $memberType==0)			
					$sql .= " ads.sharing_type='0' and	";

				if(!empty($location))
				{
					// street_address 	city 	state 	country 	postal_code
					$locations = explode(',',$location);
					$sql .= " ( ";
					if(is_array($locations) && count($locations)>0)
					{
						foreach($locations as $locations2)
						{
							$sql .= " ads.street_address like '%" . $locations2 . "%' or ";
							$sql .= " ads.city like '%" . $locations2 . "%' or ";
							$sql .= " ads.state like '%" . $locations2 . "%' or ";
							$sql .= " ads.street_address like '%" . $locations2 . "%' or ";
							$sql .= " ads.postal_code like '%" . $locations2 . "%' ";						
						}
					}
					else
					{
						$sql .= " ads.street_address like '%" . $location . "%' or ";
						$sql .= " ads.city like '%" . $location . "%' or ";
						$sql .= " ads.state like '%" . $location . "%' or ";
						$sql .= " ads.street_address like '%" . $location . "%' or ";
						$sql .= " ads.postal_code like '%" . $location . "%' ";
					}
					$sql .= " ) and ";
				}				
				
				
			}
		}		
			
		//*/
		
		// 0 , 10	1
		// 10, 10	2
		// 20, 10	3
		$offset = ($filters['current_page']-1) * $filters['per_page'] ;		
		
		
		$per_page = $filters['per_page'];
		
		$sql .= " 			
						ads.status='1' LIMIT  $offset, $per_page 
					/*filter ads by some filter like city, state, country*/";
		
		$query = $this->db->query($sql);
		//echo $str = $this->db->last_query();
		$results = array();
		
		if ($query->num_rows() > 0)
		{
			$results = $query->result_array();
			
		}
		$query->free_result();		
		
		return $results;
		
	} // end of 

	// filter my ads count

	function filter_myadsCount($filters)
	{
		if(!empty($filters['page_about']) && $filters['page_about']==1){
			$sql = " 	SELECT 
							count(ads_id) as rcount 
						FROM 
							`ads` 
						where user_id=" . $_SESSION['user_id'] . ' and ';
			
			$sql .= " 			
							status='1'
						/*filter my ads count*/";
		} else if(!empty($filters['page_about']) && $filters['page_about']==2){

			$sql = " 	SELECT 
							count(a.ads_id) as rcount 
						FROM 
							`ads` as a join shortlistedads as slad on (slad.ads_id=a.ads_id)
						where a.user_id=" . $_SESSION['user_id'] . " and slad.user_id=" . $_SESSION['user_id'] . ' and ';
			
			$sql .= " 			
							a.status='1'
						/*filter my ads count*/";
						
		} else if(!empty($filters['page_about']) && $filters['page_about']==3){


		}
		
		$query = $this->db->query($sql);
		//echo $str = $this->db->last_query();
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
		$sql = " SELECT * FROM `ads` where ads_id=? and ";
		
		$sql .= " status='1' /*get ads full details*/ ";
		
		$query = $this->db->query($sql,array($ads_id));
		
		//echo $str = $this->db->last_query();
		$results = array();
		
		if ($query->num_rows() > 0)
		{
			$results = $query->row_array();
			
		}
		$query->free_result();		
		
		return $results;
		
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
		*/		
		
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
	
	
	// add to shortlist
	function addToShortList($ads_id,$user_id)
	{
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
		return $affectedFlag;		
	} // end of addToShortList
	
	

		
	
}
