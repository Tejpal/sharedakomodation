<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class common_lib
{

    // ================ //
    // Constructor      //
    // ================ //
    function common_lib() {
		$this->CI = &get_instance();

		/*
		$this->cache_dir = ($this->CI->config->item('cache_path') == '') ? BASEPATH.'cache/' : $this->CI->config->item('cache_path');

		//$this->cache_dir = '/system/cache';
		$this->feed_uri = $params['url'];
		$this->cache_life = $params['life'];
		$this->current_feed["title"] = '';
		$this->current_feed["description"] = '';
		$this->current_feed["link"] = '';
		$this->data = array();
		$this->channel_data = array();
		//Attempt to parse the feed
		$this->parse();
		*/  
    }
	
	// load email class
	protected function load_mail()
	{
		$this->CI->load->library('email');

		// Setting Email Preferences
		$this->init_mail();		
	}	
	
	// init email class
	protected function init_mail()
	{
		/*
		
		$config['protocol'] = 'sendmail';
		$config['mailpath'] = '/usr/sbin/sendmail';
		$config['charset'] = 'iso-8859-1';
		$config['wordwrap'] = TRUE;

		$this->CI->email->initialize($config);	
		
		*/
	
	}

	// send email 
	function send_mail($mail)
	{
		$this->load_mail();
		
		
		$this->CI->email->from($this->CI->config->item('from_email'), $this->CI->config->item('from_name'));
		$this->CI->email->to($mail['email']);
		$this->CI->email->reply_to($this->CI->config->item('reply_to_email'), $this->CI->config->item('reply_to_email'));	
		$this->CI->email->cc($this->CI->config->item('sys_email')); 
		//$this->CI->email->bcc('them@their-example.com'); 		
		$this->CI->email->subject($mail['subject']);
		$this->CI->email->set_mailtype('html/text');
		$this->CI->email->message($mail['message']);
		//$this->CI->email->alt_message($txtMessage);
		$this->CI->email->send();		
		

		//echo $this->CI->email->print_debugger();	
	
	}	
	
	// send mail template
	function send_template($mail,$template_data)
	{
		$this->load_mail();
		
		$data = array();
		
		$data = array_merge($mail,$template_data);
		
		$this->CI->load->library('parser');

		//$htmlMessage =  $this->CI->parser->parse('mails/signup_success.html', $data, true);
		
		//$htmlMessage =  $this->CI->load->view('mails/signup_success.html', $data, true);
		//$htmlMessage =  $this->CI->load->view('mails/' . $template_data['tpl_name'], $data, true);
		$htmlMessage =  $this->CI->parser->parse('mails/' . $template_data['tpl_name'], $data, true);
		
		//$this->template->set_template('email');
		//$email_message = $this->template->render('', TRUE);		
		
		
		//$txtMessage = $this->parser->parse('user/email/signup_txt',  $data, true);

		#send the message
		$this->CI->email->from($this->CI->config->item('from_email'), $this->CI->config->item('from_name'));
		$this->CI->email->to($mail['email']);
		$this->CI->email->reply_to($this->CI->config->item('reply_to_email'), $this->CI->config->item('reply_to_email'));	
		$this->CI->email->cc($this->CI->config->item('sys_email')); 
		//$this->CI->email->bcc('them@their-example.com'); 		
		$this->CI->email->subject($template_data['subject']);
		$this->CI->email->set_mailtype('html');
		$this->CI->email->message($htmlMessage);
		//$this->CI->email->alt_message($txtMessage);
		$this->CI->email->send();
		
		//echo $this->CI->email->print_debugger();
		
	}

}
?>