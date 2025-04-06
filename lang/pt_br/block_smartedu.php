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
$string['summaryfor'] = "Resumo sobre ";
$string['prompt:simple_summary'] = 'Com base no seguinte conteúdo da aula intitulada "{$a->resource_name}", escreva um resumo simples de no máximo 5 frases, destacando os principais conceitos abordados de forma objetiva e clara para um aluno de graduação. Não formate o texto como bloco de código. Todas as palavras em destaque devem estar envolvidas pela tag <strong>. Não crie um título para o resumo da aula e não use Markdown para formatar o texto. Conteúdo da aula: {$a->resource_content}';
$string['prompt:detailed_summary'] = 'Com base no seguinte conteúdo da aula intitulada "{$a->resource_name}", escreva um resumo detalhado de até 300 palavras, explicando os principais conceitos apresentados para um aluno de graduação. Inclua informações sobre teorias, métodos, exemplos práticos ou desafios apresentados, conforme aplicável. Não formate o texto como bloco de código. Utilize a tag <h5> para seções principais, a tag <p> para parágrafos e a tag <strong> para destacar termos importantes. Não crie um título para o resumo da aula e não use Markdown para formatar o texto. Conteúdo da aula: {$a->resource_content}';
