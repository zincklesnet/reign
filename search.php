<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package Reign
 */

get_header();
?>

<?php do_action( 'reign_before_content_section' ); ?>

<div class="content-wrapper">
	<?php if ( have_posts() ) : ?>
	
		<div class="search-wrap">
			<?php get_search_form(); ?>		
		</div>

		<?php
		/* Start the Loop */
		while ( have_posts() ) :
			the_post();

			/**
			 * Run the loop for the search to output the results.
			 * If you want to overload this in a child theme then include a file
			 * called content-search.php and that will be used instead.
			 */
			get_template_part( 'template-parts/content', 'search' );

		endwhile;

		reign_custom_post_navigation();

	else :

		get_template_part( 'template-parts/content', 'none' );

	endif;
	?>

</div>

<?php do_action( 'reign_after_content_section' ); ?>

<?php
get_footer();
