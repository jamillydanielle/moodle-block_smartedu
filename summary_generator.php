<?php

class Summary_Generator
{
    public static function generate_with_gemini( $apiurl, $prompt )
    {
        
        $data = [
            'contents' => 
                [
                    'parts' => [
                        'text' => $prompt
                    ]
                ]
        ];
        
        $headers = [
            'Content-Type: application/json',
        ];
    
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $apiurl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        
        if (curl_errno($ch)) {
            throw new \Exception(get_string('internalerror', 'block_smartedu') . ' ' . curl_error($ch) );
        }
        
        curl_close($ch);
        
        if ($httpCode != 200) {
            throw new \Exception(get_string('internalerror', 'block_smartedu') . ' HTTP CODE: ' . $httpCode ); 
        }
        
        $chat_response = json_decode($response, true);
        $chat_content = $chat_response['candidates'][0]['content']['parts'][0]['text'];
        return $chat_content;
    }

}