<?php

class cron extends Controller {
	
		

	function cron()
	{
		parent::Controller();	
	}
	
	function index()
	{
		
	}
	
	function automated()
	{$this->load->library('email');
	$base_url=$this->config->item('base_url');
	$this->load->model('cron_model');
	$subject='7 days left for your ad to expire';
	$message='Only 7 seven days left for your ad to expire,you can extend your ad now.';
	$link='click the link below to extend your ad ';
	$link .=$base_url;
	$youremail='sharedakomodation@shak.com.com';
	
	$inboxdata['link']=$link;
	$inboxdata['youremail']=$youremail;
	$inboxdata['message']=$message;
	$inboxdata['subject']=$subject;
	$ads=$this->cron_model->cron_automated($inboxdata);
	if(empty($ads)){exit;}
	
	$ads_count=$this->cron_model->cron_automated_count();
	for($i=0;$i<$ads_count;$i++)
	{ $to=$ads[$i]['email'];
	  $ad_info=$ads[$i]['title'].",".$ads[$i]['street_address'].",".$ads[$i]['city']."-".$ads[$i]['postal_code'].",".$ads[$i]['state'].",".$ads[$i]['country'];
	
	$this->email->to($to);
	$this->email->from($youremail,'Shared akomodation');
	$this->email->subject('7 days left for your ad to expire');
	$this->email->message($message." ".$ad_info);
	$this->email->send();
	//echo $this->email->print_debugger();
	}
	
 }
 function auto_deactivate()
 {
 $this->load->library('email');
 $base_url=$this->config->item('base_url');
 $subject='Your ad is expired';
	$message='Your ad have been deactivated as its 30 days time period have expired.';
	$link='click the link below to extend your ad ';
	$link .=$base_url;
	
	$youremail='sharedakomodation@shak.com';
	
	$deactivatedata['link']=$link;
	$deactivatedata['youremail']=$youremail;
	$deactivatedata['message']=$message;
	$deactivatedata['subject']=$subject;
 
 $this->load->model('cron_model');
 $ads_deactivate=$this->cron_model->auto_deactivate_model($deactivatedata);
 if(empty($ads_deactivate)){exit;}
 $ads_deactivate_count=$this->cron_model->auto_deactivate_model_count();
 
 for($i=0;$i<$ads_deactivate_count;$i++)
	{ $to=$ads_deactivate[$i]['email'];
	  $ad_info=$ads_deactivate[$i]['title'].",".$ads_deactivate[$i]['street_address'].",".$ads_deactivate[$i]['city']."-".$ads_deactivate[$i]['postal_code'].",".$ads_deactivate[$i]['state'].",".$ads_deactivate[$i]['country'];
	
	$this->email->to($to);
	$this->email->from($youremail,'Shared akomodation');
	$this->email->subject('Your ad is expired');
	$this->email->message($message." ".$ad_info);
	$this->email->send();
	//echo $this->email->print_debugger();
	}
 }

 }
