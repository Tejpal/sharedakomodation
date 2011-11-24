<?php

function getCommunityList()
{
	$obj =& get_instance();
	$obj->load->model('ads_model');
	$list	=	$obj->ads_model->getCommunityList();
	
	return $list;
}


function displayList($lists, $selected=array())
{
	$dropdownhtml = '';
	//print_r($lists);
	//print_r($selected);
	foreach($lists as $key=>$value)
	{
		if(in_array($key,$selected) and $dropdownhtml=='')
			$dropdownhtml .= $value ;
		else if(in_array($key,$selected) )
			$dropdownhtml .= ', ' .$value ;		
	}
	
	return $dropdownhtml;
}



function getList($lists, $selected='')
{
$selected_1 = explode(",", $selected);
	$dropdownhtml = '';
	
	//echo '<pre>';print_r($lists);echo '</pre>';
	foreach($lists as $key=>$value)
	{//echo $value['country'];
		 if(in_array($key,$selected_1) and $dropdownhtml=='')
			 $dropdownhtml .= $value['community'] ;
		 else if(in_array($key,$selected_1) )
			 $dropdownhtml .= ', ' .$value['community'] ;
	
	}
	
	
	return $dropdownhtml;
}


function getList1($lists, $selected='')
{
$selected_1 = explode(",", $selected);
	$dropdownhtml = '';
	
	//echo '<pre>';print_r($lists);echo '</pre>';
	foreach($lists as $key=>$value)
	{//echo $value['country'];
		 if(in_array($value['id'],$selected_1) and $dropdownhtml=='')
			 $dropdownhtml .= $value['community'] ;
		 else if(in_array($value['id'],$selected_1) )
			 $dropdownhtml .= ', ' .$value['community'] ;
	
	}
	
	
	return $dropdownhtml;
}



function displayDropdown($lists, $name='', $selected=array(), $classes='')
{
	$dropdownhtml = '';
	
	if(empty($name))
		$name = 'dd_list_' . rand(1, 1000000);
		
	$dropdownhtml .= '<select class="' . $classes . '" name="' . $name .'" id="' . $name .'" >';
	foreach($lists as $key=>$value)
	{
		//if($key==$selected)
		if(in_array($key,$selected))
			$dropdownhtml .= '<option  name="dd_nm_' . $key . '" value="' . $key . '" selected >' . $value . '</option>';
		else
			$dropdownhtml .= '<option  name="dd_nm_' . $key . '" value="' . $key . '" >' . $value . '</option>';
			
	}
	$dropdownhtml .= '</select>';
	
	return $dropdownhtml;
}




//display dropdown values as name

function displayDropdown_alt($lists, $name='', $selected=array(), $classes='')
{
	$dropdownhtml = '';
	
	if(empty($name))
		$name = 'dd_list_' . rand(1, 1000000);
		
	$dropdownhtml .= '<select class="' . $classes . '" name="' . $name .'" id="' . $name .'" >';
	foreach($lists as $key=>$value)
	{
		//if($key==$selected)
		if(in_array($key,$selected))
			$dropdownhtml .= '<option  name="dd_nm_' . $key . '" value="' . $value . '" selected >' . $value . '</option>';
		else
			$dropdownhtml .= '<option  name="dd_nm_' . $key . '" value="' . $value . '" >' . $value . '</option>';
			
	}
	$dropdownhtml .= '</select>';
	
	return $dropdownhtml;
}




