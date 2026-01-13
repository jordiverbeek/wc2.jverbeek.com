<?php
include MS_PLUGIN_DIR . 'core/singleton.php';

class MS_Core
{
    private $admin;
 
    public function __construct()
    {
        include_once MS_PLUGIN_DIR . 'admin/settings.php';
        include_once MS_PLUGIN_DIR . 'admin/admin.php';

        $this->admin = new MS_Admin();
    }
}
