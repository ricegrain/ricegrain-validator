<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */

/**
 * @package  RiceGrain_Validator
 * @license  http://www.opensource.org/licenses/bsd-license.php  BSD License (revised)
 */

namespace RiceGrain;

use RiceGrain\ValidatorTest\Validation\BooleanValidation;
use RiceGrain\ValidatorTest\Validation\ChoiceValidation;
use RiceGrain\ValidatorTest\Validation\EmailValidation;
use RiceGrain\ValidatorTest\Validation\ExternalValueUsageValidation;
use RiceGrain\ValidatorTest\Validation\FileValidation;
use RiceGrain\ValidatorTest\Validation\FilteringValidation;
use RiceGrain\ValidatorTest\Validation\FutureDateValidation;
use RiceGrain\ValidatorTest\Validation\LengthValidation;
use RiceGrain\ValidatorTest\Validation\MbLengthValidation;
use RiceGrain\ValidatorTest\Validation\MultipleFieldValidation;
use RiceGrain\ValidatorTest\Validation\NumericValidation;
use RiceGrain\ValidatorTest\Validation\PastDateValidation;
use RiceGrain\ValidatorTest\Validation\RangeValidation;
use RiceGrain\ValidatorTest\Validation\RegexValidation;
use RiceGrain\ValidatorTest\Validation\ReturnObjectValidation;
use RiceGrain\ValidatorTest\Validation\SelfValidation;
use RiceGrain\Validator\Rule\ChoiceRule;

class ValidatorTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $_REQUEST = array();
        $_FILES = array();
    }

    /**
     * @test
     */
    public function booleanのテストをする()
    {
        $_REQUEST['gendor'] = true;
        $_REQUEST['married'] = false;

        $validator = new Validator();
        $result = $validator->validate(new BooleanValidation());

        $this->assertEquals(true, $result, var_export($validator->getErrors(), true));
        $this->assertEquals(0, count($validator->getErrors()));
        $this->assertTrue(array_key_exists('gendor', $validator->getResult()));
        $this->assertTrue(array_key_exists('married', $validator->getResult()));
        $this->assertTrue(array_key_exists('gendor', $validator->getResult(Validator::RESULT_SUCCESS_ONLY)));
        $this->assertTrue(array_key_exists('married', $validator->getResult(Validator::RESULT_SUCCESS_ONLY)));
    }

    /**
     * @test
     */
    public function booleanのテストをする2()
    {
        $request = array(
            'gendor' => true,
            'married' => false,
        );

        $validator = new Validator();
        $result = $validator->validate(new BooleanValidation(), $request);

        $this->assertEquals(true, $result, var_export($validator->getErrors(), true));
        $this->assertEquals(0, count($validator->getErrors()));
        $this->assertTrue(array_key_exists('gendor', $validator->getResult()));
        $this->assertTrue(array_key_exists('married', $validator->getResult()));
        $this->assertTrue(array_key_exists('gendor', $validator->getResult(Validator::RESULT_SUCCESS_ONLY)));
        $this->assertTrue(array_key_exists('married', $validator->getResult(Validator::RESULT_SUCCESS_ONLY)));
    }

    /**
     * @test
     */
    public function booleanのテストをする3()
    {
        $_REQUEST['gendor'] = true;
        $_REQUEST['married'] = null;

        $validator = new Validator();
        $result = $validator->validate(new BooleanValidation());

        $this->assertEquals(false, $result, var_export($validator->getErrors(), true));
        $this->assertEquals(1, count($validator->getErrors()));
        $this->assertTrue(array_key_exists('gendor', $validator->getResult()));
        $this->assertTrue(array_key_exists('married', $validator->getResult()));
        $this->assertTrue(array_key_exists('gendor', $validator->getResult(Validator::RESULT_SUCCESS_ONLY)));
        $this->assertFalse(array_key_exists('married', $validator->getResult(Validator::RESULT_SUCCESS_ONLY)));
    }


    /**
     * @test
     */
    public function choiceのテストをする()
    {
        $_REQUEST['gendor'] = array(1);
        $_REQUEST['married'] = array(0, 1);

        $validator = new Validator();
        $result = $validator->validate(new ChoiceValidation());

        $this->assertEquals(true, $result, var_export($validator->getErrors(), true));
        $this->assertEquals(0, count($validator->getErrors()));
        $this->assertTrue(array_key_exists('gendor', $validator->getResult()));
        $this->assertTrue(array_key_exists('married', $validator->getResult()));
        $this->assertTrue(array_key_exists('gendor', $validator->getResult(Validator::RESULT_SUCCESS_ONLY)));
        $this->assertTrue(array_key_exists('married', $validator->getResult(Validator::RESULT_SUCCESS_ONLY)));
    }

    /**
     * @test
     */
    public function choiceのテストをする2()
    {
        $_REQUEST['gendor'] = array(2);
        $_REQUEST['married'] = array(0);

        $validator = new Validator();
        $result = $validator->validate(new ChoiceValidation());

        $this->assertEquals(false, $result, var_export($validator->getErrors(), true));
        $this->assertEquals(1, count($validator->getErrors()));
        $this->assertTrue(array_key_exists('gendor', $validator->getResult()));
        $this->assertTrue(array_key_exists('married', $validator->getResult()));
        $this->assertTrue(array_key_exists('gendor', $validator->getResult(Validator::RESULT_SUCCESS_ONLY)));
        $this->assertFalse(array_key_exists('married', $validator->getResult(Validator::RESULT_SUCCESS_ONLY)));
    }

    /**
     * @test
     */
    public function emailのテストをする()
    {
        $_REQUEST['email'] = 'hoge@example.com';

        $validator = new Validator();
        $result = $validator->validate(new EmailValidation());

        $this->assertEquals(true, $result, var_export($validator->getErrors(), true));
        $this->assertEquals(0, count($validator->getErrors()));
    }

    /**
     * @test
     */
    public function fileのテストをする()
    {
        $_FILES['file']['name'] = 'C:\\User\\Desktop\\test.csv';
        $_FILES['file']['type'] = 'text/csv';
        $_FILES['file']['size'] = '12';
        $_FILES['file']['tmp_name'] = 'file1.txt';
        $_FILES['file']['error'] = UPLOAD_ERR_OK;

        $validator = new Validator();
        $result = $validator->validate(new FileValidation());

        $this->assertEquals(true, $result, var_export($validator->getErrors(), true));
        $this->assertEquals(0, count($validator->getErrors()));
    }

    /**
     * @test
     */
    public function fileでサイズが制限を超えた場合にエラーになる()
    {
        $_FILES['file']['name'] = 'C:\\User\\Desktop\\test.csv';
        $_FILES['file']['type'] = 'text/csv';
        $_FILES['file']['size'] = '12345';
        $_FILES['file']['tmp_name'] = 'file1.txt';
        $_FILES['file']['error'] = UPLOAD_ERR_OK;

        $validator = new Validator();
        $result = $validator->validate(new FileValidation());

        $errors = $validator->getErrors();

        $this->assertEquals(false, $result, var_export($validator->getErrors(), true));
        $this->assertEquals(1, count($errors));
        $this->assertEquals('100バイト以上のファイルです', $errors['file']);
    }

    public function futuredate日付と結果()
    {
        $yesterday = date('Y-m-d', strtotime('-1 day'));
        $today = date('Y-m-d');
        $tomorrow = date('Y-m-d', strtotime('+1 day'));

        return array(
            array($yesterday, false, 1),
            array($today,     true,  0),
            array($tomorrow,  true,  0),
        );
    }

    /**
     * @test
     * @dataProvider futuredate日付と結果
     */
    public function futruedateで未来日付をチェックする($date, $expectedResult, $expectedErrorCount)
    {
        $_REQUEST['date'] = $date;

        $validator = new Validator();
        $result = $validator->validate(new FutureDateValidation());

        $this->assertEquals($expectedResult, $result, var_export($validator->getErrors(), true));
        $this->assertEquals($expectedErrorCount, count($validator->getErrors()));
    }

    public function pastdate日付と結果()
    {
        $yesterday = date('Y-m-d', strtotime('-1 day'));
        $today = date('Y-m-d');
        $tomorrow = date('Y-m-d', strtotime('+1 day'));

        return array(
            array($yesterday, true,  0),
            array($today,     true,  0),
            array($tomorrow,  false, 1),
        );
    }

    /**
     * @test
     * @dataProvider pastdate日付と結果
     */
    public function pastdateで未来日付をチェックする($date, $expectedResult, $expectedErrorCount)
    {
        $_REQUEST['date'] = $date;

        $validator = new Validator();
        $result = $validator->validate(new PastDateValidation());

        $this->assertEquals($expectedResult, $result, var_export($validator->getErrors(), true));
        $this->assertEquals($expectedErrorCount, count($validator->getErrors()));
    }

    public function 文字列と結果()
    {
        return array(
            array('a',      false, 1),
            array('ab',     true,  0),
            array('abc',    true,  0),
            array('abcd',   true,  0),
            array('abcde',  true,  0),
            array('abcdef', false, 1),
        );
    }

    /**
     * @test
     * @dataProvider 文字列と結果
     */
    public function lengthで文字数をチェックする($stringValue, $expectedResult, $expectedErrorCount)
    {
        $_REQUEST['string_value'] = $stringValue;

        $validator = new Validator();
        $result = $validator->validate(new LengthValidation());

        $this->assertEquals($expectedResult, $result, var_export($validator->getErrors(), true));
        $this->assertEquals($expectedErrorCount, count($validator->getErrors()));
    }

    public function マルチバイト文字列と結果()
    {
        return array(
            array('あ',          false, 1),
            array('あい',        true,  0),
            array('あいう',       true,  0),
            array('あいうえ',      true,  0),
            array('あいうえお',     true,  0),
            array('あいうえおか',    false, 1),
        );
    }

    /**
     * @test
     * @dataProvider マルチバイト文字列と結果
     */
    public function mblengthでマルチバイト文字数をチェックする($stringValue, $expectedResult, $expectedErrorCount)
    {
        $_REQUEST['string_value'] = $stringValue;

        $validator = new Validator();
        $result = $validator->validate(new MbLengthValidation());

        $this->assertEquals($expectedResult, $result, var_export($validator->getErrors(), true));
        $this->assertEquals($expectedErrorCount, count($validator->getErrors()));
    }

    public function 数値と結果()
    {
        return array(
            array('あ',   false, 1),
            array('12',   true,  0),
            array(12,     true,  0),
            array(0,      true,  0),
            array(null,   false, 1),
            array(true,   false, 1),
            array(false,  false, 1),
        );
    }

    /**
     * @test
     * @dataProvider 数値と結果
     */
    public function numericで数値かどうかをチェックする($numericValue, $expectedResult, $expectedErrorCount)
    {
        $_REQUEST['numeric_value'] = $numericValue;

        $validator = new Validator();
        $result = $validator->validate(new NumericValidation());

        $this->assertEquals($expectedResult, $result, var_export($validator->getErrors(), true));
        $this->assertEquals($expectedErrorCount, count($validator->getErrors()));
    }

    public function 数値と結果2()
    {
        return array(
            array(1,  false, 1),
            array(2,  true,  0),
            array(3,  true,  0),
            array(4,  true,  0),
            array(5,  true,  0),
            array(6,  false, 1),
        );
    }

    /**
     * @test
     * @dataProvider 数値と結果2
     */
    public function rangeで数値の閾値をチェックする($numericValue, $expectedResult, $expectedErrorCount)
    {
        $_REQUEST['numeric_value'] = $numericValue;

        $validator = new Validator();
        $result = $validator->validate(new RangeValidation());

        $this->assertEquals($expectedResult, $result, var_export($validator->getErrors(), true));
        $this->assertEquals($expectedErrorCount, count($validator->getErrors()));
    }

    public function 不規則文字列と結果()
    {
        return array(
            array('abc01',  true,  0),
            array('',       false, 1),
            array(null,     false, 1),
            array(true,     false, 1),
            array(false,    false, 1),
            array(1,        false, 1),
            array('aa',     false, 1),
            array('123456', false, 1),
        );
    }

    /**
     * @test
     * @dataProvider 不規則文字列と結果
     */
    public function regexで正規表現をチェックする($stringValue, $expectedResult, $expectedErrorCount)
    {
        $_REQUEST['string_value'] = $stringValue;

        $validator = new Validator();
        $result = $validator->validate(new RegexValidation());

        $this->assertEquals($expectedResult, $result, var_export($validator->getErrors(), true));
        $this->assertEquals($expectedErrorCount, count($validator->getErrors()));
    }

    public function 電話番号２つと結果()
    {
        return array(
            array('012345678', '090123456', true,  0),
            array('012345678', '',          true,  0),
            array('',          '090123456', true,  0),
            array('',          '',          false, 2),
        );
    }

    /**
     * @test
     * @dataProvider 電話番号２つと結果
     */
    public function どちらか一方の入力が必要なバリデーションをチェックする($phone, $mobilePhone, $expectedResult, $expectedErrorCount)
    {
        $_REQUEST['phone'] = $phone;
        $_REQUEST['mobile_phone'] = $mobilePhone;
        $_REQUEST['selection'] = '2';
        $_REQUEST['input_text'] = null;

        $validator = new Validator();
        $result = $validator->validate(new MultipleFieldValidation());

        $this->assertEquals($expectedResult, $result, var_export($validator->getErrors(), true));
        $this->assertEquals($expectedErrorCount, count($validator->getErrors()), var_export($validator->getErrors(), true));
    }

    /**
     * @test
     */
    public function validateAllを使ったバリデーションをチェックする()
    {
        $_REQUEST['phone'] = '0612345678';
        $_REQUEST['mobile_phone'] = '';
        $_REQUEST['selection'] = '1';
        $_REQUEST['input_text'] = null;

        $validator = new Validator();
        $result = $validator->validate(new MultipleFieldValidation());

        $this->assertFalse($result);
    }

    /**
     * @test
     */
    public function フィルタリング()
    {
        $_REQUEST['html'] = '<font color="red">hoge</font>';
        $_REQUEST['zipCode1'] = '123';
        $_REQUEST['zipCode2'] = '4567';
        $_REQUEST['trimString'] = ' abcd efgh ';

        $validator = new Validator();
        $result = $validator->validate(new FilteringValidation());

        $resultValue = $validator->getResult(Validator::RESULT_SUCCESS_ONLY);

        $this->assertTrue($result, var_export($validator->getErrors(), true));
        $this->assertEquals(
            htmlspecialchars('<font color="red">hoge</font>'),
            $resultValue['html']
        );
        $this->assertEquals('123-4567', $resultValue['zipCode']);
        $this->assertEquals('123', $resultValue['zipCode1']);
        $this->assertEquals('4567', $resultValue['zipCode2']);
        $this->assertEquals('abcd efgh', $resultValue['trimString']);
    }

    /**
     * @test
     */
    public function 自作のバリデーションを実施する()
    {
        $_REQUEST['selfvalidator_value'] = 'hoge';

        $validator = new Validator();
        $result = $validator->validate(new SelfValidation());

        $resultValue = $validator->getResult(Validator::RESULT_SUCCESS_ONLY);

        $this->assertTrue($result, var_export($validator->getErrors(), true));
    }

    /**
     * @test
     */
    public function バリデーション後の値をオブジェクトで取得する()
    {
        $_REQUEST['field1'] = 'a';
        $_REQUEST['field2'] = 'b';
        $_REQUEST['field3'] = 'c';
        $_REQUEST['field4'] = '0';

        $validator = new Validator();
        $result = $validator->validate(new ReturnObjectValidation());

        $resultValue = $validator->getResult();
        $resultSuccessValue = $validator->getResult(Validator::RESULT_SUCCESS_ONLY);

        $this->assertInstanceOf('RiceGrain\ValidatorTest\Entity\ReturnObjectEntity', $resultValue);
        $this->assertInstanceOf('RiceGrain\ValidatorTest\Entity\ReturnObjectEntity', $resultSuccessValue);

        $this->assertEquals('a', $resultValue->getField1());
        $this->assertEquals('b', $resultValue->getField2());
        $this->assertNull($resultValue->getField3());
        $this->assertEquals('0', $resultValue->getField4());

        $this->assertEquals('a', $resultSuccessValue->getField1());
        $this->assertEquals('b', $resultSuccessValue->getField2());
        $this->assertNull($resultSuccessValue->getField3());
        $this->assertNull($resultSuccessValue->getField4());
    }

    public function 外部からの値()
    {
        return array(
            array('123456', true,  0),
            array('12345',  false, 1),
        );
    }

    /**
     * @test
     * @dataProvider 外部からの値
     */
    public function 外部からの値とをチェックする($externalValue, $expectedResult, $expectedErrorCount)
    {
        $_REQUEST['string_value'] = '123456';

        $options = array('regexString' => $externalValue);

        $validator = new Validator();
        $result = $validator->validate(new ExternalValueUsageValidation($options));

        $this->assertEquals($expectedResult, $result, var_export($validator->getErrors(), true));
        $this->assertEquals($expectedErrorCount, count($validator->getErrors()));
    }
}

/*
 * Local Variables:
 * mode: php
 * coding: utf-8
 * tab-width: 4
 * c-basic-offset: 4
 * c-hanging-comment-ender-p: nil
 * indent-tabs-mode: nil
 * End:
 */
