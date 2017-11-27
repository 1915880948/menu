<?php
/**
 * Created by PhpStorm.
 * User: bbover
 * Date: 2016/3/17
 * Time: 18:43
 * @desc 加密解密
 */

namespace qiqi\helper;

class CryptHelper
{
    /**
     * uuencode(发现有问题。。。不过也能用)
     * @param $str
     * @return string
     */
    static public function encode($str)
    {
        return trim(self::safeBase64Encode(convert_uuencode($str)));
    }

    /**
     * uudecode
     * @param $str
     * @return string
     */
    static public function decode($str)
    {
        return convert_uudecode(self::safeBase64Decode($str));
    }

    /** 加密
     * @param        $text
     * @param string $key
     * @return mixed|string
     */
    static public function encrypt($text, $key = '')
    {
        return self::cryptstr($text, $key, 'encrypt');
    }

    /**
     * 解密
     * @param        $text
     * @param string $key
     * @return mixed|string
     */
    static public function decrypt($text, $key = '')
    {
        return self::cryptstr($text, $key, 'decrypt');
    }

    //可变可逆加解密, e=encrypt other=decrypt

    /**
     * from discuz
     * @param string $string 原文或者密文
     * @param string $operation 操作(ENCODE | DECODE), 默认为 DECODE
     * @param string $key 密钥
     * @param int    $expiry 密文有效期, 加密时候有效， 单位 秒，0 为永久有效
     * @param int    $ckey_length 指定key的长度，用于混淆和再加密
     * @return string 处理后的 原文或者 经过 base64_encode 处理后的密文
     * @example
     * $a = authcode('abc', 'ENCODE', 'key');
     * $b = authcode($a, 'DECODE', 'key');  // $b(abc)
     * $a = authcode('abc', 'ENCODE', 'key', 3600);
     * $b = authcode('abc', 'DECODE', 'key'); // 在一个小时内，$b(abc)，否则 $b 为空
     */
    static function authcode($string, $operation = 'DECODE', $key = '', $expiry = 3600, $ckey_length = 4)
    {

        // 随机密钥长度 取值 0-32;
        // 加入随机密钥，可以令密文无任何规律，即便是原文和密钥完全相同，加密结果也会每次不同，增大破解难度。
        // 取值越大，密文变动规律越大，密文变化 = 16 的 $ckey_length 次方
        // 当此值为 0 时，则不产生随机密钥
        $key = md5($key ? $key : 'key'); //这里可以填写默认key值
        $keya = md5(substr($key, 0, 16));
        $keyb = md5(substr($key, 16, 16));
        $keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length) : substr(md5(microtime()), -$ckey_length)) : '';

        $cryptkey = $keya . md5($keya . $keyc);
        $key_length = strlen($cryptkey);

        $string = $operation == 'DECODE' ? self::safeBase64Decode(substr($string, $ckey_length))
            : sprintf('%010d', $expiry ? $expiry + time() : 0) . substr(md5($string . $keyb), 0, 16) . $string;
        $string_length = strlen($string);

        $result = '';
        $box = range(0, 255);

        $rndkey = [];
        for($i = 0; $i <= 255; $i++){
            $rndkey [$i] = ord($cryptkey [$i % $key_length]);
        }

        for($j = $i = 0; $i < 256; $i++){
            $j = ($j + $box [$i] + $rndkey [$i]) % 256;
            $tmp = $box [$i];
            $box [$i] = $box [$j];
            $box [$j] = $tmp;
        }

        for($a = $j = $i = 0; $i < $string_length; $i++){
            $a = ($a + 1) % 256;
            $j = ($j + $box [$a]) % 256;
            $tmp = $box [$a];
            $box [$a] = $box [$j];
            $box [$j] = $tmp;
            $result .= chr(ord($string [$i]) ^ ($box [($box [$a] + $box [$j]) % 256]));
        }

        if($operation == 'DECODE'){
            if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) &&
               substr($result, 10, 16) == substr(md5(substr($result, 26) . $keyb), 0, 16)){
                return substr($result, 26);
            } else{
                return '';
            }
        } else{
            return $keyc . self::safeBase64Encode($result);
        }
    }

    /**
     * xxxtea -> long2str
     * @param $v
     * @param $w
     * @return bool|string
     */
    public static function long2str($v, $w)
    {
        $len = count($v);
        $n = ($len - 1) << 2;
        if($w){
            $m = $v[$len - 1];
            if(($m < $n - 3) || ($m > $n)){
                return false;
            }
            $n = $m;
        }
        $s = [];
        for($i = 0; $i < $len; $i++){
            $s[$i] = pack("V", $v[$i]);
        }
        if($w){
            return substr(join('', $s), 0, $n);
        } else{
            return join('', $s);
        }
    }

    /**
     * xxxtea - str2long
     * @param $s
     * @param $w
     * @return array
     */
    public static function str2long($s, $w)
    {
        $v = unpack("V*", $s . str_repeat("\0", (4 - strlen($s) % 4) & 3));
        $v = array_values($v);
        if($w){
            $v[count($v)] = strlen($s);
        }

        return $v;
    }

    /**
     * xxxtea - int32
     * @param $n
     * @return int
     */
    public static function int32($n)
    {
        while($n >= 2147483648)
            $n -= 4294967296;
        while($n <= -2147483649)
            $n += 4294967296;

        return (int) $n;
    }

    /**
     * xxxtea - encrypt
     * @param $str
     * @param $key
     * @return string
     */
    public static function xxteaEncrypt($str, $key)
    {
        if($str == ""){
            return "";
        }
        $v = self::str2long($str, true);
        $k = self::str2long($key, false);
        if(count($k) < 4){
            for($i = count($k); $i < 4; $i++){
                $k[$i] = 0;
            }
        }
        $n = count($v) - 1;

        $z = $v[$n];
        $y = $v[0];
        $delta = 0x9E3779B9;
        $q = floor(6 + 52 / ($n + 1));
        $sum = 0;
        while(0 < $q--){
            $sum = self::int32($sum + $delta);
            $e = $sum >> 2 & 3;
            for($p = 0; $p < $n; $p++){
                $y = $v[$p + 1];
                $mx = self::int32((($z >> 5 & 0x07ffffff) ^ $y << 2) + (($y >> 3 & 0x1fffffff) ^ $z << 4)) ^ self::int32(($sum ^ $y) + ($k[$p & 3 ^ $e] ^ $z));
                $z = $v[$p] = self::int32($v[$p] + $mx);
            }
            $y = $v[0];
            $mx = self::int32((($z >> 5 & 0x07ffffff) ^ $y << 2) + (($y >> 3 & 0x1fffffff) ^ $z << 4)) ^ self::int32(($sum ^ $y) + ($k[$p & 3 ^ $e] ^ $z));
            $z = $v[$n] = self::int32($v[$n] + $mx);
        }

        return self::safeBase64Encode(self::long2str($v, false));
    }

    /**
     * xxxtea decrypt
     * @param $str
     * @param $key
     * @return bool|string
     */
    public static function xxteaDecrypt($str, $key)
    {
        if($str == ""){
            return "";
        }
        $str = self::safeBase64Decode($str);
        $v = self::str2long($str, false);
        $k = self::str2long($key, false);
        if(count($k) < 4){
            for($i = count($k); $i < 4; $i++){
                $k[$i] = 0;
            }
        }
        $n = count($v) - 1;

        $z = $v[$n];
        $y = $v[0];
        $delta = 0x9E3779B9;
        $q = floor(6 + 52 / ($n + 1));
        $sum = self::int32($q * $delta);
        while($sum != 0){
            $e = $sum >> 2 & 3;
            for($p = $n; $p > 0; $p--){
                $z = $v[$p - 1];
                $mx = self::int32((($z >> 5 & 0x07ffffff) ^ $y << 2) + (($y >> 3 & 0x1fffffff) ^ $z << 4)) ^ self::int32(($sum ^ $y) + ($k[$p & 3 ^ $e] ^ $z));
                $y = $v[$p] = self::int32($v[$p] - $mx);
            }
            $z = $v[$n];
            $mx = self::int32((($z >> 5 & 0x07ffffff) ^ $y << 2) + (($y >> 3 & 0x1fffffff) ^ $z << 4)) ^ self::int32(($sum ^ $y) + ($k[$p & 3 ^ $e] ^ $z));
            $y = $v[0] = self::int32($v[0] - $mx);
            $sum = self::int32($sum - $delta);
        }

        return self::long2str($v, true);
    }

    /**
     * safe base64_encode
     * @param $data
     * @return string
     */
    public static function safeBase64Encode($data)
    {
        $find = ['+', '/'];
        $replace = ['-', '_'];

        return rtrim(str_replace($find, $replace, base64_encode($data)), '=');
    }

    /**
     * safe base64_decode
     * @param $str
     * @return bool|string
     */
    public static function safeBase64Decode($str)
    {
        $find = ['-', '_'];
        $replace = ['+', '/'];

        return base64_decode(str_pad(str_replace($find, $replace, $str), strlen($str) % 4, '=', STR_PAD_RIGHT));
    }

    /**
     * other crypt
     * @param        $str
     * @param string $pid
     * @param string $type
     * @return mixed|string
     */
    static private function cryptstr($str, $pid = '', $type = 'encrypt') //$pid  PHPSESSID
    {
        //密钥
        $aEncryptkey = [
            '0' => 'VbPQdnCn4JYQM6DSIBLQ',
            '1' => 'VYPg5uB3MKYgU8WnVXew',
            '2' => 'cJbwRkBHBdNQkwDyBUeF',
            '3' => 'dYPgFhCn5bMwE4AS5Xew',
            '4' => 'YOaAVlVyMBaQc+WnUALA',
            '5' => 'NdOwZmVyMLYwE4DSIBLV',
            '6' => 'NfOQBgA3cIYAM6CCcEKA',
            '7' => '4LbVExVyNbMwI7W3RVeV',
            '8' => 'YBZ1Y2AHQOZgU8DCNQfA',
            '9' => 'cBZ1Y2UycNZVNqDyADLw',
            'a' => 'MLbQNjA3ddNQE4W3QBLQ',
            'b' => 'BfOVIyCn5dNQA5WHcGKg',
            'c' => 'QOaAVlA3cJYVVsX3BVeQ',
            'd' => '5bPQJiVCABaQgxCCdXew',
            'e' => 'IKbFQ0AHRaMgA5CCdVeQ',
            'f' => 'JaPANjBXEOZgA5XHNXe1',
            'g' => 'daPAFhBHALYwU8DyAGKl',
            'h' => '8BZ1ExViIAaFNqDSJTfw',
            'i' => 'YNaw5uC38MZFduCSYGKl',
            'j' => 'ZfOQdnViJbM1RtWnUALA',
            'k' => 'ZfOVQ0BnIAaAY/XHMIJF',
            'l' => 'MMagBgBHAKYlVsWHdXe1',
            'm' => 'ELbQVlAnZdNQY/AC8IJA',
            'n' => 'YOaABgVyMIYAU8CCcEKA',
            'o' => 'YBZwZmVCALYwY/XXJTf1',
            'p' => 'QPaQ9vAHQJYQQ9CSYIJA',
            'q' => 'QIbgFhBXFdNQkwAS4BLV',
            'r' => 'QAZgZmC39aMgc+AC8JJQ',
            's' => 'IJbwRkUycMZFVsCyRSfl',
            't' => 'YNa1U1VyMKYgY/CyQDLw',
            'u' => 'RaPFExBXENZVJrCSZTfw',
            'v' => 'UJbwdnBXFfN1NqCyQJJQ',
            'w' => 'UJbwBgBnINZQkwDiEIJA',
            'x' => 'ZdOwdnC38BaVNqX3ABLV',
            'y' => 'dfOQRkUycNZVJrCSYGKl',
            'z' => 'YNawZmAnYPZwA5CSZTfw',
            'A' => 'INawZmBXEIYAY/W3QIJA',
            'B' => 'EOaAJiB3NfNwc+AC9VeQ',
            'C' => 'ZYPgJiC38BaVJrDiFTfw',
            'D' => '4PaQZmAHRYMAI7XHNTf1',
            'E' => 'BfOQ5uViIPZwkwDiFXew',
            'F' => 'UJb1Y2BnJfNwQ9WHcEKA',
            'G' => 'cMagJiViJaMgE4CyRSfg',
            'H' => 'ZYPlExB3NbM1VsXHNTfw',
            'I' => '8LbQNjAXUOZlRtCCcFKQ',
            'J' => 'ILbQ9vUSUMZFVsAS4IJF',
            'K' => 'JfOVU1Cn4OZgkwCSZQfA',
            'L' => 'EKbAdnBHAPZwE4DCNQfA',
            'M' => '5fOQdnAnZdNVVsDiFVeV',
            'N' => 'MPaQFhBXEBaQI7CyRQfA',
            'O' => 'FcOgFhVyMOZgc+XXJUeF',
            'P' => 'RYPgBgUCRcNAE4DCNXe1',
            'Q' => 'RbPQRkAHRYMAE4WHdTfw',
            'R' => 'IBZ1U1AHRaMgU8XHMEKF',
            'S' => 'UAZgRkAXVaMgQ9WnVQfA',
            'T' => 'YAZg5uUCQBaQA5W3QEKA',
            'U' => '8Na1MzViJcNFRtCyQGKg',
            'V' => 'UNaw5uC39aMgI7X3BVeQ',
            'W' => 'VYPgBgUCQIYAU8CCdQfA',
            'X' => 'EIbgZmBnIOZgQ9CiVQfF',
            'Y' => 'JdO1ExBHBcNAM6DCMALF',
            'Z' => 'QKbA9vBnIIYAM6WHcIJA',
            '-' => '01Dd9b92F6a1E1Cb0063',
            '_' => 'aD153F8cb4C1E1707827',
            '.' => 'E0e637d93A14897dC590'
        ];

        $ret = '';
        if('encrypt' == $type){ //加密
            $str_len = strlen($str);
            if(1 > $str_len){
                return '';
            }

            //生成随机密钥，附带标记
            $key_flag = array_rand($aEncryptkey);
            $key_prefix = $aEncryptkey[$key_flag];

            $key = substr(md5($key_prefix . $pid), 10, 20);
            $key_len = strlen($key);

            for($i = 0; $i < $str_len; $i++){
                $char = substr($str, $i, 1);
                $keychar = substr($key, ($i % $key_len) - 1, 1);
                $char = chr(ord($char) + ord($keychar));
                $ret .= $char;
            }

            $ret = self::safeBase64Encode($ret);

            return $ret . $key_flag;
        } else{ //解密
            if(2 > strlen($str)){
                return '';
            }

            $key_flag = substr($str, -1);

            if(!array_key_exists($key_flag, $aEncryptkey)){
                return '';
            }

            $key_prefix = $aEncryptkey[$key_flag];

            $key = substr(md5($key_prefix . $pid), 10, 20);
            $key_len = strlen($key);

            $str = substr($str, 0, -1);
            $str = self::safeBase64Decode($str);
            if(!is_string($str) || !strlen($str)){
                return '';
            }

            $str_len = strlen($str);
            for($i = 0; $i < $str_len; $i++){
                $char = substr($str, $i, 1);
                $keychar = substr($key, ($i % $key_len) - 1, 1);
                $char = chr(ord($char) - ord($keychar));
                $ret .= $char;
            }

            return $ret;
        }
    }
}
