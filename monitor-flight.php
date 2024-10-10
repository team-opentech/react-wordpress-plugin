<?php

/**
 * Plugin Name: SEO Flight Schedule
 * Description: Muestra los vuelos de los aeropuertos y aerolineas.
 * Version: 2.0
 * Author: Opentech
 * Text Domain: seo-flight-schedule
 * Last Updated: 2024-08-09
 */

defined('ABSPATH') or die('¡Acceso directo no permitido!');

// Register Custom Post Type
function register_my_custom_post_types()
{
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
    register_taxonomy('country-taxonomy', array('airport', 'airline', 'flight', 'delayed-flight'), $args);

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
    register_taxonomy('state-taxonomy', array('airport', 'airline', 'flight', 'delayed-flight'), $args);

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
    register_taxonomy('city-taxonomy', array('airport', 'airline', 'flight', 'delayed-flight'), $args);

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
    register_taxonomy('airport-taxonomy', array('airport', 'airline', 'flight', 'delayed-flight'), $args);

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
    register_taxonomy('airline-taxonomy', array('airport', 'airline', 'flight', 'delayed-flight'), $args);

    // Register Custom Post Type Delayed Flights
    $labels = array(
        'name'                  => _x('Delayed Flights', 'Post Type General Name', 'seo-flight-schedule'),
        'singular_name'         => _x('Delayed Flight', 'Post Type Singular Name', 'seo-flight-schedule'),
        'menu_name'             => __('Delayed Flights', 'seo-flight-schedule'),
        'name_admin_bar'        => __('Delayed Flights', 'seo-flight-schedule'),
        'archives'              => __('Delayed Flight Archives', 'seo-flight-schedule'),
        'attributes'            => __('Delayed Flight Attributes', 'seo-flight-schedule'),
        'parent_item_colon'     => __('Parent Delayed Flight:', 'seo-flight-schedule'),
        'all_items'             => __('All Delayed Flights', 'seo-flight-schedule'),
        'add_new_item'          => __('Add New Delayed Flight', 'seo-flight-schedule'),
        'add_new'               => __('Add Delayed Flight', 'seo-flight-schedule'),
        'new_item'              => __('New Delayed Flight', 'seo-flight-schedule'),
        'edit_item'             => __('Edit Delayed Flight', 'seo-flight-schedule'),
        'update_item'           => __('Update Delayed Flight', 'seo-flight-schedule'),
        'view_item'             => __('View Delayed Flight', 'seo-flight-schedule'),
        'view_items'            => __('View Delayed Flights', 'seo-flight-schedule'),
        'search_items'          => __('Search Delayed Flights', 'seo-flight-schedule'),
        'not_found'             => __('Delayed Flight Not found', 'seo-flight-schedule'),
        'not_found_in_trash'    => __('Delayed Flight Not found in Trash', 'seo-flight-schedule'),
        'featured_image'        => __('Featured Image', 'seo-flight-schedule'),
        'set_featured_image'    => __('Set featured image', 'seo-flight-schedule'),
        'remove_featured_image' => __('Remove featured image', 'seo-flight-schedule'),
        'use_featured_image'    => __('Use as featured image', 'seo-flight-schedule'),
        'insert_into_item'      => __('Insert into item', 'seo-flight-schedule'),
        'uploaded_to_this_item' => __('Uploaded to this item', 'seo-flight-schedule'),
        'items_list'            => __('Delayed Flights list', 'seo-flight-schedule'),
        'items_list_navigation' => __('Delayed Flights list navigation', 'seo-flight-schedule'),
        'filter_items_list'     => __('Filter Delayed Flights list', 'seo-flight-schedule'),
    );

    $rewrite = array(
        'slug'                  => 'delayed-flight',
        'with_front'            => true,
        'pages'                 => true,
        'feeds'                 => false,
    );

    $args = array(
        'label'                 => __('Delayed Flight', 'seo-flight-schedule'),
        'description'           => __('Post type for Delayed Flights', 'seo-flight-schedule'),
        'labels'                => $labels,
        'supports'              => array('title', 'editor', 'trackbacks', 'custom-fields', 'page-attributes', 'post-formats'),
        'taxonomies'            => array('country-taxonomy', 'state-taxonomy', 'city-taxonomy', 'airport-taxonomy', 'airline-taxonomy'),
        'hierarchical'          => true,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => 'seo-flight-schedule',  // Add directly to the menu
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

    register_post_type('delayed_flight', $args);  // Corrected the post type slug


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
        'name'                  => _x('Airlines', 'Post Type General Name', 'seo-flight-schedule'),
        'singular_name'         => _x('Airline', 'Post Type Singular Name', 'seo-flight-schedule'),
        'menu_name'             => __('Airlines', 'seo-flight-schedule'),
        'name_admin_bar'        => __('Airlines', 'seo-flight-schedule'),
        'archives'              => __('Airline Archives', 'seo-flight-schedule'),
        'attributes'            => __('Airline Attributes', 'seo-flight-schedule'),
        'parent_item_colon'     => __('Parent Airline:', 'seo-flight-schedule'),
        'all_items'             => __('All Airlines', 'seo-flight-schedule'),
        'add_new_item'          => __('Add New Airline', 'seo-flight-schedule'),
        'add_new'               => __('Add Airline', 'seo-flight-schedule'),
        'new_item'              => __('New Airline', 'seo-flight-schedule'),
        'edit_item'             => __('Edit Airline', 'seo-flight-schedule'),
        'update_item'           => __('Update Airline', 'seo-flight-schedule'),
        'view_item'             => __('View Airline', 'seo-flight-schedule'),
        'view_items'            => __('View Airlines', 'seo-flight-schedule'),
        'search_items'          => __('Search Airlines', 'seo-flight-schedule'),
        'not_found'             => __('Airline Not found', 'seo-flight-schedule'),
        'not_found_in_trash'    => __('Airline Not found in Trash', 'seo-flight-schedule'),
        'featured_image'        => __('Featured Image', 'seo-flight-schedule'),
        'set_featured_image'    => __('Set featured image', 'seo-flight-schedule'),
        'remove_featured_image' => __('Remove featured image', 'seo-flight-schedule'),
        'use_featured_image'    => __('Use as featured image', 'seo-flight-schedule'),
        'insert_into_item'      => __('Insert into item', 'seo-flight-schedule'),
        'uploaded_to_this_item' => __('Uploaded to this item', 'seo-flight-schedule'),
        'items_list'            => __('Airlines list', 'seo-flight-schedule'),
        'items_list_navigation' => __('Airlines list navigation', 'seo-flight-schedule'),
        'filter_items_list'     => __('Filter Airlines list', 'seo-flight-schedule'),
    );
    $rewrite = array(
        'slug'                  => 'airline',
        'with_front'            => true,
        'pages'                 => true,
        'feeds'                 => false,
    );
    $args = array(
        'label'                 => __('Airline', 'seo-flight-schedule'),
        'description'           => __('Post type for Airlines', 'seo-flight-schedule'),
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
    register_post_type('post_type_airlines', $args);

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

function add_seo_flight_scheduling_menu()
{
    add_menu_page(
        'SEO Flight Scheduling',       // Page title
        'SEO Flight Scheduling',       // Menu title
        'manage_options',              // Capability
        'seo-flight-schedule',         // Menu slug
        'seo_flight_scheduling_page',  // Callback function (content of the main page)
        'dashicons-airplane',          // Icon
        6                              // Menu position
    );
}

function seo_flight_scheduling_page()
{
    echo '<h1>SEO Flight Scheduling</h1>';
    echo '<p>Welcome to the SEO Flight Scheduling plugin. Use the submenus to manage flights, delayed flights, and taxonomies.</p>';
}

add_action('admin_menu', 'add_seo_flight_scheduling_menu');

function add_taxonomies_to_menu()
{
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

function admin_script_for_custom_taxonomy_menu()
{
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

function mi_plugin_activate()
{
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
        state varchar(255) DEFAULT '',
        timezone varchar(40),
        country varchar(255) DEFAULT '',
        latitude DECIMAL(15,10) NOT NULL DEFAULT '0.0000000000',
        longitude DECIMAL(16,10) NOT NULL DEFAULT '0.0000000000',
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

    // Creación o actualización de la tabla schedules
    $sql_schedules = "CREATE TABLE {$wpdb->prefix}schedules (
        id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
        iata_code varchar(3) NOT NULL DEFAULT '',
        icao_code varchar(4) NOT NULL DEFAULT '',
        airline_iata varchar(3) NOT NULL DEFAULT '',
        airline_icao varchar(4) NOT NULL DEFAULT '',
        schedule_type enum('departure', 'arrival') NOT NULL,
        offset_value int NOT NULL DEFAULT 0,
        updated_time datetime NOT NULL DEFAULT current_timestamp(),
        last_page boolean DEFAULT false,
        PRIMARY KEY (id),
        UNIQUE KEY idx_iata_type (iata_code, icao_code, airline_iata, airline_icao, schedule_type, offset_value)
    ) $charset_collate;";
    dbDelta($sql_schedules);

    // Creación o actualización de la tabla schedule_details
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
        arr_terminal varchar(5) DEFAULT '',
        dep_terminal varchar(5) DEFAULT '',
        PRIMARY KEY (id),
        FOREIGN KEY (schedule_id) REFERENCES {$wpdb->prefix}schedules(id) ON DELETE CASCADE
    ) $charset_collate;";
    dbDelta($sql_schedule_details);

    // Creación o actualización de la tabla delayed schedules
    $sql_delayed_schedules = "CREATE TABLE {$wpdb->prefix}delayed_schedules (
        id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
        iata_code varchar(3) NOT NULL DEFAULT '',
        icao_code varchar(4) NOT NULL DEFAULT '',
        airline_iata varchar(3) NOT NULL DEFAULT '',
        airline_icao varchar(4) NOT NULL DEFAULT '',
        schedule_type enum('departures', 'arrivals') NOT NULL,
        offset_value int NOT NULL DEFAULT 0,
        updated_time datetime NOT NULL DEFAULT current_timestamp(),
        last_page boolean DEFAULT false,
        PRIMARY KEY (id),
        UNIQUE KEY idx_iata_type (iata_code, icao_code, airline_iata, airline_icao, schedule_type, offset_value)
    ) $charset_collate;";
    dbDelta($sql_delayed_schedules);

    // Creación o actualización de la tabla schedule_details
    $sql_delayed_schedule_details = "CREATE TABLE {$wpdb->prefix}delayed_schedule_details (
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
        arr_terminal varchar(5) DEFAULT '',
        dep_terminal varchar(5) DEFAULT '',
        delayed_time bigint DEFAULT 0,
        PRIMARY KEY (id),
        FOREIGN KEY (schedule_id) REFERENCES {$wpdb->prefix}delayed_schedules(id) ON DELETE CASCADE
    ) $charset_collate;";
    dbDelta($sql_delayed_schedule_details);

    // Agregar columnas 'latitude' y 'longitude' a la tabla airports si no existen
    $airports_table = $wpdb->prefix . 'airports';

    $wpdb->query("ALTER TABLE $airports_table ADD COLUMN latitude DECIMAL(15,10) NOT NULL DEFAULT '0.0000000000' AFTER country");

    $wpdb->query("ALTER TABLE $airports_table ADD COLUMN longitude DECIMAL(16,10) NOT NULL DEFAULT '0.0000000000' AFTER latitude");

    // Agregar columnas 'arr_terminal' y 'dep_terminal' a la tabla schedule_details si no existen
    $schedule_details_table = $wpdb->prefix . 'schedule_details';

    // Verificar si la columna 'arr_terminal' existe
    $arr_terminal_column = $wpdb->get_results("SHOW COLUMNS FROM $schedule_details_table LIKE 'arr_terminal'");
    if (empty($arr_terminal_column)) {
        $wpdb->query("ALTER TABLE $schedule_details_table ADD COLUMN arr_terminal VARCHAR(5) DEFAULT '' AFTER status");
    }

    // Verificar si la columna 'dep_terminal' existe
    $dep_terminal_column = $wpdb->get_results("SHOW COLUMNS FROM $schedule_details_table LIKE 'dep_terminal'");
    if (empty($dep_terminal_column)) {
        $wpdb->query("ALTER TABLE $schedule_details_table ADD COLUMN dep_terminal VARCHAR(5) DEFAULT '' AFTER arr_terminal");
    }

    // Intenta cargar datos JSON de aeropuertos
    $airportJson = file_get_contents(plugin_dir_path(__FILE__) . 'airports.json');

    if ($airportJson === false) {
        error_log('Error al leer el archivo de aeropuertos');
        return;
    }

    $airports = json_decode($airportJson, true);

    if (!is_array($airports) || !isset($airports['response'])) {
        error_log('Error al decodificar el archivo JSON de aeropuertos o la clave \'response\' no está presente');
        return;
    }

    foreach ($airports['response'] as $airport) {
        // Ensure we are updating all relevant fields
        $wpdb->replace(
            $airports_table,
            [
                'name' => isset($airport['name']) ? $airport['name'] : '',
                'iata_code' => isset($airport['iata']) ? $airport['iata'] : '',
                'icao_code' => isset($airport['icao']) ? $airport['icao'] : '',
                'country' => isset($airport['country']) ? $airport['country'] : '',
                'city' => isset($airport['city']) ? $airport['city'] : '',
                'state' => isset($airport['state']) ? $airport['state'] : '',
                'timezone' => isset($airport['tz']) ? $airport['tz'] : '',
                'latitude' => isset($airport['lat']) ? (string)$airport['lat'] : '0.0000000000',
                'longitude' => isset($airport['lon']) ? (string)$airport['lon'] : '0.0000000000'
            ],
            ['%s', '%s', '%s', '%s', '%s', '%s', '%s', '%f', '%f'], // Format for each field
        );
    }


    // Intenta cargar datos JSON de aerolíneas
    $airlineJson = file_get_contents(plugin_dir_path(__FILE__) . 'airlines.json');

    if ($airlineJson === false) {
        error_log('Error al leer el archivo de aerolíneas');
        return;
    }

    $airlines = json_decode($airlineJson, true);

    if (!is_array($airlines) || !isset($airlines['response'])) {
        error_log('Error al decodificar el archivo JSON de aerolíneas o la clave \'response\' no está presente');
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
            error_log('Error al insertar aerolínea: ' . $wpdb->last_error);
        }
    }

    update_option('mi_plugin_db_message', 'Tablas de Mi Plugin React creadas con éxito.');

    register_my_custom_post_types();
    flush_rewrite_rules();
}
register_activation_hook(__FILE__, 'mi_plugin_activate');

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
            'terminal' => array('required' => false),
            'offset_value' => array('required' => false),
        ),
        'permission_callback' => '__return_true'
    ));
    register_rest_route('mi-plugin/v1', '/local-time', array(
        'methods' => 'GET',
        'callback' => 'monitor_flight_get_local_time',
        'permission_callback' => '__return_true', // Ajustar según los permisos que desees
        'args' => array(
            'airportCode' => array(
                'required' => true,
                'validate_callback' => function ($param, $request, $key) {
                    return is_string($param) && !empty($param);
                }
            ),
            'airp_codeType' => array(
                'required' => true,
                'validate_callback' => function ($param, $request, $key) {
                    return in_array($param, array('iata', 'icao'));
                }
            ),
        ),
    ));
    register_rest_route('mi-plugin/v1', '/fetch-delayed-data', array(
        'methods' => 'GET',
        'callback' => 'fetch_delayed_flights',
        'permission_callback' => '__return_true',
        'args' => array(
            'airportCode' => array('required' => true),
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
            'delayed_type' => array('required' => true),
            'delayed_time' => array('requiered' => true),
            'offset_value' => array('required' => false),
        ),
    ));
});

