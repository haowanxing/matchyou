<?php
/**
 * Created by PhpStorm.
 * User: anthony
 * Date: 2019-06-03 10:23
 */
declare(strict_types=1);

namespace matchYou\Tests;


use matchYou\human\Character;
use matchYou\human\IDCard;
use PHPUnit\Framework\TestCase;

final class HumanTest extends TestCase
{
    public function testCanMatchIDCard()
    {
        $ids = [
            '430822199402260028'
        ];
        foreach ($ids as $value) {
            $one = IDCard::isIDCard2G($value);
            $this->assertTrue($one, 'ID not match:' . $value);
        }
    }

    public function testCanExportIDCardInfo()
    {
        $id = '430822199402260028';
        $info = IDCard::exportIDCardInfo($id);
        $this->assertNotFalse($info);
        var_dump($info);

        $id = '430822940226002';
        $info = IDCard::exportIDCardInfo($id);
        $this->assertNotFalse($info);
        var_dump($info);
    }

    public function testCanCheckCharacter()
    {
        $chinese = '你好';
        $english = 'Hello';
        $engNumber = 'go4you';
        $lowerChar = 'hello';
        $capitalChar = 'HELLO';
        $account = 'YouWant_me';
        $this->assertTrue(Character::isChineseOnly($chinese),"$chinese is not Chinese");
        $this->assertTrue(Character::isEnglishOnly($english));
        $this->assertTrue(Character::isEnglishNumbers($engNumber));
        $this->assertTrue(Character::isLowerLetterOnly($lowerChar));
        $this->assertTrue(Character::isCapitalLetterOnly($capitalChar));
        $this->assertTrue(Character::isGoodAccountName($account));
    }
}