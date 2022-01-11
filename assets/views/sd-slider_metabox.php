<?php 
    $meta = get_post_meta( $post->ID ); // i fetch the post id using a post method to the DB
    $link_text = get_post_meta( $post->ID, 'sd_slider_link_text', true );// i fetch the slider text using a post method to the DB
    $link_url = get_post_meta( $post->ID, 'sd_slider_link_url', true );// i fetch the slider link url using a post method to the DB
    //var_dump( $link_text, $link_url );
?>
c
<table class="form-table sd-slider-metabox"> c
<input type="hidden" name="sd_slider_nonce" value="<?php echo wp_create_nonce( "sd_slider_nonce" ); ?>"> <!-- this creates a specific nonse for the input field -->
    <tr>
        <th>
            <label for="sd_slider_link_text"><?php esc_html_e( 'Link Text', 'sd-slider' ); ?></label>
        </th>
        <td> <!-- escaping the value of the inputed field  -->
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
        <th> <!-- escaping the value of the inputed field  -->
            <label for="sd_slider_link_url"><?php esc_html_e( 'Link URL', 'sd-slider' ); ?></label>
        </th>
        <td> <!-- escaping the value of the inputed field  -->
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