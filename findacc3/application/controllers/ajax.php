<?php
class Ajax extends Controller {
	

	function Ajax()
	{
		parent::Controller();	
	}
	
	function index()
	{
	
	}
	
	// update
	function locations($title='',$id=0)
	{
		$this->load->model('user_model');
		
		/*
			data		al
			dummydata	dummyData
			getId		1
			limit		10
			match		contains		
		*/
		$data = array();
		$data['data'] = $this->input->post('data');
		$data['dummydata'] = $this->input->post('dummydata');
		$data['getId'] = $this->input->post('getId');
		$data['limit'] = $this->input->post('limit');
		$data['match'] = $this->input->post('match');
		
		
		$locations	=	$this->user_model->locations($data);		
		$list = 0;
		if(!empty($locations) && is_array($locations) && count($locations)>0 )
		{
			$list = '';
			foreach($locations as $row)
			{
				$list .= $row['id']."-";
				$list .= strtolower($row['name'])."|";
			}

			// send all collected data to the client
			$list = substr($list,0,-1);
		}
		echo $list;
	}
	
	
	// update
	function locations2($title='',$id=0)
	{
		$this->load->model('user_model');
		
		/*
			data		al
			dummydata	dummyData
			getId		1
			limit		10
			match		contains		
		*/
		$data = array();
		$data['data'] = $this->input->post('data');
		$data['dummydata'] = $this->input->post('dummydata');
		$data['getId'] = $this->input->post('getId');
		$data['limit'] = $this->input->post('limit');
		$data['match'] = $this->input->post('match');
		
		
		$locations	=	$this->user_model->locations2($data);		
		$list = 0;
		if(!empty($locations) && is_array($locations) && count($locations)>0 )
		{
			$list = '';
			foreach($locations as $row)
			{
				//$list .= $row['id']."-";
				$list .= $row['ID']."-";
				
				// pcode 	locality 	state
				//$str = $row['locality'] . ' ' . $row['state'] . ' ' . $row['pcode'];
				$str = $row['City'].', '. substr($row['ISO2'],2).' '.$row['ZIP'];
				
				$str = str_replace('-','',$str);
				$str = str_replace('|','',$str);
				
				//$list .= strtolower($str)."|";
				$list .= $str."|";
			}

			// send all collected data to the client
			$list = substr($list,0,-1);
		}
		echo $list;
	}
	
	
	/////////////////Postcode start
		function postcode($title='',$id=0)
	{
		$this->load->model('user_model');
		
		/*
			data		al
			dummydata	dummyData
			getId		1
			limit		10
			match		contains		
		*/
		$data = array();
		$data['data'] = $this->input->post('data');
		$data['dummydata'] = $this->input->post('dummydata');
		$data['getId'] = $this->input->post('getId');
		$data['limit'] = $this->input->post('limit');
		$data['match'] = $this->input->post('match');
		
		
		$postcode	=	$this->user_model->postcode($data);		
		$list = 0;
		if(!empty($postcode) && is_array($postcode) && count($postcode)>0 )
		{
			$list = '';
			foreach($postcode as $row)
			{
				//$list .= $row['id']."-";
				$list .= $row['ID']."-";
				
				// pcode 	locality 	state
				//$str = $row['locality'] . ' ' . $row['state'] . ' ' . $row['pcode'];
				$str = $row['ZIP'].' '. $row['City'].', '.substr($row['ISO2'],2);
				
				$str = str_replace('-','',$str);
				$str = str_replace('|','',$str);
				
				//$list .= strtolower($str)."|";
				$list .= $str."|";
			}

			// send all collected data to the client
			$list = substr($list,0,-1);
		}
		echo $list;
	}
		
	////////////////post code end
	
	function homeslider($counter)
	{
		$this->load->model('ajax_model');
		$this->result2=$this->ajax_model->homeslider($counter);
		$data1['result2']=$this->result2;
		if(empty($data1['result2'])){
		$staticurl = $this->config->item('static_url');
		$sliderContent = '<img src="'.$staticurl.'images/defaulthomepic.jpg" />
		<p class="detailBar"> No Ads are available yet</p>';
		echo $sliderContent;}
		if(!empty($data1['result2'])){
		$this->load->view('homeslider',$data1);
		}
	
	}
	
	
}
/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */