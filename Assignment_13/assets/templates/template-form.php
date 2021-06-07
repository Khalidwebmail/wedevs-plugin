<div class="wcf_container" id="wcf_container">

    <?php $contact_us_title = apply_filters( 'wcfn_contact_title', 'Contact Us' ); ?>
    
    <h1 class="wcf_heading"><?php echo esc_html__( $contact_us_title, $contact_us_title ); ?></h1>
    <form class="wcf_form" id="wcf_form">
        <?php do_shortcode( $content ); ?>
    </form>
    <div id="wcfn_error_messagebox"></div>
</div>