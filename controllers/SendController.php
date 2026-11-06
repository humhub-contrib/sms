<?php

namespace humhub\modules\sms\controllers;

use humhub\modules\content\components\ContentContainerController;
use humhub\modules\sms\components\SmsProvider;
use humhub\modules\sms\forms\SmsSendForm;
use humhub\modules\sms\permissions\SendSms;
use Yii;
use yii\web\ForbiddenHttpException;
use yii\web\HttpException;

/**
 * Description of SmsSendController.
 *
 * @author Luke
 */
class SendController extends ContentContainerController
{
    /** set debug to true, if you want additional information about the server response put to you browser console via console.log(...) */
    public $debug = false;

    /**
     * @inheritdoc
     */
    public function getAccessRules()
    {
        return [
            ['login'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        }

        // Only the global permission is checked (the same as for the profile menu entry),
        // the container permissions of the profile owner (self/friend) must not grant access.
        if (!SendSms::isAllowed()) {
            throw new ForbiddenHttpException(Yii::t('base', 'You are not permitted to access this section.'));
        }

        return true;
    }

    public function actionIndex()
    {
        $form = new SmsSendForm();
        $user = $this->contentContainer;

        if (!$this->module->isConfigured()) {
            throw new HttpException(404, Yii::t('SmsModule.base', 'Provider is not initialized. Please contact an administrator to check the module configuration.'));
        }

        $receiver = $this->module->getUserMobile($user);
        if ($receiver === null) {
            throw new HttpException(404, Yii::t('SmsModule.base', 'The user has no mobile number set.'));
        }

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $sender = Yii::$app->user->getIdentity()->displayName;
            $msg = $form->message;
            $provider = new SmsProvider();
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
