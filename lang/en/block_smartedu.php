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

// Admin settings
$string['aiprovider'] = "Choose your AI provider";
$string['apikey'] = "Enter the API key for your AI provider";
$string['enablecache'] = "Enable prompt cache";
$string['apiurl'] = "Enter the API URL for your AI provider (local)";
$string['apiurl:example'] = "http://localhost:11434/api/chat";
$string['aimodel'] = "Enter the model for your AI provider";
$string['aimodel:example'] = "gemma3:4b, gemini-2.0-flash, gpt-4o-mini, etc.";

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
$string['generatestudyguide'] = "Generate study guide";
$string['generatemindmap'] = "Generate mind map";
$string['quizz:question'] = "Question ";
$string['quizz:showresponse'] = "The correct answer is: ";
$string['quizz:sendresponses'] = "Send responses";
$string['quizz:correct'] = "Correct answer";
$string['quizz:wrong'] = "Wrong answer";
$string['studyscript:title'] = "Study guide";
$string['mindmap:title'] = "Mind map";

$string['prompt:simplesummary'] = 'Based on the content of the following lesson, write a simple summary of no more than 10 sentences, highlighting the main concepts addressed in an objective and clear manner for an undergraduate student. Return the summary in plain text, without formatting. Lesson content: {$a}';
$string['prompt:detailedsummary'] = 'Based on the content of the following lesson, write a detailed summary of no more than 30 sentences, highlighting and explaining the main concepts addressed for an undergraduate student. Return the summary in plain text, without formatting. Lesson content: {$a}';
$string['prompt:studyscript'] = 'Based on the content of the following lesson, write a study script for this lesson, containing the main theme, the objectives of the text, which subjects need to be learned, and what the student should be able to know after reading the text. Return the study script in HTML format, using the <h5> tag for titles and <ul> for lists. Lesson content: {$a}';
$string['prompt:mindmap'] = 'Based on the content of the following lesson, develop a mind map of the main concepts of the lesson. Return the mind map in a JSON format that can be correctly read by the MindElixir JavaScript library, according to the following example: {"nodeData": {"id": "root", "topic": "root", "children": [{"id": "sub1", "topic": "sub1", "children": [{"id": "sub2", "topic": "sub2"}]}]}}. Lesson content: {$a}';
$string['prompt:quizz'] = 'Based on the content of the following lesson, develop {$a->numquestions} multiple-choice questions, with 4 alternatives (A, B, C, D), with only one correct. For each alternative, provide a brief explanation of why it is correct or incorrect, without mentioning the word Correct or Incorrect before the explanation. Return the questions in JSON format, according to the following example: {"questions": [{"question": "Question text", "options": {"A": "Alternative A text", "B": "Alternative B text", "C": "Alternative C text", "D": "Alternative D text"}, "feedbacks": {"A": "Explanation of alternative A", "B": "Explanation of alternative B", "C": "Explanation of alternative C", "D": "Explanation of alternative D"}, "correct_option": "Letter of the correct alternative"}]}. Lesson content: {$a->classcontent}';
$string['prompt:forum'] = 'Based on the following forum discussions, write simple summaries of no more than 10 sentences about the content of each discussion. Return the summaries in JSON format, according to the following example: {"summaries": [{"name": "Forum discussion title", "content": "Forum messages related to the discussion"}]}. Forum discussions: {$a}';

$string['privacy:metadata'] = 'The SmartEdu block only displays existing course data.';
