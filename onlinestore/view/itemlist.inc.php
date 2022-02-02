
	<main>
	<p > <?php echo $s ?></p>
	<?php 
	if($items){ 
	$c=0;?>
		<table style="text-align:center ">
		<tr>
		<?php foreach($items as $item):
			
			if($c % 5 !=0){
				?>
			<th><img src="<?php echo $item['image'];?>" height="230" width="230">
		    <br><a href="store.php?action=showitem&id=<?php echo $item['id']?>" 
			style="color:black"><?php echo $item['itemname'];?><br>
			<?php $rate=getRate($item['id']);if($rate!=0){ echo $rate; ?> </b> <i class="fa fa-star" style="font-size:20px;color:#ff9f00;"></i><?php }
			else{ echo "no rates yet"; ?> </b> <i class="fa fa-star" style="font-size:20px;color:#ff9f00;"></i><?php }?><br>
			<?php if($item['stock']==0){ echo "out of stock!";}
		     elseif ($item['stock']<6){ echo "only ".$item['stock']."  peices left " .$item['price']."$";}
		    else{
			echo $item['price']."$" ;
		    }
		?></a>
			</th>
			
			<?php }
			else{?>
			</tr>
			<tr>
			<th><img src="<?php echo $item['image'];?>" height="230" width="230">
		    <br><a href="store.php?action=showitem&id=<?php echo $item['id']?>" style="color:black"><?php echo $item['itemname']?><br>
			<?php $rate=getRate($item['id']);if($rate!=0){ echo $rate; ?> </b> <i class="fa fa-star" style="font-size:20px;color:#ff9f00;"></i><?php }
			else{ echo "no rates yet"; ?> </b> <i class="fa fa-star" style="font-size:20px;color:#ff9f00;"></i><?php }?><br>
			<?php if($item['stock']==0){ echo "out of stock!";}
		     elseif ($item['stock']<6){ echo "only ".$item['stock']."  peices left " .$item['price']."$";}
		    else{
			echo $item['price']."$" ;
		    }
		?></a>
		<?php
		}$c++;
		endforeach;
	}
		?>
		</tr>
		</table>
	
	
	</main>





