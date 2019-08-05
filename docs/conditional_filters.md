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

#### example

```php
$n = new Normalizer([
    'name'   => ['trim', Cond::is('foo')->to('bar')],
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