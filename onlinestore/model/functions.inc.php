<?php
	$dsn = 'mysql:host=localhost:3308;dbname=store';
	$dbuser = 'root';
	$dbpass = '';

	$db = new PDO($dsn, $dbuser, $dbpass);
	
	function addItem($itemname,$stock,$description,$price,$subcategory,$itemnb,$image)
	{
		
		global $db;
		$query = 'INSERT INTO items (itemname, stock, description, 
		price,subcategory,itemnb,image)
				  VALUES (:itemname, :stock, :description, 
		:price,:subcategory,:itemnb,:image)';
		$statement = $db->prepare($query);
		$statement->bindValue(':itemname', $itemname);
		$statement->bindValue(':stock', $stock);
		$statement->bindValue(':description', $description);
		$statement->bindValue(':price', $price);
		$statement->bindValue(':subcategory', $subcategory);
		$statement->bindValue(':itemnb', $itemnb);
		$statement->bindValue(':image', $image);
		
		$statement->execute();
		$statement->closeCursor();		
	}
	function addCategory($category){
		global $db;
		$query = 'INSERT INTO categories ( name)
				  VALUES (:category) ';
		$statement = $db->prepare($query);
		$statement->bindValue(':category', $category);
		$statement->execute();
		$statement->closeCursor();		
		
	}
	function addsubCategory($subcategory,$category){
		global $db;
		$query = 'INSERT INTO subcategories ( name,category)
				  VALUES (:subcategory,:category) ';
		$statement = $db->prepare($query);
		$statement->bindValue(':subcategory', $subcategory);
		$statement->bindValue(':category', $category);
		$statement->execute();
		$statement->closeCursor();	
		
	}
	function getItems()
	{
		global $db;
		$query = 'SELECT * FROM items ORDER BY RAND() limit 15';
		$statement = $db->prepare($query);
		
		$statement->execute();
		$items = $statement->fetchAll();
		$statement->closeCursor();	
		
		return $items;
	}
	
	function getItemssubCategories($subcategoryid)
	{
		global $db;
		$query = 'SELECT * from items WHERE subcategory = :subcategoryid';
		$statement = $db->prepare($query);
		$statement->bindValue(':subcategoryid', $subcategoryid);
		$statement->execute();
		$items = $statement->fetchAll();
		$statement->closeCursor();
		
		return $items;
	}
	
	function getCategory($categoryid)
		{
		global $db;
		$query = 'SELECT name from categories WHERE id = :categoryid';
		$statement = $db->prepare($query);
		$statement->bindValue(':categoryid', $categoryid);
		$statement->execute();
		$category = $statement->fetch();
		$statement->closeCursor();
		return $category;
	}
	function getCategoryid($subcategoryid)
		{
		global $db;
		$query = 'SELECT category from subcategories WHERE id = :subcategoryid';
		$statement = $db->prepare($query);
		$statement->bindValue(':subcategoryid', $subcategoryid);
		$statement->execute();
		$category = $statement->fetch();
		$statement->closeCursor();
		return $category['name'];
	}
	function getsubCategory($subcategoryid)
		{
		global $db;
		$query = 'SELECT name from subcategories WHERE id = :subcategoryid';
		$statement = $db->prepare($query);
		$statement->bindValue(':subcategoryid', $subcategoryid);
		$statement->execute();
		$subcategory = $statement->fetch();
		$statement->closeCursor();
		
		return $subcategory;
	}
	function getItem($id)
	{
		global $db;
		$query = 'SELECT * FROM items WHERE id = :id';
		$statement = $db->prepare($query);
		$statement->bindValue(':id', $id);
		$statement->execute();
		$item = $statement->fetch();
		$statement->closeCursor();	
		return $item;
	}
	
	function getItemnb($itemnb)
	{
		global $db;
		$query = 'SELECT * FROM items WHERE itemnb = :itemnb';
		$statement = $db->prepare($query);
		$statement->bindValue(':itemnb', $itemnb);
		$statement->execute();
		$item = $statement->fetch();
		$statement->closeCursor();	
		return $item;
	}
	
	function getResultSearchName($text){
		global $db;
		$query = 'SELECT * FROM items
		WHERE itemname REGEXP :text OR description REGEXP :text OR itemnb =:text
		OR :text REGEXP  itemname OR :text REGEXP description';
		$statement = $db->prepare($query);
		$statement->bindValue(':text', $text);
		$statement->execute();
		$item = $statement->fetchAll();
		$statement->closeCursor();
		 return $item;
		
	}
	function getResultSearchSubcategories($text){
		global $db;
		$query = 'SELECT a.* FROM  items a
					JOIN subcategories c
					ON a.subcategory = c.id
		         WHERE c.name REGEXP :text or  :text REGEXP c.name';
		$statement = $db->prepare($query);
		$statement->bindValue(':text', $text);
		$statement->execute();
		$item = $statement->fetchAll();
		$statement->closeCursor();
		 return $item;
		
	}
	function getResultSearchCategories($text){
		global $db;
		$query = 'SELECT a.* FROM  items a
					JOIN subcategories s ON  s.id = a.subcategory
					JOIN categories c ON c.id=s.category
		            WHERE c.name REGEXP :text or  :text REGEXP c.name';
		$statement = $db->prepare($query);
		$statement->bindValue(':text', $text);
		$statement->execute();
		$item = $statement->fetchAll();
		$statement->closeCursor();
		 return $item;
		
	}
	
	
	function generateSerial() {
		$chars = array(0,1,2,3,4,5,6,7,8,9,'A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
        $sn = '';
        $max = count($chars)-1;
        for($i=0;$i<12;$i++){
   	    $sn .= (!($i % 5) && $i ? '-' : '').$chars[rand(0, $max)];}
        global $db;
		$query = 'SELECT * FROM items where itemnb=:itemnb';
		$statement = $db->prepare($query);
		$statement->bindValue(':itemnb', $sn);
		$statement->execute();
		$s1 = $statement->fetch();
		$statement->closeCursor();
		
		while ($s1 == $sn){
			generateSerial();
		}
        
        return $sn;
      } 

	function editItem($id,$price,$itemname,$stock,$description,$number,$subcategory,$image)
	{
		global $db;
		$query ='UPDATE items SET itemname=:itemname, stock=:stock, 
		description=:description, price=:price, 
		subcategory=:subcategory, itemnb=:itemnb, image=:image
						WHERE id = :id';
		
		$statement = $db->prepare($query);
		$statement->bindValue(':id', $id);
		$statement->bindValue(':itemname', $itemname);
		$statement->bindValue(':subcategory', $subcategory);
		$statement->bindValue(':itemnb', $number);
		$statement->bindValue(':stock', $stock);
		$statement->bindValue(':description', $description);
		$statement->bindValue(':price', $price);
		$statement->bindValue(':image', $image);
		
		$statement->execute();
		$statement->closeCursor();	
	}
	function getCategories()
	{
		global $db;
		$query = 'SELECT * FROM categories';
		$statement = $db->prepare($query);
		$statement->execute();
		$categories = $statement->fetchAll();
		$statement->closeCursor();	
		
		return $categories;
	}
	function getSubcategories()
	{
		global $db;
		$query = 'SELECT * FROM subcategories';
		$statement = $db->prepare($query);
		$statement->execute();
		$subcategories = $statement->fetchAll();
		$statement->closeCursor();	
		
		return $subcategories;
	}
	
	function deleteItem($id)
	{
		global $db;
		$query = 'DELETE FROM items WHERE id = :id';
		$statement = $db->prepare($query);
		
		$statement->bindValue(':id', $id);
		$statement->execute();
		$statement->closeCursor();	
		
	}
	//----------------------------------------------
	function addToCart($accountid, $itemid,$amount)
	{     
		global $db;
		
		$query ='select * from cart WHERE itemid = :itemid AND accountid=:accountid';
		$statement = $db->prepare($query);
		$statement->bindValue(':accountid', $accountid);
		$statement->bindValue(':itemid', $itemid);
		$statement->execute();
		$s = $statement->fetchAll();
		$statement->closeCursor();	
		if($s){
			
			$query ='UPDATE cart SET amount = amount+ :amount 
						WHERE itemid = :itemid AND accountid = :accountid';
		
		$statement = $db->prepare($query);
		$statement->bindValue(':accountid', $accountid);
		$statement->bindValue(':itemid', $itemid);
		$statement->bindValue(':amount', $amount);
		$statement->execute();
		$statement->closeCursor();
		}
		else{
			$query = 'INSERT INTO cart (accountid, itemid, amount)
				  VALUES (:accountid, :itemid, :amount)';
		$statement = $db->prepare($query);
		$statement->bindValue(':accountid', $accountid);
		$statement->bindValue(':itemid', $itemid);
		$statement->bindValue(':amount', $amount);
		$statement->execute();
		$statement->closeCursor();
		}
		global $db;
		$query ='UPDATE items SET stock = stock - :amount
						WHERE id = :itemid';
		$statement = $db->prepare($query);
		$statement->bindValue(':itemid', $itemid);
		$statement->bindValue(':amount', $amount);
		$statement->execute();
		$statement->closeCursor();	
      
		
	}
	
	function getCart($id)
	{
		global $db;
		$query = 'SELECT c.*, a.* FROM cart c
					JOIN items a
					ON c.itemid = a.id
		WHERE c.accountid = :id';
		$statement = $db->prepare($query);
		$statement->bindValue(':id', $id);
		$statement->execute();
		$cart = $statement->fetchAll();
		$statement->closeCursor();
		return $cart;
	}
	function getCartNb($id)
	{
		global $db;
		$query = 'SELECT SUM(amount) from cart where accountid = :id';
		$statement = $db->prepare($query);
		$statement->bindValue(':id', $id);
		$statement->execute();
		$cart = $statement->fetch();
		$statement->closeCursor();
	    return $cart[0];
	}
	function getTotal($cart)
	{   $total=0;
		foreach ($cart as $item):
		    $total+=$item['price']*$item['amount'];
		endforeach;
		return $total;
	}	
	function editCart($accountid,$id,$amount){
		global $db;
	    $query ='UPDATE items SET stock = stock + :amount
						WHERE id = :itemid';
		$statement = $db->prepare($query);
		$statement->bindValue(':itemid', $id);
		$statement->bindValue(':amount', $amount);
		$statement->execute();
		$statement->closeCursor();	
		
		$query ='UPDATE cart SET amount=:amount
						 WHERE accountid = :accountid AND itemid = :id';
		
		$statement = $db->prepare($query);
		$statement->bindValue(':id', $id);
		$statement->bindValue(':amount', $amount);
		$statement->bindValue(':accountid', $accountid);
		$statement->execute();
		$statement->closeCursor();	
	}
		
	
	function deleteItemFromCart($id,$accountid)
	{   global $db;
	    $cart=getCart($accountid);
		foreach($cart as $items):
		    if($items['itemid']==$id){
				$amount=$items['amount'];
			   break;}
		endforeach;
	    $query ='UPDATE items SET stock = stock + :amount
						WHERE id = :itemid';
		$statement = $db->prepare($query);
		$statement->bindValue(':itemid', $id);
		$statement->bindValue(':amount', $amount);
		$statement->execute();
		$statement->closeCursor();	

		
		$query = 'DELETE FROM cart WHERE accountid = :accountid AND itemid = :id';
		$statement = $db->prepare($query);
		$statement->bindValue(':id', $id);
		$statement->bindValue(':accountid', $accountid);
		$statement->execute();
		$statement->closeCursor();	
	}
	function cancelCart($accountid)
	{   $cart=getCart($accountid);
		foreach($cart as $items):
		$amount=$items['amount'];
		$itemid=$items['itemid'];
		global $db;
		$query ='UPDATE items SET stock = stock + :amount
						WHERE id = :itemid';
		$statement = $db->prepare($query);
		$statement->bindValue(':itemid', $itemid);
		$statement->bindValue(':amount', $amount);
		$statement->execute();
		$statement->closeCursor();	
		endforeach;
		
		$query = 'DELETE FROM cart WHERE accountid = :accountid ';
		$statement = $db->prepare($query);
		$statement->bindValue(':accountid', $accountid);
		$statement->execute();
		$statement->closeCursor();	
	}
	function checkAmount($amount,$id){
		global $db;
		$queryUser = 'SELECT stock FROM items
					  WHERE id = :id' ;
		$statement1 = $db->prepare($queryUser);
		$statement1->bindValue(':id', $id);
		$statement1->execute();
		$data = $statement1->fetch();
		$statement1->closeCursor();
		if($data[0] >= $amount)
			return true; 
		else{
		    return false; }
		
	}
	
	function checkout($accountid){
		global $db;
		$query = 'DELETE FROM cart WHERE accountid = :accountid ';
		$statement = $db->prepare($query);
		$statement->bindValue(':accountid', $accountid);
		$statement->execute();
		$statement->closeCursor();	
	}
	
	//--------------------------------------------------
	function deleteReview($id)
	{
		global $db;
		$query = 'DELETE FROM reviews WHERE id=:id';
		$statement = $db->prepare($query);
		$statement->bindValue(':id', $id);
		$statement->execute();
		$statement->closeCursor();	
	}
	function addReview($accountid, $itemid, $review)
	{
		global $db;
		
		$query = 'INSERT INTO reviews (accountid, itemid, review)
				  VALUES (:accountid, :itemid, :review)';
		$statement = $db->prepare($query);
		$statement->bindValue(':accountid', $accountid);
		$statement->bindValue(':itemid', $itemid);
		$statement->bindValue(':review', $review);
		
		
		$statement->execute();
		
		
		$statement->closeCursor();	
		
	}
	function editReview($id,$review)
	{
		global $db;
		$query ='UPDATE reviews SET review=:review
						WHERE id = :id';
		
		$statement = $db->prepare($query);
		$statement->bindValue(':id', $id);
		$statement->bindValue(':review', $review);
		$statement->execute();
		$statement->closeCursor();	
	}
	function getReviews($itemid)
	{
		global $db;
		
		
		$query = 'SELECT c.*, a.username FROM reviews c
					JOIN accounts a
					ON c.accountid = a.id
		WHERE c.itemid = :itemid';
		$statement = $db->prepare($query);
		$statement->bindValue(':itemid', $itemid);
		$statement->execute();
		$reviews = $statement->fetchAll();
		$statement->closeCursor();	
		return $reviews;
		
	}
	function getTotalReviews($itemid)
	{
		global $db;
		
		
		$query = 'SELECT COUNT(review) from reviews WHERE itemid=:itemid';
		$statement = $db->prepare($query);		
		$statement->bindValue(':itemid', $itemid);

		$statement->execute();
		$reviews = $statement->fetch();
		$statement->closeCursor();	
		
		
		return $reviews[0];
		
	}
	//-------------------------------------------------
	function addRate($accountid, $itemid, $rate)
	{
		global $db;
		
		$query = 'INSERT INTO rate (accountid, itemid, rate)
				  VALUES (:accountid, :itemid, :rate)';
		$statement = $db->prepare($query);
		$statement->bindValue(':accountid', $accountid);
		$statement->bindValue(':itemid', $itemid);
		$statement->bindValue(':rate', $rate);
		$statement->execute();
		$statement->closeCursor();	
		
	}
	function getRate($itemid)
	{
		global $db;
		
		
		$query = 'SELECT AVG(rate) from rate WHERE itemid=:itemid';
		
		$statement = $db->prepare($query);
		$statement->bindValue(':itemid', $itemid);
		$statement->execute();
		$rate = $statement->fetch();
		$statement->closeCursor();	
		
		
		return $rate[0];
		
	}
	function getTotalRate($itemid)
	{
		global $db;
		
		
		$query = 'SELECT COUNT(rate) from rate WHERE itemid=:itemid';
		
		$statement = $db->prepare($query);$statement->bindValue(':itemid', $itemid);
		$statement->execute();
		$rate = $statement->fetch();
		$statement->closeCursor();	
		
		
		return $rate[0];
		
	}
	//------------------------------------
	
	function addAccount($username, $password, $email, $fname, $lname)
	{
		global $db; //Make $db accessible inside the function block
		$query = 'INSERT INTO accounts (username, password, email, fname, lname)
				  VALUES (:username,:password, :email, :fname, :lname )';
				  
		$statement = $db->prepare($query);
		
		
		$statement->bindValue(':username', $username);
		$statement->bindValue(':password', $password);
		$statement->bindValue(':email', $email);
		$statement->bindValue(':fname', $fname);
		$statement->bindValue(':lname', $lname);
		$statement->execute();
		$statement->closeCursor();
		
		$query = 'SELECT id FROM accounts WHERE username = :username';
		$statement = $db->prepare($query);
		$statement->bindValue(':username', $username);
		$statement->execute();
		$id = $statement->fetch();
		$statement->closeCursor();
	    return $id['id'];
		
	}
	function getAccount($id)
	{
		global $db;
		$query = 'SELECT * FROM accounts WHERE id = :id';
		$statement = $db->prepare($query);
		$statement->bindValue(':id', $id);
		$statement->execute();
		$account = $statement->fetch();
		$statement->closeCursor();	
		
		return $account;
		
	}
	function getAccounts($id)
	{
		global $db;
		$query = 'SELECT * FROM accounts WHERE id != :id';
		$statement = $db->prepare($query);
		$statement->bindValue(':id', $id);
		$statement->execute();
		$accounts = $statement->fetchAll();
		$statement->closeCursor();	
		
		return $accounts;
		
	}
	
	function changeToAdmin($id)
	{
		global $db;
		$query ='UPDATE accounts SET admin = 1
						WHERE id = :id';
		
		$statement = $db->prepare($query);
		$statement->bindValue(':id', $id);
		$statement->execute();
		$statement->closeCursor();	
	}
	function changeFromAdmin($id)
	{
		global $db;
		$query ='UPDATE accounts SET admin = 0
						WHERE id = :id';
		
		$statement = $db->prepare($query);
		$statement->bindValue(':id', $id);
		$statement->execute();
		$statement->closeCursor();	
	}
	
	function checkUsername($username)
	{
		global $db;
		$queryUser = 'SELECT id FROM accounts
					  WHERE username = :username' ;
		$statement1 = $db->prepare($queryUser);
		$statement1->bindValue(':username', $username);
		$statement1->execute();
		$userAccount = $statement1->fetch();
		$statement1->closeCursor();
		if($userAccount == NULL)
			return true; 
		else
			return false; 
	}
	
	function checkCategory($category)
	{
		global $db;
		$queryUser = 'SELECT id FROM categories
					  WHERE name = :category' ;
		$statement1 = $db->prepare($queryUser);
		$statement1->bindValue(':category', $category);
		$statement1->execute();
		$data = $statement1->fetch();
		$statement1->closeCursor();
		if($data == NULL)
			return true; 
		else
			return false; 
	}
	
	function checksubCategory($subcategory)
	{
		global $db;
		$queryUser = 'SELECT id FROM subcategories
					  WHERE name = :subcategory' ;
		$statement1 = $db->prepare($queryUser);
		$statement1->bindValue(':subcategory', $subcategory);
		$statement1->execute();
		$data = $statement1->fetch();
		$statement1->closeCursor();
		if($data == NULL)
			return true; 
		else
			return false; 
	}
	function processLogin($username, $password)
	{
		global $db;
		$queryUser = 'SELECT * FROM accounts
					  WHERE username = :username' ;
			$statement1 = $db->prepare($queryUser);
			$statement1->bindValue(':username', $username);
			$statement1->execute();
			$userAccount = $statement1->fetch();
			$statement1->closeCursor();
			
			if($userAccount != NULL)
			{
				if($password != $userAccount['password'])
					$userAccount = NULL;
			}
			return $userAccount;
			
	}
	function printstarts($password)
	{
		$s="";
		$v=strlen($password);
		for($i=0; $i < $v ;$i++){
			$s=$s."*";
	
		}
		return $s;
	}
	function checkAdmin($id)
	{
		global $db;
		$queryUser = 'SELECT admin FROM accounts
					  WHERE id = :id' ;
		$statement1 = $db->prepare($queryUser);
		$statement1->bindValue(':id', $id);
		$statement1->execute();
		$admin = $statement1->fetch();
		$statement1->closeCursor();
		if($admin['admin'] == 1)
			return true;
		else
			return false;
	}
	function deleteAccount($accountid)
	{
		global $db;
		$query = 'DELETE FROM reviews WHERE accountid = :accountid';
		$statement = $db->prepare($query);
		$statement->bindValue(':accountid', $accountid);
		$statement->execute();
		$statement->closeCursor();
		$query = 'DELETE FROM cart WHERE accountid = :accountid';
		$statement = $db->prepare($query);
		$statement->bindValue(':accountid', $accountid);
		$statement->execute();
		$statement->closeCursor();	
		$query = 'DELETE FROM rate WHERE accountid = :accountid';
		$statement = $db->prepare($query);
		$statement->bindValue(':accountid', $accountid);
		$statement->execute();
		$statement->closeCursor();	
		$query = 'DELETE FROM accounts WHERE id = :accountid';
		$statement = $db->prepare($query);
		$statement->bindValue(':accountid', $accountid);
		$statement->execute();
		$statement->closeCursor();	
	}
	function editAccount($id,$username,$password,$email,$fname,$lname)
	{
		global $db;
		$query ='UPDATE accounts SET username = :username, email = :email, 
		         password = :password, fname=:fname, lname=:lname
						WHERE id = :id';
		
		$statement = $db->prepare($query);
		$statement->bindValue(':id', $id);
		$statement->bindValue(':username', $username);
		$statement->bindValue(':email', $email);
		$statement->bindValue(':password', $password);
		$statement->bindValue(':fname', $fname);
		$statement->bindValue(':lname', $lname);
		$statement->execute();
		$statement->closeCursor();	
	}
?>