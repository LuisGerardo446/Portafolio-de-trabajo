import numpy as np
import matplotlib.pyplot as plt
data = np.random.RandomState(0).rand(400)
(counts, bins, patches) = plt.hist(data)
plt.xlabel("Datos")
plt.ylabel("Eventos")
plt.show()


plt.hist(data, bins=12, density=True)
plt.xlabel("Datos")
plt.ylabel("Probabilidad")
plt.show

plt.hist(data, bins=12, density=True)
plt.hist(data, bins=12, density=True, cumulative=True, label="CFD", histtype="step")

plt.xlabel("Datos")
plt.ylabel("Probabilidad")
plt.show
