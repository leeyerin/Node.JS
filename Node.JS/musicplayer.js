var awsIot = require('aws-iot-device-sdk');
var Gpio = require('../onoff').Gpio,
    LED = new Gpio(18, 'out');
Omx = require('node-omxplayer');

var player;
var i = 0;
var array = ["/home/pi/deviceSDK/1.mp3", "/home/pi/deviceSDK/2.mp3"];
player = Omx('/home/pi/deviceSDK/1.mp3');


var connect = false;
var connectMsg = false;

if (LED.readSync() == 1) {
    i++;

    player.quit();

    player = Omx(array[i]);

}

var device = awsIot.device({
    keyPath: ' ',
    certPath: ' ',
    caPath: ' ',
    clientId: ' ',
    host: ' '
});



//메시지 보내는거

device.on('connect', function () {

    device.subscribe('LED-receive-topic');

    device.publish('LED-send-topic', JSON.stringify({ test_data: 'connect...' }));

    console.log("Message  send Succesfully");

    connectMsg = true;

});



//메시지 받아서 처리

device.on('message', function (topic, payload) {

    var payload = JSON.parse(payload.toString());

    //show the incoming message

    console.log(payload.light);

    if (topic == 'LED-receive-topic') {

        if (payload.light == 'on') {

            //player.pause();

            LED.writeSync(1);

            i++;

            player.quit();

            player = Omx(array[i]);


        } else {

            LED.writeSync(0);

        }



        if (LED.readSync() == 1) {

            i++;

            player.quit();
            player = Omx(array[i]);

        } else {
            player.nextAudio();
        }

    }
});


