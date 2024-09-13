<?php

declare(strict_types=1);

namespace Barcode;

/**
 * @author Selman Kocahal
 * @license MIT License
 */
class Datamatrix extends Two2DCode
{
    private const ENC_ASCII     = 0;
    private const ENC_C40       = 1;
    private const ENC_TXT       = 2;
    private const ENC_X12       = 3;
    private const ENC_EDF       = 4;
    private const ENC_BASE256   = 5;
    private const ENC_ASCII_EXT = 6;
    private const ENC_ASCII_NUM = 7;

    private const ECC_200_SYMBOL_ATTR = [
        // Kare form  ---------------------------------------------------------------------------------------
        [0x00a, 0x00a, 0x008, 0x008, 0x00a, 0x00a, 0x008, 0x008, 0x001, 0x001, 0x001, 0x003, 0x005, 0x001, 0x003, 0x005],
        [0x00c, 0x00c, 0x00a, 0x00a, 0x00c, 0x00c, 0x00a, 0x00a, 0x001, 0x001, 0x001, 0x005, 0x007, 0x001, 0x005, 0x007],
        [0x00e, 0x00e, 0x00c, 0x00c, 0x00e, 0x00e, 0x00c, 0x00c, 0x001, 0x001, 0x001, 0x008, 0x00a, 0x001, 0x008, 0x00a],
        [0x010, 0x010, 0x00e, 0x00e, 0x010, 0x010, 0x00e, 0x00e, 0x001, 0x001, 0x001, 0x00c, 0x00c, 0x001, 0x00c, 0x00c],
        [0x012, 0x012, 0x010, 0x010, 0x012, 0x012, 0x010, 0x010, 0x001, 0x001, 0x001, 0x012, 0x00e, 0x001, 0x012, 0x00e],
        [0x014, 0x014, 0x012, 0x012, 0x014, 0x014, 0x012, 0x012, 0x001, 0x001, 0x001, 0x016, 0x012, 0x001, 0x016, 0x012],
        [0x016, 0x016, 0x014, 0x014, 0x016, 0x016, 0x014, 0x014, 0x001, 0x001, 0x001, 0x01e, 0x014, 0x001, 0x01e, 0x014],
        [0x018, 0x018, 0x016, 0x016, 0x018, 0x018, 0x016, 0x016, 0x001, 0x001, 0x001, 0x024, 0x018, 0x001, 0x024, 0x018],
        [0x01a, 0x01a, 0x018, 0x018, 0x01a, 0x01a, 0x018, 0x018, 0x001, 0x001, 0x001, 0x02c, 0x01c, 0x001, 0x02c, 0x01c],
        [0x020, 0x020, 0x01c, 0x01c, 0x010, 0x010, 0x00e, 0x00e, 0x002, 0x002, 0x004, 0x03e, 0x024, 0x001, 0x03e, 0x024],
        [0x024, 0x024, 0x020, 0x020, 0x012, 0x012, 0x010, 0x010, 0x002, 0x002, 0x004, 0x056, 0x02a, 0x001, 0x056, 0x02a],
        [0x028, 0x028, 0x024, 0x024, 0x014, 0x014, 0x012, 0x012, 0x002, 0x002, 0x004, 0x072, 0x030, 0x001, 0x072, 0x030],
        [0x02c, 0x02c, 0x028, 0x028, 0x016, 0x016, 0x014, 0x014, 0x002, 0x002, 0x004, 0x090, 0x038, 0x001, 0x090, 0x038],
        [0x030, 0x030, 0x02c, 0x02c, 0x018, 0x018, 0x016, 0x016, 0x002, 0x002, 0x004, 0x0ae, 0x044, 0x001, 0x0ae, 0x044],
        [0x034, 0x034, 0x030, 0x030, 0x01a, 0x01a, 0x018, 0x018, 0x002, 0x002, 0x004, 0x0cc, 0x054, 0x002, 0x066, 0x02a],
        [0x040, 0x040, 0x038, 0x038, 0x010, 0x010, 0x00e, 0x00e, 0x004, 0x004, 0x010, 0x118, 0x070, 0x002, 0x08c, 0x038],
        [0x048, 0x048, 0x040, 0x040, 0x012, 0x012, 0x010, 0x010, 0x004, 0x004, 0x010, 0x170, 0x090, 0x004, 0x05c, 0x024],
        [0x050, 0x050, 0x048, 0x048, 0x014, 0x014, 0x012, 0x012, 0x004, 0x004, 0x010, 0x1c8, 0x0c0, 0x004, 0x072, 0x030],
        [0x058, 0x058, 0x050, 0x050, 0x016, 0x016, 0x014, 0x014, 0x004, 0x004, 0x010, 0x240, 0x0e0, 0x004, 0x090, 0x038],
        [0x060, 0x060, 0x058, 0x058, 0x018, 0x018, 0x016, 0x016, 0x004, 0x004, 0x010, 0x2b8, 0x110, 0x004, 0x0ae, 0x044],
        [0x068, 0x068, 0x060, 0x060, 0x01a, 0x01a, 0x018, 0x018, 0x004, 0x004, 0x010, 0x330, 0x150, 0x006, 0x088, 0x038],
        [0x078, 0x078, 0x06c, 0x06c, 0x014, 0x014, 0x012, 0x012, 0x006, 0x006, 0x024, 0x41a, 0x198, 0x006, 0x0af, 0x044],
        [0x084, 0x084, 0x078, 0x078, 0x016, 0x016, 0x014, 0x014, 0x006, 0x006, 0x024, 0x518, 0x1f0, 0x008, 0x0a3, 0x03e],
        [0x090, 0x090, 0x084, 0x084, 0x018, 0x018, 0x016, 0x016, 0x006, 0x006, 0x024, 0x616, 0x26c, 0x00a, 0x09c, 0x03e], // 144x144
        // Dikdörtgen form (kullanım dışı) ---------------------------------------------------------------------------
        [0x008, 0x012, 0x006, 0x010, 0x008, 0x012, 0x006, 0x010, 0x001, 0x001, 0x001, 0x005, 0x007, 0x001, 0x005, 0x007],
        [0x008, 0x020, 0x006, 0x01c, 0x008, 0x010, 0x006, 0x00e, 0x001, 0x002, 0x002, 0x00a, 0x00b, 0x001, 0x00a, 0x00b],
        [0x00c, 0x01a, 0x00a, 0x018, 0x00c, 0x01a, 0x00a, 0x018, 0x001, 0x001, 0x001, 0x010, 0x00e, 0x001, 0x010, 0x00e],
        [0x00c, 0x024, 0x00a, 0x020, 0x00c, 0x012, 0x00a, 0x010, 0x001, 0x002, 0x002, 0x00c, 0x012, 0x001, 0x00c, 0x012],
        [0x010, 0x024, 0x00e, 0x020, 0x010, 0x012, 0x00e, 0x010, 0x001, 0x002, 0x002, 0x020, 0x018, 0x001, 0x020, 0x018],
        [0x010, 0x030, 0x00e, 0x02c, 0x010, 0x018, 0x00e, 0x016, 0x001, 0x002, 0x002, 0x031, 0x01c, 0x001, 0x031, 0x01c],  // 16x48
    ];

