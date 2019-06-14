<?php
/**
 * Created by PhpStorm.
 * User: anthony
 * Date: 2019-06-03 10:23
 */
declare(strict_types=1);

namespace matchYou\Tests;


use matchYou\expression\Chinese;
use matchYou\expression\Domain;
use matchYou\expression\Email;
use matchYou\expression\IDCard;
use matchYou\expression\IPv4;
use matchYou\expression\IPv6;
use matchYou\expression\MobilePhone;
use matchYou\expression\Telephone;
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
完整的下一代IP地址类似于 AD80:0000:0000:0000:ABAA:0000:00C2:0002 而非完整的有 fe80::1cb8:ffff:fe9f:2e89 这样的不匹配

Please tell us: +86 18907657877,+86-13109450099,013177886666

联系我们 400-672-8166 support@dahuatech.com 杭州市滨江区滨安路1199号
办公室：　管丹　柳斌　　办公电话：027-67842525（传真）、027-67843843
理论教育科：　余凤（主任科员）　蓝永丽　杨科　　办公电话：027-67843126
网络新媒体宣传科：　刘虹　　办公电话：67843845
校报编辑部：　黄宗贵（四级职员）　刘琼（科长）　陈鹏冰　冯珊珊　　办公电话：027-67843799、027-67842546
010-62151599,400-6500-311
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
        'mobile'=>[
            '13308768888',
            '13189798978',
            '13576598789',
            '14490987787',
            '15109988976',
            '17788779900',
            '18908763421',
            '19108443231',
            '+86-15576889999',
            '8613344445555',
            '+86 13454545432'
        ],
        'telephone'=>[
          '010-66776767',
          '0744-6226037',
          '021-56115566-3',
          '027-61897876',
          '0399-889912345'
        ],
        'chinese'=>[
            '你好',
            '不管这些是啥子饕餮踽踽独行醍醐灌顶'
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
//        var_dump($rs);
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
        $this->assertNotEmpty($rs);
    }

    public function testCanExpMobile()
    {
        $a = My::matcher(MobilePhone::class);
        foreach ($this->test['mobile'] as $v){
            $this->assertTrue($a->match($v), "$v is not MobilePhone");
        }
        $b = My::extractor(MobilePhone::class);
        $rs = $b->extract($this->content);
        $this->assertNotEmpty($rs);
    }

    public function testCanExpTelephone()
    {
        $a = My::matcher(Telephone::class);
        foreach ($this->test['telephone'] as $v){
            $this->assertTrue($a->match($v), "$v is not Telephone");
        }
        $b = My::extractor(Telephone::class);
        $rs = $b->extract($this->content);
//        var_dump($rs);
        $this->assertNotEmpty($rs);
    }

    public function testCanExpChinese()
    {
        $a = My::matcher(Chinese::class);
        foreach ($this->test['chinese'] as $v){
            $this->assertTrue($a->match($v), "$v is not Chinese");
        }
        $b = My::extractor(Chinese::class);
        $rs = $b->extract($this->content);
//        var_dump($rs);
        $this->assertNotEmpty($rs);
    }
}