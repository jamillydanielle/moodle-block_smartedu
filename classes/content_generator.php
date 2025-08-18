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
 * Content generator class for the block_smartedu plugin.
 *
 * @package   block_smartedu
 * @copyright 2025, Paulo Júnior <pauloa.junior@ufla.br>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace block_smartedu;

use block_smartedu\ai_cache;

class content_generator {

    private $ai_provider;
    private $ai_model;
    private $api_base_url;
    private $api_key;
    private $enable_cache;

    // Generate a construct that receives the AI provider, AI model, API Base URL, API key and a Boolean to indicate if the cache is enabled.
    public function __construct($ai_provider, $ai_model, $api_base_url, $api_key, $enable_cache) {
        $this->ai_provider = $ai_provider;
        $this->ai_model = $ai_model;
        $this->api_base_url = $api_base_url;
        $this->api_key = $api_key;
        $this->enable_cache = $enable_cache;
    }

    /**
     * Generates content using Ollama API.
     *
     * @param string $api_key The API key for Google AI.
     * @param string $prompt The prompt to send to the AI.
     * @return string The generated content.
     * @throws Exception If there is a CURL or HTTP error.
     */
    protected function block_smartedu_generate_with_ollama( $prompt, $format_json ) {
        $data = [
            'model' => $this->ai_model, // Model name for the local AI service
            'stream'   => false, // Disable streaming for local AI
            'messages' => [
                [
                    'role' => 'user',
                    'content' =>  $prompt,
                ]
            ],
            'options' => [
                    'num_ctx' => 8192,
                    'num_keep' => 512,
                    'temperature' => 0.2,
                    'top_p' => 0.9,
                    'repeat_penalty' => 1.1
            ]
        ];

        if ($format_json) {
            $data['format'] = 'json';
        }
        
        $headers = [
            'Content-Type: application/json',
        ];

        $options = [
            'CURLOPT_HTTPHEADER' => $headers,
            'CURLOPT_TIMEOUT' => 180,
        ];
    
        $curl = new \curl();
        $response = $curl->post($this->api_base_url, json_encode($data), $options);

        if ($curl->get_errno()) {
            error_log('CURL error: ' . $curl->error);
            throw new \Exception(get_string('internalerror', 'block_smartedu'));
        }
        
        $httpCode = $curl->info['http_code'];
        if ($httpCode != 200) {
            error_log('HTTP error: ' . $httpCode);
            throw new \Exception(get_string('aiprovidererror', 'block_smartedu'));
        }
        
        $chat_response = json_decode($response, true);
        $chat_content = $chat_response['message']['content'];

        return $chat_content;
    }


    /**
     * Generates content using Google's AI API.
     *
     * @param string $api_key The API key for Google AI.
     * @param string $prompt The prompt to send to the AI.
     * @return string The generated content.
     * @throws Exception If there is a CURL or HTTP error.
     */
    protected function block_smartedu_generate_with_google( $prompt, $format_json ) {
        $api_url = "https://generativelanguage.googleapis.com/v1beta/models/{$this->ai_model}:generateContent?key={$this->api_key}";

        $data = [
            'contents' => 
                [
                    'parts' => [
                        'text' => $prompt,
                    ]
                ]
        ];

        if ($format_json) {
            $data['generationConfig'] = [
                'responseMimeType' => 'application/json'
            ];
        }
        
        $headers = [
            'Content-Type: application/json',
        ];

        $curl = new \curl();
        $options = [
            'CURLOPT_HTTPHEADER' => $headers,
            'CURLOPT_TIMEOUT' => 90,
        ];
    
        $response = $curl->post($api_url, json_encode($data), $options);

        if ($curl->get_errno()) {
            error_log('CURL error: ' . $curl->error);
            throw new \Exception(get_string('internalerror', 'block_smartedu'));
        }
        
        $httpCode = $curl->info['http_code'];
        if ($httpCode != 200) {
            error_log('HTTP error: ' . $httpCode);
            throw new \Exception(get_string('aiprovidererror', 'block_smartedu'));
        }
        
        $chat_response = json_decode($response, true);
        $chat_content = $chat_response['candidates'][0]['content']['parts'][0]['text'];
        return $chat_content;
    }

    /**
     * Generates content using OpenAI's API.
     *
     * @param string $api_key The API key for OpenAI.
     * @param string $prompt The prompt to send to the AI.
     * @return string The generated content.
     * @throws Exception If there is a CURL or HTTP error.
     */
    protected function block_smartedu_generate_with_openai( $prompt, $format_json ) {
        $api_url = "https://api.openai.com/v1/chat/completions";

        $data = [
            'model' => $this->ai_model, 
            'messages' => [
                ['role' => 'user', 'content' => $prompt],
            ]
        ];

        if ($format_json) {
            $data['response_format'] = [
                'type' => 'json_object'
            ];
        }
        
        $headers = [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $this->api_key, // API Key da OpenAI
        ];
    
        $curl = new \curl();
        $options = [
            'CURLOPT_HTTPHEADER' => $headers,
            'CURLOPT_TIMEOUT' => 90,
        ];
    
        $response = $curl->post($api_url, json_encode($data), $options);

        if ($curl->get_errno()) {
            error_log('CURL error: ' . $curl->error);
            throw new \Exception(get_string('internalerror', 'block_smartedu'));
        }
        
        $httpCode = $curl->info['http_code'];
        if ($httpCode != 200) {
            error_log('HTTP error: ' . $httpCode);
            throw new \Exception(get_string('aiprovidererror', 'block_smartedu'));
        }
        
        $chat_response = json_decode($response, true);
        $chat_content = $chat_response['choices'][0]['message']['content'];
        return $chat_content;
    }

    /**
     * Generates content using the specified AI provider.
     *
     * @param string $ai_provider The name of the AI provider (e.g., 'openai', 'google').
     * @param string $api_key The API key for the AI provider.
     * @param string $prompt The prompt to send to the AI.
     * @return string The generated content.
     * @throws Exception If the AI provider is not valid or if there is an error during generation.
     */
    public function block_smartedu_generate( $prompt, $format_json = false ) {

        $response = '';

        // Check if caching is enabled and if the response is already cached.
        $response = $this->enable_cache ? ai_cache::block_smartedu_get_cached_response($prompt) : null;

        if ($response !== null and $response !== '') {
            return $response;
        } 
        
        $valid_ai_providers = [
            'openai',
            'google',
            'ollama',
        ];
    
        $this->ai_provider = strtolower($this->ai_provider);

        if (in_array( $this->ai_provider, $valid_ai_providers )) {
            $method   = 'block_smartedu_generate_with_' . $this->ai_provider;
            $response = $this->$method( $prompt, $format_json );
                
            if ($this->enable_cache and $response !== '') {
                ai_cache::block_smartedu_store_response_in_cache($prompt, $response);
            }

            return $response;
        } else {
            error_log('AI provider not allowed');
            throw new \Exception(get_string('invalidaiprovider', 'block_smartedu'));
        }
    }
}