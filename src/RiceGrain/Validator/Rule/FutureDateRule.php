<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */

/**
 * @package  RiceGrain_Validator
 * @license  http://www.opensource.org/licenses/bsd-license.php  BSD License (revised)
 */

namespace RiceGrain\Validator\Rule;

class FutureDateRule implements RuleInterface
{
    /**
     * @var boolean
     */
    protected $allowCurrentDate = false;

    /**
     * @return \RiceGrain\Validator\Rule\FutureDateRule
     */
    public static function create()
    {
        $class = __CLASS__;
        return new $class;
    }

    /**
     * @param boolean $allowCurrentDate
     */
    public function setAllowCurrentDate($allowCurrentDate)
    {
        $this->allowCurrentDate = $allowCurrentDate;
        return $this;
    }

    /**
     * @return boolean
     */
    public function getAllowCurrentDate()
    {
        return $this->allowCurrentDate;
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
