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
 * @param bool $back
 *            redirect option.
 * @param char $sort
 *            order option.
 * @param char $dir
 *            direction option.
 * @param int $page
 *            page option.
 * @param int $perpage
 *            perpage option.
 */
require_once ('../../../config.php');
require_once ('./class/lform.php');

require_login();

$PAGE->set_context(context_system::instance());
$PAGE->set_pagelayout('standard');
$PAGE->set_title(get_string('title', 'tool_untoken_oauth2'));
$PAGE->set_heading(get_string('headeventtag', 'tool_untoken_oauth2'));
$PAGE->set_url($CFG->wwwroot . '/admin/tool/untoken_oauth2/logevent.php');

$back = optional_param('back', false, PARAM_BOOL);
$sort = optional_param('sort', 'name', PARAM_ALPHANUM);
$dir = optional_param('dir', 'ASC', PARAM_ALPHA);
$page = optional_param('page', 0, PARAM_INT);
$perpage = optional_param('perpage', 10, PARAM_INT); // how many per page

$context = context_system::instance();
require_capability('moodle/user:viewdetails', $context);
require_capability('moodle/user:delete', $context);
require_capability('tool/untoken_oauth2:action', $context);

$site = get_site();

$mform = new tool_untoken_oauth2_lform();
echo $OUTPUT->header();
if ($back) {

    redirect(new moodle_url('searchlink.php', array()));
} else {
    $mform->display();
    $table = new html_table();
    $table->head = array(
        'id',
        'from_username',
        'to_username',
        'userid',
        'email',
        'eventname',
        'timecreated'
    );
    $table->colclasses[] = 'centeralign';
    $table->attributes['cellpadding'] = '2';
    $logs = $DB->get_records('tool_untoken_oauth2_log');
    $fecha = new DateTime();

    $band = ($page * $perpage);
    $from = ($page + 1) * $perpage;
    $cont = 0;

    foreach ($logs as $log) {
        if ($band == $from) {
            break;
        }
        if ($cont == $band) {
            $fecha->setTimestamp($log->timecreated);
            $table->data[] = array(
                $log->id,
                $log->from_username,
                $log->username,
                $log->userid,
                $log->email,
                $log->eventname,
                $fecha->format('d-m-Y H:i:s')
            );
            $band ++;
        }
        $cont ++;
    }

    $url = new moodle_url('manager.php', array());
    $back = true;
    $baseurl = new moodle_url('logevent.php', array(
        'sort' => $sort,
        'dir' => $dir,
        'perpage' => $perpage
    ));
    $rowcount = $DB->count_records('tool_untoken_oauth2_log');
    echo '<br><br>';
    if (! empty($table)) {
        echo html_writer::table($table);
        echo $OUTPUT->paging_bar($rowcount, $page, $perpage, $baseurl);
    }

    echo $OUTPUT->continue_button($url);
}

echo $OUTPUT->footer();
