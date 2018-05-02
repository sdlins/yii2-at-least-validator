<?php
namespace codeonyii\yii2validators\tests;

use codeonyii\yii2validators\AtLeastValidator;
use codeonyii\yii2validators\tests\FakeModel;
use yii\base\InvalidConfigException;

/**
 * This is a temporary trait just created to avoid code duplication
 * when testing using PHP 5.6 and 7+ versions in PHPUnit since each
 * PHPUnit version will use a different Testcase class and it forces
 * us to have two tests classes, one for each version.
 *
 * PHP 5.6 is now in security updates only, till Dec, 2018. After that
 * we can remove tests for 5.6 versions because it will not be more
 * supported by PHP team.
 *
 * @author: Sidney Lins - slinstj@gmail.com
 * @since: 1.2.5
 */
trait TemporaryTraitsForTests {
    public function testWrongConfigs()
    {
        try {
            new AtLeastValidator();
        } catch (\Exception $e) {
            $this->assertInstanceOf('yii\base\InvalidConfigException', $e, 'Parameter `in` is required.');
        }

        try {
            new AtLeastValidator(['in' => 'attr1']);
        } catch (\Exception $e) {
            $this->assertInstanceOf('yii\base\InvalidConfigException', $e, 'Parameter `in` should have at least 2 attributes.');
        }
    }

    public function testWrongData()
    {
        $v = new AtLeastValidator(['in' => 'attr1, attr2, attr3']);
        $m = new FakeModel();

        $v->validateAttribute($m, 'attr1');
        $this->assertCount(1, $m->getErrors());
        $this->assertTrue($m->hasErrors('attr1'));
        $this->assertFalse($m->hasErrors('attr2'));
        $this->assertFalse($m->hasErrors('attr3'));

        $v->validateAttribute($m, 'attr1, attr2');
        $this->assertCount(2, $m->getErrors());
    }

    public function testProperData()
    {
        $v = new AtLeastValidator(['in' => 'attr1, attr2, attr3']);
        $m = new FakeModel();

        $m->attr1 = 'something';
        $v->validateAttribute($m, 'attr1');
        $this->assertCount(0, $m->getErrors(), 'Should not exist errors in attr1');

        $m->resetData();
        $m->attr2 = 'something';
        $v->validateAttribute($m, 'attr1');
        $this->assertCount(0, $m->getErrors(), 'Should not exist errors in attr1');

        $m->resetData();
        $m->attr3 = 'something';
        $v->validateAttribute($m, 'attr1');
        $this->assertCount(0, $m->getErrors(), 'Should not exist errors in attr1');

        $m->resetData();
        $m->attr1 = 'something';
        $m->attr2 = 'something';
        $v->validateAttribute($m, 'attr1');
        $this->assertCount(0, $m->getErrors(), 'Should not exist errors in attr1');

        $m->resetData();
        $m->attr2 = 'something';
        $m->attr3 = 'something';
        $v->validateAttribute($m, 'attr1');
        $this->assertCount(0, $m->getErrors(), 'Should not exist errors in attr1');
    }

    public function testErrorMessages()
    {
        $v = new AtLeastValidator(['in' => 'attr1, attr2, attr3']);
        $m = new FakeModel();

        $v->validateAttribute($m, 'attr1');
        $this->assertEquals('You must fill at least 1 of the attributes "Attr1", "Attr2", "Attr3".', $m->getFirstError('attr1'));

        $m->clearErrors();
        $v->min = 2;
        $v->validateAttribute($m, 'attr1');
        $this->assertEquals('You must fill at least 2 of the attributes "Attr1", "Attr2", "Attr3".', $m->getFirstError('attr1'));
    }

    public function testMinParam()
    {
        $v = new AtLeastValidator(['in' => 'attr1, attr2, attr3']);
        $m = new FakeModel();

        // min = 1;
        $v->validateAttribute($m, 'attr1');
        $this->assertCount(1, $m->getErrors());

        $m->clearErrors();
        $v->min = 2;
        $m->attr1 = 'something';
        $v->validateAttribute($m, 'attr1');
        $this->assertCount(1, $m->getErrors(), 'Should have an error since min = 2');
    }
}