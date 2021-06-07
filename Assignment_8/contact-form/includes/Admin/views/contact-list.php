<div class="wrap">
    
    <h1 class="wp-heading-inline"><?php _e('Contact Messages', 'contact-form') ?></h1>

    <form action="" method="post">
        <?php
            $table = new Contact\Form\Admin\Contact_List();
            $table->prepare_items();
            $table->search_box('search', 'search_id');
            $table->display();
        ?>
    </form>

</div>