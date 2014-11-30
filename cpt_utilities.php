<?php
/**
 * CPT_Utilities
 *
 * description
 *
 * @link http://clayperez.net/
 * @package
 * @version 0.0.1
 */
/*
Plugin Name: CPT_Utilities
Plugin URI: http://clayperez.net/CPTUtilities
Description: CPT Utilities
Version: 0.0.1
Author: Clayperez
Author URI: http://clayperez.net/
License: undefined
*/

////////////////////
// INITIALIZATION //
////////////////////
wp_enqueue_style('cpt_utilities_style', plugin_dir_url( __FILE__ ) . "style.css");

////////////////
// SHORTCODES //
////////////////

    //Return a very basic menu for the designated page. It can be placed anywhere in a page.
    function cpt_returnSimpleMenu($atts, $content = null){
        extract($atts, EXTR_PREFIX_SAME, "cpt");

        $output = "<div class='cpt_simpleMenuContainer'><div class='cpt_simpleMenuTitle'>$title</div><ul class='cpt_simpleMenu'>";

        //IF/ELSE: Decide which page is the parent
        if(!empty($page)){ //Figure out if a specific parent page is being provided.
            $pageByTitle = get_page_by_title( $page ); //A page title was provided, let's look it up and get the data for it
            $pageID = $pageByTitle->ID; //This is the found page's ID
            if(empty($title)){ $title = $page; } //If a page title wasn't provided, let's just use the page's actual title
        }else{ //Assume the parent is whatever page the shortcode is being executed from
            $pageID = get_the_ID(); //The current page's ID
        }

        //Get the children of the parent page
        $pages = get_pages( array("child_of"=>$pageID, "sort_column"=>"menu_order") );
        foreach($pages as $thisPage){
            $pageLink = get_page_link($thisPage->ID);
            $output .= "<li><a href='$pageLink'>{$thisPage->post_title}</a></li>";
        }
        $output .= "</ul></div>";
        return "$output";
    }
    add_shortcode( 'cpt_simpleMenu', 'cpt_returnSimpleMenu');

?>