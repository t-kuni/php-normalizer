<?php

$input = '   hoge  fuga ';
$rule  = ['trim', 'empty_to_null'];

$result = Normalizer::normalize($input, $rule);

var_dump($result);
// 'hoge  fuga'

$n = new Normalizer([
    'name'   => ['trim', 'empty_to_null'],
    'age'    => ['trim', 'empty_to_null', 'integer'],
    'gender' => ['trim', 'empty_to_null', 'integer'],
]);

$normalized = $n->normalize([
    'name'   => '    hoge  fuga ',
    'age'    => ' 20 ',
]);

var_dump($result);
// [
//   'name'   => 'hoge  fuga',
//   'age'    => 20,
//   'gender' => null,
// ]

// Advanced Filters

Filter::map([
    '1' => 'male',
    '2' => 'female',
]);
Filter::substitute('aaa', 'bbb');

// Add Filter

// Filter Set
Normalizer::STRING;
Normalizer::INTEGER;


var_dump($normalized);