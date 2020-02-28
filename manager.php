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
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle. If not, see <http://www.gnu.org/licenses/>.

/**
 * Lang strings.
 *
 * This files lists lang strings related to tool_untoken_oauth2.
 *
 * @package tool_untoken_oauth2
 * @copyright 2019 Jonathan López <jonathan.lopez.garcia@gmail.com>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
require_once('../../../config.php');
require_once('./class/mform.php');

require_login();
// namespace tool_untoken_oauth2;
$PAGE->set_context(context_system::instance());
$PAGE->set_pagelayout('standard');
$PAGE->set_title(get_string('title', 'tool_untoken_oauth2'));
$PAGE->set_heading(get_string('header', 'tool_untoken_oauth2'));
$PAGE->set_url($CFG->wwwroot . '/admin/tool/untoken_oauth2/manager.php');

$context = context_system::instance();
require_capability('moodle/user:viewdetails', $context);
require_capability('moodle/user:delete', $context);
require_capability('tool/untoken_oauth2:action', $context);

$site = get_site();
$mform = new tool_untoken_oauth2\mform();
echo $OUTPUT->header();

$previewnode = $PAGE->navigation->add(get_string('search'), new moodle_url('searchlink.php'), navigation_node::TYPE_CONTAINER);

$thingnode = $previewnode->add(get_string('logevent', 'tool_untoken_oauth2'), new moodle_url('logevent.php'));

$thingnode->make_active();

$settingnode = $PAGE->settingsnav->add(get_string('search'), new moodle_url('searchlink.php'), navigation_node::TYPE_CONTAINER);

$thingnode2 = $settingnode->add(get_string('logevent', 'tool_untoken_oauth2'), new moodle_url('logevent.php'));

$thingnode2->make_active();

$searchurl = new moodle_url('searchlilnk.php', array(
    'sesskey' => sesskey()
));

$logeventurl = new moodle_url('eventlog.php', array(
    'sesskey' => sesskey()
));

$mform->display();

echo $OUTPUT->footer();