function displayCheckboxs($lists, $name='', $selectedList=array(), $classes='',$selval='')
{
	
	$checkboxhtml = '';
	$checkboxhtml1 = '';
	$checkboxhtml2 = '';
	if(empty($name)){
		$name = 'dd_list_' . rand(1, 1000000) . '[]';
		}
	$nlist = count($lists);
	///print '--------------------------------------' . $nlist;
	$middle = ceil($nlist/2);
	//print "middle : $middle";
	$i = 0;
	$checked = '';
	foreach($lists as $key=>$value)
	{
		//$i++;
		$checked = '';
		
		if($selval==1)
			{
			if(in_array($value,$selectedList))
		
				{
		//echo 'hello';
				$checked = ' checked="checked" ';
				}
			}
		else
			{
			if(in_array($key,$selectedList))
		
				{
		//echo 'hello';
				$checked = ' checked="checked" ';
				}
			}
		if($selval==1){$check_value=$value;}else{$check_value=$key;}	
		$i++;
		if($i<=$middle)
		{	
			$checkboxhtml1 .= 
							'<li>
								<input type="checkbox" name="' . $name . '" id="' . $key . '-chck" value="' .$check_value . '" ' . $checked . ' />
								<label for="' . $key . '-chck">' . $value . '</label>
							</li>';		
		}
		else
		{
			$checkboxhtml2 .= 
							'<li>
								<input type="checkbox" name="' . $name . '" id="' . $key . '-chck" value="' . $check_value . '" ' . $checked . '  />
								<label for="' . $key . '-chck">' . $value . '</label>
							</li>';					
		}
	
	}
	
	/*	
	$dropdownhtml .= '<select class="' . $classes . '" name="' . $name .'" id="' . $name .'" >';
	foreach($lists as $key=>$value)
	{
		if($key==$selected)
			$dropdownhtml .= '<option  name="dd_nm_' . $key . '" value="' . $key . '" selected >' . $value . '</option>';
		else
			$dropdownhtml .= '<option  name="dd_nm_' . $key . '" value="' . $key . '" >' . $value . '</option>';
			
	}
	$dropdownhtml .= '</select>';
	*/
	if(!empty($checkboxhtml1))
	{
		$checkboxhtml .= '<ul>' . $checkboxhtml1 . '</ul>';
	}
	if(!empty($checkboxhtml2))	
	{
		$checkboxhtml .= '<ul>' . $checkboxhtml2 . '</ul>';
	}
	
	return $checkboxhtml;
}
//

function displayRadio($lists, $name='', $selectedList=array(), $classes='')
{
	
	$radiohtml = '';
	$radiohtml1 = '';
	$radiohtml2 = '';
	if(empty($name)){
		$name = 'dd_list_' . rand(1, 1000000) . '[]';
		}
	$nlist = count($lists);
	///print '--------------------------------------' . $nlist;
	$middle = ceil($nlist/2);
	//print "middle : $middle";
	$i = 0;
	$checked = '';
	foreach($lists as $key=>$value)
	{
		//$i++;
		$checked = '';
		
		if(in_array($key,$selectedList))
		
		{
		//echo 'hello';
			$checked = ' checked="checked" ';
		}
		$i++;
		if($i<=$middle)
		{
			$radiohtml1 .= 
							'<li>
								<input type="radio" name="' . $name . '" id="' . $key . '-radio" value="' . $key . '" ' . $checked . ' />
								<label for="' . $key . '-chck">' . $value . '</label>
							</li>';		
		}
		else
		{
			$radiohtml2 .= 
							'<li>
								<input type="radio" name="' . $name . '" id="' . $key . '-radio" value="' . $key . '" ' . $checked . '  />
								<label for="' . $key . '-chck">' . $value . '</label>
							</li>';					
		}
	
	}
	
	
	if(!empty($radiohtml1))
	{
		$radiohtml .= '<ul>' . $radiohtml1 . '</ul>';
	}
	if(!empty($radiohtml2))	
	{
		$radiohtml .= '<ul>' . $radiohtml2 . '</ul>';
	}
	
	return $radiohtml;
}
//




function encodeurl($adTitle)
{
	///*
	$adTitle = str_replace(' ','-',$adTitle);
	$adTitle = str_replace(',','-',$adTitle);
	$adTitle = str_replace('?','-',$adTitle);
	$adTitle = str_replace('\'','-',$adTitle);
	$adTitle = str_replace('"','-',$adTitle);
	$adTitle = str_replace('(','',$adTitle);	
	$adTitle = str_replace(')','',$adTitle);	
	//*/
	/*
	$patterns = array();
	$patterns[0] = '/ /';
	$patterns[1] = '/,/';
	$patterns[2] = '/\'/';
	$patterns[3] = '/"/';
	$patterns[4] = '/(/';
	
	$replacements = array();
	$replacements[4] = '';
	$replacements[3] = '-';
	$replacements[2] = '-';
	$replacements[1] = '-';
	$replacements[0] = '-';
	
	$adTitle = preg_replace($patterns, $replacements, $adTitle);		
	*/
	$adTitle = urlencode($adTitle);
	return $adTitle;
}


function getStateList()
{
	return array(
					'Any'=>'Any',
					'New South Wales'=>'New South Wales',						
					'Victoria'=>'Victoria',						
					'Queensland'=>'Queensland',						
					'Western Australia'=>'Western Australia',
					'Tasmania'=>'Tasmania',
					'South Australia'=>'South Australia'					
				);							
}

