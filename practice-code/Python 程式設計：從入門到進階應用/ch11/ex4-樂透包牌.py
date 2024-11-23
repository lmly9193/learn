import itertools
nums = [4, 6, 7, 8, 11, 24, 35, 37, 40, 48]
comb = itertools.combinations(nums, 6)
for count, data in enumerate(list(comb),start=1):
    print(count, data)
