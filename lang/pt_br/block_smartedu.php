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

$string['pluginname'] = 'SmartEdu – Aprendizado Inteligente';
$string['termsofuse'] = 'Ao utilizar o bloco SmartEdu, você concorda com seus <a href="https://github.com/dired-ufla/moodle-block_smartedu/blob/main/terms-of-use.md" target="_blank">termos de uso</a>.';
$string['noresources'] = 'Não há <a href="https://github.com/dired-ufla/moodle-block_smartedu/blob/main/file-formats.md" target="_blank">arquivos compatíveis</a> para utilização neste curso.';
$string['aiprovider'] = "Escolha seu provedor de IA generativa";
$string['apikey'] = "Informe sua chave de API";
$string['summarytype'] = "Tipo de resumo";
$string['summarytype:simple'] = "Simples";
$string['summarytype:detailed'] = "Detalhado";
$string['studentinvisible'] = " - oculto para estudantes";
$string['resourcenotprocessable'] = "Não foi possível processar o conteúdo do recurso informado.";
$string['resourcenotfound'] = "Não foi possível encontrar o recurso informado.";
$string['internalerror'] = "Erro interno do sistema.";
$string['quizz:question'] = "Questão ";
$string['quizz:showresponses'] = "Ver gabarito";
$string['prompt'] = 'Com base no seguinte conteúdo da aula intitulada "{$a->title}", escreva um resumo simples de no máximo 10 frases, destacando os principais conceitos abordados de forma objetiva e clara para um aluno de graduação. Elabore também 5 questões de múltipla escolha, com 4 alternativas (A, B, C, D), sendo apenas uma correta. Cada questão deve incluir também uma breve justificativa da resposta correta. Retorne o resumo e as questões em um arquivo JSON, com a seguinte estrutura: {"summary": "Resumo da aula", "questions": [{"question": "Texto da pergunta", "options": {"A": "Texto da alternativa A", "B": "Texto da alternativa B", "C": "Texto da alternativa C", "D": "Texto da alternativa D", },"correct_option": "Letra da alternativa correta (por exemplo: C)", "justification": "Explicação breve sobre por que essa é a correta"}]}. Conteúdo da aula: {$a->content}. ';
