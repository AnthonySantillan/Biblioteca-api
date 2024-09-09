<?php
namespace app\models;

use yii\mongodb\ActiveRecord;

class Book extends ActiveRecord
{
    public static function collectionName()
    {
        return ['db_biblioteca', 'libros'];
    }

    public function attributes()
    {
        return [
            '_id',
            'titulo',
            'anio_publicacion',
            'descripcion',
            'autor_id',
        ];
    }

    public function rules()
    {
        return [
            [['titulo', 'anio_publicacion', 'descripcion', 'autor_id'], 'required'],
            ['anio_publicacion', 'integer'],
        ];
    }
}
