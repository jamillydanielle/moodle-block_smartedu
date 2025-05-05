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
class forum_reader {

    /**
     * Reads a resource by its ID and retrieves its details.
     *
     * @param int $resourceid The ID of the resource to read.
     * @return stdClass An object containing the resource name and file.
     * @throws Exception If the resource is not found or the user lacks the required capability.
     */
    public static function block_smartedu_read($forumid) {
        global $DB, $CFG;
    
        // Retrieve the course module for the given resource ID.
        if (!$cm = get_coursemodule_from_id('forum', $forumid)) {
            throw new \Exception(get_string('resourcenotfound', 'block_smartedu'));
        }     
        
        $forum = $DB->get_record('forum', ['id' => $cm->instance], '*', IGNORE_MISSING);
        if (!$forum) {
            throw new \Exception(get_string('resourcenotfound', 'block_smartedu'));
        }
    
        $discussions = $DB->get_records('forum_discussions', ['forum' => $forum->id]);
    
        $obj = new \StdClass();
        $obj->discussions = [];
    
        foreach ($discussions as $discussion) {
            $posts = $DB->get_records('forum_posts', ['discussion' => $discussion->id]);
            $first_post = true;
            $first_post_content = '';
    
            $messages = '';
            foreach ($posts as $post) {
                if ($first_post) {
                    $first_post_content = $post->message;
                    $first_post = false;
                    continue;
                }
            
                $messages .= $post->message . " ";
            }
    
            $obj->discussions[] = [                
                'name' => $discussion->name,
                'description' => strip_tags($first_post_content),
                'content' => strip_tags($messages), 
            ];
        }
    
        return $obj;
    }
    

}