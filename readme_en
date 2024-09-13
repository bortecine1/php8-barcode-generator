# PHP 8.2 Barcode Generator Library

Easy to use, lightweight, flexible, framework-free barcode generation library for PHP 8+. Additional packages are available to convert the generated barcode to JPG or an image.



## Installation

To install the main package: [Composer](https://getcomposer.org/download/)

```composer
composer require bortecine1/php8-barcode-genarator
```

_If you want to create PNG or JPG images, you need to have the GD library installed on your system._


## Supported Barcode Types
The most commonly used types are C128 and C39 due to the length and most characters supported.

- C25 (2 of 5)
- C39
- C128
- Code 128 GS1
- Barcode
- Data Matrix (ECC 200)
- Data Matrix GS1
- QR (yakında)

## Usage
```php
define('BASE_DIR', dirname(__FILE__).'/');

$img = new C128a('1234567890', 200, 70);
$img->saveToPngFile(BASE_DIR . 'barcode_128a.png');
```
result :)

![image](https://github.com/user-attachments/assets/973d460f-c2bb-4b44-bc99-c997821059b3) (C128a)

![AAAA](https://github.com/user-attachments/assets/71ae3318-9571-436c-96f4-7ed5dd870e7d) (Data Matrix)

![c39](https://github.com/user-attachments/assets/6cc55f6e-f33c-49b0-a358-18c0386d75dd) (C39)

## License
MIT
