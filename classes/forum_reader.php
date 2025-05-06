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
 * Class forum_reader
 *
 * Provides functionality to read and retrieve forum discussions.
 */
class forum_reader {

    /**
     * Reads a forum by its ID and retrieves each discussion and its posts.
     *
     * @param int $forumid The ID of the forum to read.
     * @return stdClass An object containing the forum discussions, where each discussion includes:
     *                  - name (string): The name of the discussion.
     *                  - content (string): The concatenated and sanitized content of the posts (excluding the first post).
     * @throws Exception If the forum is not found or the user lacks the required capability.
     */
    protected static function block_smartedu_read_each_discussion($forumid) {
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
    
            $messages = '';
            foreach ($posts as $post) {
                if ($first_post) {
                    $first_post = false;
                    continue;
                }
            
                $messages .= $post->message . " ";
            }

            if ($messages === '') {
                continue;
            }
    
            $obj->discussions[] = [                
                'name' => $discussion->name,
                'content' => strip_tags($messages), 
            ];
        }
    
        return $obj;
    }

    /**
     * Reads a forum by its ID and retrieves all discussion and its posts.
     *
     * @param int $forumid The ID of the forum to read.
     * @return stdClass An object containing the forum discussions, where each discussion includes:
     *                  - name (string): The name of the discussion.
     *                  - content (string): The concatenated and sanitized content of the posts (excluding the first post).
     * @throws Exception If the forum is not found or the user lacks the required capability.
     */
    protected static function block_smartedu_read_all_discussions($forumid) {
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
    
        $messages = '';
        foreach ($discussions as $discussion) {
    
            $posts = $DB->get_records('forum_posts', ['discussion' => $discussion->id]);
    
            foreach ($posts as $post) {                       
                $messages .= $post->message . " ";
            }

            if ($messages === '') {
                continue;
            }
    
            
        }
    
        $obj->discussions[] = [                
            'name' => $forum->name,
            'content' => strip_tags($messages), 
        ];

        return $obj;
    }

    /**
     * Reads a general forum by its ID.
     *
     * @param int $forumid The ID of the forum to read.
     * @return stdClass An object containing the forum discussions, where each discussion includes:
     *                  - name (string): The name of the discussion.
     *                  - content (string): The concatenated and sanitized content of the posts (excluding the first post).
     * @throws Exception If the forum is not found or the user lacks the required capability.
     */
    protected static function block_smartedu_read_forum_general( $forumid ) {
        return self::block_smartedu_read_all_discussions( $forumid );        
    }
    
    /**
     * Reads a qanda forum by its ID.
     *
     * @param int $forumid The ID of the forum to read.
     * @return stdClass An object containing the forum discussions, where each discussion includes:
     *                  - name (string): The name of the discussion.
     *                  - content (string): The concatenated and sanitized content of the posts (excluding the first post).
     * @throws Exception If the forum is not found or the user lacks the required capability.
     */
    protected static function block_smartedu_read_forum_qanda( $forumid ) {
        return self::block_smartedu_read_each_discussion( $forumid );        
    }

        /**
     * Reads a single forum by its ID.
     *
     * @param int $forumid The ID of the forum to read.
     * @return stdClass An object containing the forum discussions, where each discussion includes:
     *                  - name (string): The name of the discussion.
     *                  - content (string): The concatenated and sanitized content of the posts (excluding the first post).
     * @throws Exception If the forum is not found or the user lacks the required capability.
     */
    protected static function block_smartedu_read_forum_single( $forumid ) {
        return self::block_smartedu_read_each_discussion( $forumid );        
    }

        /**
     * Reads a eachuser forum by its ID.
     *
     * @param int $forumid The ID of the forum to read.
     * @return stdClass An object containing the forum discussions, where each discussion includes:
     *                  - name (string): The name of the discussion.
     *                  - content (string): The concatenated and sanitized content of the posts (excluding the first post).
     * @throws Exception If the forum is not found or the user lacks the required capability.
     */
    protected static function block_smartedu_read_forum_eachuser( $forumid ) {
        return self::block_smartedu_read_all_discussions( $forumid );        
    }

    /**
     * Retrieves the list of valid forum types.
     *
     * @return array List of valid forum types.
     */
    protected static function block_smartedu_get_valid_forum_types() {
        return [
            'forum_qanda',
            'forum_general',
            'forum_eachuser',
            'forum_single',
        ];
    }

    /**
     * Reads a forum by its ID and type, delegating to the appropriate method based on the forum type.
     *
     * @param int $forumid The ID of the forum to read.
     * @param string $forumtype The type of the forum (e.g., 'forum_qanda', 'forum_general').
     * @return stdClass An object containing the forum discussions, where each discussion includes:
     *                  - name (string): The name of the discussion or forum.
     *                  - content (string): The concatenated and sanitized content of the posts.
     * @throws Exception If the forum type is invalid or the forum is not found.
     */
    public static function block_smartedu_read($forumid, $forumtype) {
        $response = '';
        
        $valid_forum_types = self::block_smartedu_get_valid_forum_types();
        $forum_type = strtolower($forumtype);

        if (in_array( $forumtype, $valid_forum_types )) {           
            $method   = 'block_smartedu_read_' . $forum_type;
            $response = self::$method( $forumid );
        } else {
            error_log('Forum type not allowed');
            throw new \Exception(get_string('internalerror', 'block_smartedu'));
        }

        return $response;
    }
    

}