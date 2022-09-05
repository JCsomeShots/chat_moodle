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
    
    if ($city == 'Barcelona'){
        
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
