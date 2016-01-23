<?php
/**
 * Created by PhpStorm.
 * User: spock
 * Date: 24/1/16
 * Time: 1:21 AM
 */

if ( ! class_exists( 'WP_3sixty_Carousel' ) ) {
	class WP_3sixty_Carousel {

		/**
		 * WP_3sixty_Carousel constructor.
		 */
		public function __construct() {
			add_action( '3sixty_do_carousel', array( $this, '_3sixty_do_carousel' ) );
		}

		function _3sixty_do_carousel() {
			$feature_posts = new WP_Query( array(
				'post_type'      => array( 'plugin', 'theme' ),
				'posts_per_page' => '10',
				'cache_results'  => true,
			) );
			$feature_posts = $feature_posts->posts;
			$flag          = true;
			?>
			<div id="myCarousel" class="carousel slide" data-ride="carousel">
				<!-- Indicators -->
				<ol class="carousel-indicators">
					<?php
					for ( $i = 0; $i < count( $feature_posts ); $i ++ ) {
						echo '<li data-target="#myCarousel" data-slide-to="' . $i . '" ' . ( ( $flag ) ? 'class="active"' : '' ) . '></li>';
						if ( $flag ) {
							$flag = false;
						}
					}
					$flag = true;
					?>
				</ol>

				<!-- Wrapper for slides -->
				<div class="carousel-inner" role="listbox">
					<?php
					foreach ( $feature_posts as $_post ) { ?>
						<div class="item <?php echo ( $flag ) ? 'active' : ''; ?>">
							<?php
							echo get_the_post_thumbnail( $_post->ID ); ?>
							<div class="carousel-extra">
								<div class="carousel-header">
									<h1><?php echo get_the_title( $_post->ID ); ?></h1>
								</div>
								<div class="carousel-extra-text">
									<?php echo get_the_excerpt( $_post->ID ); ?>
								</div>
								<a class="button" href="<?php echo get_permalink( $_post->ID ); ?>">More</a>
							</div>
						</div>
						<?php
						if ( $flag ) {
							$flag = false;
						}
					}
					?>
				</div>

				<!-- Left and right controls -->
				<a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
					<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
					<span class="sr-only">Previous</span>
				</a>
				<a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
					<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
					<span class="sr-only">Next</span>
				</a>
			</div>


			<?php
		}
	}
}
