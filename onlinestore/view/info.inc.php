<main>
<div style="text-align:center">
        <p><span style=" color:Black; font-size:70px;"><i class="far fa-user-circle" style="size:70px ;">
		<?php echo $username?></i></span><a onclick="edit(0)" href="#" style=" color:black"><i class="fa fa-edit"></i></a></p>
			<p><?php echo $note;
            if($note!=""){?>
       <a href="store.php?action=dismiss" style=" color:red"><i class="fa fa-times" ></a></i>	
			<?php }?></p>
            
		<h5><?php if($user['admin']==1) {?><h5>admin </h5><br><?php }
		else {?><h5>normal user</h5> <br>     <?php }?>
		<p>email: <?php echo $email?> <a onclick="edit(1)" href="#" style=" color:black"><i class="fa fa-edit"></i></a></p>
		<p>name:  <?php echo $userDisplay?> <a onclick="edit(2)" href="#" style=" color:black"><i class="fa fa-edit"></i></a></p>
		<p>password:
		<?php echo $stars ?> 
		<a onclick="edit(3)" href="#" style=" color:black"><i class="fa fa-edit"></i></a></p>	



		<div style="display:none" id="editnameform">
		<form action="store.php" method="post"  > <hr> <h5>Edit Username:</h5>
			<p><?php echo $error ?></p>
                <label>Username:</label><br>
                <input type="text" name="username" value="<?php echo $user['username'] ?>"><br><br>
                <input type="submit" name = "action" value="change username" class="btn btn-outline-success my-2 my-sm-0"><br>
        </form>
		</div>
		<div style="display:none" id="editdisplaynameform">
		<form action="store.php" method="post"  > <hr> <h5>Edit Name:</h5>
			<p><?php echo $error ?></p>
                <label>First name:</label><br>
                <input type="text" name="fname" value="<?php echo $user['fname'] ?>"><br>
				<label>Last name:</label><br>
                <input type="text" name="lname" value="<?php echo $user['lname'] ?>"><br><br>
                <input type="submit" name = "action" value="change name" class="btn btn-outline-success my-2 my-sm-0"><br>
        </form>
		</div>
		
		<div style="display:none" id="editemailform">
		<form action="store.php" method="post"> <hr><h5>Edit Email: </h5>
			<p><?php echo $error ?></p>
                <label>Username:</label><br>
                <input type="text" name="email" value="<?php echo $user['email'] ?>"><br><br>
                <input type="submit" name = "action" value="change email" class="btn btn-outline-success my-2 my-sm-0"><br>
        </form>
		</div>
		
		<div style="display:none" id="editpasswordform">
		<form action="store.php" method="post"> <hr><h5>Edit Password:</h5>
			<p><?php echo $error ?></p>
                <label>previous password:</label><br>
                <input type="password" name="passwordp"><br>
				<label>new password:</label><br>
                <input type="password" name="password" ><br><br>
                <input type="submit" name = "action" value="change password" class="btn btn-outline-success my-2 my-sm-0"><br>
        </form>
		</div>
		</div>
</main>
<script type="text/javascript">
	   function edit(val){
		if(val == 0){
			document.getElementById("editnameform").style.display="block";
			document.getElementById("editpasswordform").style.display="none";
			document.getElementById("editdisplaynameform").style.display="none";
			document.getElementById("editemailform").style.display="none";
		}
		else if (val== 1){
			document.getElementById("editnameform").style.display="none";
			document.getElementById("editpasswordform").style.display="none";
			document.getElementById("editdisplaynameform").style.display="none";
			document.getElementById("editemailform").style.display="block";
		}
		else if (val== 2){
			document.getElementById("editnameform").style.display="none";
			document.getElementById("editpasswordform").style.display="none";
			document.getElementById("editdisplaynameform").style.display="block";
			document.getElementById("editemailform").style.display="none";
		}
		else{
			document.getElementById("editnameform").style.display="none";
			document.getElementById("editpasswordform").style.display="block";
			document.getElementById("editdisplaynameform").style.display="none";
			document.getElementById("editemailform").style.display="none";
		}
	}
	</script>