<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Extension of Upload Class to output special data
 *
 */
 
class MY_Upload extends CI_Upload {

	public $CI;

	public function __construct($props = array())
	{
		parent::__construct();

		if (count($props) > 0)
		{
			$this->initialize($props);
		}

		log_message('debug', "Upload Class Initialized");
	}

	public function data()
	{
		return array (
						'file_name'			=> $this->file_name,
						'file_type'			=> $this->file_type,
						'file_path'			=> $this->upload_path,
						'full_path'			=> $this->upload_path.$this->file_name,
						'raw_name'			=> str_replace($this->file_ext, '', $this->file_name),
						'orig_name'			=> $this->orig_name,
						'client_name'		=> $this->client_name,
						'file_ext'			=> $this->file_ext,
						'file_size'			=> $this->file_size,
						'is_image'			=> $this->is_image(),
						'image_width'		=> $this->image_width,
						'image_height'		=> $this->image_height,
						'image_type'		=> $this->image_type,
						'image_size_str'	=> $this->image_size_str,
						// new file url key
						'file_url'			=> $this->file_url($this->upload_path.$this->file_name),
					);
	}

	/*
	 * New function creates a URL to the file that was uploaded
	 *
	*/
	public function file_url($full_path)
	{
		$this->CI = get_instance();

		$this->CI->config->load('uploading_script');

		$path_parts = explode('/', $full_path);

		$target_dir = FALSE;

		$upload_dir = $this->CI->config->item('upload_dir');

		$file_url = '';

		for($x=0; $x <= count($path_parts)-1; $x++)
		{
			if($path_parts[$x] == $upload_dir OR $target_dir == 'reached')
			{
				$file_url .= '/' . $path_parts[$x];
				$target_dir = 'reached';
			}
		}
		return $file_url;
	}

}

/* End of file MY_Upload.php */
/* Location: ./application/libraries/MY_Upload.php */