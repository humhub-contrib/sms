<?php

/**
 * Description of SmsSendController.
 *
 * @author Luke
 */
class SmsSendController extends Controller {

    public $subLayout = "application.modules_core.user.views.profile._layout";
    /** set debug to true, if you want additional information about the server response put to you browser console via console.log(...) */
    public $debug = true;

    /**
     * @return array action filters
     */
    public function filters() {
    	return array(
    			'accessControl', // perform access control for CRUD operations -> redirect to login if access denied
    	);
    }
    
    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
    	return array(
    			array('allow', // allow authenticated user to perform 'create' and 'update' actions
    					'users' => array('@'),
    			),
    			array('deny', // deny all users
    					'users' => array('*'),
    			),
    	);
    }
    
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
            			'debug'	=> $this->debug
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
