<?php
/**
 * Plugin Name: SEO Flight Schedule
 * Description: Muestra los vuelos de los aeropuertos y aerolineas.
 * Version: 1.0
 * Author: Opentech
 * Text Domain: seo-flight-schedule
 */

 defined('ABSPATH') or die('¡Acceso directo no permitido!');

 // Register Custom Post Type
 function register_my_custom_post_types() {

    // $labels = array(
    //     'name'              => _x('Locations', 'taxonomy general name', 'seo-flight-schedule'),
    //     'singular_name'     => _x('Location', 'taxonomy singular name', 'seo-flight-schedule'),
    //     'search_items'      => __('Search Locations', 'seo-flight-schedule'),
    //     'all_items'         => __('All Locations', 'seo-flight-schedule'),
    //     'parent_item'       => __('Parent Location', 'seo-flight-schedule'),
    //     'parent_item_colon' => __('Parent Location:', 'seo-flight-schedule'),
    //     'edit_item'         => __('Edit Location', 'seo-flight-schedule'),
    //     'update_item'       => __('Update Location', 'seo-flight-schedule'),
    //     'add_new_item'      => __('Add New Location', 'seo-flight-schedule'),
    //     'new_item_name'     => __('New Location Name', 'seo-flight-schedule'),
    //     'menu_name'         => __('Location', 'seo-flight-schedule'),
    // );
    // $args = array(
    //     'hierarchical'      => true, // make it hierarchical (like categories)
    //     'labels'            => $labels,
    //     'show_ui'           => true,
    //     'show_admin_column' => true,
    //     'query_var'         => true,
    //     'rewrite'           => array('slug' => 'location', 'with_front' => true, 'hierarchical' => true),
    // );
    // register_taxonomy('location', array('airport', 'airline', 'flight', 'post', 'page'), $args);

        // Register Custom Taxonomy Country
    $labels = array(
        'name'              => _x('Countries Taxonomies', 'taxonomy general name', 'seo-flight-schedule'),
        'singular_name'     => _x('Country Taxonomy', 'taxonomy singular name', 'seo-flight-schedule'),
        'search_items'      => __('Search Countries Taxonomies', 'seo-flight-schedule'),
        'all_items'         => __('All Countries Taxonomies', 'seo-flight-schedule'),
        'parent_item'       => __('Parent Country Taxonomy', 'seo-flight-schedule'),
        'parent_item_colon' => __('Parent Country Taxonomy:', 'seo-flight-schedule'),
        'edit_item'         => __('Edit Country Taxonomy', 'seo-flight-schedule'),
        'update_item'       => __('Update Country Taxonomy', 'seo-flight-schedule'),
        'add_new_item'      => __('Add New Country Taxonomy', 'seo-flight-schedule'),
        'new_item_name'     => __('New Country Taxonomy Name', 'seo-flight-schedule'),
        'menu_name'         => __('Country Taxonomy', 'seo-flight-schedule'),
    );
    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'country-taxonomy', 'with_front' => true, 'hierarchical' => true),
    );
    register_taxonomy('country-taxonomy', array('airport', 'airline', 'flight', 'post', 'page'), $args);

    // Register Custom Taxonomy State
    $labels = array(
        'name'              => _x('States Taxonomies', 'taxonomy general name', 'seo-flight-schedule'),
        'singular_name'     => _x('State Taxonomy', 'taxonomy singular name', 'seo-flight-schedule'),
        'search_items'      => __('Search States Taxonomies', 'seo-flight-schedule'),
        'all_items'         => __('All States Taxonomies', 'seo-flight-schedule'),
        'parent_item'       => __('Parent State Taxonomy', 'seo-flight-schedule'),
        'parent_item_colon' => __('Parent State Taxonomy:', 'seo-flight-schedule'),
        'edit_item'         => __('Edit State Taxonomy', 'seo-flight-schedule'),
        'update_item'       => __('Update State Taxonomy', 'seo-flight-schedule'),
        'add_new_item'      => __('Add New State Taxonomy', 'seo-flight-schedule'),
        'new_item_name'     => __('New State Taxonomy Name', 'seo-flight-schedule'),
        'menu_name'         => __('State Taxonomy', 'seo-flight-schedule'),
    );
    $args = array(
        'hierarchical'      => true, 
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'state-taxonomy', 'with_front' => true, 'hierarchical' => true),
    );
    register_taxonomy('state-taxonomy', array('airport', 'airline', 'flight', 'post', 'page'), $args);

    // Register Custom Taxonomy City
    $labels = array(
        'name'              => _x('Cities Taxonomies', 'taxonomy general name', 'seo-flight-schedule'),
        'singular_name'     => _x('City Taxonomy', 'taxonomy singular name', 'seo-flight-schedule'),
        'search_items'      => __('Search Cities Taxonomies', 'seo-flight-schedule'),
        'all_items'         => __('All Cities Taxonomies', 'seo-flight-schedule'),
        'parent_item'       => __('Parent City Taxonomy', 'seo-flight-schedule'),
        'parent_item_colon' => __('Parent City Taxonomy:', 'seo-flight-schedule'),
        'edit_item'         => __('Edit City Taxonomy', 'seo-flight-schedule'),
        'update_item'       => __('Update City Taxonomy', 'seo-flight-schedule'),
        'add_new_item'      => __('Add New City Taxonomy', 'seo-flight-schedule'),
        'new_item_name'     => __('New City Taxonomy Name', 'seo-flight-schedule'),
        'menu_name'         => __('City Taxonomy', 'seo-flight-schedule'),
    );
    $args = array(
        'hierarchical'      => true, // make it hierarchical (like categories)
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'city-taxonomy', 'with_front' => true, 'hierarchical' => true),
    );
    register_taxonomy('city-taxonomy', array('airport', 'airline', 'flight', 'post', 'page'), $args);

    //Register custom taxonomy Airports
