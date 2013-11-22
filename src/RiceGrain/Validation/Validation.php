<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */

/**
 * @package  RiceGrain_Validator
 * @license  http://www.opensource.org/licenses/bsd-license.php  BSD License (revised)
 */

namespace RiceGrain\Validation;

use RiceGrain\Validator\Error;
use RiceGrain\Validator\Request;

/**
 * バリデーションクラスに追加できるメソッド
 *
 *  synthesizeField(\RiceGrain\Validator\Request $request)
 *  filterAll($value)
 *  filterXXXX($name, $value)
 *  validateAll(\RiceGrain\Validator\Request $request)
 */
abstract class Validation
{
    /**
     * @var \RiceGrain\Validator\Error
     */
    private $error;

    /**
     * @var array
     */
    private $requiredRemoveFields = array();

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->error = new Error();
    }

    /**
     * バリデーション後のデータをオブジェクトに変換する場合にクラス名を指定します。(オーバーライドして使用)
     *
     * @return string
     */
    public function entity() {}

    /**
     * フィールドを合成する場合に使用します。(オーバーライドして使用)
     *
     * 例)
     *  $request->set('zipCode', sprintf('%s-%s', $request->get('zipCode1'), $request->get('zipCode2'));
     *
     * @param \RiceGrain\Validator\Request $request
     * @return \RiceGrain\Validator\Request
     */
    public function synthesizeField(Request $request) {}

    /**
     * 複数のフィールドを使った検証をする場合に使用します。(オーバーライドして使用)
     *
     * 例)
     *  if (
     *    $this->isEmpty($request->get('home_phone')) &&
     *    $this->isEmpty($request->get('mobile_phone'))
     *  ) {
     *      $this->setErrorMessage('home_phone', '自宅電話番号、携帯電話番号どちらか一方を入力して下さい');
     *      $this->setErrorMessage('mobile_phone', '自宅電話番号、携帯電話番号どちらか一方を入力して下さい');
     *  }
     *
     * @param \RiceGrain\Validator\Request $request
     * @return \RiceGrain\Validator\Error | null
     */
    public function validateAll(Request $request) {}

    /**
     * 'Required' 設定を削除するフィールドを追加します。
     * filterAll() メソッド内で入力値の条件により必須条件を外す時に使います。
     *
     * @param string $name
     */
    final protected function addRemoveRequiredField($name)
    {
        $this->requiredRemoveFields[] = $name;
    }

    /**
     * フィールドにエラーメッセージを設定します。
     * validateAll() メソッド内でエラーとしたいフィールドにメッセージを設定する時に使います。
     *
     * @param string $name
     * @param mixed $message
     */
    final protected function setErrorMessage($name, $message)
    {
        $this->error->setMessage($name, $message);
    }

    /**
     * 値が空かどうかを判定します。
     *
     * @param mixed $value
     * @return boolean
     */
    final protected function isEmpty($value)
    {
        if (is_array($value)) {
            return count($value) === 0;
        }

        if (is_scalar($value)) {
            $value = trim($value);
        }

        if (!$value && "$value" != '0') {
            return true;
        }

        return false;
    }

    /**
     * @return array
     */
    final public function getRequiredRemoveFields()
    {
        return $this->requiredRemoveFields;
    }

    /**
     * @return \RiceGrain\Validator\Error
     */
    final public function getError()
    {
        return $this->error;
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
