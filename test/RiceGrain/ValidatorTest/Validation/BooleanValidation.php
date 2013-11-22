<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */

/**
 * @package  RiceGrain_Validator
 * @license  http://www.opensource.org/licenses/bsd-license.php  BSD License (revised)
 */

namespace RiceGrain\ValidatorTest\Validation;

use RiceGrain\Validation\Validation;
use RiceGrain\Validation\ValidationConfig;

class BooleanValidation extends Validation
{
    public function gendor()
    {
        return ValidationConfig::create()
            ->addRequired('必須入力です')
            ->addBoolean('boolean型ではありません');
    }

    public function married()
    {
        return ValidationConfig::create()
            ->addRequired('必須入力です')
            ->addBoolean('boolean型ではありません');
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
