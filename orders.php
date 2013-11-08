<?php
	include("dbfunc.php");

	$orders = getOrders();
	
	$html="";
	$html.= "<table>";
		$html.= "<tr>";
			$html.= "<th>Order ID</th>";
			$html.= "<th>Order Date</th>";
			$html.="<th>Order Price</th>";
			$html.="<th>Product Title</th>";
			$html.="<th>Customer Email</th>";
			$html.="<th>Shipping Type</th>";
			$html.="<th>Shipment Status</th>";
		$html.= "</tr>";
	foreach($orders as $order){
		if($order['OrderShipped']=="0000-00-00 00:00:00"){
			$status="Not Shipped";
		}else{
			$status="Shipped on: ".$order['OrderShipped'];
		}	


		$html.= "<tr>";
			$html.="<td>".$order['OrderID']."</td>";
			$html.="<td>".$order['OrderDate']."</td>";
			$html.="<td>".$order['fldPriceEach']."</td>";
			$html.="<td>".$order['Title']."</td>";
			$html.="<td>".$order['Email']."</td>";
			$html.="<td>".$order['ShippingType']."</td>";
			$html.="<td>".$status."</td>";
		$html.= "</tr>";
	}
	
	$html.= "</table>";




include("header.php");
	echo $html;
include("footer.php");

?>



