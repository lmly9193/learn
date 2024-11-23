nums = [i for i in range(1,2001)]
nums2 = filter(lambda x:x%5 == 2 and x%7== 1 and x%11 == 4 , nums)
print(list(nums2))
