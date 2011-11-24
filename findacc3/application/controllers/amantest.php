<?php

class Amantest extends Controller {
	

	function Amantest()
	{
		parent::Controller();	
	}
	
	function index()
	{
	
	}
	function test()
	{
	$this->load->view('header1');
	$this->load->view('upload_test');
	$this->load->view('footer');
	}
	
	
	// update
	function locations2($title='',$id=0)
	{
		$this->load->view('greyboxtest');
	}
	
	function propertydetails($title='',$id=0)
	{
		$this->load->view('createad/property_details');
	}
	function providerdetails($title='',$id=0)
	{
		$this->load->view('createad/provider_details');
	}
	function providerpref($title='',$id=0)
	{
		$this->load->view('createad/provider_pref');
	}
	function adinformation($title='',$id=0)
	{
		$this->load->view('createad/ad_information');
	}
	function confirmpost($title='',$id=0)
	{
		$this->load->view('createad/confirm_post');
	}
	
	function upfiles($title='',$id=0)
	{
		echo 'uploaded';
	}
	
	function submittest($code='')
	{
	
	
		$adsData=array();
		$adsData['editFlag']=$editFlag=$_POST['editFlag'];
		
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
			$adsData['suburb']=$suburb=$_POST['suburb'];
			$adsData['state']=$state=$_POST['state'];
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
			
			$adsData['title']=$Title=$_POST['adTitle'];
			$adsData['propFeature1']=$propFeature1=$_POST['propFeature1'];
			$adsData['propFeature2']=$propFeature2=$_POST['propFeature2'];
			$adsData['adDescription']=$adDescription=$_POST['adDescription'];
			
				if($editFlag==1)
					{
					$adsData['ads_id']=$ads_id=$_POST['ads_id'];
					}
	
			
			}
		
		if($code=='stepthree')
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
		if($code=='stepfour')
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
		//print_r($_POST);exit;
		$this->load->model('ads_model');
		//$this->ads_model->submittest($adsData,$code);
		
	}
	
	
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */