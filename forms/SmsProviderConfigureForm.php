<?php

namespace humhub\modules\sms\forms;

use humhub\modules\ui\form\widgets\ActiveField;
use humhub\modules\ui\form\widgets\ActiveForm;
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
        return array(
            array('provider', 'required'),
        );
    }

    /**
     * @see CModel::attributeLabels()
     */
    public function attributeLabels()
    {
        return array(
            'provider' => Yii::t('SmsModule.base', 'Choose Provider')
        );
    }

    /**
     * @see CFormModel::attributeNames()
     */
    public function attributeNames()
    {
        return array('provider');
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
            case 'provider' :
                return $activeForm->field($this, 'provider')->dropDownList(
                    ['AnySms' => 'Any-SMS', 'Clickatell' => 'Clickatell', 'Spryng' => 'Spryng', 'Sms77' => 'Seven'],
                    ['class' => 'form-control provider-select']
                );
            default :
                return null;
        }
    }

}
