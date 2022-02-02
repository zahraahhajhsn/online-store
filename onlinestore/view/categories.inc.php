<main><div class="navbar navbar-expand-md navbar-dark bg-dark mb-4" role="navigation">
	 <a  href="#" class="navbar-brand"><i class="fas fa-filter"> filter:</i></a>
	 <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
     </button>
	 <div class="collapse navbar-collapse" id="navbarCollapse">
	 <ul class="navbar-nav mr-auto">
	  <?php foreach($categories as $category): ?>
	    <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="dropdown1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo " ".$category['name'] ." "; ?></a>
				<ul class="dropdown-menu" aria-labelledby="dropdown1">
		 <?php foreach($subcategories as $subcategory):
		 if($subcategory['category'] == $category['id']){?>
		    <li ><a class="dropdown-item" href="store.php?action=sub&id1=<?php echo $subcategory['id']?>&id2=<?php echo $subcategory['category']?>"><?php echo $subcategory['name'] ?></a></li>
		 <?php }
		 endforeach; ?>
		 </ul>
		 </li>
	 <?php endforeach; ?>
	</ul>
	</div>
	</div>
	</main>
