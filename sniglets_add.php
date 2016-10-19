


<?php
/**
 * Created by JetBrains PhpStorm.
 * User: scotty
 * Date: 10/17/16
 * Time: 2:29 PM
 * To change this template use File | Settings | File Templates.
 */

global $wpdb;
$table = $wpdb->prefix."sniglets";


?>


<div class="wrap">
    <h2>Add New Sniglet</h2>

    <form action="  admin-post.php" method="POST">
        <input type="hidden" name="action" value="sniglets_form" />
        <legend>Sniglet Term</legend>
        <input id="sniglet_term" type="text" name="sniglet_term" size=30>
        <legend>Phonetic Spelling</legend>
        <input id="sniglet_phonetics" type="text" name="sniglet_phonetics" size="30">
        <legend>Sniglet type</legend>
        <select id="sniglet_type" name="sniglet_type">
            <option value="n.">noun</option>
            <option value="v.">verb</option>
            <option value="adj.">adjective</option>
        </select><br/>
        <textarea id="sniglet_definition" cols="30" rows="4" name="sniglet_definition"></textarea>
        <br/>
        <input id="savebtn" type="submit" value="Save Sniglet">
    </form>
</div>