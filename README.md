# AtLeastValidator (Yii 2)

## Usage

```
namespace app\models;

...
use slinstj\yii2-validators\AtLeastValidator;

class MyModel extends Model
{
    public $name;
    public $email;
    public $phone;

    public function rules()
    {
        return [
            [['name', 'email'], 'required'],
            [['phone', 'email'], AtLeastValidator::className()],
            // ['name', AtLeastValidator::className(), 'min' => 2, 'in' ['name', 'email, 'phone']] *** using parameters,
            ['email', 'email'],
        ];
    }
}
```

## Examples

Checks if one or more in a list of attributes are filled.

In the following example, the `attr1` and `attr2` attributes will
be verified. If none of them are filled they will receive an error:

```
      // in rules()
      return [
          [['attr1', 'attr2'], AtLeastValidator::className()],
      ];
```

In the following example, the `attr1`, `attr2` and `attr3` attributes will
be verified. If at least 2 (`min`) of them are not filled, `attr1` will
receive an error:

```
     // in rules()
     return [
         ['attr1', AtLeastValidator::className(), 'min' => 2, 'in' => ['attr1', 'attr2', 'attr3']],
     ];
```
