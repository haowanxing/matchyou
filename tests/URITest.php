<?php
/**
 * Created by PhpStorm.
 * User: anthony
 * Date: 2019-06-03 10:23
 */
declare(strict_types=1);

namespace matchYou\Tests;


use matchYou\net\URI;
use PHPUnit\Framework\TestCase;

final class URITest extends TestCase
{
    public function testCanMatchDomain()
    {
        $domains = [
            'imsry.cn',
            'www.imsry.cn',
            'p.cn',
            'find-me-12.qq.com.cn'
        ];
        foreach ($domains as $value) {
            $one = URI::isDomain($value);
            $this->assertTrue($one, 'Domain not match:' . $value);
        }
    }

    public function testCanMatchURL()
    {
        $urls = [
            'http://p.cn/0x11.jpg',
            'https://1311.online/path/to/file-name/and_you.xls',
            'fine-me.club/name_of_mine.exe'
        ];
        foreach ($urls as $url) {
            $one = URI::isUrl($url);
            $this->assertTrue($one, 'URL not match:' . $url);
        }
        $https = [
            'https://www.baidu.com/random?=131',
            'https://google.com/gen_204?from=http://www.baidu.com'
        ];
        $http = [
            'http://www.baidu.com/random?=131',
            'http://google.com/gen_204?from=http://www.baidu.com'
        ];
        $ftp = [
            'ftp://admin:1234@10.10.10.10',
            'ftp://admin:1234@10.10.10.10/profile',
            'ftp://admin:@10.10.10.10',
            'ftp://admin:1234@abc.com.cn',
            'ftp://abc.com.cn/private',
            'ftp://abc.com.cn:21/private',
            'ftp://admin:1234@10.10.10.10:383/profile',
        ];
        foreach ($https as $url) {
            $one = URI::isHttpsUrl($url);
            $this->assertTrue($one, 'HttpsURL not match:' . $url);
            $two = URI::isHttpUrl($url);
            $this->assertFalse($two, 'HttpsURL match:' . $url);
        }
        foreach ($http as $url) {
            $one = URI::isHttpUrl($url);
            $this->assertTrue($one, 'HttpURL not match:' . $url);
            $two = URI::isHttpsUrl($url);
            $this->assertFalse($two, 'HttpURL match:' . $url);
        }
        foreach ($ftp as $url) {
            $one = URI::isFtpUrl($url);
            $this->assertTrue($one, 'FtpURL not match:' . $url);
            $two = URI::isHttpUrl($url);
            $this->assertFalse($two, 'HttpURL match:' . $url);
            $two = URI::isHttpsUrl($url);
            $this->assertFalse($two, 'HttpsURL match:' . $url);
        }
    }

    public function testCanMatchIP()
    {
        $ipv4s = [
            '192.168.1.1',
            '1.1.1.1',
            '255.255.255.255',
            '10.0.0.1',
            '233.5.5.5',
        ];
        foreach ($ipv4s as $ip) {
            $one = URI::isIpv4($ip);
            $this->assertTrue($one, 'IPv4 not match:' . $ip);
        }
        $this->assertFalse(URI::isIpv4('256.255.255.255'), 'IP check err');
        $ipv6s = [
            'AD80:0000:0000:0000:ABAA:0000:00C2:0002',
            'fe80::4dc:94e9:53a8:3a36',
            'fe80::1cb8:ffff:fe9f:2e89'
        ];
        foreach ($ipv6s as $ip) {
            $one = URI::isIpv6($ip);
            $this->assertTrue($one, 'IPv6 not match:' . $ip);
        }
    }
}