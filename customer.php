<?php 
include('dbfunc.php');


if( isset($_POST['login'])){
	$username=$_POST['username'];
	$password=$_POST['password'];

	$validuser=LoginUser($username, $password);

	if($validuser){

		session_start();
		$_SESSION['valid']=1;
		$_SESSION['confirmed']=isConfirmed($username);
		$_SESSION['username']=$username;


	}else{
		echo "incorrect username or password";
	}


}

if( isset($_POST['register'])){
	$fname=$_POST['fname'];
	$lname=$_POST['lname'];	
	$email=$_POST['email'];
	$gender=$_POST['gender'];
	$street=$_POST['street'];
	$city=$_POST['city'];
	$state=$_POST['state'];
	$zip=$_POST['zip'];
	$phone=$_POST['phone'];
	$username=$_POST['username'];
	$password=$_POST['password'];

$valid=true;
	$message="Error, you need to fix the following fields<br />";
	
	if($fname==""){
		$valid=false;
		$message.="-First Name<br />";
	}
	if($lname==""){
		$valid=false;
		$message.="-Last Name<br />";
	}
	if(!verifyEmail($email)){
		$valid=false;
		$message.="-Email<br />";
	}
	if($street==""){
		$valid=false;
		$message.="-Street<br />";
	}
	if($city==""){
		$valid=false;
		$message.="-City<br />";
	}
	if($state=="Select a State"){
		$valid=false;
		$message.="-State<br />";
	}
	if($zip==""){
		$valid=false;
		$message.="-Zip<br />";
	}
	if($phone==""){
		$valid=false;
		$message.="-Phone<br />";
	}

	if($username==""){
		$valid=false;
		$message.="-Username<br />";
	}

	if($password==""){
		$valid=false;
		$message.="-Password<br />";
	}


	if($valid){

		RegisterUser($fname, $lname, $email, $gender, $street, $city, $state, $zip, $phone,$username,$password);

		$subject = "Maxine Davis registration confirmation";
		$message= "
			You have registered at Maxine Davis Glass Art <br />

			Please visit the following link to confirm your account: <br />

			<a href=\"http://www.uvm.edu/~lkkim/cs148/assignment4.1/confirmation.php?username=".$username."\">Confirmation Link</a>
		";
		sendMail($email, $subject, $message);

		header('location: registered.php');
	}else{
		echo $message;
	}
}
include('header.php'); 

if(isset($_SESSION['valid'])){
	echo "logged in as ".$_SESSION['username']. " <br /><br />";

	echo "<a href=\"logout.php\">Logout?</a><br />";

	if($_SESSION['confirmed']==0){
		echo "You have not been confirmed. Check your inbox for a confirmation email.";
	}
}else{



?>


<p><strong>Returning Customer</strong></p>
<form action="<? echo $_SERVER['PHP_SELF']?>" method = "post">
	<label for="username2">Username</label>
	<input type="text" id="username2" name="username" /><br />

	<label for="password2">Password</label>
	<input type="password" id="password2" name="password" /><br />

	<input type="submit" name="login" value="Login" />
</form>

<br /><br />

<p><strong>New Customer</strong></p>
<form action="<? echo $_SERVER['PHP_SELF']?>" method = "post">
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

	<label for="username">Username</label>
	<input type="text" id="username" name="username" /><br />

	<label for="password">Password</label>
	<input type="password" id="password" name="password" /><br />

	<input type="submit" name="register" value="Register" />
</form>

<?php 
	}//end else

include('footer.php'); ?>