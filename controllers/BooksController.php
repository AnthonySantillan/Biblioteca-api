<?php
namespace app\controllers;

use app\models\Book;
use Yii;
use yii\rest\ActiveController;
use app\models\User;
use yii\web\NotFoundHttpException;
use yii\web\UnauthorizedHttpException;

class BooksController extends ActiveController
{
    public $modelClass = 'app\models\Book';

    /**
     * Método ejecutado antes de cada acción para validar el token JWT.
     * Si el token es inválido o no se proporciona, lanza una excepción.
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
     * Método para obtener un libro por su ID.
     * Lanza una excepción si el libro no es encontrado.
     *
     * @author Anthony Santillan
     * @version 1 Creación de metodo
     *
     * @param string $id El ID del libro.
     * @return Book El modelo del libro.
     * @throws NotFoundHttpException Si el libro no es encontrado.
     */
    public function actionView($id)
    {
        $book = Book::findOne(['_id' => $id]);
        if ($book !== null) {
            return $book;
        }
        throw new NotFoundHttpException("Libro no encontrado");
    }

    /**
     * Método para crear un nuevo libro.
     * Valida los datos recibidos y guarda el modelo en la base de datos.
     * Si los datos no son válidos, retorna los errores de validación.
     *
     * @author Anthony Santillan
     * @version 1 Creación de metodo
     *
     * @return Book|array El libro creado o los errores de validación.
     */
    public function actionCreate()
    {
        $book = new Book();
        $book->load(\Yii::$app->request->post(), '');
        if ($book->validate() && $book->save()) {
            return $book;
        }
        return $book->getErrors();
    }

    /**
     * Método para actualizar un libro existente por su ID.
     * Valida los datos recibidos y actualiza el modelo en la base de datos.
     * Lanza una excepción si el libro no es encontrado.
     *
     *
     * @author Anthony Santillan
     * @version 1 Creación de metodo
     *
     * @param string $id El ID del libro.
     * @return Book|array El libro actualizado o los errores de validación.
     * @throws NotFoundHttpException Si el libro no es encontrado.
     */
    public function actionUpdate($id)
    {
        $book = Book::findOne(['_id' => $id]);
        if ($book === null) {
            throw new NotFoundHttpException("Libro no encontrado");
        }
        $book->load(\Yii::$app->request->post(), '');
        if ($book->validate() && $book->save()) {
            return $book;
        }
        return $book->getErrors();
    }

    /**
     * Método para eliminar un libro por su ID.
     * Lanza una excepción si el libro no es encontrado.
     *
     *
     * @author Anthony Santillan
     * @version 1 Creación de metodo
     *
     * @param string $id El ID del libro.
     * @return array Mensaje de éxito.
     * @throws NotFoundHttpException Si el libro no es encontrado.
     */
    public function actionDelete($id)
    {
        $book = Book::findOne(['_id' => $id]);
        if ($book === null) {
            throw new NotFoundHttpException("Libro no encontrado");
        }
        $book->delete();
        return ['mensaje' => 'Libro eliminado correctamente'];
    }
}
