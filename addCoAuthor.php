 <?php
 /**
 * Add current logged in user as a co-author of a post.
 * This function works as a extension with WP plugin: Co-Authors Plus
 *
 * @since 3.3.0
 *
 */
function addUser(){
    $current_user = wp_get_current_user();
    $post = get_post();
    
    $coauthor_taxonomy = 'author';

    $coauthors = array( $current_user->user_login );
    $existing_coauthors = wp_list_pluck( get_coauthors( $post->ID ), 'user_login' );
    $coauthors = array_unique( array_merge( $existing_coauthors, $coauthors ) );

    wp_set_post_terms( $post->ID, $coauthors, $coauthor_taxonomy, false );
}
?>
 
 <a href="<?php echo("$PHP_SELF?anmelden")?>">ANMELDEN: Mich als Teilnehmer auf diesem Anlass eintragen.</a><p><br>
 
 <?php 
    if (isset($_GET['anmelden'])) {
        addUser();
      }
 ?>

