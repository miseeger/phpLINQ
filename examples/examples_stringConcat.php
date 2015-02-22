<?php

//  LICENSE: GPL 3 - https://www.gnu.org/licenses/gpl-3.0.txt
//  
//  s. https://github.com/mkloubert/phpLINQ


require_once './bootstrap.inc.php';


$pageTitle = 'stringConcat()';

// example #1
$examples[] = new Example();
$examples[0]->title = 'Default behavior';
$examples[0]->sourceCode = 'use \\System\\Linq\\Enumerable;

$seq = Enumerable::fromValues(1, 2, 3, 4, 5);

echo $seq->stringConcat();
';

// example #2
$examples[] = new Example();
$examples[1]->title = 'Custom selector';
$examples[1]->sourceCode = 'use \\System\\Linq\\Enumerable;

$mySelector = function($item) {
    return strtolower($item);
};
        
$seq = Enumerable::fromValues("TM", "MK", "YS", "Js");

echo $seq->stringConcat($mySelector);
';


require_once './shutdown.inc.php';