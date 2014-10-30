
<?php foreach($products as $product) : ?>
	<div class="col-md-4 game">
		<div class="game-price">$<?php echo $product->price; ?></div>
		<a href="<?php echo base_url(); ?>products/details/<?php echo $product->id; ?>">
			<img src="<?php echo base_url(); ?>assets/images/products/<?php echo $product->image; ?>" />
		</a>
		<div class="game-title"><?php echo $product->title; ?></div>
		<div class="game-add">
			<button class="btn btn-primary" type="submit">Add To Cart</button>
		</div>
	</div>

<?php endforeach; ?>

