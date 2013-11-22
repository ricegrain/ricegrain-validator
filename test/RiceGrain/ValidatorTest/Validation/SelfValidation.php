<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */

/**
 * @package  RiceGrain_Validator
 * @license  http://www.opensource.org/licenses/bsd-license.php  BSD License (revised)
 */

namespace RiceGrain\ValidatorTest\Validation;

use RiceGrain\Validation\Validation;
use RiceGrain\Validation\ValidationConfig;

class SelfValidation extends Validation
{
    public function selfvalidator_value()
    {
        return ValidationConfig::create()
            ->addRequired('必須入力です')
            ->addValidator('RiceGrain\ValidatorTest\Validator\SelfValidator', 'エラーです');
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
