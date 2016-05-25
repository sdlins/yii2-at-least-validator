<?php
/**
 * @author: Sidney Lins - slinstj@gmail.com
 * Please, check the LICENSE information.
 */

namespace codeonyii\yii2validators\tests;


use yii\base\Model;

class FakeModel extends Model
{
    public $attr1;
    public $attr2;
    public $attr3;
    public $attr4;
    public $attr5;

    public function resetData()
    {
        for ($i = 1; $i <= 5; $i++) {
            $attr = 'attr' . $i;
            $this->$attr = null;
        }
    }
}