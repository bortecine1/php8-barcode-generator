<?php

declare(strict_types=1);

namespace Barcode;

use Barcode\Exception\InvalidValueType;
use Barcode\Types\OrientationType;

/**
 * @author Selman Kocahal
 * @license MIT License
 */
abstract class BarcodeAbstract
{
    protected string $codestring    = '';
    protected array $codearray      = [[]];

    protected int $orientation  = 0;
    protected array $dimension  = ['width' => 0, 'height' => 0];
    protected int $margin       = 10;
    protected string $content   = '';
    protected array $background = ['r' => 0, 'g' => 0, 'b' => 0, 'a' => 0];
    protected array $front      = ['r' => 0, 'g' => 0, 'b' => 0, 'a' => 0];

    public function __construct(string $content = '', int $width = 100, int $height = 20, int $orientation = OrientationType::HORIZONTAL)
    {
        $this->setContent($content);
        $this->setDimension($width, $height);
        $this->setOrientation($orientation);
    }

    /**
     * Barkod boyutlarını ayarlar.
     * Set barcode dimensions.
     */
    public function setDimension(int $width, int $height): void
    {
        if ($width < 0) {
            throw new \OutOfBoundsException((string) $width);
        }

        if ($height < 0) {
            throw new \OutOfBoundsException((string) $height);
        }

        $this->dimension['width']  = $width;
        $this->dimension['height'] = $height;
    }

    /**
     * Barkod kenar boşluklarını ayarlar.
     * Set barcode margins.
     */
    public function setMargin(int $margin): void
    {
        $this->margin = $margin;
    }

    /**
     * Barkod yönünü ayarlar.
     * Set barcode orientation.
     */
    public function setOrientation(int $orientation): void
    {
        if (!OrientationType::isValidValue($orientation)) {
            throw new InvalidValueType($orientation);
        }

        $this->orientation = $orientation;
    }

    /**
     * Şifrelenen içeriği alır.
     * Retrieves encrypted content.
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * Şifrelenecek içeriği ayarlar.
     * Set content to encrypt.
     */
    public function setContent(string $content): void
    {
        $this->content    = $content;
        $this->codestring = '';
        $this->codearray  = [];
    }

    /**
     * Dosyayı PNG biçiminde kaydeder.
     * Saves the file in PNG format.
     */
    public function saveToPngFile(string $file): void
    {
        $res = $this->get();

        if ($res === null) {
            return;
        }

        \imagepng($res, $file);
        \imagedestroy($res);
    }

    /**
     * Dosyayı PNG biçiminde kaydeder.
     * Saves the file in JPG format.
     */
    public function saveToJpgFile(string $file): void
    {
        $res = $this->get();
        
        if ($res === null) {
            return;
        }

        \imagejpeg($res, $file);
        \imagedestroy($res);
    }
    

    abstract public function get(): ?\GdImage;
}