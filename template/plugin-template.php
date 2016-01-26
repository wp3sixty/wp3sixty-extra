<?php
/**
 * User: spock
 * Date: 26/1/16
 * Time: 1:07 PM
 */
?>
<?php while ( have_posts() ) : the_post(); ?>
	<article <?php post_class(); ?>>
		<?php if ( get_post_type() === 'post' ) { ?>
			<div class="entry-author">
				<?php get_template_part( 'templates/entry-author' ); ?>
			</div>
		<?php } ?>
		<?php if ( has_post_thumbnail() ) { ?>
			<div class="post-feature-image wp3sixty-plugin-post-feature-image"><?php the_post_thumbnail( 'full' ); ?>
				<div class="wp3sixty-work-link">
					<?php
					$github_link = get_post_meta( get_the_ID(), 'github', true );
					$w_link      = get_post_meta( get_the_ID(), 'wordpress', true );
					if ( ! empty( $github_link ) ) {
						?><a class="wp3sixty-github" href="<?php echo $github_link; ?>"></a><?php
					}
					if ( ! empty( $w_link ) ) {
						?><a class="dashicons dashicons-wordpress-alt wp3sixty-wordpress" href="<?php echo $w_link; ?>"></a><?php
					}
					?>
				</div>
			</div>
			<?php
		} ?>
		<header>
			<h1 class="entry-title"><?php the_title(); ?></h1>
		</header>
		<div class="entry-content">
			<?php the_content(); ?>
		</div>
		<footer>
			<?php wp_link_pages( [
				'before' => '<nav class="page-nav"><p>' . __( 'Pages:', 'devanagari' ),
				'after'  => '</p></nav>',
			] ); ?>
		</footer>
		<div class="tag-container">
			<?php the_tags( '', '' ); ?>
		</div>
		<?php comments_template( '/templates/comments.php' ); ?>
	</article>
<?php endwhile; ?>
