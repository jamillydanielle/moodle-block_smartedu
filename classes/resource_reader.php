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

namespace block_smartedu;

/**
 * Class resource_reader
 *
 * Provides functionality to read and retrieve resource details.
 */
class resource_reader {

    /**
     * Reads a resource by its ID and retrieves its details.
     *
     * @param int $resourceid The ID of the resource to read.
     * @return stdClass An object containing the resource name and file.
     * @throws Exception If the resource is not found or the user lacks the required capability.
     */
    public static function block_smartedu_read( $resourceid ) {
        global $DB, $CFG;

        // Retrieve the course module for the given resource ID.
        if (!$cm = get_coursemodule_from_id('resource', $resourceid)) {
            throw new \Exception(get_string('resourcenotfound', 'block_smartedu'));
        } 
            
        // Retrieve the resource record from the database.
        $resource = $DB->get_record('resource', array('id'=>$cm->instance), '*', MUST_EXIST);
        $context = \context_module::instance($cm->id);
            
        // Ensure the user has the capability to view the resource.
        require_capability('mod/resource:view', $context);
                   
        // Retrieve the files associated with the resource.
        $fs = get_file_storage();
        $files = $fs->get_area_files($context->id, 'mod_resource', 'content', 0, 'sortorder DESC, id ASC', false); 
            
        if (count($files) < 1) {
            throw new \Exception(get_string('resourcenotfound', 'block_smartedu'));
        } 
            
        // Get the first file in the list.
        $file = reset($files);
        unset($files);

        // Create an object to store the resource details.
        $obj = new \StdClass();
        $obj->name = $resource->name;
        $obj->file = $file;
    
        return $obj;
    }

}