function getCountryList()
{
	return array(
					'Any'=>'Any',
					'Australia'=>'Australia',						
					'India'=>'India',						
					'UK'=>'UK'				
				);							
}

// Rent Type / Rent Duration

function getRentTypeList()
{
	return array(
					'Weekly',
					'Fortnightly',						
					'Monthly',						
					'Quarterly',						
					'Yearly'							
				);							
}

function getStayList()
{
	return array(
					'Any',
					'1 month',						
					'2 month',						
					'3 month',						
					'6 month',
					'1 year',
					'1 year 3 months',
					'1 year 6 months',
					'2 years'
				);							
}

function getPropertyType()
{
	return array(
					'Any',
					'Unit/Apartment',						
					'House',						
					'Townhouse',						
					'Building',
					'Granny Flat'
				);							
}

function getParkingType()
{
	return array(
					'Any',
					'Garage parking',						
					'No Parking',						
					'On-street parking',						
					
				);							
}

function getOccupationType()
{
	return array(
	                'Any',
					'Student',
					'Professional',						
				);							
}

function getNoList()
{
	return array(
					'Any',
					'1',						
					'2',						
					'3',						
					'4',
					'5'
				);							
}

function getUtilBillsList()
{
	return array(
					'Phone'=>'Phone',
					'Internet'=>'Internet',						
					'Electricity'=>'Electricity',						
					'Cable TV'=>'Cable TV',						
					'Water'=>'Water',
					'Gas'=>'Gas'
				);							
}

function getFurnishedList()
{
	return array(
					'Phone'=>'Phone',
					'TV'=>'TV',						
					'Air conditioning'=>'Air conditioning',
					'Internet'=>'Internet',				
					'Microwave'=>'Microwave',
					'Couch/Sofa'=>'Couch/Sofa',
					'Refrigerator'=>'Refrigerator',					
					'Music System'=>'Music System'						
				);							
}

function getGenderList()
{
	return array(
					'Any',
					'Male',						
					'Female',						
					'Couple'
				);							
}

function getAgeGroupList()
{
	return array(
					'Any',
					'18-25 yrs',						
					'26-35 yrs',						
					'36-45',
					'46-55',
					'55+'
				);							
}

function getSmokerList()
{
	return array(
					'Any',
					'Smoker',						
					'Non Smoker',						
					'Smoke Outside Only'
				);							
}

function getOrientationList()
{
	return array(
					'Any',
					'Straight',						
					'Gay/Lesbian',						
					'Bisexual'
				);							
}

function getDietList()
{
	return array(
					'Any',
					'Vegetarian',						
					'Non Vegetarian',						
					'Non Veg(Halal)'
				);							
}

function getPriceRange()
{
	return array(
					'0'=>'0',
					'100'=>'100',						
					'200'=>'200',						
					'300'=>'300',
					'400'=>'400',
					'500'=>'500'
				);
}


function showupdateddate($udate)
{
	
	$cdate = date('Y-m-d h:i:s');
	//echo " $cdate - $udate ";
	
	$str = 'Today';
	$days = count_days( strtotime($udate), time() );
	if($days==1)
	{
		$str = 'a day ago';
	}
	else if($days>1)
	{
		$str = "$days days ago";
	}		
	return $str;
}

// Will return the number of days between the two dates passed in
function count_days( $a, $b )
{
    // First we need to break these dates into their constituent parts:
    $gd_a = getdate( $a );
    $gd_b = getdate( $b );
    // Now recreate these timestamps, based upon noon on each day
    // The specific time doesn't matter but it must be the same each day
    $a_new = mktime( 12, 0, 0, $gd_a['mon'], $gd_a['mday'], $gd_a['year'] );
    $b_new = mktime( 12, 0, 0, $gd_b['mon'], $gd_b['mday'], $gd_b['year'] );
    // Subtract these two numbers and divide by the number of seconds in a
    // day. Round the result since crossing over a daylight savings time
    // barrier will cause this time to be off by an hour or two.
    return round( abs( $a_new - $b_new ) / 86400 );
} 
function images($num_results,$results)
{
$obj =& get_instance();
$obj->load->model('ads_model');
return $list=$obj->ads_model->image($num_results,$results);
//print_r($list);
}
?>