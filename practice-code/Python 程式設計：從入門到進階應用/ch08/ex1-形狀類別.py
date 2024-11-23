class Shape():
    def __init__(self, name):
        self.name = name
    def length(self):
        pass
class Tri(Shape):
    def __init__(self, name, a, b, c):
        super().__init__(name)
        self.a = a
        self.b = b
        self.c = c
    def length(self):
        return self.a+self.b+self.c
a = Shape('形狀')
t = Tri('三角形', 3, 4, 5)
print(a.name)
print(t.name, '周長為', t.length())

