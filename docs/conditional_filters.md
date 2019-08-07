# Conditional Filtering 

(TBD)

## Condition Part

### Specify Value

```
Cond::is(0)
Cond::is('target_value')
```

### Type

```
Cond::isNull()
Cond::isEmpty()
```

### Closure

```
Cond::is(function($in) {
    return $in === 'target value',
})
```

### Anything

```
Cond::isAny()
```

### Contains

```
Cond::isContains()
```

### Regular Expression

```
Cond::isRegexp()
```

## Output Part

### Specify Value

```
Cond::isAny()->to(0)
Cond::isAny()->to('new string')
```

### Cast type

```
Cond::isAny()->toInt();
Cond::isAny()->toBoolean();
Cond::isAny()->toFloat();
Cond::isAny()->toString();
```

### Closure

```
Cond::isAny()->to(function($in) {
    return $in . ' suffix';
})
```

### Filter

```
Cond::isAny()->toFilter('trim')
Cond::isAny()->toFilter(new class implements FilterContract
{
    public function apply($input)
    {
        return $input . '-suffix';
    }
});
```