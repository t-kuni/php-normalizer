# PHP Normalizer

(TODO)

## Features

### Single Normalize

```php
$input  = '   hoge  fuga ';
$filters   = ['trim', 'empty_to_null'];

$result = Normalizer::normalize($input, $filters);

var_dump($result);
// 'hoge  fuga'
```

### Multiple Normalize

Flat Array

```php
$n = new Normalizer([
    'name'   => ['trim', 'empty_to_null'],
    'age'    => ['trim', 'empty_to_null', 'integer'],
    'gender' => ['trim', 'empty_to_null', 'integer'],
]);

$result = $n->normalize([
    'name'   => '    hoge  fuga ',
    'age'    => ' 20 ',
]);

var_dump($result);
// [
//   'name'   => 'hoge  fuga',
//   'age'    => 20,
//   'gender' => null,
// ]
```

Nested Array

```php
$n = new Normalizer([
    'users.*.name'   => ['trim', 'empty_to_null'],
    'users.*.age'    => ['trim', 'empty_to_null', 'integer'],
]);

$result = $n->normalize([
    [
        'name'   => '    hoge  fuga ',
        'age'    => ' 20 ',
    ],
    [
        'name'   => '',
        'age'    => ' 20 ',
    ],
);

var_dump($result);
// [
//     [
//         'name'   => 'hoge  fuga',
//         'age'    => 20,
//     ],
//     [
//         'name'   => null,
//         'age'    => 20,
//     ],
// ]
```

### Advanced Filters 

```php
```

### Add Filter

```php
```