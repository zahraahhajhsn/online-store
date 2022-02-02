<main>
<div style="text-align:center">
        <h1>Login Form</h1>
		<form action="store.php" method="post">

			<p><?php echo $error ?></p>
                <label>Username:</label>
                <input type="text" name="username" value="<?php echo $username ?>"><br>

                <label>Password:</label>
                <input type="password" name="password"><br>
				          
                <input type="submit" name = "action" value="login as admin"><br>
            

        </form>
		</div>
    </main>