<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Reign
 */

global $post;
$bp_pages = get_option( 'bp-pages' );
if ( bp_is_current_component( 'groups' ) ) {
	$post = get_post( $bp_pages['groups'] );
} elseif ( bp_is_current_component( 'members' ) || bp_is_user() ) {
	$post = get_post( $bp_pages['members'] );
} elseif ( bp_is_current_component( 'activity' ) ) {
	$post = get_post( $bp_pages['activity'] );
} elseif ( bp_is_current_component( 'document' ) ) {
	$post = get_post( $bp_pages['document'] );
} elseif ( bp_is_current_component( 'media' ) ) {
	$post = get_post( $bp_pages['media'] );
} elseif ( bp_is_register_page() ) {
	$post = get_post( $bp_pages['register'] );
}

$theme_slug  = apply_filters( 'wbcom_essential_theme_slug', 'reign' );
$site_layout = '';
if ( ! empty( $post ) && $post->ID != 0 ) {
	$wbcom_metabox_data = get_post_meta( $post->ID, $theme_slug . '_wbcom_metabox_data', true );
	$site_layout        = isset( $wbcom_metabox_data['layout']['site_layout'] ) ? $wbcom_metabox_data['layout']['site_layout'] : '';
}

if ( function_exists( 'buddypress' ) && version_compare( buddypress()->version, '12.0', '>=' ) || class_exists( 'BP_Classic' ) ) {
	$bp_activity_sidebar = get_theme_mod( 'reign_activity_directory_sidebar_layout', 'right_sidebar' );
	$bp_members_sidebar  = get_theme_mod( 'reign_members_directory_sidebar_layout', 'right_sidebar' );
	$bp_groups_sidebar   = get_theme_mod( 'reign_groups_directory_sidebar_layout', 'right_sidebar' );

	if ( ( bp_is_current_component( 'activity' ) && $bp_activity_sidebar == 'both_sidebar' ) || bp_is_current_component( 'activity' ) && ( $bp_activity_sidebar == 'right_sidebar' ) ) {
		$sidebar_id = 'activity-index';
	} elseif ( ( bp_is_current_component( 'members' ) && $bp_members_sidebar == 'both_sidebar' ) || ( bp_is_current_component( 'members' ) && $bp_members_sidebar == 'right_sidebar' ) ) {
		$sidebar_id = 'member-index';
	} elseif ( ( bp_is_current_component( 'groups' ) && $bp_groups_sidebar == 'both_sidebar' ) || bp_is_current_component( 'groups' ) && ( $bp_groups_sidebar == 'right_sidebar' ) ) {
		$sidebar_id = 'group-index';
	} elseif ( $site_layout == '0' ) {
		$sidebar_id = '0';
	} elseif ( ! bp_is_user() ) {
		return;
	}
} elseif ( ( $site_layout == 'both_sidebar' ) || ( $site_layout == 'right_sidebar' ) ) {
	$sidebar_id = $wbcom_metabox_data['layout']['primary_sidebar'];
} elseif ( $site_layout == '0' ) {
	$sidebar_id = '0';
} elseif ( ! bp_is_user() ) {
	return;
}

