<form id="wrp_dashboard_form">
    <table class="form-table" role="presentation">
        <tbody>

            <tr>
                <th scope="row">
                    <label for="wrp_no_of_posts"><?php echo esc_html__( 'No of posts', 'wd-recent-posts' ); ?></label>
                </th>
                <td>
                    <input
                    name="wrp_no_of_posts"
                    type="text"
                    id="wrp_no_of_posts"
                    value="<?php echo esc_attr( $wrp_no_of_posts ); ?>"
                    class="regular-text"
                    placeholder="Example: 10"
                    />
                </td>
            </tr>

            
            <tr>
                <th scope="row">
                    <label for="wrp_order">Post Order</label>
                </th>
                <td>
                    <select name="wrp_order" id="wrp_order">
                        <option selected="selected" value="subscriber">Select one</option>
                        <option value="ASC" <?php selected( 'ASC' === $wrp_order, 1 ); ?>>ASC</option>
                        <option value="DESC" <?php selected( 'DESC' === $wrp_order, 1 ); ?>>DESC</option>
                    </select>
                </td>
            </tr>

            <tr>
            <th scope="row">Categories</th>
                <td>
                    <fieldset>
                        <?php foreach( $categories as $category ): ?>

                            <label for="<?php echo esc_attr( $category->slug ); ?>">
                                <input
                                    name="wrp_category_items[]"
                                    type="checkbox"
                                    id="<?php echo esc_attr( $category->slug ); ?>"
                                    value="<?php echo esc_attr( $category->slug ); ?>"
                                    <?php
                                        if ( ! empty( $category_items ) ) {
                                            checked( in_array( $category->slug, $category_items ), 1 ); 
                                        }
                                    ?>
                                />
                                <?php echo esc_html__( $category->name, 'wd-recent-posts' ); ?>
                            </label><br/>

                        <?php endforeach; ?>
                    </fieldset>
                </td>
            </tr>

            <tr>
                <th scope="row">
                     <p class="submit">
                        <input type="submit" name="wrp_save" id="wrp_save" class="button button-primary" value="Save">
                    </p>
                </th>
                <td>
                   
                </td>
            </tr>

        </tbody>
    </table>
</form>

<div id="wrp_list_container">

    <?php 
        if ( $the_query->have_posts() ) {
            while( $the_query->have_posts() ) {
                $the_query->the_post();
                ?>
                <p>
                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                </p>
                <?php
            }
        }
    ?>

</div>
