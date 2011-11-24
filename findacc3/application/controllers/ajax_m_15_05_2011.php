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
		$data['data'] = $this->input->post('data');;
		$data['dummydata'] = $this->input->post('dummydata');;
		$data['getId'] = $this->input->post('getId');;
		$data['limit'] = $this->input->post('limit');;
		$data['match'] = $this->input->post('match');;
		
		
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
	
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */