<?php

declare(strict_types = 1);

namespace Barcode\Exception;

class InvalidValueType extends \UnexpectedValueException
{
    public function __construct($message, int $code = 0, ?\Exception $previous = null)
    {
        parent::__construct($message . ' geçerli değil.', $code, $previous);
    }
}
