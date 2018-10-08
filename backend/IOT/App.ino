/*
 *  This sketch demonstrates how to set up a simple HTTP-like server.
 *  The server will set a GPIO pin depending on the request
 *    http://server_ip/gpio/0 will set the GPIO2 low,
 *    http://server_ip/gpio/1 will set the GPIO2 high
 *  server_ip is the IP address of the ESP8266 module, will be 
 *  printed to Serial when the module is connected.
 */

#include <ESP8266WiFi.h>
#include <Wire.h> 
#include <LiquidCrystal_I2C.h>
#include <SimpleTimer.h>

SimpleTimer timer;

const char* ssid = "iPhoneNK";
const char* password = "ketui2522";
int delaytime=0;
LiquidCrystal_I2C lcd(0x3F, 20, 4);

// Create an instance of the server
// specify the port to listen on as an argument
WiFiServer server(80);

void setup() {
  Serial.begin(115200);
  delay(10);
  
  // prepare GPIO2
  pinMode(D2, OUTPUT);
  digitalWrite(D2, 0);
  
  // Connect to WiFi network
  Serial.println();
  Serial.println();
  Serial.print("Connecting to ");
  Serial.println(ssid);
  
  WiFi.begin(ssid, password);
  lcd.begin();
  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
    lcd.clear();
    lcd.setCursor(0, 1);
    lcd.print("Not Connect WiFi");
  }
  Serial.println("");
  Serial.println("WiFi connected");
  
  // Start the server
  server.begin();
  Serial.println("Server started");

  // Print the IP address
  Serial.println(WiFi.localIP());
  lcd.clear();
  lcd.print(WiFi.localIP());
  delay(5000);
  lcd.clear();
  timer.setInterval(1000, repeatMe);
}

void repeatMe() {
 if(delaytime>0)
     {
      digitalWrite(D2, 1);
      delaytime--;
     }
  else
     digitalWrite(D2, 0);   
     Serial.println(delaytime);
}

void loop() {
  timer.run();
  // Check if a client has connected
  WiFiClient client = server.available();
  if (!client) {
    timer.run();
    return;
  }
  
  // Wait until the client sends some data
  Serial.println("new client");
  while(!client.available()){
    timer.run();
    delay(1);
  }
  
  // Read the first line of the request
  String req = client.readStringUntil('\r');
  Serial.println(req);
  client.flush();
  
  // Match the request
  int val;
  
  String buffer1,buffer2,buffer3,buffer4,buffer5;
  int ind1,ind2,ind3,ind4,ind5;
  //int location=req.indexOf("/msg/");

  ind1=req.indexOf("/");
  buffer1=req.substring(0,ind1);
  ind2=req.indexOf("/",ind1+1);
  buffer2=req.substring(ind1+1,ind2);
  ind3=req.indexOf("/",ind2+1);
  buffer3=req.substring(ind2+1,ind3);
    
  ind4=req.indexOf("/",ind3+1);
  buffer4=req.substring(ind3+1,ind4);

  ind5=req.indexOf("/",ind4+1);
  buffer5=req.substring(ind4+1,ind5-5);  
  
  client.flush();

  // Prepare the response
  String s = "HTTP/1.1 200 OK\r\nContent-Type: text/html\r\n\r\n<!DOCTYPE HTML>\r\n<html>\r\n";
  //s += (val)?"high":"low ";
 // s += buffer1;
//  s += "<br>";
  s += buffer2;
  s += "<br>";
  s += buffer3;
  s += "<br>";
  s += buffer4;
  s += "<br>";
  s += buffer5;
  s += "<br>";
  s += "</html>\n";

 

  // Send the response to the client
  client.print(s);
  client.flush();
  client.stop();
  delay(1);
  Serial.println("Client disonnected");
  
lcd.clear();  
lcd.setCursor(0, 0);lcd.print(buffer2); 
lcd.setCursor(0, 1);lcd.print(buffer3); 
lcd.setCursor(0, 2);lcd.print(buffer4); 
lcd.setCursor(0, 3);lcd.print(buffer5); 
delaytime=10;  

  // The client will actually be disconnected 
  // when the function returns and 'client' object is detroyed
}

