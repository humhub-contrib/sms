<?php

namespace humhub\modules\sms\forms;

use humhub\modules\ui\form\widgets\ActiveField;
use humhub\modules\ui\form\widgets\ActiveForm;
use Yii;

class SpryngConfigureForm extends SmsProviderConfigureForm
{

    // required
    public $username_spryng;
    public $password_spryng;
    // optional
    public $route_spryng;
    public $service_spryng;
    public $allowlong_spryng;

    /**
     * Declares the validation rules.
     */
    public function rules()
    {
        return array_merge(parent::rules(), array(
            array(['username_spryng', 'password_spryng'], 'required'),
            array(['route_spryng', 'service_spryng', 'allowlong_spryng'], 'safe')
        ));
    }

    /**
     * Declares customized attribute labels.
     * If not declared here, an attribute would have a label that is
     * the same as its name with the first letter in upper case.
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), array(
            'username_spryng' => Yii::t('SmsModule.base', 'Username'),
            'password_spryng' => Yii::t('SmsModule.base', 'Password'),
            'route_spryng' => Yii::t('SmsModule.base', 'Select the Spryng route (default: BUSINESS)'),
            'service_spryng' => Yii::t('SmsModule.base', 'Reference tag to create a filter in statistics'),
            'allowlong_spryng' => Yii::t('SmsModule.base', 'Allow Messages > 160 characters (default: not allowed -> currently not supported, as characters are limited by the view)')
        ));
    }

    /**
     * You can change the order of the form elements here. First element in array is shown first.
     * @see SmsProviderConfigureForm::attributeNames()
     */
    public function attributeNames()
    {
        return array_merge(parent::attributeNames(), array('username_spryng', 'password_spryng', 'route_spryng', 'service_spryng', 'allowlong_spryng'));
    }

    /**
     * Offers a proper ActiveFormField for each form field by its name.
     *
     * @param ActiveForm $activeForm
     * @param string $attributeName the attributes name
     * @return ActiveField | \yii\bootstrap\ActiveField | null
     */
    public function getActiveFormElement($activeForm = null, $attributeName = null)
    {
        if ($activeForm == null || $attributeName == null) {
            return null;
        }

        switch ($attributeName) {
            case 'username_spryng' :
                return $activeForm->field($this, 'username_spryng')->textInput();
            case 'password_spryng' :
                return $activeForm->field($this, 'password_spryng')->passwordInput();
            case 'route_spryng' :
                return $activeForm->field($this, 'route_spryng')->textInput();
            case 'service_spryng' :
                return $activeForm->field($this, 'service_spryng')->textInput();
            case 'allowlong_spryng' :
                return $activeForm->field($this, 'allowlong_spryng')->checkbox();
            default :
                return parent::getActiveFormElement($activeForm, $attributeName);
        }
    }

}
