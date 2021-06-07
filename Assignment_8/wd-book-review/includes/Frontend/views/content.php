<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="entry-header alignwide">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
		<?php twenty_twenty_one_post_thumbnail(); ?>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php
		the_content();

		wp_link_pages(
			array(
				'before'   => '<nav class="page-links" aria-label="' . esc_attr__( 'Page', 'twentytwentyone' ) . '">',
				'after'    => '</nav>',
				/* translators: %: Page number. */
				'pagelink' => esc_html__( 'Page %', 'twentytwentyone' ),
			)
		);
		?>
	</div><!-- .entry-content -->

	<?php if ( is_single() ) : ?>
	<div class="entry-content">
		<p><?php _e( 'Writter', 'wd-book-review' ) ?> <?php esc_html_e( $writter ) ?></p>
		<p><?php _e( 'Publisher', 'wd-book-review' ) ?> <?php esc_html_e( $publisher ) ?></p>
		<p><?php _e( 'Language', 'wd-book-review' ) ?> <?php esc_html_e( $language ) ?></p>
		<p><?php _e( 'ISBN', 'wd-book-review' ) ?> <?php  esc_html_e( $isbn ) ?></p>
		<div>
			<?php endif; ?>

			<div class="entry-content">
				<input type="hidden" id="post-id" value="<?php esc_attr_e( $post_id ) ?>"/>

				<div class="rating">
					<i class="<?php echo wd_rating_star_class( wd_get_avg_rating( get_the_ID() ), 1 ) ?>" data-rate="1"></i>
					<i class="<?php echo wd_rating_star_class( wd_get_avg_rating( get_the_ID() ), 2 ) ?>" data-rate="2"></i>
					<i class="<?php echo wd_rating_star_class( wd_get_avg_rating( get_the_ID() ), 3 ) ?>" data-rate="3"></i>
					<i class="<?php echo wd_rating_star_class( wd_get_avg_rating( get_the_ID() ), 4 ) ?>" data-rate="4"></i>
					<i class="<?php echo wd_rating_star_class( wd_get_avg_rating( get_the_ID() ), 5 ) ?>" data-rate="5"></i>
					<div class="message"></div>
				</div>
			</div>

			<footer class="entry-footer default-max-width">
				<?php twenty_twenty_one_entry_meta_footer(); ?>
			</footer><!-- .entry-footer -->

			<?php if ( ! is_singular( 'attachment' ) ) : ?>
				<?php get_template_part( 'template-parts/post/author-bio' ); ?>
			<?php endif; ?>

</article>
<?php
