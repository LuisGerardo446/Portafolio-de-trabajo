import numpy as np
import matplotlib.pyplot as plt

from sklearn.linear_model import LinearRegression

def f(x):
    np.random.seed(42)
    y = 0.1*x + 0.2*np.random.randn(x.shape[0])
    return y

x = np.arange(0,20,0.5)
y = f(x)

plt.scatter(x,y,label='data', color = 'blue')
plt.title('Datos')

from sklearn.linear_model import LinearRegression

regresion_lineal = LinearRegression()

regresion_lineal.fit(x.reshape(-1,1), y)

print('w =' + str(regresion_lineal.coef_) + ', b =' + str(regresion_lineal.intercept_))

nuevo_x = np.array([5])

prediccion = regresion_lineal.predict(nuevo_x.reshape(-1,1))

print(prediccion)

from sklearn.metrics import mean_squared_error

prediccion_entrenamiento = regresion_lineal.predict(x.reshape(-1,1))

prediccion_entrenamiento + regresion_lineal.predict(x.reshape(-1,1))

mse = mean_squared_error(y_true = y, y_pred = prediccion_entrenamiento)

rmse = np.sqrt(mse)

print("error cuadratico medio (mse) = " + str(mse))
print("raiz del error cuadratico medio (rmse) = " + str(rmse))

r2 = regresion_lineal.score(x.reshape(-1,1), y)

print("Coeficiente de determinacion r2 = " + str(r2))



    
