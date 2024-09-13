<?php

declare(strict_types=1);

namespace Barcode;

class Barcoder extends BarcodeGenerator
{
    protected static array $CONVERSION_TABLE = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '0', '-', '$', ':', '/', '.', '+', 'A', 'B', 'C', 'D'];
    protected static array $CONVERSION_TABLE2 = [
        '1111221', '1112112', '2211111', '1121121', '2111121', '1211112', '1211211', '1221111', '2112111', '1111122',
        '1112211', '1122111', '2111212', '2121112', '2121211', '1121212', '1122121', '1212112', '1112122', '1112221',
    ];

    protected static string $CODE_START = '11221211';
    protected static string $CODE_END   = '1122121';

    /**
     * Şifrelenecek içeriği ayarlar. 
     * Set content to encrypt.
     */
    public function setContent(string $content): void
    {
        parent::setContent(\strtoupper($content));
    }

    /**
     * Bir kod dizesi oluştur.
     * A generate code string
     */
    protected function generateCodeString(): string
    {
        $codeString = '';
        $length     = \strlen($this->content);
        $codeLength = \count(self::$CONVERSION_TABLE);

        for ($posX = 1; $posX <= $length; ++$posX) {
            for ($posY = 0; $posY < $codeLength; ++$posY) {
                if (\substr($this->content, ($posX - 1), 1) === self::$CONVERSION_TABLE[$posY]) {
                    $codeString .= self::$CONVERSION_TABLE2[$posY] . '1';
                }
            }
        }

        return $codeString;
    }
}