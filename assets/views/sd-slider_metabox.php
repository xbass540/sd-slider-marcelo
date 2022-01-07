<?php 
    $meta = get_post_meta( $post->ID );
    $link_text = get_post_meta( $post->ID, 'sd_slider_link_text', true );
    $link_url = get_post_meta( $post->ID, 'sd_slider_link_url', true );
    //var_dump( $link_text, $link_url );
?>
<table class="form-table sd-slider-metabox"> 
<input type="hidden" name="sd_slider_nonce" value="<?php echo wp_create_nonce( "sd_slider_nonce" ); ?>">
    <tr>
        <th>
            <label for="sd_slider_link_text"><?php esc_html_e( 'Link Text', 'sd-slider' ); ?></label>
        </th>
        <td>
            <input 
                type="text" 
                name="sd_slider_link_text" 
                id="sd_slider_link_text" 
                class="regular-text link-text"
                value="<?php echo ( isset( $link_text ) ) ? esc_html( $link_text ) : ''; ?>"
                required
            >
        </td>
    </tr>
    <tr>
        <th>
            <label for="sd_slider_link_url"><?php esc_html_e( 'Link URL', 'sd-slider' ); ?></label>
        </th>
        <td>
            <input 
                type="url" 
                name="sd_slider_link_url" 
                id="sd_slider_link_url" 
                class="regular-text link-url"
                value="<?php echo ( isset( $link_url ) ) ? esc_url( $link_url ) : ''; ?>"
                required
            >
        </td>
    </tr>               
</table>