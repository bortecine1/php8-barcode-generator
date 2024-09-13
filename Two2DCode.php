<?php

declare(strict_types=1);

namespace Barcode;

abstract class Two2DCode extends BarcodeAbstract
{
    public function get(): ?\GdImage
    {
        $codeArray = $this->generateCodeArray();
        return $this->createImage($codeArray);
    }

    abstract public function generateCodeArray(): array;

    /**
     * Barkod görüntüsünü oluştur.
     * Create barcode image
     */
    protected function createImage(array $codeArray): ?\GdImage
    {
        if (empty($codeArray)) {
            return null;
        }

        $dimensions = $this->calculateDimensions($codeArray);
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

        $width  = \count($codeArray);
        $height = \count(\reset($codeArray));

        $multiplier = (int) (($dimensions['width'] - 2 * $this->margin) / $width);
        $locationX  = $this->margin;

        for ($posX = 0; $posX < $width; ++$posX) {
            $locationY = $this->margin;

            for ($posY = 0; $posY < $height; ++$posY) {
                \imagefilledrectangle(
                    $image,
                    $locationX,
                    $locationY,
                    $locationX + $multiplier,
                    $locationY + $multiplier,
                    $codeArray[$posY][$posX] ? $black : $white
                );

                $locationY += $multiplier;
            }

            $locationX += $multiplier;
        }

        return $image;
    }

    /**
     * Kod boyutlarını hesaplar.
     * Calculate the code dimensions.
     */
    private function calculateDimensions(array $codeArray): array
    {
        if (empty($codeArray)) {
            return [
                'width'  => 0,
                'height' => 0,
            ];
        }

        $matrixDimension = \max(\count($codeArray), \count(\reset($codeArray)));
        $imageDimension  = \max($this->dimension['width'], $this->dimension['width']);
        $multiplier      = (int) (($imageDimension - 2 * $this->margin) / $matrixDimension);

        $dimensions['width']  = (int) ($matrixDimension * $multiplier + 2 * $this->margin);
        $dimensions['height'] = (int) ($matrixDimension * $multiplier + 2 * $this->margin);
        return $dimensions;
    }
}