function monitor_flight_get_local_time($request)
{
    // Get parameters
    $airport_code = $request->get_param('airportCode');
    $airp_codeType = $request->get_param('airp_codeType');

    // Check if parameters are missing
    if (!$airport_code || !$airp_codeType) {
        error_log('Missing required query parameters.');
        return new WP_Error('missing_parameters', 'Missing required query parameters', array('status' => 400));
    }

    // Log parameters for debugging
    // error_log("Request Params: Type: $type, Airport Code: $airport_code, Code Type: $airp_codeType");


    global $wpdb;

    // Fetch airport info
    $column = ($airp_codeType === 'icao') ? 'icao_code' : 'iata_code';
    $airport = $wpdb->get_row($wpdb->prepare(
        "SELECT latitude, longitude FROM {$wpdb->prefix}airports WHERE $column = %s",
        $airport_code
    ));

    if (!$airport) {
        error_log("No airport found for the given code: $airport_code");
        return new WP_Error('no_airport_found', 'No airport found for the given code', array('status' => 404));
    }

    $latitude = $airport->latitude;
    $longitude = $airport->longitude;

    // Log latitude and longitude for debugging
    // error_log("Latitude: $latitude, Longitude: $longitude");

    // Use TimeZoneDB API
    $timezone_db_key = get_option('mi_plugin_timezone_db_key');
    $url = "http://api.timezonedb.com/v2.1/get-time-zone?key={$timezone_db_key}&format=json&by=position&lat={$latitude}&lng={$longitude}";

    $response = wp_remote_get($url);

    if (is_wp_error($response)) {
        error_log('Failed to retrieve data from TimeZoneDB API: ' . $response->get_error_message());
        return new WP_Error('api_error', 'Failed to retrieve data from the API', array('status' => 500));
    }

    $data = json_decode(wp_remote_retrieve_body($response), true);

    if (isset($data['zoneName'])) {
        // Use the 'zoneName' and 'formatted' data from TimeZoneDB
        $timeZoneId = $data['zoneName'];
        $local_time = new DateTime($data['formatted'], new DateTimeZone($timeZoneId));
    } else {
        error_log('Invalid API response. Missing zoneName or formatted time.');
        return new WP_Error('invalid_api_response', 'The API response did not contain valid time data', array('status' => 500));
    }

    // Log the local time before returning
    error_log("Local time: " . $local_time->format('Y-m-d H:i:s'));

    return array(
        'airport_code' => $airport_code,
        'local_time' => $local_time->format('Y-m-d H:i:s'),
    );
}

