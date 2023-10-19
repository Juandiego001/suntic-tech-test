from dotenv import load_dotenv
from apiflask import APIFlask, Schema, fields
from flask_sqlalchemy import SQLAlchemy
from werkzeug.utils import secure_filename
import os

load_dotenv()

app = APIFlask(__name__)
app['SQLALCHEMY_DATABASE_URI'] = os.getenv('SQLALCHEMY_DATABASE_URI')
db: SQLAlchemy = SQLAlchemy(app)

# Esquemas
class FileIn(Schema):
    nombrearchivo = fields.String(150)
    cantlineas = fields.Int()
    cantpalabras = fields.Int()
    cantcaracteres = fields.Int()
    fecharegistro = fields.String()

class FileOut(Schema):
    codigo = fields.Int()
    nombrearchivo = fields.String(150)
    cantlineas = fields.Int()
    cantpalabras = fields.Int()
    cantcaracteres = fields.Int()
    fecharegistro = fields.String()

class File(Schema):
    file = fields.File()

class Message(Schema):
    message = fields.String()

# Modelos
class File(db.Model):
    codigo = db.Integer(nullable=False, primary_key=True)
    nombrearchivo = db.String(150, nullable=False)
    cantlineas = db.Integer(nullable=False)
    cantpalabras = db.Integer(nullable=False)
    cantcaracteres = db.Integer(nullable=False)
    fecharegistro = db.Date(nullable=False)


@app.get('/')
def test():
    return {'message': 'Hello World'}

@app.put('/')
@app.input(File, location='files')
@app.output(Message)
def upload_file(files):
    f = files['file']
    filename = secure_filename(f.filename)
    f.save(filename)
    return {'message': 'File upload successfully'}

if __name__ == '__main__':
    app.run()
