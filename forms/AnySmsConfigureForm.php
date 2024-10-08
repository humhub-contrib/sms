<?php

namespace humhub\modules\sms\forms;

use humhub\modules\ui\form\widgets\ActiveField;
use humhub\modules\ui\form\widgets\ActiveForm;
use Yii;

/**
 * AnySmsConfigureForm holds the configuration fields available for the AnySms provider.
 *
 * @author Sebastian Stumpf
 *
 */
class AnySmsConfigureForm extends SmsProviderConfigureForm
{
    public $username_anysms;
    public $password_anysms;
    public $gateway_anysms;
    public $test_anysms;

    /**
     * Declares the validation rules.
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['username_anysms', 'password_anysms', 'gateway_anysms'], 'required'],
            ['test_anysms', 'safe'],
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
            'username_anysms' => Yii::t('SmsModule.base', 'Username'),
            'password_anysms' => Yii::t('SmsModule.base', 'Password'),
            'gateway_anysms' => Yii::t('SmsModule.base', 'Gateway Number'),
            'test_anysms' => Yii::t('SmsModule.base', 'Test option. Sms are not delivered, but server responses as if the were.'),
        ]);
    }

    /**
     * You can change the order of the form elements here. First element in array is shown first.
     * @see SmsProviderConfigureForm::attributeNames()
     */
    public function attributeNames()
    {
        return array_merge(parent::attributeNames(), ['username_anysms', 'password_anysms', 'gateway_anysms', 'test_anysms']);
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
            case 'username_anysms':
                return $activeForm->field($this, 'username_anysms')->textInput();
            case 'password_anysms':
                return $activeForm->field($this, 'password_anysms')->passwordInput();
            case 'gateway_anysms':
                return $activeForm->field($this, 'gateway_anysms')->textInput();
            case 'test_anysms':
                return $activeForm->field($this, 'test_anysms')->checkbox();
            default:
                return parent::getActiveFormElement($activeForm, $attributeName);
        }
    }

}
