#!/usr/bin/env python3

from tkinter import *
from tkinter import ttk

# tkinter
root = Tk()

# vars
input = StringVar()
last_input = DoubleVar()
op_mode = BooleanVar()
last_op = StringVar()


input.set('0')
last_input.set(0)
op_mode.set(False)

# functions
def set_number(number) :
    value = input.get()
    mode = op_mode.get()
    if mode is False :
        if number == 0 and value == '0' :
            pass
        elif number != 0 and value == '0' :
            value = str(number)
        else :
            value += str(number)
        input.set(value)
    else :
        last_input.set(float(value))
        input.set(str(number))
        op_mode.set(False)

def set_dot() :
    value = input.get()
    if '.' not in value :
        value += str('.')
        input.set(value)

def set_posi_negi() :
    value = input.get()
    number = float(value)
    if number > float(0) :
        value = str('-') + value
    elif number < float(0) :
        value = value.lstrip('-')
    else :
        pass
    input.set(value)

def operator(type) :

    current = float(input.get())
    last = last_input.get()
    if op_mode.get() is True :
        last_op.set(type)
    else :
        if last != 0 :
            if type == '+' :
                input.set(str(last + current))
            elif type == '-' :
                input.set(str(last - current))
            elif type == '*' :
                input.set(str(last * current))
            elif type == '/' :
                input.set(str(last / current))
            elif type == '%' :
                input.set(str(last % current))

        last_op.set(type)
        op_mode.set(True)

def clear() :
    input.set('0')
    last_input.set(0)
    op_mode.set(False)

def equal() :
    current = float(input.get())
    last = last_input.get()
    op = last_op.get()
    if op_mode.get() is True :
        pass
    else :
        if op == '+' :
            input.set(str(last + current))
        elif op == '-' :
            input.set(str(last - current))
        elif op == '*' :
            input.set(str(last * current))
        elif op == '/' :
            input.set(str(last / current))
        elif op == '%' :
            input.set(str(last % current))
        op_mode.set(True)
    
# gui
window = ttk.Frame(root)
result = ttk.Entry(window, text='0', textvariable=input , justify='right')

btn_正負 = ttk.Button(window, text="+/-", command=lambda: set_posi_negi())
btn_點 = ttk.Button(window, text=".", command=lambda: set_dot())

btn_零 = ttk.Button(window, text="0", command=lambda: set_number(0))
btn_一 = ttk.Button(window, text="1", command=lambda: set_number(1))
btn_二 = ttk.Button(window, text="2", command=lambda: set_number(2))
btn_三 = ttk.Button(window, text="3", command=lambda: set_number(3))
btn_四 = ttk.Button(window, text="4", command=lambda: set_number(4))
btn_五 = ttk.Button(window, text="5", command=lambda: set_number(5))
btn_六 = ttk.Button(window, text="6", command=lambda: set_number(6))
btn_七 = ttk.Button(window, text="7", command=lambda: set_number(7))
btn_八 = ttk.Button(window, text="8", command=lambda: set_number(8))
btn_九 = ttk.Button(window, text="9", command=lambda: set_number(9))

btn_加法 = ttk.Button(window, text="+", command=lambda: operator('+'))
btn_減法 = ttk.Button(window, text="-", command=lambda: operator('-'))
btn_乘法 = ttk.Button(window, text="*", command=lambda: operator('*'))
btn_除法 = ttk.Button(window, text="/", command=lambda: operator('/'))
btn_取於 = ttk.Button(window, text="%", command=lambda: operator('%'))

btn_清除 = ttk.Button(window, text="C", command=clear)
btn_倒退 = ttk.Button(window, text="<-")
btn_等於 = ttk.Button(window, text="=", command=equal)

# grid
window.grid(row=0, column=0)
result.grid(row=0, column=0, columnspan=4, sticky=(N, S, E, W))

btn_清除.grid(row=1, column=0)
btn_倒退.grid(row=1, column=1)
btn_取於.grid(row=1, column=2)
btn_除法.grid(row=1, column=3)

btn_七.grid(row=2, column=0)
btn_八.grid(row=2, column=1)
btn_九.grid(row=2, column=2)
btn_乘法.grid(row=2, column=3)

btn_四.grid(row=3, column=0)
btn_五.grid(row=3, column=1)
btn_六.grid(row=3, column=2)
btn_減法.grid(row=3, column=3)

btn_一.grid(row=4, column=0)
btn_二.grid(row=4, column=1)
btn_三.grid(row=4, column=2)
btn_加法.grid(row=4, column=3)

btn_正負.grid(row=5, column=0)
btn_零.grid(row=5, column=1)
btn_點.grid(row=5, column=2)
btn_等於.grid(row=5, column=3)

root.mainloop()
