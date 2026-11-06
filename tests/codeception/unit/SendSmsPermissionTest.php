<?php

namespace sms\tests\codeception\unit;

use humhub\modules\sms\permissions\SendSms;
use tests\codeception\_support\HumHubDbTestCase;

class SendSmsPermissionTest extends HumHubDbTestCase
{
    public function testNotAllowedForUser()
    {
        $this->becomeUser('User1');
        $this->assertFalse(SendSms::isAllowed());
    }

    public function testAllowedForAdmin()
    {
        $this->becomeUser('Admin');
        $this->assertTrue(SendSms::isAllowed());
    }
}
