<?php
$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__)
    ->exclude('.github')
    ->exclude('bin')
    ->exclude('reports')
    ->exclude('var')
    ->exclude('vendor')
    ->exclude('web')
;


$config = new PhpCsFixer\Config();
return $config->setRules([
    '@Symfony' => true,
    '@PSR2' => true,
    'ordered_imports' => true,
    'array_syntax' => ['syntax' => 'short'],
])
    ->setFinder($finder)
    ;