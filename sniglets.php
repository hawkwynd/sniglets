<?php
/*
Plugin Name: Sniglets
Plugin URI: https://github.com/hawkwynd/sniglets
Description: Displays a random sniglet on your page. Add new sniglets, remove unwanted sniglets. Installs with 10 sniglets, more available all over the internet, or write your own sniglets!
Author: Scott Fleming scott.s.fleming@gmail.com
Version: 1.0
Author URI: https://github.com/hawkwynd/sniglets

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
add_action('admin_post_sniglets_form', 'process_sniglets_form');
add_action('sniglets_edit.php', 'sniglets_edit');


function sniglets_options_panel(){
    add_menu_page('Sniglets Admin',
                  'Sniglets',
                  'manage_options',
                  'sniglets-options',
                  'sniglets_menu');

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
                       'sniglet_term'         => $_POST['sniglet_term'],
                       'sniglet_phonetics'    => $_POST['sniglet_phonetics'],
                       'sniglet_type'         => $_POST['sniglet_type'],
                       'sniglet_definition'   => $_POST['sniglet_definition']
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
                  sniglet_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                  sniglet_term varchar(255) COLLATE utf8_unicode_ci NOT NULL,
                  sniglet_phonetics varchar(255) COLLATE utf8_unicode_ci NOT NULL,
                  sniglet_type varchar(255) COLLATE utf8_unicode_ci NOT NULL,
                  sniglet_definition text COLLATE utf8_unicode_ci NOT NULL,
                  sniglet_date timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                  isActive int(1) NOT NULL DEFAULT '0')
                  ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci
                  COMMENT='Sniglets database';";

    $wpdb->query($structure);

    $populate = "INSERT INTO $table
                (sniglet_id, sniglet_term, sniglet_phonetics, sniglet_type,
                sniglet_definition, sniglet_date,isActive)
                VALUES
                (1, 'Lottohole', 'LOT o hole', 'n.', 'The person in front of you at the Quiky-Mart who takes an eternity ordering a laundry list of lottery tickets from a sheet of legal sized paper when youre just wanting to pay for your gas.', '2013-05-17 17:27:19',  1),
                (2, 'nanoTap', 'NAN o tap', 'n.', 'The span of time it takes for a man to say to himself \"I`d tap that..\" while looking at a woman.', '2013-05-17 17:27:19',  1),
                (3, 'cufftackle', 'Kuf Tak `el', 'v.', 'The struggle that ensues when a button refuses to go through the hole in your shirt cuff. ', '2013-05-17 17:27:38',  1),
                (4, 'Nanitesity', 'NAN-ites eh TEE', 'n.', 'To suddenly find yourself without a witty come-back for one of your friends little `digs`.', '2013-05-17 17:27:19',  1),
                (5, 'Joes of Arc', 'johz` uhv ark', 'n.', 'Those tiny drops of coffee that die a sizzling death on the burner just  after the pot is removed.', '2013-05-17 17:27:19',  1),
                (6, 'Motspur', 'mot` sper', 'n.', 'The pesky fourth wheel on a shopping cart that refuses to co-operate with the other three.', '2013-05-17 17:27:19',  1),
                (7, 'Nocturnuggets', 'nok` ter nuh gitz', 'n.', 'Deposits found in one`s eye upon awakening in the morning, also called: GOZZAGAREENA, OPTIGOOK, EYEHOCKEY, etc.', '2013-05-17 17:27:19',  1),
                (8, 'Uclipse', 'yew` klips', 'n.', 'The dangerous arc into another lane made by drivers just before executing a turn.', '2013-05-17 17:27:19',  1),
                (9, 'Tritz', 'trits`', 'n.', 'The holes in saltine crackers. ', '2013-05-17 17:27:19',  1),
                (10, 'Slurm', 'slerm', 'n.', 'The slime that accumulates on the underside of a soap bar when it sits in the dish too long.', '2013-05-17 17:27:19', 1),
(11, 'Snorfing', 'SNORF ing', 'adj.', 'The little game waitresses love to play of waiting until your mouth is full before sneaking up and asking, \"Is everything okay?\"', '2013-05-17 17:27:53', 1),
(12, 'Sprachett', 'SPRA-chit', 'n.', 'That little rubber or plastic bar used to separate your grocery items on the checkout belt.', '2013-05-17 17:27:19', 1),
(13, 'Stuttoning', 'Stut`-un-ing', 'n.', 'The act of buttoning up a shirt or blouse and putting one button in the wrong hole, so all subsequent buttons go into wrong holes until you realize your mistake.', '2013-05-17 17:27:19', 1),
(14, 'Rovalert', 'Rov` uh-lert', 'n.', 'The system whereby one dog can quickly establish an entire neighborhood network of barking dogs.', '2013-05-17 17:27:19', 1),
(15, 'Petrophobic', 'Petro FO-bik', 'n.', 'One who is embarrassed to undress in front of a household pet. Or the fear of undressing before a household pet.', '2013-05-17 17:27:19', 1),
(16, 'Psychophobia', 'sy ko FO be uh', 'n.', 'The compulsion, when using a host`s bathroom, to peer behind the shower curtain and make sure no one is waiting for you.', '2013-05-17 17:27:19', 1),
(17, 'Anticiparcellate', 'an ti si par` sel ate', 'v.', 'Waiting until the mailman is several houses down the street before picking up the mail, so as not too appear too anxious.', '2013-05-17 17:27:38', 1),
(18, 'Aquadextrous', 'ak wa DEKS trus', 'v.', 'Possessing the ability to turn the bathtub faucet on and off with your toes', '2013-05-17 17:27:38', 1),
(19, 'Beelzebug', 'BEE zul` bug', 'n.', 'Satan in the form of a mosquito that gets into your bedroom at 3 in the morning and can not be cast out. ', '2013-05-17 17:27:19', 1),
(20, 'Thumlyk', 'THUM-lik`', 'n.', 'A lubricant or adhesive derived from the salivary gland used for turning book pages or counting paper money.', '2013-05-17 17:27:19', 1),
(21, 'bursploot', 'BER sploot', 'v.', ' To position one`s thumb at the end of a garden hose (hosepipe) to increase the water pressure. ', '2013-05-17 17:27:38', 1),
(22, 'Cereoallocative', 'ser r o al` o ka tuv', 'adj.', 'Describers the ability of a seasoned breakfast eater to establish a perfect cereal/banana ratio, assuring there will be at least one slice of banana left for the final spoonful of cereal.', '2013-05-17 17:27:53', 1),
(23, 'Traficulous', 'Trafik`-yew lus', 'adj.', 'The condition that exists while driving, when you are trying to pull out through an intersection where it is clear to the right but not to the left, then it is clear to the left but not the right, then the same over and over again for an inabordinate amount of time.', '2013-05-17 17:29:12', 1),
(24, 'Blechophy', 'BLEK-o` fee', 'v.', 'The sickly reaction as a result of absent mindedly taking the last sip of a stale coffee at the bottom of the cup.', '2013-05-17 17:27:38', 1),
(25, 'Grantnap', 'Grant` nap', 'n.', 'The extra five minutes of sleep you allow yourself that somehow makes all the difference in the world, especially if you have a hangover.', '2013-05-17 17:27:19', 1),
(26, 'Doork', 'DO` ork', 'n.', 'A person who tries to enter through a door clearly marked `Exit`.', '2013-05-17 17:27:19', 1),
(27, 'CALTITUDE', 'kal` tih tood', 'n.', 'The height to which a cat`s rear end can rise to meet the hand stroking it.', '2013-05-17 17:27:19', 1),
(28, 'Javavu', 'jah` vah-voo', 'n.', 'Phenomenon of constantly adjusting the sugar/cream level of your coffee to your liking, only to have a waitress come along and ruin it again. ', '2013-05-17 17:27:19', 1),
(29, 'Neutron Peas', 'new` tron peez', 'n.', 'Tiny green objects in TV dinners that remain frozen solid even when the rest of the food in the tray has been microwaved beyond recognition.', '2013-05-17 17:27:19', 1),
(30, 'P-Spot', 'pee` spaht', 'n.', 'The area directly above the urinal in public restrooms that men stare at, knowing a glance in any other direction would arouse suspicion.', '2013-05-17 17:27:19', 1),
(31, 'iknot', 'eye` naught', 'n.', 'The knot that forms in your cable when you take your ear-buds out of their storage place no matter how tediously you packed them away.', '2013-05-17 17:27:19', 1),
(32, 'inknotanglius', 'eye naught tang` glee us', 'v.', 'The phenomenon that occurs when you struggle gingerly to untie the knot in your cable to your ear buds, being careful not to drop your mp3 player in the process.', '2013-05-17 17:27:38', 1),
(33, 'phenomenot', 'Fe` nom eh` naught', 'n.', 'The latest gadget/gizmo/tech-toy that isn`t all that it was proclaimed to be. See iJunk.', '2013-05-17 17:27:19', 1),
(34, 'regurgimailer', 'Re` gerj ee` may `ler', 'n.', 'A person who finds it neccessary to FWD:FWD:FWD everything he/she has received from their inbox to everyone in their address book. (See eTard mailer)', '2013-05-17 17:27:19', 1),
(35, 'e-mailsculation', 'e-MAILS cu lay-shun', 'v.', 'what happens when the IT department abruptly takes away access to an email account from a worker that`s been fired, including archives, distribution lists and contacts.', '2013-05-14 20:57:26', 1),
(36, 'Adam 69', 'Adam sixty-nine', 'adj.', 'Two police cars, parked next to each other, facing opposite directions, in such a way that the drivers side doors are only inches from each other, allowing the officers to chat with each other while waiting for a traffic violation to happen. ', '2013-05-14 20:57:39', 1),
(37, 'Aquadextrous', 'akwa-DECKS-truss', 'adj.', 'Possessing the ability to turn the bathtub faucet on and off with your toes.', '2013-05-14 20:57:47', 1),
(38, 'Askhole', 'ask-HOLE', 'n.', 'someone who asks very annoying questions ', '2013-05-14 20:57:54', 1),
(39, 'Blithwapping', 'blith-WAPPING', 'v.', 'Using anything BUT a hammer to hammer a nail into the wall, such as shoes, lamp bases, doorstops, etc.', '2013-05-14 20:59:15', 1),
(40, '110 At The Equator', 'won` ten at the ek way` tawr', 'n.', 'Any burning sensation experienced directly below the navel when putting on a pair of jeans straight from the dryer. ', '2013-05-15 20:51:01', 1),
(41, 'Aeropalmics', 'ayr o palm` iks', 'n.', 'The study of wind resistance conducted by holding a cupped hand out the car window.', '2013-05-15 21:03:02', 1),
(42, 'OptiGook', 'Optee` GUK', 'n.', 'Deposits found in one\\`s eye upon awakening in the morning. AKA Nocturnuggets, GOZZAGAREENA', '2013-05-15 17:09:07', 1),
(43, 'ambivilane', 'am-`BIV-a-LANE', 'n.', 'The striped area by an exit ramp where people often pull off when trying to decide \"Is this my exit?\" ', '2013-05-16 21:24:23', 1),
(44, 'Anticiparcellate', 'an ti si par\\` sel ate', 'v.', 'Waiting until the mailman is several houses down the street before picking up the mail, so as not too appear too anxious.', '2013-05-15 17:15:44', 1),
(45, 'Charp', 'charp', 'n.', 'The green, mutant potato chip found in every bag.', '2013-05-15 18:32:22', 1),
(46, 'Circumpopulate', 'sur kum pop` yew layt`', 'v.', 'To finish off a Popsicle \"laterally\" because the \"frontal\" approach causes one to gag.', '2013-05-15 21:14:19', 1),
(47, 'Combiloops', 'kom` bih lewps', 'n.', 'The two or three unsuccessful passes before finally opening a combination locker.', '2013-05-15 21:13:53', 1),
(48, 'Creedles', 'kre` dulz', 'n.', 'The colony of microscopic indentations on a golf ball.', '2013-05-15 21:02:27', 1),
(49, 'Crummox', '', 'n.', 'The amount of cereal leftover in the box that is too little to eat and too much to throw away.', '2013-05-15 20:30:46', 1),

(50, 'Cushup', 'kush` up', 'v.', 'To sit down on a couch somehow causing the cushion next to you to rise.', '2013-05-15 21:13:25', 1),
(51, 'Darf', 'Darf', 'n.', 'The least attractive side of a Christmas tree that ends up facing the wall.', '2013-05-15 20:42:10', 1),
(52, 'Decaflon', 'de`KAF-a-LON', 'n.', 'The grueling event of getting through the day consuming only things that are good for you.', '2013-05-15 20:43:58', 1),
(53, 'Deodorend', 'DE o `der-end', 'n.', ' The last 1/2 inch of stick deodorant that won\\`t turn up out of the tube, and thus cannot be used without inducing lacerations.', '2013-05-15 20:45:37', 1),
(54, 'Destinesia', 'des tin e` shu', 'n.', 'When you go somewhere, then upon arrival, forget why you went there. ', '2013-05-15 20:46:44', 1),
(55, 'Detruncus', 'de trunk` us', 'n.', 'The embarrassing phenomenon of losing one`s bathing shorts while diving into a swimming pool.', '2013-05-15 21:03:22', 1),
(56, 'Digitritus', 'dij ih tree` tus', 'n.', 'Deposits found between the links of a watchband.', '2013-05-15 20:52:17', 1),
(57, 'Dillrelict', 'dil rel` ikt', 'n.', 'The last pickle in the jar that avoids all attempts to be captured.', '2013-05-15 21:13:42', 1),
(58, 'E-bage', 'ee` bage', 'n.', 'An addiction to electronic devices. ', '2013-05-15 21:02:50', 1),
(59, 'Eiffelites', 'eye` ful eyetz', 'n.', 'Gangly people sitting in front of you at the movies who, no matter what direction you lean in, follow suit.', '2013-05-15 21:11:44', 1),
(60, 'Elbonics', 'el-BON` ix', 'n.', 'The actions of two people maneuvering for one armrest in a movie theater.', '2013-05-15 21:36:18', 1),
(61, 'Ellacelleration', 'ella `axe  er `a shun', 'n.', 'The mistaken belief that repeatedly pressing the elevator button will make it go faster', '2013-05-15 21:37:34', 1),
(62, 'Essoass', 'ess`-O ass', 'n.', 'Any person who drives through a corner gas station to avoid stopping at the intersection.', '2013-05-16 14:08:16', 1),
(63, 'Execuglide', 'eks ek` yew glyd', 'v.', 'To propel oneself about an office without getting up from the chair.', '2013-05-16 14:09:17', 1),
(64, 'Expresshole', 'ex-PRESS `hol', 'n.', 'A person who goes through the grocery store`s 12-item express lane with 22 items.', '2013-05-16 14:10:32', 1),
(65, 'Fenderberg', 'fen der burg`', 'n.', 'The large glacial deposits that form on the insides of car fenders during snowstorms.', '2013-05-16 14:11:55', 1),
(66, 'Flarpswitch', 'flarp` switch', 'n.', 'The one light switch in every house with no function whatsoever.', '2013-05-16 14:15:12', 1),
(67, 'Flintstep', 'flint` step', 'v.', 'To wind up one`s feet before running away in fear. Common among cartoon characters.', '2013-05-16 14:15:55', 1),
(68, 'Flosstitution', 'flos` tee too shun', 'v.', 'Using anything other than the waxed string product , i.e matchbook covers, etc. to clean between your teeth.', '2013-05-16 14:16:53', 1),
(69, 'Fods', 'fahdz', 'n.', 'Couples at amusement parks who wear identical T-shirts, presumably to keep from getting lost.', '2013-05-16 14:18:21', 1),
(70, 'Fridgedalien', 'frid-ja-DAY lee on`', 'n.', 'Anything stored in the refrigerator that is not a food product. i.e. Photography film, batteries, etc. ', '2013-05-16 14:19:34', 1),
(71, 'Frust', 'frust`', 'n.', 'The line of dust that accumulates when sweeping dust into a dust pan and frustratingly backs you up because you can never get it into the pan.', '2013-05-16 14:20:21', 1),
(72, 'Fuffle', 'fuh` full', 'n.', 'To assume, when dining out, that you are making things easier on the waitress by using the phrase \"when you get a chance...\"', '2013-05-16 14:22:19', 1),
(73, 'Furblestroll', 'fur-BULL strol`', 'n.', 'Having to meander through a maze of ropes at an airport or bank even when you are the only person in line.', '2013-05-16 14:23:27', 1),
(74, 'Gapiana', 'ga pee ah` nah', 'n.', 'The unclaimed strip of land between the \"you are now leaving\" and \"welcome to\" signs when crossing state lines.', '2013-05-16 14:24:21', 1),
(75, 'Giraffiti', 'jer aff` eetee', 'n.', 'Vandalism spray-painted very, very high.', '2013-05-16 14:25:52', 1),
(76, 'Gladhandling', 'glad HANdel-eeng', 'n.', ' To attempt, often with frustrating results (sepecially when in a hurry), to find and separate the ends of a plastic sandwich or trash bag.', '2013-05-16 14:27:25', 1),
(77, 'Grantnap', 'grant` nap', 'n.', 'The extra five minutes of sleep you allow yourself that somehow makes all the difference in the world.', '2013-05-16 14:29:06', 1),
(78, 'Gription', 'grip` shun', 'n.', 'The sound of sneakers squeaking against the floor during basketball games.', '2013-05-16 14:30:00', 1),
(79, 'Grisknob', 'grisd` nahb', 'n.', 'The end of a chicken drumstick which always gives the appearance of having more chicken on it.', '2013-05-16 14:30:51', 1),
(80, 'Gyroped', 'jy`roh ped', 'n.', 'A kid who simply cannot resist spinning around wildly on a diner stool.', '2013-05-16 14:32:03', 1),
(81, 'Hacula', 'hak` yew luh', 'n.', 'The last few remaining inches of tape measure or lawn mower cord that refuses to rewind automatically.', '2013-05-16 14:32:53', 1),
(82, 'Idiolocator', 'id ee-O` lo kayter', 'n.', 'The symbol on a mall or amusement park map representing \"You Are Here\"', '2013-05-16 14:35:12', 1),
(83, 'Idiot Box', 'id-E yaht box', 'n.', ' The part of the envelope that tells a person where to place the stamp when they can`t quite figure it out for themselves.', '2013-05-16 14:36:02', 1),
(84, 'ienvy', 'aye `en-vee', 'adj.', 'The sublime jealousy a person with a normal cell phone has when his friend or partner is on their i-phone. ', '2013-05-16 14:37:08', 1),
(85, 'Ignoranus', 'ig `nor AY nuss', 'n.', 'A person who`s both stupid and an asshole. ', '2013-05-16 14:38:07', 1),
(86, 'Intaxication', 'in taxy KAY-shun', 'adj.', 'The false euphoria at getting a tax refund, which lasts until you realize it was your money to start with.', '2013-05-16 14:42:21', 1),
(87, 'itard', 'aye `tard', 'n.', 'somone who owns an iphone, because it`s the socially popular thing to have, and yest has no idea how to operate the device.', '2013-05-16 14:43:51', 1),
(88, 'Jiffylust', 'ji` phee lust', 'n.', 'The inability to be the first person to carve into a brand-new beautiful jar of peanut butter.', '2013-05-16 14:45:05', 1),
(89, 'confetto', 'con `fet oh', 'n.', '1. one piece of confetti: a sparkle, a streamer, a bit of paper; 2. a really small celebration. (From the Italian.)\n\ne.g., \"What`s this strip of paper? Hey! is someone shredding our records?!\" \"Nah, it`s just a confetto from the party we had last week.\" ', '2013-05-16 18:05:49', 1);
                ";

    $wpdb->query($populate);
}
?>
