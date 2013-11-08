<?php
include('dbfunc.php');

$allart = getArt();

$html="";
foreach($allart as $art){

	$html.= "<a href=\"checkout.php?id=".$art['ArtID']."\">".$art['Title']."</a> - $".$art['RetailPrice']." <br />";
	$html.= "<img alt=\"productimage\" style=\"width:300px;\" src=\"images/".$art['ImageName'].".jpg\" /><br />";

	$html.= "<br />";
}

include("header.php");
?>

<p>Here are the glass art pieces that are currently in stock and for sale. 
	Art pieces can be either panels, bowls/dishes, or miscellaneous. Click on the link above 
	each piece to place an order. Each order can only contain one piece, but customers may place 
	multiple orders. Some pieces are also sold by local Vermont businesses – please contact Maxine 
	Davis for a list of wholesalers.  	Please contact Maxine for more information on specific pieces 
	if needed. <br /><br /> </p>

<?php 

echo $html;
include("footer.php");
?>

