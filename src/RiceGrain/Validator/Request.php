<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */

/**
 * @package  RiceGrain_Validator
 * @license  http://www.opensource.org/licenses/bsd-license.php  BSD License (revised)
 */

namespace RiceGrain\Validator;

class Request
{
    /**
     * @var array
     */
    protected $request;

    /**
     * @var array
     */
    protected $files;

    /**
     * @param array $request
     * @param array $files
     */
    public function __construct(array $request, array $files = array())
    {
        $this->request = $request;
        $this->files = $files;
    }

    /**
     * @param string $name
     * @return boolean
     */
    public function has($name)
    {
        if (isset($this->request[$name])) {
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
        return $this->request;
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function get($name)
    {
        if ($this->has($name)) {
            return $this->request[$name];
        } else {
            return null;
        }
    }

    /**
     * @param string $name
     * @param mixed $value
     */
    public function set($name, $value)
    {
        $this->request[$name] = $value;
    }

    /**
     * @param string $name
     * @return boolean
     */
    public function hasFiles($name)
    {
        if (isset($this->files[$name])) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function getFiles($name)
    {
        if ($this->hasFiles($name)) {
            return $this->files[$name];
        } else {
            return null;
        }
    }

    /**
     * @param string $name
     * @param mixed $value
     */
    public function setFiles($name, $value)
    {
        $this->files[$name] = $value;
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
