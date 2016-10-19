<?php
/*
Plugin Name: Sniglets
Plugin URI: http://www.musiccityguru.com/sniglets/sniglet_edit.php
Description: Displays a random sniglet on your page. Add new sniglets, remove unwanted sniglets. Installs with 10 sniglets, more available all over the internet, or write your own sniglets!
Author: Scott Fleming
Version: 1.0 (Beta)
Author URI: mailto:scott.s.fleming@gmail.com

{Plugin Name} is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.

{Plugin Name} is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
*/

// add activate link
add_action('activate_sniglets/sniglets.php', 'sniglets_install');
add_action('admin_menu', 'sniglets_options_panel');

// add menu actions
add_action('admin_menu', 'sniglets_admin_actions');
add_action('admin_post_sniglets_form', 'process_sniglets_form');
add_action('sniglets_edit.php', 'sniglets_edit');


function sniglets_options_panel(){
    add_menu_page('Sniglets Admin',
                  'Sniglets',
                  'manage_options',
                  'sniglets-options',
                  'sniglets_options');

    add_submenu_page('sniglets-options',
        'Sniglets',
        'List Sniglets',
        'manage_options',
        'sniglets-options',
        'sniglets_menu');

    add_submenu_page('sniglets-options',
                     'Sniglets',
                     'Add New Sniglet',
                      'manage_options',
                      'sniglets-sub-options',
                      'sniglets_add');

    add_submenu_page(NULL,
                    'Sniglets',
                    'Sniglet Edit',
                    'manage_options',
                    'sniglets_edit',
                    'sniglets_edit');
}


function sniglets_menu(){
    global $wpdb;
    include 'sniglets_admin.php';

}

function sniglets_edit(){
    global $wpdb;
    include 'sniglets_edit.php';

}

function sniglets_add(){
    global $wpdb;
    include 'sniglets_add.php';
}



function process_sniglets_form(){
    global $wpdb;

    if( isset($_POST['sniglet_term'])){

        $table = $wpdb->prefix."sniglets";
        $wpdb->insert($table, array(
                       sniglet_term         => $_POST['sniglet_term'],
                       sniglet_phonetics    => $_POST['sniglet_phonetics'],
                       sniglet_type         =>  $_POST['sniglet_type'],
                       sniglet_definition   => $_POST['sniglet_definition']
        ));

        wp_redirect(admin_url('admin.php?page=sniglets-options'));
    }

}

/**
 * Display random sniglet entry
*/

function sniglet_random(){
    global $wpdb;
    $table   = $wpdb->prefix."sniglets";
    $results = $wpdb->get_results("select * from $table ORDER BY RAND() LIMIT 1");

    foreach($results as $result){
        echo "<strong>". $result->sniglet_term . "</strong> <i>".
            $result->sniglet_phonetics ."</i> (" . $result->sniglet_type . ")<br/>" .
            $result->sniglet_definition;
    }
}


/**
 * Install function, create a table, and populate with entries
*/

function sniglets_install(){
    global $wpdb;

    $table = $wpdb->prefix."sniglets";
    $structure = "CREATE TABLE IF NOT EXISTS $table (
                  sniglet_id int(11) NOT NULL,
                  sniglet_term varchar(255) COLLATE utf8_unicode_ci NOT NULL,
                  sniglet_phonetics varchar(255) COLLATE utf8_unicode_ci NOT NULL,
                  sniglet_type varchar(255) COLLATE utf8_unicode_ci NOT NULL,
                  sniglet_definition text COLLATE utf8_unicode_ci NOT NULL,
                  sniglet_date timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                  sniglet_likes int(3) NOT NULL DEFAULT '0',
                  sniglet_dislikes int(3) NOT NULL DEFAULT '0',
                  isActive int(1) NOT NULL DEFAULT '0')
                  ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT
                  CHARSET=utf8
                  COLLATE=utf8_unicode_ci
                  COMMENT='Sniglets database';";

    $wpdb->query($structure);

    $populate = "INSERT INTO $table
                (sniglet_id, sniglet_term, sniglet_phonetics, sniglet_type,
                sniglet_definition, sniglet_date,sniglet_likes, sniglet_dislikes, isActive)
                VALUES
                (1, 'Lottohole', 'LOT o'' hole', 'n.', 'The person in front of you at the Quiky-Mart who takes an eternity ordering a laundry list of lottery tickets from a sheet of legal sized paper when you''re just wanting to pay for your gas.', '2013-05-17 17:27:19', 0, 0, 1),
                (2, 'nanoTap', 'NAN o'' tap', 'n.', 'The span of time it takes for a man to say to himself \"I''d tap that..\" while looking at a woman.', '2013-05-17 17:27:19', 0, 0, 1),
                (3, 'cufftackle', 'Kuf Tak ''el', 'v.', 'The struggle that ensues when a button refuses to go through the hole in your shirt cuff. ', '2013-05-17 17:27:38', 0, 0, 1),
                (4, 'Nanitesity', 'NAN-ites eh TEE', 'n.', 'To suddenly find yourself without a witty come-back for one of your friends little ''digs''.', '2013-05-17 17:27:19', 0, 0, 1),
                (5, 'Joes of Arc', 'johz'' uhv ark', 'n.', 'Those tiny drops of coffee that die a sizzling death on the burner just  after the pot is removed.', '2013-05-17 17:27:19', 0, 0, 1),
                (6, 'Motspur', 'mot'' sper', 'n.', 'The pesky fourth wheel on a shopping cart that refuses to co-operate with the other three.', '2013-05-17 17:27:19', 0, 0, 1),
                (7, 'Nocturnuggets', 'nok'' ter nuh gitz', 'n.', 'Deposits found in one''s eye upon awakening in the morning, also called: GOZZAGAREENA, OPTIGOOK, EYEHOCKEY, etc.', '2013-05-17 17:27:19', 0, 0, 1),
                (8, 'Uclipse', 'yew'' klips', 'n.', 'The dangerous arc into another lane made by drivers just before executing a turn.', '2013-05-17 17:27:19', 0, 0, 1),
                (9, 'Tritz', 'trits''', 'n.', 'The holes in saltine crackers. ', '2013-05-17 17:27:19', 0, 0, 1);
                ";

    $wpdb->query($populate);
}
?>
