<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */

/**
 * @package  RiceGrain_Validator
 * @license  http://www.opensource.org/licenses/bsd-license.php  BSD License (revised)
 */

namespace RiceGrain\Validator\Plugin;

class DateValidator extends Validator
{
    /**
     * {@inheritDoc}
     */
    public function validate($value)
    {
        if (!preg_match('!(\d+)-(\d+)-(\d+)!', $value, $matches)) {
            return false;
        }

        return checkdate($matches[2], $matches[3], $matches[1]);
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