if ( bp_is_current_component( 'groups' ) && ! bp_is_group() && ! bp_is_user() && ! bp_is_group_create() ) {
	$class      = 'widget-area member-index-widget-area md-wb-grid-1-3';
	$sidebar_id = ( $sidebar_id != '0' ) ? $sidebar_id : 'group-index';
	if ( ! is_active_sidebar( $sidebar_id ) ) {
		return;
	}
	ob_start();
	do_action( 'reign_begin_group_index_sidebar' );
	dynamic_sidebar( $sidebar_id );
	do_action( 'reign_end_group_index_sidebar' );
	$sidebar_content = ob_get_clean();

	if ( ! empty( trim( $sidebar_content ) ) ) {
		?>
		<aside id="left" class="<?php echo esc_attr( $class ); ?>" role="complementary">
			<div class="widget-area-inner">
				<?php echo $sidebar_content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</div>
		</aside>
		<?php
	}
} elseif ( bp_is_current_component( 'members' ) && ! bp_is_user() ) {
	$class      = 'widget-area member-index-widget-area md-wb-grid-1-3';
	$sidebar_id = ( $sidebar_id != '0' ) ? $sidebar_id : 'member-index';
	if ( ! is_active_sidebar( $sidebar_id ) ) {
		return;
	}
	ob_start();
	do_action( 'reign_begin_member_index_sidebar' );
	dynamic_sidebar( $sidebar_id );
	do_action( 'reign_end_member_index_sidebar' );
	$sidebar_content = ob_get_clean();

	if ( ! empty( trim( $sidebar_content ) ) ) {
		?>
		<aside id="left" class="<?php echo esc_attr( $class ); ?>" role="complementary">
			<div class="widget-area-inner">
				<?php echo $sidebar_content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</div>
		</aside>
		<?php
	}
} elseif ( bp_is_current_component( 'activity' ) && ! bp_is_user() ) {

	$sidebar_id = ( $sidebar_id != '0' ) ? $sidebar_id : 'activity-index';

	if ( is_active_sidebar( $sidebar_id ) ) {
		ob_start();
		do_action( 'reign_begin_activity_index_sidebar' );
		dynamic_sidebar( $sidebar_id );
		do_action( 'reign_end_activity_index_sidebar' );
		$sidebar_content = ob_get_clean();

		if ( ! empty( trim( $sidebar_content ) ) ) {
			?>
			<aside id="secondary" class="widget-area activity-index-widget-area sm-wb-grid-1-3" role="complementary">
				<div class="widget-area-inner">
					<?php echo $sidebar_content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				</div>
			</aside>
			<?php
		}
	}
} elseif ( function_exists( 'bp_is_document_component' ) && ( bp_is_document_component() && ! bp_is_user() ) ) {
	$sidebar_id = ( $sidebar_id != '0' ) ? $sidebar_id : 'activity-index';

	if ( is_active_sidebar( $sidebar_id ) ) {
		ob_start();
		do_action( 'reign_begin_activity_index_sidebar' );
		dynamic_sidebar( $sidebar_id );
		do_action( 'reign_end_activity_index_sidebar' );
		$sidebar_content = ob_get_clean();

		if ( ! empty( trim( $sidebar_content ) ) ) {
			?>
			<aside id="secondary" class="widget-area activity-index-widget-area sm-wb-grid-1-3" role="complementary">
				<div class="widget-area-inner">
					<?php echo $sidebar_content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				</div>
			</aside>
			<?php
		}
	}
} elseif ( function_exists( 'bp_is_media_component' ) && ( bp_is_media_component() && ! bp_is_user() ) ) {
	$sidebar_id = ( $sidebar_id != '0' ) ? $sidebar_id : 'activity-index';

	if ( is_active_sidebar( $sidebar_id ) ) {
		ob_start();
		do_action( 'reign_begin_activity_index_sidebar' );
		dynamic_sidebar( $sidebar_id );
		do_action( 'reign_end_activity_index_sidebar' );
		$sidebar_content = ob_get_clean();

		if ( ! empty( trim( $sidebar_content ) ) ) {
			?>
			<aside id="secondary" class="widget-area activity-index-widget-area sm-wb-grid-1-3" role="complementary">
				<div class="widget-area-inner">
					<?php echo $sidebar_content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				</div>
			</aside>
			<?php
		}
	}
} elseif ( function_exists( 'bp_is_register_page' ) && bp_is_register_page() ) {
	$sidebar_id = ( $sidebar_id != '0' ) ? $sidebar_id : 'activity-index';

	if ( is_active_sidebar( $sidebar_id ) ) {
		ob_start();
		do_action( 'reign_begin_activity_index_sidebar' );
		dynamic_sidebar( $sidebar_id );
		do_action( 'reign_end_activity_index_sidebar' );
		$sidebar_content = ob_get_clean();

		if ( ! empty( trim( $sidebar_content ) ) ) {
			?>
			<aside id="secondary" class="widget-area activity-index-widget-area sm-wb-grid-1-3" role="complementary">
				<div class="widget-area-inner">
					<?php echo $sidebar_content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				</div>
			</aside>
			<?php
		}
	}
}
