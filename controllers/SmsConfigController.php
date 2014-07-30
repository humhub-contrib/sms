<?php

/**
 * Description of SmsConfigController.
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
     * Configuration Action for Super Admins.
     */
    public function actionIndex() {

        Yii::import('sms.forms.*');
        
        $post = $this->getPost(array('SmsProviderConfigureForm', 'AnySmsConfigureForm', 'ClickatellConfigureForm', 'SpryngConfigureForm'));
        
        if ($post != null) {
        	$provider = $post['provider'];
        	        	
        	// provider changed => just change the provider setting and reload the correct form
        	if($provider != HSetting::Get('provider', 'sms')) {
        		$form = new SmsProviderConfigureForm();
        	} else {
        		$form = $this->getSmsProviderForm($provider);
        	}
        	$form->attributes = $post;
        	
        	// uncomment the following code to enable ajax-based validation
        	if (Yii::app()->getRequest()->getIsAjaxRequest()) {
        		echo CActiveForm::validate($form);
        		Yii::app()->end();
        	}
        	
        	if ($form->validate()) {
        		foreach($form->attributeNames() as $attributeName) {
        			HSetting::Set($attributeName, $form->$attributeName, 'sms');
        		}
        		$this->redirect(Yii::app()->createUrl('//sms/smsConfig/index'));
        	}
        } else {
        	$provider = HSetting::Get('provider', 'sms');
        	$form = $this->getSmsProviderForm($provider);
        	foreach($form->attributeNames() as $attributeName) {
        		$form->$attributeName = HSetting::Get($attributeName, 'sms');
        	}
        }     
        
        $this->render('index', array('model' => $form));        
    }   
    
    /**
     * Returns the fitting form for the given sms provider.
     * 
     * @param string $provider the currently selected sms provider.
     * @return AnySmsConfigureForm|ClickatellConfigureForm|SpryngConfigureForm|SmsProviderConfigureForm
     */
    private function getSmsProviderForm($provider = null) {
    	if($provider != null) {
    		switch($provider) {
    			case 'AnySms':
    				return new AnySmsConfigureForm();
    			case 'Clickatell':
    				return new ClickatellConfigureForm();
    			case 'Spryng':
    				return new SpryngConfigureForm();
    			default:
    				break;
    		}
    	}
    	return new SmsProviderConfigureForm();
    }
    
    /**
     * @param array{string} the provider form classes to accept when set in the post.
     * @return the received post, if one of the provider forms is posted, else null.
     */
    private function getPost($providerFormClasses = array()) {
    	
    	foreach($providerFormClasses as $formClass) {
    		if (isset($_POST[$formClass])) {
    			return Yii::app()->input->stripClean($_POST[$formClass]);
    		}
    	}
    	return null;
    }    
}

?>
