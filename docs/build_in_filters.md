# Filters

## Trimming

```php
$n = new Normalizer([
    'name'   => ['trim', 'empty_to_null'],
    'age'    => ['trim', 'empty_to_null', 'integer'],
    'gender' => ['trim', 'empty_to_null', 'integer'],
]);

* empty_to_null
* integer
* boolean
* float
* string

# memo

https://laravel.com/docs/5.8/helpers
https://book.cakephp.org/3.0/ja/core-libraries/inflector.html