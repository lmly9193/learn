using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Input;

namespace CalculatorWPF.Commands
{
    public class ClearCommand : ICommand
    {
        private readonly CalculatorViewModel _viewModel;

        public ClearCommand(CalculatorViewModel viewModel)
        {
            _viewModel = viewModel;
        }

        public bool CanExecute(object? parameter)
        {
            return _viewModel.Display != "0";  // 只有當顯示不為 "0" 時才可執行
        }

        public void Execute(object? parameter)
        {
            _viewModel.Display = "0";
        }

        public event EventHandler? CanExecuteChanged
        {
            add { CommandManager.RequerySuggested += value; }
            remove { CommandManager.RequerySuggested -= value; }
        }
    }

}
