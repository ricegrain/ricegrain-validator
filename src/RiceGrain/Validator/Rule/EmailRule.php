<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */

/**
 * @package  RiceGrain_Validator
 * @license  http://www.opensource.org/licenses/bsd-license.php  BSD License (revised)
 */

namespace RiceGrain\Validator\Rule;

class EmailRule implements RuleInterface
{
    /**
     * @var boolean
     */
    protected $allowDotBeforeAtmark = false;

    /**
     * @return \RiceGrain\Validator\Rule\EmailRule
     */
    public static function create()
    {
        $class = __CLASS__;
        return new $class;
    }

    /**
     * @param boolean $allowDotBeforeAtmark
     */
    public function setAllowDotBeforeAtmark($allowDotBeforeAtmark)
    {
        $this->allowDotBeforeAtmark = $allowDotBeforeAtmark;
        return $this;
    }

    /**
     * @return boolean
     */
    public function getAllowDotBeforeAtmark()
    {
        return $this->allowDotBeforeAtmark;
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
