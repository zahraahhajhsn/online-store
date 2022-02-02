<main>
<?php if(!empty($items)){?>
<h3> <form action="store.php" method="post"> Cart:
<button type="submit" name = "action" value="emptycart" class="btn btn-outline-success my-2 my-sm-0"><i class="fa fa-shopping-cart"></i> Empty cart </button></form></h3>
<?php
	foreach($items as $item):?>
<table style="text-align:left">
		<tr>
		<th rowspan="7"><img src="<?php echo $item['image'];?>" height="100px" width="100px">
		</th>
	    <th colspan="5"><h4><?php echo $item['itemname'] . "  ";?>
		<a href="store.php?action=removeitem&amount=<?php echo $item['amount'];?>&id=<?php echo $item['itemid'];?>"
		style=" color:black"><i class="fa fa-times"></i></a></h4> </th></tr>
		<tr><th colspan="5"><p><?php echo $item['itemnb']?></p></th></tr>
		<tr><th colspan="5"><h5><?php echo $item['price']."$ x ".$item['amount'] ." " ;?>
		<a style="color:black" href="#" onclick="view()"><i class="fa fa-edit" ></i></a></th><th>
		<form action="store.php" method="post" id="form" style="display:none">
		        <?php echo $error ?>
                <input type="hidden" name="id" value="<?php echo $item['id'] ?>">
				<input type="text" name="amount" value="<?php echo$item['amount']?>" size="5">
                <button type="submit" name = "action" value="verify" class="btn btn-outline-success my-2 my-sm-0"><i class="fa fa-check"></i></button>
        </form>
		</h5></th></tr>
		</table>
		<hr>
		<?php 
    endforeach;?>
	
		
		<h4 style="text-align:center">total= <?php echo $total ."$";?></h4>
		<form action="store.php" method="post" style="text-align:center">
		<input type="submit" name = "action" value="checkout" class="btn btn-outline-success my-2 my-sm-0"><br>
		
        </form>
	<?php
	}
else {?>
	 <h4 style="text-align:center">cart is empty.</h4>;<?php
	}
	?>	
</main>
<script type="text/javascript">
	function view(){
			document.getElementById("form").style.display="block";
	}
	</script>