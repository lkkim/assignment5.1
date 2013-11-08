<?php
include('db.php');

function getArt(){
	global $db;

	$query="select * from art";

	$results = $db->query($query);

	return $results->fetchAll();
}

function LoginUser($username, $password){
	global $db;
	$query="select * from returningcustomer where Username='".$username."' and Password='".$password."'";
	$results=$db->query($query);
	$rowcount=$results->rowCount();

	if($rowcount>0){
		return true;
	}else{
		return false;
	}
}

function RegisterUser($fname, $lname, $email, $gender, $street, $city, $state, $zip, $phone, $username, $password){
	global $db;

	$query="insert into returningcustomer set Username='".$username."', Password='".$password."', is_confirmed=0";
	$db->exec($query);


	$query="";

	$query2="insert into customer set
				Email='".$email."',
				LastName='".$lname."',
				FirstName='".$fname."',
				Street='".$street."',
				City='".$city."',
				State='".$state."',
				Gender='".$gender."',
				Zip='".$zip."',
				PhoneNumber='".$phone."',
				RegisteredDate=NOW(),
				fkUsername='".$username."'
		";

	
	$db->exec($query2);
}

function confirmUser($username){
	global $db;

	$query="update returningcustomer set is_confirmed=1 where Username='".$username."'";

	$db->exec($query);

}

function isConfirmed($username){
	global $db;

	$query="select is_confirmed from returningcustomer where Username='".$username."'";

	$results = $db->query($query);
	$results = $results->fetch();

	return $results['is_confirmed'];
}

function getCustomerData($username){
	global $db;
	$query="select * from customer where fkUsername='".$username."'";

	$results = $db->query($query);
	return $results->fetch();
}	

function getOrders(){
	global $db;
	$query="select * from `order` o inner join orderart on o.OrderID=orderart.fkOrderID
			inner join art on orderart.fkArtID=art.ArtID
			";

	$results=$db->query($query);

	return $results->fetchAll();
}


function getArtById($id){
	global $db;

	$query="select * from art where ArtID=".$id;

	$results = $db->query($query);

	return $results->fetch();
}

function verifyEmail($testString){
    // Check for a valid email address 
    return (preg_match("/^([[:alnum:]]|_|\.|-)+@([[:alnum:]]|\.|-)+(\.)([a-z]{2,4})$/", $testString));
}

function formSubmit($artid, $orderid, $fname, $lname, $email, $gender, $street, $city, $state, $zip, $phone, $expedite, $shipping, $gift){
	global $db;
	$art = getArtById($artid);
	$price = $art['RetailPrice'];

	$query="insert into orderart set 
				fkOrderID='".$orderid."',
				Email='".$email."',
				fldPriceEach='".$price."',
				LastName='".$lname."',
				FirstName='".$fname."',
				Street='".$street."',
				fkArtID='".$artid."',
				City='".$city."',
				State='".$state."',
				Zip='".$zip."',
				PhoneNumber='".$phone."',
				Gender='".$gender."',
				Expedite='".$expedite."',
				Gift='".$gift."',
				ShippingType='".$shipping."'	

			";

	$db->exec($query);

}


function createOrder(){
	global $db;
	$now = date("Y-m-d H:i:s");
	$query="insert into `order`(`OrderID`, `OrderDate`, `OrderShipped`) 
			VALUES('', '".$now."','')";
	$result=$db->exec($query);
	
	return $db->lastInsertId();
}

function sendMail($to, $subject, $message){ 
    $MIN_MESSAGE_LENGTH=40;
    
    // just checking to make sure the values passed in are reasonable
    if(empty($to)) return false;
    if(!(preg_match("/^([[:alnum:]]|_|\.|-)+@([[:alnum:]]|\.|-)+(\.)([a-z]{2,4})$/",$to))) return false;
    
    if(empty($subject)) return false;
    
    if(empty($message)) return false;
    if (strlen($message)<$MIN_MESSAGE_LENGTH) return false;
    
    $to = htmlentities($to,ENT_QUOTES,"UTF-8");
    $subject = htmlentities($to,ENT_QUOTES,"UTF-8");
    
    // we cannot push message into html entites or we lose the format
    // of our email so be sure to do that before sending it to this function
    
    // be sure to change Your Site and yoursite to something meaningful
    $mailFrom = "Maxine Davis Glass Art <lkkim@uvm.edu>";

    $cc = "";  // ex: $cc = "webmaster@yoursite.com";
    $bcc = ""; // ex: $bcc = "youremail@yoursite.com";

    /* message */
    $messageTop  = '<html><head><title>' . $subject . '</title></head><body>';
    $mailMessage = $messageTop . $message;

    $headers  = "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=utf-8\r\n";

    $headers .= "From: " . $mailFrom . "\r\n";

    if ($cc!="") $headers .= "CC: " . $cc . "\r\n";
    if ($bcc!="") $headers .= "Bcc: " . $bcc . "\r\n";

    /* this line actually sends the email */
    $blnMail=mail($to, $subject, $mailMessage, $headers);
    
    return $blnMail;
}

?>