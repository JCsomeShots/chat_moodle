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
 * Plugin version and other meta-data are defined here.
 *
 * @package     local_chats
 * @copyright   2022 JcSomeCodes <juancarlo.castillo20@gmail.com>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once('../../config.php');
require_once($CFG->dirroot. '/local/chats/lib.php');
require_once($CFG->libdir . '/formslib.php');

$mensajeidiomas = local_chats_get_message_form($USER);

class local_chats_message_form extends moodleform {

    /**
     * Define the form.
     */
    public function definition() {
        $mform    = $this->_form; // Don't forget the underscore!

        // $mform->addElement('textarea', 'message', get_string('yourmessagees', 'local_chats')); // Add elements to your form.
        // $mform->addElement('textarea', 'message', get_string('yourmessageen', 'local_chats')); // Add elements to your form.
        $mform->addElement('textarea', 'message', get_string('yourmessagecat', 'local_chats')); // Add elements to your form.
        $mform->setType('message', PARAM_TEXT); // Set type of element.

        // // $mform->addElement('text', 'email', get_string('emailes', 'local_chats')); // Add elements to your form.
        // $mform->addElement('text', 'email', get_string('email')); // Add elements to your form.
        // $mform->setType('email', PARAM_NOTAGS);                   // Set type of element.
        // // $mform->setDefault('email', 'Por favor entre su correo');        // Default value.

        // $mform->addElement('text', 'name', get_string('forumname', 'forum'), $attributes);

        // $mform->addElement('float', 'defaultmark', get_string('defaultmark', 'question'), $attributes);

        // $mform->addElement('textarea', 'introduction', get_string("introtext", "survey"), 'wrap="virtual" rows="10" cols="10"');

        // // $mform->addElement('file', 'file', get_string('file')); // Add elements to your form
        // // $mform->setType('file', PARAM_NOTAGS);                   //Set type of element
        // // $mform->setDefault('file', 'Please select a file');

        $submitlabel = get_string('submit');
        $mform->addElement('submit', 'submitmessage', $submitlabel);
    }

}
