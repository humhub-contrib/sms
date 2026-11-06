<?php

/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\sms\components;

use Throwable;
use Yii;

/**
 * HttpRequest sends the requests to the SMS providers.
 */
class HttpRequest
{
    private const TIMEOUT = 15;

    /**
     * Sends a GET request and returns the response body.
     *
     * The URL contains credentials of the provider and the message, so it must never be logged.
     *
     * @param string $url
     * @return string|null the response body or null if the provider could not be reached
     */
    public static function get(string $url): ?string
    {
        try {
            $handle = fopen($url, 'rb', false, stream_context_create([
                'http' => ['timeout' => self::TIMEOUT, 'ignore_errors' => true],
            ]));

            if ($handle === false) {
                return null;
            }

            $response = stream_get_contents($handle);
            fclose($handle);

            return $response === false ? null : $response;
        } catch (Throwable) {
            Yii::error('Could not connect to the SMS provider.', 'sms');
            return null;
        }
    }

    /**
     * @return array the result for a not reachable provider
     */
    public static function connectionError(): array
    {
        return [
            'error' => true,
            'statusMsg' => Yii::t('SmsModule.base', 'Could not open connection to SMS-Provider, please contact an administrator.'),
        ];
    }
}
