<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */

/**
 * @package  RiceGrain_Validator
 * @license  http://www.opensource.org/licenses/bsd-license.php  BSD License (revised)
 */

namespace RiceGrain\Validator;

use RiceGrain\Validator\ValidatorNotFoundException;

class ValidatorFactory
{
    /**
     * @param string $name
     * @return boolean
     * @throws \RiceGrain\Validator\ValidatorNotFoundException
     */
    public static function create($name)
    {
        if (class_exists($name)) {
            return new $name;
        } else {
            $class = "RiceGrain\\Validator\\Plugin\\{$name}Validator";
            if (!class_exists($class)) {
                throw new ValidatorNotFoundException();
            }
        }

        return new $class;
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
