SugarCRM
========

REST client for SugarCRM, based on PHP.

PHP version >= 5.3 is required.

Establish a connection
----------------------
```php
Session::connect('http://link/to/your/sugarcrm/service/v4_1/rest.php', 'login', 'password');
```

***

Where clause
------------
To search records use `where` method with `array` or `string` parameter.

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

*Remember to add a correct table alias.*

This method can be chained with other `where` methods:

```php
Contact::where(array('last_name' => 'Tibbs'))
            ->where(array('first_name' => 'John'))
            ->fetch();
```

***

Dynamic searching
-----------------
SugarClient allows to create a dynamic method with column name in the method definition:

```php
Account::findByName('Airline Maintenance Co')->fetch();
```

Return account name where `name` is equal to passed argument.

You can dynamically search using `findBy` prefix in static method and defining multiple columns e.g.:

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
You can select fields to be returned in the result. By default return all fields.

```php
$account = Account::where(array('name' => "LIKE 'Airline%'"))->select('name', 'phone_office')->fetch();
```

Now available fields are only `name` and `phone_office`.

***

Counting records
----------------
You can return count of the records using `count` method. 

```php
$count = Account::count(array('name' => "LIKE 'Air%'"));
```

If you not pass where clause to the `count` method then will be returned the number of all records in the module.

***

Working with objects
--------------------
When you fetch object you can access to their properties using dynamic fields:

```php
$contact = Contact::where(array('last_name' => 'Tibbs'))->fetch();

$contact->first_name;
$contact->last_name;
```

To create new record use `insert` method:

```php
$contact = new Contact();
$contact->first_name = 'John';
$contact->last_name = 'Doe';
$contact->insert();
```

`insert` method returns id new created record.

To update record use `update` method:

```php
$contact = Contact::where(array('last_name' => 'Doe'))->fetch();
$contact->first_name = 'Brad';
$contact->last_name = 'Smith';
$contact->update();
```

To delete record use `delete` method:

```php
Contact::where(array('last_name' => 'Doe'))->delete();
```

Returns `true` if correctly deleted or `false` on failure.

To set relation between objects use `relatedWith` method.

```php
$account = new Account();
$account->name = 'New Company';
$account->insert();

$contact = new Contact();
$contact->first_name = 'John';
$contact->last_name = 'Doe';
$contact->insert();

$account->relatedWith($contact);
```

You can reload module attributes using method `reload`.

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
$contact = Contact::where(array('last_name' => 'Tibbs'))
                    ->join('account', array('id', 'name'))
                    ->fetch();
```

This code result that in `Account` module will be avaiable only fields: `id` and `name`.

***

Joining modules through other relation
--------------------------------------
Sometimes you want to get relations through other relation. You can do this using `->` sparator in a `join` method.

```php
$contact = Contact::where(array('last_name' => 'Tibbs'))
            ->join('account->leads')
            ->fetch();
```

***

Handling files
--------------
To upload `Document` file create object, and use `uploadFile` method.

```php
$document = new Document(array(
    'document_name' => 'new document test',
    'revision' => '1'
));
$document->insert();
$content = file_get_contents(Path::join('path', 'to', 'your', 'file_name.txt'));
$fileName = 'file_name.txt';

$document->uploadFile($content, $fileName);
```

To retrive last file for document use `getFile` method.

```php
$document->getFile();
```

This method return `File` object where you can save file using `saveTo` method.

```php
$file = $document->getFile();
$file->saveTo(Path::join('destination', 'path', $file->getFileName()));
```
