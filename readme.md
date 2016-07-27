#Auditor [![Latest Stable Version](https://poser.pugx.org/midnite81/auditor/version)](https://packagist.org/packages/midnite81/auditor) [![Total Downloads](https://poser.pugx.org/midnite81/auditor/downloads)](https://packagist.org/packages/midnite81/auditor) [![Latest Unstable Version](https://poser.pugx.org/midnite81/auditor/v/unstable)](https://packagist.org/packages/midnite81/auditor) [![License](https://poser.pugx.org/midnite81/auditor/license.svg)](https://packagist.org/packages/midnite/auditor)

Auditor is a PHP package to retrieve audit json data from Laravel 5 and present it in table format.

**Please note this is a work in progress.**

#Installation

This package requires PHP 5.6+, and includes a Laravel 5 Service Provider.

To install through composer include the package in your `composer.json`.

    "midnite81/auditor": "0.0.*"

Run `composer install` or `composer update` to download the dependencies or you can run `composer require midnite81/auditor`.

##Laravel 5 Integration

To use the package with Laravel 5 firstly add the Auditor service provider to the list of service providers 
in `app/config/app.php`.

    'providers' => [

      Midnite81\Auditor\AuditorServiceProvider::class
              
    ];

#Basic Usage

**Please note this is a work in progress package. Documentation is not yet complete.**

    use Midnite81\Auditor\Contracts\Auditor;

    public function index(Auditor $auditor)
    {

        $data = MyModel::orderBy('created_at', desc')->get(['data']);

        $auditTable = $auditor->setData($data)->sort(['UserId', 'Priorty'])->render();

        return view('some.view', ['auditTable' => $auditTable]);

    }