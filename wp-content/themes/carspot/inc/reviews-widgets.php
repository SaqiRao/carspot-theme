<?php
/**
 * Register widget with WordPress.
 */
add_action( 'widgets_init', function () {
	register_widget( 'carspot_recent_posts' );
} );

if ( ! class_exists( 'carspot_recent_posts' ) ) {
	class carspot_recent_posts extends WP_Widget {
		/**
		 * Register widget with WordPress.
		 */
		function __construct() {
			// Instantiate the parent object
			parent::__construct( false, 'Latest Reviews' );
		}

		/**
		 * Front-end display of widget.
		 *
		 * @param array $args Widget arguments.
		 * @param array $instance Saved values from database.
		 *
		 * @see WP_Widget::widget()
		 *
		 */
		public function widget( $args, $instance ) {


			global $post;
			if ( $instance['sb_no_of_review_posts'] == "" ) {
				$instance['sb_no_of_review_posts'] = 5;
			}
			$args         = array(
				'post_type'      => 'reviews',
				'posts_per_page' => $instance['sb_no_of_review_posts'],
				'orderby'        => 'ID',
				'order'          => 'DESC',
			);
			$recent_posts = get_posts( $args );
			?>
            <!-- Heading -->
            <div class="widget">
                <div class="latest-news">
                    <div class="widget-heading">
                        <h4 class="panel-title">
                            <a>
								<?php echo esc_html( $instance['title'] ); ?>
                            </a>
                        </h4>
                    </div>


                    <div class="recent-ads">
						<?php
						$src = '';
						foreach ( $recent_posts as $recent_post ) {
							$feat_image = wp_get_attachment_image_src( get_post_thumbnail_id( $recent_post->ID ), 'carspot-small-thumb' );
							if ( $feat_image != '' ) {
								$src = $feat_image[0];
							}
							?>

                            <div class="recent-ads-list">
                                <div class="recent-ads-container">
									<?php
									if ( $src != "" ) {
										?>
                                        <div class="recent-ads-list-image">
                                            <a href="<?php echo esc_url( get_the_permalink( $recent_post->ID ) ); ?>"
                                               class="recent-ads-list-image-inner">
                                                <img src="<?php echo esc_url( $src ); ?>"
                                                     alt="<?php echo esc_attr( get_the_title( $recent_post->ID ) ); ?>">
                                            </a><!-- /.recent-ads-list-image-inner -->
                                        </div>
										<?php
									}
									?>
                                    <!-- /.recent-ads-list-image -->
                                    <div class="recent-ads-list-content">
                                        <h3 class="recent-ads-list-title">
                                            <a href="<?php echo esc_url( get_the_permalink( $recent_post->ID ) ); ?>"><?php echo esc_html( get_the_title( $recent_post->ID ) ); ?></a>
                                        </h3>
                                        <ul class="recent-ads-list-location">
                                            <li>
                                                <a href="javascript:void(0)"><?php echo esc_html( get_the_date( get_option( 'date_format' ), $recent_post->ID ) ); ?></a>
                                            </li>
                                        </ul>
                                        <!-- /.recent-ads-list-price -->
                                    </div>
                                    <!-- /.recent-ads-list-content -->
                                </div>
                                <!-- /.recent-ads-container -->
                            </div>

							<?php
						}
						?>
                    </div>

                </div>
            </div>


			<?php
		}

		/**
		 * Back-end widget form.
		 *
		 * @param array $instance Previously saved values from database.
		 *
		 * @see WP_Widget::form()
		 *
		 */
		public function form( $instance ) {
			if ( isset( $instance['title'] ) ) {
				$title = $instance['title'];
			} else {
				$title = esc_html__( 'Latest Reviews', 'carspot' );
			}
			if ( isset( $instance['sb_no_of_review_posts'] ) ) {
				$sb_no_of_review_posts = $instance['sb_no_of_review_posts'];
			} else {
				$sb_no_of_review_posts = 5;
			}
			?>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>">
					<?php echo esc_html__( 'Title:', 'carspot' ); ?>
                </label>
                <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"
                       name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text"
                       value="<?php echo esc_attr( $title ); ?>">
            </p>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'sb_no_of_review_posts' ) ); ?>">
					<?php esc_html__( 'How many posts to diplay:', 'carspot' ); ?>
                </label>
                <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'sb_no_of_review_posts' ) ); ?>"
                       name="<?php echo esc_attr( $this->get_field_name( 'sb_no_of_review_posts' ) ); ?>" type="text"
                       value="<?php echo esc_attr( $sb_no_of_review_posts ); ?>">
            </p>
			<?php
		}

		/**
		 * Sanitize widget form values as they are saved.
		 *
		 * @param array $new_instance Values just sent to be saved.
		 * @param array $old_instance Previously saved values from database.
		 *
		 * @return array Updated safe values to be saved.
		 * @see WP_Widget::update()
		 *
		 */
		public function update( $new_instance, $old_instance ) {
			$instance                          = array();
			$instance['title']                 = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
			$instance['sb_no_of_review_posts'] = ( ! empty( $new_instance['sb_no_of_review_posts'] ) ) ? strip_tags( $new_instance['sb_no_of_review_posts'] ) : '';

			return $instance;
		}
	}
}