$labels = array(
        'name'              => _x('Airports Taxonomies', 'taxonomy general name', 'seo-flight-schedule'),
        'singular_name'     => _x('Airport Taxonomy', 'taxonomy singular name', 'seo-flight-schedule'),
        'search_items'      => __('Search Airports Taxonomies', 'seo-flight-schedule'),
        'all_items'         => __('All Airports Taxonomies', 'seo-flight-schedule'),
        'parent_item'       => __('Parent Airport Taxonomy', 'seo-flight-schedule'),
        'parent_item_colon' => __('Parent Airport Taxonomy:', 'seo-flight-schedule'),
        'edit_item'         => __('Edit Airport Taxonomy', 'seo-flight-schedule'),
        'update_item'       => __('Update Airport Taxonomy', 'seo-flight-schedule'),
        'add_new_item'      => __('Add New Airport Taxonomy', 'seo-flight-schedule'),
        'new_item_name'     => __('New Airport Taxonomy Name', 'seo-flight-schedule'),
        'menu_name'         => __('Airport Taxonomy', 'seo-flight-schedule'),
    );
    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'airport-taxonomy', 'with_front' => true, 'hierarchical' => true),
    );
    register_taxonomy('airport-taxonomy', array('airport', 'airline', 'flight', 'post', 'page'), $args);

    //Register custom taxonomy Airlines
    $labels = array(
        'name'              => _x('Airlines Taxonomies', 'taxonomy general name', 'seo-flight-schedule'),
        'singular_name'     => _x('Airline Taxonomy', 'taxonomy singular name', 'seo-flight-schedule'),
        'search_items'      => __('Search Airlines Taxonomies', 'seo-flight-schedule'),
        'all_items'         => __('All Airlines Taxonomies', 'seo-flight-schedule'),
        'parent_item'       => __('Parent Airline Taxonomy', 'seo-flight-schedule'),
        'parent_item_colon' => __('Parent Airline Taxonomy:', 'seo-flight-schedule'),
        'edit_item'         => __('Edit Airline Taxonomy', 'seo-flight-schedule'),
        'update_item'       => __('Update Airline Taxonomy', 'seo-flight-schedule'),
        'add_new_item'      => __('Add New Airline Taxonomy', 'seo-flight-schedule'),
        'new_item_name'     => __('New Airline Taxonomy Name', 'seo-flight-schedule'),
        'menu_name'         => __('Airline Taxonomy', 'seo-flight-schedule'),
    );
    $args = array(
        'hierarchical'      => true, 
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'airline-taxonomy', 'with_front' => true, 'hierarchical' => true),
    );
    register_taxonomy('airline-taxonomy', array('airport', 'airline', 'flight', 'post', 'page'), $args);

    // Register Custom Post Type Airports
    $labels = array(
        'name'                  => _x('Airports', 'Post Type General Name', 'seo-flight-schedule'),
        'singular_name'         => _x('Airport', 'Post Type Singular Name', 'seo-flight-schedule'),
        'menu_name'             => __('Airports', 'seo-flight-schedule'),
        'name_admin_bar'        => __('Airports', 'seo-flight-schedule'),
        'archives'              => __('Airport Archives', 'seo-flight-schedule'),
        'attributes'            => __('Airport Attributes', 'seo-flight-schedule'),
        'parent_item_colon'     => __('Parent Airport:', 'seo-flight-schedule'),
        'all_items'             => __('All Airports', 'seo-flight-schedule'),
        'add_new_item'          => __('Add New Airport', 'seo-flight-schedule'),
        'add_new'               => __('Add Airport', 'seo-flight-schedule'),
        'new_item'              => __('New Airport', 'seo-flight-schedule'),
        'edit_item'             => __('Edit Airport', 'seo-flight-schedule'),
        'update_item'           => __('Update Airport', 'seo-flight-schedule'),
        'view_item'             => __('View Airport', 'seo-flight-schedule'),
        'view_items'            => __('View Airports', 'seo-flight-schedule'),
        'search_items'          => __('Search Airports', 'seo-flight-schedule'),
        'not_found'             => __('Airport Not found', 'seo-flight-schedule'),
        'not_found_in_trash'    => __('Airport Not found in Trash', 'seo-flight-schedule'),
        'featured_image'        => __('Featured Image', 'seo-flight-schedule'),
        'set_featured_image'    => __('Set featured image', 'seo-flight-schedule'),
        'remove_featured_image' => __('Remove featured image', 'seo-flight-schedule'),
        'use_featured_image'    => __('Use as featured image', 'seo-flight-schedule'),
        'insert_into_item'      => __('Insert into item', 'seo-flight-schedule'),
        'uploaded_to_this_item' => __('Uploaded to this item', 'seo-flight-schedule'),
        'items_list'            => __('Airports list', 'seo-flight-schedule'),
        'items_list_navigation' => __('Airports list navigation', 'seo-flight-schedule'),
        'filter_items_list'     => __('Filter Airports list', 'seo-flight-schedule'),
    );
    $rewrite = array(
        'slug'                  => 'airport',
        'with_front'            => true,
        'pages'                 => true,
        'feeds'                 => true,
    );
    $args = array(
        'label'                 => __('Airport', 'seo-flight-schedule'),
        'description'           => __('Post type for Airports', 'seo-flight-schedule'),
        'labels'                => $labels,
        'supports'              => array('title', 'editor', 'trackbacks', 'custom-fields', 'page-attributes', 'post-formats'),
        'taxonomies'            => array('country-taxonomy', 'state-taxonomy', 'city-taxonomy', 'airport-taxonomy', 'airline-taxonomy'),
        'hierarchical'          => true,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => 'seo-flight-schedule',
        'menu_position'         => 5,
        'menu_icon'             => 'dashicons-airplane',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'rewrite'               => $rewrite,
        'capability_type'       => 'post',
    );
    register_post_type('post_type_airports', $args);

    //Register Custom Post Type Airlines
    	$labels = array(
		'name'                  => _x( 'Airlines', 'Post Type General Name', 'seo-flight-schedule' ),
		'singular_name'         => _x( 'Airline', 'Post Type Singular Name', 'seo-flight-schedule' ),
		'menu_name'             => __( 'Airlines', 'seo-flight-schedule' ),
		'name_admin_bar'        => __( 'Airlines', 'seo-flight-schedule' ),
		'archives'              => __( 'Airline Archives', 'seo-flight-schedule' ),
		'attributes'            => __( 'Airline Attributes', 'seo-flight-schedule' ),
		'parent_item_colon'     => __( 'Parent Airline:', 'seo-flight-schedule' ),
		'all_items'             => __( 'All Airlines', 'seo-flight-schedule' ),
		'add_new_item'          => __( 'Add New Airline', 'seo-flight-schedule' ),
		'add_new'               => __( 'Add Airline', 'seo-flight-schedule' ),
		'new_item'              => __( 'New Airline', 'seo-flight-schedule' ),
		'edit_item'             => __( 'Edit Airline', 'seo-flight-schedule' ),
		'update_item'           => __( 'Update Airline', 'seo-flight-schedule' ),
		'view_item'             => __( 'View Airline', 'seo-flight-schedule' ),
		'view_items'            => __( 'View Airlines', 'seo-flight-schedule' ),
		'search_items'          => __( 'Search Airlines', 'seo-flight-schedule' ),
		'not_found'             => __( 'Airline Not found', 'seo-flight-schedule' ),
		'not_found_in_trash'    => __( 'Airline Not found in Trash', 'seo-flight-schedule' ),
		'featured_image'        => __( 'Featured Image', 'seo-flight-schedule' ),
		'set_featured_image'    => __( 'Set featured image', 'seo-flight-schedule' ),
		'remove_featured_image' => __( 'Remove featured image', 'seo-flight-schedule' ),
		'use_featured_image'    => __( 'Use as featured image', 'seo-flight-schedule' ),
		'insert_into_item'      => __( 'Insert into item', 'seo-flight-schedule' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'seo-flight-schedule' ),
		'items_list'            => __( 'Airlines list', 'seo-flight-schedule' ),
		'items_list_navigation' => __( 'Airlines list navigation', 'seo-flight-schedule' ),
		'filter_items_list'     => __( 'Filter Airlines list', 'seo-flight-schedule' ),
	);
	$rewrite = array(
		'slug'                  => 'airline',
		'with_front'            => true,
		'pages'                 => true,
		'feeds'                 => false,
	);
	$args = array(
		'label'                 => __( 'Airline', 'seo-flight-schedule' ),
		'description'           => __( 'Post type for Airlines', 'seo-flight-schedule' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'trackbacks', 'custom-fields', 'page-attributes', 'post-formats' ),
		'taxonomies'            => array('country-taxonomy', 'state-taxonomy', 'city-taxonomy', 'airport-taxonomy', 'airline-taxonomy'),
		'hierarchical'          => true,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => 'seo-flight-schedule',
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-airplane',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'rewrite'               => $rewrite,
		'capability_type'       => 'post',
	);
	register_post_type( 'post_type_airlines', $args );
    
        // Register Custom Post Type Flights
        $labels = array(
            'name'                  => _x('Flights', 'Post Type General Name', 'seo-flight-schedule'),
            'singular_name'         => _x('Flight', 'Post Type Singular Name', 'seo-flight-schedule'),
            'menu_name'             => __('Flights', 'seo-flight-schedule'),
            'name_admin_bar'        => __('Flights', 'seo-flight-schedule'),
            'archives'              => __('Flight Archives', 'seo-flight-schedule'),
            'attributes'            => __('Flight Attributes', 'seo-flight-schedule'),
            'parent_item_colon'     => __('Parent Flight:', 'seo-flight-schedule'),
            'all_items'             => __('All Flights', 'seo-flight-schedule'),
            'add_new_item'          => __('Add New Flight', 'seo-flight-schedule'),
            'add_new'               => __('Add Flight', 'seo-flight-schedule'),
            'new_item'              => __('New Flight', 'seo-flight-schedule'),
            'edit_item'             => __('Edit Flight', 'seo-flight-schedule'),
            'update_item'           => __('Update Flight', 'seo-flight-schedule'),
            'view_item'             => __('View Flight', 'seo-flight-schedule'),
            'view_items'            => __('View Flights', 'seo-flight-schedule'),
            'search_items'          => __('Search Flights', 'seo-flight-schedule'),
            'not_found'             => __('Flight Not found', 'seo-flight-schedule'),
            'not_found_in_trash'    => __('Flight Not found in Trash', 'seo-flight-schedule'),
            'featured_image'        => __('Featured Image', 'seo-flight-schedule'),
            'set_featured_image'    => __('Set featured image', 'seo-flight-schedule'),
            'remove_featured_image' => __('Remove featured image', 'seo-flight-schedule'),
            'use_featured_image'    => __('Use as featured image', 'seo-flight-schedule'),
            'insert_into_item'      => __('Insert into item', 'seo-flight-schedule'),
            'uploaded_to_this_item' => __('Uploaded to this item', 'seo-flight-schedule'),
            'items_list'            => __('Flights list', 'seo-flight-schedule'),
            'items_list_navigation' => __('Flights list navigation', 'seo-flight-schedule'),
            'filter_items_list'     => __('Filter Flights list', 'seo-flight-schedule'),
        );
        $rewrite = array(
            'slug'                  => 'flight',
            'with_front'            => true,
            'pages'                 => true,
            'feeds'                 => true,
        );
        $args = array(
            'label'                 => __('Flight', 'seo-flight-schedule'),
            'description'           => __('Post type for Flights', 'seo-flight-schedule'),
            'labels'                => $labels,
            'supports'              => array('title', 'editor', 'trackbacks', 'custom-fields', 'page-attributes', 'post-formats'),
            'taxonomies'            => array('country-taxonomy', 'state-taxonomy', 'city-taxonomy', 'airport-taxonomy', 'airline-taxonomy'),
            'hierarchical'          => true,
            'public'                => true,
            'show_ui'               => true,
            'show_in_menu'          => 'seo-flight-schedule',
            'menu_position'         => 5,
            'menu_icon'             => 'dashicons-airplane',
            'show_in_admin_bar'     => true,
            'show_in_nav_menus'     => true,
            'can_export'            => true,
            'has_archive'           => true,
            'exclude_from_search'   => false,
            'publicly_queryable'    => true,
            'rewrite'               => $rewrite,
            'capability_type'       => 'post',
        );
        register_post_type('post_type_flights', $args);
}
add_action('init', 'register_my_custom_post_types');

