var app = require('http').createServer(handler)
  , io = require('socket.io').listen(app)
  , fs = require('fs')
  , usernames = {}
  , messages = []
  , port = 8080;
io.set('log level', 0); // disable log message in console
io.set('transports', [
    'xhr-polling'
  , 'jsonp-polling'
  ,  'websocket'
  , 'flashsocket'
  , 'htmlfile'
  
  ]);

app.listen(port);
// need helper for log
// app.debug_log = function(log) { console.log(data); }

var socket_users = {};

function session_id_from_request(request) {
  var cookies = {};
  request.headers.cookie && request.headers.cookie.split(';').forEach(function( cookie ) {
    var parts = cookie.split('=');
    console.log('key: ' + parts[ 0 ].trim() );
    console.log('value: ' + parts[ 1 ].trim() );
    //cookies[ parts[ 0 ].trim() ] = ( parts[ 1 ] || '' ).trim();
  });
}

function get_sid(str_cookie) {
  var SID = '';
  str_cookie.split(';').forEach(function( cookie ) {
    var parts = cookie.split('=');
    if (parts[ 0 ].trim() === 'SID') {
        SID =  parts[ 1 ].trim();
    }
  });
  return SID;
}


function handler (req, res) {
  //get_cookie(req);
  //console.log(req.url);
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
              //var cookie = socket.handshake.headers['cookie'];
             // console.log(cookie);
             //console.log(socket.id); // this id is random generated for each connection
             socket.session_id = get_sid(socket.handshake.headers['cookie']);
             //console.log('Session ID: ' + socket.session_id);
             if ( socket_users[socket.session_id]  !== undefined ) {
                 socket.username = socket_users[socket.session_id].username;
                 socket_users[socket.session_id].socket_id = socket.id;
                 //socket.emit('resumechat', 'Admin', socket_users[socket.session_id] + ' comes back to chat');
                 socket.emit('updateusers', usernames);
                 socket.emit('loadmessage', messages);
                 socket.emit('updatechat', 'Admin', 'Your chat has been resumed.');
                 //socket.broadcast.emit('updatechat', 'Admin', socket_users[socket.session_id] + ' comes back to chat');
                 
                // add the client's username to the global list
                
                //
                // echo to client they've connected
                //socket.emit('updatechat', 'Admin', 'Hello ' + username +', welcome to chat.');

                // echo globally (all clients) that a person has connected
                //socket.broadcast.emit('updatechat', 'Admin', username + ' has join to chat room');
                // update the list of users in chat, client-side
        //		io.sockets.emit('loadmessage', messages);
        //		io.sockets.emit('updateusers', usernames);

                //update for other clients
                //socket.broadcast.emit('updateusers', usernames);

                 
             }
             
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
        socket_users[socket.session_id] = { username: username, socket_id: socket.id };
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
  // when the user disconnects. perform this
	socket.on('disconnect', function() {
        // need to check user has resummed chat, socket_id does not updated
        if ( socket_users[socket.session_id].socket_id === socket.id) {
            delete socket_users[socket.session_id];
            // remove the username from global usernames list
            delete usernames[socket.username];
            console.log('Delete user ' + socket.username);
            // update list of users in chat, client-side
            io.sockets.emit('updateusers', usernames);
            // echo globally that this client has left
            socket.broadcast.emit('updatechat', 'Admin', socket.username + ' has left chat room');
        }
	});
  //end disconnect
});