// Reviews By Top Brands
add_action( 'widgets_init', function () {
	register_widget( 'carspot_top_brands' );
} );
if ( ! class_exists( 'carspot_top_brands' ) ) {
	class carspot_top_brands extends WP_Widget {
		/**
		 * Register widget with WordPress.
		 */
		function __construct() {
			// Instantiate the parent object
			parent::__construct( false, 'Reviews By Brands' );
		}

		/**
		 * Front-end display of widget.
		 *
		 * @param array $args Widget arguments.
		 * @param array $instance Saved values from database.
		 *
		 * @see WP_Widget::widget()
		 *
		 */
		public function widget( $args, $instance ) {
			global $post;
			if ( $instance['sb_no_of_posts'] == "" ) {
				$instance['sb_no_of_posts'] = 5;
			}
			?>
            <!-- Heading -->
            <div class="widget">
                <div class="reviews_bybrands">
                    <div class="widget-heading">
                        <h4 class="panel-title">
                            <a>
								<?php echo esc_html( $instance['title'] ); ?>
                            </a>
                        </h4>
                    </div>
					<?php
					$terms = get_terms( 'reviews_brands', array(
						'hide_empty' => false,
						'number'     => $instance['sb_no_of_posts'],
						' orderby'   => 'id',
						'order'      => 'ASC'
					) );
					if ( is_array($terms) && count( $terms ) > 0 ) {
						$table = '';
						$i     = 0;
						$table = "<table class='table'><tbody><tr>";
						$count = count( $terms );
						foreach ( $terms as $term ) {
							$table .=
								'<td>
                   <a href="' . esc_url( get_term_link( $term ) ) . '">' . esc_html( $term->name ) . '<span>&nbsp;(' . $term->count . ')' . '</span> </a>
                    
					</td>';

							if ( ( $i + 1 ) % 2 == 0 ) {

								if ( $count == 1 ) {
									$table .= "</tr>";
								} else {
									$table .= "</tr><tr>";
								}

							}
							$count --;
							$i ++;
						}
						$table .= "</tr></tbody></table>";
					}
					echo "" . ( $table );
					?>
                </div>
            </div>


			<?php
		}

		/**
		 * Back-end widget form.
		 *
		 * @param array $instance Previously saved values from database.
		 *
		 * @see WP_Widget::form()
		 *
		 */
		public function form( $instance ) {
			if ( isset( $instance['title'] ) ) {
				$title = $instance['title'];
			} else {
				$title = esc_html__( 'Reviews By Brands', 'carspot' );
			}
			if ( isset( $instance['sb_no_of_posts'] ) ) {
				$sb_no_of_posts = $instance['sb_no_of_posts'];
			} else {
				$sb_no_of_posts = 5;
			}
			?>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>">
					<?php echo esc_html__( 'Title:', 'carspot' ); ?>
                </label>
                <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"
                       name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text"
                       value="<?php echo esc_attr( $title ); ?>">
            </p>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'sb_no_of_posts' ) ); ?>">
					<?php esc_html__( 'How many posts to diplay:', 'carspot' ); ?>
                </label>
                <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'sb_no_of_posts' ) ); ?>"
                       name="<?php echo esc_attr( $this->get_field_name( 'sb_no_of_posts' ) ); ?>" type="text"
                       value="<?php echo esc_attr( $sb_no_of_posts ); ?>">
            </p>
			<?php
		}

		/**
		 * Sanitize widget form values as they are saved.
		 *
		 * @param array $new_instance Values just sent to be saved.
		 * @param array $old_instance Previously saved values from database.
		 *
		 * @return array Updated safe values to be saved.
		 * @see WP_Widget::update()
		 *
		 */
		public function update( $new_instance, $old_instance ) {
			$instance                   = array();
			$instance['title']          = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
			$instance['sb_no_of_posts'] = ( ! empty( $new_instance['sb_no_of_posts'] ) ) ? strip_tags( $new_instance['sb_no_of_posts'] ) : '';

			return $instance;
		}
	}
}


