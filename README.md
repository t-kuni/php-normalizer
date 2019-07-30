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

#### Flat Array

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

#### Nested Array

(TBD)

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

(TBD)

```php
Filter::is(0)->to(1);
Filter::is(null)->to(1);
Filter::isEmpty()->to(null);
Filter::toInt();
Filter::isNotNull()->toInt();
Filter::isEmpty()->to(new CustomFilter());
```

### Add Filter

```php
```