<main>  
<div style="text-align:center">
        <input type="radio" name="radio" onclick="showregister(1)">
		<label for="signupradio"><h5>New user? Sign up.</h5></label><br>
		<form action="store.php" method="post"  style="display:none"  id="signupform"> 
			<p><?php echo $error ?></p>
                <label>Username:</label><br>
                <input type="text" name="username" value="<?php echo $username ?>"><br>
                <label>Password:</label><br>
                <input type="password" name="password"><br>
				<label>Email:</label><br>
                <input type="email" name="email" value="<?php echo $email ?>"><br>
				<label>First Name:</label><br>
                <input type="text" name="fname" value="<?php echo $fname ?>"><br>
				<label>Last Name:</label><br>
                <input type="text" name="lname" value="<?php echo $lname ?>"><br><br>
				          
                <input type="submit" name = "action" value="Submit Registration" class="btn btn-outline-success my-2 my-sm-0"><br>
            

        </form>
		<br><input type="radio" name="radio" onclick="showregister(0)" checked="true">
		<label for="loginradio"><h5>Already a costumer? Log in.</h5></label>
		<form action="store.php" method="post" id="loginform">
			<p><?php echo $error ?></p>
                <label>Username:</label><br>
                <input type="text" name="username" value="<?php echo $username ?>"><br>  <br>        
                <input type="submit" name = "action" value="Continue" class="btn btn-outline-success my-2 my-sm-0"><br>
            

        </form>
</div>	
    </main>
	<script type="text/javascript">
	   function showregister(val){
		if(val == 1){
			document.getElementById("signupform").style.display="block";
			document.getElementById("loginform").style.display="none";
		}
		else{
			document.getElementById("loginform").style.display="block";
			document.getElementById("signupform").style.display="none";
		}
	}
	</script>