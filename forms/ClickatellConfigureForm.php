<?php

namespace humhub\modules\sms\forms;

use Yii;

class ClickatellConfigureForm extends SmsProviderConfigureForm
{

    public $username_clickatell;
    public $password_clickatell;
    public $apiid_clickatell;

    /**
     * Declares the validation rules.
     */
    public function rules()
    {
        return array_merge(parent::rules(), array(
            array(['username_clickatell', 'password_clickatell', 'apiid_clickatell'], 'required')
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
            'username_clickatell' => Yii::t('SmsModule.base', 'Username'),
            'password_clickatell' => Yii::t('SmsModule.base', 'Password'),
            'apiid_clickatell' => Yii::t('SmsModule.base', 'API ID')
        ));
    }

    /**
     * You can change the order of the form elements here. First element in array is shown first.
     * 
     * @see SmsProviderConfigureForm::attributeNames()
     */
    public function attributeNames()
    {
        return array_merge(parent::attributeNames(), array('username_clickatell', 'password_clickatell', 'apiid_clickatell'));
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
            case 'username_clickatell' :
                return $activeForm->textField($this, 'username_clickatell', array('class' => 'form-control'));
            case 'password_clickatell' :
                return $activeForm->passwordField($this, 'password_clickatell', array('class' => 'form-control'));
            case 'apiid_clickatell' :
                return $activeForm->textField($this, 'apiid_clickatell', array('class' => 'form-control'));
            default :
                return parent::getActiveFormElement($activeForm, $attributeName);
        }
    }

}
