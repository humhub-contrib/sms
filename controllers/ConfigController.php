<?php

namespace humhub\modules\sms\controllers;

use humhub\components\SettingsManager;
use humhub\modules\sms\forms\AnySmsConfigureForm;
use humhub\modules\sms\forms\ClickatellConfigureForm;
use humhub\modules\sms\forms\Sms77ConfigureForm;
use humhub\modules\sms\forms\SmsProviderConfigureForm;
use humhub\modules\sms\forms\SpryngConfigureForm;
use Yii;

/**
 * Description of SmsConfigController.
 *
 * @author Luke
 */
class ConfigController extends \humhub\modules\admin\components\Controller
{
    /**
     * Configuration Action for Super Admins.
     */
    public function actionIndex()
    {
        $post = $this->getPost(['SmsProviderConfigureForm', 'AnySmsConfigureForm', 'ClickatellConfigureForm', 'SpryngConfigureForm', 'Sms77ConfigureForm']);

        /* @var SettingsManager $settings */
        $settings = Yii::$app->getModule('sms')->settings;

        if ($post !== null) {
            $form = $this->getSmsProviderForm($post['provider'] ?? null);
            $form->setAttributes($post);
            if ($form->validate()) {
                foreach ($form->attributeNames() as $attributeName) {
                    $settings->set($attributeName, $form->$attributeName);
                }
                $this->view->saved();
                return $this->redirect(['/sms/config']);
            }
        } else {
            // The provider can be switched without saving, the form is reloaded via ajax
            $savedProvider = $settings->get('provider');
            $provider = Yii::$app->request->get('provider', $savedProvider);
            $form = $this->getSmsProviderForm($provider);
            if ($provider === $savedProvider) {
                foreach ($form->attributeNames() as $attributeName) {
                    $form->$attributeName = $settings->get($attributeName);
                }
            } else {
                $form->provider = $provider;
            }

            if (Yii::$app->request->isAjax && Yii::$app->request->get('provider') !== null) {
                return $this->renderAjax('_form', ['model' => $form]);
            }
        }

        return $this->render('index', ['model' => $form]);
    }

    /**
     * Returns the fitting form for the given sms provider.
     *
     * @param string|null $provider the currently selected sms provider.
     * @return AnySmsConfigureForm|ClickatellConfigureForm|SpryngConfigureForm|Sms77ConfigureForm|SmsProviderConfigureForm
     */
    private function getSmsProviderForm($provider = null)
    {
        return match ($provider) {
            'AnySms' => new AnySmsConfigureForm(),
            'Clickatell' => new ClickatellConfigureForm(),
            'Spryng' => new SpryngConfigureForm(),
            'Sms77' => new Sms77ConfigureForm(),
            default => new SmsProviderConfigureForm(),
        };
    }

    /**
     * @param array{string} the provider form classes to accept when set in the post.
     * @return array|null the received post, if one of the provider forms is posted, else null.
     */
    private function getPost($providerFormClasses = [])
    {
        foreach ($providerFormClasses as $formClass) {
            $post = Yii::$app->request->post($formClass);
            if (is_array($post)) {
                return $post;
            }
        }
        return null;
    }

}
