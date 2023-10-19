# Ejercicio 2

## Requerimientos

Se sugiere crear un entorno virtual de python dentro de la carpeta _backend/_ e instalar los paquetes que se encuentran en el archivo de *requirements.txt*. Para esto realizar lo siguiente:

```console
cd /ejercicio-2/backend
python -m venv pyenv

# Activar el entorno virtual.
# Para Windows dirigirse a pyenv/Scripts/ y ejecutar activate.
# Para Linux y MAC dirigirse a pyenv/bin/ y ejecutar activate.
# Consultar activar el entorno en: https://docs.python.org/3/library/venv.html

pip install -r requirements.txt
```
## Variables de entorno
Crear un archivo de variables de entorno dentro de la carpeta _backend/_ de nombre _.env._ Agregar la variable:

```python
SQLALCHEMY_DATABASE_URI='mysql+mysqldb://<user>:<password>@<host>:<port>/datosdb'
```