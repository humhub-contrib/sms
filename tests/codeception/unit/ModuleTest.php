<?php

namespace sms\tests\codeception\unit;

use humhub\modules\sms\forms\SmsProviderConfigureForm;
use tests\codeception\_support\HumHubDbTestCase;
use Yii;

class ModuleTest extends HumHubDbTestCase
{
    public function testIsConfigured()
    {
        $module = Yii::$app->getModule('sms');

        $module->settings->set('provider', '');
        $this->assertFalse($module->isConfigured());

        $module->settings->set('provider', 'Sms77');
        $this->assertTrue($module->isConfigured());
    }

    public function testProviderCanBeEmpty()
    {
        $form = new SmsProviderConfigureForm(['provider' => '']);
        $this->assertTrue($form->validate());

        $form = new SmsProviderConfigureForm(['provider' => 'Sms77']);
        $this->assertTrue($form->validate());

        $form = new SmsProviderConfigureForm(['provider' => 'Unknown']);
        $this->assertFalse($form->validate());
    }
}
