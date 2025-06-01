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
 * Prompt generator class for the block_smartedu plugin.
 *
 * @package   block_smartedu
 * @copyright 2025, Paulo Júnior <pauloa.junior@ufla.br>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace block_smartedu;

class prompt_generator {
    /**
     * Define the max questions number for a quizz.
     */
    private const BLOCK_SMARTEDU_MAX_QUESTIONS_NUMBER = 7;

    /**
     * Define the default questions number for a quizz.
     */
    private const BLOCK_SMARTEDU_DEFAULT_QUESTIONS_NUMBER = 5;


    /**
     * Retrieves the list of valid prompt types.
     *
     * @return array List of valid prompts types.
     */
    protected static function block_smartedu_get_valid_prompt_types() {
        return [
            'resource',
            'forum',
        ];
    }

    /**
     * Generates prompt for foruns.
     * @param array $config Configuration settings for the resource.
     * @param string $content The content to be used in the prompt generation.
     */
    protected static function block_smartedu_generate_for_forum( $config, $content ) {
        if ($config['summary_type'] == 'simple') {
            return get_string('prompt:simpleforum', 'block_smartedu', $content);
        }     

        return get_string('prompt:detailedforum', 'block_smartedu', $content);
    }

    /**
     * Generates prompt for resources.
     * @param array $config Configuration settings for the resource.
     * @param string $content The content to be used in the prompt generation.
     */
    protected static function block_smartedu_generate_for_resource( $config, $content ) {
        $class_title = $config['class_title'];
        $summary_type = $config['summary_type'];
        $questions_number = $config['questions_number'];
        $generatestudyguide = $config['generatestudyguide'];
        $generatemindmap = $config['generatemindmap'];

        $prompt = get_string('prompt:simplesummary', 'block_smartedu', $class_title);

        if ($summary_type == 'detailed') {
            $prompt = get_string('prompt:detailedsummary', 'block_smartedu', $class_title);
        }
        
        if ($generatestudyguide) {
            $prompt .= get_string('prompt:studyscript', 'block_smartedu');
        }

        if ($generatemindmap) {
            $prompt .= get_string('prompt:mindmap', 'block_smartedu');
        }

        if ($questions_number < 0 || $questions_number > self::BLOCK_SMARTEDU_MAX_QUESTIONS_NUMBER) {
            $questions_number = self::BLOCK_SMARTEDU_DEFAULT_QUESTIONS_NUMBER;
        } 
        
        
        if ($questions_number > 0) {
            $prompt .= get_string('prompt:quizz', 'block_smartedu', $questions_number);
        }
        
        $prompt .= get_string('prompt:return', 'block_smartedu', $content);

        return $prompt;
    }

    /**
     * Generates prompt using the specified prompt type and configurations.
     * 
     * @param string $prompt_type The type of prompt to generate (e.g., 'resource', 'forum').
     * @param array $config Configuration settings for the prompt generation.
     * @param string $content The content to be used in the prompt generation.
     *
     * @throws Exception If the prompt type is not valid or if there is an error during generation.
     */
    public static function block_smartedu_generate( $prompt_type, $config, $content ) {
        $response = '';
        
        $valid_prompt_types = self::block_smartedu_get_valid_prompt_types();
        $prompt_type = strtolower($prompt_type);

        if (in_array( $prompt_type, $valid_prompt_types )) {
            $method   = 'block_smartedu_generate_for_' . $prompt_type;
            $response = self::$method( $config, $content );
        } else {
            error_log('Prompt type not allowed');
            throw new \Exception(get_string('invalidtypefile', 'block_smartedu'));
        }


        return $response;
    }

}