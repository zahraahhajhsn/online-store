<main>
<br>
<div style="text-align:center">
<form method="post" action="store.php" >
<input type="text" name="searchn" placeholder="search of a specific item by number" size="30">

<button type="submit" name="action" value="searchi" class="btn btn-outline-success my-2 my-sm-0" ><i class="fa fa-search"></i></button>

</form><br>
<p><?php if($item!=""){
  if($item=="item of the interened number does not exist"){
	?><p><?php echo $item;?><a href="store.php?action=dismiss3" style=" color:red"><i class="fa fa-times" ></a></i></p>
<?php }
 else if($item=="this field can't be empty"){
	?><p><?php echo $item;?><a href="store.php?action=dismiss3" style=" color:red"><i class="fa fa-times" ></a></i></p>
<?php }
else{?>
	<table style="text-align:left">
		<tr>
		<th rowspan="7"><img src="<?php echo $item['image'];?>" height="200px" width="200px">
		</th>
	    <th colspan="5"><h4><?php echo $item['itemnb'] ;?><a href="store.php?action=itemi&id=<?php echo $item['id'];?>" style=" color:black"><i class="fa fa-edit"></i></a><a href="store.php?action=itemrem&id=<?php echo $item['id'];?>" style=" color:black"><i class="fa fa-remove"></i></a></h4> </th></tr>
		<tr><th colspan="5"><h5><?php echo $item['itemname'];?></h5></th></tr>
		<tr><th colspan="5"><h5><?php echo $item['stock']." peices left"?></h5></th></tr>
		<tr><th colspan="5"><h5><?php echo $item['price']. "$";?></h5></th></tr>
		<tr><th colspan="5"><h5><?php 
		$s=getsubCategory($item['subcategory']);
		echo $s['name'];?></h5> </th></tr>
		<tr><tr><tr><th colspan="5"><h5><?php echo $item['description'];?></h5></th></tr></table>
<?php }}?>
<p><?php echo $data;
            if($data!=""){?>
<a href="store.php?action=dismiss2" style=" color:red"><i class="fa fa-times" ></a></i>	
			<?php }?></p>
<div id="additem"><button class="btn btn-outline-success my-2 my-sm-0" ><i class="fas fa-plus" onclick="add(0)" > Add item</i></button><br><br></div>
<div id="item" style="display:none">
		<form action="store.php" method="post" enctype="multipart/form-data"> <hr> <h5>Add item:</h5>
		<?php echo $error;?>
                <label>Item name:</label><br>
                <input type="text" name="itemname"><br>
				<label>Price:</label><br>
				<input type="text" name="price"><br>
				<label>stock:</label><br>
				<input type="text" name="stock"><br>
				<label>subcategory:</label><br>
				<select name="subcategoryitem"><br>
				<option value="null">please select subcategory</option>
				<?php foreach ($subs as $sub):?>
				<option value= "<?php echo $sub['id']?>"><?php echo $sub['name'] ?></option>
				<?php endforeach?>
				</select>
				<br><br>
				<label>please choose an image:(can be kept empty if image not available)</label><br>
				<input type="file" name="image" accept="image/*" value="images/null.jpg" class="btn btn-outline-success my-2 my-sm-0"><br>
				<label>description:</label><br>
				<textarea name="description"></textarea><br><br>
                <input type="submit" name = "action" value="add item" class="btn btn-outline-success my-2 my-sm-0"><br>
     <hr></form>
		</div>
<div id="addcategory"><button class="btn btn-outline-success my-2 my-sm-0"><i class="fas fa-plus" onclick="add(1)" > Add category</i></button><br><br></div>
<div id="category" style="display:none">
		<form action="store.php" method="post"> <hr> <h5>Add category:</h5>
		<?php echo $error;?>
                <label>category:</label><br>
				<input type="text" name="category"><br>
				<br><br>
                <input type="submit" name = "action" value="add category" class="btn btn-outline-success my-2 my-sm-0"><br><br>
     <hr></form>
		</div>
<div id="addsub"><button class="btn btn-outline-success my-2 my-sm-0"><i class="fas fa-plus" onclick="add(2)" > Add subcategory</i></button><br></div>
<div id="subcategory" style="display:none">
		<form action="store.php" method="post"> <hr> <h5>Add Subcategory:</h5>
		<?php echo $error;?>
                <label>subcategory:</label><br>
				<input type="text" name="subcategory"><br>
				<label>subcategory:</label><br>
				<select name="categoryitem"><br>
				<option value="null">please select category</option>
				<?php foreach ($cats as $cat):?>
				<option value= "<?php echo $cat['id']?>"><?php echo $cat['name'] ?></option>
				<?php endforeach?>
				</select>
				<br><br>
                <input type="submit" name = "action" value="add subcategory" class="btn btn-outline-success my-2 my-sm-0"><br>
     <hr></form>
		</div>
</div>
</main>
<script type="text/javascript">
	   function add(val){
		if(val ==0 ){
			document.getElementById("item").style.display="block";
			document.getElementById("category").style.display="none";
			document.getElementById("subcategory").style.display="none";
			document.getElementById("additem").style.display="none";
			document.getElementById("addcategory").style.display="block";
			document.getElementById("addsub").style.display="block";
		}
		else if (val== 1){
			document.getElementById("addsub").style.display="block";
			document.getElementById("item").style.display="none";
			document.getElementById("category").style.display="block";
			document.getElementById("addcategory").style.display="none";
			document.getElementById("subcategory").style.display="none";
			document.getElementById("additem").style.display="block";
		}
		else if (val== 2){
			document.getElementById("addcategory").style.display="block";
			document.getElementById("additem").style.display="block";
			document.getElementById("addsub").style.display="none";
			document.getElementById("subcategory").style.display="block";
			document.getElementById("category").style.display="none";
			document.getElementById("item").style.display="none";
		}
	}
	</script>