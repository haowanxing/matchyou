<?php
/**
 * Created by PhpStorm.
 * User: anthony
 * Date: 2019-06-03 10:23
 */
declare(strict_types=1);

namespace matchYou\Tests;


use matchYou\expression\Domain;
use matchYou\expression\Email;
use matchYou\expression\IDCard;
use matchYou\expression\IPv4;
use matchYou\expression\IPv6;
use matchYou\expression\URL;
use matchYou\My;
use PHPUnit\Framework\TestCase;

final class MatcherTest extends TestCase
{
    private $content = <<<EOF
Content contains URL: "http://www.adobe.com/thanks.asp" Please click!
and http://www.google.com/go.lang-.html?a=3&b=3# like you
北京市公安局提醒您： 犯罪人如下表所示
430822199402260028 430822840216013
410822880912013,430822840216015

相关邮箱你可以看到：
smoothest@yeah.net,haowanxing@163.com,admin@imsry.cn,anthony.liu@wiwide.com.cn,find_me-in_this.room@you.will.love.me

路由器地址一般为：192.168.1.1 192.168.0.1 192.168.123.1
公网地址：59.68.31.220
完整的下一代IP地址类似于 AD80:0000:0000:0000:ABAA:0000:00C2:0002 而非完整的有 fe80::1cb8:ffff:fe9f:2e89 这样的
EOF;
    private $test = [
        'domain'=>[
            'imsry.cn',
            'www.imsry.cn',
            'p.cn',
            'find-me-12.qq.com.cn'
        ],
        'idCard' => [
            '430822199402260028',
            '430822840216013'
        ],
        'email'=>[
            'smoothest@yeah.net',
            'anthony.liu@wiwide.cn',
            '909047801@qq.com',
            'hello_world@example.com.cn',
            'find-me_in-this.room@you.will.love.in'
        ],
        'url'=>[
            'http://p.cn/0x11.jpg',
            'https://1311.online/path/to/file-name/and_you.xls',
            'fine-me.club/name_of_mine.exe',
            'https://www.baidu.com/random?=131',
            'https://google.com/gen_204?from=http://www.baidu.com'
        ],
        'ip4'=>[
            '192.168.1.1',
            '1.1.1.1',
            '255.255.255.255',
            '10.0.0.1',
            '233.5.5.5',
        ],
        'ip6'=>[
            'AD80:0000:0000:0000:ABAA:0000:00C2:0002',
            'fe80::4dc:94e9:53a8:3a36',
            'fe80::1cb8:ffff:fe9f:2e89'
        ],
    ];

    public function testCanApplyMatcher()
    {
        $a = My::matcher(Domain::class);
        foreach ($this->test['domain'] as $v){
            $this->assertTrue($a->match($v), "$v is not Domain");
        }
        $b = My::extractor(Domain::class);
        $rs = $b->extract($this->content);
        $this->assertNotEmpty($rs);
    }

    public function testCanExpIDCard()
    {
        $a = My::matcher(IDCard::class);
        foreach ($this->test['idCard'] as $v){
            $this->assertTrue($a->match($v), "$v is not IDCard");
        }
        $b = My::extractor(IDCard::class);
        $rs = $b->extract($this->content);
        $this->assertNotEmpty($rs);
    }

    public function testCanExpEmail()
    {
        $a = My::matcher(Email::class);
        foreach ($this->test['email'] as $v){
            $this->assertTrue($a->match($v), "$v is not Email");
        }
        $b = My::extractor(Email::class);
        $rs = $b->extract($this->content);
        $this->assertNotEmpty($rs);
    }

    public function testCanExpUrl()
    {
        $a = My::matcher(URL::class);
        foreach ($this->test['url'] as $v){
            $this->assertTrue($a->match($v), "$v is not Url");
        }
        $b = My::extractor(URL::class);
        $rs = $b->extract($this->content);
        $this->assertNotEmpty($rs);
    }

    public function testCanExpIPv4()
    {
        $a = My::matcher(IPv4::class);
        foreach ($this->test['ip4'] as $v){
            $this->assertTrue($a->match($v), "$v is not IPv4");
        }
        $b = My::extractor(IPv4::class);
        $rs = $b->extract($this->content);
//        var_dump($rs);
        $this->assertNotEmpty($rs);
    }

    public function testCanExpIPv6()
    {
        $a = My::matcher(IPv6::class);
        foreach ($this->test['ip6'] as $v){
            $this->assertTrue($a->match($v), "$v is not IPv6");
        }
        $b = My::extractor(IPv6::class);
        $rs = $b->extract($this->content);
        var_dump($rs);
        $this->assertNotEmpty($rs);
    }
}