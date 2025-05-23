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
 * Version metadata for the block_smartedu plugin.
 *
 * @package   block_smartedu
 * @copyright 2025, Paulo Júnior <pauloa.junior@ufla.br>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


namespace block_smartedu;

require_once(__DIR__ . '/../vendor/autoload.php');

use Smalot\PdfParser\Parser;

class text_extractor {
    /**
     * Extracts text from a PDF file.
     *
     * @param string $path_to_file The path to the PDF file.
     * @return string The extracted text.
     * @throws Exception If the PDF parser class is not available or an error occurs.
     */
    protected static function block_smartedu_pdf_to_text( $path_to_file ) {
        try {
            $parser = new Parser();
            $pdf      = $parser->parseFile( $path_to_file );
            $response = $pdf->getText();

        } catch (\Exception $e) {
            error_log('Error while parsing PDF file: ' . $e->getMessage());
            throw new \Exception(get_string('resourcenotprocessable', 'block_smartedu') ); 
        }

        return $response;
    }

    /**
     * Extracts text from a DOCX file.
     *
     * @param string $path_to_file The path to the DOCX file.
     * @return string|bool The extracted text or false if an error occurs.
     */
    protected static function block_smartedu_docx_to_text( $path_to_file ) {
        $response = '';
        $zip = new \ZipArchive();

        if ($zip->open($path_to_file) === true) {
            $index = $zip->locateName('word/document.xml');
            if ($index !== false) {
                $content = $zip->getFromIndex($index);
                $response = strip_tags($content);
            }
            $zip->close();
        } else {
            error_log('Error while parsing DOCX file: ' . $e->getMessage());
            throw new \Exception(get_string('resourcenotprocessable', 'block_smartedu') ); 
        }
    
        return $response;
    }

    /**
     * Extracts text from a PPTX file.
     *
     * @param string $path_to_file The path to the PPTX file.
     * @return string The extracted text.
     */
    protected static function block_smartedu_pptx_to_text( $path_to_file ) {
        $response   = '';
        $zip_handle = new \ZipArchive();

        if (true === $zip_handle->open($path_to_file)) {
            
            $slide_number = 1; //loop through slide files
            $doc = new \DOMDocument();

            while (($xml_index = $zip_handle->locateName('ppt/slides/slide' . $slide_number . '.xml')) !== false) {

                $xml_data   = $zip_handle->getFromIndex($xml_index);

                $doc->loadXML($xml_data, LIBXML_NOENT | LIBXML_XINCLUDE | LIBXML_NOERROR | LIBXML_NOWARNING);
                $response  .= strip_tags($doc->saveXML());

                $slide_number++;
                
            }
            
            $zip_handle->close();
            
        } else {
            error_log('Error while parsing PPTX file: ' . $e->getMessage());
            throw new \Exception(get_string('resourcenotprocessable', 'block_smartedu') ); 
        }
        
        return $response;
    }

    /**
     * Extracts text from a TXT file.
     *
     * @param string $path_to_file The path to the TXT file.
     * @return string The extracted text.
     */
    protected static function block_smartedu_txt_to_text( $path_to_file ) {
        $response   = file_get_contents($path_to_file);
        return $response;
    }

    /**
     * Retrieves the list of valid file types for text extraction.
     *
     * @return array List of valid file extensions.
     */
    public static function block_smartedu_get_valid_file_types() {
        return [
            'docx',
            'pptx',
            'pdf',
            'txt',
        ];
    }

    /**
     * Converts a file to text based on its type.
     *
     * @param string $path_to_file The path to the file.
     * @return string The extracted text.
     * @throws Exception If the file type is invalid or the file does not exist.
     */
    public static function block_smartedu_convert_to_text( $path_to_file ) {
        if (isset($path_to_file) && file_exists($path_to_file)) {

            $valid_extensions = self::block_smartedu_get_valid_file_types();

            $file_info = pathinfo($path_to_file);
            $file_ext  = strtolower($file_info['extension']);

            if (in_array( $file_ext, $valid_extensions )) {


                $method   = 'block_smartedu_' . $file_ext . '_to_text';
                $response = self::$method( $path_to_file );

            } else {
                error_log('Error invalid file type');
                throw new \Exception(get_string('invalidtypefile', 'block_smartedu'));

            }
        } else {
            error_log('Error file does not exist');
            throw new \Exception(get_string('resourcenotfound', 'block_smartedu'));
        }        

        return $response;
    }

}