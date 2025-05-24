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
 * Block definition class for the block_smartedu plugin.
 *
 * @package   block_smartedu
 * @copyright 2025, Paulo Júnior <pauloa.junior@ufla.br>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

 use block_smartedu\text_extractor;
 use block_smartedu\resource_reader;

/**
 * Class block_smartedu
 * 
 * Defines the block_smartedu plugin functionality.
 */

class block_smartedu extends block_base {

    /**
     * Initialises the block.
     *
     * @return void
     */
    public function init() {
        $this->title = get_string('pluginname', 'block_smartedu');
    }

    /**
     * Gets the block contents.
     *
     * @return string The block HTML.
     */
    public function get_content() {
        global $OUTPUT, $COURSE;
        
        if ($this->content !== null) {
            return $this->content;
        }

        $termsofuse = get_string('termsofuse', 'block_smartedu');
        $noresources = get_string('noresources', 'block_smartedu');

        $resources = $this->get_resources_list();
        $data = [
            'resources' => [],
            'termsofuse' => $termsofuse,
            'noresources' => $noresources,
        ];        

        foreach ($resources as $item) {
            if (strpos($item->type, 'forum_') === 0) {
                $url = new moodle_url('/blocks/smartedu/forum.php', [
                    'forumid' => $item->id,
                    'forumtype' => $item->type
                ]);
            } else if ($item->type === 'resource') {
                $url = new moodle_url('/blocks/smartedu/results.php', [
                    'resourceid' => $item->id,
                    'resourcetype' => 'resource',
                    'summarytype' => $this->config->summarytype == '' ? 'simple' : $this->config->summarytype,
                    'nquestions' => $this->config->nquestions == '' ? 5 : $this->config->nquestions,
                ]);
            } else if ($item->type === 'url') {
                $url = new moodle_url('/blocks/smartedu/results.php', [
                    'resourceid' => $item->id,
                    'resourcetype' => 'url',
                    'summarytype' => $this->config->summarytype == '' ? 'simple' : $this->config->summarytype,
                    'nquestions' => $this->config->nquestions == '' ? 5 : $this->config->nquestions,
                ]);
            } 


            $data['resources'][] = [
                'name' => $item->name,
                'type' => $item->type,
                'icon_url' => $item->icon_url,
                'url' => $url->out(false),
            ];
        }

        $this->content = new \stdClass();
        $this->content->text = $OUTPUT->render_from_template('block_smartedu/block_smartedu', $data);
        $this->content->footer = '';

        return $this->content;
    }
    
    /**
     * Retrieves the list of resources for the current course.
     *
     * @return array List of resources as objects with id, name, and icon_url.
     */
    private function get_resources_list() {
        global $COURSE, $DB;
        
        $allowed_extensions = text_extractor::block_smartedu_get_valid_file_types();
        $course_info = get_fast_modinfo($COURSE->id);
        $resourses = array();

        foreach ($course_info->cms as $key => $item) {
           
            // Exclude resources invisible for users 
            if (!$item->uservisible) {
                continue;
            }

            if ($item->modname != 'resource' && $item->modname != 'forum' && $item->modname != 'url') {
                continue;
            }


            $type = $item->modname;
            
            if ($type == 'forum') {
                
                // Exlude foruns of the type 'news' 
                if (!$cm = get_coursemodule_from_id('forum', $item->id)) {
                    continue;
                } 
            
                $forum = $DB->get_record('forum', ['id' => $cm->instance], '*', IGNORE_MISSING);
                if (!$forum or $forum->type === 'blog' or $forum->type === 'news') {
                    continue;
                }

                $type = 'forum_' . $forum->type;

            } else if ($type == 'resource') {

                $res = resource_reader::block_smartedu_read($item->id);
                $filename = $res->file->get_filename();
                $file_extension = substr(strrchr($filename, '.'), 1);
                
                if (!in_array(strtolower($file_extension), $allowed_extensions)) {
                    continue;
                }

            } else if ($type == 'url') {
                $url = $DB->get_record('url', ['id' => $item->instance], '*', IGNORE_MISSING);
                if (!$url) {
                    continue;
                }

                $externalurl = $url->externalurl;
                $pattern = '/https:\/\/docs\.google\.com\/presentation\/d\/[^\/]+/i';
                $is_google_slides = preg_match($pattern, $externalurl);

                if (!$is_google_slides) {
                    continue;
                }

                $type = 'url';
            }

            $obj = new stdClass();
            $obj->id = $item->id;
            $obj->name = $item->name;
            $obj->type = $type;
           
            if (!$item->visible) {
                $obj->name .= get_string('studentinvisible', 'block_smartedu'); 
            }
            
            $obj->icon_url = $item->get_icon_url();

            $resourses[] = $obj;
        }


        return $resourses;
    }

    /**
     * Defines in which pages this block can be added.
     *
     * @return array of the pages where the block can be added.
     */
    public function applicable_formats() {
        return [
            'course-view' => true,
        ];
    }

    /**
     * Indicates if the block has a global configuration page.
     *
     * @return bool True if the block has a configuration page, false otherwise.
     */
    function has_config() {
        return true;
    }
}