    private const CHARSET = [
        self::ENC_C40 => [
            'S1' => 0x00, 'S2' => 0x01, 'S3' => 0x02, 0x20 => 0x03, 0x30 => 0x04, 0x31 => 0x05, 0x32 => 0x06, 0x33 => 0x07, 0x34 => 0x08, 0x35 => 0x09,
            0x36 => 0x0a, 0x37 => 0x0b, 0x38 => 0x0c, 0x39 => 0x0d, 0x41 => 0x0e, 0x42 => 0x0f, 0x43 => 0x10, 0x44 => 0x11, 0x45 => 0x12, 0x46 => 0x13,
            0x47 => 0x14, 0x48 => 0x15, 0x49 => 0x16, 0x4a => 0x17, 0x4b => 0x18, 0x4c => 0x19, 0x4d => 0x1a, 0x4e => 0x1b, 0x4f => 0x1c, 0x50 => 0x1d,
            0x51 => 0x1e, 0x52 => 0x1f, 0x53 => 0x20, 0x54 => 0x21, 0x55 => 0x22, 0x56 => 0x23, 0x57 => 0x24, 0x58 => 0x25, 0x59 => 0x26, 0x5a => 0x27,
        ],
        self::ENC_TXT => [
            'S1' => 0x00, 'S2' => 0x01, 'S3' => 0x02, 0x20 => 0x03, 0x30 => 0x04, 0x31 => 0x05, 0x32 => 0x06, 0x33 => 0x07, 0x34 => 0x08, 0x35 => 0x09,
            0x36 => 0x0a, 0x37 => 0x0b, 0x38 => 0x0c, 0x39 => 0x0d, 0x61 => 0x0e, 0x62 => 0x0f, 0x63 => 0x10, 0x64 => 0x11, 0x65 => 0x12, 0x66 => 0x13,
            0x67 => 0x14, 0x68 => 0x15, 0x69 => 0x16, 0x6a => 0x17, 0x6b => 0x18, 0x6c => 0x19, 0x6d => 0x1a, 0x6e => 0x1b, 0x6f => 0x1c, 0x70 => 0x1d,
            0x71 => 0x1e, 0x72 => 0x1f, 0x73 => 0x20, 0x74 => 0x21, 0x75 => 0x22, 0x76 => 0x23, 0x77 => 0x24, 0x78 => 0x25, 0x79 => 0x26, 0x7a => 0x27,
        ],
        'SH1' => [
            0x00 => 0x00, 0x01 => 0x01, 0x02 => 0x02, 0x03 => 0x03, 0x04 => 0x04, 0x05 => 0x05, 0x06 => 0x06, 0x07 => 0x07, 0x08 => 0x08, 0x09 => 0x09,
            0x0a => 0x0a, 0x0b => 0x0b, 0x0c => 0x0c, 0x0d => 0x0d, 0x0e => 0x0e, 0x0f => 0x0f, 0x10 => 0x10, 0x11 => 0x11, 0x12 => 0x12, 0x13 => 0x13,
            0x14 => 0x14, 0x15 => 0x15, 0x16 => 0x16, 0x17 => 0x17, 0x18 => 0x18, 0x19 => 0x19, 0x1a => 0x1a, 0x1b => 0x1b, 0x1c => 0x1c, 0x1d => 0x1d,
            0x1e => 0x1e, 0x1f => 0x1f,
        ],
        'SH2' => [ 
            0x21 => 0x00, 0x22 => 0x01, 0x23 => 0x02, 0x24 => 0x03, 0x25 => 0x04, 0x26 => 0x05, 0x27 => 0x06, 0x28 => 0x07, 0x29 => 0x08, 0x2a => 0x09,
            0x2b => 0x0a, 0x2c => 0x0b, 0x2d => 0x0c, 0x2e => 0x0d, 0x2f => 0x0e, 0x3a => 0x0f, 0x3b => 0x10, 0x3c => 0x11, 0x3d => 0x12, 0x3e => 0x13,
            0x3f => 0x14, 0x40 => 0x15, 0x5b => 0x16, 0x5c => 0x17, 0x5d => 0x18, 0x5e => 0x19, 0x5f => 0x1a, 'F1' => 0x1b, 'US' => 0x1e,
        ],
        'S3C' => [
            0x60 => 0x00, 0x61 => 0x01, 0x62 => 0x02, 0x63 => 0x03, 0x64 => 0x04, 0x65 => 0x05, 0x66 => 0x06, 0x67 => 0x07, 0x68 => 0x08, 0x69 => 0x09,
            0x6a => 0x0a, 0x6b => 0x0b, 0x6c => 0x0c, 0x6d => 0x0d, 0x6e => 0x0e, 0x6f => 0x0f, 0x70 => 0x10, 0x71 => 0x11, 0x72 => 0x12, 0x73 => 0x13,
            0x74 => 0x14, 0x75 => 0x15, 0x76 => 0x16, 0x77 => 0x17, 0x78 => 0x18, 0x79 => 0x19, 0x7a => 0x1a, 0x7b => 0x1b, 0x7c => 0x1c, 0x7d => 0x1d,
            0x7e => 0x1e, 0x7f => 0x1f,
        ],
        'S3T' => [ 
            0x60 => 0x00, 0x41 => 0x01, 0x42 => 0x02, 0x43 => 0x03, 0x44 => 0x04, 0x45 => 0x05, 0x46 => 0x06, 0x47 => 0x07, 0x48 => 0x08, 0x49 => 0x09,
            0x4a => 0x0a, 0x4b => 0x0b, 0x4c => 0x0c, 0x4d => 0x0d, 0x4e => 0x0e, 0x4f => 0x0f, 0x50 => 0x10, 0x51 => 0x11, 0x52 => 0x12, 0x53 => 0x13,
            0x54 => 0x14, 0x55 => 0x15, 0x56 => 0x16, 0x57 => 0x17, 0x58 => 0x18, 0x59 => 0x19, 0x5a => 0x1a, 0x7b => 0x1b, 0x7c => 0x1c, 0x7d => 0x1d,
            0x7e => 0x1e, 0x7f => 0x1f,
        ],
        self::ENC_X12 => [
            0x0d => 0x00, 0x2a => 0x01, 0x3e => 0x02, 0x20 => 0x03, 0x30 => 0x04, 0x31 => 0x05, 0x32 => 0x06, 0x33 => 0x07, 0x34 => 0x08, 0x35 => 0x09,
            0x36 => 0x0a, 0x37 => 0x0b, 0x38 => 0x0c, 0x39 => 0x0d, 0x41 => 0x0e, 0x42 => 0x0f, 0x43 => 0x10, 0x44 => 0x11, 0x45 => 0x12, 0x46 => 0x13,
            0x47 => 0x14, 0x48 => 0x15, 0x49 => 0x16, 0x4a => 0x17, 0x4b => 0x18, 0x4c => 0x19, 0x4d => 0x1a, 0x4e => 0x1b, 0x4f => 0x1c, 0x50 => 0x1d,
            0x51 => 0x1e, 0x52 => 0x1f, 0x53 => 0x20, 0x54 => 0x21, 0x55 => 0x22, 0x56 => 0x23, 0x57 => 0x24, 0x58 => 0x25, 0x59 => 0x26, 0x5a => 0x27,
        ],
    ];

