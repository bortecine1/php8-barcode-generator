<?php

declare(strict_types = 1);

namespace Barcode;

use Barcode\Types\OrientationType;

/**
 * @author Selman Kocahal
 * @license MIT License
 */
abstract class BarcodeGenerator extends BarcodeAbstract
{
    protected static int $CHECKSUM           = 0;
    protected static array $CONVERSION_TABLE = [];
    protected static string $CODE_START      = '';
    protected static string $CODE_END        = '';

    /**
     * Barkodun altındaki metni gösterir.
     * Show text below barcode
     */
    protected bool $showText = true;

    public function get(): ?\GdImage
    {
        $codeString = static::$CODE_START . $this->generateCodeString() . static::$CODE_END;
        return $this->createImage($codeString);
    }

    /**
     * Barkod dizesini doğrular.
     * Validate the barcode string.
     */
    public static function isValidString(string $barcode): bool
    {
        $length = \strlen($barcode);

        for ($i = 0; $i < $length; ++$i) {
            if (!isset(static::$CONVERSION_TABLE[$barcode[$i]]) && !\in_array($barcode[$i], static::$CONVERSION_TABLE)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Bir kod dizesi oluşturur.
     * A generate code string.
     */
    protected function generateCodeString(): string
    {
        if ($this->codestring === '') {
            $keys     = \array_keys(static::$CONVERSION_TABLE);
            $values   = \array_flip($keys);
            $length   = \strlen($this->content);
            $checksum = static::$CHECKSUM;

            for ($pos = 1; $pos <= $length; ++$pos) {
                $activeKey         = \substr($this->content, ($pos - 1), 1);
                $this->codestring .= static::$CONVERSION_TABLE[$activeKey];
                $checksum         += $values[$activeKey] * $pos;
            }

            $this->codestring .= static::$CONVERSION_TABLE[$keys[($checksum - ((int) ($checksum / 103) * 103))]];
        }

        return $this->codestring;
    }

    /**
     * Barkod görüntüsü oluşturur.
     * Create barcode image.
     */
    protected function createImage(string $codeString): \GdImage
    {
        $dimensions = $this->calculateDimensions($codeString);
        $image      = \imagecreate($dimensions['width'], $dimensions['height']);

        if ($image === false) {
            throw new \Exception();
        }

        $black = \imagecolorallocate($image, 0, 0, 0);
        $white = \imagecolorallocate($image, 255, 255, 255);

        if ($white === false || $black === false) {
            throw new \Exception();
        }

        \imagefill($image, 0, 0, $white);

        $location = 0;
        $length   = \strlen($codeString);

        for ($position = 1; $position <= $length; ++$position) {
            $cur_size = $location + (int) (\substr($codeString, ($position - 1), 1));

            if ($this->orientation === OrientationType::HORIZONTAL) {
                \imagefilledrectangle(
                    $image,
                    $location + $this->margin,
                    0 + $this->margin,
                    $cur_size + $this->margin,
                    $dimensions['height'] - $this->margin - 1,
                    ($position % 2 === 0 ? $white : $black)
                );
            } else {
                \imagefilledrectangle(
                    $image,
                    0 + $this->margin,
                    $location + $this->margin,
                    $dimensions['width'] - $this->margin - 1,
                    $cur_size + $this->margin,
                    ($position % 2 === 0 ? $white : $black)
                );
            }

            $location = $cur_size;
        }

        return $image;
    }

    /**
     * Görüntü boyutu için kod uzunluğunu hesaplar.
     * Calculate the code length for image dimensions.
     */
    private function calculateCodeLength(string $codeString): int
    {
        $codeLength = 0;
        $length     = \strlen($codeString);

        for ($i = 1; $i <= $length; ++$i) {
            $codeLength += (int) (\substr($codeString, ($i - 1), 1));
        }

        return $codeLength;
    }

    /**
     * Kod boyutlarını hesaplar.
     * Calculate the code dimensions.
     */
    private function calculateDimensions(string $codeString): array
    {
        $codeLength = $this->calculateCodeLength($codeString);
        $dimensions = ['width' => 0, 'height' => 0];

        if ($this->orientation === OrientationType::HORIZONTAL) {
            $dimensions['width']  = $codeLength + $this->margin * 2 + 1;
            $dimensions['height'] = $this->dimension['height'];
        } else {
            $dimensions['width']  = $this->dimension['width'];
            $dimensions['height'] = $codeLength + $this->margin * 2 + 1;
        }

        return $dimensions;
    }
}