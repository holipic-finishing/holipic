/**************************************
*********  Import Socket IO   *********
***************************************/
require('dotenv').config({path: '../.env'})

var SOCKET_IO_PORT = process.env.SOCKET_IO_PORT
var REDIS_PORT 	 = process.env.REDIS_PORT

var io = require('socket.io')(SOCKET_IO_PORT)
console.log('Connectd to port ' + SOCKET_IO_PORT)

io.on('error', function(socket){
	console.log('error')
})
io.on('connection',function(socket){
	console.log('New User Connecttion '+ socket.id)
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
redis.psubscribe('*');
redis.on('pmessage',function(partner, channel, message){
	console.log(channel)
	console.log(message)
	console.log(partner)
	
	message = JSON.parse(message);
    io.emit(channel, message.data.notification);
    console.log('Sent');
})
