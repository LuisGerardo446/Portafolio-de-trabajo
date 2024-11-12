from numpy import unique
from numpy import where
from matplotlib import pyplot
from sklearn.datasets import make_classification
from sklearn.cluster import AffinityPropagation

training_data, _ = make_classification(
    n_samples = 1000,
    n_features = 2,
    n_informative = 2,
    n_redundant = 0,
    n_clusters_per_class = 1,
    random_state = 4
    )
affinity_model = AffinityPropagation(damping = 0.7)

affinity_model.fit(training_data)

affinity_result = affinity_model.predict(training_data)

affinity_clusters = unique(affinity_result)

for affinity_cluster in affinity_clusters:
    index = where(affinity_result == affinity_cluster)
    pyplot.scatter(training_data[index,0], training_data[index, 1])

pyplot.show()
