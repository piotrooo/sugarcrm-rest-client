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

This method can be chained with other `where` methods:

```php
Contact::where(array('last_name' => 'Tibbs'))
            ->where(array('first_name' => 'John'))
            ->fetch();
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

This method can be chained with `where` methods:

```php
Contact::findByLastName('Tibbs')
            ->where(array('first_name' => 'John'))
            ->fetch();
```

***

Selecting fields
----------------

You can select fields to be returned in result. By default return all fields.

```php
$account = Account::where(array('name' => "LIKE 'Airline%'"))->select('name', 'phone_office')->fetch();
```

Now available fields are only `name` and `phone_office`.

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
$accountName = $contact->account->name;
```

If you want to specify fields which are returned by the `join` method you can pass array whit this fields as second parameter.

```php
$contact = Contact::where(array('last_name' => 'Tibbs'))->join('account', array('id', 'name'))->fetch();
```

This code result that in `Account` module will be avaiable only fields: `id` and 'name`.

***

Joining modules through other relation
--------------------------------------

Sometimes you want to get relations through other relation. You can do this using `->` sparator in a `join` method.

```php
$contact = Contact::where(array('last_name' => 'Tibbs'))
            ->join('account->leads')
            ->fetch();
```
