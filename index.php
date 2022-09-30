<?php
declare(strict_types =1);
/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */
define('ROOT' , __DIR__ . DIRECTORY_SEPARATOR);
define('MODELS_PATH' , ROOT .'Models'. DIRECTORY_SEPARATOR);
define('VIEWS_PATH', ROOT . 'Views' . DIRECTORY_SEPARATOR);

require_once MODELS_PATH . 'Diagnosis.php';
//var_dump(MODELS_PATH . 'Diagnosis.php');
require_once MODELS_PATH . 'Notes.php';
//var_dump(MODELS_PATH . 'Notes.php');
require_once VIEWS_PATH . 'DiagnosisForm.php';


?>
