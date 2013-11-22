<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */

/**
 * @package  RiceGrain_Validator
 * @license  http://www.opensource.org/licenses/bsd-license.php  BSD License (revised)
 */

namespace RiceGrain\ValidatorTest\Validation;

use RiceGrain\Validator\Rule\RegexRule;

use RiceGrain\Validation\Validation;
use RiceGrain\Validation\ValidationConfig;

class ReturnObjectValidation extends Validation
{
    public function entity()
    {
        return 'RiceGrain\ValidatorTest\Entity\ReturnObjectEntity';
    }

    public function field1()
    {
        return ValidationConfig::create()
            ->addRequired('必須入力です');
    }

    public function field2()
    {
        return ValidationConfig::create()
            ->addRequired('必須入力です');
    }

    public function field3()
    {
        return ValidationConfig::create()
            ->addRequired('必須入力です');
    }

    public function field4()
    {
        return ValidationConfig::create()
            ->addRequired('必須入力です')
            ->addRegex('dではありません', RegexRule::create()->setPattern('!^d$!'));
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
