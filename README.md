ricegrain-validator
===================

## Composer

最初に、**composer.json** ファイルに次のように **ricegrain/ricegrain-validator** を記入してください。

```json
{
    "require": {
        "ricegrain/ricegrain-validator": "0.1.*"
    }
}
```

次に、次のように依存関係を更新してください。

```console
composer update ricegrain/ricegrain-validater
```

## Usage

 * バリデーション定義クラスを作成します。

```php
    use RiceGrain\Validation\Validation;
    use RiceGrain\Validation\ValidationConfig;
    
    class HogeValidation extends Validation
    {
        public function married()
        {
            return ValidationConfig::create()
                ->addRequired('必須入力です')
                ->addBoolean('boolean型ではありません');
        }
    }

```

 * バリデーションを行います。(入力値は $_REQUEST から取得します。)

```php
    use RiceGrain\Validator;

    $validator = new Validator();
    $validationResult = $validator->validate(new HogeValidation());

    $errors = $validator->getErrors();

    $allResult     = $validator->getResult();
    $successResult = $validator->getResult(Validator::RESULT_SUCCESS_ONLY);
```

## License

[The BSD 2-Clause License](http://opensource.org/licenses/BSD-2-Clause)