// Reviews By Categories
add_action( 'widgets_init', function () {
	register_widget( 'carspot_review_categories' );
} );
if ( ! class_exists( 'carspot_review_categories' ) ) {
	class carspot_review_categories extends WP_Widget {
		/**
		 * Register widget with WordPress.
		 */
		function __construct() {
			// Instantiate the parent object
			parent::__construct( false, 'Reviews By Categories' );
		}

		/**
		 * Front-end display of widget.
		 *
		 * @param array $args Widget arguments.
		 * @param array $instance Saved values from database.
		 *
		 * @see WP_Widget::widget()
		 *
		 */
		public function widget( $args, $instance ) {
			global $post;
			if ( $instance['sb_no_of_posts'] == "" ) {
				$instance['sb_no_of_posts'] = 5;
			}
			?>
            <!-- Heading -->
            <div class="widget">
                <div class="widget-heading">
                    <h4 class="panel-title">
                        <a>
							<?php echo esc_html( $instance['title'] ); ?>
                        </a>
                    </h4>
                </div>
                <div class="categories">
					<?php
					$cat_terms = get_terms( 'reviews_cats', array(
						'hide_empty' => false,
						'number'     => $instance['sb_no_of_posts'],
						' orderby'   => 'id',
						'order'      => 'DESC'
					) );
					if ( is_array($cat_terms) && count( $cat_terms ) > 0 ) {
						echo '<ul>';
						foreach ( $cat_terms as $terms ) {
							echo '<li> <a href="' . esc_url( get_term_link( $terms ) ) . '"> ' . esc_html( $terms->name ) . '<span>&nbsp;(' . $terms->count . ')' . '</span>  </a> </li>';
						}
						echo '</ul>';

					}
					?>
                </div>
            </div>


			<?php
		}

		/**
		 * Back-end widget form.
		 *
		 * @param array $instance Previously saved values from database.
		 *
		 * @see WP_Widget::form()
		 *
		 */
		public function form( $instance ) {
			if ( isset( $instance['title'] ) ) {
				$title = $instance['title'];
			} else {
				$title = esc_html__( 'Reviews By Categories', 'carspot' );
			}
			if ( isset( $instance['sb_no_of_posts'] ) ) {
				$sb_no_of_posts = $instance['sb_no_of_posts'];
			} else {
				$sb_no_of_posts = 5;
			}
			?>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>">
					<?php echo esc_html__( 'Title:', 'carspot' ); ?>
                </label>
                <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"
                       name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text"
                       value="<?php echo esc_attr( $title ); ?>">
            </p>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'sb_no_of_posts' ) ); ?>">
					<?php esc_html__( 'How many posts to diplay:', 'carspot' ); ?>
                </label>
                <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'sb_no_of_posts' ) ); ?>"
                       name="<?php echo esc_attr( $this->get_field_name( 'sb_no_of_posts' ) ); ?>" type="text"
                       value="<?php echo esc_attr( $sb_no_of_posts ); ?>">
            </p>
			<?php
		}

		/**
		 * Sanitize widget form values as they are saved.
		 *
		 * @param array $new_instance Values just sent to be saved.
		 * @param array $old_instance Previously saved values from database.
		 *
		 * @return array Updated safe values to be saved.
		 * @see WP_Widget::update()
		 *
		 */
		public function update( $new_instance, $old_instance ) {
			$instance                   = array();
			$instance['title']          = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
			$instance['sb_no_of_posts'] = ( ! empty( $new_instance['sb_no_of_posts'] ) ) ? strip_tags( $new_instance['sb_no_of_posts'] ) : '';

			return $instance;
		}
	}
}