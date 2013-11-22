<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */

/**
 * @package  RiceGrain_Validator
 * @license  http://www.opensource.org/licenses/bsd-license.php  BSD License (revised)
 */

namespace RiceGrain\Validator\Plugin;

class PastDateValidator extends Validator
{
    /**
     * @var \RiceGrain\Validator\Rule\PastDateRule
     */
    protected $rule;

    /**
     * {@inheritDoc}
     */
    public function validate($value)
    {
        $date = date_parse($value);
        if (!$date) {
            return false;
        }

        if (!checkdate($date['month'], $date['day'], $date['year'])) {
            return false;
        }

        $target = sprintf('%04d%02d%02d', $date['year'], $date['month'], $date['day']);
        if ($this->rule->getAllowCurrentDate() == true) {
            return $target <= date('Ymd');
        } else {
            return $target < date('Ymd');
        }
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
