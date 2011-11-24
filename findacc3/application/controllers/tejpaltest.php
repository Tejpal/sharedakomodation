<?php

class tejpaltest extends Controller {
	

	function tejpaltest()
	{
		parent::Controller();	
	}
	
	function index()
	{
	
	if(isset($_COOKIE['username'])){echo 'hello';}
	}
	function test()
	{
	
	$this->load->library('benchmark');
	
	$this->benchmark->mark('code_start');

 echo "llllllllllllllllllllllllllllll";

$this->benchmark->mark('code_end');

echo $this->benchmark->elapsed_time('code_start', 'code_end');
	
	
	echo  'its a test';
	 echo $this->benchmark->memory_usage();
	//unlink('static/ads_upload/img1_wcc937ee967595c02dba5b047440fccb6.jpg');
	}

function test3()
{	
$myimage = "http://www.sharedakomodation.com/findacc3/static/ads_upload/img2_w0c8938e9631d026a6488fe3b6d775b05.JPG";
$size = getimagesize($myimage);
print_r($size);
}	
		function test2()
		{
			
			$this->load->view('test');
			
		}
		
		function filter($val='')
		{
		$this->load->model('ads_model');
		$results['result']=$this->ads_model->test($val);
		$this->load->view('test1',$results);
		}
		
		
}
/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */