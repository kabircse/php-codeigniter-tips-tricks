var app = require('http').createServer(handler)
  , io = require('socket.io').listen(app)
  , fs = require('fs')
  , usernames = {}
  , messages = []
  , port = 8080;
io.set('transports', [
    'xhr-polling'
  , 'jsonp-polling'
  ,  'websocket'
  , 'flashsocket'
  , 'htmlfile'
  
  ]);

app.listen(port);

function handler (req, res) {
  fs.readFile(__dirname + '/index.html', function (err, data) {
    if (err) {
      res.writeHead(500);
      return res.end('Error loading index.html');
    }

    res.writeHead(200);
    res.end(data);
  });
  /*
   console.log((new Date()) + ' HTTP server. URL' + request.url + ' requested.');
    if (request.url === '/status') {
        response.writeHead(200, {'Content-Type': 'application/json'});
        var responseObject = {
            currentClients: clients.length,
            totalHistory: history.length
        }
        response.end(JSON.stringify(responseObject));
    } else {
        response.writeHead(404, {'Content-Type': 'text/plain'});
        response.end('Sorry, unknown url');
    }
   */
  //http://martinsikora.com/nodejs-and-websocket-simple-chat-tutorial
}

function html_escape(str) {
   return str.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;').replace(/'/g, '&apos;');
}
io.sockets.on('connection', function (socket) {
  /*
  socket.on('my other event', function (data) {
    console.log(data);
  });*/
  // when the client emits 'sendchat', this listens and executes
	socket.on('sendchat', function (data) {
        data = html_escape(data);
		// we tell the client to execute 'updatechat' with 2 parameters
        messages.push({username: socket.username, data: data});
		io.sockets.emit('updatechat', socket.username, data);
	});

  // add user
  socket.on('adduser', function(username) {
		// we store the username in the socket session for this client
		socket.username = username;
		// add the client's username to the global list
		usernames[username] = username;
        
        socket.emit('loadmessage', messages);
		socket.emit('updateusers', usernames);
		// echo to client they've connected
		socket.emit('updatechat', 'Admin', 'Hello ' + username +', welcome to chat.');
     
		// echo globally (all clients) that a person has connected
		socket.broadcast.emit('updatechat', 'Admin', username + ' has join to chat room');
		// update the list of users in chat, client-side
//		io.sockets.emit('loadmessage', messages);
//		io.sockets.emit('updateusers', usernames);
		
        //update for other clients
		socket.broadcast.emit('updateusers', usernames);
	});
  
  // end add user
  //disconnect
  // when the user disconnects.. perform this
	socket.on('disconnect', function(){
		// remove the username from global usernames list
		delete usernames[socket.username];
		// update list of users in chat, client-side
		io.sockets.emit('updateusers', usernames);
		// echo globally that this client has left
		socket.broadcast.emit('updatechat', 'Admin', socket.username + ' has left chat room');
	});
  //end disconnect
});