<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */

/**
 * @package  RiceGrain_Validator
 * @license  http://www.opensource.org/licenses/bsd-license.php  BSD License (revised)
 */

namespace RiceGrain;

use RiceGrain\Validation\Validation;
use RiceGrain\Validator\Error;
use RiceGrain\Validator\Request;
use RiceGrain\Validator\ValidatorFactory;
use RiceGrain\Validator\ValidatorNotFoundException;

class Validator
{
    /**
     * @var string
     */
    const RESULT_ALL = 'all';

    /**
     * @var string
     */
    const RESULT_SUCCESS_ONLY = 'success_only';

    /**
     * @var \RiceGrain\Validator\Error
     */
    protected $error;

    /**
     * @var string
     */
    protected $entity;

    /**
     * @var array
     */
    protected $resultAll = array();

    /**
     * @var array
     */
    protected $resultSuccess = array();

    /**
     * @var \RiceGrain\Validator\Request
     */
    protected $request;

    /**
     * @var array
     */
    protected $requiredRemoveFields = array();

    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->error->getAll();
    }

    /**
     * @param string $target
     * @return array
     */
    public function getResult($target = self::RESULT_ALL)
    {
        if ($target == self::RESULT_ALL) {
            return $this->mapArray2Class($this->resultAll, $this->entity);
        } elseif ($target == self::RESULT_SUCCESS_ONLY) {
            return $this->mapArray2Class($this->resultSuccess, $this->entity);
        } else {
            return $this->resultAll;
        }
    }

    /**
     * @param array $array
     * @param object $entity
     * @return array|object
     */
    protected function mapArray2Class(array $array, $entity)
    {
        if (is_null($entity) || !class_exists($entity)) {
            return $array;
        } else {
            $object = new $entity();
            foreach ($array as $name => $value) {
                $setterMethodName = sprintf('set%s', $this->camelize($name));
                $propertyName = $this->camelize($name, true);
                if (method_exists($object, $setterMethodName)) {
                    $object->$setterMethodName($value);

                } elseif (property_exists($object, $propertyName)) {
                    $class = new \ReflectionClass($object);
                    $property = $class->getProperty($propertyName);
                    if ($property->isPublic()) {
                        $object->$property = $value;
                    }
                }
            }

            return $object;
        }
    }

    /**
     * @param \RiceGrain\Validation\Validation $class
     * @param array $request
     * @param array $files
     * @return boolean
     */
    public function validate(Validation $class, array $request = null, array $files = null)
    {
        $this->initialize($request, $files);

        if (method_exists($class, 'entity') && !is_null($class->entity())) {
            $this->entity = $class->entity();
        }

        $this->synthesizeField($class);
        $this->filterAll($class);
        $this->filterField($class);
        $this->validateField($class);
        $this->validateAll($class);

        if ($this->error->count() > 0) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * @param array $request
     * @param array $files
     */
    protected function initialize(array $request = null, array $files = null)
    {
        $request = is_null($request) ? $_REQUEST : $request;
        $files = is_null($files) ? $_FILES : $files;
        $this->request = new Request($request, $files);
        $this->error = new Error();

        $this->resultAll = $this->resultSuccess = array();
    }

    /**
     * @param \RiceGrain\Validation\Validation $class
     */
    protected function synthesizeField(Validation $class)
    {
        $class->synthesizeField($this->request);
    }

    /**
     * @param \RiceGrain\Validation\Validation $class
     */
    protected function filterAll(Validation $class)
    {
        if (method_exists($class, 'filterAll')) {
            foreach ($this->request->getAll() as $name => $value) {
                $result = $class->filterAll($value);
                $this->request->set($name, $result);
            }
        }
    }

    /**
     * @param \RiceGrain\Validation\Validation $class
     */
    protected function filterField(Validation $class)
    {
        foreach ($this->getClassMethodsForFilter($class) as $filterMethod) {
            foreach ($this->request->getAll() as $name => $value) {
                $result = $class->$filterMethod($name, $value);
                $this->request->set($name, $result);
                $this->setRequiredRemoveFields($class->getRequiredRemoveFields());
            }
        }
    }

    /**
     * @param array $fields
     */
    protected function setRequiredRemoveFields(array $fields)
    {
        $this->requiredRemoveFields = $fields;
    }

    /**
     * @param \RiceGrain\Validation\Validation $class
     */
    protected function validateField(Validation $class)
    {
        foreach ($this->getClassMethodsForField($class) as $name) {
            $validations = $class->$name()->getConfigs();
            $this->resultAll[$name] = $this->getValue($name);

            foreach ($this->requiredRemoveFields as $field) {
                unset($validations['Required']);
            }

            if (!$this->validateRequired($name, $validations)) {
                continue;
            }

            $this->validateWithoutRequired($name, $validations);
        }
    }

    /**
     * @param \RiceGrain\Validation\Validation $class
     */
    protected function validateAll(Validation $class)
    {
        $class->validateAll($this->request);
        foreach ($class->getError()->getAll() as $name => $message) {
            if (!$this->error->has($name)) {
                $this->error->setMessage($name, $message);
            }
            unset($this->resultSuccess[$name]);
        }
    }

    /**
     * @param string $name
     * @param array $validations
     * @return boolean
     */
    protected function validateRequired($name, array $validations)
    {
        $validatorName = 'Required';
        if ($this->request->hasFiles($name)) {
            $validatorName = 'FileRequired';
        }

        if (!$this->validateBySingleValidation($name, $validatorName)) {
            if (isset($validations['Required'])) {
                $this->error->setMessage($name, $validations['Required']['message']);
            }

            return false;
        } else {
            return true;
        }
    }

    /**
     * @param string $name
     * @param array $validations
     * @return boolean
     */
    protected function validateWithoutRequired($name, array $validations)
    {
        unset($validations['Required']);

        $message = '';
        $result = true;
        foreach ($validations as $validatorName => $params) {
            if (!$this->validateBySingleValidation($name, $validatorName, $params)) {
                $message = $params['message'];
                $result = false;
                break;
            }
        }

        if ($result == true) {
            $this->resultSuccess[$name] = $this->getValue($name);
        } else {
            if (!$this->error->has($name)) {
                $this->error->setMessage($name, $message);
                unset($this->resultSuccess[$name]);
            }
        }
    }

    /**
     * @param string $name
     * @param string $validatorName
     * @param array $params
     * @return boolean
     * @throws \RiceGrain\Validator\ValidatorNotFoundException
     */
    protected function validateBySingleValidation($name, $validatorName, array $params = null)
    {
        if (!isset($validatorName)) {
            throw new ValidatorNotFoundException();
        }

        $validator = ValidatorFactory::create($validatorName); /* @var $validator \RiceGrain\Validator\Plugin\Validator */
        if (isset($params['rule'])) {
            $validator->setRule($params['rule']);
        }
        if ($validator->validate($this->getValue($name))) {
            return true;
        } else {
            if ($validator->getMessage()){
                $this->error->setMessage($name, $validator->getMessage());
            }
            return false;
        }
    }

    /**
     * @param string $name
     * @return mixed
     */
    protected function getValue($name)
    {
        if ($this->request->has($name)) {
            return $this->request->get($name);
        } elseif ($this->request->hasFiles($name)) {
            return $this->request->getFiles($name);
        } else {
            return null;
        }
    }

    /**
     * @param \RiceGrain\Validation\Validation $class
     * @return array
     */
    protected function getClassMethodsForFilter(Validation $class)
    {
        $methods = get_class_methods(get_class($class));
        $filterMethods = array();
        foreach ($methods as $index => $method) {
            if ($this->isFilterMethod($method) && $method != 'filterAll') {
                $filterMethods[] = $method;
            }
        }

        return $filterMethods;
    }

    /**
     * @param \RiceGrain\Validation\Validation $class
     * @return array
     */
    protected function getClassMethodsForField(Validation $class)
    {
        $methods = get_class_methods(get_class($class));
        foreach ($methods as $index => $method) {
            if ($this->isSpecifiedMethod($method)) {
                unset($methods[$index]);
            }
        }

        return $methods;
    }

    /**
     * @param string $method
     * @return boolean
     */
    protected function isFilterMethod($method)
    {
        if (preg_match('!^filter!', $method)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param string $method
     * @return boolean
     */
    protected function isSpecifiedMethod($method)
    {
        if (
            $this->isFilterMethod($method) ||
            in_array($method, get_class_methods('RiceGrain\Validation\Validation'))
        ) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param string  $word
     * @param boolean $lowercaseFirstLetter
     * @return string
     */
    protected function camelize($word, $lowercaseFirstLetter = false)
    {
        $camelizedWord = str_replace(' ', '', ucwords(preg_replace('/(?:(?<!\d)[^A-Z^a-z^0-9](?!\d))+/', ' ', $word)));
        if (!$lowercaseFirstLetter) {
            return $camelizedWord;
        } else {
            return strtolower(substr($camelizedWord, 0, 1)) . substr($camelizedWord, 1);
        }
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
