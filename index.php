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
require_once($CFG->dirroot. '/local/chats/message_form.php');


$context = context_system::instance();
$PAGE->set_context($context);
$PAGE->set_url(new moodle_url('/local/chats/index.php'));
$PAGE->set_pagelayout('standard');
$PAGE->set_title($SITE->fullname);
$titulo = get_string('pluginname', 'local_chats');
$PAGE->set_heading($titulo);

require_login();

if (isguestuser()) {
    throw new moodle_exception('noguest');
}

// if (!is_siteadmin()) {
//     throw new moodle_exception('only for Admin');
//     // die('Admin only');
// }

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




$allowpost = has_capability('local/chats:postmessages', $context);
$viewpost = has_capability('local/chats:viewmessages', $context);
$deleteanypost = has_capability('local/chats:deleteanymessages', $context);

$action = optional_param('action', '', PARAM_TEXT);

// This capability allow delete message with change url with id 
// if ($action == 'del') {
//     $id = required_param('id', PARAM_TEXT);

//     $DB->delete_records('local_chats_messages', array('id' => $id));
// }

if ($action == 'del') {
    $id = required_param('id', PARAM_TEXT);

    if ($deleteanypost) {
        $params = array('id' => $id);

        $DB->delete_records('local_chats_messages', $params);
    }
}

$messageform = new local_chats_message_form();


echo $OUTPUT->header();

if (isloggedin()) {
    echo '<h2>Greetings, ' . $userfirstname . '</h2>';
    echo '<p>'.$saludos.' </p>';
    echo '<br>';
    echo get_string('greetingloggedinuser', 'local_chats', fullname($USER));
    echo '<br>';
    echo '<br>';
    echo '<br>';
    echo '<br>';
    echo '<h3>' . $saludosidiomas. '</h3>';
    echo '<br>';
    echo '<br>';
    echo '<br>';
} else {
    echo '<h2>Greetings, user</h2>';
    echo get_string('greetinguser', 'local_chats');
    echo '<br>';
    echo '<br>';
    echo '<br>';
    echo '<br>';

}
// echo '<h4>saludando al usuario '. $username . '</h4>';
// echo '<p>Este tu nombre firstname '. $userfirstname .'</p>';
// echo '<p>Este tu nombre lastname '. $userlastname .'</p>';
// echo '<p>Este tu user ID '.$userid.'</p>';
// echo '<p>'.$useremail.'</p>';
// echo '<p> Ciudad: '.$usercity.'</p>';
// echo '<p> País: '.$usercountry.'</p>';
// echo '<p> idioma: '. $userlang .'</p>';
// echo '<br>';
// echo '<br>';
// echo get_string('caca', 'local_chats' , fullname($USER));

// echo '<p>Este debería ser un parrafo de trasteo, en el se encontrará info de lo que ocurre en el mundo</p>';

$now = time();
echo '<p>'.userdate($now).'</p>';

// echo '<p> Formato qué pasa con la hora: '.userdate($date->getTimestamp()).'</p>';

// echo '<p> Formato sin la hora: '.userdate($date->getTimestamp(), get_string('strftimedatefullshort', 'core_langconfig')).'</p>';

// echo '<p> Tratando números decimales 20 / 3 = '.format_float($grade, 2).'</p>';


// Print the form without capability
// $messageform->display();

// Print the form with capability
if ($allowpost) {
    $messageform->display();
}



if ($data = $messageform->get_data()) {
    require_capability('local/chats:postmessages', $context);
    
    $message = required_param('message', PARAM_TEXT);

    //Some output way, the most simple.
    // echo $OUTPUT->heading($message, 4);

    // Some comments
    // $email = required_param('email', PARAM_NOTAGS);
    // echo $OUTPUT->heading($email, 4);
    // $forum = required_param('name', PARAM_TEXT);
    // echo $OUTPUT->heading($forum, 4);
    // $defaultmark = required_param('defaultmark', PARAM_NOTAGS);
    // echo $OUTPUT->heading($defaultmark, 4);
    // $introduction = required_param('introduction', PARAM_TEXT);
    // echo $OUTPUT->heading($introduction, 4);.
    // $file = required_param('file', PARAM_TEXT);
    // echo $OUTPUT->heading($file, 4);.

    // var_dump($data);

    if (!empty($message)) {
        $record = new stdClass();
        $record->message = $message;
        $record->timecreated = time();

        $record->userid = $USER->id;


        $DB->insert_record('local_chats_messages', $record);
    }
}

if ($viewpost){
    // Versión directa.
    // $messages = $DB->get_records('local_chats_messages');
    
    $userfields = \core_user\fields::for_name()->with_identity($context);
    $userfieldssql = $userfields->get_sql('u');
    
    $sql = "SELECT m.id, m.message, m.timecreated, m.userid {$userfieldssql->selects}
                FROM {local_chats_messages} m
            LEFT JOIN {user} u ON u.id = m.userid
            ORDER BY timecreated DESC";
    
    $messages = $DB->get_records_sql($sql);
    
    // A direct way to print messages.
    // foreach ($messages as $m) {
    //     echo '<p>' . $m->message . ', ' . $m->timecreated . '</p>';
    // }

    echo $OUTPUT->box_start('card-columns');
    
    foreach ($messages as $m) {
        echo html_writer::start_tag('div', array('class' => 'card'));
        echo html_writer::start_tag('div', array('class' => 'card-body'));
    
        // Old version without sanity estructure.
        // Eecho html_writer::tag('p', $m->message, array('class' => 'card-text'));.
        // To sanity the format of the message.
        echo html_writer::tag('p', format_text($m->message, FORMAT_PLAIN), array('class' => 'card-text'));
        echo html_writer::tag('p', get_string('postedby', 'local_chats', $m->firstname), array('class' => 'card-text'));
    
        echo html_writer::start_tag('p', array('class' => 'card-text'));
        echo html_writer::tag('small', userdate($m->timecreated), array('class' => 'text-muted'));
        echo html_writer::end_tag('p');

        if ($deleteanypost) {
            echo html_writer::start_tag('p', array('class' => 'card-footer text-center'));
            echo html_writer::link(
                new moodle_url(
                    '/local/chats/index.php',
                    array('action' => 'del', 'id' => $m->id)
                ),
                $OUTPUT->pix_icon('t/delete', '') . get_string('delete')
            );
            echo html_writer::end_tag('p');
        }

        echo html_writer::end_tag('div');
        echo html_writer::end_tag('div');
    }
    
    echo $OUTPUT->box_end();

}


echo $OUTPUT->footer();
