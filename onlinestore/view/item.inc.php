<main>
<table style="text-align:left">
		<tr>
		<tr><th colspan="3"><p><?php echo "model number :".$item['itemnb'] ;?></p> </th></tr>
		<th rowspan="10"><img src="<?php echo $item['image'];?>" height="450px" width="400px">
		</th>
		<tr><th colspan="3"  valign="top"  style="font-family: Times new roman"><h1>
		<?php echo $item['itemname']; ?></h1><hr></th></tr>
		<tr><th colspan="5"><p style="font-family: Times new roman"><?php 
		$s=getsubCategory($item['subcategory']);
		echo "from ".$s['name'];?></p> </th></tr>
		<tr><th colspan="5">
		<?php if($item['stock']==0){ echo "<h4>this item is temporarily out of stock, it'll be available soon!</h5>";}
		elseif ($item['stock']<6){ echo "<h5>only ".$item['stock']."  peices left</h5>";}
		else{
			echo"<h5>in stock</h5>";
		}
		?>
	</th></tr>
	
		<tr><th colspan="5"><h1><?php echo $item['price']. "$";?></h1></th></tr>
		
		<tr><th colspan="5"><hr><?php echo "<h5>about this item: </h5>"."<hp>".$item['description'];?></p></th></tr>
	<?php if($item['stock']!=0){?>	<tr><th colspan="5">
		<?php if($loggedin){
		?>
		<form action="store.php" method="post">
		        <?php echo $error ?>
                <input type="hidden" name="id" value="<?php echo $item['id'] ?>"><br><br>
				<input type="text" name="amount" value="1" size="5">
                <button type="submit" name = "action" value="add to cart" class="btn btn-outline-success my-2 my-sm-0"><i class="fa fa-shopping-cart"></i> add to cart</button>
        </form>
		</th></tr><?php } 
	
	 else{?>
		 <h4><a href="store.php?action=signin"  style="color:black;"><i class="fa fa-sign-in"> please sign in to shop in online shop </i></h4>
		
	<?php }}?></table>

</main>