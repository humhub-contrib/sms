<?php

class SmsConfigureForm extends CFormModel {

    public $provider;
    public $username;
    public $password;
    public $gateway;

    /**
     * Declares the validation rules.
     */
    public function rules() {
        return array(
            array('provider, username, password, gateway', 'required'),
        );
    }

    /**
     * Declares customized attribute labels.
     * If not declared here, an attribute would have a label that is
     * the same as its name with the first letter in upper case.
     */
    public function attributeLabels() {
        return array(
        );
    }

}