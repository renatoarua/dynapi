<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    /** @var User */
    private $_user = false;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            [
                'username',
                'unique',
                'targetClass' => '\app\models\User',
                'message' => Yii::t('app', 'This username has already been taken.')
            ],
            ['username', 'string', 'length' => [3, 25]],
            [
                'username',
                'match',
                'pattern' => '/^[A-Za-z0-9_-]{3,25}$/',
                'message' => Yii::t(
                    'app',
                    'Your username can only contain alphanumeric characters, underscores and dashes.'
                )
            ],
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            [
                'email',
                'unique',
                'targetClass' => '\app\models\User',
                'message' => Yii::t('app', 'This email address has already been taken.')
            ],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],
        ];
    }

    /**
     * Signs user up.
     *
     * @return boolean the saved model or null if saving fails
     */
    public function signup()
    {
        if ($this->validate()) {
            $user = new User();
            $user->username = strtolower($this->username);
            $user->email = $this->email;
            $user->unconfirmed_email = $this->email;
            $user->role = User::ROLE_STAFF;
            $user->status = User::STATUS_PENDING;
            $user->picture = "assets/img/avatars/1.jpg";
            $user->setPassword($this->password);
            $user->generateAuthKey();

            $user->registration_ip = Yii::$app->request->userIP;

            if ($user->save(false)) {
                $this->_user = $user;
                return true;
            }

            return false;
        }
        return false;
    }

    /**
     * Return User object
     *
     * @return User
     */
    public function getUser()
    {
        return $this->_user;
    }

    /**
     * Send confirmation email
     *
     * @return bool
     */
    public function sendConfirmationEmail()
    {
        $data = [];
        $data["confirmURL"] = \Yii::$app->params['backendURL'] . '#/auth/confirm?id=' . $this->_user->id . '&auth_key=' . $this->_user->auth_key;
        $data["appName"] = \Yii::$app->name;
        $data["username"] = $this->_user->username;
        $data["disclaimer"] = "'You can reach us at support@dyntechnologies.net with any doubt.'";

        $mail = \Yii::$app->mailer
            ->compose(
                ['html' => 'signup-confirmation-html'],
                [
                    'data' => $data
                ]
            )
            ->setTo($this->email)
            ->setFrom([\Yii::$app->params['noreplyEmail'] => \Yii::$app->name])
            ->setSubject('Signup confirmation')
            ->send();

        return $mail;
    }
}
