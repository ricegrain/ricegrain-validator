<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */

/**
 * @package  RiceGrain_Validator
 * @license  http://www.opensource.org/licenses/bsd-license.php  BSD License (revised)
 */

namespace RiceGrain\Validator\Plugin;

use RiceGrain\Validator\Rule\RuleInterface;

abstract class Validator
{
    /**
     * @var \RiceGrain\Validator\Rule\Rule
     */
    protected $rule;

    /**
     * @var string
     */
    protected $message;

    /**
     * @param \RiceGrain\Validator\Rule\RuleInterface $params
     */
    public function setRule(RuleInterface $rule)
    {
        $this->rule = $rule;
    }

    /**
     * @param string $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param mixed $value
     * @return boolean
     */
    abstract public function validate($value);
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
