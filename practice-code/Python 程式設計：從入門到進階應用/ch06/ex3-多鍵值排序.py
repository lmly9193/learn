score = [('John', 60, 70, 130), ('Tony', 80, 80, 160),('Mary', 70, 85, 155), ('Tina', 75, 90, 165)]
sort_score = sorted(score, key=lambda x: x[3], reverse=True)
print(sort_score)
