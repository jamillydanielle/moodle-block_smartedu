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


require_once('../../config.php');
require_once($CFG->dirroot.'/mod/resource/lib.php');
require_once($CFG->dirroot.'/mod/resource/locallib.php');
require_once($CFG->libdir.'/completionlib.php');
require_once('text_extraction.php');
require_once('summary_generator.php');

$PAGE->set_url(new moodle_url('/blocks/smartedu/results.php', ['resourceid' => $resourceid]));
$PAGE->set_title(get_string('pluginname', 'block_smartedu'));

$resourceid = required_param('resourceid', PARAM_INT);
$summary_type = optional_param('summarytype', "", PARAM_TEXT);

$has_error = false;
$error_message = '';

if (!$cm = get_coursemodule_from_id('resource', $resourceid)) {
    $has_error = true;
    $error_message = get_string('resourcenotfound', 'block_smartedu');
} else {
    $resource = $DB->get_record('resource', array('id'=>$cm->instance), '*', MUST_EXIST);

    $context = context_module::instance($cm->id);
    require_capability('mod/resource:view', $context);
        
    $fs = get_file_storage();
    $files = $fs->get_area_files($context->id, 'mod_resource', 'content', 0, 'sortorder DESC, id ASC', false); 
    if (count($files) < 1) {
        $has_error = true;
        $error_message = get_string('resourcenotfound', 'block_smartedu');
    } else {
        $file = reset($files);
        unset($files);
        
        $filename = $file->get_filename();
        $fulpath = "$CFG->tempdir/$filename";
        
        $file->copy_content_to($fulpath);

        try {
            $content = Text_Extraction::convert_to_text($fulpath);

            $api_key = get_config('block_smartedu', 'apikey');
            $api_url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=$api_key";

            $prompt = "Com base no seguinte conteúdo da aula intitulada '$resource->name', escreva um resumo simples, de no máximo 5 frases, destacando os principais conceitos abordados de forma objetiva e clara para um aluno de graduação. O retorno deve utilizar a tag <strong> para destacar os termos importantes. Conteúdo da aula: $content";
            
            if ($summary_type == 'detailed') {
                $prompt = "Com base no seguinte conteúdo da aula intitulada '$resource->name', escreva um resumo detalhado, entre 200 e 300 palavras, explicando os principais conceitos apresentados para um aluno de graduação. Inclua informações sobre teorias, métodos, exemplos práticos ou desafios apresentados, conforme aplicável. O retorno deve utilizar a tag <h5> para seções principais, <p> para parágrafos e <strong> para destacar termos importantes. Conteúdo da aula: $content";
            }

            $summary = Summary_Generator::generate_with_gemini($api_url, $prompt);

        } catch (Exception $e) {
            $has_error = true;
            $error_message = get_string('internalerror', 'block_smartedu');
        }
    }
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
    $summary_title = get_string('summaryfor', 'block_smartedu');

    $content_component = <<<HTML
            <div class="card">
                <div class="card-header">
                    <strong>$summary_title "$resource->name"</strong>
                </div>
                <div class="card-body">
                    <p class="card-text">$summary</p>
                    
                </div>
            </div>
        HTML;

    echo $content_component;
}



echo $OUTPUT->footer();