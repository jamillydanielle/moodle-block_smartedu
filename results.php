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


require_once('text_extractor.php');
require_once('content_generator.php');
require_once('resource_reader.php');

const MAX_QUESTIONS_NUMBER = 7;
const DEFAULT_QUESTIONS_NUMBER = 5;

$PAGE->set_url(new moodle_url('/blocks/smartedu/results.php', ['resourceid' => $resourceid]));
$PAGE->set_title(get_string('pluginname', 'block_smartedu'));

$resourceid = required_param('resourceid', PARAM_INT);
$summary_type = optional_param('summarytype', "", PARAM_TEXT);
$questions_number = optional_param('nquestions', DEFAULT_QUESTIONS_NUMBER, PARAM_INT);

$has_error = false;
$error_message = '';

try {
    $res = resource_reader::block_smartedu_read($resourceid);

    $filename = $res->file->get_filename();
    $fullpath = "$CFG->tempdir/$filename";

    $res->file->copy_content_to($fullpath);
    
    $content = text_extractor::block_smartedu_convert_to_text($fullpath);
    
    if ($content == "") {
        throw new \Exception(get_string('resourcenotprocessable', 'block_smartedu'));
    }

    $api_key = get_config('block_smartedu', 'apikey');
    $ai_provider = get_config('block_smartedu', 'aiprovider');

    $prompt = get_string('prompt:simplesummary', 'block_smartedu', $res->name);

    if ($summary_type == 'detailed') {
        $prompt = get_string('prompt:detailedsummary', 'block_smartedu', $res->name);
    } 
    
    if ($questions_number < 0 || $questions_number > MAX_QUESTIONS_NUMBER) {
        $questions_number = DEFAULT_QUESTIONS_NUMBER;
    } 
    
    $prompt .= get_string('prompt:quizz', 'block_smartedu', $questions_number);
    $prompt .= get_string('prompt:return', 'block_smartedu', $content);

    $response = content_generator::block_smartedu_generate($ai_provider, $api_key, $prompt);

    $response = preg_replace('/```json\s*(.*?)\s*```/s', '$1', $response);
    $data = json_decode($response);

} catch (Exception $e) {
    $has_error = true;
    $error_message = $e->getMessage();
}

echo $OUTPUT->header();

if ($has_error) {
    $error_component = <<<HTML
            <div class="alert alert-danger" role="alert">
                $error_message
            </div>
        HTML;

    echo $error_component;
} else {
    $summary_component = <<<HTML
            <div class="card">
                <div class="card-header">
                    <strong>$res->name</strong>
                </div>
                <div class="card-body">
                    <p class="card-text">$data->summary</p>                    
                </div>
            </div>
        HTML;

    echo $summary_component;

    
    if ($questions_number != 0) {
        $index = 0;
        $quizz_responses = '';    

        foreach($data->questions as $question) {
            $index++;
            $quizz_question = get_string('quizz:question', 'block_smartedu') . $index;
            $quizz_responses .= $quizz_question . ': ' . $question->correct_option . '<br>'; 

            $option_a = $question->options->A;
            $option_b = $question->options->B;
            $option_c = $question->options->C;
            $option_d = $question->options->D;

            $quizz_component = <<<HTML
                <div class="card mt-2">
                    <div class="card-header">
                        <strong>$quizz_question: $question->question</strong>
                    </div>
                    <div class="card-body">
                        <p class="card-text">(A) $option_a</p>
                        <p class="card-text">(B) $option_b</p>
                        <p class="card-text">(C) $option_c</p>
                        <p class="card-text">(D) $option_d</p>
                    </div>
                </div>
                HTML;
            echo $quizz_component;
        }
        
        $quizz_showresponses = get_string('quizz:showresponses', 'block_smartedu');
        $quizz_response = <<<HTML
                <div class="accordion mt-2" id="myAccordion">
                    <div class="card">
                        <div class="card-header">
                            <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#colapseOne" aria-expanded="false">
                                $quizz_showresponses
                            </button>
                        </div>
                        <div id="colapseOne" class="collapse" data-parent="#myAccordion">
                            <div class="card-body">
                                $quizz_responses
                            </div>
                        </div>
                    </div>
                </div>
                HTML;
        echo $quizz_response;
    }
}

echo $OUTPUT->footer();