#include <WiFi.h>
#include <HTTPClient.h>
#include <SPI.h>
#include <MFRC522.h>

// WiFi credentials
const char* ssid = "PLDTHOMEFIBR9ZWdG";
const char* password = "PLDTWIFIS2yHq";

// Server address
const char* serverName = "http://192.168.1.48/senti-shield/add_logs.php"; // Change to your local server IP

// RFID and Buzzer setup
#define SS_PIN 10
#define RST_PIN 21
MFRC522 rfid(SS_PIN, RST_PIN);  // Create MFRC522 instance

void setup() {
    Serial.begin(115200);
    SPI.begin(11, 12, 13);  // SCK, MISO, MOSI
    rfid.PCD_Init();        // Initialize the MFRC522

    Serial.println("RFID Reader Initialized");

    Serial.println("Connecting to WiFi...");
    WiFi.begin(ssid, password);
    while (WiFi.status() != WL_CONNECTED) {
        delay(1000);
        Serial.print(".");
    }
    Serial.println("\nConnected to WiFi");
    Serial.print("ESP32 IP Address: ");
    Serial.println(WiFi.localIP());
}

void loop() {
    // Look for new cards
    if (!rfid.PICC_IsNewCardPresent() || !rfid.PICC_ReadCardSerial()) {
        delay(50);
        return;
    }

    // Show UID on serial monitor
    Serial.print("UID tag: ");
    String rfidTag = "";
    for (byte i = 0; i < rfid.uid.size; i++) {
        Serial.print(rfid.uid.uidByte[i] < 0x10 ? " 0" : " ");
        Serial.print(rfid.uid.uidByte[i], HEX);
        rfidTag.concat(String(rfid.uid.uidByte[i] < 0x10 ? " 0" : " "));
        rfidTag.concat(String(rfid.uid.uidByte[i], HEX));
    }
    Serial.println();
    Serial.print("Message : ");
    rfidTag.toUpperCase();
    Serial.println(rfidTag);

    // Send data to server
    if (WiFi.status() == WL_CONNECTED) {
        WiFiClient client; // Create a WiFi client
        HTTPClient http;   // Create an HTTP client

        http.begin(client, serverName); // Specify the destination for the HTTP request
        http.addHeader("Content-Type", "application/x-www-form-urlencoded"); // Specify content-type header

        String httpRequestData = "rfid=" + rfidTag; // Prepare the data to send
        Serial.print("Sending HTTP POST request: ");
        Serial.println(httpRequestData);

        int httpResponseCode = http.POST(httpRequestData); // Send the POST request

        if (httpResponseCode > 0) {
            String response = http.getString();
            Serial.print("HTTP Response code: ");
            Serial.println(httpResponseCode); // Print the response code
            Serial.print("Server Response: ");
            Serial.println(response);         // Print the server's response
        } else {
            Serial.print("Error on sending POST: ");
            Serial.println(httpResponseCode);
            Serial.print("HTTPClient error: ");
            Serial.println(http.errorToString(httpResponseCode).c_str());
        }
        http.end(); // Free resources
    } else {
        Serial.println("WiFi Disconnected");
    }

    delay(1000); // Wait for a second before reading again
}