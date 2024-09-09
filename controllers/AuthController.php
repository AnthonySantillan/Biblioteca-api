<?php
namespace app\controllers;

use Yii;
use yii\rest\Controller;
use app\models\User;
use yii\web\UnauthorizedHttpException;

class AuthController extends Controller
{
    /**
     * Inicia sesión de un usuario.
     *
     * Este método verifica el nombre de usuario y la contraseña proporcionados en la solicitud y,
     * si son válidos, genera un token JWT para el usuario autenticado.
     *
     * @author Anthony Santillan
     * @version 1 Creación de metodo
     *
     * @return array Un arreglo que contiene el token JWT si la autenticación es exitosa.
     * @throws UnauthorizedHttpException Si el nombre de usuario o la contraseña son incorrectos.
     */
    public function actionLogin()
    {
        $request = json_decode(Yii::$app->request->getRawBody(), true);
        $username = $request['username'];
        $password = $request['password'];

        $user = User::findByUsername($username);

        if ($user && $user->validatePassword($password)) {
            $token = $user->generateJwt();
            return ['token' => $token];
        } else {
            throw new UnauthorizedHttpException('Nombre de usuario o contraseña incorrectos.');
        }
    }
}

