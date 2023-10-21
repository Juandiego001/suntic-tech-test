from datetime import datetime
from dotenv import load_dotenv
from apiflask import APIFlask, Schema, abort, fields
from flask_cors import CORS
from flask_migrate import Migrate
from flask_sqlalchemy import SQLAlchemy
from werkzeug.utils import secure_filename
import os

load_dotenv()

app = APIFlask(__name__)
CORS(app)
app.config['SQLALCHEMY_DATABASE_URI'] = os.getenv('SQLALCHEMY_DATABASE_URI')
db: SQLAlchemy = SQLAlchemy(app)

# Esquemas
class FileOut(Schema):
    codigo = fields.Integer()
    nombrearchivo = fields.String()
    cantlineas = fields.Integer()
    cantpalabras = fields.Integer()
    cantcaracteres = fields.Integer()
    fecharegistro = fields.String()

class Files(Schema):
    items = fields.List(fields.Nested(FileOut))

class TheFile(Schema):
    file = fields.File()

class Message(Schema):
    message = fields.String()

# Modelos
class Information(db.Model):
    __tablename__ = 'informacion'

    codigo = db.Column(db.Integer(), nullable=False, primary_key=True,
                       autoincrement=True)
    nombrearchivo = db.Column(db.String(250), nullable=False)
    cantlineas = db.Column(db.Integer(), nullable=False)
    cantpalabras = db.Column(db.Integer(), nullable=False)
    cantcaracteres = db.Column(db.Integer(), nullable=False)
    fecharegistro = db.Column(db.Date(), nullable=False)

migrate: Migrate = Migrate(app, db)

@app.get('/')
@app.output(Files)
def get_files_info():
    return {'items': [FileOut().dump(info) for info in Information.query.all()]}

@app.post('/')
@app.input(TheFile, location='files')
@app.output(Message)
def upload_the_file(files_data):
    try:
        f = files_data['file']
        filename = secure_filename(f.filename)

        lines = 0
        words = 0
        chars = 0
        for line in f.readlines():
            words += len(line.split())
            lines += 1
            for c in line:
                if c != ' ' and c != '\n':
                    chars += 1


        information = Information(nombrearchivo=filename, cantlineas=lines, 
                                  cantpalabras=words, cantcaracteres=chars,
                                  fecharegistro=datetime.now())
        db.session.add(information)
        db.session.commit()
        return {'message': 'File upload successfully'}
    except Exception as ex:
        abort(500, str(ex))

if __name__ == '__main__':
    app.run(debug=True)
