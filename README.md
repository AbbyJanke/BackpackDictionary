# AbbyJanke/Dictionary

Allows you have a full dictionary with definitions, synonyms, and antonyms.

## Install

1. In your terminal:
```
composer require abbyjanke/backpackdictionary
```

2. Publish the config file & run migrations.
```
php artisan vendor:publish --provider="AbbyJanke\BackpackDictionary\DictionaryServiceProvider" #publish views and languages
php artisan migrate #create the necessary tables
```

3.[optional] Add a menu item for it in resources/views/vendor/backpack/base/inc/sidebar.blade.php:
```
<!-- AbbyJanke/Dictionary -->
<li><a href="{{ backpack_url('dictionary') }}"><i class="fa fa-book"></i> <span>@lang('backpack::dictionary.dictionary')</span></a></li>
```

## Security

If you discover any security related issues with this package, please email me@abbyjanke.com instead of using the issue tracker.
If you discover any security related issues with the Backpack core, please email hello@tabacitu.ro instead of using the issue tracker.
