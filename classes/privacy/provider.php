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
// You should have received a copy of the GNU General Public License along with Moodle.
// If not, see <http://www.gnu.org/licenses/>.

/**
 * Lang strings.
 *
 * This files lists lang strings related to tool_untoken_oauth2.
 *
 * @package tool_untoken_oauth2 
 * @copyright 2019 Jonathan López  <jonathan.lopez.garcia@gmail.com>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */



namespace tool_untoken_oauth2\privacy;

defined('MOODLE_INTERNAL') || die();

use core_privacy\local\metadata\collection;
use core_privacy\local\request\approved_contextlist;
use core_privacy\local\request\approved_userlist;
use core_privacy\local\request\contextlist;
use core_privacy\local\request\userlist;
use core_privacy\local\request\writer;

/**
 * Privacy Subsystem implementation for tool_untoken_oauth2.
 *
 * @package tool_untoken_oauth2 
 * @copyright 2019 Jonathan López  <jonathan.lopez.garcia@gmail.com>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class provider implements
        // Transactions store user data.
        \core_privacy\local\metadata\provider,

        // The payu enrolment plugin contains user's transactions.
        \core_privacy\local\request\plugin\provider,

        // This plugin is capable of determining which users have data within it.
        \core_privacy\local\request\core_userlist_provider {

    /**
     * Returns meta data about this system.
     *
     * @param collection $collection The initialised collection to add items to.
     * @return collection A listing of user data stored through this system.
     */
    public static function get_metadata(collection $collection) : collection {
 
        // The tool_untoken_oauth2 has a DB table that contains user data.
        $collection->add_database_table(
                'tool_untoken_oauth2',
                [
                    'id' => 'privacy:metadata:tool_untoken_oauth2:id',
	    	    'from_username' => 'privacy:metadata:tool_untoken_oauth2:from_username',
            	    'username' => 'privacy:metadata:tool_untoken_oauth2:to_username',
            	    'userid' => 'privacy:metadata:tool_untoken_oauth2:userid',
            	    'email' => 'privacy:metadata:tool_untoken_oauth2:email',
                    'eventname' => 'privacy:metadata:tool_untoken_oauth2:eventname',
            	    'timecreated' => 'privacy:metadata:tool_untoken_oauth2:timecreated',
                ],
                'privacy:metadata:tool_untoken_oauth2:pluginmeta'
        );

        return $collection;
    }

    public static function get_contexts_for_userid(int $userid) : contextlist {
        $contextlist = new contextlist();

        $sql = "SELECT ctx.id
                  FROM {tool_untoken_oauth2} ep
                  JOIN {user} u ON u.username = ep.username 
                 WHERE u.id = :userid";
        $params = [
            'contextcourse' => CONTEXT_USER,
            'userid'        => $userid,
        ];

        $contextlist->add_from_sql($sql, $params);

        return $contextlist;
    }

    public static function get_users_in_context(userlist $userlist) {
    }

    public static function export_user_data(approved_contextlist $contextlist) {
    }

    public static function delete_data_for_all_users_in_context(\context $context) {
    }

    public static function delete_data_for_user(approved_contextlist $contextlist) {
    }

     public static function delete_data_for_users(approved_userlist $userlist) {
        global $DB;

        $context = $userlist->get_context();

        if ($context->contextlevel != CONTEXT_USER) {
            return;
	}
     }
}

