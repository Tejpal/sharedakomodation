<html>
<head>
<script src="http://www.sharedakomodation.com/findacc3/static/js/jquery.min.js"></script>
<script src="http://www.sharedakomodation.com/findacc3/static/js/jquery-ui.min.js"></script>
<script type="text/javascript">
$(document).ready(function()
{
var val='';
	function homeslider(){
		$.ajax({
			url:'http://www.sharedakomodation.com/findacc3/index.php/tejpaltest/filter/'+val,
			type: "POST",
			data: "",
			cache: false,
			success: function(data) {
				
					$('#actualSliderBack').html(data);
				
			}
		});
		
	}homeslider();
});
	
	
function loadXMLDoc(val)
{
var xmlhttp;
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("actualSliderBack").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET",'http://www.sharedakomodation.com/findacc3/index.php/tejpaltest/filter/'+val,true);
xmlhttp.send();
}
</script>
</script>
</head>
<body>
<form>
<input type="text"  onkeyup="loadXMLDoc(this.value);">
</form>
<div id="actualSliderBack" style="height:300px; width:300px;overflow-y:scroll;">
</div>
<body>