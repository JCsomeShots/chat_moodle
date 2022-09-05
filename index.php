<?php
// This file is part of Moodle - https://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

/**
 * Plugin strings are defined here.
 *
 * @package     local_chats
 * @category    string
 * @copyright   JcSomeShots <juancarlo.castillo20@gmail.com>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once('../../config.php');
require_once($CFG->dirroot. '/local/chats/lib.php');


$context = context_system::instance();
$PAGE->set_context($context);
$PAGE->set_url(new moodle_url('/local/chats/index.php'));
$PAGE->set_pagelayout('standard');
$PAGE->set_title($SITE->fullname);
$titulo = get_string('pluginname', 'local_chats');
$PAGE->set_heading($titulo);

global $USER;
$userid = $USER->id;
$username = $USER->username;
$userfirstname = $USER->firstname;
$userlastname = $USER->lastname;
$useremail = $USER->email;
$usercity = $USER->city;
$usercountry = $USER->country;
$userlang = $USER->lang;
$date = new DateTime("today", core_date::get_user_timezone_object());
$date->setTime(0, 0, 0);
$grade = 20.00 / 3;
$saludos = get_string('greetingloggedinuser', 'local_chats', fullname($USER));
$saludosidiomas = local_chats_get_greeting($USER);



echo $OUTPUT->header();

if (isloggedin()) {
    echo '<h2>Greetings, ' . $userfirstname . '</h2>';
    echo '<p>'.$saludos.' </p>';
    echo get_string('greetingloggedinuser', 'local_chats', fullname($USER));
    echo '<p>antes </p>';
    echo '<h3>' . $saludosidiomas. '</h3>';
    echo '<p>después</p>';
    // Vvar_dump($USER);.
} else {
    echo '<h2>Greetings, user</h2>';
    echo get_string('greetinguser', 'local_chats');
    
}
echo '<h4>saludando al usuario '. $username . '</h4>';
echo '<p>Este tu nombre firstname '. $userfirstname .'</p>';
echo '<p>Este tu nombre lastname '. $userlastname .'</p>';
echo '<p>Este tu user ID '.$userid.'</p>';
echo '<p>'.$useremail.'</p>';
echo '<p> Ciudad: '.$usercity.'</p>';
echo '<p> País: '.$usercountry.'</p>';
echo '<p> idioma: '. $userlang .'</p>';
echo get_string('caca', 'local_chats' , fullname($USER));

echo '<p>Este debería ser un parrafo de trasteo, en el se encontrará info de lo que ocurre en el mundo</p>';

$now = time();
echo '<p>'.userdate($now).'</p>';

echo '<p> Formato qué pasa con la hora: '.userdate($date->getTimestamp()).'</p>';

echo '<p> Formato sin la hora: '.userdate($date->getTimestamp(), get_string('strftimedatefullshort', 'core_langconfig')).'</p>';

echo '<p> Tratando números decimales 20 / 3 = '.format_float($grade, 2).'</p>';

echo $OUTPUT->footer();
