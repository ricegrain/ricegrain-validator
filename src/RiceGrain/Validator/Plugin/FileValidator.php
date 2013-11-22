<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */

/**
 * @package  RiceGrain_Validator
 * @license  http://www.opensource.org/licenses/bsd-license.php  BSD License (revised)
 */

namespace RiceGrain\Validator\Plugin;

class FileValidator extends Validator
{
    /**
     * @var \RiceGrain\Validator\Rule\FileRule
     */
    protected $rule;

    /**
     * @var array
     */
    private static $errorCodes = array(
        'UPLOAD_ERR_INI_SIZE',
        'UPLOAD_ERR_FORM_SIZE',
        'UPLOAD_ERR_PARTIAL',
        'UPLOAD_ERR_NO_FILE',
        'UPLOAD_ERR_NO_TMP_DIR',
        'UPLOAD_ERR_CANT_WRITE',
        'UPLOAD_ERR_EXTENSION'
    );

    /**
     * {@inheritDoc}
     */
    public function validate($value)
    {
        if (
            !is_array($value) ||
            !array_key_exists('error', $value) ||
            !array_key_exists('tmp_name', $value) ||
            !array_key_exists('size', $value) ||
            !array_key_exists('type', $value)
        ) {
            return false;
        }

        if (!is_array($value['error'])) {
            $value = array_map(create_function('$v', 'return array($v);'), $value);
        }

        for ($i = 0, $count = count($value['error']); $i < $count; ++$i) {
            if ($value['error'][$i] != UPLOAD_ERR_OK) {
                return false;
            }

            if (!$this->validateFile($value['tmp_name'][$i], $value['size'][$i], $value['type'][$i])) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param string  $filename
     * @param integer $size
     * @param string  $mime
     * @return boolean
     */
    protected function validateFile($filename, $size, $mime)
    {
        if (!$this->inRange($size)) {
            return false;
        }

        $useMagic = $this->rule->getUseMagic();
        if ($useMagic) {
            $mime = $this->detectMimeType($filename);
            if ($mime === false) {
                $this->setMessage($this->rule->getMimetypeMessage());
                return false;
            }
        }

        if (!$this->validateMimeType($mime)) {
            $this->setMessage($this->rule->getMimetypeMessage());
            return false;
        }

        return true;
    }

    /**
     * @param string $key
     * @param string $value
     * @return boolean
     */
    protected function inRange($value)
    {
        $max = $this->rule->getMaxSize();
        if (!is_null($max)) {
            if ($value > $max) {
                $this->setMessage($this->rule->getMaxSizeMessage());
                return false;
            }
        }

        $min = $this->rule->getMinSize();
        if (!is_null($min)) {
            if ($value < $min) {
                $this->setMessage($this->rule->getMinSizeMessage());
                return false;
            }
        }

        return true;
    }

    /**
     * @param string $mime
     * @return boolean
     */
    protected function validateMimeType($mime)
    {
        $pattern = $this->rule->getMimetype();
        if (is_null($pattern)) {
            return true;
        }

        if (!preg_match("!{$pattern}!", $mime)) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * @param string $filename
     * @return mixed
     */
    private function detectMimeType($filename)
    {
        if (!is_file($filename) || !is_readable($filename)) {
            return false;
        }

        if (function_exists('finfo_file')) {
            return $this->detectMimeWithFileinfo($filename);
        }

        if (function_exists('mime_content_type')) {
            return mime_content_type($filename);
        }

        if (substr(PHP_OS, 0, 3) != 'WIN') {
            return exec('file -bi '. escapeshellarg($filename));
        }

        return false;
    }

    /**
     * @param string $filename
     * @return mixed
     */
    private function detectMimeWithFileinfo($filename)
    {
        $info = finfo_open(FILEINFO_MIME);
        $mime = finfo_file($info, $filename);
        finfo_close($info);
        return $mime;
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
