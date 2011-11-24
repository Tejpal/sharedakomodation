<?

foreach($result as $row)
{
$a=$row['id'];

	if (in_array($a, $myarray))
	{
	
	echo "<li><input type='checkbox' name='options[]' value=$a  checked='checked' >";
	}
	else
	{
	echo "<li><input type='checkbox' name='options[]' value=$a   >";
	}

echo $row['community'].'</li>';
} 

?>