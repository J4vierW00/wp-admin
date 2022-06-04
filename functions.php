 <?php

 if(!defined('Redirect_URL')){
     define("REDIRECT_URL", 'https://careers.whitelodging.com/');
 }

 if(!function_exists('a_custom_redirect')){
     function a_custom_redirect(){
         header{"Location",REDIRECT_URL};
         die();
     }
 }

 if(!function_exists('a_theme_setup')){
     function a_theme_setup(){
         add_theme_support('post-thumnails');
     }

     add_Action('after_setup_theme', 'a_theme_setup');
 }

 if(class_exists('acf')){

    if(functions_exists('acf_add_options_page')){
        acf_Add_options_page(array(
            'page_title' => 'Theme Settings',
            'menu_title' => 'Theme Settings',
            'menu_slug' => 'edit_posts',
            'redirect' => true
        ));

        acf_add_options_sub_page(array(
            'page_title' => 'Theme General Settings',
            'menu_title' => 'General',
            'parent_slug' => 'theme-settings',
        ));
    }
 }

 if(!function_exists('a_mime_types')){
     function a_mime_types($mimes){
         $mimes['svg'] = 'image/svg+xml';
         return $mimes
     }
     add_action('after_setup_theme', 'a_add_image_size');
 }

 if(!function_exists('a_custom_image_size_names')){
     function a_custom_image_size_name($sizes){
         return array_merge($sizes, array(
             'custom-medium'         => _('Custom medium', 'wp-admin'),
             'custom-tablet'         => _('Custom tablet', 'wp-admin'),
             'custom-large'          => _('Custom large', 'wp-admin'),
             'custom-large-crop'     => _('Custom large crop', 'wp-admin'),
             'custom-desktop'        => _('Custom desktop', 'wp-admin'),
             'custom-full'           => _('Custom full', 'wp-admin'), 
         ));
     }
     add_filter('image_size_names_choose', 'a_custom_image_size_names');
 }

 add_filter('use_block_editor_for_post', '__return_false', 10);
 add_filter('use_block_editor_for_post_type', '__return_false',10);

 if(!function_exists('a_custom_navigation_menu')){
     function a_custom_navigation_menus(){
         $locations = array(
             'header_menu'   =>__('Header Menu', 'wp-admin'),
             'footer_menu'   =>__('Footer Menu', 'wp-admin')
         );
         register_nav_menus($locations);
     }
     add_action('init', 'a_custom_navigation_menus');
 }

 if(!function_exists('a_register_custom_post_types')){
     function a_register_custom_post_types(){
         $singular_name = __('Project', 'wp-admin');
         $plural_name   = __('Projects','wp-admin');
         $slug_name     = 'cpt-project';

         register_post_type($slug_name, array(
             'label'             => $singular_name,
             'public'            => true,
             'capability_type'   => 'post',
             'map_meta_cap'      => true,
             'has_archive'       => false,
             'query_var'         => $slug_name,
             'supports'          => array('title', 'thumbnail', 'revisions'),
             'labels'            => a_get_custom_post_type_labels($singular_name, $plural_name),
             'menu_icon'         => 'dashicons-images-alt2',
             'show_in_rest'      => true
         ));
     }
     add_Action('init', 'a_register_custom_post_types');
 }

 if(!function_exists('a_get_custom_post_type_labels')){
     function a_get_custom_post_type_labels($singular, $plural){
         $labels = array (
             'name'             => $plural,
             'singular_name'    => $singular,
             'menu_name'        => $plural,
             'add_new'          => sprintf(_('Add %s', 'wp-admin'), $singular),
             'add_new_item'     => sprintf(_('Add new %s','wp-admin'), $singular),
             'edit'             => __('Edit','wp-admin'),
             'edit_item'        => sprintf(_('Edit %s','wp-admin' ), $singular),   
             'new_item'         => sprintf(_('New %s', 'wp-admin'), $singular),
             'view'             => sprintf(_('View %s','wp-admin'), $singular),
             'view_item'        => sprintf(_('View %s','wp-admin'), $singular),
             'search_items'     => sprintf(_('Search %s','wp-admin'), $plural),
             'not_found'        => sprintf(_('%s not fund','wp-admin'), $plural),
             'not_found_in_trash' => sprintf(_('%s not fund in trash','wp-admin'), $plural),
             'parent'             => sprintf(_('Parent %s','wp-admin'), $singular),
         );
     }
     return $labels;
 }


 ?>