
const int greenLEDPin = 9;
const int redLEDPin = 11;
const int blueLEDPin = 10;
const int redSensorPin = A0;
const int greenSensorPin = A1;
const int blueSensorPin = A2;
int redValue = 0;
int greenValue = 0;
int blueValue = 0;
int redSensorValue = 0;
int greenSensorValue = 0;
int blueSensorValue = 0;

void setup() {
  Serial.begin(9600);
  pinMode(greenLEDPin, OUTPUT);
  pinMode(redLEDPin, OUTPUT);
  pinMode(blueLEDPin, OUTPUT);
}

void loop() {
  redSensorValue = analogRead(redSensorPin);
  delay(5);
  greenSensorValue = analogRead(greenLEDPin);
  delay(5);
  blueSensorValue = analogRead(blueLEDPin);
  delay(5);
  Serial.println("Raw Sensor Values \t Red: " + String(redSensorValue) + "\t Green: " + String(greenSensorValue) + "\t Blue: " + String(blueSensorValue));
  redValue = redSensorValue/4;
  greenValue = greenSensorValue/4;
  blueValue = blueSensorValue/4;
  Serial.println("Mapped Sensor Values \t Red: " + String(redValue) + "\t Green: " + String(greenValue) + "\t Blue: " + String(blueValue));
  analogWrite(redLEDPin, redValue);
  analogWrite(greenLEDPin, greenValue);
  analogWrite(blueLEDPin, blueValue);
}
