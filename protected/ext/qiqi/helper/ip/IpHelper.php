<?php
/**
 * @category IpHelper
 * @author   gouki <gouki.xiao@gmail.com>
 * @created  8/17/15 13:51
 * @since
 */
namespace qiqi\helper\ip;

/**
 * Class IpHelper
 *
 * @package common\helper
 */
class IpHelper
{
    /**
     * 返回0.0.0.0时代表IP是未知的
     *
     * @return mixed|string
     */
    public static function getRealIP()
    {
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARDED_FOR'] != '') {
            $client_ip = ( !empty($_SERVER['REMOTE_ADDR'])) ? $_SERVER['REMOTE_ADDR']
                : (( !empty($_ENV['REMOTE_ADDR'])) ? $_ENV['REMOTE_ADDR'] : "0.0.0.0");
            $entries = preg_split('[, ]', $_SERVER['HTTP_X_FORWARDED_FOR']);
            reset($entries);
            while (list(, $entry) = each($entries)) {
                $entry = trim($entry);
                if (preg_match("/^([0-9]+\.[0-9]+\.[0-9]+\.[0-9]+)/", $entry, $ip_list)) {
                    // http://www.faqs.org/rfcs/rfc1918.html
                    $private_ip = array(
                        '/^0\./',
                        '/^127\.0\.0\.1/',
                        '/^192\.168\..*/',
                        '/^172\.((1[6-9])|(2[0-9])|(3[0-1]))\..*/',
                        '/^10\..*/',
                    );
                    $found_ip = preg_replace($private_ip, $client_ip, $ip_list[1]);
                    if ($client_ip != $found_ip) {
                        $client_ip = $found_ip;
                        break;
                    }
                }
            }
        } else {
            $client_ip = ( !empty($_SERVER['REMOTE_ADDR'])) ? $_SERVER['REMOTE_ADDR']
                : (( !empty($_ENV['REMOTE_ADDR'])) ? $_ENV['REMOTE_ADDR'] : "0.0.0.0");
        }
        if(strpos($client_ip,'::1') !== false){
            $client_ip = '127.0.0.1';
        }
        return $client_ip;
    }
}
