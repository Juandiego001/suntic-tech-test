import argparse
import os

'''
  Crea un archivo y le agrega un número de lineas de texto de la forma:
  "Linea #"
  donde # corresponde al número de la línea.
  Por defecto crea 30 líneas si se especifica n se le indica la cantidad de
  líneas.
'''
def create_file(filename, lines):
  file = open(filename, 'w+')
  full_lines = ''
  for i in range(lines):
      full_lines += f'Línea {i}\n'
  file.write(full_lines)
  file.close()

'''
  Imprimir cada línea del archivo.
'''
def print_lines(filename, lines):
  if os.path.exists(filename):
    with open(filename) as file:
      full_lines = ''
      for i in file.readlines()[:lines]:
        full_lines += i
      print(full_lines)
  else:
    raise Exception(f'No existe el archivo con nombre {filename}')


if __name__ == '__main__':
  # Preparación del archivo para leer argumentos.
  parser = argparse.ArgumentParser(
    description='Ejecución inicial.py',
    formatter_class=argparse.ArgumentDefaultsHelpFormatter)
  parser.add_argument('-c', '--create-file', action='store_true', 
                      help='Crear archivo con su nombre de archivo y\
                        la cantidad de líneas deseadas')
  parser.add_argument('filename', help='Nombre del archivo')
  parser.add_argument('lines', nargs='?', default=30, help='Número')
  args = parser.parse_args()
  config = vars(args)

  if (config['create_file']):
    create_file(config['filename'], int(config['lines']))
  else:
    print_lines(config['filename'], int(config['lines']))



