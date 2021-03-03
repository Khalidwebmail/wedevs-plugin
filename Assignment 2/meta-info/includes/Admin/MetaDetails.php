<?php

namespace Meta\Info\Admin;

class MetaDetails {

    public function __construct() {
        add_action( 'wp_head', [ $this, 'update_meta_detalis' ] );
    }

    public function update_meta_detalis() 
    {
        $meta_details = apply_filters( 'md_update_meta',  'lorem imsun dolorem');
    ?>
        <meta name='description' content='<?php echo $meta_details ?>'>
<?php
    }
}