<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */

/**
 * @package  RiceGrain_Validator
 * @license  http://www.opensource.org/licenses/bsd-license.php  BSD License (revised)
 */

namespace RiceGrain\Validator;

class Error
{
    /**
     * @var array
     */
    protected $errors = array();

    /**
     * @param string $name
     * @return boolean
     */
    public function has($name)
    {
        if (isset($this->errors[$name])) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @return array
     */
    public function getAll()
    {
        return $this->errors;
    }

    /**
     * @return integer
     */
    public function count()
    {
        return count($this->errors);
    }

    /**
     * @param string $name
     * @return string
     */
    public function getMessage($name)
    {
        if ($this->has($name)) {
            return $this->errors[$name];
        } else {
            return null;
        }
    }

    /**
     * @param string $name
     * @param mixed $message
     */
    public function setMessage($name, $message)
    {
        $this->errors[$name] = $message;
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
