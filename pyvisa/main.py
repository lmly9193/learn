import time
import datetime
from pyvisa import ResourceManager, constants


rm = ResourceManager()
instr = rm.open_resource('GPIB0::7::INSTR')

while True:
    # dt = datetime.datetime.now().isoformat()
    instr.wait_for_srq()
    status_byte = instr.read_stb()
    command = int(status_byte) + 64
    print(f'STB: {command}')
    if command == 70:
        instr.write('Z')
    elif command == 76:
        instr.write('ANC')
    
    
    # print(f"Status Byte: {status_byte}")
    # if command:
    #     print(f'[{dt}]{command}')
