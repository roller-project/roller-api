<?php
use phpseclib\Math\BigInteger as BigNumber;
/**
 * 
 */
class Uints
{
    public  $unit = array(
        'noether' => '0',
        'wei' => '1',
        'kwei' => '1000',
        'Kwei' => '1000',
        'babbage' => '1000',
        'femtoether' => '1000',
        'mwei' => '1000000',
        'Mwei' => '1000000',
        'lovelace' => '1000000',
        'picoether' => '1000000',
        'gwei' => '1000000000',
        'Gwei' => '1000000000',
        'shannon' => '1000000000',
        'nanoether' => '1000000000',
        'nano' => '1000000000',
        'szabo' => '1000000000000',
        'microether' => '1000000000000',
        'micro' => '1000000000000',
        'finney' => '1000000000000000',
        'milliether' => '1000000000000000',
        'milli' => '1000000000000000',
        'ether' => '1000000000000000000',
        'kether' => '1000000000000000000000',
        'grand' => '1000000000000000000000',
        'mether' => '1000000000000000000000000',
        'gether' => '1000000000000000000000000000',
        'tether' => '1000000000000000000000000000000'
    );
    
	function toHex($value, $isPrefix=false)
    {
        if (is_numeric($value)) {
            // turn to hex number
            $bn = $this->toBn($value);
            $hex = $bn->toHex(true);
            $hex = preg_replace('/^0+(?!$)/', '', $hex);
        } elseif (is_string($value)) {
            $value = $this->stripZero($value);
            $hex = implode('', unpack('H*', $value));
        } elseif ($value instanceof BigNumber) {
            $hex = $value->toHex(true);
            $hex = preg_replace('/^0+(?!$)/', '', $hex);
        } else {
            throw new InvalidArgumentException('The value to toHex function is not support.');
        }
        if ($isPrefix) {
            return '0x' . $hex;
        }
        return $hex;
    }

	function isNegative($value)
    {
        if (!is_string($value)) {
            throw new InvalidArgumentException('The value to isNegative function must be string.');
        }
        return (strpos($value, '-') === 0);
    }
	
	function toBn($number)
    {
        if ($number instanceof BigNumber){
            $bn = $number;
        } elseif (is_int($number)) {
            $bn = new BigNumber($number);
        } elseif (is_numeric($number)) {
            $number = (string) $number;
            if ($this->isNegative($number)) {
                $count = 1;
                $number = str_replace('-', '', $number, $count);
                $negative1 = new BigNumber(-1);
            }
            if (strpos($number, '.') > 0) {
                $comps = explode('.', $number);
                if (count($comps) > 2) {
                    throw new InvalidArgumentException('toBn number must be a valid number.');
                }
                $whole = $comps[0];
                $fraction = $comps[1];
                return [
                    new BigNumber($whole),
                    new BigNumber($fraction),
                    strlen($comps[1]),
                    isset($negative1) ? $negative1 : false
                ];
            } else {
                $bn = new BigNumber($number);
            }
            if (isset($negative1)) {
                $bn = $bn->multiply($negative1);
            }
        } elseif (is_string($number)) {
            $number = mb_strtolower($number);
            if ($this->isNegative($number)) {
                $count = 1;
                $number = str_replace('-', '', $number, $count);
                $negative1 = new BigNumber(-1);
            }
            if ($this->isZeroPrefixed($number) || preg_match('/[a-f]+/', $number) === 1) {
                $number = self::stripZero($number);
                $bn = new BigNumber($number, 16);
            } elseif (empty($number)) {
                $bn = new BigNumber(0);
            } else {
                throw new InvalidArgumentException('toBn number must be valid hex string.');
            }
            if (isset($negative1)) {
                $bn = $bn->multiply($negative1);
            }
        } else {
            throw new InvalidArgumentException('toBn number must be BigNumber, string or int.');
        }
        return $bn;
    }

}