# PHP Normalizer

(TODO)

## Features

### Single Normalize

```php
$input   = '   hoge  fuga ';
$filters = ['trim', 'empty_to_null'];

$result = Normalizer::normalize($input, $filters);

// $result is...
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

// $result is...
// [
//   'name'   => 'hoge  fuga',
//   'age'    => 20,
//   'gender' => null,
// ]
```

#### Nested Array

```php
$n = new Normalizer([
    'users.*.name'   => ['trim', 'empty_to_null'],
    'users.*.age'    => ['trim', 'empty_to_null', 'integer'],
]);

$result = $n->normalize([
    'users' => [
        [
            'name'   => '    hoge  fuga ',
            'age'    => ' 20 ',
        ],
        [
            'name'   => '',
            'age'    => ' 20 ',
        ],
    ]
);

// $result is...
// [
//   'users' => [
//     [
//         'name'   => 'hoge  fuga',
//         'age'    => 20,
//     ],
//     [
//         'name'   => null,
//         'age'    => 20,
//     ],
//   ]
// ]
```

### Conditional Filtering 

(TBD)

```php
use ...\Condition as Cond;
Cond::is(0)->to(1);
Cond::is(null)->to(1);
Cond::isEmpty()->to(null);
Cond::toInt();
Cond::isNotNull()->toInt();
Cond::isEmpty()->to(new CustomFilter());
```

```php
$n = new Normalizer([
    'name'   => ['trim', Cond::isEmpty()->toNull()],
    'age'    => ['trim', Cond::isEmpty()->toNull(), Cond::isNotEmpty()->toInt()],
    'gender' => ['trim', Cond::isEmpty()->toNull(), Cond::isNotEmpty()->toInt()],
]);

$result = $n->normalize([
    'name'   => '    hoge  fuga ',
    'age'    => ' 20 ',
]);

// $result is...
// [
//   'name'   => 'hoge  fuga',
//   'age'    => 20,
//   'gender' => null,
// ]
```

### Add Custom Filter

```php
```