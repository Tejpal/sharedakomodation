<?php

/**
 * Handle file uploads via XMLHttpRequest
 */
class qqUploadedFileXhr {
    /**
     * Save the file to the specified path
     * @return boolean TRUE on success
     */
    function save($path) {    
        $input = fopen("php://input", "r");
        $temp = tmpfile();
        $realSize = stream_copy_to_stream($input, $temp);
        fclose($input);
        
        if ($realSize != $this->getSize()){            
            return false;
        }
        
        $target = fopen($path, "w");        
        fseek($temp, 0, SEEK_SET);
        stream_copy_to_stream($temp, $target);
        fclose($target);
        
        return true;
    }
    function getName() {

        return $_GET['qqfile'];
    }
    function getSize() {
        if (isset($_SERVER["CONTENT_LENGTH"])){
            return (int)$_SERVER["CONTENT_LENGTH"];            
        } else {
            throw new Exception('Getting content length is not supported.');
        }      
    }   
}

/**
 * Handle file uploads via regular form post (uses the $_FILES array)
 */
class qqUploadedFileForm {  
    /**
     * Save the file to the specified path
     * @return boolean TRUE on success
     */
    function save($path) {
        if(!move_uploaded_file($_FILES['qqfile']['tmp_name'], $path)){
            return false;
        }
        return true;
    }
    function getName() {
        return $_FILES['qqfile']['name'];
    }
    function getSize() {
        return $_FILES['qqfile']['size'];
    }
}

class qqFileUploader {
    private $allowedExtensions = array();
    private $sizeLimit = '';
    private $file;

    function __construct(array $allowedExtensions = array(), $sizeLimit =''){        
        $allowedExtensions = array_map("strtolower", $allowedExtensions);
            
        $this->allowedExtensions = $allowedExtensions;        
        $this->sizeLimit = $sizeLimit;
        
        $this->checkServerSettings();       

        if (isset($_GET['qqfile'])) {
            $this->file = new qqUploadedFileXhr();
        } elseif (isset($_FILES['qqfile'])) {
            $this->file = new qqUploadedFileForm();
        } else {
            $this->file = false; 
        }
    }
    
    private function checkServerSettings(){        
        $postSize = $this->toBytes(ini_get('post_max_size'));
        $uploadSize = $this->toBytes(ini_get('upload_max_filesize'));        
        
        if ($postSize < $this->sizeLimit || $uploadSize < $this->sizeLimit){
            $size = max(1, $this->sizeLimit / 1024 / 1024) . 'M';             
            die("{'error':'increase post_max_size and upload_max_filesize to $size'}");    
        }        
    }
    
    private function toBytes($str){
        $val = trim($str);
        $last = strtolower($str[strlen($str)-1]);
        switch($last) {
            case 'g': $val *= 1024;
            case 'm': $val *= 1024;
            case 'k': $val *= 1024;        
        }
        return $val;
    }
    