    public int $encoding = self::ENC_ASCII;

    /**
     * Bir barkod dizisi oluştur.
     * A create barcode array.
     */
    public function generateCodeArray(): array
    {
        $this->codearray = [];

        $cw = $this->getHighLevelEncoding($this->content);
        $nd = \count($cw);

        if ($nd > 1558) {
            return [];
        }

        foreach (self::ECC_200_SYMBOL_ATTR as $params) {
            if ($params[11] >= $nd) {
                break;
            }
        }

        if ($params[11] < $nd) {
            return [];
        } elseif ($params[11] > $nd) {
            if ((($params[11] - $nd) > 1) && ($cw[($nd - 1)] !== 254)) {
                if ($this->encoding === self::ENC_EDF) {
                    $cw[] = 124;
                    ++$nd;
                } elseif (($this->encoding !== self::ENC_ASCII) && ($this->encoding !== self::ENC_BASE256)) {
                    $cw[] = 254;
                    ++$nd;
                }
            }

            if ($params[11] > $nd) {
                $cw[] = 129;
                ++$nd;

                for ($i = $nd; $i < $params[11]; ++$i) {
                    $cw[] = $this->get253StateCodeword(129, $i);
                }
            }
        }

        $cw = $this->getErrorCorrection($cw, $params[13], $params[14], $params[15]);

        for ($i = 0; $i < $params[2]; ++$i) {
            $this->codearray[$i] = \array_fill(0, $params[3], false);
        }

        $places = $this->getPlacementMap($params[2], $params[3]);
        $i      = 0;
        $rdri   = ($params[4] - 1);
        $rdci   = ($params[5] - 1);

        for ($vr = 0; $vr < $params[9]; ++$vr) {
            for ($r = 0; $r < $params[4]; ++$r) {
                $row = (($vr * $params[4]) + $r);

                for ($hr = 0; $hr < $params[8]; ++$hr) {
                    for ($c = 0; $c < $params[5]; ++$c) {
                        $col = (($hr * $params[5]) + $c);

                        if ($r === 0) {
                            $this->codearray[$row][$col] = ($c % 2) === 0;
                        } elseif ($r === $rdri) {
                            $this->codearray[$row][$col] = true;
                        } elseif ($c === 0) {
                            $this->codearray[$row][$col] = true;
                        } elseif ($c === $rdci) {
                            $this->codearray[$row][$col] = ($r % 2) === 0;
                        } elseif ($places[$i] < 2) {
                            $this->codearray[$row][$col] = (bool) $places[$i];

                            ++$i;
                        } else {
                            $cw_id  = (int) (\floor($places[$i] / 10) - 1);
                            $cw_bit = \pow(2, (8 - ($places[$i] % 10)));

                            $this->codearray[$row][$col] = ($cw[$cw_id] & $cw_bit) !== 0;
                            ++$i;
                        }
                    }
                }
            }
        }

        return $this->codearray;
    }

    /**
     * İki kuvvetli Galois alanında iki sayının çarpımını verir.
     * Returns the product of two numbers in a two-power Galois field.
     */
    protected function getGaloisField(int $a, int $b, array $log, array $alog, int $gf): int
    {
        if (($a === 0) || ($b === 0)) {
            return 0;
        }

        return $alog[($log[$a] + $log[$b]) % ($gf - 1)];
    }

