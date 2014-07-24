<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SmsSendController
 *
 * @author Luke
 */
class SmsSendController extends Controller {

    public $subLayout = "application.modules_core.user.views.profile._layout";

    /**
     * Add behaviors to this controller
     * @return type
     */
    public function behaviors() {
        return array(
            'ProfileControllerBehavior' => array(
                'class' => 'application.modules_core.user.behaviors.ProfileControllerBehavior',
            ),
        );
    }

    public function actionIndex() {
        Yii::import('sms.forms.*');

        $user = $this->getUser();
        $form = new SmsSendForm;

        // uncomment the following code to enable ajax-based validation
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'sms-send-form') {
            echo CActiveForm::validate($form);
            Yii::app()->end();
        }
	
        if (isset($_POST['SmsSendForm'])) {
            $_POST['SmsSendForm'] = Yii::app()->input->stripClean($_POST['SmsSendForm']);
            $form->attributes = $_POST['SmsSendForm'];            
            
            if ($form->validate()) {
            	$sender = Yii::app()->user->displayName;
            	$receiver = $user->profile->mobile;
            	$msg = $form->message;
            	$provider = new SmsProvider();
            	$response = $provider->sendSms($sender, $receiver, $msg);
            	 
            	$this->render('done', array(
            			'user' => $user,
            			'response' => $response,
            			'debug'	=> true
            	));
            	return;
            }
        }

        $this->render('index', array(
            'model' => $form,
            'user' => $user
        ));
    }

}

?>
