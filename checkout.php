<?php
include('dbfunc.php');

$ArtID=$_GET['id'];


if(isset($_POST['submit'])){
	$fname=$_POST['fname'];
	$lname=$_POST['lname'];	
	$email=$_POST['email'];
	$gender=$_POST['gender'];
	$street=$_POST['street'];
	$city=$_POST['city'];
	$state=$_POST['state'];
	$zip=$_POST['zip'];
	$phone=$_POST['phone'];

	$valid=true;
	$message="Error, you need to fix the following fields<br />";
	
	if($fname==""){
		$valid=false;
		$message.="-First Name<br />";
	}
	if($lname==""){
		$valid=false;
		$message.="-First Name<br />";
	}

	if(!verifyEmail($email)){
		$valid=false;
		$message.="-First Name<br />";
	}
	if($street==""){
		$valid=false;
		$message.="-First Name<br />";
	}
	if($city==""){
		$valid=false;
		$message.="-First Name<br />";
	}
	if($state=="Select a State"){
		$valid=false;
		$message.="-State<br />";
	}
	if($zip==""){
		$valid=false;
		$message.="-First Name<br />";
	}
	if($phone==""){
		$valid=false;
		$message.="-First Name<br />";
	}


	if(isset($_POST['expedite'])){
		$expedite=$_POST['expedite'];
	}else{
		$expedite="n";
	}
	
	$shipping=$_POST['shipping'];
	
	if(isset($_POST['gift'])){
		$gift=$_POST['gift'];
	}else{
		$gift="n";
	}


	if($valid){


		$orderid= createOrder();

		formSubmit($ArtID, $orderid, $fname, $lname,$email, $gender, $street, $city, $state, $zip, $phone, $expedite, $shipping, $gift);

		$art = getArtById($ArtID);

		$subject="Maxine Davis Glass Art Order: '".$art['Title']."'' Confirmation";

		$message="Your order has been confirmed! <br /><br />
		Your Order Number is ".$orderid." <br />
		Title: ".$art['Title']." <br />
		Price: ".$art['RetailPrice']." <br /><br />
		Thank you for your order!";

		sendMail($email, $subject, $message);

		//SEND EMAIL
		
		header('location: thanks.php');
	}else{
		echo $message;
	}

	//formSubmit($ArtID, $fname, $lname);

}elseif(isset($_POST['submitLogged'])){

	if(isset($_POST['expedite'])){
		$expedite=$_POST['expedite'];
	}else{
		$expedite="n";
	}
	
	$shipping=$_POST['shipping'];
	
	if(isset($_POST['gift'])){
		$gift=$_POST['gift'];
	}else{
		$gift="n";
	}

	$orderid= createOrder();

	$username=$_POST['username'];
	$customer=getCustomerData($username);


	$fname=$customer['FirstName'];
	$lname=$customer['LastName'];
	$email=$customer['Email'];
	$gender=$customer['Gender'];
	$street=$customer['Street'];
	$city=$customer['City'];
	$state=$customer['State'];
	$zip=$customer['Zip'];
	$phone=$customer['PhoneNumber'];


	formSubmit($ArtID, $orderid, $fname, $lname,$email, $gender, $street, $city, $state, $zip, $phone, $expedite, $shipping, $gift);

	$art = getArtById($ArtID);

	$subject="Maxine Davis Glass Art Order: '".$art['Title']."'' Confirmation";

	$message="Your order has been confirmed! <br /><br />
	Your Order Number is ".$orderid." <br />
	Title: ".$art['Title']." <br />
	Price: ".$art['RetailPrice']." <br /><br />
	Thank you for your order!";

	sendMail($email, $subject, $message);

	//SEND EMAIL
	
	header('location: thanks.php');



}else{
		include("header.php");

		if(isset($_SESSION['valid'])){
			echo "Logged in as ". $_SESSION['username']." <br />";
		?>	

		<p><strong>Use the form below to use your registered account info</strong></p>

		<form action="" method="post">
			<label for="expedite">Expedite</label>
			<input type="checkbox" id="expedite" value="y" name="expedite" /><br />

			<input type="hidden" value="<?php  echo $_SESSION['username'] ?>" name="username" />

			<label>Shipping Type</label><br />
			
			<input type="radio" id="Standard" checked="checked" value="standard" name="shipping" />
			<label for="standard">Standard</label><br />

			<input type="radio" id="Express" value="express" name="shipping" />
			<label for="express">Express</label><br />

			<label for="gift">Gift</label>
			<input type="checkbox" id="gift" value="y" name="gift" /><br />

			<input type="submit" name="submitLogged" value="submit" />
		</form><br />

		<?php } ?>


<p><strong>Use the form below if you do not want to register or you need to use different shipping information.</strong></p>

<form action="" method = "post">
	<label for="fname">First Name</label>
	<input type="text" id="fname" name="fname" /><br />

	<label for="lname">Last Name</label>
	<input type="text" id="lname" name="lname" /><br />

	<label for="email">Email</label>
	<input type="text" id="email" name="email" /><br />


	<label>Gender</label><br />
	
	<input type="radio" id="female" checked="checked" value="f" name="gender" />
	<label for="female">Female</label><br />

	<input type="radio" id="male" value="m" name="gender" />
	<label for="male">Male</label><br />



	<label for="street">Street Address</label>
	<input type="text" id="street" name="street" /><br />

	<label for="city">City</label>
	<input type="text" id="city" name="city" /><br />

	<label for="state">State</label>
	<select id="state" name="state">
		
<option value="" selected="selected">Select a State</option> 
<option value="AL">Alabama</option> 
<option value="AK">Alaska</option> 
<option value="AZ">Arizona</option> 
<option value="AR">Arkansas</option> 
<option value="CA">California</option> 
<option value="CO">Colorado</option> 
<option value="CT">Connecticut</option> 
<option value="DE">Delaware</option> 
<option value="DC">District Of Columbia</option> 
<option value="FL">Florida</option> 
<option value="GA">Georgia</option> 
<option value="HI">Hawaii</option> 
<option value="ID">Idaho</option> 
<option value="IL">Illinois</option> 
<option value="IN">Indiana</option> 
<option value="IA">Iowa</option> 
<option value="KS">Kansas</option> 
<option value="KY">Kentucky</option> 
<option value="LA">Louisiana</option> 
<option value="ME">Maine</option> 
<option value="MD">Maryland</option> 
<option value="MA">Massachusetts</option> 
<option value="MI">Michigan</option> 
<option value="MN">Minnesota</option> 
<option value="MS">Mississippi</option> 
<option value="MO">Missouri</option> 
<option value="MT">Montana</option> 
<option value="NE">Nebraska</option> 
<option value="NV">Nevada</option> 
<option value="NH">New Hampshire</option> 
<option value="NJ">New Jersey</option> 
<option value="NM">New Mexico</option> 
<option value="NY">New York</option> 
<option value="NC">North Carolina</option> 
<option value="ND">North Dakota</option> 
<option value="OH">Ohio</option> 
<option value="OK">Oklahoma</option> 
<option value="OR">Oregon</option> 
<option value="PA">Pennsylvania</option> 
<option value="RI">Rhode Island</option> 
<option value="SC">South Carolina</option> 
<option value="SD">South Dakota</option> 
<option value="TN">Tennessee</option> 
<option value="TX">Texas</option> 
<option value="UT">Utah</option> 
<option value="VT">Vermont</option> 
<option value="VA">Virginia</option> 
<option value="WA">Washington</option> 
<option value="WV">West Virginia</option> 
<option value="WI">Wisconsin</option> 
<option value="WY">Wyoming</option>

	</select><br />



	<label for="zip">Zip</label>
	<input type="text" id="zip" name="zip" /><br />

	<label for="phonenumber">Phone Number </label>
	<input type="text" id="phonenumber" name="phone" /><br />

	<label for="expedite">Expedite</label>
	<input type="checkbox" id="expedite" value="y" name="expedite" /><br />

	<label>Shipping Type</label><br />
	
	<input type="radio" id="Standard" checked="checked" value="standard" name="shipping" />
	<label for="standard">Standard</label><br />

	<input type="radio" id="Express" value="express" name="shipping" />
	<label for="express">Express</label><br />

	<label for="gift">Gift</label>
	<input type="checkbox" id="gift" value="y" name="gift" /><br />

	<input type="submit" name="submit" value="submit" />
</form>




<?php
		include("footer.php");
	}//close else 
?>