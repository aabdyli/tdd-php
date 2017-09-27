<?php

$finder = PhpCsFixer\Finder::create()
    ->notPath('bootstrap/cache')
    ->notPath('storage')
    ->notPath('vendor')
    ->in(__DIR__)
    ->name('*.php')
    ->notName('*.blade.php')
    ->notName('.phpstorm.meta.php')
    ->notName('_ide_helper.php')
    ->notName('_ide_helper_models.php')
    ->notName('server.php')
    ->notPath('public/index.php')
    ->ignoreDotFiles(true)
    ->ignoreVCS(true);

return PhpCsFixer\Config::create()
    ->setRules([
        '@PSR2' => true,
        'array_syntax' => ['syntax' => 'short'],
        'whitespace_after_comma_in_array' => true,
        'blank_line_after_opening_tag' => true,
        'blank_line_before_statement' => [
            'statements' => ['break', 'continue', 'declare', 'return', 'throw', 'try']
        ],
        'hash_to_slash_comment' => true,
        'method_separation' => true,
        'no_whitespace_in_blank_line' => true,
        'not_operator_with_space' => true,
        'object_operator_without_whitespace' => true,
        'no_unused_imports' => true,
        'ordered_imports' => ['sortAlgorithm' => 'length'],
        'phpdoc_indent' => true,
        'phpdoc_order' => true,
        'phpdoc_return_self_reference' => true,
        'phpdoc_summary' => true,
        'phpdoc_to_comment' => true,
        'short_scalar_cast' => true,
        'semicolon_after_instruction' => true,
        'cast_spaces' => true,
        'single_blank_line_before_namespace' => true,
        'trailing_comma_in_multiline_array' => true,
        'phpdoc_no_package' => true,
        'phpdoc_var_without_name' => true,
        'phpdoc_scalar' => true,
        'general_phpdoc_annotation_remove' => [
            'annotations' => ["author", "package"]
        ],
    ])
    ->setFinder($finder)
    ->setUsingCache(false)
    ;
