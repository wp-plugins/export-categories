<?php
/*
Plugin Name: Export Categories
Plugin URI: http://wordpress.org/extend/plugins/export-categories/
Description: export you wordpress categories only to another wordpress site
Version: 1.0
Author: Shambhu Prasad Patnaik
Author URI:http://aynsoft.com/
*/
/*
***********************************************************
**********#	Name	    : Shambhu Prasad Patnaik   #*******
**********#	Company	    : Aynsoft			   #***********
**********#	Copyright (c) www.aynsoft.com 2013 #***********
***********************************************************
*/
register_deactivation_hook(__FILE__, 'export_categories_deactivate');
register_activation_hook(__FILE__, 'export_categories_activate');
if (!function_exists('export_categories_deactivate')):
function export_categories_deactivate()
{
}
endif;
if (!function_exists('export_categories_activate')):
function export_categories_activate()
{
}
endif;
if (!function_exists('export_categories_add_menus')) :
function export_categories_add_menus()
{
 add_management_page( 'Export Categories', 'Export Categories', 'manage_options', 'export-categories-admin_home', 'export_categories_admin_home' );
}
endif;
add_action('admin_menu', 'export_categories_add_menus');

if (!function_exists('export_categories_export')) :
function export_categories_export()
{
define( 'WXR_VERSION', '1.2' );

	global $wpdb;

	$sitename = sanitize_key( get_bloginfo( 'name' ) );
	if ( ! empty($sitename) ) $sitename .= '.';
	$filename = $sitename . 'wordpress_categories.' . date( 'Y-m-d' ) . '.xml';

	header( 'Content-Description: File Transfer' );
	header( 'Content-Disposition: attachment; filename=' . $filename );
	header( 'Content-Type: text/xml; charset=' . get_option( 'blog_charset' ), true );


	// get the requested terms ready, empty unless posts filtered by category or all content
	$cats =  $terms = array();
 {
		$categories = (array) get_categories( array( 'get' => 'all' ) );

		$custom_taxonomies = get_taxonomies( array( '_builtin' => false ) );
		$custom_terms = (array) get_terms( $custom_taxonomies, array( 'get' => 'all' ) );

		// put categories in order with no child going before its parent
		while ( $cat = array_shift( $categories ) ) {
			if ( $cat->parent == 0 || isset( $cats[$cat->parent] ) )
				$cats[$cat->term_id] = $cat;
			else
				$categories[] = $cat;
		}

		// put terms in order with no child going before its parent
		while ( $t = array_shift( $custom_terms ) ) {
			if ( $t->parent == 0 || isset( $terms[$t->parent] ) )
				$terms[$t->term_id] = $t;
			else
				$custom_terms[] = $t;
		}

		unset( $categories, $custom_taxonomies, $custom_terms );
	}

	/**
	 * Wrap given string in XML CDATA tag.
	 *
	 * @since 2.1.0
	 *
	 * @param string $str String to wrap in XML CDATA tag.
	 * @return string
	 */
	function wxr_cdata( $str ) {
		if ( seems_utf8( $str ) == false )
			$str = utf8_encode( $str );

		// $str = ent2ncr(esc_html($str));
		$str = '<![CDATA[' . str_replace( ']]>', ']]]]><![CDATA[>', $str ) . ']]>';

		return $str;
	}
	/**
	 * Return the URL of the site
	 *
	 * @since 2.5.0
	 *
	 * @return string Site URL.
	 */
function wxr_site_url() {
		// ms: the base url
		if ( is_multisite() )
			return network_home_url();
		// wp: the blog url
		else
			return get_bloginfo_rss( 'url' );
	}

	/**
	 * Output a cat_name XML tag from a given category object
	 *
	 * @since 2.1.0
	 *
	 * @param object $category Category Object
	 */
function wxr_cat_name( $category ) {
		if ( empty( $category->name ) )
			return;

		echo '<wp:cat_name>' . wxr_cdata( $category->name ) . '</wp:cat_name>';
	}

	/**
	 * Output a category_description XML tag from a given category object
	 *
	 * @since 2.1.0
	 *
	 * @param object $category Category Object
	 */
  	function wxr_category_description( $category ) {
		if ( empty( $category->description ) )
			return;

		echo '<wp:category_description>' . wxr_cdata( $category->description ) . '</wp:category_description>';
	}

	/**
	 * Output a tag_name XML tag from a given tag object
	 *
	 * @since 2.3.0
	 *
	 * @param object $tag Tag Object
	 */


	/**
	 * Output a tag_description XML tag from a given tag object
	 *
	 * @since 2.3.0
	 *
	 * @param object $tag Tag Object
	 */

	/**
	 * Output a term_name XML tag from a given term object
	 *
	 * @since 2.9.0
	 *
	 * @param object $term Term Object
	 */


	/**
	 * Output a term_description XML tag from a given term object
	 *
	 * @since 2.9.0
	 *
	 * @param object $term Term Object
	 */


	/**
	 * Output list of authors with posts
	 *
	 * @since 3.1.0
	 */


	/**
	 * Ouput all navigation menu terms
	 *
	 * @since 3.1.0
	 */


	/**
	 * Output list of taxonomy terms, in XML tag format, associated with a post
	 *
	 * @since 2.3.0
	 */



	echo'<?xml version="1.0" encoding="' . get_bloginfo('charset') . "\" ?>\n";

	?>
<!-- This is a WordPress eXtended RSS file generated by WordPress as an export of your site. -->
<!-- It contains information about your site's posts, pages, comments, categories, and other content. -->
<!-- You may use this file to transfer that content from one site to another. -->
<!-- This file is not intended to serve as a complete backup of your site. -->

<!-- To import this information into a WordPress site follow these steps: -->
<!-- 1. Log in to that site as an administrator. -->
<!-- 2. Go to Tools: Import in the WordPress admin panel. -->
<!-- 3. Install the "WordPress" importer from the list. -->
<!-- 4. Activate & Run Importer. -->
<!-- 5. Upload this file using the form provided on that page. -->
<!-- 6. You will first be asked to map the authors in this export file to users -->
<!--    on the site. For each author, you may choose to map to an -->
<!--    existing user on the site or to create a new user. -->
<!-- 7. WordPress will then import each of the posts, pages, comments, categories, etc. -->
<!--    contained in this file into your site. -->
<?php the_generator( 'export' ); ?>
 <rss version="2.0"
	xmlns:excerpt="http://wordpress.org/export/<?php echo WXR_VERSION; ?>/excerpt/"
	xmlns:content="http://purl.org/rss/1.0/modules/content/"
	xmlns:wfw="http://wellformedweb.org/CommentAPI/"
	xmlns:dc="http://purl.org/dc/elements/1.1/"
	xmlns:wp="http://wordpress.org/export/<?php echo WXR_VERSION; ?>/"
>
 <channel>
	<title><?php bloginfo_rss( 'name' ); ?></title>
	<link><?php bloginfo_rss( 'url' ); ?></link>
	<description><?php bloginfo_rss( 'description' ); ?></description>
	<pubDate><?php echo date( 'D, d M Y H:i:s +0000' ); ?></pubDate>
	<language><?php bloginfo_rss( 'language' ); ?></language>
	<wp:wxr_version><?php echo WXR_VERSION; ?></wp:wxr_version>
	<wp:base_site_url><?php echo wxr_site_url(); ?></wp:base_site_url>
	<wp:base_blog_url><?php bloginfo_rss( 'url' ); ?></wp:base_blog_url>
 <?php foreach ( $cats as $c ) : ?>
	<wp:category><wp:term_id><?php echo $c->term_id ?></wp:term_id><wp:category_nicename><?php echo $c->slug; ?></wp:category_nicename><wp:category_parent><?php echo $c->parent ? $cats[$c->parent]->slug : ''; ?></wp:category_parent><?php wxr_cat_name( $c ); ?><?php wxr_category_description( $c ); ?></wp:category>
 <?php endforeach; ?>
 <?php do_action( 'rss2_head' ); ?>
 </channel>
 </rss><?php
	die();
}
endif;
if(isset($_GET['page']) && $_GET['page'] == 'export-categories-admin_home' && isset( $_POST['download'] ) ) {
	add_action('init', 'export_categories_export');
}


if (!function_exists('export_categories_admin_home')) :
function export_categories_admin_home()
{

 echo'<div class="wrap">
       <div id="icon-tools" class="icon32 "></div>      
       <h2>Export Categories</h2><br>
	     <div>';
							?>
							<p>When you click the button below WordPress will create an XML file for you to save to your computer.</p>
<p>This format, which we call WordPress eXtended RSS or WXR, will contain your categories</p>
<p>Once you've saved the download file, you can use the Import function in another WordPress installation to import the content from this site.</p>
							<form action="" method="post" id="export-filters">
							 <input name="download" value="true" type="hidden">
        <p class="submit"><input name="submit" id="submit" class="button button-primary" value="Download Export File" type="submit"></p>
							<?php
     ?>
					 </form>
					<?php
}
endif;