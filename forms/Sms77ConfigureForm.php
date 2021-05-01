<?php

namespace humhub\modules\sms\forms;

use Yii;

class Sms77ConfigureForm extends SmsProviderConfigureForm
{

    public $apikey_sms77;

    /**
     * Declares the validation rules.
     */
    public function rules()
    {
        return array_merge(parent::rules(), array(
            array(['apikey_sms77'], 'required')
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
            'apikey_sms77' => Yii::t('SmsModule.base', 'API key'),
        ));
    }

    /**
     * You can change the order of the form elements here. First element in array is shown first.
     * 
     * @see SmsProviderConfigureForm::attributeNames()
     */
    public function attributeNames()
    {
        return array_merge(parent::attributeNames(), array('apikey_sms77'));
    }

    /**
     * @see SmsProviderConfigureForm::getActiveFormElement()
     */
    public function getActiveFormElement($activeForm = null, $attributeName = null)
    {
        if ($activeForm == null || $attributeName == null) {
            return null;
        }
        switch ($attributeName) {
            case 'apikey_sms77' :
                return $activeForm->passwordField($this, 'apikey_sms77', array('class' => 'form-control'));
            default :
                return parent::getActiveFormElement($activeForm, $attributeName);
        }
    }

}
