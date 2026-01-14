<?php

if (!defined('ABSPATH')) exit;

class MS_Shortcode
{

    private $settings;

    public function __construct()
    {
        $this->settings = new MS_Settings();
        add_shortcode('movie_search', [$this, 'render']);
        add_action('wp_enqueue_scripts', [$this, 'assets']);
    }


    public function assets()
    {
        wp_enqueue_style(
            'ms-frontend',
            MS_PLUGIN_URL . 'assets/css/frontend.css'
        );
    }

    public function render()
    {
        ob_start();
?>
        <form method="get" class="ms-search">
            <input type="text" name="movie" placeholder="Zoek een film">
            <button>Zoeken</button>
        </form>
<?php

        if (!empty($_GET['movie'])) {
            $this->search($_GET['movie']);
        }

        return ob_get_clean();
    }

    private function search($query)
    {
        $api_url = $this->settings->get_api_url();
        $api_key = $this->settings->get_api_key();
        $type    = $this->settings->get_type();

        // Stap 1: zoek films
        $search_params = [
            'apikey' => $api_key,
            's'      => sanitize_text_field($query),
            'type'   => $type,
        ];

        $search_url = add_query_arg($search_params, $api_url);
        $response = wp_remote_get($search_url);

        if (is_wp_error($response)) {
            echo '<p>Fout bij ophalen van data</p>';
            return;
        }

        $data = json_decode(wp_remote_retrieve_body($response), true);

        if (empty($data['Search'])) {
            echo '<p>Geen resultaten</p>';
            return;
        }

        echo '<ul>';
        foreach ($data['Search'] as $movie) {
            // Stap 2: haal detail info op per film
            $detail_params = [
                'apikey' => $api_key,
                'i'      => $movie['imdbID'],
            ];
            $detail_url = add_query_arg($detail_params, $api_url);
            $detail_response = wp_remote_get($detail_url);

            if (is_wp_error($detail_response)) continue;

            $details = json_decode(wp_remote_retrieve_body($detail_response), true);

            $title = esc_html($details['Title']);
            $rating = isset($details['imdbRating']) ? esc_html($details['imdbRating']) : 'n.v.t.';
            $released = isset($details['Released']) ? esc_html($details['Released']) : 'n.v.t.';

            echo "<li><strong>$title</strong> — Rating: $rating — Released: $released</li>";
        }
        echo '</ul>';
    }
}
