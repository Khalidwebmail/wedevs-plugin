<?php

namespace WeDevs\Academy\Frontend;

class Shortcode 
{
    /**
     * class initialization
     */
    public function __construct()
    {
        add_shortcode('wedevs-academy', [$this, 'render_shortcode']);
    }
    
    /**
     * shortcode header class
     *
     * @param  array $atts
     * @param  string $content
     * @return string
     */
    public function render_shortcode($atts, $content = '')
    {
        return "Hello from shortcode";
    }
}