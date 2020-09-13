# EzPubSub

[![Latest Version on Packagist](https://img.shields.io/packagist/v/ezpubsub/ezpubsub-php.svg?style=flat-square)](https://packagist.org/packages/ezpubsub/ezpubsub-php)
[![Total Downloads](https://img.shields.io/packagist/dt/ezpubsub/ezpubsub-php.svg?style=flat-square)](https://packagist.org/packages/ezpubsub/ezpubsub-php)

PHP library for EzPubSub

## Installation

You can install the package via composer:

```bash
composer require ezpubsub/ezpubsub-php
```

## EzPubSub Constructor
Use the credentials from your [EzPubSub Application](https://ezpubsub.com) to create a new EzPubSub\EzPubSub instance.
``` php
$app_id = 'YOUR_APP_ID';
$app_key = 'YOUR_APP_KEY';
$app_secret = 'YOUR_APP_SECRET';
$app_cluster = 'YOUR_APP_CLUSTER';

$ezpubsub = new EzPubSub\EzPubSub($app_id, $app_key, $app_secret, $app_cluster);
```

## Publishing/Triggering
To trigger one or more channels use ``trigger`` function.
#### A single channel
```php
$ezpubsub->trigger('channel', [
  'text' => 'Hello'
]);
```

#### Multiple channel
```php
$ezpubsub->trigger([ 'channel-1', 'channel-2 '], [
    'text' => 'Hello'
]);
```

## Batches
It's also possible to send multiple events with a single API call.
```php
$ezpubsub->triggerBatch([
    ['channel' => ['batch-multi-1', 'batch-multi-2'], 'data' => 'batch-multi-message'],
    ['channel' => 'batch-1', 'data' => 'batch-message-1'],
    ['channel' => 'batch-2', 'data' => 'batch-message-2']
]);
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email nyinyilwin1992@hotmail.com instead of using the issue tracker.

## Credits

- All Contributors

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
