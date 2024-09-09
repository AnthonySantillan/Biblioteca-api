<?php

namespace app\models;

use Yii;
use yii\mongodb\ActiveRecord;
use yii\web\IdentityInterface;
use Firebase\JWT\JWT;
use yii\web\UnauthorizedHttpException;

class User extends ActiveRecord implements IdentityInterface
{
    /**
     * Define la colección de MongoDB
     */
    public static function collectionName()
    {
        return ['db_biblioteca', 'usuarios'];
    }

    /**
     * Atributos del modelo
     */
    public function attributes()
    {
        return [
            '_id',
            'username',
            'password_hash',
            'authKey',
            'accessToken',
        ];
    }

    /**
     * Reglas de validación
     */
    public function rules()
    {
        return [
            [['username', 'password_hash'], 'required'],
            ['username', 'unique'],
        ];
    }

    /**
     * Encuentra un usuario por su ID.
     */
    public static function findIdentity($id)
    {
        return static::findOne(['_id' => $id]);
    }

    /**
     * Encuentra un usuario por su token de acceso.
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['accessToken' => $token]);
    }

    /**
     * Encuentra un usuario por nombre de usuario.
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    /**
     * Obtiene el ID del usuario.
     */
    public function getId()
    {
        return (string) $this->_id;
    }

    /**
     * Obtiene el authKey del usuario.
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * Valida el authKey del usuario.
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Valida la contraseña del usuario.
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Genera un hash de la contraseña.
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Genera un token JWT para el usuario.
     */
    public function generateJwt()
    {
        $issuedAt = time();
        $expirationTime = $issuedAt + 1800;
        $payload = [
            'iat' => $issuedAt,
            'exp' => $expirationTime,
            'uid' => $this->getId(),
            'username' => $this->username,
        ];

        return JWT::encode($payload, 'ASEQSAD1Q23QWASDFA2DS', 'HS256');
    }

    /**
     * Valida un token JWT.
     */
    public function validateJwt($token)
    {
        try {
            $headers = null;
            return JWT::decode($token, $this->getSecretKey(), $headers);
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Devuelve la clave secreta para la codificación del JWT.
     */
    private function getSecretKey()
    {
        return 'ASEQSAD1Q23QWASDFA2DS';
    }
}