    /**
     * Veri kod sözcükleri dizisine hata düzeltme kod sözcükleri ekler.
     * Add error correction codewords to data codewords array.
     */
    protected function getErrorCorrection(array $wd, int $nb, int $nd, int $nc, int $gf = 256, int $pp = 301): array
    {
        $log[0]  = 0;
        $alog[0] = 1;

        for ($i = 1; $i < $gf; ++$i) {
            $alog[$i] = ($alog[($i - 1)] * 2);

            if ($alog[$i] >= $gf) {
                $alog[$i] ^= $pp;
            }

            $log[$alog[$i]] = $i;
        }

        \ksort($log);

        $c    = \array_fill(0, ($nc + 1), 0);
        $c[0] = 1;

        for ($i = 1; $i <= $nc; ++$i) {
            $c[$i] = $c[($i - 1)];

            for ($j = ($i - 1); $j >= 1; --$j) {
                $c[$j] = $c[($j - 1)] ^ $this->getGaloisField($c[$j], $alog[$i], $log, $alog, $gf);
            }

            $c[0] = $this->getGaloisField($c[0], $alog[$i], $log, $alog, $gf);
        }

        \ksort($c);

        $num_wd = ($nb * $nd);
        $num_we = ($nb * $nc);

        for ($b = 0; $b < $nb; ++$b) {
            $block = [];

            for ($n = $b; $n < $num_wd; $n += $nb) {
                $block[] = $wd[$n];
            }

            $we = \array_fill(0, ($nc + 1), 0);

            for ($i = 0; $i < $nd; ++$i) {
                $k = ($we[0] ^ $block[$i]);

                for ($j = 0; $j < $nc; ++$j) {
                    $we[$j] = ($we[($j + 1)] ^ $this->getGaloisField($k, $c[($nc - $j - 1)], $log, $alog, $gf));
                }
            }

            $j = 0;

            for ($i = $b; $i < $num_we; $i += $nb) {
                $wd[($num_wd + $i)] = $we[$j];
                ++$j;
            }
        }

        \ksort($wd);
        return $wd;
    }

    /**
     * 253 durumlu kod sözcüğünü döndürür.
     * Return the 253-state codeword.
     */
    protected function get253StateCodeword(int $cwpad, int $cwpos): int
    {
        $pad = ($cwpad + (((149 * $cwpos) % 253) + 1));

        if ($pad > 254) {
            $pad -= 254;
        }

        return $pad;
    }

    /**
     * 255 durumlu kod sözcüğünü döndürür.
     * Return the 255-state codeword
     */
    protected function get255StateCodeword(int $cwpad, int $cwpos): int
    {
        $pad = ($cwpad + (((149 * $cwpos) % 255) + 1));

        if ($pad > 255) {
            $pad -= 256;
        }

        return $pad;
    }

    /**
     * Karakterin seçili moda ait olup olmadığını kontrol eder.
     * Checks whether the character belongs to the selected mode.
     */
    protected function isCharMode(int $chr, int $mode): bool
    {
        switch ($mode) {
            case self::ENC_ASCII:
                // ASCII 0 - 127
                return (($chr >= 0) && ($chr <= 127));
            case self::ENC_C40:
                // Büyük harfli alfanümerik
                return (($chr === 32) || (($chr >= 48) && ($chr <= 57)) || (($chr >= 65) && ($chr <= 90)));
            case self::ENC_TXT:
                // Küçük harfli alfanümerik
                return (($chr === 32) || (($chr >= 48) && ($chr <= 57)) || (($chr >= 97) && ($chr <= 122)));
            case self::ENC_X12:
                // ANSI X12
                return (($chr === 13) || ($chr === 42) || ($chr === 62));
            case self::ENC_EDF:
                // ASCII 32 - 94
                return (($chr >= 32) && ($chr <= 94));
            case self::ENC_BASE256:
                // Fonksiyon karakterleri
                return (($chr === 232) || ($chr === 233) || ($chr === 234) || ($chr === 241));
            case self::ENC_ASCII_EXT:
                // ASCII 128 - 255
                return (($chr >= 128) && ($chr <= 255));
            case self::ENC_ASCII_NUM:
                // ASCII rakamları
                return (($chr >= 48) && ($chr <= 57));
        }

        return false;
    }