//Function to fetch Delayed flight data
function fetch_delayed_flights(WP_REST_Request $request)
{
    global $wpdb;

    // Expiration time in seconds (for example, 30 minutes)
    $exp_data = get_option('mi_plugin_data_expiration');
    $expiration_seconds = $exp_data * 60;

    // Retrieve the query parameters from the request
    $airportCode = $request->get_param('airportCode');
    $airp_codeType = $request->get_param('airp_codeType'); // Default to 'iata' if not provided
    $airlineCode = $request->get_param('airlineCode');
    $airl_codeType = $request->get_param('airl_codeType'); // Default to 'iata' if not provided
    $delayed_type = $request->get_param('delayed_type');
    $delayed_time = $request->get_param('delayed_time');
    $status = $request->get_param('status');
    $terminal = $request->get_param('terminal');
    $offset_value = $request->get_param('offset_value') ?: 0;

    // Check if valid data exists in the database
    if (!empty($airlineCode)) {
        // Consulta cuando airline_iata o airline_icao están presentes
        $schedule = $wpdb->get_row($wpdb->prepare(
            "SELECT id, updated_time, offset_value, last_page FROM {$wpdb->prefix}delayed_schedules
                    WHERE (iata_code = %s OR icao_code = %s)
                    AND schedule_type = %s
                    AND (airline_iata = %s OR airline_icao = %s)
                    AND offset_value = %d",
            $airportCode,
            $airportCode,
            $delayed_type,
            $airlineCode,
            $airlineCode,
            $offset_value
        ), ARRAY_A);
    } else {
        // Consulta cuando airline_iata y airline_icao están vacíos
        $schedule = $wpdb->get_row($wpdb->prepare(
            "SELECT id, updated_time, offset_value, last_page FROM {$wpdb->prefix}delayed_schedules
                    WHERE (iata_code = %s OR icao_code = %s)
                    AND schedule_type = %s
                    AND airline_iata = 'N/A'
                    AND airline_icao = 'N/A'
                    AND offset_value = %d",
            $airportCode,
            $airportCode,
            $delayed_type,
            $offset_value
        ), ARRAY_A);
    }

    if ($schedule && (((strtotime($schedule['updated_time'])) + $expiration_seconds) > time()) && !$schedule['last_page']) {

        // Buscar detalles asociados en schedule_details
        $query = "SELECT * FROM {$wpdb->prefix}delayed_schedule_details WHERE schedule_id = %d AND offset_page = %d";
        $params = [$schedule['id'], $schedule['offset_value']];

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

        // Añadir filtro por terminal si está presente
        if (!empty($filter_terminal)) {
            if ($delayed_type === 'departures') {
                // Check dep_terminal for departures
                $query .= " AND dep_terminal = %s";
            } elseif ($delayed_type === 'arrivals') {
                // Check arr_terminal for arrivals
                $query .= " AND arr_terminal = %s";
            }
            $params[] = $filter_terminal; // Add the terminal filter to the parameters
        }

        $flightDetails = $wpdb->get_results($wpdb->prepare($query, $params), ARRAY_A);

        if (!empty($flightDetails)) {
            // Formatear los detalles del vuelo para la respuesta
            $formattedFlights = array_map(function ($flight) {
                global $wpdb;
                $arrAirport = $wpdb->get_row($wpdb->prepare(
                    "SELECT * FROM {$wpdb->prefix}airports WHERE iata_code = %s OR icao_code = %s",
                    $flight['arr_iata'],
                    $flight['arr_icao']
                ));
                $depAirport = $wpdb->get_row($wpdb->prepare(
                    "SELECT * FROM {$wpdb->prefix}airports WHERE iata_code = %s OR icao_code = %s",
                    $flight['dep_iata'],
                    $flight['dep_icao']
                ));

                return [
                    'flight' => !empty($flight['flight_iata']) ? $flight['flight_iata'] : $flight['flight_icao'],
                    'airport' => $flight['airport'],
                    'airline_name' => $flight['airline_name'],
                    'airline_code' => !empty($flight['airline_iata']) ? $flight['airline_iata'] : $flight['airline_icao'],
                    'depart' => $flight['depart'],
                    'arrive' => $flight['arrive'],
                    'arrAirport' => $arrAirport->name,
                    'arrAirport_city' => $arrAirport->city,
                    'arrAirport_state' => $arrAirport->state,
                    'arrAirport_country' => $arrAirport->country,
                    'depAirport' => $depAirport->name,
                    'depAirport_city' => $depAirport->city,
                    'depAirport_state' => $depAirport->state,
                    'depAirport_country' => $depAirport->country,
                    'dep_code' => !empty($flight['dep_iata']) ? $flight['dep_iata'] : $flight['dep_icao'],
                    'dep_city' => $flight['dep_city'],
                    'arr_code' => !empty($flight['arr_icao']) ? $flight['arr_iata'] : $flight['arr_icao'],
                    'arr_city' => $flight['arr_city'],
                    'tz_dep' => $flight['tz_dep'],
                    'tz_arr' => $flight['tz_arr'],
                    'status' => $flight['status'],
                    'delayed' => $flight['delayed'],
                ];
            }, $flightDetails);

            return new WP_REST_Response($formattedFlights, 200);
        } else if (empty($flightDetails) && $status) {
            return new WP_REST_Response([], 200);
        } else {
            return new WP_REST_Response(['message' => 'No flight details available'], 404);
        }
    }
    if (!$schedule) {
        // Airport and airline lookup
        $airpCodeType = $airp_codeType === 'iata' ? 'iata_code' : 'icao_code';
        $airportData = $wpdb->get_row(
            $wpdb->prepare(
                "SELECT iata_code, icao_code FROM {$wpdb->prefix}airports WHERE {$airpCodeType} = %s",
                $airportCode
            )
        );

        if (!empty($airlineCode)) {
            $airlCodeType = $airl_codeType === 'iata' ? 'iata_code' : 'icao_code';
            $airlineData = $wpdb->get_row(
                $wpdb->prepare(
                    "SELECT iata_code, icao_code FROM {$wpdb->prefix}airlines WHERE {$airlCodeType} = %s",
                    $airlineCode
                )
            );
        }

        // Insert new schedule
        $wpdb->insert(
            "{$wpdb->prefix}delayed_schedules",
            [
                'schedule_type' => $delayed_type,
                'updated_time' => current_time('mysql', 1),
                'iata_code' => $airportData->iata_code,
                'icao_code' => $airportData->icao_code,
                'airline_iata' => $airlineData->iata_code ?? 'N/A',
                'airline_icao' => $airlineData->icao_code ?? 'N/A',
                'offset_value' => $offset_value,
            ],
            ['%s', '%s', '%s', '%s', '%s', '%d']
        );

        $schedule['id'] = $wpdb->insert_id;
        $schedule['offset_value'] = $offset_value;
    } else {
        // If the data has expired, update the schedule and delete the details
        if (strtotime($schedule['updated_time']) + $expiration_seconds < time()) {
            // Begin transaction
            $wpdb->query('START TRANSACTION');

            // Update the schedule's updated_time and reset last_page
            $updated = $wpdb->update(
                "{$wpdb->prefix}delayed_schedules",
                ['updated_time' => current_time('mysql', 1), 'last_page' => false],
                ['id' => $schedule['id']],
                ['%s', '%d'],
                ['%d']
            );

            if ($updated !== false) {
                // Delete existing flight details
                $deleted = $wpdb->delete(
                    "{$wpdb->prefix}delayed_schedule_details",
                    ['schedule_id' => $schedule['id']],
                    ['%d']
                );

                if ($deleted !== false) {
                    // Commit transaction
                    $wpdb->query('COMMIT');
                } else {
                    // Rollback if deletion failed
                    $wpdb->query('ROLLBACK');
                    return new WP_Error('db_delete_error', 'Error deleting schedule details.', ['status' => 500]);
                }
            } else {
                // Rollback if update failed
                $wpdb->query('ROLLBACK');
                return new WP_Error('db_update_error', 'Error updating schedule.', ['status' => 500]);
            }
        }
    }

    // Get the AirLabs API key from WordPress options (make sure it's stored there)
    $apiKey = get_option('mi_plugin_api_key');
    if (!$apiKey) {
        return new WP_Error('api_key_missing', 'The AirLabs API key is not configured in the plugin settings.', array('status' => 500));
    }

    // Build the API request URL based on the parameters provided
    $apiUrl = 'https://airlabs.co/api/v9/delays?api_key=' . $apiKey;

    if (!empty($airp_codeType) && !empty($airportCode)) {
        // Determine the prefix based on delayed_type
        $airportPrefix = $delayed_type === 'departures' ? 'dep_' : 'arr_';
        // Append the airport code with the appropriate prefix
        $apiUrl .= '&' . $airportPrefix . $airp_codeType . '=' . urlencode($airportCode);
    }


    if (!empty($airlineCode)) {
        // Determine the prefix based on the airline code type (IATA or ICAO)
        $airlinePrefix = $airl_codeType === 'iata' ? 'airline_iata' : 'airline_icao';

        // Append the airline code with the appropriate prefix
        $apiUrl .= '&' . $airlinePrefix . '=' . urlencode($airlineCode);
    }


    $apiUrl .= '&type=' . urlencode($delayed_type); // Add the delayed type (arrival/departure)
    $apiUrl .= '&delay=' . urlencode($delayed_time); // Add the delayed time (in minutes)

    // Optional parameters
    if ($offset_value) {
        $apiUrl .= '&offset=' . urlencode($offset_value); // Add pagination or offset if provided
    }

    // Make the API request to AirLabs
    $response = wp_remote_get($apiUrl);
    if (is_wp_error($response)) {
        return new WP_Error('api_error', 'Error fetching data from AirLabs.', array('status' => 500));
    }

    $schedulesData = json_decode(wp_remote_retrieve_body($response), true);

    // If no data returned, log an error
    if (empty($schedulesData['response'])) {
        return new WP_Error('no_flight_data', 'No flight data available.', array('status' => 404));
    }

    if (empty($schedulesData['response'])) {
        $result = $wpdb->update(
            "{$wpdb->prefix}delayed_schedules",
            ['last_page' => true],
            ['id' => $schedule['id']],
            ['%d'],
            ['%d']
        );
        if ($result || $schedule['last_page'] === true) {
            return new WP_REST_Response(null, 204);
        } else {
            return new WP_Error("api_fetch_error", "Error updating last page status.", ['status' => 500]);
        }
    }

    $airportData = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}airports", ARRAY_A);
    $airports = array_column($airportData, null, 'iata_code'); // Create a map using IATA as keys

    // 2. Fetch all required airline data in ONE query
    $airlineData = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}airlines", ARRAY_A);
    $airlines = array_column($airlineData, null, 'iata_code');  // Create a map using IATA as keys

    // Prepare and insert flight details
    $insert_data = [];
    $formattedFlights = []; // Array to store the formatted flights for the response

    foreach ($schedulesData['response'] as $flight) {
        $arrCode = !empty($flight['arr_iata']) ? $flight['arr_iata'] : $flight['arr_icao'];
        $depCode = !empty($flight['dep_iata']) ? $flight['dep_iata'] : $flight['dep_icao'];

        // Access data from the pre-fetched arrays/maps
        $airportName = $airports[$arrCode]['name'] ?? '';
        $airline_name = $airlines[$flight['airline_iata']]['name'] ?? '';
        $dep_city = $airports[$depCode]['city'] ?? '';
        $arr_city = $airports[$arrCode]['city'] ?? '';
        $tz_dep = $airports[$depCode]['timezone'] ?? '';
        $tz_arr = $airports[$arrCode]['timezone'] ?? '';

        // Prepare formatted flight data for response
        $formattedFlights[] = [
            'flight' => !empty($flight['flight_iata']) ? $flight['flight_iata'] : $flight['flight_icao'],
            'airport' => $airportName,
            'depart' => $flight['dep_estimated'] ?? $flight['dep_time'],
            'arrive' => $flight['arr_estimated'] ?? $flight['arr_time'],
            'airline_name' => $airline_name,
            'airline_code' => !empty($flight['airline_iata']) ? $flight['airline_iata'] : $flight['airline_icao'],
            'arrAirport' => $airports[$arrCode]['name'] ?? '',
            'arrAirport_city' => $arr_city,
            'arrAirport_state' => $airports[$arrCode]['state'] ?? '',
            'arrAirport_country' => $airports[$arrCode]['country'] ?? '',
            'depAirport' => $airports[$depCode]['name'] ?? '',
            'depAirport_city' => $dep_city,
            'depAirport_state' => $airports[$depCode]['state'] ?? '',
            'depAirport_country' => $airports[$depCode]['country'] ?? '',
            'dep_code' => $depCode,
            'dep_city' => $dep_city,
            'arr_code' => $arrCode,
            'arr_city' => $arr_city,
            'tz_dep' => $tz_dep,
            'tz_arr' => $tz_arr,
            'status' => $flight['status'],
            'delayed' => $flight['delayed'],
        ];

        $insert_data[] = $wpdb->prepare(
            "(%d, %d, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %d)",
            $schedule['id'],
            $offset_value,
            $flight['flight_iata'] ?? '',
            $flight['flight_icao'] ?? '',
            $flight['airline_iata'] ?? '',
            $flight['airline_icao'] ?? '',
            $airportName ?? '',
            $airline_name ?? '',
            $flight['dep_estimated'] ?? $flight['dep_time'],
            $flight['arr_estimated'] ?? $flight['arr_time'],
            $depCode,
            $flight['dep_icao'] ?? '',
            $dep_city,
            $arrCode,
            $flight['arr_icao'] ?? '',
            $arr_city,
            $tz_dep,
            $tz_arr,
            $flight['status'] ?? '',
            $flight['dep_terminal'] ?? '',
            $flight['arr_terminal'] ?? '',
            $flight['delayed'] ?? ''
        );
    }

    // Insert into the `delayed_schedule_details` table
    if (!empty($insert_data)) {
        $query = "INSERT INTO {$wpdb->prefix}delayed_schedule_details
            (`schedule_id`, `offset_page`, `flight_iata`, `flight_icao`, `airline_iata`, `airline_icao`, `airline_name`,
             `airport`, `depart`, `arrive`, `dep_iata`, `dep_icao`, `dep_city`, `arr_iata`, `arr_icao`,
             `arr_city`, `tz_dep`, `tz_arr`, `status`, `dep_terminal`, `arr_terminal`, `delayed`) 
            VALUES " . implode(', ', $insert_data);

        $wpdb->query($query);
    }

    // Return the flight data as a response
    return new WP_REST_Response($formattedFlights, 200);
}



