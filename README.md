# PHP 8.2 Barkod Oluşturma Kütüphanesi

If your language is English, please [click here](https://github.com/bortecine1/php8-barcode-generator/blob/main/readme_en.md)

PHP 8+ için kullanımı kolay, hafif, esnek, çerçeveden uzak barkod oluşturma kütüphanesi. Oluşturulan barkodu JPG'ye veya bir resme dönüştürmek için ek paketler mevcuttur.



## Kurulum

Ana paketi yüklemek için: [Composer](https://getcomposer.org/download/)

```composer
composer require bortecine1/php8-barcode-genarator
```

_PNG veya JPG görüntüleri oluşturmak istiyorsanız, sisteminizde GD kütüphanesinin yüklü olması gerekir._


## Desteklenen Barkod Türleri
Uzunluk ve desteklenen çoğu karakter nedeniyle en çok kullanılan tür C128 ve C39'dur.

- C25 (2 of 5)
- C39
- C128
- Code 128 GS1
- Barcode
- Data Matrix (ECC 200)
- Data Matrix GS1
- QR (yakında)

## Kullanım
```php
define('BASE_DIR', dirname(__FILE__).'/');

$img = new C128a('1234567890', 200, 70);
$img->saveToPngFile(BASE_DIR . 'barcode_128a.png');
```
ve sonuç:

![image](https://github.com/user-attachments/assets/973d460f-c2bb-4b44-bc99-c997821059b3) (C128a)

![AAAA](https://github.com/user-attachments/assets/71ae3318-9571-436c-96f4-7ed5dd870e7d) (Data Matrix)

![c39](https://github.com/user-attachments/assets/6cc55f6e-f33c-49b0-a358-18c0386d75dd) (C39)

## Lisans
MIT
