<div class="wrap">
    <h2><?php _e( 'Add New Address', 'wedevs-crud' ) ?></h2>
    <form action="" method="post">
        <?php wp_nonce_field( 'new-address' ) ?>
        <table class="form-table">
            <tbody>
                <tr class="row<?php echo $this->has_error( 'name' ) ? ' form-invalid' : '' ;?>">
                    <th scope="row">
                        <label for="name"><?php _e( 'Full Name', 'wedevs-crud' ) ?></label>
                    </th>
                    <td>
                        <input type="text" name="name" id="name" class="regular-text" value="">
                        <?php if( $this->has_error( 'name' ) ): ?>
                            <p class="description error"><?php echo $this->get_error( 'name' ) ?></p>
                        <?php endif; ?>
                    </td>
                </tr>

                <tr class="row<?php echo $this->has_error( 'email' ) ? ' form-invalid' : '' ;?>">
                    <th scope="row">
                        <label for="email"><?php _e( 'Email Address', 'wedevs-crud' ) ?></label>
                    </th>
                    <td>
                        <input type="email" name="email" id="email" class="regular-text" value="">
                        <?php if( $this->has_error( 'email' ) ): ?>
                            <p class="description error"><?php echo $this->get_error( 'email' ) ?></p>
                        <?php endif; ?>
                    </td>
                </tr>

                <tr class="row<?php echo $this->has_error( 'phone' ) ? ' form-invalid' : '' ;?>">
                    <th scope="row">
                        <label for="phone"><?php _e( 'Cell Number', 'wedevs-crud' ) ?></label>
                    </th>
                    <td>
                        <input type="text" name="phone" id="phone" class="regular-text" value="">
                        <?php if( $this->has_error( 'phone' ) ): ?>
                            <p class="description error"><?php echo $this->get_error( 'phone' ) ?></p>
                        <?php endif; ?>
                    </td>
                </tr>

                <tr class="row<?php echo $this->has_error( 'address' ) ? ' form-invalid' : '' ;?>">
                    <th scope="row">
                        <label for="name"><?php _e( 'Address', 'wedevs-crud' ) ?></label>
                    </th>
                    <td>
                        <textarea name="address" id="address" class="regular-text" cols="55" rows="10"></textarea>
                        <?php if( $this->has_error( 'address' ) ): ?>
                            <p class="description error"><?php echo $this->get_error( 'address' ) ?></p>
                        <?php endif; ?>
                    </td>
                </tr>
            </tbody>
        </table>
        <input type="submit" name="submit_address" value="<?php _e( 'Save Address' )?>" class="button button-primary button-large">
    </form>
</div>