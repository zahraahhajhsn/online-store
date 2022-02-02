<main>
<div style="text-align:center">
<form action="store.php" method="post" enctype="multipart/form-data"> <hr> <h5>Edit item <?php echo $number;?></h5>
		<?php echo $error;?>
                <label>Item name:</label><br>
                <input type="text" name="itemname" value="<?php echo $itemname;?>"><br>
				<label>Price:</label><br>
				<input type="text" name="price" value="<?php echo $price;?>"><br>
				<label>stock:</label><br>
				<input type="text" name="stock" value="<?php echo $stock;?>"><br>
				<label>subcategory:</label><br>
				<input type="hidden" name="id" value="<?php echo $id;?>">
				<input type="hidden" name="number" value="<?php echo $number;?>">
				<select name="subcategoryitem" value="<?php echo $subcategory;?>"><br>
				<?php foreach ($subs as $sub):?>
				<option value= "<?php echo $sub['id']?>"><?php echo $sub['name'] ?></option>
				<?php endforeach?>
				</select>
				<br><br>
				<label>please choose an image:</label><br>
				<input type="file" name="image" accept="image/*" class="btn btn-outline-success my-2 my-sm-0"><br>
				<label>description:</label><br>
				<textarea name="description"><?php echo $description;?></textarea><br><br>
                <input type="submit" name = "action" value="confirm" class="btn btn-outline-success my-2 my-sm-0"><br>
    </form>
		</div>
</main>