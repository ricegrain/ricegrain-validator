<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */

/**
 * @package  RiceGrain_Validator
 * @license  http://www.opensource.org/licenses/bsd-license.php  BSD License (revised)
 */

namespace RiceGrain\Validator\Plugin;

class RegexValidator extends Validator
{
    /**
     * @var \RiceGrain\Validator\Rule\RegexRule
     */
    protected $rule;

    /**
     * {@inheritDoc}
     */
    public function validate($value)
    {
        $pattern = $this->rule->getPattern();
        if (!is_null($pattern)) {
            return (boolean)preg_match($pattern, $value);
        }

        return false;
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
