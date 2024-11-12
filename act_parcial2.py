from numpy import unique
from numpy import where
from matplotlib import pyplot
from sklearn.datasets import make_classification
from sklearn.cluster import KMeans

training_data, _ = make_classification(
    n_samples = 1000,
    n_features = 2,
    n_informative = 2,
    n_redundant = 0,
    n_clusters_per_class = 1,
    random_state = 4

    )
kmeans_model = KMeans(n_clusters = 2)

kmeans_model.fit(training_data)

kmeans_model = KMeans(n_clusters = 2)

kmeans_model.fit(training_data)

kmeans_result = kmeans_model.predict(training_data)

kmeans_clusters = unique(kmeans_result)

for kmeans_cluster in kmeans_clusters:
    index = where(kmeans_result == kmeans_cluster)
    pyplot.scatter(training_data[index,0], training_data[index,1])
    print(index)

pyplot.show()
