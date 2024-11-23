// Define Pin Number
const int enablePin = 9;   // L293D #1
const int controlPin = 2;  // L293D #2

// State
int motorState = 0;
int motorRpm = 5800;  // 5800(RPM)

const char terminatorChar = '\n';

void setup() {
  pinMode(enablePin, OUTPUT);
  pinMode(controlPin, OUTPUT);
  digitalWrite(enablePin, LOW);
  Serial.begin(9600);  // 開啟串列通訊
}

void loop() {

  if (Serial.available() > 0) {
    String command = Serial.readStringUntil(terminatorChar);  // 讀取直到換行符
    command.trim();                                           // 移除前後的空白字元和換行符

    if (command == "start") {
      digitalWrite(controlPin, HIGH);
    }

    if (command == "stop") {
      digitalWrite(controlPin, LOW);
    }

    if (command.startsWith("speed:")) {
      int rpm = command.substring(6).toInt();  // 提取並轉換數值
      if (rpm >= 1000 && rpm <= 5800) {
        setMotorSpeed(rpm);
      }
    }
  }
}

void setMotorSpeed(int rpm) {
  int motorSpeed = map(rpm, 4000, 5800, 100, 255);
  analogWrite(enablePin, motorSpeed);
}
