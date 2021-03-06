<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class ContactForm extends Model
{
    public $firstname;
    public $lastname;
    public $email;
    public $subject;
    public $message;
    public $verifyCode;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['firstname', 'lastname', 'email', 'subject', 'message'], 'required'],
            // email has to be a valid email address
            ['email', 'email'],
            // verifyCode needs to be entered correctly
            // ['verifyCode', 'captcha'],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'verifyCode' => 'Verification Code',
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     * @param string $email the target email address
     * @return boolean whether the model passes validation
     */
    public function contact($email = 'contact@dyntechnologies.net')
    {
        if ($this->validate()) {
            $data = [];
            $data['name'] = $this->firstname.' '.$this->lastname;
            $data['subject'] = "Site Contact Form: " . $this->subject;
            $data['message'] = $this->message;
            $data['email'] = $this->email;            

            // ->setTextBody($this->message)
            $mail = Yii::$app->mailer->compose(
                ['html' => 'contact-html'],
                ['data' => $data])
                ->setTo($email)
                ->setFrom([Yii::$app->params['adminEmail'] => $data['name']])
                ->setSubject($data['subject'])
                ->send();

            return true;
        }
        return false;
    }
}
