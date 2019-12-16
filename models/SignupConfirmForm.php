<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\User;
/**
 * Signup Confirm form
 */
class SignupConfirmForm extends Model
{
    public $id;
    public $auth_key;
    public $plan = 1;
    /** @var User */
    private $_user = false;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'auth_key'], 'trim'],
            [['id', 'auth_key'], 'required'],
            [
                'id',
                'exist',
                'targetClass' => 'app\models\User',
                'filter' => [
                    'and',
                    ['status' => User::STATUS_PENDING],
                    'confirmed_at IS NULL',
                ],
                'message' => 'The ID is not valid.'
            ],
            ['auth_key', 'string', 'length' => 32],

            [
                'auth_key',
                'exist',
                'targetClass' => 'app\models\User',
                'message' => 'The auth key is not valid.',
                'filter' => function ($query) {
                    $query->andWhere(['status' => User::STATUS_PENDING])
                        ->andWhere(['id' => $this->id])
                        ->andWhere('confirmed_at IS NULL');
                    // var_dump($query->createCommand()->rawsql);
                    // $res = $query->all();
                    // return count($res) > 0;
                }
            ]
        ];
    }

    /**
     * Signs user up.
     *
     * @return boolean the saved model or null if saving fails
     */
    public function confirm()
    {
        if ($this->validate()) {
            $user = $this->getUserByID();

            // fill confirmed_at
            $user->confirmEmail();

            // generate access token
            $user->generateAccessTokenAfterUpdatingClientInfo(true);

            $user->generateTrialOrder($this->plan);

            // Send confirmation email
            $this->sendSignupSuccessEmail();

            return true;
        }
        return false;
    }

    /**
     * Finds user by [[id]]
     *
     * @return User|null
     */
    public function getUserByID()
    {
        if ($this->_user === false) {
            $this->_user = User::findOne($this->id);
        }

        return $this->_user;
    }

    public function sendSignupSuccessEmail()
    {
        $data = [];
        $data["username"] = $this->_user->username;
        $data["appName"] = Yii::$app->name;
        $data["loginURL"] = Yii::$app->params['backendURL'] . '#/login';
        $data["disclaimer"] = "'You can reach us at support@dyntechnologies.com.br with any doubt.'";

        $loginURL = Yii::$app->params['backendURL'] . '#/login';

        $email = \Yii::$app->mailer
            ->compose(
                ['html' => 'signup-success-html'],
                [
                    'data' => $data
                ]
            )
            ->setTo($this->_user->email)
            ->setFrom([Yii::$app->params['supportEmail'] => $data['appName']])
            ->setSubject('Signup completed')
            ->send();

        return $email;
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
}