function add_seo_flight_scheduling_menu() {
    add_menu_page(
        'SEO Flight Scheduling', 
        'SEO Flight Scheduling', 
        'manage_options', 
        'seo-flight-schedule',
        '', 
        'dashicons-airplane', 
        6
    );
}
add_action('admin_menu', 'add_seo_flight_scheduling_menu');

function add_taxonomies_to_menu() {
    // add_submenu_page(
    //     'seo-flight-schedule',            // El slug del menú padre
    //     'Manage Locations',                 // Título de la página
    //     'Locations',                        // Título del menú
    //     'manage_options',                   // Capacidad necesaria para ver este menú
    //     'edit-tags.php?taxonomy=location'  // La URL para gestionar la taxonomía
    // );
    add_submenu_page(
        'seo-flight-schedule',
        'Manage Countries Taxonomies',
        'Countries Taxonomy',
        'manage_options',
        'edit-tags.php?taxonomy=country-taxonomy'
    );
    add_submenu_page(
        'seo-flight-schedule',
        'Manage States Taxonomies',
        'States Taxonomy',
        'manage_options',
        'edit-tags.php?taxonomy=state-taxonomy'
    );
    add_submenu_page(
        'seo-flight-schedule',
        'Manage Cities Taxonomies',
        'Cities Taxonomy',
        'manage_options',
        'edit-tags.php?taxonomy=city-taxonomy'
    );
    add_submenu_page(
        'seo-flight-schedule',
        'Manage Airports Taxonomies',
        'Airports Taxonomy',
        'manage_options',
        'edit-tags.php?taxonomy=airport-taxonomy'
    );
     add_submenu_page(
        'seo-flight-schedule',
        'Manage Airlines Taxonomies',
        'Airlines Taxonomy',
        'manage_options',
        'edit-tags.php?taxonomy=airline-taxonomy'
    );
}
add_action('admin_menu', 'add_taxonomies_to_menu');

function admin_script_for_custom_taxonomy_menu() {
    global $parent_file;
    // if (get_current_screen()->taxonomy == 'location') {
    //     $parent_file = 'seo-flight-schedule';
    // }
    if (get_current_screen()->taxonomy == 'country-taxonomy') {
        $parent_file = 'seo-flight-schedule';
    }
    if (get_current_screen()->taxonomy == 'state-taxonomy') {
        $parent_file = 'seo-flight-schedule';
    }
    if (get_current_screen()->taxonomy == 'city-taxonomy') {
        $parent_file = 'seo-flight-schedule';
    }
    if (get_current_screen()->taxonomy == 'airport-taxonomy') {
        $parent_file = 'seo-flight-schedule';
    }
    if (get_current_screen()->taxonomy == 'airline-taxonomy') {
        $parent_file = 'seo-flight-schedule';
    }
}
add_action('admin_head', 'admin_script_for_custom_taxonomy_menu');


// Custom rewrite rules
// function custom_rewrite_rules() {
//     add_rewrite_rule(
//         '^location/([^/]+)/([^/]+)/([^/]+)/airport/([^/]+)/?$',
//         'index.php?location=$matches[3]&airport=$matches[4]',
//         'top'
//     );
// }
// add_action('init', 'custom_rewrite_rules');

// Custom post type link
// function custom_post_type_permalink($post_link, $post) {
//     if (($post->post_type == 'airport' || $post->post_type == 'airline' || $post->post_type == 'flight') && $taxonomy_terms = wp_get_object_terms($post->ID, 'location')) {
//         $terms = wp_get_object_terms($post->ID, 'location'); // Asegúrate de que 'location' es el slug correcto de la taxonomía
//         if (!is_wp_error($taxonomy_terms) && !empty($taxonomy_terms)) {
//             // Ordena los términos de más bajo a más alto en la jerarquía
//             usort($terms, function ($a, $b) {
//                 return $a->parent - $b->parent;
//             });
//             $term = array_pop($taxonomy_terms); // Obtén el término más bajo
//             $ancestors = array_reverse(get_ancestors($term->term_id, 'location', 'taxonomy')); // Obtén todos los ancestros
//             $ancestors[] = $term->term_id; // Incluye el término actual
//             $path = '';
//             foreach ($ancestors as $ancestor) {
//                 $term = get_term($ancestor, 'location');
//                 $path .= $term->slug . '/';
//             }
//             $post_link = home_url(user_trailingslashit('airport/' . $path . $post->post_name));
//         }
//     }
//     return $post_link;
// }
// add_filter('post_type_link', 'custom_post_type_permalink', 10, 4);

// function custom_post_type_link($post_link, $post, $leavename, $sample) {
//     if ($post->post_type == 'airports') {
//         // Recuperamos los términos asignados al post
//         $terms = wp_get_object_terms($post->ID, 'location');
        
