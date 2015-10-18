#! /usr/bin/env python

from RPIO import PWM
import time
import sys

servo = PWM.Servo()

freq = int(float(sys.argv[1]));
print freq;

if (freq >= 100 and freq <= 2000):
        servo.set_servo(17, freq);
else:
        print "Value not in the 1000-2000 range!"

time.sleep(0.5)
servo.stop_servo(17)
