<?php

class AnySmsConfigureForm extends CFormModel {

    public $provider;
    public $username_anysms;
    public $password_anysms;
    public $gateway_anysms;

    /**
     * Declares the validation rules.
     */
    public function rules() {
        return array(
            array('provider, username_anysms, password_anysms, gateway_anysms', 'required'),
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