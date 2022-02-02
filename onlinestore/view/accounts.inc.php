<main>
<h1> List of all users:</h1>
<p><?php echo $data;
if($data!=""){?>
       <a href="store.php?action=dismiss4" style=" color:red"><i class="fa fa-times" ></a></i>	
			<?php }?></p>
	<?php 
	foreach($users as $user): ?>
		    <p><span style=" color:green; font-size:30px;"><i class="far fa-user-circle" style="size:18px">
			<?php echo $user['username']?></p></i></span>
			<?php if($user['admin']==1) {?> privellage: admin |
            <a href="store.php?action=delete&id=<?php echo $user['id']?>" style=" color:black"><i class="fa fa-user-times" >remove</a></i>
			<a href="store.php?action=changefromadmin&id=<?php echo $user['id']?>" style=" color:black"><i class="fa fa-edit">change to normal user</i></a><?php }

			else { ?> privellage: normal user |
			<a href="store.php?action=delete&id=<?php echo $user['id']?>" style=" color:black"><i class="fa fa-user-times" >remove</a></i>
			<a href="store.php?action=changetoadmin&id=<?php echo $user['id']?>" style=" color:black"><i class="fa fa-edit">change to admin</i></a>
			</p>
			<?php } ?> 
			
			<hr>
    <?php 
    endforeach;
		?>
	
	
	</main>