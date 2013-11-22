<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */

/**
 * @package  RiceGrain_Validator
 * @license  http://www.opensource.org/licenses/bsd-license.php  BSD License (revised)
 */

namespace RiceGrain\Validator\Plugin;

class NumericValidator extends Validator
{
    /**
     * @var \RiceGrain\Validator\Rule\NumericRule
     */
    protected $rule;

    /**
     * {@inheritDoc}
     */
    public function validate($value)
    {
        if (!is_numeric($value)) {
            return false;
        }

        $value += 0;

        if ($this->rule->getAllowFloat()) {
            return is_float($value);
        } else {
            return is_int($value);
        }
    }
}

/*
 * Local Variables:
 * mode: php
 * coding: iso-8859-1
 * tab-width: 4
 * c-basic-offset: 4
 * c-hanging-comment-ender-p: nil
 * indent-tabs-mode: nil
 * End:
 */
