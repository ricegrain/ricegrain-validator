<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */

/**
 * @package  RiceGrain_Validator
 * @license  http://www.opensource.org/licenses/bsd-license.php  BSD License (revised)
 */

namespace RiceGrain\Validation;

use RiceGrain\Validator\Rule\ChoiceRule;
use RiceGrain\Validator\Rule\EmailRule;
use RiceGrain\Validator\Rule\FileRule;
use RiceGrain\Validator\Rule\FutureDateRule;
use RiceGrain\Validator\Rule\LengthRule;
use RiceGrain\Validator\Rule\MbLengthRule;
use RiceGrain\Validator\Rule\NumericRule;
use RiceGrain\Validator\Rule\PastDateRule;
use RiceGrain\Validator\Rule\RangeRule;
use RiceGrain\Validator\Rule\RegexRule;
use RiceGrain\Validator\Rule\RuleInterface;

class ValidationConfig
{
    /**
     * @var array
     */
    protected $config = array();

    /**
     * @return \RiceGrain\Validation\ValidationConfig
     */
    public static function create()
    {
        return new self;
    }

    /**
     * @return array
     */
    public function getConfigs()
    {
        return $this->config;
    }

    /**
     * @param string $message
     * @return \RiceGrain\Validation\ValidationConfig
     */
    public function addRequired($message)
    {
        return $this->addValidator('Required', $message);
    }

    /**
     * @param string $message
     * @return \RiceGrain\Validation\ValidationConfig
     */
    public function addBoolean($message)
    {
        return $this->addValidator('Boolean', $message);
    }

    /**
     * @param string $message
     * @param \RiceGrain\Validator\Rule\ChoiceRule $rule
     * @return \RiceGrain\Validation\ValidationConfig
     */
    public function addChoice($message, ChoiceRule $rule = null)
    {
        return $this->addValidator('Choice', $message, $rule);
    }

    /**
     * @param string $message
     * @param \RiceGrain\Validator\Rule\EmailRule $rule
     * @return \RiceGrain\Validation\ValidationConfig
     */
    public function addEmail($message, EmailRule $rule = null)
    {
        return $this->addValidator('Email', $message, $rule);
    }

    /**
     * @param string $message
     * @param \RiceGrain\Validator\Rule\FileRule $rule
     * @return \RiceGrain\Validation\ValidationConfig
     */
    public function addFile($message, FileRule $rule = null)
    {
        return $this->addValidator('File', $message, $rule);
    }

    /**
     * @param string $message
     * @param \RiceGrain\Validator\Rule\FutureDateRule $rule
     * @return \RiceGrain\Validation\ValidationConfig
     */
    public function addFutureDate($message, FutureDateRule $rule = null)
    {
        return $this->addValidator('FutureDate', $message, $rule);
    }

    /**
     * @param string $message
     * @param \RiceGrain\Validator\Rule\pastDateRule $rule
     * @return \RiceGrain\Validation\ValidationConfig
     */
    public function addPastDate($message, PastDateRule $rule = null)
    {
        return $this->addValidator('PastDate', $message, $rule);
    }

    /**
     * @param string $message
     * @param \RiceGrain\Validator\Rule\LengthRule $rule
     * @return \RiceGrain\Validation\ValidationConfig
     */
    public function addLength($message, LengthRule $rule = null)
    {
        return $this->addValidator('Length', $message, $rule);
    }

    /**
     * @param string $message
     * @param \RiceGrain\Validator\Rule\MbLengthRule $rule
     * @return \RiceGrain\Validation\ValidationConfig
     */
    public function addMbLength($message, MbLengthRule $rule = null)
    {
        return $this->addValidator('MbLength', $message, $rule);
    }

    /**
     * @param string $message
     * @param \RiceGrain\Validator\Rule\NumericRule $rule
     * @return \RiceGrain\Validation\ValidationConfig
     */
    public function addNumeric($message, NumericRule $rule = null)
    {
        return $this->addValidator('Numeric', $message, $rule);
    }

    /**
     * @param string $message
     * @param \RiceGrain\Validator\Rule\RangeRule $rule
     * @return \RiceGrain\Validation\ValidationConfig
     */
    public function addRange($message, RangeRule $rule = null)
    {
        return $this->addValidator('Range', $message, $rule);
    }

    /**
     * @param string $message
     * @param \RiceGrain\Validator\Rule\RegexRule $rule
     * @return \RiceGrain\Validation\ValidationConfig
     */
    public function addRegex($message, RegexRule $rule = null)
    {
        return $this->addValidator('Regex', $message, $rule);
    }

    /**
     * @param string $name
     * @param string $message
     * @param \RiceGrain\Validator\Rule\RuleInterface $rule
     * @return \RiceGrain\Validation\ValidationConfig
     */
    public function addValidator($name, $message, RuleInterface $rule = null)
    {
        $this->config[$name]['message'] = $message;

        if (!is_null($rule)) {
            $this->config[$name]['rule'] = $rule;
        } else {
            $className = 'RiceGrain\\Validator\\Rule\\' . $name . 'Rule';
            if (class_exists($className)) {
                $this->config[$name]['rule'] = new $className();
            }
        }

        return $this;
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
