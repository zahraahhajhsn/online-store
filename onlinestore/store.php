<?php
session_start(); //start session at th begining
if(isset($_SESSION['loggedin']) && isset($_SESSION['admin']))//if user is admin
{
	
	$loggedin = $_SESSION['loggedin'];//store session values in variables
	$isadmin=$_SESSION['admin'];
	$loggedin = $_SESSION['loggedin'];
	$accountid = $_SESSION['accountid'];
	$userDisplay = $_SESSION['userDisplay'];
	$username = $_SESSION['username'];
	$email = $_SESSION['email'];
	$cart=$_SESSION['cart'];
}
else if(isset($_SESSION['loggedin']) && !isset($_SESSION['admin']))//if user not admin
{ 
	$loggedin = $_SESSION['loggedin'];//store session values in variables
	$accountid = $_SESSION['accountid'];
	$userDisplay = $_SESSION['userDisplay'];
	$username = $_SESSION['username'];
	$email = $_SESSION['email'];
	$cart=$_SESSION['cart'];
	$isadmin=False;
}
else//not logged in
{
	$loggedin = False;
	$isadmin=False;
}

include("model/functions.inc.php");//include model
$action = filter_input(INPUT_POST, 'action');//get action from post

if($action == NULL){
$action = filter_input(INPUT_GET, 'action');}//get action from get

//------------------------------------------------------------------------------------for all type of users
if($action == NULL){//when begening the application
	$s="<h5>top picks for you:</h5>";
	$pagetitle = "Home";
	$categories=getCategories();//get all subcategories
	$subcategories=getSubCategories();// get all categories to show on filter menu
	$items=getItems();//get items to view in home page
	if($loggedin){ 
	if(getCartNb($accountid)!=NULL) $_SESSION['cart']= getCartNb($accountid);//set cart value as number of items added to cart
	else{  $_SESSION['cart']=0;}}//if user didn't have anything in cart
	include("view/homeheader.inc.php");//header
	include("view/categories.inc.php");//category file menu
	include("view/itemlist.inc.php");//items
	include("view/footer.inc.php");//footer
 }
 
 elseif ($action == "sub"){//filter by subcategory
	$pagetitle = "Home";
	$categories=getCategories();
	$subcategories=getSubCategories();
	$subcategoryid=filter_input(INPUT_GET, 'id1');//get subcategory selected
	$categoryid=filter_input(INPUT_GET, 'id2');//get category selected
	$subcategory=getsubCategory($subcategoryid);
	$category=getCategory($categoryid);
	$s="<h5>filtered by ".$category['name'] .": ".$subcategory['name'] ."</h5>";//put what category and subcategory seleceted
	$items=getItemssubCategories($subcategoryid);//get items with category id like seleceted
	include("view/homeheader.inc.php");
	include("view/categories.inc.php");
	include("view/itemlist.inc.php");//reload same page
    include("view/footer.inc.php");

}

elseif($action=="search"){//search for item based on number/name/category/subcategory
	$pagetitle = "Home";
	$categories=getCategories();
	$subcategories=getSubCategories();
	$text=filter_input(INPUT_POST, 'search');//get entered value
	
	$items1=getResultSearchSubcategories($text);
	$items2=getResultSearchCategories($text);
	$items3=getResultSearchName($text);
	if($items1 || $items2 || $items3 ){
		if($items1) $items=$items1;
		else if ($items2){$items=$items2;}
		else {
			$items=$items3;}
		$s="<h5>showing results of ".$text."</h5>";//idf there is matching items
	   include("view/homeheader.inc.php");
	   include("view/categories.inc.php");
       include("view/itemlist.inc.php");//reload same page
	   include("view/footer.inc.php");}
	else{
		$items=NULL;
		$s="<h5>No such item or category</h5>";//if not
	include("view/homeheader.inc.php");
	include("view/categories.inc.php");
    include("view/itemlist.inc.php");//reload same page
	include("view/footer.inc.php");
		
	}
}
else if($action == "showitem"){//pressing on a specific item to view details and to add to cart(if user is loggedin)
	$pagetitle="Item";
	$id=filter_input(INPUT_GET, 'id');//get id a seleceted item
	$item=getItem($id);//get this item from database
	$rate=getRate($id);//get rate of this item
	$reviews=getReviews($id);//get reviews of this item
	$error="";
	include("view/homeheader.inc.php");
	include("view/item.inc.php");//item view
	include("view/rates.inc.php");//rates and reviews view
	include("view/footer.inc.php");
}
elseif($action=="adminlogin"){//request to login as admin
	$error = "";
	$username="";
			$pagetitle="Admin Login";
			include("view/homeheader.inc.php");
			include("view/adminlogin.inc.php");//go to admin page
			include("view/footer.inc.php");
	
}
elseif($action=="login as admin"){//after entereing email and password of admin
	$username = filter_input(INPUT_POST, 'username');
	$password = filter_input(INPUT_POST, 'password');
	if($username != " " && $password!= " "){//check if not empty
	$account = processLogin($username, $password);//check if account exists first
		if($account != NULL)//account exixts
		{
			if(checkAdmin($account['id'])){//check if this account is admin account
			    $_SESSION['admin']=true;//set session variables accordingly
			    $_SESSION['loggedin'] = True;
			    $_SESSION['username'] = $account['username'];
			    $_SESSION['accountid']= $account['id'];
			    $_SESSION['email'] = $account['email'];
			    $_SESSION['userDisplay'] = $account['fname']." ".$account['lname'];
				$_SESSION['cart']=getCartNb($accountid);
				$pagetitle="Home";
				$s=" ";
				$subcategories=getSubCategories();
				$categories=getCategories();
		        $items=getItems();
	           header("Location:store.php");//reload to homr page
		
			}
			else{
			$error = "<p>access denied! try again with an admin account.</p>";	//account exists but not admin
			$pagetitle="Admin Login";
			include("view/homeheader.inc.php");
			include("view/adminlogin.inc.php");//reload same page
			include("view/footer.inc.php");
		}	
				
			}
		else
		{   
			$error = "<p>Incorrect login, try again</p>";	//account does not exixt or password is incorrect
			$pagetitle="Admin Login";
			include("view/homeheader.inc.php");
			include("view/adminlogin.inc.php");//reload same page
			include("view/footer.inc.php");
		}	
	}
	else{
		$error = "<p>Please complete all fields</p>";//any field is empty	
			$pagetitle="Admin Login";
			include("view/homeheader.inc.php");
			include("view/adminlogin.inc.php");//reload same page
			include("view/footer.inc.php");
		
	}
	}


