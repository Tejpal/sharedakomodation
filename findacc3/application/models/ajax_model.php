
<?php

class Ajax_model extends Model {
	

	function Ajax_model()
	{
		parent::Model();	
	}
	
	function index()
	{
	
	}
	
		//homeslider
	function homeslider($counter)
	{
	$counter=$counter-1;
	$rem=$counter%2;
	/*cmnt start
	//if(!isset($_SESSION['user_id']))
	if(!$this->session->userdata('user_id'))
	{
		if($counter=='0'||$rem=='0')
		{
		$numsql2="select * from ads where sharing_type='1'";
		$numquery = $this->db->query($numsql2);
	if ($numquery->num_rows() > 0)
		{
			$num=$numquery->num_rows();
		}else{return false;}
		
		if($counter>$num)
		{
		$counter=$counter%$num;
		}
		
		
		$sql2="select * from ads where sharing_type='1' order BY addedtime desc limit $counter,1";
		$query = $this->db->query($sql2);
		
		$result = array();
	if ($query->num_rows() > 0)
		{
			$result=$query->result_array();
		}
		$adsid=$result[0]['ads_id'];
		$sql1="select images.*,ads.* from images JOIN ads ON (images.ads_id=ads.ads_id)where images.ads_id=$adsid order BY added_time desc limit 0,1";
		}
		if($rem >'0')
		{
		$numsql2="select * from ads where sharing_type='0' ";
		$numquery = $this->db->query($numsql2);
			
	if ($numquery->num_rows() > 0)
		{
			$num=$numquery->num_rows();
		}
		else{return false;}
		if($counter>$num)
		{
		$counter=$counter%$num;
		}
		
		$sql2="select * from ads where sharing_type='0' order BY addedtime desc limit $counter,1";
		$query = $this->db->query($sql2);
		
		$result = array();
	if ($query->num_rows() > 0)
		{
			$result=$query->result_array();
		}
		$adsid=$result[0]['ads_id'];
		$sql1="select images.*,ads.* from images JOIN ads ON (images.ads_id=ads.ads_id) where images.ads_id=$adsid order BY added_time desc limit 0,1";
		
		}
	}
	else
	{
	//if($_SESSION['sharing_type']=='0')
	if($this->session->userdata('sharing_type')=='0')
		{
		$numsql2="select * from ads where sharing_type='1'";
		$numquery = $this->db->query($numsql2);
			
	if ($numquery->num_rows() > 0)
		{
			$num=$numquery->num_rows();
		}
		else{return false;}
		
		if($counter>=$num)
		{
		$counter=$counter%$num;
		}
		
		
		$sql2="select * from ads where sharing_type='1' order BY addedtime desc limit $counter,1";
		$query = $this->db->query($sql2);
		
		//echo "<br>" .$str = $this->db->last_query();exit;
		$result = array();
		
	if ($query->num_rows() > 0)
		{
			$result=$query->result_array();
		}
		
		$adsid=$result[0]['ads_id'];
		
		
		$sql1="select images.*,ads.* from images JOIN ads ON(images.ads_id=ads.ads_id) where images.ads_id=$adsid order BY added_time desc limit 0,1";
		
		//echo "<br>" .$str = $this->db->last_query();exit;
		}
		//if($_SESSION['sharing_type']=='1')
		if($this->session->userdata('sharing_type')=='1')
		{
		$numsql2="select * from ads where sharing_type='0' ";
		$numquery = $this->db->query($numsql2);
			
	if ($numquery->num_rows() > 0)
		{
			$num=$numquery->num_rows();
		}
		else{return false;}
		if($counter>=$num)
		{
		$counter=$counter%$num;
		
		}
		
		$sql2="select * from ads where sharing_type='0' order BY addedtime desc limit $counter,1";
		
		$query = $this->db->query($sql2);
		//echo "<br>" .$str = $this->db->last_query();exit;
		$result = array();
	if ($query->num_rows() > 0)
		{
			$result=$query->result_array();
		}
		$adsid=$result[0]['ads_id'];
		$sql1="select images.*,ads.* from images JOIN ads ON (images.ads_id=ads.ads_id) where images.ads_id=$adsid order BY added_time desc limit 0,1";
		}
	}
cmnt end	*/
	
	//test slider
	
	
	//if($_SESSION['sharing_type']=='0')
	
		//if($_SESSION['sharing_type']=='1')
		
		$numsql2="select * from ads where `status`='1' and `image_uploaded`='1'";
		$numquery = $this->db->query($numsql2);
		//echo "<br>" .$str = $this->db->last_query();exit;	
	if ($numquery->num_rows() > 0)
		{
			$num=$numquery->num_rows();
			//echo $num;
		}
	else if ($numquery->num_rows() == 0)
		{
		return false;
		}
		
		
		if($counter>=$num)
		{
		$counter=$counter%$num;
		
		}
		
		$sql2="select * from ads where `status`='1' and `image_uploaded`='1' order BY addedtime desc limit $counter,1";
		
		$query = $this->db->query($sql2);
		//echo "<br>" .$str = $this->db->last_query();exit;
		$result = array();
	if ($query->num_rows() > 0)
		{
			$result=$query->result_array();
		}
		$adsid=$result[0]['ads_id'];
		$sql1="select images.*,ads.* from images JOIN ads ON (images.ads_id=ads.ads_id) where images.ads_id=$adsid order BY added_time desc limit 0,1";
	
	//test slider end
	
	$query = $this->db->query($sql1);
	//echo "<br>" .$str = $this->db->last_query();exit;
	$results = array();
	if ($query->num_rows() > 0)
		{
			$results=$query->result_array();
		}
		
		
		
		$query->free_result();
		
		return $results;
	}
	
}