function mi_plugin_fetch_flight_data($request)
{
    global $wpdb;
    $apiKey = get_option('mi_plugin_api_key');
    $exp_data = get_option('mi_plugin_data_expiration');
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
    $terminal = $request->get_param('terminal');
    $offset = $request->get_param('offset_value');

    // Tablas de la base de datos
    $flights_table = $wpdb->prefix . 'flights';
    $airports_table = $wpdb->prefix . 'airports';
    $airlines_table = $wpdb->prefix . 'airlines';

    $apiUrl = 'https://airlabs.co/api/v9/';
    $apiImgUrl = 'https://airlabs.co/img/airline/m/';

    // Variables para medir tiempos
    $timings = [];

    // Dependiendo del tipo de consulta, se define la lógica
    switch ($type) {
        case 'flight':
            // Medición de tiempo de consulta a la base de datos
            $start_time_db = microtime(true);

            // Buscar en la base de datos por flight_iata o flight_icao
            $codeType = ($flight_codeType === 'iata') ? 'flight_iata' : 'flight_icao';
            $airlineApi = $airl_codeType === 'iata' ? "iata_code={$airlineCode}" : "icao_code={$airlineCode}";

            $flightData = $wpdb->get_row($wpdb->prepare(
                "SELECT * FROM {$flights_table} WHERE {$codeType} = %s",
                $flight
            ), ARRAY_A);

            $end_time_db = microtime(true);
            $timings['db'] = ($end_time_db - $start_time_db) * 1000; // tiempo en milisegundos

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

                // Añadir encabezado Server-Timing
                $timing_header = 'Server-Timing: ';
                foreach ($timings as $key => $dur) {
                    $timing_header .= "$key;dur=$dur, ";
                }
                $timing_header = rtrim($timing_header, ', ');
                header($timing_header);

                return new WP_REST_Response($response, 200);
            } else {
                // Medición de tiempo de llamada a la API
                $start_time_api = microtime(true);

                // Si no existen en la base, consulta la API y guarda los resultados
                $flightApi = $flight_codeType === 'iata' ? "flight_iata={$flight}" : "flight_icao={$flight}";
                $fullUrl = "{$apiUrl}flight?{$flightApi}&api_key={$apiKey}";
                $response = wp_remote_get($fullUrl);

                $end_time_api = microtime(true);
                $timings['api'] = ($end_time_api - $start_time_api) * 1000; // tiempo en milisegundos

                if (is_wp_error($response)) {
                    return new WP_Error('api_fetch_error', 'Error al realizar el fetch al API externo.', ['status' => 500]);
                }
                $data = json_decode(wp_remote_retrieve_body($response), true);
                if (isset($data['response'])) {
                    $flightData = $data['response'];
                    $airlineLogoUrl = "{$apiImgUrl}{$flightData['airline_iata']}.png";

                    // Medición de tiempo de almacenamiento en la base de datos
                    $start_time_save = microtime(true);

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
                            'dep_time_ts' => $flightData['dep_time'],
                            'dep_delayed' => $flightData['dep_delayed'],
                            'arr_iata' => $flightData['arr_iata'],
                            'arr_icao' => $flightData['arr_icao'],
                            'arr_gate' => $flightData['arr_gate'],
                            'arr_time_ts' => $flightData['arr_time'],
                            'arr_delayed' => $flightData['arr_delayed'],
                            'duration' => $flightData['duration'],
                            'updated_time' => current_time('mysql', 1),
                        ],
                        ['%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%d', '%d', '%s', '%s', '%s', '%d', '%d', '%d', '%s']
                    );

                    $end_time_save = microtime(true);
                    $timings['save'] = ($end_time_save - $start_time_save) * 1000; // tiempo en milisegundos

                    //Buscar timezone de los Aeropuertos de salida y llegada
                    $airportData = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}airports", ARRAY_A);
                    $airports = array_column($airportData, null, 'iata_code'); // Create a map using IATA as keys

                    $tz_dep = $airports[$flightData['dep_iata']]['timezone'] ?? '';
                    $tz_arr = $airports[$flightData['arr_iata']]['timezone'] ?? '';

                    $formatedData = [
                        'airlineLogo' => $airlineLogoUrl,
                        'flightIata' => $flightData['flight_iata'],
                        'flightIcao' => $flightData['flight_icao'],
                        'flightNumber' => $flightData['flight_number'],
                        'status' => $flightData['status'],
                        'depIata' => $flightData['dep_iata'],
                        'depGate' => $flightData['dep_gate'],
                        'depTimeTs' => $flightData['dep_time'],
                        'depDelayed' => $flightData['dep_delayed'],
                        'arrIata' => $flightData['arr_iata'],
                        'arrGate' => $flightData['arr_gate'],
                        'arrTimeTs' => $flightData['arr_time'],
                        'arrDelayed' => $flightData['arr_delayed'],
                        'duration' => $flightData['duration'],
                        'airlineName' => $flightData['airline_name'],
                        'depAirportName' => $flightData['dep_name'],
                        'depCity' => $flightData['dep_city'],
                        'arrAirportName' => $flightData['arr_name'],
                        'arrCity' => $flightData['arr_city'],
                        'tz_dep' => $tz_dep,
                        'tz_arr' => $tz_arr,
                    ];

                    // Añadir encabezado Server-Timing
                    $timing_header = 'Server-Timing: ';
                    foreach ($timings as $key => $dur) {
                        $timing_header .= "$key;dur=$dur, ";
                    }
                    $timing_header = rtrim($timing_header, ', ');
                    header($timing_header);

                    return new WP_REST_Response($formatedData, 200);
                }
            }
            break;

        case 'departures':
        case 'arrivals':
            $isDepartures = $type === 'departures';
            $scheduleType = $isDepartures ? 'departure' : 'arrival';
            $filter = !empty($status) ? $status : '';
            $filter_terminal = !empty($terminal) ? $terminal : '';

            // Medición de tiempo de consulta a la base de datos
            $start_time_db = microtime(true);

            if (!empty($airlineCode)) {
                // Consulta cuando airline_iata o airline_icao están presentes
                $schedule = $wpdb->get_row($wpdb->prepare(
                    "SELECT id, updated_time, offset_value, last_page FROM {$wpdb->prefix}schedules
                            WHERE (iata_code = %s OR icao_code = %s)
                            AND schedule_type = %s
                            AND (airline_iata = %s OR airline_icao = %s)
                            AND offset_value = %d",
                    $airportCode,
                    $airportCode,
                    $scheduleType,
                    $airlineCode,
                    $airlineCode,
                    $offset
                ), ARRAY_A);
            } else {
                // Consulta cuando airline_iata y airline_icao están vacíos
                $schedule = $wpdb->get_row($wpdb->prepare(
                    "SELECT id, updated_time, offset_value, last_page FROM {$wpdb->prefix}schedules
                            WHERE (iata_code = %s OR icao_code = %s)
                            AND schedule_type = %s
                            AND airline_iata = 'N/A'
                            AND airline_icao = 'N/A'
                            AND offset_value = %d",
                    $airportCode,
                    $airportCode,
                    $scheduleType,
                    $offset
                ), ARRAY_A);
            }

            $end_time_db = microtime(true);
            $timings['db'] = ($end_time_db - $start_time_db) * 1000; // tiempo en milisegundos

            if ($schedule && (((strtotime($schedule['updated_time'])) + $exp_data_seconds) > time()) && !$schedule['last_page']) {
                // Medición de tiempo de consulta de detalles de vuelo
                $start_time_details = microtime(true);

                // Buscar detalles asociados en schedule_details
                $query = "SELECT * FROM {$wpdb->prefix}schedule_details WHERE schedule_id = %d AND offset_page = %d";
                $params = [$schedule['id'], $schedule['offset_value']];

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

                // Añadir filtro por terminal si está presente
                if (!empty($filter_terminal)) {
                    if ($type === 'departures') {
                        // Check dep_terminal for departures
                        $query .= " AND dep_terminal = %s";
                    } elseif ($type === 'arrivals') {
                        // Check arr_terminal for arrivals
                        $query .= " AND arr_terminal = %s";
                    }
                    $params[] = $filter_terminal; // Add the terminal filter to the parameters
                }

                $flightDetails = $wpdb->get_results($wpdb->prepare($query, $params), ARRAY_A);

                $end_time_details = microtime(true);
                $timings['details'] = ($end_time_details - $start_time_details) * 1000; // tiempo en milisegundos

                if (!empty($flightDetails)) {
                    // Formatear los detalles del vuelo para la respuesta
                    $formattedFlights = array_map(function ($flight) {
                        global $wpdb;
                        $arrAirport = $wpdb->get_row($wpdb->prepare(
                            "SELECT * FROM {$wpdb->prefix}airports WHERE iata_code = %s OR icao_code = %s",
                            $flight['arr_iata'],
                            $flight['arr_icao']
                        ));
                        $depAirport = $wpdb->get_row($wpdb->prepare(
                            "SELECT * FROM {$wpdb->prefix}airports WHERE iata_code = %s OR icao_code = %s",
                            $flight['dep_iata'],
                            $flight['dep_icao']
                        ));

                        return [
                            'flight' => !empty($flight['flight_iata']) ? $flight['flight_iata'] : $flight['flight_icao'],
                            'airport' => $flight['airport'],
                            'airline_name' => $flight['airline_name'],
                            'airline_code' => !empty($flight['airline_iata']) ? $flight['airline_iata'] : $flight['airline_icao'],
                            'depart' => $flight['depart'],
                            'arrive' => $flight['arrive'],
                            'arrAirport' => $arrAirport->name,
                            'arrAirport_city' => $arrAirport->city,
                            'arrAirport_state' => $arrAirport->state,
                            'arrAirport_country' => $arrAirport->country,
                            'depAirport' => $depAirport->name,
                            'depAirport_city' => $depAirport->city,
                            'depAirport_state' => $depAirport->state,
                            'depAirport_country' => $depAirport->country,
                            'dep_code' => !empty($flight['dep_iata']) ? $flight['dep_iata'] : $flight['dep_icao'],
                            'dep_city' => $flight['dep_city'],
                            'arr_code' => !empty($flight['arr_icao']) ? $flight['arr_iata'] : $flight['arr_icao'],
                            'arr_city' => $flight['arr_city'],
                            'tz_dep' => $flight['tz_dep'],
                            'tz_arr' => $flight['tz_arr'],
                            'status' => $flight['status'],
                        ];
                    }, $flightDetails);

                    // Añadir encabezado Server-Timing
                    $timing_header = 'Server-Timing: ';
                    foreach ($timings as $key => $dur) {
                        $timing_header .= "$key;dur=$dur, ";
                    }
                    $timing_header = rtrim($timing_header, ', ');
                    header($timing_header);

                    return new WP_REST_Response($formattedFlights, 200);
                } else if (empty($flightDetails) && $status) {
                    return new WP_REST_Response([], 200);
                } else {
                    return new WP_REST_Response(['message' => 'No flight details available'], 404);
                }
            }

            if (!$schedule) {
                $airpCodeType = $airp_codeType === 'iata' ? 'iata_code' : 'icao_code';
                // Obtener ambos códigos de aeropuertos desde la tabla de aeropuertos
                $airportData = $wpdb->get_row($wpdb->prepare(
                    "SELECT iata_code, icao_code FROM {$wpdb->prefix}airports WHERE {$airpCodeType} = %s",
                    $airportCode
                ));
                if (!empty($airlineCode)) {
                    $airlCodeType = $airl_codeType === 'iata' ? 'iata_code' : 'icao_code';
                    $airlineData = $wpdb->get_row($wpdb->prepare(
                        "SELECT iata_code, icao_code FROM {$wpdb->prefix}airlines WHERE {$airlCodeType} = %s",
                        $airlineCode
                    ));
                }

                $wpdb->insert(
                    "{$wpdb->prefix}schedules",
                    [
                        'schedule_type' => $scheduleType,
                        'updated_time' => current_time('mysql', 1),
                        'iata_code' => $airportData->iata_code,
                        'icao_code' => $airportData->icao_code,
                        'airline_iata' => $airlineData->iata_code ?? 'N/A',
                        'airline_icao' => $airlineData->icao_code ?? 'N/A',
                        'offset_value' => $offset,
                    ],
                    ['%s', '%s', '%s', '%s', '%s', '%s', '%d']
                );
                $schedule['id'] = $wpdb->insert_id;
                $schedule['offset_value'] = $offset;
            } else {
                if ($schedule['id'] && (strtotime($schedule['updated_time']) + $exp_data_seconds) < time()) {
                    // Iniciar transacción
                    $wpdb->query('START TRANSACTION');

                    // Actualizar el registro en la tabla schedules
                    $updated = $wpdb->update(
                        "{$wpdb->prefix}schedules",
                        ['updated_time' => current_time('mysql', 1), 'last_page' => false],
                        ['id' => $schedule['id']],
                        ['%s', '%d'],
                        ['%d']
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

            // Medición de tiempo de llamada a la API
            $start_time_api = microtime(true);

            // Si no hay información reciente, consulta al API de Airlabs
            $endpointUrl = "{$apiUrl}schedules?" . ($isDepartures ? "dep_" : "arr_") . "{$airp_codeType}={$airportCode}&api_key={$apiKey}&offset={$offset}";

            if (!empty($airlineCode)) {
                $endpointUrl .= "&airline_" . ($airl_codeType === 'iata' ? 'iata' : 'icao') . "={$airlineCode}";
            }

            $apiResponse = wp_remote_get($endpointUrl);

            $end_time_api = microtime(true);
            $timings['api'] = ($end_time_api - $start_time_api) * 1000; // tiempo en milisegundos

            if (is_wp_error($apiResponse)) {
                return new WP_Error('api_fetch_error', 'Error al obtener datos del API de Airlabs.', ['status' => 500]);
            }

            $schedulesData = json_decode(wp_remote_retrieve_body($apiResponse), true);

            if (isset($schedulesData['error'])) {
                // Handle specific error
                if ($schedulesData['error']['code'] === 'month_limit_exceeded') {
                    return new WP_Error('month_limit_exceeded', $schedulesData['error']['message'], ['status' => 400]);
                }
                return new WP_Error('api_fetch_error', $schedulesData['error']['message'], ['status' => 500]);
            }

            if (empty($schedulesData['response'])) {
                $result = $wpdb->update(
                    "{$wpdb->prefix}schedules",
                    ['last_page' => true],
                    ['id' => $schedule['id']],
                    ['%d'],
                    ['%d']
                );
                if ($result || $schedule['last_page'] === true) {
                    return new WP_REST_Response(null, 204);
                } else {
                    return new WP_Error("api_fetch_error", "Error al actualizar el último estado de la página.", ['status' => 500]);
                }
            }

            if (isset($schedulesData['response'])) {
                $formattedFlights = [];
                $insert_data = [];
                // Medición de tiempo de almacenamiento de detalles de vuelo
                $start_time_save = microtime(true);

                // 1. Fetch all required airport data in ONE query
                $airportData = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}airports", ARRAY_A);
                $airports = array_column($airportData, null, 'iata_code'); // Create a map using IATA as keys

                // 2. Fetch all required airline data in ONE query
                $airlineData = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}airlines", ARRAY_A);
                $airlines = array_column($airlineData, null, 'iata_code');  // Create a map using IATA as keys
                foreach ($schedulesData['response'] as $flightData) {
                    $arrCode = !empty($flightData['arr_iata']) ? $flightData['arr_iata'] : $flightData['arr_icao'];
                    $depCode = !empty($flightData['dep_iata']) ? $flightData['dep_iata'] : $flightData['dep_icao'];
                    $airportCodeToCheck = $isDepartures ? $arrCode : $depCode;

                    // 4. Access data from the pre-fetched arrays/maps
                    $airportName = $airports[$airportCodeToCheck]['name'] ?? '';
                    $airline_name = $airlines[$flightData['airline_iata']]['name'] ?? '';
                    $dep_city = $airports[$flightData['dep_iata']]['city'] ?? '';
                    $arr_city = $airports[$flightData['arr_iata']]['city'] ?? '';
                    $tz_dep = $airports[$flightData['dep_iata']]['timezone'] ?? '';
                    $tz_arr = $airports[$flightData['arr_iata']]['timezone'] ?? '';

                    $insert_data[] = $wpdb->prepare(
                        "(%d, %d, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                        $schedule['id'],
                        $offset,
                        $flightData['flight_iata'] ?? '',
                        $flightData['flight_icao'] ?? '',
                        $flightData['airline_iata'] ?? '',
                        $flightData['airline_icao'] ?? '',
                        $airportName ?? '',
                        $airline_name ?? '',
                        $flightData['dep_estimated'] ?? $flightData['dep_time'],
                        $flightData['arr_estimated'] ?? $flightData['arr_time'],
                        $flightData['dep_iata'] ?? '',
                        $flightData['dep_icao'] ?? '',
                        $dep_city ?? '',
                        $flightData['arr_iata'] ?? '',
                        $flightData['arr_icao'] ?? '',
                        $arr_terminal['arr_terminal'] ?? '',
                        $dep_terminal['dep_terminal'] ?? '',
                        $arr_city ?? '',
                        $tz_dep ?? '',
                        $tz_arr ?? '',
                        $flightData['status'] ?? ''
                    );

                    // if ($insert_result !== false) {
                    if (!empty($filter) && $flightData['status'] !== $filter) {
                        continue;
                    }
                    // Terminal filter logic
                    if (!empty($filter_terminal)) {
                        if ($type === 'departures' && (!isset($flightData['dep_terminal']) || $flightData['dep_terminal'] !== $filter_terminal)) {
                            continue;
                        }
                        if ($type === 'arrivals' && (!isset($flightData['arr_terminal']) || $flightData['arr_terminal'] !== $filter_terminal)) {
                            continue;
                        }
                    }

                    $formattedFlights[] = [
                        'flight' => !empty($flightData['flight_iata']) ? $flightData['flight_iata'] : $flightData['flight_icao'],
                        'airport' => $airportName,
                        'depart' => $flightData['dep_estimated'] ?? $flightData['dep_time'],
                        'arrive' => $flightData['arr_estimated'] ?? $flightData['arr_time'],
                        'airline_name' => $airline_name,
                        'airline_code' => !empty($flightData['airline_iata']) ? $flightData['airline_iata'] : $flightData['airline_icao'],
                        'arrAirport' => $airports[$flightData['arr_iata']]['name'] ?? '', // Access from $airports
                        'arrAirport_city' => $arr_city,
                        'arrAirport_state' => $airports[$flightData['arr_iata']]['state'] ?? '', // Access from $airports
                        'arrAirport_country' => $airports[$flightData['arr_iata']]['country'] ?? '', // Access from $airports
                        'depAirport' => $airports[$flightData['dep_iata']]['name'] ?? '', // Access from $airports
                        'depAirport_city' => $dep_city,
                        'depAirport_state' => $airports[$flightData['dep_iata']]['state'] ?? '', // Access from $airports
                        'depAirport_country' => $airports[$flightData['dep_iata']]['country'] ?? '', // Access from $airports
                        'dep_code' => $depCode,
                        'dep_city' => $dep_city,
                        'arr_code' => $arrCode,
                        'arr_city' => $arr_city,
                        'tz_dep' => $tz_dep,
                        'tz_arr' => $tz_arr,
                        'status' => $flightData['status'],
                    ];
                }
                // Execute the batch insert
                if (!empty($insert_data)) {
                    $query = "INSERT INTO {$wpdb->prefix}schedule_details 
                        (`schedule_id`, `offset_page`, `flight_iata`, `flight_icao`, `airline_iata`, 
                         `airline_icao`, `airport`, `airline_name`, `depart`, `arrive`, `dep_iata`, 
                         `dep_icao`, `dep_city`, `arr_iata`, `arr_icao`, `arr_city`, `tz_dep`, 
                         `tz_arr`, `status`, `dep_terminal`, `arr_terminal`) 
                        VALUES " . implode(', ', $insert_data);

                    $wpdb->query($query);
                }


                $end_time_save = microtime(true);
                $timings['save'] = ($end_time_save - $start_time_save) * 1000; // tiempo en milisegundos

                if (!empty($formattedFlights)) {
                    // Añadir encabezado Server-Timing
                    $timing_header = 'Server-Timing: ';
                    foreach ($timings as $key => $dur) {
                        $timing_header .= "$key;dur=$dur, ";
                    }
                    $timing_header = rtrim($timing_header, ', ');
                    header($timing_header);

                    return new WP_REST_Response($formattedFlights, 200);
                } else {
                    return new WP_Error('api_fetch_error', 'Error en guardar la informacion en la tabla schedule_details', ['status' => 404]);
                }
            }

        default:
            return new WP_Error('invalid_request', 'Tipo de solicitud no válida.', ['status' => 400]);
    }
}

