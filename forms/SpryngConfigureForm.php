<?php

class SpryngConfigureForm extends SmsProviderConfigureForm {

	// required
	public $username_spryng;
	public $password_spryng;
	
	// optional
	public $route_spryng;
	public $service_spryng;
	public $allowlong_spryng;

    /**
     * Declares the validation rules.
     */
    public function rules() {
        return array_merge(parent::rules(), array(
        	array('username_spryng, password_spryng', 'required'),
        	array('route_spryng, service_spryng, allowlong_spryng', 'safe')
        ));
    }

    /**
     * Declares customized attribute labels.
     * If not declared here, an attribute would have a label that is
     * the same as its name with the first letter in upper case.
     */
    public function attributeLabels() {
        return  array_merge(parent::attributeLabels(), array( 
        	'username_spryng' => Yii::t('SmsModule.base', 'Username'),
        	'password_spryng' => Yii::t('SmsModule.base', 'Password'),
        	'route_spryng' => Yii::t('SmsModule.base', 'Select the Spryng route (default: BUSINESS)'),
        	'service_spryng' => Yii::t('SmsModule.base', 'Reference tag to create a filter in statistics'),
        	'allowlong_spryng' => Yii::t('SmsModule.base', 'Allow Messages > 160 characters (default: not allowed -> currently not supported, as characters are limited by the view)')
        ));
    }
    /**
     * You can change the order of the form elements here. First element in array is shown first.
     * @see SmsProviderConfigureForm::attributeNames()
     */
    public function attributeNames() {
    	return  array_merge(parent::attributeNames(), array('username_spryng', 'password_spryng', 'route_spryng', 'service_spryng', 'allowlong_spryng'));
    }
    
    /**
     * @see SmsProviderConfigureForm::getActiveFormElement()
     */
    public function getActiveFormElement($activeForm = null, $attributeName = null) {
    	if($activeForm == null || $attributeName == null) {
    		return null;
    	}
    	switch($attributeName) {
    		case 'username_spryng' :
    			return $activeForm->textField($this, 'username_spryng', array('class' => 'form-control'));
    		case 'password_spryng' :
    			return $activeForm->passwordField($this, 'password_spryng', array('class' => 'form-control'));
    		case 'route_spryng' :
    			return $activeForm->textField($this, 'route_spryng', array('class' => 'form-control'));
    		case 'service_spryng' :
    			return $activeForm->textField($this, 'service_spryng', array('class' => 'form-control'));
    		case 'allowlong_spryng' :
    			return $activeForm->checkBox($this, 'allowlong_spryng', array('class' => 'form-control'));
    		default :
    			return parent::getActiveFormElement($activeForm, $attributeName);
    	}
    }

}