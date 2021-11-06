<?php

namespace humhub\modules\sms\forms;

use humhub\modules\ui\form\widgets\ActiveField;
use humhub\modules\ui\form\widgets\ActiveForm;
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
            case 'username_clickatell' :
                return $activeForm->field($this, 'username_clickatell')->textarea();
            case 'password_clickatell' :
                return $activeForm->field($this, 'password_clickatell')->passwordInput();
            case 'apiid_clickatell' :
                return $activeForm->field($this, 'apiid_clickatell')->textInput();
            default :
                return parent::getActiveFormElement($activeForm, $attributeName);
        }
    }

}