function enqueue_react_app_script()
{
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


function generar_shortcode_react_app($atts, $content, $tag)
{
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
        'time_range' => '',
        'terminal' => '', // New parameter for terminal filtering
        'delayed_time' => '',
        'delayed_type' => ''
    ], $atts);

    // Validación básica
    if (($tag == 'arrivals_app' || $tag == 'departures_app') && empty($atts['iata_code']) && empty($atts['icao_code'])) {
        return "Por favor, incluye al menos el IATA code o el ICAO code del aeropuerto para proceder.";
    }
    if ($tag == 'numero-vuelo' && empty($atts['flight_iata']) && empty($atts['flight_icao'])) {
        return "Por favor, incluye al menos el IATA code o el ICAO code del vuelo para proceder.";
    }

    if ($tag == 'delayed_flights' && empty($atts['delayed_time']) && empty($atts['delayed_type'])) {
        return "Por favor, incluye ambos parametros delayed_type y delayed_time para los delayed_flights";
    }

    $type = $tag == 'departures_app' ? 'departures' : ($tag == 'arrivals_app' ? 'arrivals' : ($tag == 'delayed_flights' ? 'delayed_flights' : 'flight'));
    $airportCode = !empty($atts['iata_code']) ? $atts['iata_code'] : $atts['icao_code'];
    $airp_codeType = !empty($atts['iata_code']) ? 'iata' : 'icao'; //Definir el tipo de codigo del aeropuerto, iata o icao
    $airlineCode = !empty($atts['airline_iata']) ? $atts['airline_iata'] : $atts['airline_icao'];
    $airl_codeType = !empty($atts['airline_iata']) ? 'iata' : 'icao'; //Definir el tipo de codigo de la aerolinea, iata o icao
    $flightCode = !empty($atts['flight_iata']) ? $atts['flight_iata'] : $atts['flight_icao'];
    $flight_codeType = !empty($atts['flight_iata']) ? 'iata' : 'icao'; //Definir el tipo de codigo del vuelo, iata o icao
    $status = $atts['status'];
    $time_range = $atts['time_range'];
    $terminal = $atts['terminal']; // Recuperar el valor del terminal
    $delayed_time = $atts['delayed_time'];
    $delayed_type = $atts['delayed_type'];

    // Recuperar los valores guardados en los ajustes del plugin
    return "<div class='react-app-container' data-react-app='mi-react-app' data-flight='{$flightCode}' data-flight-codetype='{$flight_codeType}' data-airport-code='{$airportCode}' data-airp-codetype='{$airp_codeType}' data-type='{$type}' data-size='{$atts['size']}' data-airline='{$airlineCode}' data-airl-codetype='{$airl_codeType}' data-status='{$status}' data-time-range='{$time_range}' data-terminal='{$terminal}' data-delayed-time='{$delayed_time}' data-delayed-type='{$delayed_type}'></div>";
}

