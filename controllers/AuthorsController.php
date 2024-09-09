<?php
namespace app\controllers;

use app\models\User;
use MongoDB\BSON\ObjectId;
use Yii;
use yii\rest\ActiveController;
use app\models\Author;
use yii\web\NotFoundHttpException;
use yii\web\UnauthorizedHttpException;

class AuthorsController extends ActiveController
{
    public $modelClass = 'app\models\Author';

    /**
     * Método ejecutado antes de cualquier acción para validar el token JWT.
     * Lanza una excepción si el token es inválido o no se proporciona.
     *
     * @author Anthony Santillan
     * @version 1 Creación de metodo
     *
     */
    public function beforeAction($action)
    {
        $authHeader = Yii::$app->request->getHeaders()->get('Authorization');
        if ($authHeader !== null && preg_match('/^Bearer\s+(.*)$/', $authHeader, $matches)) {
            $token = $matches[1];

            $user = new User();
            $decoded = $user->validateJwt($token);
            if ($decoded === null) {
                throw new UnauthorizedHttpException('Token no válido o expirado.');
            }
        } else {
            throw new UnauthorizedHttpException('No se ha proporcionado un token de autenticación.');
        }

        return parent::beforeAction($action);
    }

    /**
     * Método para obtener los detalles de un autor por su ID.
     * Lanza una excepción si el autor no se encuentra.
     *
     * @author Anthony Santillan
     * @version 1 Creación de metodo
     *
     * @param string $id El ID del autor.
     * @return Author El modelo del autor.
     * @throws NotFoundHttpException Si el autor no es encontrado.
     */
    public function actionView($id)
    {
        $author = Author::findOne(['_id' => new ObjectID($id)]);
        if ($author !== null) {
            return $author;
        }
        throw new NotFoundHttpException("Autor no encontrado");
    }

    /**
     * Método para crear un nuevo autor.
     * Valida los datos recibidos y guarda el modelo en la base de datos.
     * Retorna los errores de validación si los datos no son válidos.
     *
     * @author Anthony Santillan
     * @version 1 Creación de metodo
     *
     * @return Author|array El autor creado o los errores de validación.
     */
    public function actionCreate()
    {
        $author = new Author();
        $author->load(\Yii::$app->request->post(), '');

        if ($author->validate() && $author->save()) {
            return $author;
        }
        return $author->getErrors();
    }

    /**
     * Método para actualizar un autor existente por su ID.
     * Valida los datos recibidos y actualiza el modelo en la base de datos.
     * Lanza una excepción si el autor no se encuentra o el ID es inválido.
     *
     * @author Anthony Santillan
     * @version 1 Creación de metodo
     *
     * @param string $id El ID del autor.
     * @return Author|array El autor actualizado o los errores de validación.
     * @throws NotFoundHttpException Si el autor no es encontrado o el ID es inválido.
     */
    public function actionUpdate($id)
    {
        try {
            $mongoId = new ObjectId($id);
        } catch (\Exception $e) {
            throw new NotFoundHttpException("ID no válido");
        }

        $author = Author::findOne(['_id' => $mongoId]);

        if ($author === null) {
            throw new NotFoundHttpException("Autor no encontrado");
        }

        $request = Yii::$app->request->getBodyParams();

        $author->load($request, '');

        if ($author->validate() && $author->save()) {
            return $author;
        }
        return $author->getErrors();
    }

    /**
     * Método para eliminar un autor por su ID.
     * Lanza una excepción si el autor no se encuentra.
     *
     * @author Anthony Santillan
     * @version 1 Creación de metodo
     *
     * @param string $id El ID del autor.
     * @return array Mensaje de éxito.
     * @throws NotFoundHttpException Si el autor no es encontrado.
     */
    public function actionDelete($id): array
    {
        $author = Author::findOne(['_id' => $id]);
        if ($author === null) {
            throw new NotFoundHttpException("Autor no encontrado");
        }
        $author->delete();
        return ['mensaje' => 'Autor eliminado correctamente'];
    }
}
