# Hitta.se PHP package

[![Latest Version on Packagist](https://img.shields.io/packagist/v/grafstorm/hitta_php_package.svg?style=flat-square)](https://packagist.org/packages/grafstorm/hitta_php_package)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/grafstorm/hitta_php_package/run-tests?label=tests)](https://github.com/grafstorm/hitta_php_package/actions?query=workflow%3ATests+branch%3Amaster)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/grafstorm/hitta_php_package/Check%20&%20fix%20styling?label=code%20style)](https://github.com/grafstorm/hitta_php_package/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amaster)
[![Total Downloads](https://img.shields.io/packagist/dt/grafstorm/hitta_php_package.svg?style=flat-square)](https://packagist.org/packages/grafstorm/hitta_php_package)

---
**Package under development**  
Fluent Wrapper around the API Hitta.se provides.
Example of usage:
```php
$hitta = new Hitta('::api-user::', '::api-key::');
$result = $hitta->companies()
    ->what('Empire')
    ->where('Deathstar')
    ->find();

foreach($result->companies as $company) {
    echo $company->displayName . "\n";
}
```

## Requirements
PHP 8 is required.

## Installation

You can install the package via composer:

```bash
composer require grafstorm/hitta_php_package
```

## Usage

```php
// Hitta.se API Wrapper as a Laravel Package
// Search for Swedish companies and people

// Create a new instance of the API wrapper.
$hitta = new Hitta('::api-user::', '::api-key::');

// Combined search. You can also explicitly call Hitta::combined()
$hitta->what('Luke Skywalker')
  ->where('Kiruna')
  ->find();
  
$result = $hitta->combined()
  ->what('Empire')
  ->where('Deathstar')
  ->find();

foreach($result->companies as $company) {
  echo $company->displayName . "\n";
}

foreach($result->people as $person) {
  echo $person->displayName . "\n";
}

// Only Search for people
$hitta->people()
  ->what('Luke Skywalker')
  ->find();
  
// Only Search for companies
$hitta->companies()
  ->what('Empire')
  ->find();
  
// Optional search parameters
$hitta->companies()
  ->what('Luke Skywalker')
  ->where('Kiruna')
  ->pageNumber(1)
  ->pageSize(10)
  ->rangeFrom(100)
  ->rangeTo(150)
  ->find();

// Example of Fetching details of a company or person with findPerson and findCompany.
$result = $hitta->combined()
  ->what('Skywalker')
  ->find();
  
$personId = collect($result->people)->first()->id;
$companyId = collect($result->companies)->first()->id;

$hitta->findPerson($personId);
$hitta->findCompany($companyId);
```

## Testing
Tests requiring proper API keys are skipped unless you provide them in your testing environment.
```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [grafi](https://github.com/argia-andreas)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
