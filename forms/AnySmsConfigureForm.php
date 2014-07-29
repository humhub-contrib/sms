<?php

class AnySmsConfigureForm extends SmsProviderConfigureForm {

    public $username_anysms;
    public $password_anysms;
    public $gateway_anysms;

    /**
     * Declares the validation rules.
     */
    public function rules() {
        return array_merge(parent::rules(), array(
        	array('username_anysms, password_anysms, gateway_anysms', 'required')
        ));
    }

    /**
     * Declares customized attribute labels.
     * If not declared here, an attribute would have a label that is
     * the same as its name with the first letter in upper case.
     */
    public function attributeLabels() {
        return  array_merge(parent::attributeLabels(), array( 
        	'username_anysms' => Yii::t('SmsModule.base', 'Username'),
        	'password_anysms' => Yii::t('SmsModule.base', 'Password'),
        	'gateway_anysms' => Yii::t('SmsModule.base', 'Gateway Number')
        ));
    }
    
	/**
     * You can change the order of the form elements here. First element in array is shown first.
     * @see SmsProviderConfigureForm::attributeNames()
     */
    public function attributeNames() {
    	return  array_merge(parent::attributeNames(), array('username_anysms', 'password_anysms', 'gateway_anysms'));
    }
    
    public function getActiveFormElement($activeForm = null, $attributeName = null) {
        	if($activeForm == null || $attributeName == null) {
    		return null;
    	}
    	switch($attributeName) {
    		case 'username_anysms' :
    			return $activeForm->textField($this, 'username_anysms', array('class' => 'form-control'));
    		case 'password_anysms' :
    			return $activeForm->passwordField($this, 'password_anysms', array('class' => 'form-control'));
    		case 'gateway_anysms' :
    			return $activeForm->textField($this, 'gateway_anysms', array('class' => 'form-control'));
    		default :
    			return parent::getActiveFormElement($activeForm, $attributeName);
    	}
    }

}