    /**
     * Returns array('success'=>true) or array('error'=>'error message')
     */
    function handleUpload($uploadDirectory, $replaceOldFile = FALSE){
	//return array('error' => "Server error. Upload directory".$uploadDirectory." isn't writable.");
	//$uploadDirectory="/home2/sharedak/public_html/findacc3/static/img/";
	//$uploadDirectory='/home2/sharedak/public_html/findacc3/static/img/'
        if (!is_writable($uploadDirectory)){
            return array('error' => "Server error. Upload directory".$uploadDirectory." isn't writable.");
        }
        
        if (!$this->file){
            return array('error' => 'No files were uploaded.');
        }
       
		
        $size = $this->file->getSize();
         if ($size == 0) {
            return array('error' => 'File is empty');
        }
        
		
		
        if ($size > $this->sizeLimit) {
            return array('error' => 'File is too large');
        }
        
        $pathinfo = pathinfo($this->file->getName());
        $filename = $pathinfo['filename'];
        $filename = md5(uniqid());
        $ext = $pathinfo['extension'];

        if($this->allowedExtensions && !in_array(strtolower($ext), $this->allowedExtensions)){
            $these = implode(', ', $this->allowedExtensions);
            return array('error' => 'Please upload an image,file has an invalid extension, it should be one of '. $these . '.' );
        }
        
        if(!$replaceOldFile){
            /// don't overwrite previous files that were uploaded
            while (file_exists($uploadDirectory . $filename . '.' . $ext)) {
                $filename .= rand(10, 99);
            }
        }
        
        if ($this->file->save($uploadDirectory . $filename . '.' . $ext)){
		
          ///gd s
$pathToImages=$uploadDirectory;
$fname=$filename . '.' . $ext;
//$fname='vv.jpg';
$dir = opendir($pathToImages);
$info = pathinfo($pathToImages . $fname);
$new_image_name='w'.$fname;
//
$size = getimagesize($pathToImages . $fname);
if($size['0']>3000 || $size['1']>2500)
{
unlink($uploadDirectory.$fname);
return array('error'=> 'Max image dimension allowed 3000X2500');
}
//
if ( strtolower($info['extension']) == 'jpg' || strtolower($info['extension']) == 'jpeg' )
{
	$new_img = imagecreatefromjpeg($pathToImages.$fname);
	
	//$new_img2 = imagecreatefromjpeg($pathToImages.$fname);
	//$new_img3 = imagecreatefromjpeg($pathToImages.$fname);
}
elseif ( strtolower($info['extension']) == 'png' )
{
	$new_img = imagecreatefrompng("{$pathToImages}{$fname}" );
	//$new_img2 = imagecreatefrompng("{$pathToImages}{$fname}" );
	//$new_img3 = imagecreatefrompng("{$pathToImages}{$fname}" );
}

elseif(strtolower($info['extension']) == 'gif')
{
	$new_img = imagecreatefromgif("{$pathToImages}{$fname}" );
	//$new_img2 = imagecreatefromgif("{$pathToImages}{$fname}" );
	//$new_img3 = imagecreatefromgif("{$pathToImages}{$fname}" );
}
$width = imagesx($new_img);
$height = imagesy($new_img);

$imgratio=$width/$height;

$LargeThumb=800;
$img1_Thumb=365;
$img2_Thumb=115;
$img3_Thumb=90;


//large thumb
if ($width>$LargeThumb)
$newwidth=$LargeThumb;
else
$newwidth=$width;
$newheight=$newwidth*(1/$imgratio);		
		
//img_1		
	if ($width>$img1_Thumb)
$newwidth1=$img1_Thumb;
else
$newwidth1=$width;
//$newwidth1=$img1_Thumb;
$newheight1=$newwidth1*(1/$imgratio);	
		


//img_2		
	if ($width>$img2_Thumb)
$newwidth2=$img2_Thumb;
else
$newwidth2=$width;
$newheight2=$newwidth2*(1/$imgratio);		
		
//img_3		
if ($width>$img3_Thumb)
$newwidth3=$img3_Thumb;
else
$newwidth3=$width;
$newheight3=$newwidth3*(1/$imgratio);	


		
		/* $newwidth2=$ThumbWidth2;
		$newheight2=$ThumbWidth2*(1/$imgratio); */
		



		

	$resized_img = imagecreatetruecolor($newwidth,$newheight);
	$resized_img1 = imagecreatetruecolor($newwidth1,$newheight1);
	$resized_img2 = imagecreatetruecolor($newwidth2,$newheight2);
	$resized_img3 = imagecreatetruecolor($newwidth3,$newheight3);

//the resizing is going on here!

	imagecopyresampled($resized_img, $new_img, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
	imagecopyresampled($resized_img1, $new_img, 0, 0, 0, 0, $newwidth1, $newheight1, $width, $height);
	imagecopyresampled($resized_img2, $new_img, 0, 0, 0, 0, $newwidth2, $newheight2, $width, $height);
	imagecopyresampled($resized_img3, $new_img, 0, 0, 0, 0, $newwidth3, $newheight3, $width, $height);

//finally, save the image

	ImageJpeg ($resized_img,$uploadDirectory .$new_image_name, 100);
	ImageJpeg ($resized_img1,$uploadDirectory . "img1_".$new_image_name, 100);
	ImageJpeg ($resized_img2,$uploadDirectory . "img2_".$new_image_name, 100);
	ImageJpeg ($resized_img3,$uploadDirectory . "img3_".$new_image_name, 100);

	ImageDestroy ($resized_img);
	ImageDestroy ($new_img);
	
	ImageDestroy ($resized_img1);

	ImageDestroy ($resized_img2);
	//ImageDestroy ($new_img2);

	ImageDestroy ($resized_img3);
	//ImageDestroy ($new_img3);
//echo 'done';
 
 unlink($uploadDirectory.$fname);
closedir( $dir );		  
		  ////gd e
		  
	  
	
	$ads_id=$_SESSION['ads_id'];
	//$this->load->library('session');
	//$ads_id=$this->session->userdata('ads_id');
			if($ads_id > 0)
			{
			$sql="insert into `images` (`ads_id`,`name`) values('$ads_id','$new_image_name');";
			$res=mysql_query($sql);
	  
			$sql1="UPDATE `ads` SET `image_uploaded`='1' WHERE `ads_id`='$ads_id'";
			$res1=mysql_query($sql1);
			
				if(!$res && !$res1)
				{
				return array('error'=> 'Could not save uploaded file due to database error.');
				}
			}	 
	 //unset($_SESSION['ads_id']);
//echo $sql;          
		  return array('success'=>true,'file name'=>$filename. '.' . $ext);
        } else {
            return array('error'=> 'Could not save uploaded file.' .
                'The upload was cancelled, or server error encountered');
        }
        
    }    
}
