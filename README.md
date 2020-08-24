# Certificate
 Get information about the secure connection certificate for a domain

## Install
```bash
composer require manzadey/certificate
```

## Usage

Create class `Certificate`:
```php
use Manzadey\Certificate\Certificate;

$info = new Certificate('google.com');
```

Get all info about certificate:
```php
$info->all(); // array
```

Issuer:
```php
$info->issuer(); // Google Trust Services
```

Domain:
```php
$info->domain(); // ssl://google.com:443
```

Valid From:
```php
$info->validFrom(); // 11.08.2020 11:53:40
```

Valid To:
```php
$info->validTo(); // 03.11.2020 11:53:40
```

Experation date:
```php
$info->experationDate(); // 84
```

Expires date
```php
$info->expiresDate(); // 70
```