//---------------------------------------------------------------------------------------------------//not authenticated in user
if(!$loggedin){
  if($action == "signin")//sign in as a new or old user
	{ 
        $pagetitle="Sign In";
		$error="";
		$username = "";
		$email="";
		$fname = "";
		$lname="";
			include("view/homeheader.inc.php");
			include("view/signin.inc.php");//go signin view
			include("view/footer.inc.php");
	}
elseif($action == "Continue")//if user entered his username and pressed continue to verify and go to password viw
	{   
	$username = filter_input(INPUT_POST, 'username');//get username
	$email="";
	$fname = "";
	$lname="";
	if($username != "" ){//verify username not empty
	if(checkUsername($username) == false){//if user exists
		$pagetitle="Login";
		$error="";
		include("view/homeheader.inc.php");
		include("view/password.inc.php");//go to passsword view
		include("view/footer.inc.php");
	}
	else{//user does not exist
		$error="<p>username not found!</p>";//error message
		$pagetitle="Login";
		include("view/homeheader.inc.php");
		include("view/signin.inc.php");//reloadthe same page
		include("view/footer.inc.php");
	}
	}
	else{//user is empty
		$error="<p>username can't be empty!</p>";//error message
		$pagetitle="Login";
		include("view/homeheader.inc.php");
		include("view/signin.inc.php");//reload the same page
		include("view/footer.inc.php");
		
	}
}

elseif($action == "Submit Registration")//if user choosed to sign in as a new user and entered his information in the form
	{   
	$username = filter_input(INPUT_POST, 'username');//get entered information
	$password = filter_input(INPUT_POST, 'password');
	$email=filter_input(INPUT_POST, 'email');
	$fname = filter_input(INPUT_POST, 'fname');
	$lname=filter_input(INPUT_POST, 'lname');
	if($username != "" && $email!= "" && $fname!= "" && $lname!="" && $password!= ""){//check if not empty
	  if(checkUsername($username) == true){//check if username avaialable
		    $_SESSION['loggedin'] = True;//set session values to authenticate user
			$_SESSION['username'] = $username;
			$_SESSION['email'] = $email;
			$_SESSION['userDisplay'] = $fname." ".$lname;
			$id=addAccount($username, $password, $email, $fname, $lname);//add account to database and get id to store in session
			$_SESSION['accountid'] = $id;
			$_SESSION['cart']=0;//new user has empty care
			header("Location:store.php");//reload the home page
		}
	  
	  else{//username is taken before
		$error="<p>username already exists! please use another username.</p>";
		$pagetitle="Sign In";
		include("view/homeheader.inc.php");
		include("view/signin.inc.php");//reload same page
		include("view/footer.inc.php");
		echo '
		<script type="text/JavaScript">
		 showregister(1);
		</script>
		' ;	
		
	  }
	}
	else{
		$error="<p>Please complete all fields</p>";//any field is empty
		$pagetitle="Sign In";
		include("view/homeheader.inc.php");
		include("view/signin.inc.php");//reload same page
		include("view/footer.inc.php");
		echo '
		<script type="text/JavaScript">
		 showregister(1);
		</script>
		' ;	//this js function sets the form according to what the user choosed(login or sigunup)
		//the function called to view the signup form after reload
		
	}
}
else if($action == "Login")//after username verified and password entered
	{
		$username = filter_input(INPUT_POST, 'username');//take from hidden input
		$password = filter_input(INPUT_POST, 'password');
		
		$account = processLogin($username, $password);//get the account if exists
		if($password!= ""){//if entered passsowrd is not empty
		if($account != NULL)
		{
			$_SESSION['loggedin'] = True;//set session variables
			$_SESSION['username'] = $account['username'];
			$_SESSION['accountid']= $account['id'];
			$_SESSION['email'] = $account['email'];
			if(getCartNb($account['id']!=NULL)) $_SESSION['cart']=getCartNb($account['id']);
	       else{  $_SESSION['cart']=0;}
			$_SESSION['userDisplay'] = $account['fname']." ".$account['lname'];
			if(checkAdmin($account['id'])){//if loggedin user is admin
			     $_SESSION['admin']=true;
			}
			header("Location:store.php");//reload to homr page
		}
		else
		{   
			$error = "<p>Incorrect password, try again</p>";//password is incorrect	
			$pagetitle="Login";
			include("view/homeheader.inc.php");
			include("view/password.inc.php");//reload same page
			include("view/footer.inc.php");
		}	
	}
	
	else{
		$error = "<p>password can't be empty!</p>";	//password is empty
			$pagetitle="Login";
			include("view/homeheader.inc.php");
			include("view/password.inc.php");//reload same page
			include("view/footer.inc.php");
		
	}
	}
	
}
//----------------------------------------------------------------------------------------------------

