<?php
namespace app\models;

use yii\mongodb\ActiveRecord;


class Author extends ActiveRecord
{
    /**
     * Define la colección de MongoDB
     */
    public static function collectionName()
    {
        return ['db_biblioteca', 'autores'];
    }

    /**
     * Atributos del modelo (columnas de la tabla o campos de la colección)
     */
    public function attributes()
    {
        return [
            '_id',
            'nombre_completo',
            'fecha_nacimiento'
        ];
    }

    /**
     * Reglas de validación
     */
    public function rules()
    {
        return [
            [['nombre_completo', 'fecha_nacimiento'], 'required'],
            ['fecha_nacimiento', 'date', 'format' => 'php:Y-m-d'],
            ['nombre_completo', 'string', 'max' => 255],
        ];
    }
}
