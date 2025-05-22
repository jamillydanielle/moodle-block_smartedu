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
$string['smartedu:myaddinstance'] = 'Add a new SmartEdu block to the My Moodle page';
$string['termsofuse'] = 'By using the SmartEdu block, you agree to its <a href="https://github.com/dired-ufla/moodle-block_smartedu/blob/main/terms-of-use.md" target="_blank">Terms of Use</a>.';
$string['noresources'] = 'No <a href="https://github.com/dired-ufla/moodle-block_smartedu/blob/main/file-formats.md" target="_blank">compatible files</a> are available for this course.';
$string['aiprovider'] = "Choose your Generative AI provider";
$string['apikey'] = "Insert your API Key";
$string['enablecache'] = "Enable prompt cache";
$string['summarytype'] = "Summary type";
$string['nquestions'] = "Number of questions";
$string['summarytype:simple'] = "Simple";
$string['summarytype:detailed'] = "Detailed";
$string['studentinvisible'] = " - hidden from students";  
$string['resourcenotfound'] = "The specified resource could not be found.";  
$string['resourcenotprocessable'] = "The content of the specified resource could not be processed.";
$string['invalidtypefile'] = "Resource type not supported.";
$string['invalidaiprovider'] = "AI provider not supported.";
$string['aiprovidererror'] = "It looks like there was an error while trying to use the AI service. Please try again in a few minutes. If the problem persists, please contact support.";
$string['internalerror'] = "Internal system error.";  
$string['quizz:question'] = "Question ";
$string['quizz:showresponse'] = "The correct answer is: ";
$string['quizz:sendresponses'] = "Send responses";
$string['quizz:correct'] = "Correct answer";
$string['quizz:wrong'] = "Wrong answer";
$string['studyscript:title'] = "Study guide";
$string['mindmap:title'] = "Mind map";
$string['prompt:simplesummary'] = 'Based on the following content from the lecture titled "{$a}", write a simple summary of no more than 10 sentences, highlighting the main concepts in a clear and objective way for an undergraduate student. ';
$string['prompt:detailedsummary'] = 'Based on the following content from the lecture titled "{$a}", write a detailed summary of no more than 300 words, highlighting and explaining the main concepts for an undergraduate student. ';
$string['prompt:studyscript'] = 'Also, write a study guide for this class, formatted in HTML using h5 tags for headings, containing the main topic, the objectives of the text, what subjects need to be learned, and what the student should be able to know after reading the text. ';
$string['prompt:mindmap'] = 'Also, create a mind map of the main concepts from the lesson, in a format that can be correctly read by the JavaScript library MindElixir, as in the following example: {"nodeData": {"id": "root", "topic": "root", "children": [{"id": "sub1", "topic": "sub1", "children": [{"id": "sub2", "topic": "sub2"}]}]}}';
$string['prompt:quizz'] = 'Also, create {$a} multiple-choice questions, each with 4 options (A, B, C, D), with only one correct answer. For each option, provide a brief explanation of why it is correct or incorrect, without mentioning the word Correct or Incorrect before the explanation.';
$string['prompt:returnwithquestions'] = 'Return the summary, the study guide, and the questions in a JSON file with the following structure: {"summary": "Lecture summary", "study_script": "Lecture study guide", "mind_map": "Mind map content", "questions": [{"question": "Question text", "options": {"A": "Option A text", "B": "Option B text", "C": "Option C text", "D": "Option D text"}, "feedbacks": {"A": "Explanation of option A", "B": "Explanation of option B", "C": "Explanation of option C", "D": "Explanation of option D"}, "correct_option": "Letter of the correct option"}]}. Lecture content: {$a}';
$string['prompt:returnwithoutquestions'] = 'Return the summary and the study guide in a JSON file with the following structure: {"summary": "Lecture summary", "study_script": "Lecture study guide", "mind_map": "Mind map content"}. Lecture content: {$a}';
$string['privacy:metadata'] = 'The SmartEdu block only displays existing course data.';
$string['prompt:forum'] = 'You will receive a series of forum discussions in the following JSON format: [{"name": "Title of the forum discussion", "content": "Forum messages related to this discussion"}]. Your task is to summarize the content of the discussions and return a JSON in the same format, highlighting the main points discussed and the conclusions reached. The summary should be clear and concise, with a maximum of 300 words. Forum messages: {$a}';
