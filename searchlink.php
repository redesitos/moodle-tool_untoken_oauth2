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
// along with Moodle. If not, see <http://www.gnu.org/licenses/>.

/**
 * Lang strings.
 *
 * This files lists lang strings related to tool_untoken_oauth2.
 *
 * @package tool_untoken_oauth2
 * @copyright 2019 Jonathan López <jonathan.lopez.garcia@gmail.com>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * 
 * @param int $delete
 *            delete action.
 * @param bool $cancelled
 *            cancel action.
 */
require_once('../../../config.php');
defined('MOODLE_INTERNAL') || die();
require_login();

$PAGE->set_context(context_system::instance());
$PAGE->set_pagelayout('standard');
$PAGE->set_title(get_string('title', 'tool_untoken_oauth2'));
$PAGE->set_heading(get_string('headsearchtag', 'tool_untoken_oauth2'));
$PAGE->set_url($CFG->wwwroot . '/admin/tool/untoken_oauth2/searchlink.php');

$delete = optional_param('delete', 0, PARAM_INT);
$cancelled = optional_param('cancel', false, PARAM_BOOL);

$context = context_system::instance();
require_capability('moodle/user:viewdetails', $context);
require_capability('tool/untoken_oauth2:search', $context);

$site = get_site();

$mform = new tool_untoken_oauth2\sform();

echo $OUTPUT->header();
if ($mform->get_data()) {

    if ($data = $mform->get_data()) {
        if (! empty($data->email)) {
            $count = $DB->count_records_sql('SELECT count(*) 	
				 FROM {auth_oauth2_linked_login} 
				WHERE ' . $DB->sql_compare_text('email') . ' = ' . $DB->sql_compare_text(':email'), [
                'email' => $data->email
            ]);
            if ($count) {
                echo '<h3>' . get_string('titlesearchtag', 'tool_untoken_oauth2') . '</h3>';
                echo '<br>';
                $fecha = new DateTime();
                $table = new html_table();
                $table->head = array(
                    'linkid',
                    'userid',
                    'username',
                    'email',
                    'confirmtoken',
                    'confirmtokenexpires'
                );

                $userlink = $DB->get_records_sql('SELECT * 
					    FROM {auth_oauth2_linked_login} 
					   WHERE ' . $DB->sql_compare_text('email') . ' = ' . $DB->sql_compare_text(':email'), [
                    'email' => $data->email
                ]);
                foreach ($userlink as $usr) {
                    $fecha->setTimestamp($usr->confirmtokenexpires);
                    $table->data[] = array(
                        $usr->id,
                        $usr->userid,
                        $usr->username,
                        $usr->email,
                        $usr->confirmtoken,
                        $fecha->format('d-m-Y H:i:s')
                    );
                    $linkid['id' . $usr->id] = $usr->id;
                }
                echo html_writer::table($table);
                if (! empty($userlink)) {

                    $optionsyes = new moodle_url('delete.php', array(
                        'email' => $data->email,
                        'delete' => $delete = 1,
                        'confirm' => md5($delete),
                        'sesskey' => sesskey()
                    ));

                    $optionsno = new moodle_url('searchlink.php', array(
                        'cancel' => true
                    ));
                    $deleteurl = new moodle_url($optionsyes);
                    $cancelurl = new moodle_url($optionsno);
                    $deletebutton = new single_button($deleteurl, get_string('delete'), 'post');
                    $cancelbutton = new single_button($cancelurl, get_string('cancel'), 'post');

                    echo $OUTPUT->confirm(get_string('confirmsearchtag', 'tool_untoken_oauth2'), $deletebutton, $cancelbutton);
                } else {
                    $OUTPUT->notification(get_string('notsearchtag', 'tool_untoken_oauth2'));
                    $mform->display();
                }
            } else {
                echo $OUTPUT->notification(get_string('notfoundsearchtag', 'tool_untoken_oauth2'));
                $mform->display();
            }
        }
    }
} else {
    if ($cancelled) {
        echo $OUTPUT->notification(get_string('cancelsearchtag', 'tool_untoken_oauth2'));
    }
    $mform->display();
}
echo $OUTPUT->footer();

