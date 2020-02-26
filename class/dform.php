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
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
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

namespace tool_untoken_oauth2;

defined('MOODLE_INTERNAL') || die();


//moodleform is defined in formslib.php
require_once($CFG->libdir .'/formslib.php');
use moodleform;

/*
 * Class dform email search
 *
 * This class have form delete elements for tool_untoken_oauth2.
 *
 * @package    tool_untoken_oauth2
 * @copyright  2019 Jonathan López <jonathan.lopez.garcia@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * Documentation class dform, have items to email delete
 */


class dform extends moodleform {
    //Add elements to form

        public function definition() {
                global $CFG;

                $mform = $this->_form; // Don't forget the underscore! 
                $mform->addElement('header', 'general' ,get_string('infoprocestag','tool_untoken_oauth2'));
		$mform->addElement('static', 'information', '<h5>'.get_string('information','tool_untoken_oauth2').':</5>',
			    '<h6><p>'.get_string('descriptionprocestag','tool_untoken_oauth2').'</p></h6>');
                $mform->addElement('submit', 'back', get_string('continue'));
	}
}
