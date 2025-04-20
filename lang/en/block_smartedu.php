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
 * Languages configuration for the block_smartedu plugin.
 *
 * @package   block_smartedu
 * @copyright 2025, Paulo Júnior <pauloa.junior@ufla.br>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$string['pluginname'] = 'SmartEdu – Intelligent Learning';
$string['smartedu:addinstance'] = 'Add a new SmartEdu block';
$string['termsofuse'] = 'By using the SmartEdu block, you agree to its <a href="https://github.com/dired-ufla/moodle-block_smartedu/blob/main/terms-of-use.md" target="_blank">Terms of Use</a>.';
$string['noresources'] = 'No <a href="https://github.com/dired-ufla/moodle-block_smartedu/blob/main/file-formats.md" target="_blank">compatible files</a> are available for this course.';
$string['aiprovider'] = "Choose your Generative AI provider";
$string['apikey'] = "Insert your API Key";
$string['summarytype'] = "Summary type";
$string['nquestions'] = "Number of questions";
$string['summarytype:simple'] = "Simple";
$string['summarytype:detailed'] = "Detailed";
$string['studentinvisible'] = " - hidden from students";  
$string['resourcenotfound'] = "The specified resource could not be found.";  
$string['resourcenotprocessable'] = "The content of the specified resource could not be processed.";
$string['internalerror'] = "Internal system error.";  
$string['quizz:question'] = "Question ";
$string['quizz:showresponses'] = "Show responses";
$string['prompt:simplesummary'] = 'Based on the following content from the lecture titled "{$a}", write a simple summary of no more than 10 sentences, highlighting the main concepts in a clear and objective way for an undergraduate student. ';
$string['prompt:detailedsummary'] = 'Based on the following content from the lecture titled "{$a}", write a detailed summary of no more than 300 words, highlighting and explaining the main concepts for an undergraduate student. ';
$string['prompt:quizz'] = 'Also create {$a} multiple-choice questions, each with 4 options (A, B, C, D), with only one correct answer. ';
$string['prompt:return'] = 'Return the summary and the questions in a JSON file with the following structure: {"summary": "Lecture summary", "questions": [{"question": "Question text", "options": {"A": "Option A text", "B": "Option B text", "C": "Option C text", "D": "Option D text", },"correct_option": "Letter of the correct option"}]}. Lecture content: {$a}';
$string['privacy:metadata'] = 'The SmartEdu block only displays existing course data.';
