<?php
namespace app\modules\cart\models;
use Yii;

class User extends  \yii\db\ActiveRecord{

    public $comment;
    public $delivery;
    public $district;

    public static function tableName()
    {
        return 'user';
    }

    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required','message' => 'Необходимо заполнить «Ваше имя»'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],

            ['phone', 'filter', 'filter' => 'trim'],
            ['phone', 'required','message' => 'Необходимо заполнить «Телефон»'],

            ['comment', 'filter', 'filter' => 'trim'],

            ['address', 'filter', 'filter' => 'trim'],
            ['address', 'filter', 'filter' => function ($value) {
                if(!empty($value)){
                    $value = strip_tags($value);
                }
                return $value;
            }],
            ['address', 'required','message' => 'Необходимо заполнить «Адрес»'],
            ['district', 'filter', 'filter' => 'trim'],
        ];
    }

    public function sendEmail()
    {
        /* @var $user User */
        $user = User::findOne([
            'status' => User::STATUS_ACTIVE,
            'email' => $this->email,
        ]);

        if ($user) {
            if (!User::isPasswordResetTokenValid($user->password_reset_token)) {
                $user->generatePasswordResetToken();
            }

            if ($user->save()) {
                //var_dump($user->password_reset_token); exit;
                /*return \Yii::$app->mailer->compose(['html' => 'passwordResetToken-html', 'text' => 'passwordResetToken-text'], ['user' => $user])
                    ->setFrom([\Yii::$app->params['supportEmail'] => \Yii::$app->name . ' robot'])
                    ->setTo($this->email)
                    ->setSubject('Password reset for ' . \Yii::$app->name)
                    ->send();*/
                return \Yii::$app->mailer->compose(['html' => 'passwordResetToken-html'], ['user' => $user])
                    ->setFrom([\Yii::$app->params['supportEmail'] => \Yii::$app->name . ' robot'])
                    ->setTo($this->email)
                    ->setSubject('Password reset for ' . \Yii::$app->name)
                    ->send();
            }
        }

        return false;
    }
}