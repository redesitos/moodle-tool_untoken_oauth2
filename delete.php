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
 *         
 * @param bool $delete
 *            delete action.
 * @param bool $back
 *            redirect option.
 * @param email $email
 *            email address.
 * @param text $confirm
 *            confirmation string.
 */
require_once ('../../../config.php');
require_once ('./class/sform.php');

require_login();

$PAGE->set_context(context_system::instance());
$PAGE->set_pagelayout('standard');
$PAGE->set_title(get_string('title', 'tool_untoken_oauth2'));
$PAGE->set_heading(get_string('headprocestag', 'tool_untoken_oauth2'));
$PAGE->set_url($CFG->wwwroot . '/admin/tool/untoken_oauth2/delete.php');

/*
 * @param bool $delete delete action.
 * @param bool $back redirect option.
 * @param email $email email address.
 * @param text $confirm confirmation string.
 * @throws ddl_exception if an error occurs.
 */

$delete = optional_param('delete', false, PARAM_BOOL);
$back = optional_param('back', false, PARAM_BOOL);
$email = optional_param('email', '', PARAM_EMAIL);
$confirm = optional_param('confirm', '', PARAM_TEXT);

$context = context_system::instance();
require_capability('moodle/user:viewdetails', $context);
require_capability('moodle/user:delete', $context);
require_capability('tool/untoken_oauth2:action', $context);

$site = get_site();

$mform = new dform();
echo $OUTPUT->header();
if (confirm_sesskey() && $confirm && $delete) {

    $table = new html_table();
    $table->head = array(
        'linkid',
        'userid',
        'username',
        'email',
        'status'
    );
    $deluser = $DB->get_records_sql('SELECT * 
					FROM {auth_oauth2_linked_login} WHERE ' . $DB->sql_compare_text('email') . ' = ' . $DB->sql_compare_text(':email'), [
        'email' => $email
    ]);

    $fecha = new DateTime();
    $row = new stdClass();

    foreach ($deluser as $usr) {
        $table->data[] = array(
            $usr->id,
            $usr->userid,
            $usr->username,
            $usr->email,
            get_string('deleted', 'tool_untoken_oauth2')
        );

        try {

            $DB->delete_records('auth_oauth2_linked_login', [
                'id' => $usr->id,
                'userid' => $usr->userid,
                'username' => $usr->username
            ]);
        } catch (ExpectedException $e) {
            throw new coding_exception('Can not delete email link account, error: ' . $e);
        }

        $row->from_username = $USER->username;
        $row->username = $usr->username;
        $row->userid = $usr->userid;
        $row->email = $usr->email;
        $row->eventname = 'linked email account deleted';
        $row->timecreated = $fecha->getTimestamp();

        $transaction = $DB->start_delegated_transaction();
        $DB->insert_record('tool_untoken_oauth2_log', $row);
        $transaction->allow_commit();
    }

    echo html_writer::table($table);

    $back = true;
    $mform->display();
} else {

    if ($back) {
        redirect(new moodle_url('manager.php', array()));
    }
}

echo $OUTPUT->footer();
