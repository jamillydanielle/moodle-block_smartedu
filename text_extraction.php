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

require_once('vendor/autoload.php');

class Text_Extraction
{
    /**
     * @param $path_to_file
     * @return string
     * @throws Exception
     */
    protected static function pdf_to_text( $path_to_file ) {

        if ( class_exists( '\\Smalot\\PdfParser\\Parser') ) {

            $parser   = new \Smalot\PdfParser\Parser();
            $pdf      = $parser->parseFile( $path_to_file );
            $response = $pdf->getText();

        } else {
            error_log('Error while parsing PDF file');
            throw new \Exception(get_string('resourcenotprocessable', 'block_smartedu') ); 
        }

        return $response;
    }

    /**
     * @return bool|string
     */
    protected static function docx_to_text( $path_to_file )
    {
        $response = '';
        $zip      = zip_open($path_to_file);

        if (!$zip || is_numeric($zip)) return false;

        while ($zip_entry = zip_read($zip)) {

            if (zip_entry_open($zip, $zip_entry) == FALSE)
                continue;

            if (zip_entry_name($zip_entry) != 'word/document.xml')
                continue;

            $response .= zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));

            zip_entry_close($zip_entry);
        }

        zip_close($zip);

        $response = str_replace('</w:r></w:p></w:tc><w:tc>', ' ', $response);
        $response = str_replace('</w:r></w:p>', "\r\n", $response);
        $response = strip_tags($response);

        return $response;
    }

    /**
     * @return string
     */
    protected static function pptx_to_text( $path_to_file )
    {
        $zip_handle = new ZipArchive();
        $response   = '';

        if (true === $zip_handle->open($path_to_file)) {
            
            $slide_number = 1; //loop through slide files
            $doc = new DOMDocument();

            while (($xml_index = $zip_handle->locateName('ppt/slides/slide' . $slide_number . '.xml')) !== false) {

                $xml_data   = $zip_handle->getFromIndex($xml_index);

                $doc->loadXML($xml_data, LIBXML_NOENT | LIBXML_XINCLUDE | LIBXML_NOERROR | LIBXML_NOWARNING);
                $response  .= strip_tags($doc->saveXML());

                $slide_number++;
                
            }
            
            $zip_handle->close();
            
        }
        
        return $response;
    }

    /**
     * @return string
     */
    protected static function txt_to_text( $path_to_file )
    {
        $response   = file_get_contents($path_to_file);
        return $response;
    }

    /**
     * @return array
     */
    public static function get_valid_file_types()
    {
        return [
            'docx',
            'pptx',
            'pdf',
            'txt',
        ];
    }

    /**
     * @param $path_to_file
     * @return bool|mixed|string
     * @throws Exception
     */
    public static function convert_to_text( $path_to_file )
    {
        if (isset($path_to_file) && file_exists($path_to_file)) {

            $valid_extensions = self::get_valid_file_types();

            $file_info = pathinfo($path_to_file);
            $file_ext  = strtolower($file_info['extension']);

            if (in_array( $file_ext, $valid_extensions )) {


                $method   = $file_ext . '_to_text';
                $response = self::$method( $path_to_file );

            } else {
                error_log('Error invalid file type');
                throw new \Exception(get_string('resourcenotprocessable', 'block_smartedu'));

            }

        } else {
            error_log('Error file does not exist');
            throw new \Exception(get_string('resourcenotfound', 'block_smartedu'));

        }
        

        return $response;
    }

}