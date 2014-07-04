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

                $status = "None";
                if (HSetting::Get('gateway', 'sms') != "" && HSetting::Get('username', 'sms') != "") {

                    // Build SMS API Url
                    $url = "http://gateway.any-sms.biz/send_sms.php?id=" . HSetting::Get('username', 'sms');
                    $url .= "&pass=" . HSetting::Get('password', 'sms');
                    $url .= "&text=" . $form->message;
                    $url .= "&nummer=" . $user->profile->mobile;
                    $url .= "&gateway=" . HSetting::Get('gateway', 'sms');
                    $url .= "&absender=" . str_replace(" ", "", Yii::app()->user->displayName);
                    ##$url .= "&flash=1";
                    #$url .= "&test=1";
                    // Sent it

                    $handle = fopen($url, "rb");
                    $contents = stream_get_contents($handle);
 #                   $contents = 'err:0\n';

                    // Fetch Response
                    $lines = explode("\n", $contents);
                    if ($lines[0] == "err:0") {
                        $status = "OK";
                    } else {
                        $status = "Error! " . $lines[0];
                    }
                } else {
                    $status = "Internal Error - Check Module Config!";
                }

                $this->render('done', array(
                    'status' => $status,
                    'user' => $user
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
