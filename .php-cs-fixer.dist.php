<?php

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__.'/')
;

return (new PhpCsFixer\Config())
    ->setRules([
        '@PhpCsFixer' => true,
        '@Symfony' => true,
    ])
    ->setFinder($finder)
    ->setCacheFile('.php-cs-fixer.cache')
;
