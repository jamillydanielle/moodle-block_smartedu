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

$string['pluginname'] = 'SmartEdu – Aprendizaje Inteligente';
$string['smartedu:addinstance'] = 'Agregar un nuevo bloque SmartEdu';
$string['smartedu:myaddinstance'] = 'Agregar un nuevo bloque SmartEdu a la página Mi Moodle';
$string['termsofuse'] = 'Al utilizar el bloque SmartEdu, aceptas sus <a href="https://github.com/dired-ufla/moodle-block_smartedu/blob/main/terms-of-use.md" target="_blank">Términos de uso</a>.';
$string['noresources'] = 'No hay <a href="https://github.com/dired-ufla/moodle-block_smartedu/blob/main/file-formats.md" target="_blank">archivos compatibles</a> disponibles para este curso.';

// Admin settings
$string['aiprovider'] = "Elige tu proveedor de IA";
$string['apikey'] = "Introduce la clave API de tu proveedor de IA";
$string['enablecache'] = "Habilitar caché de prompts";
$string['apiurl'] = "Introduce la URL de la API de tu proveedor de IA (local)";
$string['apiurl:example'] = "http://localhost:11434/api/chat";
$string['aimodel'] = "Introduce el modelo de tu proveedor de IA";
$string['aimodel:example'] = "gemma3:4b, gemini-2.0-flash, gpt-4o-mini, etc.";


$string['summarytype'] = "Tipo de resumen (para foros y recursos)";
$string['nquestions'] = "Número de preguntas";
$string['summarytype:simple'] = "Simple";
$string['summarytype:detailed'] = "Detallado";
$string['studentinvisible'] = " - oculto para los estudiantes";
$string['resourcenotfound'] = "No se pudo encontrar el recurso especificado.";
$string['resourcenotprocessable'] = "No se pudo procesar el contenido del recurso especificado.";
$string['invalidtypefile'] = "Tipo de recurso no compatible.";
$string['invalidaiprovider'] = "Proveedor de IA no compatible.";
$string['aiprovidererror'] = "Parece que ocurrió un error al intentar utilizar el servicio de IA. Por favor, inténtelo de nuevo en unos minutos. Si el problema persiste, contacte al soporte.";
$string['internalerror'] = "Error interno del sistema.";
$string['generatestudyguide'] = "Generar guía de estudio (para recursos)";
$string['generatemindmap'] = "Generar mapa mental (para recursos)";
$string['quizz:question'] = "Pregunta ";
$string['quizz:showresponse'] = "La respuesta correcta es: ";
$string['quizz:sendresponses'] = "Enviar respuestas";
$string['quizz:correct'] = "Respuesta correcta";
$string['quizz:wrong'] = "Respuesta incorrecta";
$string['studyscript:title'] = "Guía de estudio";
$string['mindmap:title'] = "Mapa mental";

$string['prompt:simplesummary'] = 'Con base en el contenido de la clase a continuación, escribe un resumen simple de máximo 10 frases, destacando los principales conceptos abordados de forma objetiva y clara para un estudiante de grado. Devuelve el resumen en texto plano, sin formato. Contenido de la clase: {$a}';
$string['prompt:detailedsummary'] = 'Con base en el contenido de la clase a continuación, escribe un resumen detallado de máximo 30 frases, destacando y explicando los principales conceptos abordados para un estudiante de grado. Devuelve el resumen en texto plano, sin formato. Contenido de la clase: {$a}';
$string['prompt:studyscript'] = 'Con base en el contenido de la clase a continuación, escribe una guía de estudio para esta clase, incluyendo el tema principal, los objetivos del texto, los temas que deben ser aprendidos y lo que el estudiante debe ser capaz de saber después de leer el texto. Devuelve la guía de estudio en formato HTML, utilizando la etiqueta <h5> para títulos y <ul> para listas. Contenido de la clase: {$a}';
$string['prompt:mindmap'] = 'Con base en el contenido de la clase a continuación, elabora un mapa mental de los principales conceptos de la clase. Devuelve el mapa mental en formato JSON que pueda ser leído correctamente por la biblioteca JavaScript MindElixir, según el siguiente ejemplo: {"nodeData": {"id": "root", "topic": "root", "children": [{"id": "sub1", "topic": "sub1", "children": [{"id": "sub2", "topic": "sub2"}]}]}}. Contenido de la clase: {$a}';
$string['prompt:quizz'] = 'Con base en el contenido de la clase a continuación, elabora {$a->numquestions} preguntas de opción múltiple, con 4 alternativas (A, B, C, D), siendo solo una correcta. Para cada alternativa, proporciona una breve explicación de por qué es correcta o incorrecta, sin mencionar la palabra Correcta o Incorrecta antes de la explicación. Devuelve las preguntas en formato JSON, según el siguiente ejemplo: {"questions": [{"question": "Texto de la pregunta", "options": {"A": "Texto de la alternativa A", "B": "Texto de la alternativa B", "C": "Texto de la alternativa C", "D": "Texto de la alternativa D"}, "feedbacks": {"A": "Explicación de la alternativa A", "B": "Explicación de la alternativa B", "C": "Explicación de la alternativa C", "D": "Explicación de la alternativa D"}, "correct_option": "Letra de la alternativa correcta"}]}. Contenido de la clase: {$a->classcontent}';
$string['prompt:forum'] = 'Con base en las discusiones de foro a continuación, escribe resúmenes simples de máximo 10 frases sobre el contenido de cada discusión. Devuelve los resúmenes en formato JSON, según el siguiente ejemplo: {"summaries": [{"name": "Título de la discusión del foro", "content": "Mensajes del foro relacionados con la discusión"}]}. Discusiones del foro: {$a}';

$string['privacy:metadata'] = 'El bloque SmartEdu solo muestra datos existentes del curso.';