    /**
     * En iyi modu bulmak için kodlanacak verileri tarar.
     * It scans the data to be encoded to find the best mode.
     */
    protected function lookAheadTest(string $data, int $pos, int $mode): int
    {
        $data_length = \strlen($data);

        if ($pos >= $data_length) {
            return $mode;
        }

        $charscount = 0;

        // Adım: J
        if ($mode === self::ENC_ASCII) {
            $numch = [0, 1, 1, 1, 1, 1.25];
        } else {
            $numch        = [1, 2, 2, 2, 2, 2.25];
            $numch[$mode] = 0;
        }

        while (true) {
            // Adım: K
            if (($pos + $charscount) === $data_length) {
                if ($numch[self::ENC_ASCII] <= \ceil(\min(
                        $numch[self::ENC_C40],
                        $numch[self::ENC_TXT],
                        $numch[self::ENC_X12],
                        $numch[self::ENC_EDF],
                        $numch[self::ENC_BASE256]
                    ))
                ) {
                    return self::ENC_ASCII;
                }

                if ($numch[self::ENC_BASE256] < \ceil(\min(
                        $numch[self::ENC_ASCII],
                        $numch[self::ENC_C40],
                        $numch[self::ENC_TXT],
                        $numch[self::ENC_X12],
                        $numch[self::ENC_EDF]
                    ))
                ) {
                    return self::ENC_BASE256;
                }

                if ($numch[self::ENC_EDF] < \ceil(\min(
                        $numch[self::ENC_ASCII],
                        $numch[self::ENC_C40],
                        $numch[self::ENC_TXT],
                        $numch[self::ENC_X12],
                        $numch[self::ENC_BASE256]
                    ))
                ) {
                    return self::ENC_EDF;
                }

                if ($numch[self::ENC_TXT] < \ceil(\min(
                        $numch[self::ENC_ASCII],
                        $numch[self::ENC_C40],
                        $numch[self::ENC_X12],
                        $numch[self::ENC_EDF],
                        $numch[self::ENC_BASE256]
                    ))
                ) {
                    return self::ENC_TXT;
                }

                if ($numch[self::ENC_X12] < \ceil(\min(
                        $numch[self::ENC_ASCII],
                        $numch[self::ENC_C40],
                        $numch[self::ENC_TXT],
                        $numch[self::ENC_EDF],
                        $numch[self::ENC_BASE256]
                    ))
                ) {
                    return self::ENC_X12;
                }

                return self::ENC_C40;
            }

            $chr = \ord($data[$pos + $charscount]);
            ++$charscount;

            // Adım: L
            if ($this->isCharMode($chr, self::ENC_ASCII_NUM)) {
                $numch[self::ENC_ASCII] += (1 / 2);
            } elseif ($this->isCharMode($chr, self::ENC_ASCII_EXT)) {
                $numch[self::ENC_ASCII] = \ceil($numch[self::ENC_ASCII]);
                $numch[self::ENC_ASCII] += 2;
            } else {
                $numch[self::ENC_ASCII] = \ceil($numch[self::ENC_ASCII]);
                ++$numch[self::ENC_ASCII];
            }

            // Adım: M
            if ($this->isCharMode($chr, self::ENC_C40)) {
                $numch[self::ENC_C40] += (2 / 3);
            } elseif ($this->isCharMode($chr, self::ENC_ASCII_EXT)) {
                $numch[self::ENC_C40] += (8 / 3);
            } else {
                $numch[self::ENC_C40] += (4 / 3);
            }

            // Adım: N
            if ($this->isCharMode($chr, self::ENC_TXT)) {
                $numch[self::ENC_TXT] += (2 / 3);
            } elseif ($this->isCharMode($chr, self::ENC_ASCII_EXT)) {
                $numch[self::ENC_TXT] += (8 / 3);
            } else {
                $numch[self::ENC_TXT] += (4 / 3);
            }

            // Adım: O
            if ($this->isCharMode($chr, self::ENC_X12) || $this->isCharMode($chr, self::ENC_C40)) {
                $numch[self::ENC_X12] += (2 / 3);
            } elseif ($this->isCharMode($chr, self::ENC_ASCII_EXT)) {
                $numch[self::ENC_X12] += (13 / 3);
            } else {
                $numch[self::ENC_X12] += (10 / 3);
            }

            // Adım: P
            if ($this->isCharMode($chr, self::ENC_EDF)) {
                $numch[self::ENC_EDF] += (3 / 4);
            } elseif ($this->isCharMode($chr, self::ENC_ASCII_EXT)) {
                $numch[self::ENC_EDF] += (17 / 4);
            } else {
                $numch[self::ENC_EDF] += (13 / 4);
            }

            // Adım: Q
            if ($this->isCharMode($chr, self::ENC_BASE256)) {
                $numch[self::ENC_BASE256] += 4;
            } else {
                ++$numch[self::ENC_BASE256];
            }

            // Adım: R
            if ($charscount >= 4) {
                if (($numch[self::ENC_ASCII] + 1) <= \min(
                        $numch[self::ENC_C40],
                        $numch[self::ENC_TXT],
                        $numch[self::ENC_X12],
                        $numch[self::ENC_EDF],
                        $numch[self::ENC_BASE256]
                    )
                ) {
                    return self::ENC_ASCII;
                }

                if ((($numch[self::ENC_BASE256] + 1) <= $numch[self::ENC_ASCII])
                    || ($numch[self::ENC_BASE256] + 1) < \min(
                            $numch[self::ENC_C40],
                            $numch[self::ENC_TXT],
                            $numch[self::ENC_X12],
                            $numch[self::ENC_EDF]
                        )
                ) {
                    return self::ENC_BASE256;
                }

                if (($numch[self::ENC_EDF] + 1) < \min(
                        $numch[self::ENC_ASCII],
                        $numch[self::ENC_C40],
                        $numch[self::ENC_TXT],
                        $numch[self::ENC_X12],
                        $numch[self::ENC_BASE256]
                    )
                ) {
                    return self::ENC_EDF;
                }

                if (($numch[self::ENC_TXT] + 1) < \min(
                        $numch[self::ENC_ASCII],
                        $numch[self::ENC_C40],
                        $numch[self::ENC_X12],
                        $numch[self::ENC_EDF],
                        $numch[self::ENC_BASE256]
                    )
                ) {
                    return self::ENC_TXT;
                }

                if (($numch[self::ENC_X12] + 1) < \min(
                        $numch[self::ENC_ASCII],
                        $numch[self::ENC_C40],
                        $numch[self::ENC_TXT],
                        $numch[self::ENC_EDF],
                        $numch[self::ENC_BASE256]
                    )
                ) {
                    return self::ENC_X12;
                }

                if (($numch[self::ENC_C40] + 1) < \min(
                        $numch[self::ENC_ASCII],
                        $numch[self::ENC_TXT],
                        $numch[self::ENC_EDF],
                        $numch[self::ENC_BASE256]
                    )
                ) {
                    if ($numch[self::ENC_C40] < $numch[self::ENC_X12]) {
                        return self::ENC_C40;
                    }

                    if ($numch[self::ENC_C40] === $numch[self::ENC_X12]) {
                        $k = ($pos + $charscount + 1);

                        while ($k < $data_length) {
                            $tmpchr = \ord($data[$k]);

                            if ($this->isCharMode($tmpchr, self::ENC_X12)) {
                                return self::ENC_X12;
                            } elseif (!$this->isCharMode($tmpchr, self::ENC_X12)
                                && !$this->isCharMode($tmpchr, self::ENC_C40)
                            ) {
                                break;
                            }

                            ++$k;
                        }

                        return self::ENC_C40;
                    }
                }
            }
        }
    }

    /**
     * Anahtarlama kod sözcüğünü yeni bir kodlama moduna alır.
     * Switches the keying codeword to a new coding mode.
     */
    protected function getSwitchEncodingCodeword(int $mode): int
    {
        switch ($mode) {
            case self::ENC_ASCII:
                if ($this->encoding === self::ENC_EDF) {
                    return 124;
                }

                return 254;
            case self::ENC_C40:
                return 230;
            case self::ENC_TXT:
                return 239;
            case self::ENC_X12:
                return 238;
            case self::ENC_EDF:
                return 240;
            case self::ENC_BASE256:
                return 231;
        }

        return 254;
    }

    /**
     * Minimum matris boyutunu seçer ve maksimum veri kod sözcüğü sayısını döndürür.
     * Choose the minimum matrix size and return the max number of data codewords.
     */
    protected function getMaxDataCodewords(int $numcw): int
    {
        foreach (self::ECC_200_SYMBOL_ATTR as $matrix) {
            if ($matrix[11] >= $numcw) {
                return $matrix[11];
            }
        }

        return 0;
    }

