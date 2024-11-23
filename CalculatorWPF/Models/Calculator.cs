using System;

namespace CalculatorWPF.Models
{
    public class Calculator
    {
        public string DisplayText { get; set; }

        public decimal CurrentNumber { get; set; }

        public decimal LastNumber { get; set; }

        public bool HasResult { get; set; }

        public Calculator()
        {
            Clear();
        }

        public void Clear()
        {
            DisplayText = "0";
            CurrentNumber = 0m;
            LastNumber = 0m;
            HasResult = false;
        }

        public void AddDigit(char digit)
        {
            if (DisplayText == "0")
            {
                DisplayText = digit;
            }
            else
            {
                DisplayText = char.Parse(DisplayText.ToString() + digit);
            }
        }

        public void AddDecimal()
        {
            if (!DisplayText.ToString().Contains('.'))
            {
                DisplayText = char.Parse(DisplayText.ToString() + ".");
            }
        }

        public void DeleteDigit()
        {
            if (DisplayText.ToString().Length > 1)
            {
                DisplayText = char.Parse(DisplayText.ToString().Substring(0, DisplayText.ToString().Length - 1));
            }
            else
            {
                DisplayText = '0';
            }
        }

        public void Add()
        {
            LastNumber = CurrentNumber;
            CurrentNumber = decimal.Parse(DisplayText.ToString());
            DisplayText = '0';
        }

        public void Subtract()
        {
            LastNumber = CurrentNumber;
            CurrentNumber = decimal.Parse(DisplayText.ToString());
            DisplayText = '0';
        }

        public void Multiply()
        {
            LastNumber = CurrentNumber;
            CurrentNumber = decimal.Parse(DisplayText.ToString());
            DisplayText = '0';
        }

        public void Divide()
        {
            LastNumber = CurrentNumber;
            CurrentNumber = decimal.Parse(DisplayText.ToString());
            DisplayText = '0';
        }

        public void Equals()
        {
            switch (DisplayText)
            {
                case '+':
                    CurrentNumber = LastNumber + CurrentNumber;
                    break;
                case '-':
                    CurrentNumber = LastNumber - CurrentNumber;
                    break;
                case '*':
                    CurrentNumber = LastNumber * CurrentNumber;
                    break;
                case '/':
                    CurrentNumber = LastNumber / CurrentNumber;
                    break;
            }

            DisplayText = char.Parse(CurrentNumber.ToString());
        }

        public void ChangeSign()
        {
            CurrentNumber = CurrentNumber * -1;
            DisplayText = char.Parse(CurrentNumber.ToString());
        }

        public void Percent()
        {
            CurrentNumber = CurrentNumber / 100;
            DisplayText = char.Parse(CurrentNumber.ToString());
        }

        public void SquareRoot()
        {
            CurrentNumber = (decimal)Math.Sqrt((double)CurrentNumber);
            DisplayText = char.Parse(CurrentNumber.ToString());
        }

    }
}