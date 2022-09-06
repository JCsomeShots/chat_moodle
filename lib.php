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

/**
 * Insert a link to index.php on the site front page navigation menu.
 *
 * @param navigation_node $frontpage Node representing the front page in the navigation tree.
 */
function local_chats_extend_navigation_frontpage(navigation_node $frontpage) {
    $frontpage->add(
        get_string('pluginname', 'local_chats'),
        new moodle_url('/local/chats/index.php')
    );
}

/**
 * Add link to index.php into navigation drawer.
 *
 * @param global_navigation $root Node representing the global navigation tree.
 */
function local_chats_extend_navigation(global_navigation $root) {

    $node = navigation_node::create(
        get_string('pluginname', 'local_chats'),
        new moodle_url('/local/chats/index.php'),
        navigation_node::TYPE_CUSTOM,
        null,
        null,
        new pix_icon('t/message', '')
    );

    $node->showinflatnavigation = true;

    $root->add_node($node);
}

/**
 * Get a localised greeting message for a user
 *
 * @param \stdClass $user
 * @return string
 */
function local_chats_get_greeting($user) {
    if ($user == null) {
        return get_string('greetinguser', 'local_chats');
    }

    $country = $user->country;
    $city = $user->city;

    if ( $city === 'Barcelona' ){

        $langstr = 'greetingusercat';
    } else {

        switch ($country) {
            case 'AU':
                $langstr = 'greetinguserau';
                break;
            case 'ES':
                $langstr = 'greetinguseres';
                break;
            case 'FJ':
                $langstr = 'greetinguserfj';
                break;
            case 'NZ':
                $langstr = 'greetingusernz';
                break;
            default:
                $langstr = 'greetingloggedinuser';
                break;
        }
    }

    return get_string($langstr, 'local_chats', fullname($user));
}
