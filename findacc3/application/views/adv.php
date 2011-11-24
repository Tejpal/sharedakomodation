<?php
$base_url = site_url() . '/';
?>
<html>
<form name="advsearch" id="advsearch" action="<?=$base_url?>ads/advsearch1" method="post">

<table>


<tr><td>PROPERT TYPE</td><td><select name="propertytype" id="propertytype">
<option value=0>Any</option>
<option value=1>Unit/appartment</option>
<option value=2>House</option>
<option value=3>townhouse</option>
<option value=4>Building</option>
<option value=5>Granny flat</option>
</select></td></tr>

<tr><td>Bedrooms </td><td><select name="bedrooms" id="bedrooms">
<option value=10>Any</option>
<option value=1>1</option>
<option value=2>2 or less</option>
<option value=3>3 or less</option>
<option value=4>4 or less</option>
<option value=5>5 or less</option>
</select></td></tr>
<tr><td>Price:</td></tr>
<tr><td>Min:</td><td><input type="text" name="min" ></td></tr>
<tr><td>Max:</td><td><input type="text" name="max" ></td></tr>

<tr><td>Parking </td><td><select name="Parking" id="Parking">
<option value=0>Any</option>
<option value=1>Garage parking</option>
<option value=2>No parking</option>
<option value=3>On-street parking</option>
</select></td></tr>
<tr><td><input type="submit" name="submit" value="SEARCH"></td></tr>

</table>
</form>
</html>