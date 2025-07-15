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
 * Install script for the block_smartedu plugin.
 *
 * @package   block_smartedu
 * @copyright 2025, Paulo Júnior <pauloa.junior@ufla.br>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
*/

use block_smartedu\constants;

/*
 * Install function for the block_smartedu plugin.
 *
 * This function is called during the installation of the plugin to set up necessary
 * configurations, such as creating a tag for hiding courses.
 *
 * @return void
*/
function xmldb_block_smartedu_install() {
    $tagcollid = \core_tag_area::get_collection('core', 'course');
    $tagname = constants::TAG_HIDE;
    \core_tag_tag::create_if_missing($tagcollid, [$tagname], true);
}
