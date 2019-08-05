[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/t-kuni/php-normalizer/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/t-kuni/php-normalizer/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/t-kuni/php-normalizer/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/t-kuni/php-normalizer/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/t-kuni/php-normalizer/badges/build.png?b=master)](https://scrutinizer-ci.com/g/t-kuni/php-normalizer/build-status/master)
[![Code Intelligence Status](https://scrutinizer-ci.com/g/t-kuni/php-normalizer/badges/code-intelligence.svg?b=master)](https://scrutinizer-ci.com/code-intelligence)

# PHP Normalizer

In development...

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

[More details](docs/build_in_filters.md)

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

[More details](docs/conditional_filters.md)

### Add Custom Filter

```php
$customFilter = new class implements FilterContract
{
    public function apply($input)
    {
        return $input . '-suffix';
    }
}

Container::container()->get(FilterProviderContract::class)
    ->addFilter('custom_filter_name', $customFilter);

$n = new Normalizer([
    'users.*.name' => ['trim', 'custom_filter_name'],
]);

$result = $n->normalize([
    'users' => [
        [
            'name' => 'john',
        ],
        [
            'name' => 'eric',
        ],
    ]
]);

// $result is...
// [
//     'users' => [
//         [
//             'name' => 'john-suffix',
//         ],
//         [
//             'name' => 'eric-suffix',
//         ],
//     ]
// ]
```
