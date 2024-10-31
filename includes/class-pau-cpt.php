<?php

class PAU_CPT {

    public function pau() {

        $labels = [
            'name' => __( 'Plurar', 'pau-universal-accessibility' ),
            'singular_name' => __( 'Singular', 'pau-universal-accessibility' ),
            'add_new' => __( 'Add new', 'pau-universal-accessibility' ),
            'add_new_item' => __( 'Add new item', 'pau-universal-accessibility' ),
            'edit_item' => __( 'Edit item', 'pau-universal-accessibility' ),
            'view_item' => __( 'View item', 'pau-universal-accessibility' ),
            'featured_image' => __( 'Cover image items', 'pau-universal-accessibility' ),
            'set_featured_image' => __( 'Define cover item', 'pau-universal-accessibility' ),
            'remove_featured_image' => __( 'Delete cover item', 'pau-universal-accessibility' ),
            'use_featured_image' => __( 'Use an item image.', 'pau-universal-accessibility' ),
        ];

        $args = [
            'labels' => $labels,
            'public' => true,
            'has_archive' => true,
            'supports' => [ 'title', 'editor', 'thumbnail' ],
            'capability_type' => 'post',
            'show_ui' => true,
            'show_in_menu' => true,
            'show_in_nav_menus' => false,
            'show_in_admin_bar' => false,
            'rewrite' => [ 'slug' => 'items' ],
        ];

        register_post_type( 'pau_post_type', $args );

        flush_rewrite_rules();

    }

}
