<?php

namespace Post;

class Admin {

    public function __construct() {
        $callback = new \Post\Admin\WdCallback();
        new \Post\Admin\WdSettings();
        new \Post\Admin\WdRegister( $callback );
    }
}