add_shortcode('arrivals_app', 'generar_shortcode_react_app');
add_shortcode('departures_app', 'generar_shortcode_react_app');
add_shortcode('numero-vuelo', 'generar_shortcode_react_app'); // Registrar el nuevo shortcode
add_shortcode('delayed_flights', 'generar_shortcode_react_app');

// Añadir la página de configuraciones y registrar las opciones
add_action('admin_menu', 'mi_plugin_menu');

function mi_plugin_menu()
{
    add_options_page('Configuración del Plugin de Vuelos', 'Vuelos Settings', 'manage_options', 'mi-plugin-settings', 'mi_plugin_settings_page');
}

function mi_plugin_settings_page()
{
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

function mi_plugin_docs_page()
{
?>
    <div class="wrap">
        <h2>Documentación del Plugin de Vuelos</h2>
        <p>Aquí puedes encontrar cómo usar el plugin, consejos de integración y solución de problemas comunes.</p>

        <!-- Uso Básico -->
        <h3>Uso Básico</h3>
        <p>Para comenzar rápidamente con nuestro plugin, simplemente inserta uno de los siguientes shortcodes en cualquier página o entrada para mostrar información en tiempo real sobre vuelos.</p>

        <!-- New API Key section -->
        <h3>Configuración de API</h3>
        <p>El plugin requiere la API de AirLabs y la API de TimezoneDB para obtener la información de vuelos y las zonas horarias respectivamente.</p>
        <ul>
            <li><strong>API Key de AirLabs</strong>: Necesario para obtener información en tiempo real sobre los vuelos. Puedes conseguirlo en <a href="https://airlabs.co/">AirLabs</a>.</li>
            <li><strong>API Key de TimezoneDB</strong>: Necesario para obtener la hora local del aeropuerto. Puedes obtenerlo en <a href="https://timezonedb.com/">TimezoneDB</a>.</li>
        </ul>

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
            <li><strong>time_range</strong>: Establece un rango de tiempo en minutos para mostrar vuelos. Los vuelos que estén dentro del tiempo actual local del aeropuerto más el valor de `time_range` serán mostrados. (opcional)</li>
            <li><strong>terminal</strong>: Filtrar por terminal de llegada. (opcional)</li> <!-- New terminal parameter -->
        </ul>
        <p>
            <strong>Ejemplos:</strong>
        <ul>
            <li><code>[arrivals_app iata_code="JFK" size="5"]</code></li>
            <li><code>[arrivals_app iata_code="LAX" size="10" airline_iata="AA"]</code></li>
            <li><code>[arrivals_app icao_code="KMIA" size="15" status="cancelled"]</code></li>
            <li><code>[arrivals_app iata_code="JFK" size="5" time_range="60"]</code> - Muestra vuelos de llegada a JFK en el próximo rango de 60 minutos.</li>
            <li><code>[arrivals_app iata_code="LAX" size="10" airline_iata="AA" time_range="30"]</code> - Muestra vuelos de llegada de American Airlines (AA) en los próximos 30 minutos.</li>
            <li><code>[arrivals_app iata_code="LAX" size="10" terminal="A"]</code> - Filtra por vuelos que lleguen a la terminal A de LAX.</li> <!-- New example using terminal -->
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
            <li><strong>time_range</strong>: Establece un rango de tiempo en minutos para mostrar vuelos. Los vuelos que estén dentro del tiempo actual local del aeropuerto más el valor de `time_range` serán mostrados. (opcional)</li>
            <li><strong>terminal</strong>: Filtrar por terminal de salida. (opcional)</li> <!-- New terminal parameter -->
        </ul>
        <p>
            <strong>Ejemplos:</strong>
        <ul>
            <li><code>[departures_app iata_code="LAX" size="10"]</code></li>
            <li><code>[departures_app iata_code="LAX" size="10" airline_iata="AA"]</code></li>
            <li><code>[departures_app icao_code="KMIA" size="15" status="landed"]</code></li>
            <li><code>[departures_app iata_code="LAX" size="10" time_range="45"]</code> - Muestra vuelos de salida de LAX en el próximo rango de 45 minutos.</li>
            <li><code>[departures_app iata_code="LAX" size="10" airline_iata="AA" time_range="60"]</code> - Muestra vuelos de salida de American Airlines (AA) en los próximos 60 minutos.</li>
            <li><code>[departures_app iata_code="LAX" size="10" terminal="2"]</code> - Filtra por vuelos que salen de la terminal 2 de LAX.</li> <!-- New example using terminal -->
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

        <!-- New Section for Delayed Flights -->
        <h4>Vuelos Retrasados [delayed_flights]</h4>
        <p>Este shortcode muestra información sobre vuelos retrasados en un aeropuerto específico. Utiliza los siguientes parámetros para personalizar la salida:</p>
        <ul>
            <li><strong>airportCode</strong>: Código IATA o ICAO del aeropuerto. (opcional si se proporciona el tipo de código)</li>
            <li><strong>airp_codeType</strong>: Tipo de código del aeropuerto (opciones: `iata` o `icao`).</li>
            <li><strong>airlineCode</strong>: Código IATA o ICAO de la aerolínea (opcional).</li>
            <li><strong>airl_codeType</strong>: Tipo de código de la aerolínea (opciones: `iata` o `icao`).</li>
            <li><strong>delayed_type</strong>: Tipo de retraso (opciones: `arrivals` o `departures`).</li>
            <li><strong>delayed_time</strong>: Tiempo de retraso en minutos.</li>
            <li><strong>status</strong>: Filtrar vuelos por estado. (opcional) Valores posibles: 'scheduled', 'cancelled', 'active', 'landed'.</li>
            <li><strong>terminal</strong>: Filtrar por terminal del vuelo. (opcional)</li>
        </ul>

        <p><strong>Ejemplos:</strong></p>
        <ul>
            <li><code>[delayed_flights airportCode="LAX" airp_codeType="iata" delayed_type="departures" delayed_time="30"]</code> - Muestra vuelos de salida retrasados en LAX con retrasos de al menos 30 minutos.</li>
            <li><code>[delayed_flights airportCode="JFK" airp_codeType="icao" airlineCode="AA" airl_codeType="iata" delayed_type="arrivals" delayed_time="60"]</code> - Muestra vuelos de llegada retrasados de American Airlines (AA) a JFK con retrasos de al menos 60 minutos.</li>
        </ul>

        <!-- Configuración -->
        <h3>Configuración</h3>
        <p>Si deseas configurar manualmente los permalinks a su gusto, debes descargar el plugin Permalink Manager.</p>
        <p>Con este plugin puedes configurar y estructurar los permalinks para cada post, page, media, etc. que hayas definido.</p>
        <p>Se puede descargar el plugin Permalink Manager <a href="https://wordpress.org/plugins/permalink-manager/">aquí</a></p>

        <!-- Permalinks -->
        <h3>Estructura de Permalinks</h3>
        <p>Aquí está la estructura de los permalinks para los diferentes tipos de contenido:</p>
        <ul>
            <li><strong>Departures de Aeropuertos:</strong> /%country-taxonomy%/%state-taxonomy%/%city-taxonomy%/%airport-taxonomy%/departures</li>
            <li><strong>Arrivals de Aeropuertos:</strong> /%country-taxonom%/%state-taxonomy%/%city-taxonomy%/%airport-taxonomy%/arrivals</li>
            <li><strong>Vuelos:</strong> /flight/%flight_number%/</li>
            <li><strong>Aerolíneas (Departures):</strong> /%country-taxonomy%/%state-taxonomy%/%city-taxonomy%/%airport-taxonomy%/departures/%airline_code%</li>
            <li><strong>Aerolíneas (Arrivals):</strong> /%country-taxonomy%/%state-taxonomy%/%city-taxonomy%/%airport-taxonomy%/arrivals/%airline_code%</li>
        </ul>

        <!-- Popups -->
        <h3>Ver Datos de JSON</h3>
        <p>Puedes ver los datos de los aeropuertos y aerolíneas cargados usando los siguientes enlaces:</p>
        <ul>
            <li><a href="javascript:void(0);" onclick="openPopup('airports-popup');">Ver Aeropuertos</a></li>
            <li><a href="javascript:void(0);" onclick="openPopup('airlines-popup');">Ver Aerolíneas</a></li>
        </ul>

        <!-- Popup para Aeropuertos -->
        <div id="airports-popup" class="popup-overlay">
            <div class="popup-content">
                <span class="close" onclick="closePopup('airports-popup')">&times;</span>
                <h2>Aeropuertos Cargados</h2>
                <div class="loading">Cargando...</div>
                <div id="airports-table"></div>
            </div>
        </div>

        <!-- Popup para Aerolíneas -->
        <div id="airlines-popup" class="popup-overlay">
            <div class="popup-content">
                <span class="close" onclick="closePopup('airlines-popup')">&times;</span>
                <h2>Aerolíneas Cargadas</h2>
                <div class="loading">Cargando...</div>
                <div id="airlines-table"></div>
            </div>
        </div>

    </div>

    <style>
        .popup-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            display: none;
            justify-content: center;
            align-items: center;
        }

        .popup-content {
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            width: 80%;
            max-height: 80%;
            overflow-y: auto;
            position: relative;
        }

        .popup-content .close {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 24px;
            cursor: pointer;
        }

        .loading {
            text-align: center;
            font-size: 18px;
            padding: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
        }
    </style>

    <script>
        function openPopup(id) {
            document.getElementById(id).style.display = 'flex';
            if (id === 'airports-popup') {
                loadJSONData('airports.json', 'airports-table');
            } else if (id === 'airlines-popup') {
                loadJSONData('airlines.json', 'airlines-table');
            }
        }

        function closePopup(id) {
            document.getElementById(id).style.display = 'none';
        }

        function loadJSONData(jsonFile, tableId) {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', '<?php echo plugins_url('react-plugin/') ?>' + jsonFile, true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    var data = JSON.parse(xhr.responseText);
                    var table = document.getElementById(tableId);
                    var loading = document.querySelector(`#${tableId} ~ .loading`);
                    loading.style.display = 'none';

                    var headers = Object.keys(data.response[0]);
                    var tableHTML = '<table><thead><tr>';
                    headers.forEach(function(header) {
                        tableHTML += '<th>' + header + '</th>';
                    });
                    tableHTML += '</tr></thead><tbody>';
                    data.response.forEach(function(row) {
                        tableHTML += '<tr>';
                        headers.forEach(function(header) {
                            tableHTML += '<td>' + row[header] + '</td>';
                        });
                        tableHTML += '</tr>';
                    });
                    tableHTML += '</tbody></table>';
                    table.innerHTML = tableHTML;
                }
            };
            xhr.send();
        }
    </script>
