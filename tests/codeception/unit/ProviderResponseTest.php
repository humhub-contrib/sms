<?php

namespace sms\tests\codeception\unit;

use humhub\modules\sms\components\AnySms;
use humhub\modules\sms\components\Clickatell;
use humhub\modules\sms\components\HttpRequest;
use humhub\modules\sms\components\Sms77;
use humhub\modules\sms\components\SmsProvider;
use humhub\modules\sms\components\Spryng;
use ReflectionMethod;
use tests\codeception\_support\HumHubDbTestCase;

class ProviderResponseTest extends HumHubDbTestCase
{
    private function interpret(object $provider, string $response): array
    {
        $method = new ReflectionMethod($provider, 'interpretResponse');

        return $method->invoke($provider, $response);
    }

    public function testAnySms()
    {
        $this->assertFalse($this->interpret(new AnySms(), "err:0\nmsg:ok")['error']);
        $this->assertTrue($this->interpret(new AnySms(), "err:-3\nmsg:no credit")['error']);
        $this->assertTrue($this->interpret(new AnySms(), '<html>Bad Gateway</html>')['error']);
        $this->assertTrue($this->interpret(new AnySms(), '')['error']);
    }

    public function testClickatell()
    {
        $this->assertFalse($this->interpret(new Clickatell(), 'ID: abc123')['error']);

        $result = $this->interpret(new Clickatell(), 'ERR: 001, Authentication failed');
        $this->assertTrue($result['error']);
        $this->assertEquals('Authentication failed', $result['statusMsg']);

        $this->assertTrue($this->interpret(new Clickatell(), '<html>Bad Gateway</html>')['error']);
    }

    public function testSpryng()
    {
        $result = $this->interpret(new Spryng(), '1');
        $this->assertFalse($result['error']);
        $this->assertEquals('SMS has been successfully sent.', $result['statusMsg']);

        $result = $this->interpret(new Spryng(), "203\n");
        $this->assertTrue($result['error']);
        $this->assertEquals('Insufficent credits.', $result['statusMsg']);

        $this->assertTrue($this->interpret(new Spryng(), '<html>Bad Gateway</html>')['error']);
        $this->assertTrue($this->interpret(new Spryng(), '')['error']);
    }

    public function testSms77()
    {
        $result = $this->interpret(new Sms77(), '{"success":"100","messages":[{"id":"1","error":null}]}');
        $this->assertFalse($result['error']);
        $this->assertEquals('1', $result['furtherInfo']['message_1_id']);

        $this->assertTrue($this->interpret(new Sms77(), '{"success":"500"}')['error']);
        $this->assertTrue($this->interpret(new Sms77(), '<html>Bad Gateway</html>')['error']);
    }

    public function testNormalizeReceiver()
    {
        $provider = new SmsProvider();

        $this->assertEquals('00491701234567', $provider->normalize('+49 (170) 123-4567'));
        $this->assertEquals('0170123', $provider->normalize('0170 123'));
    }

    public function testNotReachableProvider()
    {
        $this->assertNull(HttpRequest::get('http://127.0.0.1:1/'));
        $this->assertTrue(HttpRequest::connectionError()['error']);
    }
}
