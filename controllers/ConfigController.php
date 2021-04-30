<?php

namespace humhub\modules\sms\controllers;

use Yii;
use humhub\models\Setting;

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
        $post = $this->getPost(array('SmsProviderConfigureForm', 'AnySmsConfigureForm', 'ClickatellConfigureForm', 'SpryngConfigureForm', 'Sms77ConfigureForm'));

        if ($post != null) {
            $provider = $post['provider'];
            $form = $this->getSmsProviderForm($provider);

            // provider changed => just change the provider setting and reload the correct form
            if ($provider != Setting::Get('provider', 'sms')) {
                $form = new \humhub\modules\sms\forms\SmsProviderConfigureForm();
            } else {
                $form = $this->getSmsProviderForm($provider);
            }

            $form->setAttributes($post);
            if ($form->validate()) {
                foreach ($form->attributeNames() as $attributeName) {
                    Setting::Set($attributeName, $form->$attributeName, 'sms');
                }
                return $this->redirect(['/sms/config']);
            }
        } else {
            $provider = Setting::Get('provider', 'sms');
            $form = $this->getSmsProviderForm($provider);
            foreach ($form->attributeNames() as $attributeName) {
                $form->$attributeName = Setting::Get($attributeName, 'sms');
            }
        }

        return $this->render('index', array('model' => $form));
    }

    /**
     * Returns the fitting form for the given sms provider.
     * 
     * @param string $provider the currently selected sms provider.
     * @return AnySmsConfigureForm|ClickatellConfigureForm|SpryngConfigureForm|SmsProviderConfigureForm
     */
    private function getSmsProviderForm($provider = null)
    {
        if ($provider != null) {
            switch ($provider) {
                case 'AnySms':
                    return new \humhub\modules\sms\forms\AnySmsConfigureForm();
                case 'Clickatell':
                    return new \humhub\modules\sms\forms\ClickatellConfigureForm();
                case 'Spryng':
                    return new \humhub\modules\sms\forms\SpryngConfigureForm();
                case 'Sms77':
                    return new \humhub\modules\sms\forms\Sms77ConfigureForm();
                default:
                    break;
            }
        }
        return new \humhub\modules\sms\forms\SmsProviderConfigureForm();
    }

    /**
     * @param array{string} the provider form classes to accept when set in the post.
     * @return the received post, if one of the provider forms is posted, else null.
     */
    private function getPost($providerFormClasses = array())
    {
        foreach ($providerFormClasses as $formClass) {
            if (isset($_POST[$formClass])) {
                return ($_POST[$formClass]);
            }
        }
        return null;
    }

}

?>
