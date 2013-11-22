<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */

/**
 * @package  RiceGrain_Validator
 * @license  http://www.opensource.org/licenses/bsd-license.php  BSD License (revised)
 */

namespace RiceGrain\ValidatorTest\Validation;

use RiceGrain\Validation\Validation;
use RiceGrain\Validation\ValidationConfig;
use RiceGrain\Validator\Rule\LengthRule;

class LengthValidation extends Validation
{
    public function string_value()
    {
        return ValidationConfig::create()
            ->addRequired('必須入力です')
            ->addLength('文字数が不正です', LengthRule::create()->setMax(5, '5バイト以内で入力して下さい')->setMin(2, '2バイト以上で入力して下さい'));
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
