/**************************************
*********  Import Socket IO   *********
*********   with port 6000    *********
***************************************/

var io = require('socket.io')(6001)
console.log('Connectd to port 6001')
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
var redis = new Redis(6379)


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
