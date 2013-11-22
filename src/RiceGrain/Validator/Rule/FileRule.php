<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */

/**
 * @package  RiceGrain_Validator
 * @license  http://www.opensource.org/licenses/bsd-license.php  BSD License (revised)
 */

namespace RiceGrain\Validator\Rule;

class FileRule implements RuleInterface
{
    /**
     * @var integer
     */
    protected $maxSize;

    /**
     * @var string
     */
    protected $maxSizeMessage;

    /**
     * @var integer
     */
    protected $minSize = 0;

    /**
     * @var string
     */
    protected $minSizeMessage;

    /**
     * @var string
     */
    protected $mimetype;

    /**
     * @var string
     */
    protected $mimetypeMessage;

    /**
     * @var boolean
     */
    protected $useMagic = false;

    /**
     * @return \RiceGrain\Validator\Rule\FileRule
     */
    public static function create()
    {
        $class = __CLASS__;
        return new $class;
    }

    /**
     * @param integer $maxSize
     * @param string $message
     * @return \RiceGrain\Validator\Rule\Rule
     */
    public function setMaxSize($maxSize, $message = null)
    {
        $this->maxSize = $maxSize;
        $this->maxSizeMessage = $message;
        return $this;
    }

    /**
     * @return integer
     */
    public function getMaxSize()
    {
        return $this->maxSize;
    }

    /**
     * @param integer $minSize
     * @param string $message
     * @return \RiceGrain\Validator\Rule\Rule
     */
    public function setMinSize($minSize, $message = null)
    {
        $this->minSize = $minSize;
        $this->minSizeMessage = $message;
        return $this;
    }

    /**
     * @return integer
     */
    public function getMinSize()
    {
        return $this->minSize;
    }

    /**
     * @param string $mimetype
     * @param string $message
     * @return \RiceGrain\Validator\Rule\Rule
     */
    public function setMimetype($mimetype, $message = null)
    {
        $this->mimetype = $mimetype;
        $this->mimetypeMessage = $message;
        return $this;
    }

    /**
     * @return string
     */
    public function getMimetype()
    {
        return $this->mimetype;
    }

    /**
     * @param boolean $useMagic
     * @return \RiceGrain\Validator\Rule\Rule
     */
    public function setUseMagic($useMagic)
    {
        $this->useMagic = $useMagic;
        return $this;
    }

    /**
     * @return boolean
     */
    public function getUseMagic()
    {
        return $this->useMagic;
    }

    /**
     * @return string
     */
    public function getMaxSizeMessage()
    {
        return $this->maxSizeMessage;
    }

    /**
     * @return string
     */
    public function getMinSizeMessage()
    {
        return $this->minSizeMessage;
    }

    /**
     * @return string
     */
    public function getMimetypeMessage()
    {
        return $this->mimetypeMessage;
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