    /**
     * ECC 200 için minimum sembol veri karakterlerini kullanarak yüksek düzeyde kodlama elde eder.
     * Get high level encoding using the minimum symbol data characters for ECC-200.
     */
    protected function getHighLevelEncoding(string $data): array
    {
        $enc         = self::ENC_ASCII;
        $pos         = 0;
        $cw          = [];
        $cw_num      = 0;
        $data_length = \strlen($data);

        while ($pos < $data_length) {
            $this->encoding = $enc;

            switch ($enc) {
                case self::ENC_ASCII:
                    if ($data_length > 1 && $pos < ($data_length - 1)
                        && ($this->isCharMode(\ord($data[$pos]), self::ENC_ASCII_NUM)
                            && $this->isCharMode(\ord($data[$pos + 1]), self::ENC_ASCII_NUM))
                    ) {
                        // 1. Bir sonraki veri dizisi en az 2 ardışık hane ise, sonraki iki haneyi ASCII modunda çift hane olarak kodlar.
                        $cw[] = ((int) \substr($data, $pos, 2) + 130);
                        ++$cw_num;
                        $pos += 2;
                    } else {
                        // 2. İleriye bakma testi (adım J'den başlayarak) başka bir mod gösteriyorsa, bu moda geçer.
                        $newenc = $this->lookAheadTest($data, $pos, $enc);

                        if ($newenc !== $enc) {
                            $enc  = $newenc;
                            $cw[] = $this->getSwitchEncodingCodeword($enc);
                            ++$cw_num;
                        } else {
                            $chr = \ord($data[$pos]);
                            ++$pos;

                            if ($this->isCharMode($chr, self::ENC_ASCII_EXT)) {
                                // 3. Bir sonraki veri karakteri genişletilmiş ASCII (127'den büyük) ise, önce üst kaydırma (değer 235) karakterini kullanarak ASCII modunda kodlar.
                                $cw[]    = 235;
                                $cw[]    = ($chr - 127);
                                $cw_num += 2;
                            } else {
                                // 4. Aksi takdirde, ASCII kodlamasında bir sonraki veri karakterini işler.
                                $cw[] = ($chr + 1);
                                ++$cw_num;
                            }
                        }
                    }

                    break;
                case self::ENC_C40:
                case self::ENC_TXT:
                case self::ENC_X12:
                    $temp_cw = [];
                    $p       = 0;
                    $epos    = $pos;
                    $charset = self::CHARSET[$enc];

                    do {
                        // 2. C40 kodlamasında bir sonraki karakteri işler.
                        $chr = \ord($data[$epos]);
                        ++$epos;

                        if (($chr & 0x80) !== 0) {
                            if ($enc === self::ENC_X12) {
                                return [];
                            }

                            $chr      &= 0x7f;
                            $temp_cw[] = 1;
                            $temp_cw[] = 30;
                            $p        += 2;
                        }

                        if (isset($charset[$chr])) {
                            $temp_cw[] = $charset[$chr];
                            ++$p;
                        } else {
                            if (isset(self::CHARSET['SH1'][$chr])) {
                                $temp_cw[] = 0;
                                $shiftset  = self::CHARSET['SH1'];
                            } elseif (isset($chr, self::CHARSET['SH2'][$chr])) {
                                $temp_cw[] = 1;
                                $shiftset  = self::CHARSET['SH2'];
                            } elseif ($enc === self::ENC_C40 && isset(self::CHARSET['S3C'][$chr])) {
                                $temp_cw[] = 2;
                                $shiftset  = self::CHARSET['S3C'];
                            } elseif ($enc === self::ENC_TXT && isset(self::CHARSET['S3T'][$chr])) {
                                $temp_cw[] = 2;
                                $shiftset  = self::CHARSET['S3T'];
                            } else {
                                return [];
                            }

                            $temp_cw[] = $shiftset[$chr];
                            $p        += 2;
                        }

                        if ($p >= 3) {
                            $c1      = \array_shift($temp_cw);
                            $c2      = \array_shift($temp_cw);
                            $c3      = \array_shift($temp_cw);
                            $p      -= 3;
                            $tmp     = ((1600 * $c1) + (40 * $c2) + $c3 + 1);
                            $cw[]    = ($tmp >> 8);
                            $cw[]    = ($tmp % 256);
                            $cw_num += 2;
                            $pos     = $epos;

                            // 1. C40 kodlaması yeni bir çift sembol karakteri başlatma noktasındaysa ve ileriye bakma testi (J adımından başlayarak) başka bir modu gösteriyorsa, bu moda geçer.
                            $newenc = $this->lookAheadTest($data, $pos, $enc);
                          
                            if ($newenc !== $enc) {
                                $enc = $newenc;

                                if ($enc !== self::ENC_ASCII) {
                                    $cw[] = $this->getSwitchEncodingCodeword(self::ENC_ASCII);
                                    ++$cw_num;
                                }

                                ++$cw_num;

                                $cw[] = $this->getSwitchEncodingCodeword($enc);
                                $pos -= $p;
                                $p    = 0;

                                break;
                            }
                        }
                    } while (($p > 0) && ($epos < $data_length));

                    // Varsa son verileri işler
                    if ($p > 0) {
                        $cwr = ($this->getMaxDataCodewords($cw_num) - $cw_num);

                        if (($cwr === 1) && ($p === 1)) {
                            // d. Kodlanacak bir sembol karakteri ve bir C40 değeri (veri karakteri) kaldıysa:
                            $c1 = \array_shift($temp_cw);
                            --$p;
                            ++$cw_num;

                            $cw[]           = ($chr + 1);
                            $pos            = $epos;
                            $enc            = self::ENC_ASCII;
                            $this->encoding = $enc;
                        } elseif (($cwr === 2) && ($p === 1)) {
                            // c. İki sembol karakteri kaldıysa ve kodlanacak yalnızca bir C40 değeri (veri karakteri) kaldıysa:
                            --$p;

                            $c1             = \array_shift($temp_cw);
                            $cw[]           = 254;
                            $cw[]           = ($chr + 1);
                            $cw_num        += 2;
                            $pos            = $epos;
                            $enc            = self::ENC_ASCII;
                            $this->encoding = $enc;
                        } elseif (($cwr === 2) && ($p === 2)) {
                            // b. İki sembol karakteri kalırsa ve kodlanacak iki C40 değeri kalırsa:
                            $c1             = \array_shift($temp_cw);
                            $c2             = \array_shift($temp_cw);
                            $p             -= 2;
                            $tmp            = ((1600 * $c1) + (40 * $c2) + 1);
                            $cw[]           = ($tmp >> 8);
                            $cw[]           = ($tmp % 256);
                            $cw_num        += 2;
                            $pos            = $epos;
                            $enc            = self::ENC_ASCII;
                            $this->encoding = $enc;
                        } elseif ($enc !== self::ENC_ASCII) {
                            $enc            = self::ENC_ASCII;
                            $this->encoding = $enc;
                            $cw[]           = $this->getSwitchEncodingCodeword($enc);

                            ++$cw_num;
                            $pos = ($epos - $p);
                        }
                    }
                    break;
                case self::ENC_EDF:
                    // F. EDIFACT (EDF) kodlamasında ise, geçici diziyi 0 uzunluk ile başlatır.
                    $temp_cw      = [];
                    $epos         = $pos;
                    $field_length = 0;
                    $newenc       = $enc;

                    do {
                        // 2. EDIFACT kodlamasında bir sonraki karakteri işler.
                        $chr = \ord($data[$epos]);

                        if ($this->isCharMode($chr, self::ENC_EDF)) {
                            ++$epos;
                            $temp_cw[] = $chr;
                            ++$field_length;
                        }

                        if (($field_length === 4)
                            || ($epos === $data_length)
                            || !$this->isCharMode($chr, self::ENC_EDF)
                        ) {
                            if (($epos === $data_length) && ($field_length < 3)) {
                                $enc  = self::ENC_ASCII;
                                $cw[] = $this->getSwitchEncodingCodeword($enc);
                                ++$cw_num;

                                break;
                            }

                            if ($field_length < 4) {
                                $temp_cw[] = 0x1f;
                                ++$field_length;

                                for ($i = $field_length; $i < 4; ++$i) {
                                    $temp_cw[] = 0;
                                }

                                $enc            = self::ENC_ASCII;
                                $this->encoding = $enc;
                            }

                            // Üç kod sözcüğünde dört veri karakterini kodlar.
                            $tcw = (($temp_cw[0] & 0x3F) << 2) + (($temp_cw[1] & 0x30) >> 4);

                            if ($tcw > 0) {
                                $cw[] = $tcw;
                                ++$cw_num;
                            }

                            $tcw = (($temp_cw[1] & 0x0F) << 4) + (($temp_cw[2] & 0x3C) >> 2);

                            if ($tcw > 0) {
                                $cw[] = $tcw;
                                ++$cw_num;
                            }

                            $tcw = (($temp_cw[2] & 0x03) << 6) + ($temp_cw[3] & 0x3F);

                            if ($tcw > 0) {
                                $cw[] = $tcw;
                                ++$cw_num;
                            }

                            $temp_cw      = [];
                            $pos          = $epos;
                            $field_length = 0;

                            if ($enc === self::ENC_ASCII) {
                                break;
                            }
                        }
                    } while ($epos < $data_length);

                    break;
                case self::ENC_BASE256:
                    // G. Base-256 (B256) kodlamasında iken, geçici diziyi 0 uzunluk ile başlatır.
                    $temp_cw      = [];
                    $field_length = 0;

                    while (($pos < $data_length) && ($field_length <= 1555)) {
                        $newenc = $this->lookAheadTest($data, $pos, $enc);

                        if ($newenc !== $enc) {
                            // 1. İleriye bakma testi, Başka bir mod gösteriyorsa, bu moda geçer.
                            $enc = $newenc;

                            break;
                        } else {
                            // 2. Aksi takdirde, bir sonraki karakteri Base-256 kodlamasında işler.
                            $chr = \ord($data[$pos]);
                            ++$pos;

                            $temp_cw[] = $chr;
                            ++$field_length;
                        }
                    }

                    if ($field_length <= 249) {
                        $cw[] = $this->get255StateCodeword($field_length, ($cw_num + 1));
                        ++$cw_num;
                    } else {
                        $cw[]    = $this->get255StateCodeword((int) (\floor($field_length / 250) + 249), ($cw_num + 1));
                        $cw[]    = $this->get255StateCodeword(($field_length % 250), ($cw_num + 2));
                        $cw_num += 2;
                    }

                    foreach ($temp_cw as $p => $cht) {
                        $cw[] = $this->get255StateCodeword($cht, ($cw_num + $p + 1));
                    }

                    break;
            }
        }

        return $cw;
    }

