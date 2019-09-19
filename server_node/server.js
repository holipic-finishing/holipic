/**************************************
*********  Import Socket IO   *********
***************************************/
require('dotenv').config({path: '../.env'});
var SOCKET_IO_PORT = process.env.SOCKET_IO_PORT;
var REDIS_PORT 	 = process.env.REDIS_PORT;

var fs = require('fs');
var https = require('https');
var app = require('express')();

var server = https.createServer({
    key: fs.readFileSync('../rsa_key/holipic.key'),
    cert: fs.readFileSync('../rsa_key/holipic.pem'),
}, app);

server.listen(SOCKET_IO_PORT);

var io = require('socket.io').listen(server);

io.set('transports', [
    'websocket',
    'flashsocket',
    'htmlfile',
    'xhr-polling',
    'jsonp-polling',
    'polling'
]);

console.log('Connectd to port ' + SOCKET_IO_PORT);

io.on('error', function(socket){
	console.log('error');
});

io.on('connection',function(socket){
	console.log('New User Connecttion '+ socket.id);

	// socket.on('join', function (joinRoom) {
    //     socket.join(joinRoom);
    //     console.log('a client has joined room '+ joinRoom);
    // });

    // socket.on('leave', function (leaveroom) {
    //     socket.leave(leaveroom);
    //     console.log('a client has leave room '+ leaveroom);
    // });
})


/***********************************************
*********  Connect with Redis Server   *********
*********    And run with port 6379    *********
************************************************/

var Redis = require('ioredis')
var redis = new Redis(REDIS_PORT)


/**********************************
*********  Listen event   *********
***********************************/
redis.psubscribe("*",function(error, count){
    console.log(error);
});

redis.on('pmessage',function(partner, channel, message){
	console.log('----------------Start------------------');
    console.log(channel + ": " + message);
    console.log('---------------------------------------');

	if(channel == 'view-listings') {
		message = JSON.parse(message);
	    io.emit(channel, message.data.notification);
	}


    if(channel == 'view-activity'){
        message = JSON.parse(message);
        io.emit(channel, message.data.activity);
    };
    console.log('----------------End-------------------');
})
