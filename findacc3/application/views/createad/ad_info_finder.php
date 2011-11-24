<?php $staticurl = $this->config->item('static_url'); 
//print_r($adsImages);
//print_r($adinfo[0]['ads_id']);
?>
<link href="<?=$staticurl?>js/fileupload/fileuploader.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="<?=$staticurl?>js/gallery/jquery.ad-gallery.css">

<script type="text/javascript" src="<?=$staticurl?>js/fileupload/fileuploader.js"></script>
<script type="text/javascript">
//this is to load the gallery after image upload
 function getreloadurl(){
	$.ajax({
		url: getbaseurl()+'ads/uploadimges/'+<?=$adinfo[0]['ads_id']?>,
		data:"",
		cache:false,
		success: function(data) {
			$('#newimggal').html(data);
		}
	});
} 
</script>
<script type="text/javascript">

var uploader = new qq.FileUploader({
    // pass the dom node (ex. $(selector)[0] for jQuery users)
    element: document.getElementById('file-uploader'),
    // path to server-side upload script
    action: getbaseurl()+'ads/upload_file'
});

$(document).ready(function(){
  $.ajax({
	  url: getbaseurl()+'ads/uploadimges/'+<?=$adinfo[0]['ads_id']?>,
	  data:"",
	  cache:false,
	  success: function(data) {
		  $('#newimggal').html(data);
	  }
  });
});


</script>
<p class="compulsorynote">(Fields marked with * are compulsory)</p>
<div class="creationbox roundBor3" id="stepfour">
	<p id="nwErrorBox" class="error-notify"></p>
    <div class="flLeft">
        <p class="myfieldhol">
            <label for="adTitle" class="nwlabel">Title for your Ad *</label>
            <input type="text" value="<?php if(!empty($adinfo)){ echo $adinfo[0]['title'];}?>" name="adTitle" id="adTitle" class="if434 inputFieldnw" />
        </p>
        <p class="myfieldhol">
            <label for="propFeature1" class="nwlabel">Two best features of the property *</label>
            <input type="text" value="<?php if(!empty($adinfo)){ echo $adinfo[0]['bestfeature1'];}?>" id="propFeature1" name="propFeature1" class="if434 inputFieldnw" /><br />
            <input type="text" value="<?php if(!empty($adinfo)){ echo $adinfo[0]['bestfeature2'];}?>" id="propFeature2" name="propFeature2" class="if434 inputFieldnw marTop10" />
        </p>
        <p>
            <label for="adDescription-crtad" class="nwlabel">Ad Description</label>
            <textarea name="adDescription" id="adDescription-crtad" class="tf434 textFieldnw" ><?php if(!empty($adinfo)){ echo $adinfo[0]['description'];}?></textarea>
        </p>
        <p class="clearer"></p>
    </div>
    <div id="rightDiv">
    
    	<div id="newimggal">
		<?php
$i=0;
// print_r($adsImages);
if(isset($adsImages) && is_array($adsImages) && count($adsImages)>0){
?>
<div id="gallery" class="ad-gallery">
      <div class="ad-image-wrapper">
      </div>
      <div class="ad-nav">
        <div class="ad-thumbs">
          <ul class="ad-thumb-list">
          	<?php
			foreach($adsImages as $adsImage){
			?>
<li>
  <a href="<?=$staticurl?>ads_upload/img1_<?=$adsImage['name']?>">
    <img src="<?=$staticurl?>ads_upload/img3_<?=$adsImage['name']?>" class="image<?=$i?>">
  </a>
</li>
            <?php	
			$i++;									
			}
			?>
          </ul>
        </div>
      </div>
    </div>
<?php	
}else{
	echo "<div id='emptyimagesyet'>You haven't uploaded any images yet.<br />Please upload more than one image to get better results.</div>";
}
?>
        </div>
        
    	<div id="uploadImagesnw">     
              <div id="file-uploader">       
                  <noscript>          
                      <p>Please enable JavaScript to use file uploader.</p>
                      <!-- or put a simple form for upload here -->
                  </noscript>      
              </div>
        </div>  
	</div>
    <br class="clearer" />
</div>


