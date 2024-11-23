import os
from pyvisa import ResourceManager


class NP3000:
    def __init__(self):
        self.inst = ResourceManager().open_resource("GPIB0::7::INSTR")

    def write(self, command: str):
        self.inst.write(command)

    def query(self, command: str) -> str:
        return self.inst.query(command)

    def wait_for_srq(self):
        self.inst.wait_for_srq()

    def read_stb(self) -> int:
        code = self.inst.read_stb()
        if not 64 <= code <= 127:
            if code < 64:
                code += 64
            if code > 127:
                code -= 64
        return code

    def get_message(self) -> str:
        STBCode = {
            64: "GP-IB Initial Setting Done",
            65: "Absolute Value Travel Done",
            66: "Coordinate Travel Done",
            67: "Z-UP (Test Start)",
            68: "Z-DOWN",
            69: "Marking Done",
            70: "Wafer Loading Done",
            71: "Wafer Unloading Done",
            72: "Lot End",
            73: "",
            74: "Out of Probing Area",
            75: "Prober Initial Setting Done",
            76: "Error",
            77: "Index Setting Done",
            78: "Pass Counting Up Done",
            79: "Fail Counting Up Done",
            80: "Wafer Count",
            81: "Wafer End",
            82: "Cassette End",
            83: "",
            84: "Alignment Rejection Error",
            85: "Stop Command Received",
            86: "Print Data Receiving Done",
            87: "Warning Error",
            88: "Test Start (Count Not Needed)",
            89: "Needle Cleaning Done",
            90: "Probing Stop",
            91: "Probing Start",
            92: "Z-UP/Down Done",
            93: "Hot Chuck Cont. Command Received",
            94: "Lot Done",
            95: "",
            96: "",
            97: "",
            98: "Command Normally Done",
            99: "Command Abnormally Done",
            100: "Test Done Received",
            101: "(em command correct end)",
            102: "",
            103: "Map Data Down Loading Normally Done",
            104: "Map Data Down Load Abnormally Done",
            105: "Able to Adjust Needle Height",
            106: "",
            107: "Binary data up-loading start",
            108: "Binary data up-loading finish",
            109: "",
            110: "Needle Mark OK",
            111: "Needle Mark NG",
            112: "",
            113: "Re-Alignment Done",
            114: "Auto Needle Alignment Normally Done",
            115: "Auto Needle Alignment Abnormally Done",
            116: "Chuck Height Setting Done",
            117: "(Continuous Fail error)",
            118: "Wafer Loading Done",
            119: "Error Recovery Done (Wafer centering complete)",
            120: "Start Normally Done",
            121: "Start Abnormally Done",
            122: "Probe-mark inspection finish",
            123: "Fail-mark inspection finish",
            124: "",
            125: "",
            126: "",
            127: "",
        }
        return STBCode[self.read_stb()]


if __name__ == "__main__":
    os.system("cls")
    prober = NP3000()

    while True:
        try:
            prober.wait_for_srq()
            stb = prober.read_stb()
            print(f"STB: {prober.get_message()}")
            if stb == 67:
                rec = prober.query("O")
                print(f"Receive: {rec}")
            elif stb == 70:
                prober.write("Z")
            elif stb == 76:
                pass
        except Exception as e:
            print(f"Error: {e}")
        except KeyboardInterrupt:
            break
    prober.inst.close()
