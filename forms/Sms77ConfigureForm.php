<?php

namespace humhub\modules\sms\forms;

use humhub\modules\ui\form\widgets\ActiveField;
use humhub\modules\ui\form\widgets\ActiveForm;
use Yii;

class Sms77ConfigureForm extends SmsProviderConfigureForm
{
    public $apikey_sms77;

    /**
     * Declares the validation rules.
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['apikey_sms77'], 'required'],
        ]);
    }

    /**
     * Declares customized attribute labels.
     * If not declared here, an attribute would have a label that is
     * the same as its name with the first letter in upper case.
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'apikey_sms77' => Yii::t('SmsModule.base', 'API key'),
        ]);
    }

    /**
     * You can change the order of the form elements here. First element in array is shown first.
     *
     * @see SmsProviderConfigureForm::attributeNames()
     */
    public function attributeNames()
    {
        return array_merge(parent::attributeNames(), ['apikey_sms77']);
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
            case 'apikey_sms77':
                return $activeForm->field($this, 'apikey_sms77')->passwordInput();
            default:
                return parent::getActiveFormElement($activeForm, $attributeName);
        }
    }

}
