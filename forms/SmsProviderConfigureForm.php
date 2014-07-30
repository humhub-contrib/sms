<?php

class SmsProviderConfigureForm extends CFormModel {

    public $provider;
	
    /**
     * Declares the validation rules.
     */
    public function rules() {
        return array(
            array('provider', 'required'),
        );
    }

    /**
     * Declares customized attribute labels.
     * If not declared here, an attribute would have a label that is
     * the same as its name with the first letter in upper case.
     */
    public function attributeLabels() {
        return array( 
        	'provider' => Yii::t('SmsModule.base', 'Choose Provider')
        );
    }
    
    public function attributeNames() {
    	return  array('provider');
    }
    
    public function getActiveFormElement($activeForm = null, $attributeName = null) {
    	if($activeForm == null || $attributeName == null) {
    		return null;
    	}
    	switch($attributeName) {
    		case 'provider' : 
    			return $activeForm->dropdownList($this, 'provider', array('AnySms' => 'Any-SMS', 'Clickatell' => 'Clickatell', 'Spryng' => 'Spryng'), array('class' => 'form-control provider-select'));
    		default :
    			return null;
    	}
    }

}