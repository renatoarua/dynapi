<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class TicketForm extends Model
{
    public $email;
    public $feature;
    public $title;
    public $description;
    public $opsystem;
    public $browser;
    public $priority;
    public $status;
    public $screenshot1;
    public $screenshot2;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['email', 'feature', 'title', 'description', 'opsystem', 'browser', 'priority', 'status'], 'required'],
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
    {}

    /**
     * Sends an email to the specified email address using the information collected by this model.
     * @param string $email the target email address
     * @return boolean whether the model passes validation
     */
    public function send($email = 'support@dyntechnologies.net')
    {
        if ($this->validate()) {
            $data = [];
            $data['name'] = $this->firstname.' '.$this->lastname;
            $data['subject'] = "Site Contact Form: " . $this->subject;
            $data['message'] = $this->message;
            $data['email'] = $this->email;

            // ->setTextBody($this->message)
            $mail = Yii::$app->mailer->compose(
                ['html' => 'ticket-html'],
                ['data' => $data])
                ->setTo($email)
                ->setFrom([Yii::$app->params['adminEmail'] => $data['email']])
                ->setSubject($data['subject'])
                ->send();

            return true;
        }
        return false;
    }
}
