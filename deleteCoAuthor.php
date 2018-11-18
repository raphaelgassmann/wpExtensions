<?php
 /**
 * Delete current logged in user as a co-author of a post.
 * This function works as a extension with WP plugin: Co-Authors Plus
 *
 * @since 3.3.0
 *
 */
function deleteUser(){
    $current_user = wp_get_current_user();
    $post = get_post();
    $coauthor_taxonomy = 'author';
    $coauthors = array();

    $existing_coauthors = get_coauthors( $post->ID );

    foreach ( $existing_coauthors as $author ) {
        if ( $author->ID == $current_user->ID) {
            //remove procedure -> skip for user that needs to be removed
        }else{
            $remainingAuthor = array($author->user_login);
            $coauthors = array_unique( array_merge( $coauthors, $remainingAuthor ) );    
        }
    }
    wp_set_post_terms( $post->ID, $coauthors, $coauthor_taxonomy, false );
}
?>

 <a href="<?php echo("$PHP_SELF?abmelden")?>">ABMELDEN: Mich als Teilnehmer auf diesem Anlass entfernen.</a><p><br>

 <?php 
    if (isset($_GET['abmelden'])) {
        deleteUser();
      }
 ?>
