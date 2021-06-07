<div>
	<form id="myForm" name="myForm" action="" method="post">
		<fieldset>
			<div>
				<div>
					<label><?php _e( 'User Name', 'user-roles-and-capabilities' ) ?></label>
					<input type="text" name="uname" class="regular-text" value="" placeholder="<?php esc_html_e( 'Enter your username', 'user-roles-and-capabilities' ) ?>" required  >
				</div>
				<br>
				<div>
					<label><?php _e( 'Email Address', 'user-roles-and-capabilities' ) ?></label>
					<input type="email" name="email" class="regular-text" value="" placeholder="<?php esc_html_e( 'Enter email address', 'user-roles-and-capabilities' ) ?>" required >
				</div>
				<br>
				<div>
					<label><?php _e( 'Password', 'user-roles-and-capabilities' ) ?></label>
					<input type="password" name="password" class="regular-text" value="" placeholder="<?php esc_html_e( 'Enter your password', 'user-roles-and-capabilities' ) ?>" required >
				</div>
				<br>
				<div>
					<label for=""><?php echo esc_html_e( 'Capability', 'user-roles-and-capabilities' ); ?></label>
					<select name="capability" class="regular-text" required>
						<option value="" ><?php esc_html_e('Select customer', 'user-roles-and-capabilities') ?></option>
						<option value="wholesale" ><?php esc_html_e( 'Wholesale customer', 'user-roles-and-capabilities' ) ?></option>
						<option value="retail" ><?php esc_html_e( 'Retail customer', 'user-roles-and-capabilities' ) ?></option>
						<option value="regular" ><?php esc_html_e( 'Regular customer', 'user-roles-and-capabilities' ) ?></option>
					</select>
				</div>
				<br>
				<div>
					<?php wp_nonce_field( 'urc_nonce_from' ) ?>
					<br>
					<input type="submit" name="send_shortcode" value="<?php esc_html_e( 'Save', 'user-roles-and-capabilities' ) ?>">
				</div>
			</div>
		</fieldset>
	</form>
</div>
