<?php $staticurl = $this->config->item('static_url'); 
//print_r($adsImages);
//print_r($adinfo);
?>
<?php
$i=0;
// print_r($adsImages);
if(is_array($adsImages) && count($adsImages)>0){
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
	echo "<p id='emptyimagesyet'>You haven't uploaded any images yet.<br />Please upload more than one image to get better results.</p>";
}
?>
<script type="text/javascript" src="<?=$staticurl?>js/gallery/jquery.ad-gallery.js"></script>
<script type="text/javascript">
$(function() {
  var galleries = $('.ad-gallery').adGallery();
});
</script>

