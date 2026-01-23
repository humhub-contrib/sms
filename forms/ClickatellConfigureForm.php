<?php

namespace humhub\modules\sms\forms;

use humhub\widgets\form\ActiveField;
use humhub\widgets\form\ActiveForm;
use Yii;

class ClickatellConfigureForm extends SmsProviderConfigureForm
{
    public $apiKey_clickatell;

    /**
     * Declares the validation rules.
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['apiKey_clickatell'], 'required'],
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
            'apiKey_clickatell' => Yii::t('SmsModule.base', 'API Key'),
        ]);
    }

    /**
     * You can change the order of the form elements here. First element in array is shown first.
     *
     * @see SmsProviderConfigureForm::attributeNames()
     */
    public function attributeNames()
    {
        return array_merge(parent::attributeNames(), ['apiKey_clickatell']);
    }

    /**
     * Offers a proper ActiveFormField for each form field by its name.
     *
     * @param ActiveForm $activeForm
     * @param string $attributeName the attributes name
     * @return ActiveField | \humhub\widgets\form\ActiveField | null
     */
    public function getActiveFormElement($activeForm = null, $attributeName = null)
    {
        if ($activeForm == null || $attributeName == null) {
            return null;
        }

        return match ($attributeName) {
            'apiKey_clickatell' => $activeForm->field($this, 'apiKey_clickatell')->textInput(),
            default => parent::getActiveFormElement($activeForm, $attributeName),
        };
    }

}
