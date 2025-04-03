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

/**
 * Block edit form class for the block_pluginname plugin.
 *
 * @package   block_smartedu
 * @copyright 2025, Paulo Júnior <pauloa.junior@ufla.br>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

class block_smartedu_edit_form extends block_edit_form {
    protected function specific_definition($mform) {
        // A sample string variable with a default value.
        $options = array(
            'simple' => get_string('summarytype:simple', 'block_smartedu'),
            'detailed' => get_string('summarytype:detailed', 'block_smartedu'),
        );
        $select = $mform->addElement('select', 'config_summarytype', get_string('summarytype', 'block_smartedu'), $options);
        // This will select the colour blue.
        $select->setSelected('simple');
    }
}