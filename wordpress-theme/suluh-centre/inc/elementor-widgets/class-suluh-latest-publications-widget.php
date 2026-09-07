<?php
/**
 * "Latest Stories" Elementor widget — one featured Story in a large card,
 * a handful more in a list beside it, both pulled live from the `story`
 * post type (labeled "Stories" — see inc/content-types.php). Renders the
 * exact same markup/classes as the static build's Stories section
 * (.stories2-head, .story-spread, .feat-story, .list-story — see
 * concept2.css) so it's pixel-identical to the original design, not an
 * Elementor-native-widget approximation.
 *
 * The widget's internal name/slug (get_name(), the class name, this
 * filename) are left as "publications" even though the label reverted to
 * "Stories" — Elementor pages that already placed this widget (e.g.
 * home.json) reference it by that slug, and changing it would orphan the
 * widget on any page already using it.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Suluh_Latest_Publications_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'suluh-latest-publications';
	}

	public function get_title() {
		return __( 'Latest Stories', 'suluh-centre' );
	}

	public function get_icon() {
		return 'eicon-posts-grid';
	}

	public function get_categories() {
		return array( 'general' );
	}

	public function get_keywords() {
		return array( 'publications', 'stories', 'posts', 'news', 'suluh' );
	}

	protected function register_controls() {

		$this->start_controls_section(
			'suluh_content_section',
			array( 'label' => __( 'Content', 'suluh-centre' ) )
		);

		$this->add_control(
			'eyebrow_text',
			array(
				'label'   => __( 'Eyebrow', 'suluh-centre' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'From the ground', 'suluh-centre' ),
			)
		);

		$this->add_control(
			'heading_text',
			array(
				'label'   => __( 'Heading', 'suluh-centre' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Latest', 'suluh-centre' ),
			)
		);

		$this->add_control(
			'list_count',
			array(
				'label'       => __( 'Stories in the list', 'suluh-centre' ),
				'type'        => \Elementor\Controls_Manager::NUMBER,
				'default'     => 3,
				'min'         => 1,
				'max'         => 8,
				'description' => __( 'Not counting the one featured Story in the large card.', 'suluh-centre' ),
			)
		);

		$this->add_control(
			'story_type_filter',
			array(
				'label'   => __( 'Only show this Story Type', 'suluh-centre' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => '',
				'options' => $this->get_story_type_options(),
			)
		);

		$this->add_control(
			'view_all_text',
			array(
				'label'   => __( '"View all" link text', 'suluh-centre' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'All stories', 'suluh-centre' ),
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Builds the Story Type dropdown from the real taxonomy terms, so the
	 * list in the Elementor editor always matches whatever terms actually
	 * exist in wp-admin — no hardcoded term list to fall out of sync.
	 */
	private function get_story_type_options() {
		$options = array( '' => __( 'All types', 'suluh-centre' ) );

		if ( ! function_exists( 'get_terms' ) ) {
			return $options;
		}

		$terms = get_terms( array( 'taxonomy' => 'story_type', 'hide_empty' => false ) );
		if ( is_array( $terms ) ) {
			foreach ( $terms as $term ) {
				$options[ $term->slug ] = $term->name;
			}
		}

		return $options;
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$count    = max( 1, (int) $settings['list_count'] );
		$type     = $settings['story_type_filter'] ? $settings['story_type_filter'] : null;

		// One extra post for the featured slot, on top of the list count.
		$query = function_exists( 'suluh_get_stories' )
			? suluh_get_stories( $type, $count + 1 )
			: new WP_Query( array( 'post_type' => 'story', 'posts_per_page' => $count + 1, 'orderby' => 'date', 'order' => 'DESC' ) );

		$posts = $query->posts;

		if ( empty( $posts ) ) {
			echo '<p>' . esc_html__( 'No Stories published yet.', 'suluh-centre' ) . '</p>';
			return;
		}

		$featured = array_shift( $posts );
		$rest     = $posts;

		$archive_link = function_exists( 'get_post_type_archive_link' )
			? get_post_type_archive_link( 'story' )
			: home_url( '/stories/' );

		$f     = suluh_story_card_data( $featured->ID );
		$thumb = get_the_post_thumbnail_url( $featured->ID, 'large' );
		?>
		<div class="stories2-head">
			<div>
				<span class="eyebrow"><?php echo esc_html( $settings['eyebrow_text'] ); ?></span>
				<h2><?php echo esc_html( $settings['heading_text'] ); ?></h2>
			</div>
			<a class="see-all" href="<?php echo esc_url( $archive_link ); ?>">
				<?php echo esc_html( $settings['view_all_text'] ); ?> <svg width="15" height="15"><use href="#c2-ico-arrow"/></svg>
			</a>
		</div>
		<div class="story-spread">
			<a class="feat-story" href="<?php echo esc_url( $f['link'] ); ?>">
				<?php if ( $thumb ) : ?>
					<div class="thumb"><img src="<?php echo esc_url( $thumb ); ?>" alt="" loading="lazy"></div>
				<?php endif; ?>
				<div class="body">
					<?php if ( $f['tag'] ) : ?><span class="tag"><?php echo wp_kses_post( $f['tag'] ); ?></span><?php endif; ?>
					<h3><?php echo esc_html( $f['title'] ); ?></h3>
					<?php if ( $f['dek'] ) : ?><p><?php echo esc_html( $f['dek'] ); ?></p><?php endif; ?>
					<p class="meta"><?php echo esc_html( $f['date'] ); ?></p>
				</div>
			</a>
			<div>
				<?php foreach ( $rest as $p ) : $row = suluh_story_card_data( $p->ID ); ?>
					<a class="list-story" href="<?php echo esc_url( $row['link'] ); ?>">
						<div class="yr"><?php echo esc_html( $row['date'] ); ?></div>
						<div>
							<?php if ( $row['tag'] ) : ?><span class="tag2"><?php echo wp_kses_post( $row['tag'] ); ?></span><?php endif; ?>
							<h4><?php echo esc_html( $row['title'] ); ?></h4>
							<?php if ( $row['dek'] ) : ?><p><?php echo esc_html( $row['dek'] ); ?></p><?php endif; ?>
						</div>
					</a>
				<?php endforeach; ?>
			</div>
		</div>
		<?php
	}
}
