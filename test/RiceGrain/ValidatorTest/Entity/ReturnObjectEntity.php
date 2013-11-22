<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */

/**
 * @package  RiceGrain_Validator
 * @license  http://www.opensource.org/licenses/bsd-license.php  BSD License (revised)
 */

namespace RiceGrain\ValidatorTest\Entity;

class ReturnObjectEntity
{
    /**
     * @var string
     */
    protected $field1;

    /**
     * @var string
     */
    protected $field2;

    /**
     * @var string
     */
    protected $field3;

    /**
     * @var string
     */
    protected $field4;

    /**
     * @param string $field1
     */
    public function setField1($field1)
    {
        $this->field1 = $field1;
    }

    /**
     * @return string
     */
    public function getField1()
    {
        return $this->field1;
    }

    /**
     * @param string $field2
     */
    public function setField2($field2)
    {
        $this->field2 = $field2;
    }

    /**
     * @return string
     */
    public function getField2()
    {
        return $this->field2;
    }

    /**
     * @return string
     */
    public function getField3()
    {
        return $this->field3;
    }

    /**
     * @param string $field4
     */
    public function setField4($field4)
    {
        $this->field4 = $field4;
    }

    /**
     * @return string
     */
    public function getField4()
    {
        return $this->field4;
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
