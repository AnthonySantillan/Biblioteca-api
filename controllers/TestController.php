<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;

class TestController extends Controller
{
    public function actionTestConnection()
    {
        try {
            $collection = Yii::$app->mongodb->getCollection('usuarios'); // Asegúrate de que la colección exista
            $document = $collection->findOne(); // Busca un documento para verificar la conexión
            return $this->asJson(['status' => 'Conexión exitosa', 'document' => $document]);
        } catch (\Exception $e) {
            return $this->asJson(['status' => 'Error en la conexión', 'error' => $e->getMessage()]);
        }
    }
}
