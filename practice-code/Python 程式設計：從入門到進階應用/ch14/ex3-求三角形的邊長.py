import numpy as np
from scipy.spatial.distance import pdist, squareform
x = np.array([[0, 0], [3, 5], [5, 2]])
d = squareform(pdist(x, 'euclidean'))
dis = [d for d in d.reshape(1,9).tolist()[0] if d > 0]
print(set(dis))