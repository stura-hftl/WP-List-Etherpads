<?php
    
/*
Plugin Name: List Etherpads
Plugin URI: http://stura.hftl.de
Description: [listetherpads] to list all etherpads in given database
Version: 1.0
Author: Tilmann Bach
Author URI: http://laufwerkc.de
*/

    function get_padlist() 
    {
      $MYSQL_SERVER = "localhost";
      $MYSQL_USER = "etherpad";
      $MYSQL_PASS = "eth3r!pad!";
      $MYSQL_DB = "etherpad";
      
      
      $con=mysqli_connect($MYSQL_SERVER,$MYSQL_USER,$MYSQL_PASS,$MYSQL_DB);
      // Check connection
      $cont = "";
       if (mysqli_connect_errno())
         {
         $cont .= "Failed to connect to MySQL: " . mysqli_connect_error();
         }

       $result = mysqli_query($con,'select distinct substring(store.key,5,locate(":",store.key,5)-5) AS pads from store where store.key like "pad:%"');

       while($row = mysqli_fetch_array($result))
         {
         $cont .= '<div class="etherpad-item"><a href="http://stura.hft-leipzig.de/pad/'.$row['pads'].'" target="_blank">' . $row['pads'] . '</a></div>';
         }

       mysqli_close($con);
       
       return $cont;
    }

    function replace_shortcode($content) 
    {
    /*
    [listetherpads]
    */
      return str_replace('[listetherpads]', '<div class="etherpad-list">'.get_padlist().'</div>', $content);
    }

    add_filter('the_content', replace_shortcode);

?>