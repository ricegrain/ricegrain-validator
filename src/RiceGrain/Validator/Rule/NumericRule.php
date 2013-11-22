<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */

/**
 * @package  RiceGrain_Validator
 * @license  http://www.opensource.org/licenses/bsd-license.php  BSD License (revised)
 */

namespace RiceGrain\Validator\Rule;

class NumericRule implements RuleInterface
{
    /**
     * @var boolean
     */
    protected $allowFloat = false;

    /**
     * @return \RiceGrain\Validator\Rule\NumericRule
     */
    public static function create()
    {
        $class = __CLASS__;
        return new $class;
    }

    /**
     * @param boolean $allowFloat
     */
    public function setAllowFloat($allowFloat)
    {
        $this->allowFloat = $allowFloat;
    }

    /**
     * @return boolean
     */
    public function getAllowFloat()
    {
        return $this->allowFloat;
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
