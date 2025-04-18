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
* Quizz page for the block_smartedu plugin.
*
* @package   block_smartedu
* @copyright 2025, Paulo Júnior <pauloa.junior@ufla.br>
* @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
*/

require_once(__DIR__ . '/../../config.php');
require_once($CFG->dirroot.'/mod/resource/lib.php');
require_once($CFG->dirroot.'/mod/resource/locallib.php');
require_once($CFG->libdir.'/completionlib.php');

class Resource_Reader
{

    public static function read( $resourceid ) {
        global $DB, $CFG;

        if (!$cm = get_coursemodule_from_id('resource', $resourceid)) {
            throw new \Exception(get_string('resourcenotfound', 'block_smartedu'));
        } 
            
        $resource = $DB->get_record('resource', array('id'=>$cm->instance), '*', MUST_EXIST);
        $context = context_module::instance($cm->id);
            
        require_capability('mod/resource:view', $context);
                   
        $fs = get_file_storage();
        $files = $fs->get_area_files($context->id, 'mod_resource', 'content', 0, 'sortorder DESC, id ASC', false); 
            
        if (count($files) < 1) {
            throw new \Exception(get_string('resourcenotfound', 'block_smartedu'));
        } 
            
        $file = reset($files);
        unset($files);

        $obj = new StdClass();
        $obj->name = $resource->name;
        $obj->file = $file;
    
        return $obj;
    }

}