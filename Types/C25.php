<?php

declare(strict_types=1);

namespace Barcode\Types;

use Barcode\BarcodeGenerator;

/**
 * C25 - Standard 2 of 5.
 */
class C25 extends BarcodeGenerator
{
    protected static array $CONVERSION_TABLE = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '0'];
    protected static array $CONVERSION_TABLE2 = [
        '3-1-1-1-3', '1-3-1-1-3', '3-3-1-1-1', '1-1-3-1-3', '3-1-3-1-1',
        '1-3-3-1-1', '1-1-1-3-3', '3-1-1-3-1', '1-3-1-3-1', '1-1-3-3-1',
    ];

    protected static string $CODE_START = '1111';
    protected static string $CODE_END   = '311';

    /**
     * Şifrelenecek içeriği ayarlar.
     * Set content to encrypt.
     */
    public function setContent(string $content): void
    {
        if (!\ctype_digit($content)) {
            throw new \InvalidArgumentException($content);
        }

        parent::setContent($content);
    }

    /**
     * C25 standartında kod dizesi oluşturur.
     * Generates code string in C25 standard.
     */
    protected function generateCodeString(): string
    {
        $codeStr     = '';
        $length      = \strlen($this->content);
        $arrayLength = \count(self::$CONVERSION_TABLE);
        $temp        = [];

        for ($posX = 1; $posX <= $length; ++$posX) {
            for ($posY = 0; $posY < $arrayLength; ++$posY) {
                if (\substr($this->content, ($posX - 1), 1) === self::$CONVERSION_TABLE[$posY]) {
                    $temp[$posX] = self::$CONVERSION_TABLE2[$posY];
                }
            }
        }

        for ($posX = 1; $posX <= $length; $posX += 2) {
            if (isset($temp[$posX], $temp[($posX + 1)])) {
                $temp1 = \explode('-', $temp[$posX]);
                $temp2 = \explode('-', $temp[($posX + 1)]);
                $count = \count($temp1);

                for ($posY = 0; $posY < $count; ++$posY) {
                    $codeStr .= $temp1[$posY] . $temp2[$posY];
                }
            }
        }

        return $codeStr;
    }
}