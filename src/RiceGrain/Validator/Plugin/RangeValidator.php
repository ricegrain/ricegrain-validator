<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */

/**
 * @package  RiceGrain_Validator
 * @license  http://www.opensource.org/licenses/bsd-license.php  BSD License (revised)
 */

namespace RiceGrain\Validator\Plugin;

use RiceGrain\Validator\Rule\NumericRule;

class RangeValidator extends Validator
{
    /**
     * @var \RiceGrain\Validator\Rule\RangeRule
     */
    protected $rule;

    /**
     * {@inheritDoc}
     */
    public function validate($value)
    {
        if (is_array($value)) {
            for ($i = 0, $count = count($value); $i < $count; ++$i) {
                if (!$this->validate($value[$i])) {
                    return false;
                }
            }

            return true;
        }

        $numericValidator = new NumericValidator();
        $numericValidator->setRule(new NumericRule());
        if (!$numericValidator->validate($value)) {
            return false;
        }

        $min = $this->rule->getMin();
        if (is_int($min)) {
            if ($value < $min) {
                $this->setMessage($this->rule->getMinMessage());
                return false;
            }
        }

        $max = $this->rule->getMax();
        if (is_int($max)) {
            if ($value > $max) {
                $this->setMessage($this->rule->getMaxMessage());
                return false;
            }
        }

        return true;
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
