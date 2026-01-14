<div class="wrap">
    <h1>Movie Search instellingen</h1>

    <?php if (isset($_GET['updated'])): ?>
        <div class="updated notice"><p>Instellingen opgeslagen</p></div>
    <?php endif; ?>

    <form method="post" action="<?= admin_url('admin-post.php'); ?>">
        <?php wp_nonce_field('ms_save_settings'); ?>
        <input type="hidden" name="action" value="ms_save_settings">

        <table class="form-table">
            <tr>
                <th>API URL</th>
                <td>
                    <input type="text" name="ms_api_url"
                           value="<?= esc_attr($settings->get_api_url()); ?>"
                           class="regular-text">
                </td>
            </tr>

            <tr>
                <th>API Key</th>
                <td>
                    <input type="password" name="ms_api_key"
                           value="<?= esc_attr($settings->get_api_key()); ?>"
                           class="regular-text">
                </td>
            </tr>

            <tr>
                <th>Type</th>
                <td>
                    <select name="ms_type">
                        <option value="movie" <?= selected($settings->get_type(), 'movie'); ?>>Movie</option>
                        <option value="series" <?= selected($settings->get_type(), 'series'); ?>>Series</option>
                    </select>
                </td>
            </tr>
        </table>

        <?php submit_button(); ?>
    </form>
</div>
