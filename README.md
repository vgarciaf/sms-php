[![Build Status](https://img.shields.io/travis/descom-es/php-sms/master.svg?style=flat-square)](https://travis-ci.org/descom-es/php-sms)
[![StyleCI](https://styleci.io/repos/103265304/shield)](https://styleci.io/repos/103265304)
[![Latest Stable Version](https://poser.pugx.org/descom/php-sms/version?format=flat-square)](https://packagist.org/packages/descom/php-sms)
[![Total Downloads](https://poser.pugx.org/descom/php-sms/downloads?format=flat-square)](https://packagist.org/packages/descom/php-sms)
[![Latest Unstable Version](https://poser.pugx.org/descom/php-sms/v/unstable?format=flat-square)](//packagist.org/packages/descom/php-sms)
[![License](https://poser.pugx.org/descom/php-sms/license?format=flat-square)](https://packagist.org/packages/descom/php-sms)
# PHP SMS sending

SMS Library for sending text messages to mobile numbers worldwide from your own application via [Descom SMS](https://www.descomsms.com) gateway.

Create your free account at [Descom SMS](https://www.descomsms.com) and buy credits for SMS sending when required.

Our [API documentation](https://api.descomsms.com) is available [here](https://api.descomsms.com). Also, we will be happy to assist you at soporte@descom.es for further info on your SMS project.  

## Installation

You can install it with composer:

```bash
composer require descom/php-sms
```

## Usage


### Send single SMS

This is an example:

```php
$sms = new Sms(new AuthUser('your_username', 'your_password'));

$message = new Message();

$message->addDestintation('mobile_number')->setText('message_text');

$result = $sms->addMessage($message)
        ->setDryrun(true)
        ->send();
```

#### Send multiple SMS
You can send multiple SMS in one go, function `addDestintation`:


```php
//...

$message->addDestintation('mobile_number_1')
        ->addDestintation('mobile_number_2');

/...
```

or with an Array:

```php
//...

$message->addDestintation([
    'replace_by_number_mobile1',
    'replace_by_number_mobile2'
]);
/...
```

### Get balance of your account

You need balance to send SMS, perhaps you wish know your current balance. For this
case you have a function `getBalance`. See this example:

```php
$sms = new Sms(new AuthUser('replace_by_your_usernme', 'replace_by_your_password'));

$balance = $sms->getBalance();

echo 'Your balance is '.$balance."\n";
```


#### Define de sender of message

You can set de sender of message with the function `setSender` in the
class `Descom\Sms\Sms`

```php
$sms->setSender('replace_by_sender_of_message');
```
Your sender must be register in the platform.

#### Dryrun the send

If you can testing you can use this function `setDryrun` in the class `Descom\Sms\Sms` and set to `true`

```php
$sms->setDryrun(true);
```


## Examples

You can see folder examples for use.
