<div class="wrap">
    <h1 class="wp-heading-inline"><?php _e('Edit Menu Text', 'vertical-menu') ?></h1>

    <form action="" method="post">
        <table class="form-table">
            <tr>
                <th scope="row">
                    <label for="menu_txt"><?php _e( 'Name', 'vertical-menu' )?></label>
                </th>
                <td>
                    <input type="text" name="menu_txt" id="menu_txt" class="regular-text" value="">
                </td>
            </tr>
        </table>
        <?php wp_nonce_field( 'menu-text' ) ?>
        <?php submit_button( __( 'Update Menu Text', 'vertical-menu'), 'primary', 'update_menu_txt' ) ?>
    </form>
</div>