<?php

Class MS_Settings extends Singleton {

    public function render__ms_setting_api_url() {
        $value = get_option( 'ms_setting__api_url' );
        if ( false === $value ) {
            // $value = MS_API;
        }

        ?>
            <input type="text" name="ms_setting_api_url" value="<?= esc_attr($value) ?>" />
        <?php
    }


    public function handle_post($POST) {

    }
}