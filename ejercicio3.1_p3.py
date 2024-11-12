import pandas as pd
import matplotlib.pyplot as plt
import math




datos = pd.read_csv('DAV2.csv',header=0, index_col = False, encoding="latin1")
print(datos)
print(datos.info())
print(datos.shape)




datos['Municipio'] = datos [ 'Municipio'].replace('Gpe', 'Guadalupe')
datos['Municipio'] =datos['Municipio'].replace('San Nicolás', 'San Nicolás de los Garza')
datos['Municipio'] = datos['Municipio'].replace('Mty', 'Monterrey')
datos[ 'Municipio'] = datos[ 'Municipio' ].replace('Escobedo', 'General Escobedo')
fig, plot = plt.subplots()
datos.groupby('Municipio').count()['Matricula'].plot(kind='pie'), plt.legend(loc='best', ncol=3, framealpha=0.3, bbox_to_anchor=[1.5,0])
plt.xlabel(None)
plt.ylabel(None)
plt.title('Alumnos por Municipio')

plt.savefig('Mi primer grafica pye en python.pdf')

fig, plot = plt.subplots()
datos.groupby('Spadres').count()['Matricula'].plot(kind='bar'), plt.savefig('Mi primer grafica barras en python.pdf')
plt.xlabel('Situación de los padres'), plt.ylabel('Cantidad de alumnos')
plt.title('Alumnos por situación de los padres')
plt.savefig('Mi primer grafica barras en python.pdf')
fig, plot = plt.subplots()
datos.plot('ExaIngMat', 'ExaIngEspa', kind='scatter') 
plt.savefig('Mi primer grafica puntos dispersos en python.pdf')
plt.xlabel('Promedio matemáticas')
plt.ylabel('Promedio español')
plt.title('Matemáticas vs. español')
plt.savefig('Mi primer grafica puntos dispersos en python.pdf')
fig, plot = plt.subplots() # preparar un gráfico con matplotlib rango datos [ 'ExaIngCN'].max() datos['ExaIngCN'].min() -
print("Rango: ", rango)
intervalos = 1 +3.3* math.log10(rango), print("intervalos: ", intervalos)
amplitud = round(rango / round(intervalos, 0))
print("Amplitud: " , amplitud)
plot.hist(x=datos['ExaIngCN'], bins = amplitud, color='red', density=False, facecolor='b')
plt.grid(True)
plt.xlabel('Ingreso en Ciencias Naturales')
plt.ylabel('Frecuencia')
plt.title('Histograma')

plt.savefig('Mi primer grafica histograma en python.pdf')
