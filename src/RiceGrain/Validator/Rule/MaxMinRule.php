<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */

/**
 * @package  RiceGrain_Validator
 * @license  http://www.opensource.org/licenses/bsd-license.php  BSD License (revised)
 */

namespace RiceGrain\Validator\Rule;

abstract class MaxMinRule implements RuleInterface
{
    /**
     * @var integer
     */
    protected $max;

    /**
     * @var string
     */
    protected $maxMessage;

    /**
     * @var integer
     */
    protected $min;

    /**
     * @var string
     */
    protected $minMessage;

    /**
     * @param integer $max
     * @param string $maxMessage
     * @return \RiceGrain\Validator\Rule\ChoiceRule
     */
    public function setMax($max, $message = null)
    {
        $this->max = $max;
        $this->maxMessage = $message;
        return $this;
    }

    /**
     * @return integer
     */
    public function getMax()
    {
        if (is_numeric($this->max)) {
            return $this->max + 0;
        } else {
            return $this->max;
        }
    }

    /**
     * @return string
     */
    public function getMaxMessage()
    {
        return $this->maxMessage;
    }

    /**
     * @param integer $min
     * @param string $minMessage
     * @return \RiceGrain\Validator\Rule\ChoiceRule
     */
    public function setMin($min, $message = null)
    {
        $this->min = $min;
        $this->minMessage = $message;
        return $this;
    }

    /**
     * @return integer
     */
    public function getMin()
    {
        if (is_numeric($this->min)) {
            return $this->min + 0;
        } else {
            return $this->min;
        }
    }

    /**
     * @return string
     */
    public function getMinMessage()
    {
        return $this->minMessage;
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
