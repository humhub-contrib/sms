<?php

namespace humhub\modules\sms\forms;

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
     * @param HActiveFormElement $activeForm 
     * @param string $attributeName the attributes name
     * @return the fitting ActiveFormField
     */
    public function getActiveFormElement($activeForm = null, $attributeName = null)
    {
        if ($activeForm == null || $attributeName == null) {
            return null;
        }
        switch ($attributeName) {
            case 'provider' :
                return $activeForm->dropdownList($this, 'provider', array('AnySms' => 'Any-SMS', 'Clickatell' => 'Clickatell', 'Spryng' => 'Spryng'), array('class' => 'form-control provider-select'));
            default :
                return null;
        }
    }

}