    /**
     * "chr+bit" ifadesini dizi içine uygun sarmalamayla yerleştirir.
     * Places the expression “chr+bit” in the array with the appropriate wrapper
     */
    protected function placeModule(array $marr, int $nrow, int $ncol, int $row, int $col, int $chr, int $bit): array
    {
        if ($row < 0) {
            $row += $nrow;
            $col += (4 - (($nrow + 4) % 8));
        }

        if ($col < 0) {
            $col += $ncol;
            $row += (4 - (($ncol + 4) % 8));
        }

        $marr[(($row * $ncol) + $col)] = ((10 * $chr) + $bit);
        return $marr;
    }

    /**
     * Utah şeklindeki sembol karakterinin 8 bitini yerleştirir.
     * Places 8 bits of the Utah-shaped symbol character.
     */
    protected function placeUtah(array $marr, int $nrow, int $ncol, int $row, int $col, int $chr): array
    {
        $marr = $this->placeModule($marr, $nrow, $ncol, $row - 2, $col - 2, $chr, 1);
        $marr = $this->placeModule($marr, $nrow, $ncol, $row - 2, $col - 1, $chr, 2);
        $marr = $this->placeModule($marr, $nrow, $ncol, $row - 1, $col - 2, $chr, 3);
        $marr = $this->placeModule($marr, $nrow, $ncol, $row - 1, $col - 1, $chr, 4);
        $marr = $this->placeModule($marr, $nrow, $ncol, $row - 1, $col,   $chr, 5);
        $marr = $this->placeModule($marr, $nrow, $ncol, $row,   $col - 2, $chr, 6);
        $marr = $this->placeModule($marr, $nrow, $ncol, $row,   $col - 1, $chr, 7);

        return $this->placeModule($marr, $nrow, $ncol, $row,   $col,   $chr, 8);
    }

