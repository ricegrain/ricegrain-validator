<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */

/**
 * @package  RiceGrain_Validator
 * @license  http://www.opensource.org/licenses/bsd-license.php  BSD License (revised)
 */

namespace RiceGrain\ValidatorTest\Validation;

use RiceGrain\Validation\Validation;
use RiceGrain\Validation\ValidationConfig;
use RiceGrain\Validator\Rule\ChoiceRule;

class ChoiceValidation extends Validation
{
    public function gendor()
    {
        return ValidationConfig::create()
            ->addRequired('必須入力です')
            ->addChoice('1つ以下で選択して下さい', ChoiceRule::create()->setMax(1, '1つ以上選択して下さい')->setMin(0));
    }

    public function married()
    {
        $rule = new ChoiceRule();

        return ValidationConfig::create()
            ->addRequired('必須入力です')
            ->addChoice('2つ以上3つ以下で選択して下さい', ChoiceRule::create()->setMax(3, '3つ以下で選択して下さい')->setMin(2, '2つ以上選択して下さい'));
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
