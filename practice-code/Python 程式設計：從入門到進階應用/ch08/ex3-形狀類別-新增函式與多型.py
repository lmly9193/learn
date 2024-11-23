import math
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
    def area(self):
        s = self.length()/2
        return math.sqrt(s*(s-self.a)*(s-self.b)*(s-self.c))
class Rec(Shape):
    def __init__(self, name, a, b):
        super().__init__(name)
        self.a = a
        self.b = b
    def length(self):
        return 2*(self.a+self.b)
    def area(self):
        return self.a*self.b
class Cir(Shape):
    def __init__(self, name, a):
        super().__init__(name)
        self.a = a
    def length(self):
        return 2*3.14*self.a
    def area(self):
        return 3.14*self.a*self.a
def poly(obj):
    print(obj.name, '面積為', obj.area())
a = Shape('形狀')
t = Tri('三角形', 3, 4, 5)
r = Rec('長方形', 4, 5)
c = Cir('圓形', 5)
poly(t)
poly(r)
poly(c)

