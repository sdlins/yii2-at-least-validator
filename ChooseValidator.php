<?php

namespace slinstj\yii2-choose-validator;

use Yii;
use yii\base\InvalidConfigException;

/**
 * Checks if one or more of the choosen attributes are filled.
 *
 * In the following example, the `attr1`, `attr2` and `attr3` attributes will
 * be verified. If none of them are filled they will receive an error:
 *
 * ~~~[php]
 *      // in rules()
 *      return [
 *          [['attr1', 'attr2, 'attr3'], 'choose'],
 *      ];
 * ~~~
 *
 * In the following example, the `attr1`, `attr2` and `attr3` attributes will
 * be verified. If at least 2 (`min`) of them are not filled, `attr1` and `attr3` will
 * receive an error:
 *
 * ~~~[php]
 *      // in rules()
 *      return [
 *          [['attr1', 'attr2', 'attr3'], 'choose', 'min' => 2, 'errorIn' => 'attr1'],
 *      ];
 * ~~~
 *
 * The attributes that will receive the error message can be specified into [[errorIn]]
 * param. If none is specified, all envolved attributes will receive the error.
 *
 * @author Sidney Lins <slinstj@gmail.com>
 */
class ChooseValidator extends Validator
{
    /**
     * @var integer the minimun required quantity of attributes that must to be filled.
     * Defaults to 1.
     */
    public $min = 1;

    /**
     * @var array the list of attributes that should receive the error message.
     * Defaults to all attributes being validated (i.e, attribute + [[with]] attributes).
     */
    public $errorIn;

    /**
     * @var boolean whether this validation rule should be skipped if the attribute value
     * is null or an empty string.
     */
    public $skipOnEmpty = false;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        if ($this->message === null) {
            $this->message = Yii::t('yii', 'Please, fill at least {min} of the attributes {attributesList}.');
        }
    }

    public function validateAttribute($model, $attribute)
    {
        $value = $model->$attribute;

        $attributes = array_merge((array) $attribute, (array) $this->with);
        $filled = 0;
        foreach ($attributes as $attribute) {
            $value = $model->$attribute;
            $attributesListLabels[] = '"' . $model->generateAttributeLabel($attribute) . '"';
            $filled += !empty($value) ? 1 : 0;
        }

        if (!$filled) {
            $attributesList = implode(' or ', $attributesListLabels);
            $errorIn = !empty($this->errorIn) ? (array) $this->errorIn : $attributes;
            foreach ($errorIn as $attribute) {
                $this->addError($model, $attribute, $this->message, [
                    'attributesList' => $attributesList,
                ]);
            }
        }
    }
}
