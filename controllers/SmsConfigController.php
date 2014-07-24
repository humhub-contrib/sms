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

        $form = new AnySmsConfigureForm;

        // uncomment the following code to enable ajax-based validation
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'any-sms-configure-form') {
            echo CActiveForm::validate($form);
            Yii::app()->end();
        }

        if (isset($_POST['AnySmsConfigureForm'])) {
            $_POST['AnySmsConfigureForm'] = Yii::app()->input->stripClean($_POST['AnySmsConfigureForm']);
            $form->attributes = $_POST['AnySmsConfigureForm'];

            if ($form->validate()) {

                $form->provider = HSetting::Set('provider', $form->provider, 'sms');
                $form->username_anysms = HSetting::Set('username_anysms', $form->username, 'sms');
                $form->password_anysms = HSetting::Set('password_anysms', $form->password, 'sms');
                $form->gateway_anysms = HSetting::Set('gateway_anysms', $form->gateway, 'sms');

                $this->redirect(Yii::app()->createUrl('//sms/smsConfig/index'));
            }
        } else {
            $form->provider = HSetting::Get('provider', 'sms');
            $form->username_anysms = HSetting::Get('username_anysms', 'sms');
            $form->password_anysms = HSetting::Get('password_anysms', 'sms');
            $form->gateway_anysms = HSetting::Get('gateway_anysms', 'sms');
        }

        $this->render('index', array('model' => $form));
    }

}

?>
