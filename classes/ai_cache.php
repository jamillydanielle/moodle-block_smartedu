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

namespace block_smartedu;

/**
 * Class resource_reader
 *
 * Provides functionality to read and retrieve resource details.
 */
class ai_cache {

    /**
     * Retrieves a cached response for a given prompt.
     *
     * This function calculates the hash of the provided prompt and checks
     * the database table `meupluguin_cache` for a matching record. If a match
     * is found, the cached response is returned; otherwise, `null` is returned.
     *
     * @param string $prompt The prompt for which to retrieve the cached response.
     * @return string|null The cached response if it exists, or null if not found.
     */
    public static function block_smartedu_get_cached_response(string $prompt): ?string {
        global $DB;
    
        $hash = hash('sha256', $prompt);
    
        $record = $DB->get_record('block_smartedu_cache', ['prompthash' => $hash]);
        return $record ? $record->response : null;
    }
    
    /**
     * Stores a response in the cache for a given prompt.
     *
     * This function calculates the hash of the provided prompt and stores
     * the prompt, its hash, the response, and the creation time in the
     * database table `meupluguin_cache`. If a record with the same hash
     * already exists, the response is not stored again.
     *
     * @param string $prompt The prompt for which the response is being cached.
     * @param string $response The response to cache.
     * @return void
     */
    public static function block_smartedu_store_response_in_cache(string $prompt, string $response): void {
        global $DB;
    
        $hash = hash('sha256', $prompt);

        if ($DB->record_exists('block_smartedu_cache', ['prompthash' => $hash])) {
            return;
        }

        $record = new \stdClass();
        $record->prompthash = $hash;
        $record->response = $response;
        $record->timecreated = time(); // Adiciona o timestamp atual.

        $DB->insert_record('block_smartedu_cache', $record);
    }
    

}