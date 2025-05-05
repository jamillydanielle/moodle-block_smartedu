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


use block_smartedu\content_generator;
use block_smartedu\ai_cache;
use block_smartedu\forum_reader;

require_once(__DIR__ . '/../../config.php');

// Set up the page URL and title.
$forumid = required_param('forumid', PARAM_INT);
$summary_type = optional_param('summarytype', "", PARAM_TEXT);

try {

    // Retrieve the course module for the given resource ID.
    if (!$cm = get_coursemodule_from_id('forum', $forumid)) {
        throw new \Exception(get_string('resourcenotfound', 'block_smartedu'));
    } 
        
    $context = context_module::instance($cm->id);
    $course = get_course($cm->course);
    require_login($course, true, $cm);

    $discussions = forum_reader::block_smartedu_read($forumid);

    $PAGE->set_context($context); // Define o contexto como o curso.
    $PAGE->set_url(new moodle_url('/blocks/smartedu/forum.php', ['forumid' => $forumid]));
    $PAGE->set_title(get_string('pluginname', 'block_smartedu'));
    $PAGE->set_heading($course->fullname); // Define o título do cabeçalho como o nome do curso.


    $data_template['has_error'] = false;

    foreach ($discussions as $discussion) {
        $data_template['discussions'] = $discussion;
    }

} catch (Exception $e) {
    $has_error = true;
    $error_message = $e->getMessage();
    $data_template['has_error'] = true;
    $data_template['error_message'] = $error_message;
}

// Output the page.
echo $OUTPUT->header();
echo $OUTPUT->render_from_template('block_smartedu/forum', $data_template);
echo $OUTPUT->footer();