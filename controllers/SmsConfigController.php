<?php

/**
 * Description of SmsConfigController
 *
 * @author Luke
 */
class SmsConfigController extends Controller {

    public $subLayout = "application.modules_core.admin.views._layout";

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('allow',
                'expression' => 'Yii::app()->user->isAdmin()',
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Configuration Action for Super Admins
     */
    public function actionIndex() {

        Yii::import('sms.forms.*');

        $form = new SmsConfigureForm;

        // uncomment the following code to enable ajax-based validation
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'sms-configure-form') {
            echo CActiveForm::validate($form);
            Yii::app()->end();
        }

        if (isset($_POST['SmsConfigureForm'])) {
            $_POST['SmsConfigureForm'] = Yii::app()->input->stripClean($_POST['SmsConfigureForm']);
            $form->attributes = $_POST['SmsConfigureForm'];

            if ($form->validate()) {

                $form->provider = HSetting::Set('provider', $form->provider, 'sms');
                $form->username = HSetting::Set('username', $form->username, 'sms');
                $form->password = HSetting::Set('password', $form->password, 'sms');
                $form->gateway = HSetting::Set('gateway', $form->gateway, 'sms');

                $this->redirect(Yii::app()->createUrl('//sms/smsConfig/index'));
            }
        } else {
            $form->provider = HSetting::Get('provider', 'sms');
            $form->username = HSetting::Get('username', 'sms');
            $form->password = HSetting::Get('password', 'sms');
            $form->gateway = HSetting::Get('gateway', 'sms');
        }

        $this->render('index', array('model' => $form));
    }

}

?>
