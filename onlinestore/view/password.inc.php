<main>
<div style="text-align:center">
		<form action="store.php" method="post">
			<p><?php echo $error ?></p>
                <h5><?php echo "password for username ". $username ?></h5>
                <label>Password:</label><br>
				<input type="hidden" name="username" value=<?php echo $username ?> >
                <input type="password" name="password"><br><br>
                <input type="submit" class="btn btn-outline-success my-2 my-sm-0" name = "action" value="Login"><br>
            

        </form>
		</div>
    </main>
	</body>
	</html>