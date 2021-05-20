<div class="wrap">
    <form action="" method="get">
        <input type="text" name="keyword" id="keyword" placeholder="<?php esc_attr_e( 'Job keyword such php python', 'my-github-job' )?>">

        <input type="text" name="location" id="location" placeholder="<?php esc_attr_e( 'Job location', 'my-github-job' )?>">

        <?php 
            $full_time_job = isset( $_GET[ 'full_time_job' ] ) ? $_GET[ 'full_time_job' ] : '';
        ?>
        <input type="checkbox" name="full_time" id="full_time" value="on" <?php checked( $full_time_job, 'on' ) ?>>

        <label for="full_time_job"><?php esc_attr_e( 'Full time only', 'my-github-job' ) ?></label>

        <input type="submit" name="search_job" value="<?php esc_attr_e( 'Search', 'my-github-job' ) ?>">
    </form>
</div>