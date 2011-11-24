<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Find Accomodation - Get Shared Accommodation . Anywhere . Anytime .</title>
<?php
$baseurl = $this->config->item('base_url');
$staticurl = $this->config->item('static_url');
?>
<link href="<?=$staticurl?>css/find.css" rel="stylesheet" type="text/css" />
<link href="<?=$staticurl?>css/register.css" rel="stylesheet" type="text/css" />
<script src="<?=$staticurl?>js/cufon-yui.js" type="text/javascript"></script>
<script src="<?=$staticurl?>js/dinMedium_500.font.js" type="text/javascript"></script>
<script src="<?=$staticurl?>js/dinRegular_400.font.js" type="text/javascript"></script>
<script type="text/javascript">
	Cufon.replace('h3', { fontFamily: 'dinMedium' });
	Cufon.replace('h2', { fontFamily: 'dinMedium' });
	Cufon.replace('span.replace', { fontFamily: 'dinMedium' });
	Cufon.replace('span.replaceReg', { fontFamily: 'dinRegular' });
	Cufon.replace('div.replace', { fontFamily: 'dinMedium' });
</script>
<script type="text/javascript" src="<?=$staticurl?>js/autocomplete/lib/jquery.js"></script>
<script type='text/javascript' src='<?=$staticurl?>js/autocomplete/lib/jquery.bgiframe.min.js'></script>
<script type='text/javascript' src='<?=$staticurl?>js/autocomplete/lib/jquery.ajaxQueue.js'></script>
<script type='text/javascript' src='<?=$staticurl?>js/autocomplete/lib/thickbox-compressed.js'></script>
<script type='text/javascript' src='<?=$staticurl?>js/autocomplete/jquery.autocomplete.js'></script>
<script type='text/javascript' src='<?=$staticurl?>js/autocomplete/demo/localdata.js'></script>
<link rel="stylesheet" type="text/css" href="<?=$staticurl?>js/autocomplete/jquery.autocomplete.css" />
<script>
  $(document).ready(function(){
	$("#location").focus().autocomplete(cities);
  });
</script>



</head>

<body>
<div id="topBarContainer">
	<div id="topBarHolder" >
		<div class="navBox">
			<ul>
				<li class="selected"><a href="<?=$baseurl?>" class="homeBtn"></a></li>
				<li><a href="<?=$baseurl?>" class="freeAdBtn"></a></li>
				<li><a href="<?=$baseurl?>" class="advSearchBtn"></a></li>
				<li><a href="<?=$baseurl?>" class="worksBtn"></a></li>
			</ul>
		</div>
		<div class="loginBox" align="right">
			<div id="signFields"><input type="text" id="userName" value="username" onclick="" />
			<input type="password" id="userPassword" value="djdfj" /></div>
	    	<div id="signTopBtn"><img src="<?=$staticurl?>images/signin.gif" width="67" height="16" /></div>
        </div>
	</div>
</div>

<div id="mainBarContainer">
	<div id="mainBarHolder">
		<div id="logoBox">
			<h1>Find Accomodation</h1>
			<h3 class="countryHolder">AUSTRALIA</h3>
		</div>
		
		<div id="searchForm" >
			<div id="locationBlock">
				<label for="location" id="banLocation">
                <img src="<?=$staticurl?>images/banLocation.gif" width="220" height="19" /> 
                </label>
			  <label for="surrAreas" id="surrAreasLbl"><span class="replace">Include surrounding areas</span></label>
				<input type="checkbox" id="surrAreas" name="surrAreas"/>
				         	
            <input type="text" id="location" name="location" />
			</div>
			
			<div id="communityBlock" > 
         	<label for="community">
              <img src="<?=$staticurl?>images/bancommunity.gif" width="128" height="19" /></label>
         	<input type="text" id="community" name="community"/><br/>
         	<label><span class="fieldHint">Helps finding accomodation in your own/preferred community. <span class="homeCatchy">Ctrl+Click</span> to select multiple communities</span></label>
         	<br/>
         </div>
         
         <div id="findBlock">
            <div id="banRadio"><input type="radio" name="memberType" id="memberType" value="providers" checked="checked" />
            <span class="replace">&nbsp;&nbsp;Find Sharing Providers</span><br /><br />
            <input type="radio" name="memberType" id="memberType" value="finders" />
            <span class="replace">&nbsp;&nbsp;Find Sharing Finders</span></div>
            <div id="banFind">
            <input type="image" src="<?=$staticurl?>images/findnow.png" id="findBtn" /></div>
			</div>
		</div>
	</div>		
