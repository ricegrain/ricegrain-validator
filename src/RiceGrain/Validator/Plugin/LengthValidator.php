<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */

/**
 * @package  RiceGrain_Validator
 * @license  http://www.opensource.org/licenses/bsd-license.php  BSD License (revised)
 */

namespace RiceGrain\Validator\Plugin;

class LengthValidator extends Validator
{
    /**
     * @var \RiceGrain\Validator\Rule\LengthRule
     */
    protected $rule;

    /**
     * {@inheritDoc}
     */
    public function validate($value)
    {
        $length = strlen($value);

        $min = $this->rule->getMin();
        if (is_int($min)) {
            if ($length < $min) {
                $this->setMessage($this->rule->getMinMessage());
                return false;
            }
        }

        $max = $this->rule->getMax();
        if (is_int($max)) {
            if ($length > $max) {
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