    /**
     * İlk özel köşe durumunun 8 bitini yerleştirir.
     * Places the 8 bits of the first special corner case.
     */
    protected function placeCornerA(array $marr, int $nrow, int $ncol, int $chr): array
    {
        $marr = $this->placeModule($marr, $nrow, $ncol, $nrow - 1, 0, $chr, 1);
        $marr = $this->placeModule($marr, $nrow, $ncol, $nrow - 1, 1, $chr, 2);
        $marr = $this->placeModule($marr, $nrow, $ncol, $nrow - 1, 2, $chr, 3);
        $marr = $this->placeModule($marr, $nrow, $ncol, 0, $ncol - 2, $chr, 4);
        $marr = $this->placeModule($marr, $nrow, $ncol, 0, $ncol - 1, $chr, 5);
        $marr = $this->placeModule($marr, $nrow, $ncol, 1, $ncol - 1, $chr, 6);
        $marr = $this->placeModule($marr, $nrow, $ncol, 2, $ncol - 1, $chr, 7);

        return $this->placeModule($marr, $nrow, $ncol, 3, $ncol - 1, $chr, 8);
    }

    /**
     * İkinci özel köşe durumunun 8 bitini yerleştirir.
     * Places the 8 bits of the second special corner case.
     */
    protected function placeCornerB(array $marr, int $nrow, int $ncol, int $chr): array
    {
        $marr = $this->placeModule($marr, $nrow, $ncol, $nrow - 3, 0, $chr, 1);
        $marr = $this->placeModule($marr, $nrow, $ncol, $nrow - 2, 0, $chr, 2);
        $marr = $this->placeModule($marr, $nrow, $ncol, $nrow - 1, 0, $chr, 3);
        $marr = $this->placeModule($marr, $nrow, $ncol, 0, $ncol - 4, $chr, 4);
        $marr = $this->placeModule($marr, $nrow, $ncol, 0, $ncol - 3, $chr, 5);
        $marr = $this->placeModule($marr, $nrow, $ncol, 0, $ncol - 2, $chr, 6);
        $marr = $this->placeModule($marr, $nrow, $ncol, 0, $ncol - 1, $chr, 7);

        return $this->placeModule($marr, $nrow, $ncol, 1, $ncol - 1, $chr, 8);
    }

    /**
     * Üçüncü özel köşe durumunun 8 bitini yerleştirir.
     * Places the 8 bits of the third special corner case.
     */
    protected function placeCornerC(array $marr, int $nrow, int $ncol, int $chr): array
    {
        $marr = $this->placeModule($marr, $nrow, $ncol, $nrow - 3, 0, $chr, 1);
        $marr = $this->placeModule($marr, $nrow, $ncol, $nrow - 2, 0, $chr, 2);
        $marr = $this->placeModule($marr, $nrow, $ncol, $nrow - 1, 0, $chr, 3);
        $marr = $this->placeModule($marr, $nrow, $ncol, 0, $ncol - 2, $chr, 4);
        $marr = $this->placeModule($marr, $nrow, $ncol, 0, $ncol - 1, $chr, 5);
        $marr = $this->placeModule($marr, $nrow, $ncol, 1, $ncol - 1, $chr, 6);
        $marr = $this->placeModule($marr, $nrow, $ncol, 2, $ncol - 1, $chr, 7);

        return $this->placeModule($marr, $nrow, $ncol, 3, $ncol - 1, $chr, 8);
    }

    /**
     * Dördüncü özel köşe durumunun 8 bitini yerleştirir.
     * Places the 8 bits of the fourth special corner case.
     */
    protected function placeCornerD(array $marr, int $nrow, int $ncol, int $chr): array
    {
        $marr = $this->placeModule($marr, $nrow, $ncol, $nrow - 1, 0, $chr, 1);
        $marr = $this->placeModule($marr, $nrow, $ncol, $nrow - 1, $ncol - 1, $chr, 2);
        $marr = $this->placeModule($marr, $nrow, $ncol, 0, $ncol - 3, $chr, 3);
        $marr = $this->placeModule($marr, $nrow, $ncol, 0, $ncol - 2, $chr, 4);
        $marr = $this->placeModule($marr, $nrow, $ncol, 0, $ncol - 1, $chr, 5);
        $marr = $this->placeModule($marr, $nrow, $ncol, 1, $ncol - 3, $chr, 6);
        $marr = $this->placeModule($marr, $nrow, $ncol, 1, $ncol - 2, $chr, 7);

        return $this->placeModule($marr, $nrow, $ncol, 1, $ncol - 1, $chr, 8);
    }

    /**
     * Bir yerleşim haritası oluşturur.
     * Build a placement map.
     */
    protected function getPlacementMap(int $nrow, int $ncol): array
    {
        $marr = \array_fill(0, ($nrow * $ncol), 0);

        $chr = 1;
        $row = 4;
        $col = 0;

        do {
            if (($row === $nrow) && ($col === 0)) {
                $marr = $this->placeCornerA($marr, $nrow, $ncol, $chr);
                ++$chr;
            } elseif (($row === ($nrow - 2)) && ($col === 0) && ($ncol % 4)) {
                $marr = $this->placeCornerB($marr, $nrow, $ncol, $chr);
                ++$chr;
            } elseif (($row === ($nrow - 2)) && ($col === 0) && (($ncol % 8) === 4)) {
                $marr = $this->placeCornerC($marr, $nrow, $ncol, $chr);
                ++$chr;
            } elseif (($row === ($nrow + 4)) && ($col === 2) && (!($ncol % 8))) {
                $marr = $this->placeCornerD($marr, $nrow, $ncol, $chr);
                ++$chr;
            }

            do {
                if (($row < $nrow) && ($col >= 0) && (!$marr[(($row * $ncol) + $col)])) {
                    $marr = $this->placeUtah($marr, $nrow, $ncol, $row, $col, $chr);
                    ++$chr;
                }

                $row -= 2;
                $col += 2;
            } while (($row >= 0) && ($col < $ncol));

            ++$row;
            $col += 3;

            do {
                if (($row >= 0) && ($col < $ncol) && (!$marr[(($row * $ncol) + $col)])) {
                    $marr = $this->placeUtah($marr, $nrow, $ncol, $row, $col, $chr);
                    ++$chr;
                }

                $row += 2;
                $col -= 2;
            } while (($row < $nrow) && ($col >= 0));

            $row += 3;
            ++$col;
        } while (($row < $nrow) || ($col < $ncol));

        if (!$marr[(($nrow * $ncol) - 1)]) {
            $marr[(($nrow * $ncol) - 1)]         = 1;
            $marr[(($nrow * $ncol) - $ncol - 2)] = 1;
        }

        return $marr;
    }
}