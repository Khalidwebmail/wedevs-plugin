<form action="" method="post">
    <?php
    $table = new WeRestApi\We_Contact_List();
    $table->prepare_items();
    $table->search_box( 'search', 'search_id' );
    $table->display();
    ?>
</form>