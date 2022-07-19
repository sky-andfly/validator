# Simple validator

## Connection
___
Connect `Validator.php` your project:
```php
require_once "Validator.php";
```
Before creating an object, you need to prepare data in the form of an array:
```php
$data = [
'name' => 'Sergey',
'email' => 'test@test.ru',
'phone' => '+79888111111',
'password' => '1password',
'password_confirm' => '1password',
'date' => '2052-02-02'
];
```
Create a class object:
```php
$val = new Validator($data);
```

## Customization
____
You can change some class settings:
1. Set `PASSWORD_LEN` to the minimum length of the required password;
2. Set `NumberInPassword` to `true` if your password must have at least one digit, otherwise `false`;
3. Set the `DATE_SEPARATOR` separator to be used in the date;
4. Add new regular expressions in the `phone` method to check for new phone numbers.

```php
    const PASSWORD_LEN = 8;
    const NumberInPassword = true;
    const DATE_SEPARATOR = '-';
    
    $regulars = [
            'rus' => '/^(\+7|7|8)?[\s\-]?\(?[489][0-9]{2}\)?[\s\-]?[0-9]{3}[\s\-]?[0-9]{2}[\s\-]?[0-9]{2}$/',
            'usa' => '/^(\([0-9]{3}\) |[0-9]{3}-)[0-9]{3}-[0-9]{4}$/',
            'kz' => '/^\+?77(\d{9})$/',
    ];
```
## Using
____
To validate field you must enter field name in method field, and then call needed methods to validate:
```php
$val->getField('data')
                       ->phone('usa');//rus, usa, kz
                       ->email();
                       ->checkPassword()
                       ->repeatPassword('password_confirm');
                       ->date();
                       ->notEmpty();
$val->validity();
$val->displayErrors();
```
## Example
___
```php
<?php
require_once "Validator.php";
$data = [
    'name' => 'Sergey',
    'email' => 'test@test.ru',
    'phone' => '+79888111111',
    'password' => '1password',
    'password_confirm' => '1password',
    'date' => '2052/02/02'
];
$val = new Validator($data);

$val->getField('phone')->phone('rus');
$val->getField('email')->email();
$val->getField('password')->checkPassword()->repeatPassword('password_confirm');
$val->getField('date')->date();
$val->getField('name')->notEmpty();
var_dump($val->validity());
$val->displayErrors();
?>

```
