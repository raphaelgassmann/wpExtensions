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

/**
 * Checks if current logged in user is marked as author on selected post
 *
 * @return boolean registerState
 * @since 3.3.0
 *
 */
function getUserRegisterState(){
    $current_user = wp_get_current_user();
    $post = get_post();
    
    $existing_coauthors = get_coauthors( $post->ID );

    foreach ( $existing_coauthors as $author ) {
        if ( $author->ID == $current_user->ID) {
            return true;
        }
    }
    return false;
}

?>
 

<?php
    if (getUserRegisterState() == true){
        ?>  <a href="<?php echo("$PHP_SELF?abmelden")?>">ABMELDEN: Mich als Teilnehmer auf diesem Anlass entfernen.</a><p> <?php
    }else{
        ?>  <a href="<?php echo("$PHP_SELF?anmelden")?>">ANMELDEN: Mich als Teilnehmer auf diesem Anlass eintragen.</a><p> <?php
    }
?>

 <?php 
    if (isset($_GET['anmelden'])) {
        addUser();
    }
    if (isset($_GET['abmelden'])) {
        deleteUser();
    }
 ?>




