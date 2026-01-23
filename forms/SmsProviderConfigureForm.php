<?php

namespace humhub\modules\sms\forms;

use humhub\widgets\form\ActiveField;
use humhub\widgets\form\ActiveForm;
use Yii;

/**
 * Super class for all provider specific ConfigureFormModels.
 *
 * @author Sebastian Stumpf
 *
 */
class SmsProviderConfigureForm extends \yii\base\Model
{
    /** The selected provider. * */
    public $provider;

    /**
     * @see CModel::rules()
     */
    public function rules()
    {
        return [
            ['provider', 'required'],
        ];
    }

    /**
     * @see CModel::attributeLabels()
     */
    public function attributeLabels()
    {
        return [
            'provider' => Yii::t('SmsModule.base', 'Choose Provider'),
        ];
    }

    /**
     * @see CFormModel::attributeNames()
     */
    public function attributeNames()
    {
        return ['provider'];
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
            'provider' => $activeForm->field($this, 'provider')->dropDownList(
                ['AnySms' => 'Any-SMS', 'Clickatell' => 'Clickatell', 'Spryng' => 'Spryng', 'Sms77' => 'Seven'],
                ['class' => 'form-control provider-select'],
            ),
            default => null,
        };
    }

}