//         // Verificamos si no hay errores y si hay términos asignados
//         if (!is_wp_error($terms) && !empty($terms)) {
//             // Asumimos que los términos están ordenados correctamente de padre a hijo
//             $slug = '';
//             foreach ($terms as $term) {
//                 if (isset($term->slug)) {
//                     $slug .= $term->slug . '/' . $slug;
//                 }
//             }
//             // Generamos el nuevo enlace con la estructura deseada
//             $post_link = home_url(user_trailingslashit($slug . 'airport/' . $post->post_name));
//         }
//     }
//     return $post_link;
// }
// add_filter('post_type_link', 'custom_post_type_link', 10, 4);


 function mi_plugin_activate() {
    global $wpdb;
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    $charset_collate = $wpdb->get_charset_collate();

    // Creación o actualización de la tabla airlines
    $sql_airlines = "CREATE TABLE {$wpdb->prefix}airlines (
        iata_code varchar(3) DEFAULT '',
        icao_code varchar(4) DEFAULT '',
        name varchar(255) NOT NULL,
        logo_url varchar(255) DEFAULT '',
        PRIMARY KEY (iata_code, icao_code)
    ) $charset_collate;";
    dbDelta($sql_airlines);

    // Creación o actualización de la tabla airports
    $sql_airports = "CREATE TABLE {$wpdb->prefix}airports (
        iata_code varchar(3) DEFAULT '',
        icao_code varchar(4) DEFAULT '',
        name varchar(255) NOT NULL,
        city varchar(255) DEFAULT '',
        timezone varchar(40),
        country varchar(255) DEFAULT '',
        PRIMARY KEY (iata_code, icao_code)
    ) $charset_collate;";
    dbDelta($sql_airports);

    // Creación o actualización de la tabla flights
    $sql_flights = "CREATE TABLE {$wpdb->prefix}flights (
        flight_iata varchar(7) DEFAULT '',
        flight_icao varchar(8) DEFAULT '',
        airline_iata varchar(3) NOT NULL,
        airline_icao varchar(4) DEFAULT '',
        dep_iata varchar(3) NOT NULL,
        dep_icao varchar(4) DEFAULT '',
        arr_iata varchar(3) NOT NULL,
        arr_icao varchar(4) DEFAULT '',
        dep_time_ts bigint DEFAULT 0,
        arr_time_ts bigint DEFAULT 0,
        status varchar(20) DEFAULT '',
        flight_number varchar(10) DEFAULT '',
        dep_gate varchar(10) DEFAULT '',
        arr_gate varchar(10) DEFAULT '',
        dep_delayed int DEFAULT 0,
        arr_delayed int DEFAULT 0,
        duration int DEFAULT 0,
        updated_time datetime NOT NULL DEFAULT current_timestamp(),
        PRIMARY KEY (flight_iata, flight_icao)
    ) $charset_collate;";
    dbDelta($sql_flights);

    $sql_schedules = "CREATE TABLE {$wpdb->prefix}schedules (
        id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
        iata_code varchar(3) NOT NULL DEFAULT '',
        icao_code varchar(4) NOT NULL DEFAULT '',
        airline_iata varchar(3) NOT NULL DEFAULT '',
        airline_icao varchar(4) NOT NULL DEFAULT '',
        schedule_type enum('departure', 'arrival') NOT NULL,
        offset int NOT NULL DEFAULT 0,
        updated_time datetime NOT NULL DEFAULT current_timestamp(),
        last_page boolean DEFAULT false,
        PRIMARY KEY (id),
        UNIQUE KEY idx_iata_type (iata_code, icao_code, airline_iata, airline_icao, schedule_type, offset)
    ) $charset_collate;";
    dbDelta($sql_schedules);

    $sql_schedule_details = "CREATE TABLE {$wpdb->prefix}schedule_details (
        id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
        schedule_id bigint(20) UNSIGNED NOT NULL,
        offset_page int NOT NULL DEFAULT 0,
        flight_iata varchar(7) DEFAULT '',
        flight_icao varchar(8) DEFAULT '',
        airline_iata varchar(3) DEFAULT '',
        airline_icao varchar(4) DEFAULT '',
        airline_name varchar(255) DEFAULT '',
        airport varchar(255) DEFAULT '',
        depart varchar(40) DEFAULT '',
        arrive varchar(40) DEFAULT '',
        dep_iata varchar(3) DEFAULT '',
        dep_icao varchar(4) DEFAULT '',
        dep_city varchar(40) DEFAULT '',
        arr_iata varchar(3) DEFAULT '',
        arr_icao varchar(4) DEFAULT '',
        arr_city varchar(40) DEFAULT '',
        tz_dep varchar(40) DEFAULT '',
        tz_arr varchar(40) DEFAULT '',
        status varchar(20) DEFAULT '',
        PRIMARY KEY (id),
        FOREIGN KEY (schedule_id) REFERENCES {$wpdb->prefix}schedules(id) ON DELETE CASCADE
    ) $charset_collate;";
    dbDelta($sql_schedule_details);    

    // Intenta cargar datos JSON de aeropuertos
    $airportJson = file_get_contents(plugin_dir_path(__FILE__) . 'airports.json');


    if ($airportJson === false) {
        error_log('Error al leer el archivo de aeropuertos');
        return;
    }

    $airports = json_decode($airportJson, true);

    if (!is_array($airports) || !isset($airports['response'])){
        error_log('Error al decodificar el archivo JSON de aeropuertos o la clave \'response\' no está presente');
        return;
    }

    $airports_table = $wpdb->prefix . 'airports';
    foreach ($airports['response'] as $airport) {
        $result = $wpdb->insert(
            $airports_table,
            [
                'name' => $airport['name'],
                'iata_code' => $airport['iata'],
                'icao_code' => $airport['icao'],
                'country' => $airport['country'],
                'city' => $airport['city'],
                'timezone' => $airport['tz']
            ],
            ['%s', '%s', '%s', '%s', '%s', '%s']
        );

        if ($result === false) {
            error_log('Error al insertar aeropuerto: ' . $wpdb->last_error);
        }
    }

    // Intenta cargar datos JSON de aerolíneas
    $airlineJson = file_get_contents(plugin_dir_path(__FILE__) . 'airlines.json');
    
    if ($airlineJson === false) {
        error_log('Error al leer el archivo de aerolíneas');
        return;
    }

    $airlines = json_decode($airlineJson, true);

    if (!is_array($airlines) || !isset($airlines['response'])){
        error_log('Error al decodificar el archivo JSON de aeropuertos o la clave \'response\' no está presente');
        return;
    }
    $airlines_table = $wpdb->prefix . 'airlines';
    foreach ($airlines['response'] as $airline) {
        $result = $wpdb->insert(
            $airlines_table,
            [
                'name' => $airline['name'],
                'iata_code' => $airline['iata_code'],
                'icao_code' => $airline['icao_code'],
                'logo_url' => "https://airlabs.co/img/airline/m/{$airline['iata_code']}.png"
            ],
            ['%s', '%s', '%s', '%s']
        );

        if ($result === false) {
            error_log('Error al insertar aeropuerto: ' . $wpdb->last_error);
        }
    }

    update_option('mi_plugin_db_message', 'Tablas de Mi Plugin React creadas con éxito.');

    register_my_custom_post_types();
    flush_rewrite_rules();
}
register_activation_hook(__FILE__, 'mi_plugin_activate');


//  function mi_plugin_show_db_message() {
//      $message = get_option('mi_plugin_db_message');
//      if (!empty($message)) {
//          echo "<script type='text/javascript'>console.log('" . esc_js($message) . "');</script>";
//          // Borra el mensaje una vez mostrado para no repetirlo en futuras cargas de página
//          delete_option('mi_plugin_db_message');
//      }
//  }
//  add_action('wp_footer', 'mi_plugin_show_db_message');

add_action('rest_api_init', function () {
    register_rest_route('mi-plugin/v1', '/fetch-flight-data', array(
      'methods' => 'GET',
      'callback' => 'mi_plugin_fetch_flight_data',
      'args' => array(
        'type' => array(
          'required' => true,
          'validate_callback' => function ($param, $request, $key) {
            return in_array($param, ['departures', 'arrivals', 'flight']);
          }
        ),
        'airportCode' => array('required' => false),
        'flight' => array('required' => false),
        'flight_codeType' => array(
          'required' => false,
          'validate_callback' => function ($param, $request, $key) {
            return in_array($param, ['iata', 'icao']);
          }
        ),
        'airp_codeType' => array(
          'required' => false,
          'validate_callback' => function ($param, $request, $key) {
            return in_array($param, ['iata', 'icao']);
          }
        ),
        'airlineCode' => array('required' => false),
        'airl_codeType' => array(
          'required' => false,
          'validate_callback' => function ($param, $request, $key) {
            return in_array($param, ['iata', 'icao']);
          }
        ),
        'status' => array('required' => false),
        'offset' => array('required' => false),
      ),
      'permission_callback' => '__return_true'
    ));
  });

