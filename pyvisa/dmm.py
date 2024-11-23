# 標準庫
import time

# 第三方庫
import pyvisa


class DMM34461A():
    '''This class is used to control the Keysight 34461A Digital Multimeter.'''

    def __init__(self, device_address=None):
        self.rm = pyvisa.ResourceManager()
        self.connect(device_address)

    def connect(self, device_address):
        '''Connect to the device. If the device address is not provided, the user will be prompted to select a device from the list of available devices.'''

        while device_address is None:
            resources = self.rm.list_resources()
            resources_count = len(resources)
            print(f'Devices found: {resources_count}')
            for i in range(resources_count):
                print(f'  {i + 1}. {resources[i]}')
            target = input('Please select a device: ')
            if target.isdigit() and 1 <= int(target) <= resources_count:
                device_address = resources[int(target) - 1]
            else:
                print('Invalid input. Please try again.')
        try:
            self.inst = self.rm.open_resource(device_address)
            if self.get_info()['Model'] != '34461A':
                raise Exception('Invalid device model')
        except Exception as e:
            self.inst = None
            print(f'Failed to connect [{device_address}], {e}')
            exit()

    def disconnect(self):
        '''Disconnect from the device.'''
        self.inst.close()
        self.inst = None
        
    def reset(self):
        '''Reset the device to its default settings.'''
        self.inst.write('*RST')

    def query(self, cmd):
        return self.inst.query(cmd)

    def write(self, cmd):
        return self.inst.write(cmd)

    def get_info(self):
        idn = self.query('*IDN?').strip().split(',')
        return {
            'Manufacturer': f'{idn[0]}',
            'Model': f'{idn[1]}',
            'Serial': f'{idn[2]}',
            'Revision': f'{idn[3]}'
        }

    def measure_resistance(self):
        self.inst.write('CONF:FRES')
        r = self.inst.query('READ?')
        r = float(r)
        return r

if __name__ == '__main__':
    # DEVICE_ADDRESS = 'GPIB0::22::INSTR'
    dmm = DMM34461A()

    if dmm.inst is not None:
        while True:
            print('1. Device Information')
            print('2. Measure Resistance')
            print('3. Exit')
            choice = input('Enter your choice: ')

            if choice == '1':
                print(dmm.get_info())
            elif choice == '2':
                r = dmm.measure_resistance()
                print(f'Measured Resistance: {r} Ω')
            elif choice == '3':
                break
            elif choice == '4':
                while True:
                    r = dmm.measure_resistance()
                    print(f'Measured Resistance: {r} Ω')
                    # time.sleep(1)
            else:
                print('Invalid choice')

        dmm.disconnect()
