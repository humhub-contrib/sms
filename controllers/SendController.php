<?php

namespace humhub\modules\sms\controllers;

use Yii;

/**
 * Description of SmsSendController.
 *
 * @author Luke
 */
class SendController extends \humhub\modules\content\components\ContentContainerController
{
    /** set debug to true, if you want additional information about the server response put to you browser console via console.log(...) */
    public $debug = true;

    public function actionIndex()
    {
        $form = new \humhub\modules\sms\forms\SmsSendForm();
        $user = $this->contentContainer;

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $sender = Yii::$app->user->getIdentity()->displayName;
            $receiver = $user->profile->mobile;
            $msg = $form->message;
            $provider = new \humhub\modules\sms\components\SmsProvider();
            $response = $provider->sendSms($sender, $receiver, $msg);

            return $this->render('done', [
                'user' => $user,
                'response' => $response,
                'debug' => $this->debug,
            ]);
        }

        return $this->render('index', [
            'model' => $form,
            'user' => $user,
        ]);
    }

}
