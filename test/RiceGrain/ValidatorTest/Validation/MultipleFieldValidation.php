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
use RiceGrain\Validator\Rule\RangeRule;

class MultipleFieldValidation extends Validation
{
    public function filterField($name, $value)
    {
        if ($name == 'phone') {
            if (!$this->isEmpty($value)) {
                $this->addRequiredRemoveField('mobile_phone');
            }
        }
        if ($name == 'mobile_phone') {
            if (!$this->isEmpty($value)) {
                $this->addRequiredRemoveField('phone');
            }
        }

        return $value;
    }

    public function validateAll(Request $request)
    {
        if ($request->get('selection') == '1' && $this->isEmpty($request->get('input_text'))) {
            $this->setErrorMessage('input_text', 'selectionが1の場合はinput_textを入力してください');
        }
    }

    public function phone()
    {
        return ValidationConfig::create()
            ->addRequired('必須入力です');
    }

    public function mobile_phone()
    {
        return ValidationConfig::create()
            ->addRequired('必須入力です');
    }

    public function selection()
    {
        return ValidationConfig::create()
            ->addRequired('必須入力です')
            ->addRange('1か2を選択して下さい', RangeRule::create()->setMin(1)->setMax(2));
    }

    public function input_text()
    {
        return ValidationConfig::create();
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
