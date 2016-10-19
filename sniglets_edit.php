<?php
if (current_user_can('edit_others_posts')) {

    $table = $wpdb->prefix."sniglets";

    if($_GET['action'] == 'delete'){

        $wpdb->delete( $table, array( 'sniglet_id' => $_GET['sniglet_id'] ) );
        echo "<p>Sniglet ID " . $_GET['sniglet_id'] . " has been deleted.</p>";
    }

}else{
    echo "You do not have permission to do this...";
}

?>
<script type="text/javascript">window.location = 'admin.php?page=sniglets-options';</script>