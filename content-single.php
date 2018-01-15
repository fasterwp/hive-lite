<?php
/**
 * @package Hive
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php
	/* translators: used between list items, there is a space after the comma */
	$category_list = get_the_category_list( __( ', ', 'hive-lite' ) );

	/* translators: used between list items, there is a space after the comma */
	$tag_list = get_the_tag_list( '', __( ', ', 'hive-lite' ) );

	if ( ! hive_categorized_blog() ) {
		// This blog only has 1 category so we just need to worry about tags in the meta text
		if ( '' != $tag_list ) {
			$meta_text = __( 'This entry was tagged %2$s. Bookmark the <a href="%3$s" rel="bookmark">permalink</a>.', 'hive-lite' );
		} else {
			$meta_text = __( 'Bookmark the <a href="%3$s" rel="bookmark">permalink</a>.', 'hive-lite' );
		}

	} else {
		// But this blog has loads of categories so we should probably display them here
		if ( '' != $tag_list ) {
			$meta_text = __( 'Posted in %1$s and tagged %2$s. Bookmark the <a href="%3$s" rel="bookmark">permalink</a>.', 'hive-lite' );
		} else {
			$meta_text = __( 'Posted in %1$s. Bookmark the <a href="%3$s" rel="bookmark">permalink</a>.', 'hive-lite' );
		}

	} // end check for categories on this blog
	?>

	<header class="entry-header">

		<div class="entry-meta">
			<?php hive_posted_on();

			if ( $category_list && hive_categorized_blog() ) { ?>
				<span class="cat-links">
					<?php echo $category_list; ?>
				</span>
			<?php } // End if categories ?>
		</div>
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

	</header><!-- .entry-header -->

	<?php if ( has_post_thumbnail() ) { ?>
		<div class="entry-featured  entry-thumbnail">
			<?php the_post_thumbnail( 'hive-single-image' ); ?>
			<?php
				$image_caption = get_post( get_post_thumbnail_id() )->post_excerpt;

				if( ! empty( $image_caption ) ) {
					echo '<span class="entry-featured__caption">' . $image_caption . '</span>';
				}
			?>
		</div>
	<?php } ?>

	<?php
	// We need to first get the rendered content, and then echo it.
	// This way we can process the rendered content without firing the 'the_content' filter multiple times.
	$content = hive_get_rendered_content();
	?>
	<div class="entry-content" <?php $first_letter = hive_first_content_character( $content );
	if ( ! empty( $first_letter ) ) {
		echo 'data-first_letter="' . esc_attr( $first_letter ) . '"';
	} ?>>
		<?php echo $content; ?>
	</div><!-- .entry-content -->

	<?php
	wp_link_pages( array(
		'before'           => '<div class="page-links  pagination">',
		'after'            => '</div>',
		'next_or_number'   => 'number',
		'nextpagelink'     => __( 'Next page', 'hive-lite' ),
		'previouspagelink' => __( 'Previous page', 'hive-lite' ),
		'pagelink'         => '%',
		'echo'             => 1,
	) ); ?>

	<footer class="entry-footer">
		<?php printf( $meta_text, $category_list, $tag_list, get_permalink() );
		edit_post_link( __( 'Edit', 'hive-lite' ), '<span class="edit-link">', '</span>' ); ?>
	</footer><!-- .entry-footer -->

</article><!-- #post-## -->