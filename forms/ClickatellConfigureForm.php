<?php

class ClickatellConfigureForm extends CFormModel {

    public $provider;
    public $username_clickatell;
    public $password_clickatell;
    public $apiiid_clickatell;

    /**
     * Declares the validation rules.
     */
    public function rules() {
        return array(
            array('provider, username_clickatell, password_clickatell, apiid_clickatell', 'required'),
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