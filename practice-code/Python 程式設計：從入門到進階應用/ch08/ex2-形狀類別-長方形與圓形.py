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
class Rec(Shape):
    def __init__(self, name, a, b):
        super().__init__(name)
        self.a = a
        self.b = b
    def length(self):
        return 2*(self.a+self.b)
class Cir(Shape):
    def __init__(self, name, a):
        super().__init__(name)
        self.a = a
    def length(self):
        return 2*3.14*self.a
a = Shape('形狀')
t = Tri('三角形', 3, 4, 5)
r = Rec('長方形', 4, 5)
c = Cir('圓形', 5)
print(a.name)
print(t.name, '周長為', t.length())
print(r.name, '周長為', r.length())
print(c.name, '周長為', c.length())

