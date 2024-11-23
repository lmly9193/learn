#include <Servo.h>
Servo myservo;
const int potPin = 0;
int potVal;
int angle;

void setup() {
  myservo.attach(9);
  Serial.begin(9600);
}

void loop() {
  potVal = analogRead(potPin);
  angle = map(potVal, 0, 1023, 0, 179); 
  Serial.println("PotVal: " + String(potVal) + "\t angle: " + String(angle));
  myservo.write(angle);
  delay(15);
}