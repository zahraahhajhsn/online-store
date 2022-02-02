<!DOCTYPE html>
<html lang="en">
<head>
     <title><?php echo $pagetitle ?></title> 
	 <link rel="stylesheet" href="css/mystyle.css">
	 <meta charset="UTF-8">
	  <meta name="viewport" content="width=device-width, initial-scale=1">
	 <link href="https://fonts.googleapis.com/css?family=Lobster" rel="stylesheet">
     <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
	 <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	 <link href="https://fonts.googleapis.com/css?family=Great+Vibes|Permanent+Marker" rel="stylesheet">
	 <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	 <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	 <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
     <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    </head>
<body>
<header>
<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
  
<a class="navbar-brand" href="store.php"><span style="color:black;font-family: 'Permanent Marker', cursive; font-size: 26px">ONLINE STORE</span></a>
	
		
		<?php if($loggedin && $isadmin)
		{ ?> <a href="store.php?action=info" class="navbar-brand" style="color:black; text-decoratio:none;"><i class="far fa-user"><?php echo " Admin ".$userDisplay ;?></i></a>
	    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
	    <ul class="navbar-nav ml-auto">
		<form method="post" action="store.php" >
		<li class="nav-item"><input type="text" name="search" placeholder="what are you looking for?" class="form-control">
		<button type="submit" name="action" value="search" class="btn btn-outline-success my-2 my-sm-0"><i class="fa fa-search"></i></button></li></form>
		<li class="nav-item active">
        <a class="nav-link" href="store.php">Home</a></li>
		<li class="nav-item"> <a class="nav-link" href="store.php?action=users">View users</a></li>
		<li class="nav-item"> <a class="nav-link" href="store.php?action=manage">Manage items and categories</a></li>
		<li class="nav-item"><a href="store.php?action=cart"><span style=" color:green; font-size:30px;">
		<i class="fa fa-shopping-cart" aria-hidden="true"><span style="color:green;" id="cart"  class="badge badge-light"><?php echo $cart;?>
		</span></i></span></a>
		<a href="store.php?action=logout" class="btn btn-outline-success my-2 my-sm-0" ><i class="fa fa-sign-out">Logout</i></a>
		</li>
		</ul>
		</div>
		<?php
		} 
		else if($loggedin && !$isadmin)
		{ ?>
	       <a href="store.php?action=info" class="navbar-brand" style="color:black; text-decoratio:none;"><i class="far fa-user"><?php echo " ".$userDisplay ;?></i></a>
	       <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
           <span class="navbar-toggler-icon"></span>
           </button>
           <div class="collapse navbar-collapse" id="navbarResponsive">
	       <ul class="navbar-nav ml-auto">
		   <form method="post" action="store.php" class="form-horizontal">
		   <li class="nav-item"><input type="action" name="search" placeholder="what are you looking for?" class="form-control"></li>
		   <li class="nav-item"><button type="submit" name="action" value="search" class="btn btn-outline-success my-2 my-sm-0"><i class="fa fa-search"></i></button></li></form>
		   <li class="nav-item active">
           <a class="nav-link" href="store.php">Home</a></li>
		   <li class="nav-item"><a href="store.php?action=cart"><span style=" color:green; font-size:30px;">
		   <i class="fa fa-shopping-cart" aria-hidden="true"><span style="color:green;" id="cart"  class="badge badge-light"><?php echo $cart;?>
		   </span></i></span></a>
		   <a href="store.php?action=logout" class="btn btn-outline-success my-2 my-sm-0" ><i class="fa fa-sign-out">Logout</i></a>
		   </li>
		   </ul>
		   </div>
		<?php
		} 
		else 
		{ ?>
	    <a href="store.php?action=signin" class="navbar-brand" style="color:black; text-decoratio:none;"><i class="far fa-user"> Hello, Sign In</i></a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
	    <ul class="navbar-nav ml-auto">
		<form method="post" action="store.php" class="form-horizontal">
		<li class="nav-item"><input type="action" name="search" placeholder="what are you looking for?" class="form-control"></li>
		<li class="nav-item"><button type="submit" name="action" value="search" class="btn btn-outline-success my-2 my-sm-0"><i class="fa fa-search"></i></button></li></form>
		<li class="nav-item active">
        <a class="nav-link" href="store.php">Home</a></li>
		<li  class="nav-item"><a href="#"><span style=" color:red; font-size:30px;">
		<i class="fa fa-shopping-cart" aria-hidden="true"><span style="color:red;" id="cart"  class="badge badge-light">0</span></i></span></a>
		</li>
		</ul>
		</div>
			
		<?php 
		} 
		?>
		
</nav>
<br><br><br><br>
</header>