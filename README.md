# Evaluación Técnica de Ingreso - API REST de Gestión de Biblioteca

**Proyecto:** API REST para la Gestión de Biblioteca  
**Fecha:** Abril 2024  
**Proceso:** Gestión de Talento Humano - Incorporación  
**Código:** GTH-FOR-11  
**Versión:** v1.1  
**Aprobado por:** Jennifer Torres  
**Confidencialidad:** Nivel 4 - Clientes de Libélula Soft  

## Descripción del Proyecto

Este proyecto consiste en una **API REST** desarrollada en **PHP** utilizando el framework **Yii2** y la base de datos **MongoDB** para gestionar una biblioteca virtual. La API permite gestionar libros y autores, cumpliendo con los principios básicos de diseño de software, optimización de rendimiento y seguridad.

## Objetivos

El principal objetivo es permitir a los usuarios gestionar los recursos de la biblioteca a través de una API que incluya las siguientes funcionalidades:

- **Libros**: Crear, listar, actualizar y eliminar libros.
- **Autores**: Crear, listar, actualizar y eliminar autores.
- **Autenticación y Seguridad**: Protección mediante autenticación con tokens.
- **Validación y Manejo de Errores**: Validaciones exhaustivas para entradas de datos, y manejo adecuado de errores.

## Características

### 1. **Modelos de Datos y Relaciones**
- **Libros**: Cada libro tiene los siguientes atributos:
  - `título`: El título del libro.
  - `autores`: Lista de autores asociados al libro.
  - `año de publicación`: Año en que se publicó el libro.
  - `descripción`: Breve descripción del libro.
  
- **Autores**: Cada autor tiene los siguientes atributos:
  - `nombre completo`: Nombre del autor.
  - `fecha de nacimiento`: Fecha de nacimiento del autor.
  - `libros escritos`: Lista de libros que el autor ha escrito.

### 2. **Endpoints de la API**
#### **Libros**
- `GET /books`: Listar todos los libros.
- `GET /books/{id}`: Obtener detalles de un libro específico.
- `POST /books`: Crear un nuevo libro.
- `PUT /books/{id}`: Actualizar un libro existente.
- `DELETE /books/{id}`: Eliminar un libro.

#### **Autores**
- `GET /authors`: Listar todos los autores.
- `GET /authors/{id}`: Obtener detalles de un autor específico.
- `POST /authors`: Crear un nuevo autor.
- `PUT /authors/{id}`: Actualizar un autor existente.
- `DELETE /authors/{id}`: Eliminar un autor.

### 3. **Seguridad**
La API utiliza autenticación mediante **tokens**, los cuales tienen una expiración de 30 minutos, garantizando la seguridad de las operaciones.

### 4. **Validación y Manejo de Errores**
Se ha implementado validación estricta para los datos de entrada y un sistema de manejo de errores robusto que incluye:

- Verificación de que los campos obligatorios están presentes.
- Respuestas adecuadas con códigos de estado HTTP.
- Mensajes de error claros y útiles para el usuario final.

### 5. **Rendimiento**
Las operaciones que involucran la base de datos están optimizadas para asegurar un alto rendimiento en las consultas.

## Documentación

La API ha sido documentada utilizando **Swagger** para permitir la visualización y prueba interactiva de los endpoints. También se ha utilizado **Postman** para pruebas locales de los endpoints con ejemplos detallados.

### Solicitudes

#### Registro
```bash
POST /register
{
    "username": "Bastian",
    "password": "12345678"
}
```
####  Respuesta
```bash
{
    "message": "Usuario registrado correctamente",
    "user": {
        "username": "Bastian",
        "password_hash": "$2y$13$DSXpd3ZGm5797sq1v.A8OedkJqLb7x5cWBKt50HJeY8MThxZVasCy",
        "authKey": "q6NuY1-9XDSJ0Z0i-WwxtHzm07X-ZeOa",
        "accessToken": "RcuQQxdNqUzg7OchNJ1EG9NFn4VO9nJl",
        "_id": "66dea876d2751d5f9b050b82"
    }
}

```
#### Login
```bash
POST /login
{
  "username": "Bastian",
  "password": "12345678"
}
```
####  Respuesta
```bash
{
    "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE3MjU4NjgyNDUsImV4cCI6MTcyNTg3MDA0NSwidWlkIjoiNjZkZWE4NzZkMjc1MWQ1ZjliMDUwYjgyIiwidXNlcm5hbWUiOiJCYXN0aWFuIn0.r1oCsWdlK2fwEYgJ0QeC8fVp7LV-ogucjgqxoRRELc8"
}
```
#### Crear un Libro
```bash
POST /books
{
  "titulo": "Nombre del libro",
  "anio_publicacion": 2023,
  "descripcion": "Descripción del libro",
  "autor_id": ["66deb7035f7099d63d0385d0", "66deb4eb381cf6b9fb099b90"] // Lista de autores
}
```
#### Crear un Author
```bash
POST /authors
{
  "nombre_completo": "Alfredo Palacios",
  "fecha_nacimiento": "2001-08-20"
}
```
## Instalación y Configuración

### Pasos para la instalación:

1. Clonar el repositorio:
   ```bash
    [ git clone https://github.com/usuario/proyecto-biblioteca.git](https://github.com/AnthonySantillan/Biblioteca-api.git)
   ```
2. Ingresar al proyecto:
 ```bash
  cd biblioteca-api
 ```
3. Instalar dependencias:
 ```bash
 composer install
 ```
4. Levantar servidor:
 ```bash
 php yii serve
 ```