else{//authenticated users
	if($action == "logout")//user pressed logout
	{ 
		$_SESSION = array(); 
		session_destroy();//delete content of session and reload to home page as non authenticated user
		header("Location:store.php");
	}

else if($action == "info"){//user pressed on personal information to edit
		$error="";
		$note="";
		$user=getAccount($accountid);//get account information
		$stars=printstarts($user['password']);//to block password by stars
		$pagetitle="Account Information";
		include("view/homeheader.inc.php");
		include("view/info.inc.php");//go to info page
		include("view/footer.inc.php");
	}
elseif($action == "change username")//user wants to change username
	{   
	$user=getAccount($accountid);
	$username = filter_input(INPUT_POST, 'username');
	if($username != "" ){//not empty
	if(checkUsername($username) == true){//if entered username is available
		editAccount($accountid,$username,$user['password'],$user['email'],$user['fname'],$user['lname']);//update in database
		$user=getAccount($accountid);//get user
		$_SESSION['username'] = $username;//update session
		$error="";
		$note="username changed successfully";//success note
		$stars=printstarts($user['password']);
		$pagetitle="Account Information";
		include("view/homeheader.inc.php");
		include("view/info.inc.php");//reload the page
		include("view/footer.inc.php");
	}
	else{
		$note="";
		$error="<p>username not available!</p>";//username is already existing
		$user=getAccount($accountid);
		$stars=printstarts($user['password']);
		$pagetitle="Account Information";
		include("view/homeheader.inc.php");
		include("view/info.inc.php");//reload trhis page
		include("view/footer.inc.php");
		echo '
		<script type="text/JavaScript">
		 edit(0);
		</script>
		' ;	//to show change username form after reload
	}
	}
	else{
		$note="";
		$error="<p>username can't be empty!</p>";//user name is empty
		$user=getAccount($accountid);
		$stars=printstarts($user['password']);
		$pagetitle="Account Information";
		include("view/homeheader.inc.php");
		include("view/info.inc.php");//reload the page
		include("view/footer.inc.php");
		echo '<script type="text/JavaScript">
		 edit(0);
		</script>
		' ;	
		
	}
}
elseif($action == "change email")//user pressed change email
	{   
	$user=getAccount($accountid);
	$email = filter_input(INPUT_POST, 'email');
	if($email!= "" ){//if email not empty
		
		editAccount($accountid,$user['username'],$user['password'],$email,$user['fname'],$user['lname']);//update database
			$_SESSION['email'] = $email;//update session
		
		$error="";
		$note="email changed successfully";//success note
		$user=getAccount($accountid);
		$stars=printstarts($user['password']);
		$pagetitle="Account Information";
		include("view/homeheader.inc.php");
		include("view/info.inc.php");//reload same page
		include("view/footer.inc.php");
	}
	else{
		$note="";//email empty
		$error="<p>email can't be empty!</p>";
		$user=getAccount($accountid);
		$stars=printstarts($user['password']);
		$pagetitle="Account Information";
		include("view/homeheader.inc.php");
		include("view/info.inc.php");//reload same page
		include("view/footer.inc.php");
		echo '<script type="text/JavaScript">
		 edit(1);
		</script>
		' ;// js function to show email form after reload	
		
	}
}
elseif($action == "change name")//user pressed change display name(fname and lname)
	{   
	$fname = filter_input(INPUT_POST, 'fname');
	$lname = filter_input(INPUT_POST, 'lname');
	$user=getAccount($accountid);
	if($fname!="" && $lname!="" ){//if not empty
		
		editAccount($accountid,$user['username'],$user['password'],$user['email'],$fname,$lname);//update database
			$_SESSION['userDisplay'] = $fname." ".$lname;//update session
		$error="";
		$note="name changed successfully";//success note
		$user=getAccount($accountid);
		$stars=printstarts($user['password']);
		$pagetitle="Account Information";
		include("view/homeheader.inc.php");
		include("view/info.inc.php");//reload the page
		include("view/footer.inc.php");
		
	}
	else{
		$note="";//empty fields
		$error="<p>feilds can't be empty!</p>";
		$user=getAccount($accountid);
		$stars=printstarts($user['password']);
		$pagetitle="Account Information";
		include("view/homeheader.inc.php");
		include("view/info.inc.php");
		include("view/footer.inc.php");//reload the page
		echo '<script type="text/JavaScript">
		 edit(2);
		</script>
		' ;	//js function to show change name form after reload
		
	}
}
elseif($action == "change password")//user pressed change password
	{   
	$prevpassword = filter_input(INPUT_POST, 'passwordp');//previous password entered
	$password = filter_input(INPUT_POST, 'password');//new password entered
	$user=getAccount($accountid);
	if($prevpassword!="" || $password!="" ){//not empty
	  if(processLogin($username, $prevpassword)!=NULL){//if previous password is correct
		editAccount($accountid,$user['username'],$password,$user['email'],$user['fname'],$user['lname']);//update database
		$error="";
		$note="password changed successfully";//success note
		$user=getAccount($accountid);
		$stars=printstarts($user['password']);
		$pagetitle="Account Information";
		include("view/homeheader.inc.php");
		include("view/info.inc.php");//reload same page
		include("view/footer.inc.php");
	  }
	  else{
		$note="";//previous password doesn't match that in db
		$error="<p>previous password is incorrect!</p>";
		$user=getAccount($accountid);
		$stars=printstarts($user['password']);
		$pagetitle="Account Information";
		include("view/homeheader.inc.php");
		include("view/info.inc.php");//reload the page
		include("view/footer.inc.php");
		echo '<script type="text/JavaScript">
		 edit(3);
		</script>
		' ;	//js function to view password form after reload
		  
	  }
	}
	else{
		$note="error! please try again";//field is empty
		$error="<p>feilds can't be empty!</p>";
		$user=getAccount($accountid);
		$stars=printstarts($user['password']);
		$pagetitle="Account Information";
		include("view/homeheader.inc.php");
		include("view/info.inc.php");//reload the page
		include("view/footer.inc.php");
		echo '<script type="text/JavaScript">
		 edit(3);
		</script>
		' ;	
		
	}
}
else if($action =="dismiss"){//remove success note in personal info page
	   $error="";
		$note="";
		$user=getAccount($accountid);
		$stars=printstarts($user['password']);
		$pagetitle="Account Information";
		include("view/homeheader.inc.php");
		include("view/info.inc.php");
		include("view/footer.inc.php");
}

else if($action == "add to cart"){//add item to cart
	$pagetitle="Item";
	$id=filter_input(INPUT_POST, 'id');//itemid
	$amount=filter_input(INPUT_POST, 'amount');//amount of this item
	
	if($amount!="" && is_numeric($amount)){//check if amount is avialbale
	  if(checkAmount($amount,$id)==True){//check if amount available in stock
	    addToCart($accountid,$id,$amount);//add to database
		$error="";
		$item=getItem($id);
	    $rate=getRate($id);
	    $reviews=getReviews($id);
		$_SESSION['cart']=getCartNb($accountid);//update session
		$cart=$_SESSION['cart'];
	    include("view/homeheader.inc.php");
	    include("view/item.inc.php");
		include("view/rates.inc.php");//reload the page
	    include("view/footer.inc.php");}
		else{
			$error="<p>amount is not avaialable in stock.</p>";//amount not avlaible in stock
		    $item=getItem($id);
	        $rate=getRate($id);
	        $reviews=getReviews($id);
	    include("view/homeheader.inc.php");
	    include("view/item.inc.php");
		include("view/rates.inc.php");//reload the page
	    include("view/footer.inc.php");
			
		}
	}else{
		$error="<p>amount is requiered.</p>";//amout is empty
		$item=getItem($id);
	    $rate=getRate($id);
	    $reviews=getReviews($id);
	    include("view/homeheader.inc.php");
	    include("view/item.inc.php");
		include("view/rates.inc.php");//reload the page
	    include("view/footer.inc.php");
	}
}
else if($action == "cart"){//user pressed cart to see selected items
	$error="";
	$pagetitle="Cart";
	$items= getCart($accountid);
	$total=getTotal($items);
	include("view/homeheader.inc.php");
	include("view/cart.inc.php");//go to cart page
	include("view/footer.inc.php");
	
}
else if($action == "emptycart"){//delete all items from cart
	$error="";
	cancelCart($accountid);//update db
	$_SESSION['cart']=0;
	$cart=$_SESSION['cart'];//update cart
	header("Location:store.php");//reload to home
		
}
else if($action == "removeitem"){//remove item from cart
	$error="";
	$pagetitle="Cart";
	$id=filter_input(INPUT_GET, 'id');//item id
	deleteItemFromCart($id,$accountid);//delete item from cart
	$_SESSION['cart']=getCartNb($accountid);//update session with new cart price 
	$cart=$_SESSION['cart'];
	$items=getCart($accountid);
	$total=getTotal($items);//get total price in card
	include("view/homeheader.inc.php");
	include("view/cart.inc.php");//reload same page
	include("view/footer.inc.php");
	
}
else if($action == "verify"){//edit amount of an item in cart
	$amount=filter_input(INPUT_POST, 'amount');//new amount
	$id=filter_input(INPUT_POST, 'id');//itemid
	if($amount!="" && is_numeric($amount)){//chcek if amount is available
	if(checkAmount($amount,$id)){//check if amount available in stock
	    $error="";
	    editCart($accountid,$id,$amount);//update cart
	    $pagetitle="Cart";
	    $_SESSION['cart']=getCartNb($accountid);//update session
	    $cart=$_SESSION['cart'];
	    $items=getCart($accountid);
	    $total=getTotal($items);//get total price in cart
	    include("view/homeheader.inc.php");
	    include("view/cart.inc.php");//reload same page
	    include("view/footer.inc.php");}
	else{
		$error="<p>amount not available in stock.</p>";//not avilable amount
	    $pagetitle="Cart";
	    $_SESSION['cart']=getCartNb($accountid);
	    $cart=$_SESSION['cart'];
	    $items=getCart($accountid);
	    $total=getTotal($items);
	    include("view/homeheader.inc.php");
	    include("view/cart.inc.php");//reload same page
	    include("view/footer.inc.php");
	    echo '<script type="text/JavaScript">
		 view(0);
		</script>
		' ;	
	}
	}
	else{
	$error="<p>amount is requiered.</p>";//field id empty
	$pagetitle="Cart";
	$_SESSION['cart']=getCartNb($accountid);
	$cart=$_SESSION['cart'];
	$items=getCart($accountid);
	$total=getTotal($items);
	include("view/homeheader.inc.php");
	include("view/cart.inc.php");//reload ame pahge
	include("view/footer.inc.php");
	echo '<script type="text/JavaScript">
		 view(0);
		</script>
		' ;	//js function to view change amount form after reload
	}
	
	
	
}
else if($action == "submit review"){
	$review=filter_input(INPUT_POST, 'review');//review
	$id=filter_input(INPUT_POST, 'id');//itemid
	$rate=filter_input(INPUT_POST, 'rating');//rating
  if($review!="" ){//not empty field
	$error="";
	addReview($accountid, $id, $review);//add review to database
	addRate($accountid, $id, $rate);//add rate to dataabase
	$pagetitle="Item";
	$item=getItem($id);
	$rate=getRate($id);
	$reviews=getReviews($id);
	include("view/homeheader.inc.php");
	include("view/item.inc.php");//reload same page
	include("view/rates.inc.php");
	include("view/footer.inc.php");
 } else{
	$error="<p>review can't be empty.</p>";//empty field
	$pagetitle="Item";
	$item=getItem($id);
	$rate=getRate($id);
	$reviews=getReviews($id);
	include("view/homeheader.inc.php");
	include("view/item.inc.php");//reload same page
	include("view/rates.inc.php");
	include("view/footer.inc.php");
	
	}
	
}
else if($action == "deletereview"){//delete posted review
	$idr=filter_input(INPUT_GET, 'idr');//id of review
	$id=filter_input(INPUT_GET, 'id');//id of item
	deleteReview($idr);//delete from database
	$error="";
	$pagetitle="Item";
	$item=getItem($id);
	$rate=getRate($id);
	$reviews=getReviews($id);
	include("view/homeheader.inc.php");
	include("view/item.inc.php");//reload same page
	include("view/rates.inc.php");
	include("view/footer.inc.php");
	
	
}
else if($action == "editreview"){//edit posted review
	$review=filter_input(INPUT_POST, 'review');
	$id=filter_input(INPUT_POST, 'id');//id of item
	$idr=filter_input(INPUT_POST, 'idr');//id of review
  if($review!="" ){//not empty
	$error="";
	editReview($idr,$review);//update db
	$pagetitle="Item";
	$item=getItem($id);
	$rate=getRate($id);
	$reviews=getReviews($id);
	include("view/homeheader.inc.php");
	include("view/item.inc.php");//reload same page
	include("view/rates.inc.php");
	include("view/footer.inc.php");
 } else{
	$error="<p>review can't be empty.</p>";//empty field
	$pagetitle="Item";
	$item=getItem($id);
	$rate=getRate($id);
	$reviews=getReviews($id);
	include("view/homeheader.inc.php");
	include("view/item.inc.php");//reload same page
	include("view/rates.inc.php");
	include("view/footer.inc.php");
	echo '<script type="text/JavaScript">
		 pro();
		</script>
		' ;	//js to view edit form after reload
	}
	
}

else if($action == "checkout"){
	$error="";
	checkout($accountid);//chcek out to buy items
	$_SESSION['cart']=0;//update session
	$cart=$_SESSION['cart'];
	header("Location:store.php");//reload home
	
}
	
}//end of authenticated user functionalities
//------------------------------------------------------------------------------------admin privileges:

