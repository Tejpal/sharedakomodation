<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Find Accomodation - Get Shared Accommodation . Anywhere . Anytime .</title>
<?php
$baseurl = $this->config->item('base_url');
$staticurl = $this->config->item('static_url');
/*
?>
<link href="<?=$staticurl?>css/find.css" rel="stylesheet" type="text/css" />
<link href="<?=$staticurl?>css/register.css" rel="stylesheet" type="text/css" />
<link href="<?=$staticurl?>css/signin.css" rel="stylesheet" type="text/css" />
<link href="<?=$staticurl?>css/listing.css" rel="stylesheet" type="text/css" />
<link href="<?=$staticurl?>css/createAd.css" rel="stylesheet" type="text/css" />

<link href="<?=$staticurl?>js/checklist/doc/smoothness/jquery-ui-1.8.4.custom.css">
<link href="<?=$staticurl?>js/newSelect/msdropdown/dd.css" />
<LINK href="<?=$staticurl?>css/jquery-ui.css" type="text/css" rel="stylesheet">

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1/jquery-ui.min.js"></script>
<script src="<?=$staticurl?>js/jquery.min.js"></script>
<script src="<?=$staticurl?>js/jquery-ui.min.js"></script>

<script src="<?=$staticurl?>js/cufon-yui.js" type="text/javascript"></script>
<script src="<?=$staticurl?>js/dinMedium_500.font.js" type="text/javascript"></script>
<script src="<?=$staticurl?>js/dinRegular_400.font.js" type="text/javascript"></script>
<script src="<?=$staticurl?>js/checklist/src/ui.dropdownchecklist.js"></script>
<script src="<?=$staticurl?>js/newSelect/msdropdown/js/jquery.dd.js"></script>
<script src="<?=$staticurl?>js/mydocumentready.js"></script>


*/
?>

<link href="<?=$staticurl?>css/find.css" rel="stylesheet" type="text/css" />
<link href="<?=$staticurl?>css/createAd.css" rel="stylesheet" type="text/css" />

<link href="<?=$staticurl?>css/register.css" rel="stylesheet" type="text/css" />
<link href="<?=$staticurl?>css/signin.css" rel="stylesheet" type="text/css" />

<link href="<?=$staticurl?>css/switchAccount.css" rel="stylesheet" type="text/css" />
<link href="<?=$staticurl?>css/shortlistedAds.css" rel="stylesheet" type="text/css" />
<link href="<?=$staticurl?>css/accountSettings.css" rel="stylesheet" type="text/css" />

<link href="<?=$staticurl?>css/listing.css" rel="stylesheet" type="text/css" />
<link href="<?=$staticurl?>css/pagination.css" rel="stylesheet" type="text/css" />
<link href="<?=$staticurl?>css/dev.css" rel="stylesheet" type="text/css" />



<link href="<?=$staticurl?>js/checklist/doc/smoothness/jquery-ui-1.8.4.custom.css" rel="stylesheet" type="text/css" />
<link href="<?=$staticurl?>js/newSelect/msdropdown/dd.css" rel="stylesheet" type="text/css" />
<LINK href="<?=$staticurl?>css/jquery-ui.css" type="text/css" rel="stylesheet" />
<?php 
/*
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1/jquery-ui.min.js"></script>
*/ 
?>
<script src="<?=$staticurl?>js/jquery.min.js"></script>
<script src="<?=$staticurl?>js/jquery-ui.min.js"></script>

<script src="<?=$staticurl?>js/cufon-yui.js" type="text/javascript"></script>
<script src="<?=$staticurl?>js/dinMedium_500.font.js" type="text/javascript"></script>
<script src="<?=$staticurl?>js/dinRegular_400.font.js" type="text/javascript"></script>
<script src="<?=$staticurl?>js/checklist/src/ui.dropdownchecklist.js" type="text/javascript" ></script>
<script src="<?=$staticurl?>js/newSelect/msdropdown/js/jquery.dd.js" type="text/javascript"></script>
<script src="<?=$staticurl?>js/mydocumentready.js" type="text/javascript"></script>


</head>
<body>
<?php
$login = false;
if( !empty($_SESSION['user_id']) && $_SESSION['user_id']>0)
{
	$login = true;
}
if(empty($tabon))
	$tabon = 0;