</div>

<div id="contentContainer">
  	<div id="contentHolder">
   	<div id="contentLeft">
   		<div id="registerPage">
				<h2>REGISTER</h2>
				<div id="regFormLeft" >
					<label for="userName3" ><span class="replace">Username</span></label>
					<input type="text" id="userName3" name="userName3" />
					<label class="validation">This is an example of validation</label><br/><br/>
					<label for="userPassword3" ><span class="replace">Password</span></label>
					<input type="password" id="userPassword3" name="userPassword3" />
					<label class="validation">This is an example of validation</label><br/><br/>
					<label for="confirmPassword" ><span class="replace">Confirm Password</span></label>
					<input type="password" id="confirmPassword" name="confirmPassword" /><br/><br/>
					<label for="emailId" ><span class="replace">Email ID</span></label>
					<input type="text" id="emailId" name="emailId" />
					<label class="italic">Your Email ID is not public until you choose to display it to 
					public from account settings</label>
				</div>
				<div id="regFormRight">
					<div id="radioButtons" >
						<input type="radio" name="memberType" id="memberType" value="providers" checked="checked" />
            		<span class="replace">&nbsp;&nbsp;I am a Sharing Provider </span><br /><br />
            		<input type="radio" name="memberType" id="memberType" value="finders" />
            		<span class="replace">&nbsp;&nbsp;I am a Sharing Finder</span>
            	</div><br/><br/>
            	<h3>Verification</h3><br/>
            	<div class="verification" >
            		<img src="<?=$staticurl?>images/verificationImg.gif" width="268" height="83" /><br/><br/>
            		<label>Enter the code above</label>
            		<input type="text" id="verifiCode" />
            	</div>
				</div>
				<div id="regBtnDiv" >
					<input href="#" type="image" src="<?=$staticurl?>images/register.gif" id="registerBtn" />
				</div>
			</div>
    	</div>
	 	<div id="ads" align="right">
			<img src="<?=$staticurl?>images/ads.jpg" width="160" height="502"/>
	  	</div>
        <br class="clearer">
   </div>
   <br class="clearer">
</div>

<div id="footerContainer">
	<div id="footerHolder">
		<h2>USEFUL LINKS</h2>
		<div id="links">
			<ul>
				<li><a href="#">About Us</a></li>
				<li><a href="#">Our Vision</a></li>
				<li><a href="#">Advertising</a></li>
				<li><a href="#">Contact Us</a></li>
				<li><a href="#">FAQs</a></li>
				<li><a href="#">Tell A Friend</a></li>
			</ul>
			<ul>
				<li><a href="#">About Us</a></li>
				<li><a href="#">Our Vision</a></li>
				<li><a href="#">Advertising</a></li>
				<li><a href="#">Contact Us</a></li>
				<li><a href="#">FAQs</a></li>
				<li><a href="#">Tell A Friend</a></li>
			</ul>
			<ul>
				<li><a href="#">About Us</a></li>
				<li><a href="#">Our Vision</a></li>
				<li><a href="#">Advertising</a></li>
				<li><a href="#">Contact Us</a></li>
				<li><a href="#">FAQs</a></li>
				<li><a href="#">Tell A Friend</a></li>
			</ul>
			<ul>
				<li><a href="#">About Us</a></li>
				<li><a href="#">Our Vision</a></li>
				<li><a href="#">Advertising</a></li>
				<li><a href="#">Contact Us</a></li>
				<li><a href="#">FAQs</a></li>
				<li><a href="#">Tell A Friend</a></li>
			</ul>
		</div>
		<div id="socialNet" >
			<h2>FOLLOW US</h2>
		</div>
		
	</div>
</div>
<div id="botBarContainer">
	<div id="botBarHolder">� Copyright 2010. Findaccomodation.com. All rights reserved.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Privacy Policy  |  Terms & Conditions</div>
</div>		
		
</body>
</html>