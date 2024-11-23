class NegativeException(Exception):
    def __init__(self,index):
        super().__init__(self)
        self.index=index
try:
    a = [1, 2, 3, 4]
    index = int(input('請輸入要存取的索引值？'))
    if index < 0:
        raise NegativeException(index)
    print(a[index])
except IndexError:
    print('輸入索引值超出範圍')
except NegativeException as ne:
    print('輸入索引值為', ne.index, '索引值為負值')