function mi_plugin_fetch_flight_data($request) {
    global $wpdb;
    $apiKey = get_option('mi_plugin_api_key');
    $exp_data = get_option('mi_plugin_data_expiration', 30);
    $exp_data_seconds = $exp_data * 60;

    if (!$apiKey) {
        return new WP_Error('api_key_not_set', 'API Key no configurado en el plugin.', ['status' => 500]);
    }

    $type = $request->get_param('type');
    $airportCode = $request->get_param('airportCode');
    $flight = $request->get_param('flight');
    $flight_codeType = $request->get_param('flight_codeType');
    $airp_codeType = $request->get_param('airp_codeType');
    $airlineCode = $request->get_param('airlineCode');
    $airl_codeType = $request->get_param('airl_codeType');
    $status = $request->get_param('status');
    $offset = $request->get_param('offset');

    // Tablas de la base de datos
    $flights_table = $wpdb->prefix . 'flights';
    $airports_table = $wpdb->prefix . 'airports';
    $airlines_table = $wpdb->prefix . 'airlines';

    $apiUrl = 'https://airlabs.co/api/v9/';
    $apiImgUrl = 'https://airlabs.co/img/airline/m/';
    // $apiImgUrl = "";
    // Dependiendo del tipo de consulta, se define la lógica
    switch ($type) {
        case 'flight':
            // Buscar en la base de datos por flight_iata o flight_icao
            $codeType = ($flight_codeType === 'iata') ? 'flight_iata' : 'flight_icao';
            $airlineApi = $airl_codeType === 'iata' ? "iata_code={$airlineCode}" : "icao_code={$airlineCode}";

            $flightData = $wpdb->get_row($wpdb->prepare(
                "SELECT * FROM {$flights_table} WHERE {$codeType} = %s",
                $flight
            ), ARRAY_A);

            if ($flightData && strtotime($flightData["updated_time"]) > (time() - $exp_data_seconds)) {
                // Si los datos existen en la base de datos
                if ($airlineCode !== '') {
                    $codeType = ($airl_codeType === 'iata') ? 'iata_code' : 'icao_code';
                    $codeValue = ($airl_codeType === 'iata') ? $flightData['airline_iata'] : $flightData['airline_icao'];
                
                    $airlineData = $wpdb->get_row($wpdb->prepare(
                        "SELECT name, logo_url FROM {$airlines_table} WHERE {$codeType} = %s", 
                        $codeValue
                    ), ARRAY_A);
                }
                

                // if(!$airlineData && ($flightData['airline_iata'] !== '' || $flightData['airline_icao'] !== '')) {
                //     $response = wp_remote_get("{$apiUrl}airlines?{$airlineApi}&api_key={$apiKey}");
                //     if (!is_wp_error($response) && wp_remote_retrieve_response_code($response) == 200) {
                //         $data = json_decode(wp_remote_retrieve_body($response), true);
                //         if (!empty($data['response'])) {
                //             $airlineData = $data['response'][0];
                //             $wpdb->replace(
                //                 $airlines_table,
                //                 [
                //                     'iata_code' => $airlineData['iata_code'],
                //                     'icao_code' => $airlineData['icao_code'],
                //                     'name' => $airlineData['name'],
                //                     'logo_url' => "{$apiImgUrl}{$airlineData['iata_code']}.png",
                //                 ],
                //                 ['%s', '%s', '%s', '%s']
                //             );
                //         }
                //     }                    
                // }
                
                if (!empty($flightData['dep_iata']) || !empty($flightData['dep_icao'])) {
                    $airportCode = !empty($flightData['dep_iata']) ? $flightData['dep_iata'] : $flightData['dep_icao'];
                    $codeType = !empty($flightData['dep_iata']) ? 'iata_code' : 'icao_code';
                
                    $depAirportData = $wpdb->get_row($wpdb->prepare(
                        "SELECT name, city FROM {$airports_table} WHERE {$codeType} = %s", 
                        $airportCode
                    ), ARRAY_A);
                }
                
                if (!empty($flightData['arr_iata']) || !empty($flightData['arr_icao'])) {
                    $airportCode = !empty($flightData['arr_iata']) ? $flightData['arr_iata'] : $flightData['arr_icao'];
                    $codeType = !empty($flightData['arr_iata']) ? 'iata_code' : 'icao_code';
                
                    $arrAirportData = $wpdb->get_row($wpdb->prepare(
                        "SELECT name, city FROM {$airports_table} WHERE {$codeType} = %s", 
                        $airportCode
                    ), ARRAY_A);
                }

                $response = [
                    'airlineLogo' => "{$apiImgUrl}{$flightData['airline_iata']}.png",
                    'flightIata' => $flightData['flight_iata'],
                    'flightIcao' => $flightData['flight_icao'],
                    'flightNumber' => $flightData['flight_number'],
                    'status' => $flightData['status'],
                    'depIata' => $flightData['dep_iata'],
                    'depGate' => $flightData['dep_gate'],
                    'depTimeTs' => $flightData['dep_time_ts'],
                    'depDelayed' => $flightData['dep_delayed'],
                    'arrIata' => $flightData['arr_iata'],
                    'arrGate' => $flightData['arr_gate'],
                    'arrTimeTs' => $flightData['arr_time_ts'],
                    'arrDelayed' => $flightData['arr_delayed'],
                    'duration' => $flightData['duration'],
                    'airlineName' => $airlineData['name'],
                    'depAirportName' => $depAirportData['name'],
                    'depCity' => $depAirportData['city'],
                    'arrAirportName' => $arrAirportData['name'],
                    'arrCity' => $arrAirportData['city'],
                ];
                return new WP_REST_Response($response, 200);
            } else {
                // Si no existen en la base, consulta la API y guarda los resultados
                // $fullUrl = "https://airlabs.co/api/v9/flight?flight_iata={$flight}&api_key={$apiKey}";
                $flightApi = $flight_codeType === 'iata' ? "flight_iata={$flight}" : "flight_icao={$flight}";
                $fullUrl = "{$apiUrl}flight?{$flightApi}&api_key={$apiKey}";
                $response = wp_remote_get($fullUrl);
                if (is_wp_error($response)) {
                    return new WP_Error('api_fetch_error', 'Error al realizar el fetch al API externo.', ['status' => 500]);
                }
                $data = json_decode(wp_remote_retrieve_body($response), true);
                if (isset($data['response'])) {
                    $flightData = $data['response'];
                    $airlineLogoUrl = "{$apiImgUrl}{$flightData['airline_iata']}.png";

                    $wpdb->replace(
                        $airlines_table,
                        [
                            'iata_code' => $flightData['airline_iata'],
                            'icao_code' => $flightData['airline_icao'],
                            'name' => $flightData['airline_name'],
                            'logo_url' => $airlineLogoUrl,
                        ],
                        ['%s', '%s', '%s', '%s']
                    );

                    $wpdb->replace(
                        $flights_table,
                        [
                            'flight_iata' => $flightData['flight_iata'],
                            'flight_icao' => $flightData['flight_icao'],
                            'flight_number' => $flightData['flight_number'],
                            'airline_iata' => $flightData['airline_iata'],
                            'airline_icao' => $flightData['airline_icao'],
                            'status' => $flightData['status'],
                            'dep_iata' => $flightData['dep_iata'],
                            'dep_icao' => $flightData['dep_icao'],
                            'dep_gate' => $flightData['dep_gate'],
                            'dep_time_ts' => $flightData['dep_time_ts'],
                            'dep_delayed' => $flightData['dep_delayed'],
                            'arr_iata' => $flightData['arr_iata'],
                            'arr_icao' => $flightData['arr_icao'],
                            'arr_gate' => $flightData['arr_gate'],
                            'arr_time_ts' => $flightData['arr_time_ts'],
                            'arr_delayed' => $flightData['arr_delayed'],
                            'duration' => $flightData['duration'],
                            'updated_time' => current_time('mysql', 1),
                        ],
                        ['%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%d', '%d', '%s', '%s', '%s', '%d', '%d', '%d', '%s']
                    );
                    
                    $formatedData = [
                        'airlineLogo' => $airlineLogoUrl,
                        'flightIata' => $flightData['flight_iata'],
                        'flightIcao' => $flightData['flight_icao'],
                        'flightNumber' => $flightData['flight_number'],
                        'status' => $flightData['status'],
                        'depIata' => $flightData['dep_iata'],
                        'depGate' => $flightData['dep_gate'],
                        'depTimeTs' => $flightData['dep_time_ts'],
                        'depDelayed' => $flightData['dep_delayed'],
                        'arrIata' => $flightData['arr_iata'],
                        'arrGate' => $flightData['arr_gate'],
                        'arrTimeTs' => $flightData['arr_time_ts'],
                        'arrDelayed' => $flightData['arr_delayed'],
                        'duration' => $flightData['duration'],
                        'airlineName' => $flightData['airline_name'],
                        'depAirportName' => $flightData['dep_name'],
                        'depCity' => $flightData['dep_city'],
                        'arrAirportName' => $flightData['arr_name'],
                        'arrCity' => $flightData['arr_city'],
                    ];
                    return new WP_REST_Response($formatedData, 200);
                }
            }
            break;
            case 'departures':
                case 'arrivals':
                    $isDepartures = $type === 'departures';
                    $scheduleType = $isDepartures ? 'departure' : 'arrival';
                    $filter = !empty($status) ? $status : '';

                    if (!empty($airlineCode)) {
                        // Consulta cuando airline_iata o airline_icao están presentes
                        $schedule = $wpdb->get_row($wpdb->prepare(
                            "SELECT id, updated_time, offset, last_page FROM {$wpdb->prefix}schedules
                            WHERE (iata_code = %s OR icao_code = %s)
                            AND schedule_type = %s
                            AND (airline_iata = %s OR airline_icao = %s)
                            AND offset = %d", 
                            $airportCode, $airportCode, $scheduleType, $airlineCode, $airlineCode, $offset
                        ), ARRAY_A);
                        // error_log('ERROR_LOG_1: Schedule with airline code: ' . json_encode($schedule));

                    } else {
                       // Consulta cuando airline_iata y airline_icao están vacíos
                        $schedule = $wpdb->get_row($wpdb->prepare(
                            "SELECT id, updated_time, offset, last_page FROM {$wpdb->prefix}schedules
                            WHERE (iata_code = %s OR icao_code = %s)
                            AND schedule_type = %s
                            AND airline_iata = 'N/A'
                            AND airline_icao = 'N/A'
                            AND offset = %d",
                            $airportCode, $airportCode, $scheduleType, $offset
                        ), ARRAY_A);
                        // error_log('ERROR_LOG_2: Schedule without airline code: ' . json_encode($schedule));
                    }

                    if ($schedule && $schedule['last_page'] && !(((strtotime($schedule['updated_time'])) + $exp_data_seconds) > time())) {
                        return new WP_REST_Response(null, 204);
                    }

                    if ($schedule && (((strtotime($schedule['updated_time'])) + $exp_data_seconds) > time())) {
                        // Buscar detalles asociados en schedule_details
                        $query = "SELECT * FROM {$wpdb->prefix}schedule_details WHERE schedule_id = %d AND offset_page = %d";

                        $params = [$schedule['id'], $schedule['offset']];
                
                        // Añadir filtro por airlineCode si está presente
                        if (!empty($airlineCode)) {
                            $query .= " AND " . ($airl_codeType === 'iata' ? 'airline_iata' : 'airline_icao') . " = %s";
                            $params[] = $airlineCode;
                        }
                
                        // Añadir filtro por status si está presente
                        if (!empty($filter)) {
                            $query .= " AND status = %s";
                            $params[] = $filter;
                        }

                        $flightDetails = $wpdb->get_results($wpdb->prepare($query, $params), ARRAY_A);
                
                        if (!empty($flightDetails)) {
                            // Formatear los detalles del vuelo para la respuesta
                            $formattedFlights = array_map(function ($flight) {
                                global $wpdb;
                                $arrAirport = $wpdb->get_var($wpdb->prepare(
                                    "SELECT name FROM {$wpdb->prefix}airports WHERE iata_code = %s OR icao_code = %s",
                                    $flight['arr_iata'], $flight['arr_icao']
                                ));
                                $depAirport = $wpdb->get_var($wpdb->prepare(
                                    "SELECT name FROM {$wpdb->prefix}airports WHERE iata_code = %s OR icao_code = %s",
                                    $flight['dep_iata'], $flight['dep_icao']
                                ));
                                // $airlineName = $wpdb->get_var($wpdb->prepare(
                                //     "SELECT name FROM {$wpdb->prefix}airlines WHERE iata_code = %s OR icao_code = %s",
                                //     $flight['airline_iata'], $flight['airline_icao']
                                // ));
                                return [
                                    'flight' => !empty($flight['flight_iata']) ? $flight['flight_iata'] : $flight['flight_icao'],
                                    'airport' => $flight['airport'],
                                    'airline_name' => $flight['airline_name'],
                                    'airline_code' => !empty($flight['airline_iata']) ? $flight['airline_iata'] : $flight['airline_icao'],
                                    'depart' => $flight['depart'],
                                    'arrive' => $flight['arrive'],
                                    'arrAirport' => $arrAirport,
                                    'depAirport' => $depAirport,
                                    'dep_code' => !empty($flight['dep_iata']) ? $flight['dep_iata'] : $flight['dep_icao'],
                                    'dep_city' => $flight['dep_city'],
                                    'arr_code' => !empty($flight['arr_icao']) ? $flight['arr_iata'] : $flight['arr_icao'],
                                    'arr_city' => $flight['arr_city'],
                                    'tz_dep' => $flight['tz_dep'],
                                    'tz_arr' => $flight['tz_arr'],
                                    'status' => $flight['status'],
                                ];
                            }, $flightDetails);
                
                            return new WP_REST_Response($formattedFlights, 200);
                        } else if (empty($flightDetails) && $status){
                            return new WP_REST_Response([], 200);
                        }else{
                            return new WP_REST_Response(['message' => 'No flight details available'], 404);
                        }
                    }

                    $airpCodeType = $airp_codeType === 'iata' ? 'iata_code' : 'icao_code';
                    // if (isset($schedulesData['response'])) {
                        if (!$schedule) {
                            // Obtener ambos códigos de aeropuertos desde la tabla de aeropuertos
                            $airportData = $wpdb->get_row($wpdb->prepare(
                                "SELECT iata_code, icao_code FROM {$wpdb->prefix}airports WHERE {$airpCodeType} = %s",
                                $airportCode
                            ));
                            if (!empty($airlineCode)){
                                $airlCodeType = $airl_codeType === 'iata' ? 'iata_code' : 'icao_code';
                                $airlineData = $wpdb->get_row($wpdb->prepare(
                                    "SELECT iata_code, icao_code FROM {$wpdb->prefix}airlines WHERE {$airlCodeType} = %s",
                                    $airlineCode
                                ));
                            }
                            // error_log('ERROR_LOG_3: Schedule not found: ' . json_encode($schedule));
                            $wpdb->insert(
                                "{$wpdb->prefix}schedules",
                                [
                                    'schedule_type' => $scheduleType,
                                    'updated_time' => current_time('mysql', 1),
                                    'iata_code' => $airportData->iata_code,
                                    'icao_code' => $airportData->icao_code,
                                    'airline_iata' => $airlineData->iata_code ?? 'N/A',
                                    'airline_icao'=> $airlineData->icao_code ?? 'N/A',
                                    'offset' => $offset,
                                ],
                                ['%s', '%s', '%s', '%s', '%s', '%s', '%d']
                            );                    
                                $schedule['id'] = $wpdb->insert_id;
                                $schedule['offset'] = $offset;
                        } else{
                            // Obtener el registro actual para comparar el updated_time
                            // error_log('ERROR_LOG_4: Schedule found: ' . json_encode($schedule));
                            if ($schedule['id'] && (strtotime($schedule['updated_time']) + $exp_data_seconds) < time()) {
                                // Iniciar transacción
                                $wpdb->query('START TRANSACTION');

                                // Actualizar el registro en la tabla schedules
                                $updated = $wpdb->update(
                                    "{$wpdb->prefix}schedules",
                                    ['updated_time' => current_time('mysql', 1)],
                                    ['id' => $schedule['id']],
                                    ['last-page' => false],
                                    ['%s'],
                                    ['%d'],
                                    ['%d'],
                                );

                                // Verificar si la actualización fue exitosa
                                if ($updated !== false) {
                                    // Eliminar los registros asociados en schedule_details
                                    $deleted = $wpdb->delete(
                                        "{$wpdb->prefix}schedule_details",
                                        ['schedule_id' => $schedule['id']],
                                        ['%d']
                                    );

                                    // Verificar si la eliminación fue exitosa
                                    if ($deleted !== false) {
                                        // Todo bien, hacer COMMIT de la transacción
                                        $wpdb->query('COMMIT');
                                    } else {
                                        // Error al eliminar, hacer ROLLBACK de la transacción
                                        $wpdb->query('ROLLBACK');
                                        error_log('Error al eliminar detalles del horario: ' . $wpdb->last_error);
                                    }
                                } else {
                                    // Error al actualizar, hacer ROLLBACK de la transacción
                                    $wpdb->query('ROLLBACK');
                                    error_log('Error al actualizar el horario: ' . $wpdb->last_error);
                                }
                            }
                        }
                                        
                    // Si no hay información reciente, consulta al API de Airlabs
                    $endpointUrl = "{$apiUrl}schedules?" . ($isDepartures ? "dep_" : "arr_") . "{$airp_codeType}={$airportCode}&api_key={$apiKey}&offset={$offset}";
                
                    if (!empty($airlineCode)) {
                        $endpointUrl .= "&airline_" . ($airl_codeType === 'iata' ? 'iata' : 'icao') . "={$airlineCode}";
                    }
                
                    $apiResponse = wp_remote_get($endpointUrl);
                
                    if (is_wp_error($apiResponse)) {
                        return new WP_Error('api_fetch_error', 'Error al obtener datos del API de Airlabs.', ['status' => 500]);
                    }
                
                    $schedulesData = json_decode(wp_remote_retrieve_body($apiResponse), true);

                    if (empty($schedulesData['response'])) {
                        $result = $wpdb->update(
                            "{$wpdb->prefix}schedules",
                            ['last_page' => true],
                            ['id' => $schedule['id']],
                            ['%d'],
                            ['%d']
                        );
                        if ($result) {
                            return new WP_REST_Response(null, 204); 
                        } else {
                            return new WP_Error("api_fetch_error", "Error al actualizar el último estado de la página.", ['status' => 500]);
                        }
                    }

                    if (isset($schedulesData['response'])) {
                        $formattedFlights = [];
                        foreach ($schedulesData['response'] as $flightData) {
                
                            $arrCode = !empty($flightData['arr_iata']) ? $flightData['arr_iata'] : $flightData['arr_icao'];
                            $depCode = !empty($flightData['dep_iata']) ? $flightData['dep_iata'] : $flightData['dep_icao'];
                            $airportCodeToCheck = $isDepartures ? $arrCode : $depCode;
              
                            $airportName = $wpdb->get_var($wpdb->prepare(
                                "SELECT name FROM {$wpdb->prefix}airports WHERE iata_code = %s OR icao_code = %s",
                                $airportCodeToCheck, $airportCodeToCheck
                            ));

                            $airline_name = $wpdb->get_var($wpdb->prepare(
                                "SELECT name FROM {$wpdb->prefix}airlines WHERE iata_code = %s OR icao_code = %s",
                                $flightData['airline_iata'], $flightData['airline_icao']
                            ));
                            
                            $dep_city = $wpdb->get_var($wpdb->prepare(
                                "SELECT city FROM {$wpdb->prefix}airports WHERE iata_code = %s OR icao_code = %s",
                                $flightData['dep_iata'], $flightData['dep_icao']
                            ));

                            $arr_city = $wpdb->get_var($wpdb->prepare(
                                "SELECT city FROM {$wpdb->prefix}airports WHERE iata_code = %s OR icao_code = %s",
                                $flightData['arr_iata'], $flightData['arr_icao']
                            ));
                
                            $tz_arr = $wpdb->get_var($wpdb->prepare(
                                "SELECT timezone FROM {$wpdb->prefix}airports WHERE iata_code = %s OR icao_code = %s",
                                $flightData['arr_iata'], $flightData['arr_icao']
                            ));
                
                            $tz_dep = $wpdb->get_var($wpdb->prepare(
                                "SELECT timezone FROM {$wpdb->prefix}airports WHERE iata_code = %s OR icao_code = %s",
                                $flightData['dep_iata'], $flightData['dep_icao']
                            ));
                
                            $insert_result = $wpdb->insert(
                                "{$wpdb->prefix}schedule_details",
                                [
                                    'schedule_id' => $schedule['id'],
                                    'offset_page' => $offset,
                                    'flight_iata' => $flightData['flight_iata'] ?? '',
                                    'flight_icao' => $flightData['flight_icao'] ?? '',
                                    'airline_iata' => $flightData['airline_iata'] ?? '',
                                    'airline_icao' => $flightData['airline_icao'] ?? '',
                                    'airport' => $airportName ?? '',
                                    'airline_name' => $airline_name ?? '',
                                    'depart' => $flightData['dep_time_utc'] ?? '',
                                    'arrive' => $flightData['arr_time_utc'] ?? '',
                                    'dep_iata' => $flightData['dep_iata'] ?? '',
                                    'dep_icao' => $flightData['dep_icao'] ?? '',
                                    'dep_city' => $dep_city ?? '',
                                    'arr_iata' => $flightData['arr_iata'] ?? '',
                                    'arr_icao' => $flightData['arr_icao'] ?? '',
                                    'arr_city' => $arr_city ?? '',
                                    'tz_dep' => $tz_dep ?? '',
                                    'tz_arr' => $tz_arr ?? '',
                                    'status' => $flightData['status'] ?? ''
                                ],
                                ['%d', '%d', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s']
                            );
                            
                
                            if ($insert_result !== false) {
                                if (!empty($filter) && $flightData['status'] !== $filter) {
                                    continue;
                                }
                                $arrAirport = $wpdb->get_var($wpdb->prepare(
                                    "SELECT name FROM {$wpdb->prefix}airports WHERE iata_code = %s OR icao_code = %s",
                                    $flightData['arr_iata'], $flightData['arr_icao']
                                ));
    
                                $depAirport = $wpdb->get_var($wpdb->prepare(
                                    "SELECT name FROM {$wpdb->prefix}airports WHERE iata_code = %s OR icao_code = %s",
                                    $flightData['dep_iata'], $flightData['dep_icao']
                                ));
                                
                                $formattedFlights[] = [
                                    'flight' => !empty($flightData['flight_iata']) ? $flightData['flight_iata'] : $flightData['flight_icao'],
                                    'airport' => $airportName,
                                    'depart' => $flightData['dep_time_utc'] ?? '',
                                    'arrive' => $flightData['arr_time_utc'] ?? '',
                                    'airline_name' => $airline_name,
                                    'airline_code' => !empty($flightData['airline_iata']) ? $flightData['airline_iata'] : $flightData['airline_icao'],
                                    'arrAirport' => $arrAirport,
                                    'depAirport' => $depAirport,
                                    'dep_code' => !empty($flightData['dep_iata']) ? $flightData['dep_iata'] : $flightData['dep_icao'],
                                    'dep_city' => $dep_city,
                                    'arr_code' => !empty($flightData['arr_iata']) ? $flightData['arr_iata'] : $flightData['arr_icao'],
                                    'arr_city' => $arr_city,
                                    'tz_dep' => $tz_dep,
                                    'tz_arr' => $tz_arr,
                                    'status' => $flightData['status'],
                                ];
                            } else {
                                error_log('Error al insertar en schedule_details: ' . $wpdb->last_error);
                            }
                        }
                        if (!empty($formattedFlights)) {
                            return new WP_REST_Response($formattedFlights, 200);
                        } else {
                            return new WP_Error('api_fetch_error', 'Error en guardar la informacion en la tabla schedule_details', ['status' => 404]);
                        }
                    } else {
                        error_log(''. $wpdb->last_error);
                        return new WP_Error('api_fetch_error', 'Error al obtener datos del API de Airlabs.', ['status' => 500]);
                    }
                    // Remove the unnecessary break statement
                    // break;
                
        default:
            return new WP_Error('invalid_request', 'Tipo de solicitud no válida.', ['status' => 400]);
    }
}

function enqueue_react_app_script() {
    wp_enqueue_script('mi-react-app-js', plugins_url('/build/mi-react-app.js', __FILE__), array(), '1.0', true);

    $db_message = get_option('mi_plugin_db_message', 'No hay mensaje disponible');

    $opciones = array(
        'apiKey' => get_option('mi_plugin_api_key'),
        'path' => get_option('mi_plugin_path'),
        'dbMessage' => $db_message, // Agrega el mensaje de la base de datos aquí
    );

    // Pasar todas las opciones al script de React como una variable global
    wp_localize_script('mi-react-app-js', 'phpVars', $opciones);

    // Opcional: borra el mensaje una vez que lo pasas, para no repetirlo
    delete_option('mi_plugin_db_message');
}
add_action('wp_enqueue_scripts', 'enqueue_react_app_script');


 function generar_shortcode_react_app($atts, $content, $tag) {
    // Atributos por defecto
    $atts = shortcode_atts([
        'iata_code' => '',
        'icao_code' => '',
        'size' => '10',
        'airline_iata' => '',
        'airline_icao' => '',
        'status' => '',
        'flight_iata' => '', 
        'flight_icao' => '',
    ], $atts);

    // Validación básica
    if (($tag == 'arrivals_app' || $tag == 'departures_app') && empty($atts['iata_code']) && empty($atts['icao_code'])) {
        return "Por favor, incluye al menos el IATA code o el ICAO code del aeropuerto para proceder.";
    }
    if($tag == 'numero-vuelo' && empty($atts['flight_iata']) && empty($atts['flight_icao'])) {
        return "Por favor, incluye al menos el IATA code o el ICAO code del vuelo para proceder.";
    }

    $type = $tag == 'departures_app' ? 'departures' : ($tag == 'arrivals_app' ? 'arrivals' : 'flight'); // Nuevo caso para 'vuelo'
    $airportCode = !empty($atts['iata_code']) ? $atts['iata_code'] : $atts['icao_code'];
    $airp_codeType = !empty($atts['iata_code']) ? 'iata' : 'icao'; //Definir el tipo de codigo del aeropuerto, iata o icao
    $airlineCode = !empty($atts['airline_iata']) ? $atts['airline_iata'] : $atts['airline_icao'];
    $airl_codeType = !empty($atts['airline_iata']) ? 'iata' : 'icao'; //Definir el tipo de codigo de la aerolinea, iata o icao
    $flightCode = !empty($atts['flight_iata']) ? $atts['flight_iata'] : $atts['flight_icao'];
    $flight_codeType = !empty($atts['flight_iata']) ? 'iata' : 'icao'; //Definir el tipo de codigo del vuelo, iata o icao
    $status = $atts['status'];

    // Recuperar los valores guardados en los ajustes del plugin

    return "<div class='react-app-container' data-react-app='mi-react-app' data-flight='{$flightCode}' data-flight-codetype='{$flight_codeType}' data-airport-code='{$airportCode}' data-airp-codetype='{$airp_codeType}' data-type='{$type}' data-size='{$atts['size']}' data-airline='{$airlineCode}' data-airl-codetype='{$airl_codeType}' data-status='{$status}'></div>";

}

add_shortcode('arrivals_app', 'generar_shortcode_react_app');
add_shortcode('departures_app', 'generar_shortcode_react_app');
add_shortcode('numero-vuelo', 'generar_shortcode_react_app'); // Registrar el nuevo shortcode

// Añadir la página de configuraciones y registrar las opciones
add_action('admin_menu', 'mi_plugin_menu');

function mi_plugin_menu() {
    add_options_page('Configuración del Plugin de Vuelos', 'Vuelos Settings', 'manage_options', 'mi-plugin-settings', 'mi_plugin_settings_page');
}

function mi_plugin_settings_page() {
    ?>
    <div class="wrap">
        <h2>Configuración del Plugin de Vuelos</h2>
        <form method="post" action="options.php">
            <?php
            settings_fields('mi-plugin-settings-group');
            do_settings_sections('mi-plugin-settings');
            submit_button();
            ?>
        </form>
    </div>
    <?php
}
function mi_plugin_docs_page() {
    ?>
    <div class="wrap">
        <h2>Documentación del Plugin de Vuelos</h2>
        <p>Aquí puedes encontrar cómo usar el plugin, consejos de integración y solución de problemas comunes.</p>

        <!-- Uso Básico -->
        <h3>Uso Básico</h3>
        <p>Para comenzar rápidamente con nuestro plugin, simplemente inserta uno de los siguientes shortcodes en cualquier página o entrada para mostrar información en tiempo real sobre vuelos.</p>

        <!-- Shortcodes -->
        <h3>Shortcodes Disponibles</h3>
        
        <!-- Llegadas -->
        <h4>Llegadas [arrivals_app]</h4>
        <p>Este shortcode muestra información sobre las llegadas a un aeropuerto específico. Utiliza los siguientes parámetros para personalizar la salida:</p>
        <ul>
            <li><strong>iata_code</strong>: Código IATA del aeropuerto. (opcional si se proporciona `icao_code`)</li>
            <li><strong>icao_code</strong>: Código ICAO del aeropuerto. (opcional si se proporciona `iata_code`)</li>
            <li><strong>size</strong>: Número de vuelos a mostrar.</li>
            <li><strong>airline_iata</strong>: Filtrar por código IATA de la aerolínea. (opcional)</li>
            <li><strong>airline_icao</strong>: Filtrar por código ICAO de la aerolínea. (opcional)</li>
            <li><strong>status</strong>: Filtrar vuelos por estado. (opcional) Valores posibles: 'scheduled', 'cancelled', 'active', 'landed'.</li>
        </ul>
        <p>
            <strong>Ejemplos:</strong>
            <ul>
                <li><code>[arrivals_app iata_code="JFK" size="5"]</code></li>
                <li><code>[arrivals_app iata_code="LAX" size="10" airline_iata="AA"]</code></li>
                <li><code>[arrivals_app icao_code="KMIA" size="15" status="cancelled"]</code></li>
            </ul> 
        </p>

        <!-- Salidas -->
        <h4>Salidas [departures_app]</h4>
        <p>Muestra información sobre las salidas desde un aeropuerto específico. Acepta los siguientes parámetros para personalización:</p>
        <ul>
            <li><strong>iata_code</strong>: Código IATA del aeropuerto. (opcional si se proporciona `icao_code`)</li>
            <li><strong>icao_code</strong>: Código ICAO del aeropuerto. (opcional si se proporciona `iata_code`)</li>
            <li><strong>size</strong>: Número de vuelos a mostrar.</li>
            <li><strong>airline_iata</strong>: Filtrar por código IATA de la aerolínea. (opcional)</li>
            <li><strong>airline_icao</strong>: Filtrar por código ICAO de la aerolínea. (opcional)</li>
            <li><strong>status</strong>: Filtrar vuelos por estado. (opcional) Valores posibles: 'scheduled', 'cancelled', 'active', 'landed'.</li>
        </ul>
        <p>
            <strong>Ejemplos:</strong>
            <ul>
                <li><code>[departures_app iata_code="LAX" size="10"]</code></li>
                <li><code>[departures_app iata_code="LAX" size="10" airline_iata="AA"]</code></li>
                <li><code>[departures_app icao_code="KMIA" size="15" status="landed"]</code></li>
            </ul> 
        </p>

        <!-- Número de Vuelo -->
        <h4>Número de Vuelo [numero-vuelo]</h4>
        <p>Obtiene información específica de un vuelo usando su código. Ideal para seguir vuelos individuales. Acepta los siguientes parámetros:</p>
        <ul>
            <li><strong>flight_iata</strong>: Código IATA del vuelo. (opcional si se proporciona `flight_icao`)</li>
            <li><strong>flight_icao</strong>: Código ICAO del vuelo. (opcional si se proporciona `flight_iata`)</li>
        </ul>
        <p><strong>Ejemplo:</strong> <code>[numero-vuelo flight_iata="AA123"]</code></p>

        <!-- Configuración -->
        <h3>Configuración</h3>
        <p>Si deseas configurar manualmente los permalinks a su gusto, debes descargar el plugin Permalink Manager.</p>
        <p>Con este plugin puedes configurar y estructurar los permalinks para cada post, page, media, etc. que hayas definido.</p>
        <p>Se puede descargar el plugin Permalink Manager <a href="https://wordpress.org/plugins/permalink-manager/">aquí</a></p>

        <!-- Soporte Técnico -->
        <h3>Soporte Técnico</h3>
        <p>Si encuentras problemas técnicos o necesitas ayuda personalizada, no dudes en contactar nuestro equipo de soporte a través de <a href="mailto:team@lccopen.tech">team@lccopen.tech</a>.</p>
    </div>
    <?php
}

// Hook para inicializar la configuración
add_action('admin_init', 'mi_plugin_settings_init');

function mi_plugin_settings_init() {
    // Registro de las configuraciones del plugin
    register_setting('mi-plugin-settings-group', 'mi_plugin_api_key');
    // register_setting('mi-plugin-settings-group', 'mi_plugin_path');
    register_setting('mi-plugin-settings-group', 'mi_plugin_data_expiration');

    // Añadir sección de configuración
    add_settings_section('mi-plugin-settings-section', 'Ajustes del API', 'mi_plugin_settings_section_callback', 'mi-plugin-settings');

    // Añadir campos de configuración
    add_settings_field('mi-plugin-api-key', 'API Key de AirLabs', 'mi_plugin_api_key_callback', 'mi-plugin-settings', 'mi-plugin-settings-section');
    // add_settings_field('mi-plugin-path', 'Path para Consultas', 'mi_plugin_path_callback', 'mi-plugin-settings', 'mi-plugin-settings-section');
    add_settings_field('mi-plugin-data-expiration', 'Tiempo de Expiración de Datos (minutos)', 'mi_plugin_data_expiration_callback', 'mi-plugin-settings', 'mi-plugin-settings-section');
}

function mi_plugin_settings_section_callback() {
    echo 'Ingresa tu API Key y el tiempo de expiración de los datos almacenados.';
}

function mi_plugin_api_key_callback() {
    $api_key = get_option('mi_plugin_api_key');
    echo "<input type='text' id='mi_plugin_api_key' name='mi_plugin_api_key' value='" . esc_attr($api_key) . "' />";
}

// function mi_plugin_path_callback() {
//     $path = get_option('mi_plugin_path');
//     echo "<input type='text' id='mi_plugin_path' name='mi_plugin_path' value='" . esc_attr($path) . "' />";
// }

function mi_plugin_data_expiration_callback() {
    $expiration = get_option('mi_plugin_data_expiration', 30); // Valor predeterminado de 30 minutos
    echo "<input type='number' id='mi_plugin_data_expiration' name='mi_plugin_data_expiration' value='" . esc_attr($expiration) . "' min='1' />";
}

// Función para añadir el enlace de configuración directamente en la página de plugins
function mi_plugin_add_settings_link($links) {
    $settings_link = '<a href="options-general.php?page=mi-plugin-settings">' . __('Settings') . '</a>';
    array_push($links, $settings_link);
    return $links;
}

function mi_plugin_add_admin_pages() {
    add_options_page(
        'Documentación del Plugin de Vuelos',  // Título de la página
        'Docs Plugin de Vuelos',              // Título del menú
        'manage_options',                     // Capacidad requerida
        'mi_plugin_docs_page',                // Slug del menú
        'mi_plugin_docs_page'                 // Función que muestra el contenido de la página
    );
}
add_action('admin_menu', 'mi_plugin_add_admin_pages');

function mi_plugin_add_docs_link($links) {
    $docs_link = '<a href="' . admin_url('admin.php?page=mi_plugin_docs_page') . '">' . __('Docs') . '</a>';
    array_push($links, $docs_link);  // Añade al final de los enlaces existentes
    return $links;
}


$plugin = plugin_basename(__FILE__);
add_filter("plugin_action_links_$plugin", 'mi_plugin_add_settings_link');
add_filter("plugin_action_links_$plugin", 'mi_plugin_add_docs_link');
?>