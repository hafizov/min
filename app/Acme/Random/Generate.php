<?php
/**
 * Created by PhpStorm.
 * User: anonymous
 * Date: 31.03.19
 * Time: 22:54
 */

namespace App\Acme\Random;

class Generate
{
    private $keySpace = null;

    /**
     * Generate constructor.
     * @param string $keySpace
     */
    public function __construct($keySpace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ')
    {
        $this->keySpace= $keySpace;
    }

    /**
     * @param int $length
     * @return string
     */
    public function random($length = 10)
    {
        $pieces = [];
        $max = mb_strlen($this->keySpace, '8bit') - 1;
        for ($i = 0; $i < $length; ++$i) {
            $pieces []= $this->keySpace[random_int(0, $max)];
        }
        return implode('', $pieces);
    }
}