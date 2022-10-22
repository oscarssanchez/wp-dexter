<?php
/**
 * Dexter's settings page
 *
 * @package WpDexter
 */

namespace WpDexter;

if (! ( $this instanceof Admin ) ) {
    return;
}

$wp_dexter_pokemon_generation = get_option('wp_dexter_pokemon_generation', 251);
?>
<div class="wrap">
    <h2><?php echo esc_html($GLOBALS['title']); ?></h2>
    <div class="pokepostbox postbox">
        <h3><?php esc_html_e('Settings', 'wp-dexter'); ?></h3>
        <p><?php esc_html_e('Currently picking up from:', 'wp-dexter'); ?> <span class="pokebold"><?php echo esc_html(sprintf(__('%s Pokemon', 'wp-dexter'), $wp_dexter_pokemon_generation)); ?></span></p>
        <form method="post" action="<?php echo admin_url('admin-post.php'); ?>">
            <input type="hidden" name="action" value="wp-dexter-save">
            <label for="pokemon_generation"><?php esc_html_e(' Show until which generation?', 'wp-dexter'); ?></label>
            <select name="pokemon_generation">
                <?php
                $generation_list = $this->plugin->components->api->get_generations();
                foreach( $generation_list as $pokemon_generation ) {
                    echo '<option value="' . esc_attr($pokemon_generation['gen_number']) . '">' . esc_html($pokemon_generation['gen_name']) . '</option>';
                }
                ?>
            </select>
            <?php wp_nonce_field(self::NONCE_ACTION, self::NONCE_NAME); ?>
            <?php submit_button(esc_html('Save changes', 'wp-dexter')); ?>
        </form>
    </div>
</div>
