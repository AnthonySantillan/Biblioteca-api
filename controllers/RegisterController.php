<?php
namespace app\controllers;

use Yii;
use yii\rest\Controller;
use app\models\User;

class RegisterController extends Controller
{
    public function actionCreate()
    {
        $data = json_decode(Yii::$app->request->getRawBody(), true);

        if (!isset($data['username']) || !isset($data['password'])) {
            return ['error' => 'Faltan datos obligatorios: username o password.'];
        }

        $username = $data['username'];
        $password = $data['password'];

        if (User::findByUsername($username)) {
            return ['error' => 'El nombre de usuario ya existe.'];
        }

        $user = new User();
        $user->username = $username;
        $user->setPassword($password);
        $user->authKey = Yii::$app->security->generateRandomString();
        $user->accessToken = Yii::$app->security->generateRandomString();

        if ($user->save()) {
            return ['message' => 'Usuario registrado correctamente', 'user' => $user];
        } else {
            return ['error' => 'No se pudo registrar al usuario', 'details' => $user->getErrors()];
        }
    }
}

