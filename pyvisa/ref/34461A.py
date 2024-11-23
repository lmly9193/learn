# https://blog.csdn.net/Jzy140222010108/article/details/125111682

import os
import time
import pyvisa
import csv


class DMM34461(object):
    Measurement_List = [""]
    """docstring for DMM34461"""

    def __init__(self):
        self.rm = pyvisa.ResourceManager()
        self.resource_str = self.rm.list_resources()[0]
        print(self.resource_str)
        self.Terminals = "FRON"
        self.ReadBuff = []
        self.idn_list = []

    def Connent_DMM(self, resourceName=""):
        if (resourceName != ""):
            self.resource_str = resourceName
        self.my_instrument = self.rm.open_resource(self.resource_str)
        self.my_instrument.read_termination = '\n'
        self.my_instrument.write_termination = '\n'
        self.ShowInstrumentMessage()

    def ShowInstrumentMessage(self):
        self.idn_list = self.my_instrument.query("*IDN?").split(",")
        print("Manufacturing: {0}".format(self.idn_list[0]))
        print("Model: {0}".format(self.idn_list[1]))
        print("SN: {0}".format(self.idn_list[2]))
        print("Version: {0}".format(self.idn_list[3]))

    def ResetDmm(self):
        self.my_instrument.write("*RST")  # h恢复出厂设置
        self.my_instrument.write("*CLS")
        ret = self.my_instrument.query("*TST?")
        if ret != "+0":
            print("self-test:{0}".format(ret))
        else:
            print("self-test:PASS")

        self.DmmDisplayView('NUMeric')
        pass

    def ReadConfig(self):
        ret = self.my_instrument.query("CONFigure?")

    def SetConfig(self, Measurementype, Range="DEF", Resolution="DEF"):
        if Measurementype == "CAP":
            cmd = "CONF:CAP 100".format(Range, Resolution)
            self.my_instrument.write(cmd)
            ret = self.my_instrument.query("READ?")

    def ConfigCurrentParameter(self, Measurementype, Range="DEF", Resolution="DEF"):
        CMD = "CONFigure:CURRent:{0} {1},{2}".format(
            Measurementype, Range, Resolution)
        print("Config", CMD)
        self.my_instrument.write(CMD)

    def MeasuremenDIODE(self):
        CMD = "CONF:DIOD"
        self.my_instrument.write(CMD)

    def MeasuremenFREQuencyORPERiod(self, Measurementype, Range="DEF", Resolution="DEF"):
        Measurementypes = ["FREQuency", "PERiod", "FREQ", "PER"]
        if Measurementype in Measurementypes:
            if Measurementype == "FREQuency" or Measurementype == "FREQ":
                CMD = "CONFigure:FREQuency {0},{1}".format(Range, Resolution)
                self.my_instrument.write(CMD)
            elif Measurementype == "PERiod" or Measurementype == "PER":
                CMD = "CONFigure:PERiod {0},{1}".format(Range, Resolution)
                self.my_instrument.write(CMD)
        else:
            print("Measurementype not support")

    def MeasuremenRESistanceORFRESistance(self, Measurementype, Range="DEF", Resolution="DEF"):
        Range = str.upper(Range)
        RangeNumber_Dic = {
            "100M":	100000000,
            "10M":	10000000,
            "1M":	1000000,
            "100K":	100000,
            "10K":	10000,
            "1K":	1000,
            "100": 0.1}
        Measurementypes = ["RESistance", "FRESistance", "RES", "FRES"]
        if Range in RangeNumber_Dic:
            Range = RangeNumber_Dic[Range]
        if Measurementype in Measurementypes:
            if Measurementype == "RESistance" or Measurementype == "RES":
                CMD = "CONFigure:RESistance {0},{1}".format(Range, Resolution)
                self.my_instrument.write(CMD)
            elif Measurementype == "FRESistance" or Measurementype == "FRES":
                CMD = "CONFigure:FRESistance {0},{1}".format(Range, Resolution)
                self.my_instrument.write(CMD)

        else:
            print("Measurementype not support")

    def ConfigVoltageParameter(self, Measurementype, Range="DEF", Resolution="DEF"):
        CMD = "CONFigure:VOLTage:{0} {1},{2}".format(
            Measurementype, Range, Resolution)
        print("send cmd", CMD)
        self.my_instrument.write(CMD)

    def CheckTerminals(self, Terminals):
        TerminalsTypes = ["FRON", "REAR"]
        Terminals = str.upper(Terminals)
        if Terminals in TerminalsTypes:
            ret = self.my_instrument.query("ROUTe:TERMinals?")
            if self.Terminals == ret:
                return True

            return False
        return False

    def Sample(self):
        self.my_instrument.write("SAMPle:COUNt 50")
        self.my_instrument.write("SAMPle:SOURce TIMer")

    def ReadBuff(self):
        ret = self.my_instrument.query("READ?", 1000)
        print("result {0}".format(ret))

    def Finish(self):
        del self.ReadBuff[:]
        pass

    def savebufftocsv(self, logpath):
        filename = logpath
        with open(filename, "w+") as csvfile:
            fieldnames = [
                'Manufacturing Information',
                'Device Model',
                "Device SN",
                "Version"
            ]
            writer = csv.DictWriter(csvfile, fieldnames=fieldnames)
            writer.writeheader()
            Device_Information = {
                'Manufacturing Information': self.idn_list[0],
                'Device Model': self.idn_list[1],
                'Device SN': self.idn_list[2],
                'Version': self.idn_list[3],
            }
            writer.writerow(Device_Information)
        with open(filename, "a+") as csvfile:
            fieldnames = ["ReadBuff"]
            writer = csv.DictWriter(csvfile, fieldnames=fieldnames)
            writer.writeheader()
            for buff in self.ReadBuff:
                print(buff)
                writer.writerow({"ReadBuff": buff})

    def DmmDisplay(self, displayStr):
        CMD = "DISPlay {0}".format("ON")
        self.my_instrument.write(CMD)
        CMD = "DISPlay:TEXT:DATA \"{0}\"".format(displayStr)
        self.my_instrument.write(CMD)

    def DmmDisplayClear(self):
        CMD = "DISPlay:TEXT:CLEar"
        self.my_instrument.write(CMD)

    def DmmDisplayView(self, ViewType):
        ViewTypes = ["NUMeric", "HISTogram", "TCHart", "METer"]
        # 数字、直方图、趋势图(在 34460A 上不可用)，或条形仪表、
        if ViewType in ViewTypes:
            CMD = "DISPlay:VIEW {0}".format(ViewType)
            self.my_instrument.write(CMD)

    def SetLimit(self, Limit_Low, Limit_Upp):
        self.LimitClea()
        CMD = "CALCulate:LIM:LOW {0}".format(Limit_Low)
        self.my_instrument.write(CMD)
        CMD = "CALCulate:LIM:UPP {0}".format(Limit_Upp)
        self.my_instrument.write(CMD)

    def LimitClea(self):
        CMD = "CALCulate:LIMit:CLEa"
        self.my_instrument.write(CMD)

    def SetLimitONOFF(self, SetLimitONOFF="OFF"):
        LinitStates = ["ON", "OFF", "0", "1"]
        if SetLimitONOFF in LinitStates:
            CMD = "CALCulate:LIM:STATe {0}".format(SetLimitONOFF)
            self.my_instrument.write(CMD)

    def ReadQuestionable(self):
        result = self.my_instrument.query("STATus:QUEStionable:CONDition?")

    def SetTrigerSource(self, Source):
        SourceTypes = ["IMMediate", "BUS", "EXTernal", "INTernal"]
        if Source in SourceTypes:
            self.my_instrument.write("TRIG:SOUR {0}".format(Source))
            self.my_instrument.write("TRIG:TRIG:DEL 2")

    def SetSampleCount(self, Count):
        Cmd = "SAMPle:COUNt {0}".format(Count)
        self.my_instrument.write(Cmd)

    def VoltageMeasuremen(self, VoltageType, Count=50, Range="DEF", Resolution="DEF", LimitLow=0, LimitUpp=0):
        print("VoltageMeasuremen parameter error")
        Range = str.upper(Range)
        VoltageType = str.upper(VoltageType)
        RangeNumber_Dic = {
            "1000V": 1000,
            "100V": 100,
            "10V": 10,
            "1V": 1,
            "100MV": 0.1
        }
        Measurementypes = ["AC", "DC"]
        if (VoltageType in Measurementypes) and (Range in RangeNumber_Dic):
            self.ConfigVoltageParameter(VoltageType, Range, Resolution)
            self.SetTrigerSource("BUS")
            self.SetSampleCount(Count)
            self.LimitClea()
            if LimitLow != 0 and LimitUpp != 0:
                self.SetLimit(LimitLow, LimitUpp)
                self.SetLimitONOFF("ON")
            self.my_instrument.write("INIT")
            self.my_instrument.write("*TRG")
            self.ReadBuff = self.my_instrument.query("FETC?").split(",")
            dmm.savebufftocsv("Voltage.csv")
        else:
            print("VoltageMeasuremen parameter error")

    def CurrentMeasuremen(self, CurrentType, Count=50, Range="DEF", Resolution="DEF"):
        print("CurrentMeasuremen", Range, Resolution)
        CurrentTypes = ["AC", "DC"]
        RangeNumber_Dic = {"3A": 3, "10A": 10}
        if (CurrentType in CurrentTypes) and (Range in RangeNumber_Dic):
            self.ConfigCurrentParameter(CurrentType, Range, Resolution)
            self.SetTrigerSource("BUS")
            self.SetSampleCount(Count)
            self.LimitClea()
            self.SetLimitONOFF("OFF")
            self.my_instrument.write("INIT")
            self.my_instrument.write("*TRG")
            self.ReadBuff = self.my_instrument.query("FETC?", 5).split(",")
            dmm.savebufftocsv("Current.csv")
        else:
            print("CurrentMeasuremen parameter error")


if __name__ == '__main__':

    dmm = DMM34461()
    dmm.Connent_DMM()
    dmm.ResetDmm()
    dmm.Finish()
    if dmm.CheckTerminals("FRON"):
        dmm.CurrentMeasuremen("DC", Count=5, Range="10A", Resolution=.00001)
        dmm.VoltageMeasuremen("DC", 200, "10V", 0.001, 4.5, 5.5)
        dmm.ReadQuestionable()
        print("测量完成")
    else:
        print("请切换段子")
    # dmm.ReadConfig()
    # dmm.SetConfig("CAP")
    # dmm.MeasuremenCurrentAC(3)
    # dmm.MeasuremenCurrentDC(10,0.001)
    # dmm.MeasuremenDIODE()
    # dmm.MeasuremenFREQuencyORPERiod("FREQ")
    # dmm.MeasuremenFREQuencyORPERiod("PER")
    # dmm.MeasuremenRESistanceORFRESistance("RES","100")
    # dmm.MeasuremenRESistanceORFRESistance("FRES","100")
