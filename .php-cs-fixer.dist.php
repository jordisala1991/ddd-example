<?php

$finder = (new PhpCsFixer\Finder())
    ->in(__DIR__)
    ->exclude('var')
;

return (new PhpCsFixer\Config())
    ->setRules([
        '@Symfony' => true,
        '@Symfony:risky' => true,
        'array_syntax' => ['syntax' => 'short'],
        'combine_consecutive_issets' => true,
        'combine_consecutive_unsets' => true,
        'concat_space' => ['spacing' => 'none'],
        'header_comment' => ['header' => "\n"],
        'declare_strict_types' => true,
        'no_extra_blank_lines' => true,
        'no_php4_constructor' => true,
        'no_useless_else' => true,
        'no_useless_return' => true,
        'ordered_class_elements' => true,
        'ordered_imports' => true,
        'phpdoc_align' => ['align' => 'left'],
        'phpdoc_line_span' => [
            'const' => 'multi',
            'property' => 'multi',
            'method' => 'multi',
        ],
        'phpdoc_order' => true,
        'compact_nullable_typehint' => true,
        'void_return' => false,
        'strict_comparison' => true,
        'strict_param' => true,
        'php_unit_strict' => true,
    ])
    ->setRiskyAllowed(true)
    ->setFinder($finder)
;
