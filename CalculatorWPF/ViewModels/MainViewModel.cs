using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Input;
using CalculatorWPF.Models;

namespace CalculatorWPF.ViewModels
{
    public class MainViewModel: ViewModel
    {
        // 計算器
        private Calculator Calculator { get; } = new();

        // 當前的計算值
        private double _currentValue;

        // 儲存的值，用於連續運算
        private double _storedValue;

        // 儲存當前操作符
        private string _currentOperation;

        // 判斷是否為新的輸入
        private bool _isNewInput;

        // 數字顯示
        private string _displayText;
        public string DisplayText
        {
            get { return _displayText; }
            set { _displayText = value; OnPropertyChanged(nameof(DisplayText)); }
        }

        public ICommand InputCommand { get; }
        public ICommand OperateCommand { get; }
        public ICommand EqualsCommand { get; }
        public ICommand ClearCommand { get; }

        public MainViewModel()
        {
            DisplayText = "0";
            _currentValue = 0;
            _storedValue = 0;
            _isNewInput = true;

            NumberCommand = new RelayCommand<string>(ExecuteNumberCommand);
            OperationCommand = new RelayCommand<string>(ExecuteOperationCommand);
            EqualsCommand = new RelayCommand(ExecuteEqualsCommand);
            ClearCommand = new RelayCommand(ExecuteClearCommand);
        }

        public ICommand AddDigitCommand { get; }
        private void AddDigit(char digit)
        {
            _calculator.AddDigit(digit);
            DisplayText = _calculator.DisplayText.ToString();
        }

    }
}
