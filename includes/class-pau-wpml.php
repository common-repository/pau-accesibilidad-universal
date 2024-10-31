<?php

class PAU_WPML {

    private $args = [
        'post_status'     => 'publish',
        'posts_per_page'  => -1,
        'post_type'       => 'page'
    ];

    public function is_active() {
        if( is_plugin_active( 'sitepress-multilingual-cms/sitepress.php' ) ) return true;
        return false;
    }

    public function get_langs() {

        return apply_filters( 'wpml_active_languages', NULL, 'orderby=id&order=desc' );

    }

    public function get_current_lang() {

        return apply_filters( 'wpml_current_language', NULL );

    }

    public function get_default_lang() {

        return apply_filters( 'wpml_default_language', NULL );

    }

    public function do_switch_lang( $query ) {

        do_action( 'wpml_switch_language', $this->lang );

    }

    public function switch_lang() {

        add_action( 'pre_get_posts', [ $this, "do_switch_lang" ] );

    }

    public function getOptionsPage( $lang = "" ) {

        $this->lang = $lang;

        if( $this->lang == "" ) $this->lang = $this->get_current_lang();

        $this->switch_lang();

        // var_dump( $this->args );

        $options = [];
        $query   = new WP_Query( $this->args );

        // var_dump( $query );
        while( $query->have_posts() ) {

            $query->the_post();
            $id        = get_the_ID();
            $title     = get_the_title();

            $options[ $id ] = $title;

        }

        wp_reset_query();

        return $options;

    }

}
