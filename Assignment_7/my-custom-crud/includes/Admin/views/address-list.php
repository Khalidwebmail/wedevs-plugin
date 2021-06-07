<div class="wrap">
	<h1 class='wp-heading-inline'><?php _e( 'Address book', 'wedevs-crud' ) ?></h1>
	<a href="<?php echo admin_url( 'admin.php?page=wedevs-crud&action=new' ) ?>" class="page-title-action"><?php _e( 'Add New', 'wedevs-crud' ) ?></a>

	<form action="">
		<?php
		$table = new \My\Crud\Admin\Address_List();
		$table->prepare_items();
		$table->display();
		?>
	</form>
</div>