using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace CalculatorWPF.Models
{
    internal class Operator
    {
        public static decimal Add(decimal num1, decimal num2)
        {
            return num1 + num2;
        }

        public static decimal Subtract(decimal num1, decimal num2)
        {
            return num1 - num2;
        }

        public static decimal Multiply(decimal num1, decimal num2)
        {
            return num1 * num2;
        }

        public static decimal Divide(decimal num1, decimal num2)
        {
            if (num2 != 0)
            {
                return num1 / num2;
            }
            else
            {
                throw new DivideByZeroException("除數不能為零。");
            }
        }

        public static decimal Negitive(decimal num)
        {
            return num * -1;
        }
    }
}
