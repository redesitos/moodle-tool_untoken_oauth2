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
 * @copyright 2019 Jonathan López <jonathan.lopez.garcia@gmail.com>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined('MOODLE_INTERNAL') || die();

if (has_capability('tool/untoken_oauth2:action', context_system::instance())) {
    if (! $ADMIN->locate('tool_untoken_oauth2')) {
        $ADMIN->add('tools', 
                    new admin_category('tool_untoken_oauth2', 
                    get_string('pluginname', 'tool_untoken_oauth2')));

        $ADMIN->add('tools', 
                    new admin_externalpage('untoken_oauth2', get_string('manager', 'tool_untoken_oauth2'), 
                    $CFG->wwwroot . '/' . $CFG->admin . '/tool/untoken_oauth2/manager.php'));
    }
}
