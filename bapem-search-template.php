<?php
/*
Template Name: BAPEM Search Template
*/

get_header();
$view = quest_get_view();
?>

<div id="content">
	<?php quest_title_bar( $view ); ?>

	<div class="quest-row site-content">
		<div class="<?php echo apply_filters( 'quest_content_container_cls', 'container' ); ?>">
			<div class="row">

				<?php quest_try_sidebar( $view, 'left' ); ?>

				<div id="primary" class="content-area single <?php quest_main_cls(); ?>">
					<main id="main" class="site-main" role="main">
                                            <form class="form-horizontal" method="post">
                                                <div class="form-group">
                                                    <label for="name" class="control-label col-xs-2">Nom de l'élu</label>
                                                    <div class="col-xs-10">
                                                      <input type="text" class="form-control" id="name" name="lastname" placeholder="Nom">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="firstname" class="control-label col-xs-2">Prénom de l'élu</label>
                                                    <div class="col-xs-10">
                                                        <input type="text" class="form-control" id="firstname" name="firstname" placeholder="Prénom">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="position" class="control-label col-xs-2">Fonction</label>
                                                    <div class="col-xs-10">
                                                        <input type="text" class="form-control" id="position" name="position" placeholder="Fonction">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="county" class="control-label col-xs-2">Comté</label>
                                                    <div class="col-xs-10">
                                                        <input type="text" class="form-control" id="county" name="county" placeholder="Comté">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="muncipality" class="control-label col-xs-2">Municipalité</label>
                                                    <div class="col-xs-10">
                                                        <input type="text" class="form-control" id="muncipality" name="muncipality" placeholder="Municipalité">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-xs-offset-2 col-xs-10">
                                                        <input type="submit" value="Submit" name="searchpost">
                                                    </div>
                                                </div>
                                            </form>
					</main>
                                        <?php if ( isset($_POST['searchpost']) ) {
                                            //Names used in input form needs to be linked to names of custom post fields
                                            $translation_custom_field = array(
                                                "lastname" => "Nom de l'élu",
                                                "firstname" => "Prénom de l'élu",
                                                "position" => "Fonction",
                                                "county" => "Comté",
                                                "muncipality" => "Municipalité"
                                            );
                                            $post_args = array();
                                            $post_args[''] = array(
                                                'relation' => 'AND' 
                                            );
                                            foreach ($_POST as $key => $value) {
                                                if($value != "" && $key != "searchpost") {
                                                    $post_args[] = array(
                                                        'key'		=> $translation_custom_field[$key],
                                                        'value'		=> $value,
                                                        'compare'	=> '='
                                                    );
                                                } 
                                                
                                            }
                                            // args   
                                            $args = array(
                                                    "posts_per_page" => 10,
                                                    'paged' => ( get_query_var('page') ? get_query_var('page') : 1),
                                                    'post_type'	=> 'bapem',
                                                    'meta_query' => $post_args
                                            );
                                            // query
                                            $the_query = new WP_Query( $args );
                                            echo ($the_query->found_posts > 0) ? '<h3 class="foundPosts">' . $the_query->found_posts. ' listings found</h3>' : '<h3 class="foundPosts">We found no results</h3>';
                                            echo '<table class="table"> 
                                                        <thead>
                                                            <tr> <th>Nom</th> <th>Prénom</th> <th>Fonction</th> <th>Municipalité</th> <th>Date début</th><th>Date fin</th> </tr> 
                                                        </thead> 
                                                        <tbody>';
                                            while ( $the_query->have_posts() ) : $the_query->the_post();
                                                echo ' <tr> <td> ' . get_post_meta( get_the_ID(), "Nom de l'élu", true ) . ' </td> '
                                                        . ' <td> ' . get_post_meta( get_the_ID(), "Prénom de l'élu", true ) . ' </td> '
                                                        . ' <td> ' . get_post_meta( get_the_ID(), "Fonction", true ) . ' </td> '
                                                        . ' <td> ' . get_post_meta( get_the_ID(), "Municipalité", true ) . ' </td> '
                                                        . ' <td> ' . get_post_meta( get_the_ID(), "Date début", true ) . ' </td> '
                                                        . ' <td> ' . get_post_meta( get_the_ID(), "Date fin", true ) . ' </td> '
                                                        . ' </tr>'; 
                                            endwhile; wp_reset_postdata();
                                            echo '</tbody>
                                                </table>';
                                            //$big = 999999999; // need an unlikely integer

                                            /*echo paginate_links( array(
                                                'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                                                'format' => '?paged=%#%',
                                                'prev_text'          => __(' Previous'),
                                                'next_text'          => __('Next '),
                                                'current' => max( 1, get_query_var('paged') ),
                                                'total' => $the_query->max_num_pages
                                            ) );*/
                                            ?>
                                        <?php } ?>
					<!-- #main -->
				</div>
				<!-- #primary -->

				<?php quest_try_sidebar( $view, 'right' ); ?>

			</div>
			<!-- .row -->
		</div>
		<!-- .container -->
	</div>
	<!-- .quest-row -->
</div><!-- #content -->
<?php get_footer(); ?>