?>
<div id="topBarContainer">
	<div id="topBarHolder" >
		<div class="navBox">
			<ul>
				<li <?=($tabon==0)?'class="selected"':''?> >
				<?php echo anchor('', " ", 'class="homeBtn",title="Home",alt="Home"'); ?>				
				</li>
				<li <?=($tabon==1)?'class="selected"':''?>>
				<?php echo anchor('/ads/create/', " ", 'class="freeAdBtn",title="Create Free Ad",alt="Create Free Ad"'); ?>				
				</li>				
				<li <?=($tabon==2)?'class="selected"':''?>>
				<?php echo anchor('/search', " ", 'class="advSearchBtn",title="Search",alt="Search"'); ?>				
				</li>
				<li <?=($tabon==3)?'class="selected"':''?>>
				<?php echo anchor('/work', " ", 'class="worksBtn",title="Search",alt="Search"'); ?>				
				</li>
			</ul>
		</div>
		<div class="loginBox" align="right">

			<?php
			if($login)
			{
			?>
	    	<div class="welcomename fl_left" >
				Welcome <?php echo $_SESSION['username']; ?>				
			</div>
	    	<div class="welcomename fl_left">
				<?php echo anchor('/user/account/', "Account", 'title="Account",alt="Account"'); ?>				
				| <?php echo anchor('/user/signout/', "Logout", 'title="Logout",alt="Logout"'); ?>
			</div>			
			<?php
			}
			else
			{
			?>
			<form action="<?=site_url("/user/signin/")?>" name="loginform-head" id="loginform-head" method="post" >
				<div id="signFields">
					<input type="text" class="topLoginFields" value="username" name="username"  />
					<input type="password" class="topLoginFields" value="djdfj" name="userpassword"  />
				</div>
				<div id="signTopBtn">
					<input type="image" src="<?=$staticurl?>images/signin.gif" width="67" height="16" border="0" alt="Login - Signin" title="Login - Signin" />				
				</div>		
				<div class="welcomename fl_left">
					<?php echo anchor('/user/signup/', "Signup", 'title="Signup",alt="Signup"'); ?>												
				</div>				
			</form>
			<?php
			}
			?>
        </div>
	</div>
</div>

<div id="mainBarContainer">
	<div id="mainBarHolder">
		<div id="logoBox">
			<a href="<?=site_url()?>" alt="Shared Akomodation" title="Shared Akomodation" ><h1>Shared Akomodation</h1></a>
			<h3 class="countryHolder">AUSTRALIA</h3>
		</div>
		
		<div id="searchForm" >
			<form action="<?=site_url("/ads/search/result/")?>" name="search-head" id="search-head" method="GET" >
				<div id="locationBlock">
					<label for="location" id="banLocation">
						<img src="<?=$staticurl?>images/banLocation.gif" width="220" height="19" /> 
					</label>
					<label for="surrAreas" id="surrAreasLbl"><span class="replace">Include surrounding areas</span></label>
					<input type="checkbox" id="surrAreas" name="surrAreas"/>
								
					<input type="text" id="location" name="location" />
				</div>				
				<div id="communityBlock" > 
					<!--
					<label for="community">
					  <img src="<?//=$staticurl?>images/bancommunity.gif" width="128" height="19" />
					</label>
					<input type="text" id="community" name="community" />
					<br/>
					<label><span class="fieldHint">Helps finding accomodation in your own/preferred community.</span></label>
					<br/>
					-->
					<label for="community">
						<img src="images/bancommunity.gif" width="128" height="19" />
					</label><br />
					<!--<input type="text" id="community" name="community"/>-->
					<select name="community" id="community" multiple="multiple" value="this">
						<option value="option1" selected="selected">Any Community</option>
						<option value="option2">Option 2</option>
						<option value="option3">Option 3</option>
						<option value="option4">Option 4</option>
						<option value="option5">Option 5</option>

						<option value="option6">Option 6</option>
						<option value="option7">Option 7</option>
						<option value="option8">Option 8</option>
						<option value="option9">Option 9</option>
						<option value="option10">Option 10</option>
						<option value="option11">Option 11</option>

						<option value="option12">Option 12</option>
					</select>
					<br/>
					<label><span class="fieldHint">Helps finding accomodation in your own/preferred community.</span></label>
					<br/>					
				</div>			 
				<div id="findBlock">
					<div id="banRadio">
						<label><input type="radio" name="memberType" id="memberType1" value="1" checked="checked" />
						<span class="replace">&nbsp;&nbsp;Search Sharing Providers</span></label><br /><br />
						<label><input type="radio" name="memberType" id="memberType2" value="0" />
						<span class="replace">&nbsp;&nbsp;Search Sharing Finders</span></label>
					</div>
					<div id="banFind">
						<input type="image" src="<?=$staticurl?>images/findnow.gif" id="head_findBtn" name="head_findBtn" class="imgBtnHover" />
						<input type="hidden" name="searchFrom" id="searchFrom" value="1" />
					</div>
				</div>
			</form>
		</div>
	</div>		
</div>