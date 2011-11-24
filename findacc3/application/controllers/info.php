<?

class info extends Controller {
	
		

	function info()
	{
		parent::Controller();	
	}
	
	function index()
	{
		echo phpinfo();
		//echo date_default_timezone_get();
		/*echo date('l jS \of F Y h:i:s A').'</br>';
		echo date("F j, Y, g:i a").'</br>';   
		echo $date= date("Y-m-d H:i:s").'</br>';   
		//$newDate = strtotime('+30 days',$date);
		//echo $newDate;
		
		echo date("Y-m-d H:i:s", strtotime("+30 days"));
		*/
		
//echo strtotime("+30 day"), "\n";

	}
	
	

}

 ?>