<?php
}


// Hook para inicializar la configuración
add_action('admin_init', 'mi_plugin_settings_init');

function mi_plugin_settings_init()
{
    // Registro de las configuraciones del plugin
    register_setting('mi-plugin-settings-group', 'mi_plugin_api_key');
    register_setting('mi-plugin-settings-group', 'mi_plugin_timezone_db_key'); // New API key for TimezoneDB
    register_setting('mi-plugin-settings-group', 'mi_plugin_data_expiration');

    // Añadir sección de configuración
    add_settings_section('mi-plugin-settings-section', 'Ajustes del API', 'mi_plugin_settings_section_callback', 'mi-plugin-settings');

    // Añadir campos de configuración
    add_settings_field('mi-plugin-api-key', 'API Key de AirLabs', 'mi_plugin_api_key_callback', 'mi-plugin-settings', 'mi-plugin-settings-section');
    add_settings_field('mi-plugin-timezone-db-key', 'API Key de TimezoneDB', 'mi_plugin_timezone_db_key_callback', 'mi-plugin-settings', 'mi-plugin-settings-section'); // New field for TimezoneDB
    add_settings_field('mi-plugin-data-expiration', 'Tiempo de Expiración de Datos (minutos)', 'mi_plugin_data_expiration_callback', 'mi-plugin-settings', 'mi-plugin-settings-section');
}

