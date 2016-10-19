
<?php

global $wpdb;
$table = $wpdb->prefix."sniglets";
define('SNIGLET_DATE', 'Date added: ');

?>
<style>
   div.sniglet{padding: 4px 0; width:600px}
</style>
<div class="wrap">

<?php
    $results = $wpdb->get_results("select COUNT(sniglet_id) as sniglet_count from $table");

    foreach ($results as $result){
        echo "<H3>" .$result->sniglet_count . " sniglets in list</h3>";
    }

    $results = $wpdb->get_results("select * from $table ORDER by sniglet_id desc");

    foreach($results as $result){
        echo "<div class='sniglet'><a href='http://wordpress.zbox/wp-admin/admin.php?page=sniglets_edit&sniglet_id=".$result->sniglet_id . "&action=delete'>[X]</a> ";
        echo "<strong>". $result->sniglet_term . "</strong> <i>".
                         $result->sniglet_phonetics ."</i> (" . $result->sniglet_type . ")<br/>" .
                         $result->sniglet_definition . "<br/>" .
                         SNIGLET_DATE. date('m/d/Y' , strtotime( $result->sniglet_date) ) . "</div>";
    }

?>
</div>