if($loggedin && $isadmin){ //user is admin 

	if($action == "users"){//if admin wants to view users
		$data="";
		$users=getAccounts($accountid);//get all accounts except logged in admin account
		$pagetitle="Accounts";
		include("view/homeheader.inc.php");
		include("view/accounts.inc.php");//to accounts page
		include("view/footer.inc.php");
	}
	else if($action == "delete"){//admin pressed delete a specific account
		$id=filter_input(INPUT_GET, 'id');//get id of pressed account
		deleteAccount($id);//delete from database
		$pagetitle="Account Info";
		$data=" account was removed successfully!";
		$users=getAccounts($accountid);
		$pagetitle="Accounts";
		include("view/homeheader.inc.php");
		include("view/accounts.inc.php");//reload same page
		include("view/footer.inc.php");
	}
	else if($action == "changetoadmin"){//if admin to privileges to selecetd account
		$id=filter_input(INPUT_GET, 'id');
		changeToAdmin($id);//change in database
		$pagetitle="Account Info";
		$data="account was changed to admin successfully!";
		$users=getAccounts($accountid);
		$pagetitle="Accounts";
		include("view/homeheader.inc.php");
		include("view/accounts.inc.php");//reload same page
	include("view/footer.inc.php");}
		
	else if($action == "changefromadmin"){// if admin wants to remove admin priveleges from  specific user
		$id=filter_input(INPUT_GET, 'id');
		changeFromAdmin($id);//change in database
		$pagetitle="Account Info";
		$data=" account was changed to normal user successfully!";
		$users=getAccounts($accountid);
		$pagetitle="Accounts";
		include("view/homeheader.inc.php");
		include("view/accounts.inc.php");//reload same page
		include("view/footer.inc.php");
	}
	else if($action == "manage"){//admin pressed manage items and categories
		$error="";//for errors
		$data="";//to view success notes
		$subs=getSubcategories();//get subcategories
		$cats=getCategories();//get categories
		$item="";//for search if admin searched for item using number
		$pagetitle="Manage items and categories";
		include("view/homeheader.inc.php");
		include("view/manage.inc.php");//go to manage page
		include("view/footer.inc.php");
		
	}
	 	
else if($action =="dismiss4"){ //function to dismiss success note after a specific action done in accounts page
	    $data="";
        $users=getAccounts($accountid);
		$pagetitle="Accounts";
		include("view/homeheader.inc.php");
		include("view/accounts.inc.php");
		include("view/footer.inc.php");
}

else if($action =="dismiss2"){ //function to dismiss success note after a specific action done in managing page
	   $error="";
		$data="";
		$subs=getSubcategories();
		$cats=getCategories();
		$item="";
		$pagetitle="Manage items and categories";
		include("view/homeheader.inc.php");
		include("view/manage.inc.php");
		include("view/footer.inc.php");
}
else if($action =="dismiss3"){ //function to dismiss success note after a specific action done in managing page
$item="";
		$error="";
		$data="";
		$subs=getSubcategories();
		$cats=getCategories();
		$pagetitle="Manage items and categories";
		include("view/homeheader.inc.php");
		include("view/manage.inc.php");
		include("view/footer.inc.php");
}
else if ($action== "add category"){//add new category
	$category = filter_input(INPUT_POST, 'category');//get name
	if($category!= "" ){//entered text is not empty
		if(checkCategory($category)==true){//if category doesn;t exist already
		$error="";
		$data="Category added successfully";
		addCategory($category);//entered to dataabase
		$subs=getSubcategories();
		$cats=getCategories();
		$item="";
	
		$pagetitle="Manage items and categories";
		include("view/homeheader.inc.php");
		include("view/manage.inc.php");//reload same page
		include("view/footer.inc.php");
		}
else{
	$error="<p>Category already exists!</p>";//category is already present in database
	$data="";
		$subs=getSubcategories();
		$cats=getCategories();
		$item="";
		$pagetitle="Manage items and categories";
		include("view/homeheader.inc.php");
		include("view/manage.inc.php");//reload same page
		include("view/footer.inc.php");
		echo '
		<script type="text/JavaScript">
		 add(1);
		</script>
		' ;	//js function to view add category form after reloading the page to view error
	
}		
	}
	else{
		$error="<p>field can't be empty!</p>";//field is empty
		$data="";
		$subs=getSubcategories();
		$cats=getCategories();
		$item="";
		$pagetitle="Manage items and categories";
		include("view/homeheader.inc.php");
		include("view/manage.inc.php");//reload same page
		include("view/footer.inc.php");
		echo '
		<script type="text/JavaScript">
		 add(1);
		</script>
		' ;	
	}
}
else if ($action== "add subcategory"){//add subcategrory
	$subcategory = filter_input(INPUT_POST, 'subcategory');
	$category=filter_input(INPUT_POST, 'categoryitem');
	if($category!= "null" &&  $subcategory!= ""){//category must be choosen from select menu of categoories and subcategory not empty
	  if(checksubCategory($subcategory)==true){//subcatgory does not exist already
		$error="";
		$data="Subcategory added successfully";
		addsubCategory($subcategory,$category);//add to database
		$subs=getSubcategories();
		$cats=getCategories();
		$item="";
		$pagetitle="Manage items and categories";
		include("view/homeheader.inc.php");
		include("view/manage.inc.php");//reload same page
		include("view/footer.inc.php");
	  }
	  else{
		  $error="<p>subcategory already exits!</p>";//subcategory esixts 
		  $data="";
		$subs=getSubcategories();
		$cats=getCategories();
		$item="";
		$pagetitle="Manage items and categories";
		include("view/homeheader.inc.php");
		include("view/manage.inc.php");//reload same page
		include("view/footer.inc.php");
		echo '
		<script type="text/JavaScript">
		 add(2);
		</script>
		' ;	//js function to view add subcategory form after reloading the page to view error
		
	}
	}
	else{
		$error="<p>field can't be empty!</p>";//a field is empty
		$data="";
		$subs=getSubcategories();
		$cats=getCategories();
		$item="";
		$pagetitle="Manage items and categories";
		include("view/homeheader.inc.php");
		include("view/manage.inc.php");//reload same page
		include("view/footer.inc.php");
		echo '
		<script type="text/JavaScript">
		 add(2);
		</script>
		' ;	
	}
}
else if ($action== "add item"){//admin pressed add item
	define("UPLOAD_DIR", "images/");//define directory
	$myFile = $_FILES["image"];//get entered file
	$itemname=filter_input(INPUT_POST, 'itemname');//get entered fields
	$stock=filter_input(INPUT_POST, 'stock');
	$price=filter_input(INPUT_POST, 'price');
	$description=filter_input(INPUT_POST, 'description');
	$subcategory=filter_input(INPUT_POST, 'subcategoryitem');
	if($myFile['name']!=NULL){//if there is an enetered file
	    if ($itemname!="" && $price!="" && $price!="0" 
	&& is_numeric($price) && is_numeric($stock)&& $subcategory!="null" 
	&&$stock !="" && $description!="") {//no file error and non empty fields or wrong inputs
			$name = preg_replace("/[^A-Z0-9._-]/i", "_", $myFile["name"]);//extract file name
		$i = 0;
		$parts = pathinfo($name);
		while (file_exists(UPLOAD_DIR . $name)) {
			$i++;
			$name = $parts["filename"] . "-" . $i . "." . $parts["extension"];
		}
		move_uploaded_file($myFile["tmp_name"], UPLOAD_DIR . $name);
		chmod(UPLOAD_DIR . $name, 0644);
		$image=UPLOAD_DIR."".$name;//male image put in a speicicfied directory
		$itemnb=generateSerial();//generate a random number for this item
		addItem($itemname,$stock,$description,$price,$subcategory,$itemnb,$image);//enter item to database
		$error="";
		$data="Please note that the item number of added item is: ".$itemnb;//let the admin know generated item number
		$subs=getSubcategories();
		$cats=getCategories();
		$item="";
	
		$pagetitle="Manage items and categories";
		include("view/homeheader.inc.php");
		include("view/manage.inc.php");//reload same page
		include("view/footer.inc.php");
        }
		else{
		$error = "<p>An error occured and fields can't be empty</p>";//eror occured or any field is empty
			$subs=getSubcategories();
		    $cats=getCategories();
			$data="";
		    $item="";
		    $pagetitle="Manage items and categories";
		    include("view/homeheader.inc.php");
		    include("view/manage.inc.php");//reload same page
		    include("view/footer.inc.php");
		    echo '<script type="text/JavaScript">
		        add(0);
		    </script>' ;//js function to show add item form after reload
		}}
	else{//else if no file is entered
		if ($itemname!="" && $price!="" && $price!="0" 
	&& is_numeric($price) && is_numeric($stock)&& $subcategory!="null" 
	&&$stock !="" && $description!="") {//check fields not empty
		$itemnb=generateSerial();
		$image="images/null.jpg";//make image= default image present in images in case no images are available to upload
		addItem($itemname,$stock,$description,$price,$subcategory,$itemnb,$image);//add to database
		$error="";
		$data="Please note that the item number of added item is: ".$itemnb;
		$subs=getSubcategories();
		$cats=getCategories();
		$item="";
		$pagetitle="Manage items and categories";
		include("view/homeheader.inc.php");
		include("view/manage.inc.php");//reload same page
		include("view/footer.inc.php");}

		else{
			$error = "<p>fields can't be empty</p>";//any field is empty
		$data="";
			$subs=getSubcategories();
		    $cats=getCategories();
		    $item="";
		    $pagetitle="Manage items and categories";
		    include("view/homeheader.inc.php");
		    include("view/manage.inc.php");//reload same page
		    include("view/footer.inc.php");
		    echo '<script type="text/JavaScript">
		        add(0);
		    </script>' ;
		
		
	}}
	
}
else if($action== "searchi"){//search for a product by number
	$itemnb=filter_input(INPUT_POST, 'searchn');
	if($itemnb!=""){//not empty number
	$result=getItemnb($itemnb);
	 if($result!=NULL){//if there exist item with this number
		$item=$result;//to show item details
		$error="";
		$data="";
		$subs=getSubcategories();
		$cats=getCategories();
		$pagetitle="Manage items and categories";
		include("view/homeheader.inc.php");
		include("view/manage.inc.php");//reload same page
		include("view/footer.inc.php");
	 }
	 else{
		$item="item of the interened number does not exist";//no such item
		$error="";
		$data="";
		$subs=getSubcategories();
		$cats=getCategories();
		$pagetitle="Manage items and categories";
		include("view/homeheader.inc.php");
		include("view/manage.inc.php");//reload same page
		include("view/footer.inc.php");
	}
	}else{
		$item="this field can't be empty";//if no enetered number
		$error="";
		$data="";
		$subs=getSubcategories();
		$cats=getCategories();
		$pagetitle="Manage items and categories";
		include("view/homeheader.inc.php");
		include("view/manage.inc.php");//reload same page
		include("view/footer.inc.php");
		
	}
	
}
else if($action =="itemi"){//admin pressed on edit item
	$id=filter_input(INPUT_GET, 'id');//get id of item
	$item=getItem($id);//get information
	$number=$item['itemnb'];//initialize information
	$itemname=$item['itemname'];
	$image=$item['image'];
	$price=$item['price'];
	$stock=$item['stock'];
	$description=$item['description'];
	$subcategory=$item['subcategory'];
	$error="";
	$pagetitle="Edit item";
	$subs=getSubcategories();
	include("view/homeheader.inc.php");
	include("view/edititem.inc.php");//go to edit item page
	include("view/footer.inc.php");
		
}
elseif($action =="itemrem"){//admin pressed on remove item
        $id=filter_input(INPUT_GET, 'id');//get id of item
	    deleteItem($id);//remove from database
        $item="";
		$error="";
		$data="item removed successfully!";
		$subs=getSubcategories();
		$cats=getCategories();
		$pagetitle="Manage items and categories";
		include("view/homeheader.inc.php");
		include("view/manage.inc.php");//reload same page
		include("view/footer.inc.php");
		
	
}
else if ($action== "confirm"){//confirm edit item
	define("UPLOAD_DIR", "images/");//define directory
	$myFile = $_FILES["image"];//get image
	$itemname=filter_input(INPUT_POST, 'itemname');
	$number=filter_input(INPUT_POST, 'number');
	$id=filter_input(INPUT_POST, 'id');
	$stock=filter_input(INPUT_POST, 'stock');
	$price=filter_input(INPUT_POST, 'price');
	$description=filter_input(INPUT_POST, 'description');
	$subcategory=filter_input(INPUT_POST, 'subcategoryitem');
	$item=getItem($id);
	$oldimage=$item['image'];//get image already was set before
	if ( $itemname!="" && $price!="" && $price!="0" 
	&& is_numeric($price) && is_numeric($stock)&& $subcategory!="null" 
	&&$stock !="" && $stock!="0" && $description!="") {//if no error or wrong or empty fields
			if($myFile["name"]==NULL){//if no uploaded image
			$image=$oldimage;//user old set image
		
		
		}
		else{//new image is uploaded
			$name = preg_replace("/[^A-Z0-9._-]/i", "_", $myFile["name"]);
		$i = 0;
		$parts = pathinfo($name);
		while (file_exists(UPLOAD_DIR . $name)) {
			$i++;
			$name = $parts["filename"] . "-" . $i . "." . $parts["extension"];
		}
		move_uploaded_file($myFile["tmp_name"], UPLOAD_DIR . $name);
		chmod(UPLOAD_DIR . $name, 0644);
		$image=UPLOAD_DIR."".$name;
			
		}
		editItem($id,$price,$itemname,$stock,$description,$number,$subcategory,$image);//edit item in database
		$error="";
		$data="Item was been edited successfully";//success note
		$subs=getSubcategories();
		$cats=getCategories();
		$item="";
		$pagetitle="Manage items and categories";
		include("view/homeheader.inc.php");
		include("view/manage.inc.php");//go back to previous page
		include("view/footer.inc.php");
		}
		   
        
    else{
		$error = "<p>An error occured and fields can't be empty</p>";//if error or any empty field
	        $pagetitle="Edit item";
	        $subs=getSubcategories();
	        include("view/homeheader.inc.php");
	        include("view/edititem.inc.php");//reload same page
	        include("view/footer.inc.php");
		}
}
//-------------------------------------------------------------------end of admin privileges


}	



?>
