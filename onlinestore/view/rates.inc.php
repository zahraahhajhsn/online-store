<main>
<div style="text-align:center">
<h3><b>Rating & Reviews</b></h3>
			<h3 align="center"><b><?php if($rate!=0){ echo $rate;?></b> <i class="fa fa-star" style="font-size:20px;color:#ff9f00;"></i></h3><br>
			<p><?php echo getTotalRate($id) ?> ratings and <?php } echo getTotalReviews($id)?> reviews</p>
</div><br>
<?php if($loggedin) { ?>
	<form action = "store.php" method="POST"  style="text-align:center">Add a rate 
	<div id="rating_div">
				<div class="star-rating" style="font-size:20px;color:#ff9f00;" >
					<span class="fa fa-star"   data-rating="1" style="font-size:20px;" onmouseover="change(1)"></span>
					<span class="fa fa-star-o" data-rating="2" style="font-size:20px;" onmouseover="change(2)" id="2"></span>
					<span class="fa fa-star-o" data-rating="3" style="font-size:20px;" onmouseover="change(3)" id="3"></span>
					<span class="fa fa-star-o" data-rating="4" style="font-size:20px;" onmouseover="change(4)" id="4"></span>
					<span class="fa fa-star-o" data-rating="5" style="font-size:20px;" onmouseover="change(5)" id="5"></span>
					<input type="hidden" name="rating" class="rating-value" value="1" id="input">
				</div>
	</div>
	 User: <?php echo $userDisplay ?><br>
	 <?php echo $error ?>
	<label>Write a review:</label><br>
	<textarea name="review"></textarea><br>
	<input type = "hidden" name="id" value="<?php echo $id; ?>">
	<input type="submit" name = "action" value="submit review"size="40" >
	</form>
	<?php } ?>
	<hr>
<h2> reviews:</h2>
<hr>
	<?php
		foreach($reviews as $review): ?>
		<p><?php echo "<h5>". $review['username'] ."</h5> on " . $review['date']?></p>
		<p><?php echo $review['review']; ?>
		 <?php if($loggedin){ if($accountid==$review['accountid']) { ?>
		<a href="store.php?action=deletereview&idr=<?php echo $review['id']?>&id=<?php echo $review['itemid']?>" style=" color:black"><i class="fa fa-times" > </a></i>
		 <a href="#" style=" color:black" onclick="pro()"><i class="fa fa-edit"></i></a>
		<form action="store.php" method="post" id="form" style="display:none">
		        <?php echo $error ?>
                <input type="hidden" name="idr" value="<?php echo $review['id'] ?>">
				<input type="hidden" name="id" value="<?php echo $review['itemid'] ?>">
				<textarea name="review"></textarea><br>
                <button type="submit" name = "action" value="editreview" class="btn btn-outline-success my-2 my-sm-0"><i class="fa fa-check"></i></button>
        </form><?php }}?>
		</p>
		<?php
		endforeach;
		?>

	


</main>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="js/index.js"></script>
<script type="text/javascript">
	function pro(){
			document.getElementById("form").style.display="block";
	}
	function change(val){
		if(val==1){
			document.getElementById("2").className="fa fa-star-o";
			document.getElementById("3").className="fa fa-star-o";
			document.getElementById("4").className="fa fa-star-o";
			document.getElementById("5").className="fa fa-star-o";
			
		
		}
		else if(val==2){
			document.getElementById("2").className="fa fa-star";
			document.getElementById("3").className="fa fa-star-o";
			document.getElementById("4").className="fa fa-star-o";
			document.getElementById("5").className="fa fa-star-o";
			document.getElementById("input").value="2";
		
		}
		else if(val==3){
			document.getElementById("2").className="fa fa-star";
			document.getElementById("3").className="fa fa-star";
			document.getElementById("4").className="fa fa-star-o";
			document.getElementById("5").className="fa fa-star-o";
			document.getElementById("input").value="3";
			
		}
		else if(val==4){
			document.getElementById("2").className="fa fa-star";
			document.getElementById("3").className="fa fa-star";
			document.getElementById("4").className="fa fa-star";
			document.getElementById("5").className="fa fa-star-o";
			document.getElementById("input").value="4";
		}
		else{
			document.getElementById("2").className="fa fa-star";
			document.getElementById("3").className="fa fa-star";
			document.getElementById("4").className="fa fa-star";
			document.getElementById("5").className="fa fa-star";
			document.getElementById("input").value="5";
			
		}
	}
	
	</script>