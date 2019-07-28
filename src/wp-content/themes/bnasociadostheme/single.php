<?php
/**
 * The Template for displaying all single posts
 *
 * Methods for TimberHelper can be found in the /lib sub-directory
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since    Timber 0.1
 */

$context = Timber::context();
$timber_post = Timber::query_post();
$context['post'] = $timber_post;

// if there is a gallery block do this
if (has_block('gallery', $post->post_content)) {
    $post_blocks = parse_blocks($post->post_content);
    $gallery_block = $post_blocks[0];
    $context['post_gallery'] = $gallery_block['innerHTML'];
}



if ( get_post_gallery($timber_post->ID) ) :
    $loty = get_post_gallery();
endif;

if ( post_password_required( $timber_post->ID ) ) {
	Timber::render( 'single-password.twig', $context );
} else {
	Timber::render( array( 'single-' . $timber_post->ID . '.twig', 'single-' . $timber_post->post_type . '.twig', 'single.twig' ), $context );
}
