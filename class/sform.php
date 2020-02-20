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


defined('MOODLE_INTERNAL') || die();

//moodleform is defined in formslib.php
require_once($CFG->libdir .'/formslib.php');
use moodleform;

class tool_untoken_oauth2_sform extends moodleform {
/*
 * Element definitions form search 
 *
 * @param int $oldversion The old version of the user tours plugin
 * @return bool
 *
 */

	public function definition() {
        	global $CFG;

	        $mform = $this->_form; // Don't forget the underscore! 
	        $mform->addElement('header', 'general' , get_string('information','tool_untoken_oauth2'));
	        $mform->addElement('text', 'email', get_string('emailsearchtag','tool_untoken_oauth2')); // Add elements to your form
	        $mform->addRule('email', '<strong>'.get_string('reqemailsearchtag','tool_untoken_oauth2').'</strong>', 'email', null, 'client', false, true);
		$mform->setType('email', PARAM_EMAIL);                   //Set type of element
	        $mform->setDefault('email', 'exaple@localhost.local');        //Default value
		
        	$mform->addElement('submit', 'search', get_string('searchbutton','tool_untoken_oauth2'));
		if ($mform->validate()){
			$mform->freeze();
		}
	}
	
/*
 * validation form email 
 *
 * @return bool
 *
 */
	
	function validation($data, $files) {
		$errors = parent::validation($data,$files); 
		if (empty($data['email'])) {
            		if (array_key_exists('email', $data)) {
                		$errors['email'] = get_string('required');
            		}
        	}
        return $errors;
	}

}
