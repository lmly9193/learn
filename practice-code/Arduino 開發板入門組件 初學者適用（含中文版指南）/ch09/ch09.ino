// 馬達應用
// 元件:
// 1. transistors
// 2. resistance 10k Ω
// 3. diode
// 4. motor
// 5. 9V battery
// 6. switch

const int switchPin = 2;
const int motorPin = 9;
int switchState = 0;

void setup() {
  Serial.begin(9600);
  pinMode(motorPin, OUTPUT);
  pinMode(switchPin, INPUT);
}

void loop() {
  switchState = digitalRead(switchPin);
  Serial.println("switchState: " + String(switchState));
  if (switchState == HIGH) {
    digitalWrite(motorPin, HIGH);
  } else {
    digitalWrite(motorPin, LOW);
  }
}
