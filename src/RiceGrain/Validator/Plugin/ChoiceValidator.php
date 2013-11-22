<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */

/**
 * @package  RiceGrain_Validator
 * @license  http://www.opensource.org/licenses/bsd-license.php  BSD License (revised)
 */

namespace RiceGrain\Validator\Plugin;

class ChoiceValidator extends Validator
{
    /**
     * @var \RiceGrain\Validator\Rule\ChoiceRule
     */
    protected $rule;

    /**
     * {@inheritDoc}
     */
    public function validate($value)
    {
        if (is_int($this->rule->getMax())) {
            if (count($value) > $this->rule->getMax()) {
                $this->setMessage($this->rule->getMaxMessage());
                return false;
            }
        }

        if (is_int($this->rule->getMin())) {
            if (count($value) < $this->rule->getMin()) {
                $this->setMessage($this->rule->getMinMessage());
                return false;
            }
        }

        return true;
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
