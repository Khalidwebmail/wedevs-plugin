<div class="contact-form">

    <div class="message"></div>

    <form action="" method="post" id="contact-form">

        <div class="form-group">
            <label for="name"><?php _e( 'Name', 'contact-form' ); ?></label>
            <input type="text" id="name" class="form-control" name="name" >
        </div>

        <div class="form-group">
            <label for="email"><?php _e( 'E-Mail', 'contact-form' ); ?></label>
            <input type="email" id="email" class="form-control" name="email" >
        </div>

        <div class="form-group">
            <label for="message"><?php _e( 'Message', 'contact-form' ); ?></label>
            <textarea name="message" id="message" ></textarea>
        </div>

        <div class="form-group">
            <?php wp_nonce_field( 'contact-form' ); ?>

            <input type="hidden" name="action" value="contact_form">
            <input type="submit" class="btn-submit" name="send_message" value="<?php esc_attr_e( 'Send Message', 'contact-form' ); ?>">
        </div>

    </form>

</div>