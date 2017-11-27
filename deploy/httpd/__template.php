<?php
/**
 * @category template.php
 * @author   gouki <gouki.xiao@gmail.com>
 * @created 2017/5/5 10:37
 * @since
 */

$domain = 'neatstudio.com';
return [
    'nginxPort'       => 80,
    'apachePort'      => 80,
    'domainName'      => $domain,
    'adminEmail'      => 'webmaster@meilimama.cn',
    'serverIp'        => '127.0.0.1',
    'indexFile'       => 'index.php',
    'webroot'         => "/server/webroot/{$domain}/webroot",
    'otherDomain'     => '',//如果有多个domain
    /**
     * fabfile
     */
    'gateway'         => 'root@127.0.0.1',
    'gatewayHost'     => 'root@127.0.0.1:22',
    'gatewayHostPass' => '',

    'nginxHost'     => 'root@127.0.0.1:22',
    'nginxHostPass' => '',//主密码

    'apacheHost'      => 'root@127.0.0.1:2222',
    'apacheHostPass'  => '',//另一个
    /**
     * git
     */
    'gitRepositority' => "http://git.yzhan.com/gouki/{$domain}.git",
    //如果是拉分支，这里就把LS去掉，默认ls不能去，因为不能run空命令
    'gitBranch'       => 'ls',
    'localWebRoot'    => 'webroot/application',
    'localWebPort'    => '9000',
    //
    'siteName'        => '网站名',
    'cookieDomain'    => substr_count($domain, '.') > 1 ? substr($domain, strpos($domain, '.')) : $domain,
    'cookieValidKey'  => strtoupper(md5(time())),
    'appKey'          => strtoupper(md5(microtime(1))),
];
