SugarCRM
========

REST client for SugarCRM, based on PHP.

PHP version >= 5.3 is required.

Where clause
------------

Searching records using `array` or `string` method.

```php
Contact::where(array('last_name' => 'Tibbs'))->fetch();
```

Returns `Contact` object where name is *Tibbs*.

```php
Account::where(array('name' => "LIKE 'Q%'"))->fetchAll();
```

Returns collection of `Account` objects, using for search `LIKE` clause. Its also possible using `IN` clause in the query:

```php
Account::where(array('name' => "IN ('Airline Maintenance Co', 'Air Safety Inc')"))->fetchAll();
```

Also possible is use a `string` as query:

```php
Contact::where("contacts.last_name = 'Tibbs'")->fetch();
```

***

Dynamic searching
-----------------

SugarClient allows to create dynamic method with column name in name:

```php
Account::findByName('Airline Maintenance Co')->fetch();
```

Return account name where `name` is equal to passed argument.

You can dynamically search using `find` prefix in static method and defining multiple columns e.g.:

```php
Account::findByShippingAddressPostalcodeAndName('60135', 'Airline Maintenance Co')->fetch();
```

Camel-case is **required**, column joiner is `And`. Parameters are fetching in vararg style, order of parameters are matching to column defined in the method name.

***

Working with objects
--------------------

When you fetch object you can access to their properties using dynamic fields:

```php
$contacpt = Contact::where(array('last_name' => 'Tibbs'))->fetch();

$contact->first_name;
$contact->last_name;
```

***

Joining modules
---------------

You can join for module related modules. This relations are save in module classes which are in namespace `\SugarClient\Module`. Relations types: 

* `belongsTo` - return module
* `hasMany` - return collection of modules

```php
$contact = Contact::where(array('last_name' => 'Tibbs'))->join('account')->fetch();
```

Returns `Contact` module with joined `Account` module. Access to related account is:

```php
$account = $contact->account;
```
