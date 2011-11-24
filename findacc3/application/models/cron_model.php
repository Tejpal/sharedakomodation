<?

class cron_model extends Model 
{

	// init 
    function cron_model()
    {
        parent::Model();
    }

	function cron_automated($inboxdata) 
	{
	$sql="select * from ads where status='1'and DATEDIFF( CURDATE( ) , addedtime ) = '23'";
	$query=$this->db->query($sql);
	//echo "<br>" .$str = $this->db->last_query();exit;
	$results=array();
	if ($query->num_rows() > 0)
		{
			$results = $query->result_array();
			
			$num_results=$query->num_rows();
			for($i=0;$i<$num_results;$i++)
			{
			
			$sql1="INSERT INTO `sharedak_findacc`.`adsmessages` (`ads_message_id`, `ads_id`, `users_id`, `firstname`, `lastname`, `contact_email`,`subject`, `message`, `contact_date`, `read`) VALUES (NULL, ?, ?, ?, '', '',?, ?, CURRENT_TIMESTAMP, '0');";
			$query1=$this->db->query($sql1,array($results[$i]['ads_id'],$results[$i]['user_id'],'Shared Akomodation',$inboxdata['subject'],$inboxdata['message']." ".$inboxdata['link']));
			//echo "<br>" .$str = $this->db->last_query();exit;
			}
		}
		$query->free_result();
		return $results;
	}
	
		function cron_automated_count() 
	{
	$sql="select * from ads where status='1' and DATEDIFF( CURDATE( ) , addedtime ) = '23'";
	$query=$this->db->query($sql);
	//echo "<br>" .$str = $this->db->last_query();exit;
	$results=array();
	if ($query->num_rows() > 0)
		{
			$results = $query->num_rows();
			
		}
		
		return $results;
	}
	
	function auto_deactivate_model($deactivatedata)
	{
	$sql="select * from ads where status='1' and DATEDIFF( CURDATE( ) , addedtime ) = '31'";
	$query=$this->db->query($sql);
	//echo "<br>" .$str = $this->db->last_query();exit;
	$results=array();
	if ($query->num_rows() > 0)
		{
			$results = $query->result_array();
			$num_results=$query->num_rows();
			for($i=0;$i<$num_results;$i++)
			{
			$sqlupdate="UPDATE ads SET `status` = '0' WHERE `ads`.`ads_id`=? ";
			$queryupdate = $this->db->query($sqlupdate,array($results[$i]['ads_id']));
			//echo "<br>" .$str = $this->db->last_query();exit;
			$sql1="INSERT INTO `sharedak_findacc`.`adsmessages` (`ads_message_id`, `ads_id`, `users_id`, `firstname`, `lastname`, `contact_email`,`subject`, `message`, `contact_date`, `read`) VALUES (NULL, ?, ?, ?, '', '',?, ?, CURRENT_TIMESTAMP, '0');";
			$query1=$this->db->query($sql1,array($results[$i]['ads_id'],$results[$i]['user_id'],'Shared Akomodation',$deactivatedata['subject'],$deactivatedata['message']." ".$deactivatedata['link']));
			//echo "<br>" .$str = $this->db->last_query();exit;
			}
			
			
		}
		
		return $results;
	}
	
	function auto_deactivate_model_count()
	{
	$sql="select * from ads where status='1' and DATEDIFF( CURDATE( ) , addedtime ) = '31'";
	$query=$this->db->query($sql);
	//echo "<br>" .$str = $this->db->last_query();exit;
	$results=array();
	if ($query->num_rows() > 0)
		{
			$results = $query->num_rows();
			
		}
		
		return $results;
	}
	
	
}