function mi_plugin_settings_section_callback()
{
    echo 'Ingresa tus API Keys y el tiempo de expiración de los datos almacenados.';
}

function mi_plugin_api_key_callback()
{
    $api_key = get_option('mi_plugin_api_key');
    echo "<input type='text' id='mi_plugin_api_key' name='mi_plugin_api_key' value='" . esc_attr($api_key) . "' />";
}

function mi_plugin_timezone_db_key_callback()
{
    $timezone_db_key = get_option('mi_plugin_timezone_db_key');
    echo "<input type='text' id='mi_plugin_timezone_db_key' name='mi_plugin_timezone_db_key' value='" . esc_attr($timezone_db_key) . "' />";
}

function mi_plugin_data_expiration_callback()
{
    $expiration = get_option('mi_plugin_data_expiration', 30); // Valor predeterminado de 30 minutos
    echo "<input type='number' id='mi_plugin_data_expiration' name='mi_plugin_data_expiration' value='" . esc_attr($expiration) . "' min='1' />";
}

// Función para añadir el enlace de configuración directamente en la página de plugins
function mi_plugin_add_settings_link($links)
{
    $settings_link = '<a href="options-general.php?page=mi-plugin-settings">' . __('Settings') . '</a>';
    array_push($links, $settings_link);
    return $links;
}

function mi_plugin_add_admin_pages()
{
    add_options_page(
        'Documentación del Plugin de Vuelos',  // Título de la página
        'Docs Plugin de Vuelos',              // Título del menú
        'manage_options',                     // Capacidad requerida
        'mi_plugin_docs_page',                // Slug del menú
        'mi_plugin_docs_page'                 // Función que muestra el contenido de la página
    );
}
add_action('admin_menu', 'mi_plugin_add_admin_pages');

function mi_plugin_add_docs_link($links)
{
    $docs_link = '<a href="' . admin_url('admin.php?page=mi_plugin_docs_page') . '">' . __('Docs') . '</a>';
    array_push($links, $docs_link);  // Añade al final de los enlaces existentes
    return $links;
}


$plugin = plugin_basename(__FILE__);
add_filter("plugin_action_links_$plugin", 'mi_plugin_add_settings_link');
add_filter("plugin_action_links_$plugin", 'mi_plugin_add_docs_link');
?>