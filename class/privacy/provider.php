<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  
// See the GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/*
 * Class sform email search
 *
 * This class have form search  elements for tool_untoken_oauth2.
 *
 * @package    tool_untoken_oauth2
 * @copyright  2019 Jonathan López <jonathan.lopez.garcia@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * Documentation class sform, have items to email search
 */

namespace tool_untoken_oauth2\privacy;


defined('MOODLE_INTERNAL') || die();

// moodleform is defined in formslib.php.

require_once($CFG->libdir .'/formslib.php');

class provider implements 
         \core_privacy\local\metadata\provider {
         // Legacy other moodle versions.
         use \core_privacy\local\legacy_polyfill;

    public static function get_metadata(collection $collection) : collection {

        $collection->add_database_table(
            'tool_untoken_oauth2_log',
            [
            'from_username' => 'privacy:metadata:tool_untoken_oauth2_log:from_username',
            'username' => 'privacy:metadata:tool_untoken_oauth2_log:to_username',
            'userid' => 'privacy:metadata:tool_untoken_oauth2_log:to_userid',
            'email' => 'privacy:metadata:tool_untoken_oauth2_log:email',
            'eventname' => 'privacy:metadata:tool_untoken_oauth2_log:eventname',
            'timecreated' => 'privacy:metadata:tool_untoken_oauth2_log:timecreated',

            ],
            'privacy:metadata:tool_untoken_oauth2_log'
        );

    return $collection;
    }
}
