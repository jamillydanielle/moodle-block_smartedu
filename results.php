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


use block_smartedu\text_extractor;
use block_smartedu\content_generator;
use block_smartedu\resource_reader;
use block_smartedu\ai_cache;

require_once(__DIR__ . '/../../config.php');

\require_login();

/**
 * Define the max questions number for a quizz.
 */
const BLOCK_SMARTEDU_MAX_QUESTIONS_NUMBER = 7;

/**
 * Define the default questions number for a quizz.
 */
const BLOCK_SMARTEDU_DEFAULT_QUESTIONS_NUMBER = 5;

// Set up the page URL and title.
$resourceid = required_param('resourceid', PARAM_INT);
$resourcetype = required_param('resourcetype', PARAM_TEXT);
$summary_type = required_param('summarytype', PARAM_TEXT);
$questions_number = required_param('nquestions', PARAM_INT);

if ($resourcetype != 'resource' && $resourcetype != 'url') {
    throw new \Exception(get_string('resourcenotfound', 'block_smartedu'));
}

if (!$cm = get_coursemodule_from_id($resourcetype, $resourceid)) {
    throw new \Exception(get_string('resourcenotfound', 'block_smartedu'));
} 
    
// Retrieve the resource record from the database.
$context = context_module::instance($cm->id);
$course = get_course($cm->course);
require_login($course, true, $cm);

// Ensure the user has the capability to view the resource.
require_capability('mod/resource:view', $context);
$PAGE->requires->js_call_amd('block_smartedu/results', 'init');

$PAGE->set_context(context_course::instance($course->id)); // Define o contexto como o curso.
$PAGE->set_url(new moodle_url('/blocks/smartedu/results.php', ['resourceid' => $resourceid]));
$PAGE->set_title(get_string('pluginname', 'block_smartedu'));
$PAGE->set_heading($course->fullname); // Define o título do cabeçalho como o nome do curso.


$has_error = false;
$error_message = '';
$data_template = [];

try {
    $class_title = '';

    if ($resourcetype == 'resource') {
        // Read the resource file.
        $res = resource_reader::block_smartedu_read($resourceid);
        $filename = $res->file->get_filename();

        // Create a temporary directory for the file.
        $tempdir = make_request_directory('block_smartedu');
        $fullpath = $tempdir . '/' . $filename;

        // Copy the resource content to a temporary file.
        $res->file->copy_content_to($fullpath);

        $class_title = $res->name;
    } else {
        // Retrieve the resource record from the database.
        $url = $DB->get_record('url', array('id'=>$cm->instance), '*', MUST_EXIST);
        $external_url = $url->externalurl;
        $class_title = $url->name;

        if (preg_match('#^(https://docs\.google\.com/[^/]+/d/[^/]+)#', $external_url, $matches)) {
           $external_url = $matches[1];
        }
        
        // Read the resource file.
        $pdf_content = file_get_contents("$external_url/export/pdf");
        if ($pdf_content === false) {
            throw new \Exception(get_string('resourcenotprocessable', 'block_smartedu'));
        }

        // Create a temporary directory for the file.
        $tempdir = make_request_directory('block_smartedu');
        $filename = 'file_' . time() . '.pdf';
        $fullpath = $tempdir . '/' . $filename;
        
        // Copy the resource content to a temporary file.
        file_put_contents($fullpath, $pdf_content);
    }

    // Extract text content from the resource file.
    $content = text_extractor::block_smartedu_convert_to_text($fullpath);

    if ($content == "") {
        throw new \Exception(get_string('resourcenotprocessable', 'block_smartedu'));
    }

    // Retrieve API key and AI provider configuration.
    $api_key = get_config('block_smartedu', 'apikey');
    $ai_provider = get_config('block_smartedu', 'aiprovider');
    $enablecache = get_config('block_smartedu', 'enablecache');

    // Generate the prompt for the AI based on the summary type and number of questions.
    $prompt = get_string('prompt:simplesummary', 'block_smartedu', $class_title);

    if ($summary_type == 'detailed') {
        $prompt = get_string('prompt:detailedsummary', 'block_smartedu', $class_title);
    }
    
    if ($questions_number < 0 || $questions_number > BLOCK_SMARTEDU_MAX_QUESTIONS_NUMBER) {
        $questions_number = BLOCK_SMARTEDU_DEFAULT_QUESTIONS_NUMBER;
    } 
    
    $prompt .= get_string('prompt:studyscript', 'block_smartedu');
    $prompt .= get_string('prompt:mindmap', 'block_smartedu');
    
    if ($questions_number > 0) {
        $prompt .= get_string('prompt:quizz', 'block_smartedu', $questions_number);
        $prompt .= get_string('prompt:returnwithquestions', 'block_smartedu', $content);
    } else {
        $prompt .= get_string('prompt:returnwithoutquestions', 'block_smartedu', $content);
    }
    
    // Check if caching is enabled and if the response is already cached.
    $cached = $enablecache == 1 ? ai_cache::block_smartedu_get_cached_response($prompt) : null;

    if ($cached !== null and $cached !== '') {
        $response = $cached;
    } else {
        // Generate the response using the AI provider.
        $response = content_generator::block_smartedu_generate($ai_provider, $api_key, $prompt);

        // Parse the AI response.
        $response = preg_replace('/```json\s*(.*?)\s*```/s', '$1', $response);
        ai_cache::block_smartedu_store_response_in_cache($prompt, $response);
    }

    $data = json_decode($response);

    // Prepare template context.
    $num_questions = isset($data->questions) ? count($data->questions) : 0;

    $data_template['has_error'] = false;
    $data_template['has_questions'] = $num_questions > 0 ? true : false;
    $data_template['resource_name'] = $class_title;
    $data_template['summary'] = $data->summary ?? '';
    $data_template['study_script_title'] = get_string('studyscript:title', 'block_smartedu');
    $data_template['mind_map_title'] = get_string('mindmap:title', 'block_smartedu');
    $data_template['study_script'] = $data->study_script ?? '';
    $data_template['questions'] = [];

    foreach ($data->questions as $index => $question) {
        $data_template['questions'][] = [
            'question_number' => $index + 1,
            'question_text' => $question->question,
            'option_a' => $question->options->A,
            'option_b' => $question->options->B,
            'option_c' => $question->options->C,
            'option_d' => $question->options->D,
            'feedback_a' => $question->feedbacks->A,
            'feedback_b' => $question->feedbacks->B,
            'feedback_c' => $question->feedbacks->C,
            'feedback_d' => $question->feedbacks->D,
            'correct_option' => $question->correct_option,
        ];
    }

    $data_template['send_responses_label'] = get_string('quizz:sendresponses', 'block_smartedu');
    $data_template['correct_answer_label'] = get_string('quizz:correct', 'block_smartedu');
    $data_template['wrong_answer_label'] = get_string('quizz:wrong', 'block_smartedu');
    $data_template['response_label'] = get_string('quizz:showresponse', 'block_smartedu');

    $PAGE->requires->js_call_amd('block_smartedu/mindmap', 'init', [
        'mindMapData' => $data->mind_map ?? '',
    ]);

} catch (Exception $e) {
    $has_error = true;
    $error_message = $e->getMessage();
    $data_template['has_error'] = true;
    $data_template['error_message'] = $error_message;
}

// Output the page.
echo $OUTPUT->header();
echo $OUTPUT->render_from_template('block_smartedu/results', $data_template);
echo $OUTPUT->footer();