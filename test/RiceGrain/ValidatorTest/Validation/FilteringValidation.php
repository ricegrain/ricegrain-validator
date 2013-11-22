<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */

/**
 * @package  RiceGrain_Validator
 * @license  http://www.opensource.org/licenses/bsd-license.php  BSD License (revised)
 */

namespace RiceGrain\ValidatorTest\Validation;

use RiceGrain\Validation\Validation;
use RiceGrain\Validation\ValidationConfig;
use RiceGrain\Validator\Request;
use RiceGrain\Validator\Rule\RegexRule;

class FilteringValidation extends Validation
{
    public function synthesizeField(Request $request)
    {
        $request->set('zipCode', sprintf('%s-%s', $request->get('zipCode1'), $request->get('zipCode2')));
    }

    public function filterAll($value)
    {
        return trim($value);
    }

    public function filterHtmlSpecialChars($name, $value)
    {
        if ($name == 'html') {
            return htmlspecialchars($value);
        } else {
            return $value;
        }
    }

    public function zipCode()
    {
        $rule = new RegexRule();

        return ValidationConfig::create()
            ->addRequired('必須入力です')
            ->addRegex('郵便番号を正しく入力して下さい', $rule->setPattern('!^[0-9]{3}-[0-9]{4}$!'));
    }

    public function zipCode1()
    {
        return ValidationConfig::create()
            ->addRequired('必須入力です');
    }

    public function zipCode2()
    {
        return ValidationConfig::create()
            ->addRequired('必須入力です');
    }

    public function html()
    {
        return ValidationConfig::create()
            ->addRequired('必須入力です');
    }

    public function trimString()
    {
        return ValidationConfig::create()
            ->addRequired('必須入力です');
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
