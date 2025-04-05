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
$string['termsofuse'] = 'By using the SmartEdu block, you agree to its <a href="https://github.com/dired-ufla/moodle-block_smartedu/blob/main/terms-of-use.md" target="_blank">Terms of Use</a>.';
$string['noresources'] = 'No <a href="https://github.com/dired-ufla/moodle-block_smartedu/blob/main/file-formats.md" target="_blank">compatible files</a> are available for this course.';
$string['aiprovider'] = "Choose your Generative AI provider";
$string['apikey'] = "Insert your API Key";
$string['summarytype'] = "Summary type";
$string['summarytype:simple'] = "Simple";
$string['summarytype:detailed'] = "Detailed";
$string['studentinvisible'] = " - hidden from students";  
$string['resourcenotfound'] = "The specified resource could not be found.";  
$string['internalerror'] = "Internal system error.";  
$string['summaryfor'] = "Summary about ";
$string['prompt:simple_summary'] = 'Based on the following content from the lesson entitled "{$a->resource_name}", write a simple summary in no more than 5 sentences, highlighting the main concepts in a clear and objective way for an undergraduate student. Do not format the text as a code block. All highlighted words must be enclosed within the <strong> tag. Do not create a title for the lesson summary and do not use Markdown to format the text. Lesson content: {$a->resource_content}';
$string['prompt:detailed_summary'] = 'Based on the following content from the lesson entitled "{$a->resource_name}", write a detailed summary of up to 300 words, explaining the main concepts presented for an undergraduate student. Include information about theories, methods, practical examples, or challenges discussed, as applicable. Do not format the text as a code block. Use the <h5> tag for main sections, the <p> tag for paragraphs, and the <strong> tag to highlight important terms. Do not create a title for the lesson summary and do not use Markdown to format the text. Lesson content: {$a->resource_content}';
