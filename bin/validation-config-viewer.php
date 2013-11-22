#!/usr/bin/php
<?php

$bootstrapFile = isset($_SERVER['argv'][1]) ? $_SERVER['argv'][1] : null;
if (!file_exists($bootstrapFile)) {
    printHelp('オートロード設定をするためのブートストラップファイルが見つかりません。');
}

$dir = isset($_SERVER['argv'][2]) ? $_SERVER['argv'][2] : null;
if (!is_dir($dir)) {
    printHelp('Validationクラスを配置したディレクトリが見つかりません。');
}

// カラーが表示できない場合は、$GLOBALS['ricegrain-validator-colorize'] = false; を
// ブートストラップファイルに記入して下さい。
$GLOBALS['ricegrain-validator-colorize'] = true;

define('COLOR_BLACK',      30);
define('COLOR_RED',        31);
define('COLOR_GREEN',      32);
define('COLOR_YELLOW',     33);
define('COLOR_BLUE',       34);
define('COLOR_PURPLE',     35);
define('COLOR_LIGHT_BLUE', 36);
define('COLOR_WHITE',      37);

require $bootstrapFile;

$fileList = findFile($dir);
foreach ($fileList as $file) {
    $classString = file_get_contents($file);
    if (preg_match('!namespace\s+([^;]+);!', $classString, $matches)) {
        $namespace = $matches[1];
        if (preg_match('!class\s+([a-zA-Z0-9]+)\s+extends\s+([^ ]*Validation)!', file_get_contents($file), $matches)) {
            $className = $namespace . '\\' . $matches[1];
            if ($matches[2] != 'Validation' && $matches[2] != 'RiceGrain\Validation\Validation') {
                continue;
            }
            $class = new \ReflectionClass($className);
            if ($class->getParentClass()->getName() != 'RiceGrain\Validation\Validation') {
                continue;
            }
            printValidationSettingList($className);
        }
    }
}

/**
 * @param string $message
 */
function printHelp($message = null)
{
    if (!is_null($message)) {
        print 'Error: ' . $message;
        print PHP_EOL;
        print PHP_EOL;
    }
    printf('Usage: %s [ブートスラップファイル] [ターゲットディレクトリ]', basename(__FILE__));
    print PHP_EOL;
    exit(1);
}

/**
 * @param string $dir
 * @param array $list
 * @return array
 */
function findFile($dir, array $list = array())
{
    $resource = opendir($dir);
    while (($file = readdir($resource)) !== false) {
        if (preg_match('!^\.+$!', $file)) {
            continue;
        }
        $fullpath = $dir . '/' . $file;
        if (file_exists($fullpath)) {
            if (is_dir($fullpath)) {
                $list2 = findFile($fullpath, $list);
                $list = array_merge($list, $list2);
            } else {
                $list[] = $fullpath;
            }
        } else {
            continue;
        }
    }
    closedir($resource);

    return $list;
}

exit(0);

/**
 * @param string $target
 */
function printValidationSettingList($target)
{
    print $target . PHP_EOL;

    $class = new \ReflectionClass($target);
    $reservedMethods = getReservedMethods();

    $specifiedMethod = '';
    foreach ($class->getMethods() as $method) {
        $methodName = $method->getName();
        if (in_array($methodName, $reservedMethods)) {
            continue;
        }
        if (isOverwridableMethod($methodName)) {
            if ($class->getFileName() == $method->getFileName()) {
                $specifiedMethod .= getMethodString($method);
            }
            continue;
        }

        printFieldSettings($target, $method);
    }

    if ($specifiedMethod) {
        print str_repeat(' ', 2) . 'Specified Method' . PHP_EOL;
        print str_repeat(' ', 2) .
            str_replace(PHP_EOL, PHP_EOL . str_repeat(' ', 2), colorize($specifiedMethod, COLOR_PURPLE));
    }

    print PHP_EOL;
}

/**
 * @param string $target
 * @param \ReflectionMethod $method
 */
function printFieldSettings($target, \ReflectionMethod $method)
{
    $methodName = $method->getName();

    $validationConfig = $method->invoke(new $target());
    print str_repeat(' ', 2) . convertForOutput($methodName, COLOR_GREEN) . ':' . PHP_EOL;
    foreach ($validationConfig->getConfigs() as $validator => $settings) {
        print str_repeat(' ', 6) . 'Validator: ' . convertForOutput($validator, COLOR_YELLOW) . PHP_EOL;
        foreach ($settings as $key => $value) {
            if (is_object($value)) {
                print str_repeat(' ', 8) . convertForOutput($key, COLOR_BLUE) . ':' . PHP_EOL;
                $settingsObject = new \ReflectionClass($value);
                $counter = 0;
                foreach ($settingsObject->getProperties() as $property) {
                    $property->setAccessible(true);
                    if (is_null($property->getValue($value))) continue;
                    if ($counter > 0) print PHP_EOL;
                    print str_repeat(' ', 10) . convertForOutput($property->getName()) . ' => ' . convertForOutput($property->getValue($value));
                    ++$counter;
                }
            } else {
                print str_repeat(' ', 8) . convertForOutput($key, COLOR_BLUE) . ':' . PHP_EOL;
                print str_repeat(' ', 10) . str_replace(PHP_EOL, PHP_EOL . str_repeat(' ', 10), convertForOutput($value));
            }
            print PHP_EOL;
        }
    }
}

/**
 * @return array
 */
function getReservedMethods()
{
    $validationClass = new \ReflectionClass('RiceGrain\Validation\Validation');
    $reservedMethods = array();
    foreach ($validationClass->getMethods() as $method) {
        if (isOverwridableMethod($method->getName())) continue;
        $reservedMethods[] = $method->getName();
    }

    return $reservedMethods;
}

/**
 * @param \ReflectionMethod $method
 * @return string
 */
function getMethodString(\ReflectionMethod $method)
{
    $lines = explode(PHP_EOL, file_get_contents($method->getFileName()));
    $methodString = '';
    for ($i = $method->getStartLine(); $i <= $method->getEndLine(); ++$i) {
        $methodString .= $lines[$i - 1] . PHP_EOL;
    }

    return $methodString;
}

/**
 * @param string $value
 * @return string
 */
function convertForOutput($value, $color = COLOR_PURPLE)
{
    if ($GLOBALS['ricegrain-validator-colorize'] == true) {
        return colorize(var_export($value, true), $color);
    } else {
        return var_export($value, true);
    }
}

/**
 * @param string $value
 * @param integer $color
 * @return string
 */
function colorize($value, $color)
{
    return pack('c',0x1B) . "[1;{$color}m" . $value . pack('c',0x1B) . "[0m";
}

/**
 * @param string $methodName
 * @return boolean
 */
function isOverwridableMethod($methodName)
{
    if (preg_match('!^(synthesizeField|validate|filter)!', $methodName)) {
        return true;
    } else {
        return false;
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
