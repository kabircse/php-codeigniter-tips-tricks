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
  //console.log(req.headers);
    
  var mime_type = 'text/html';
  var file = __dirname + '/index.html';
  
  if (req.url === '/app.css') {
      var file = __dirname + '/app.css';
      mime_type = 'text/css';
  }
  if (req.url === '/app.js') {
      var file = __dirname + '/app.js';
      mime_type = 'application/javascript';
  }
  if (req.url === '/favicon.ico') {
        res.writeHead(200, {'Content-Type': 'text/plain'});
        return res.end('faivicon.ico');
  }
  
  fs.readFile(file, function (err, data) {
    if (err) {
      res.writeHead(500);
      return res.end('Error loading index.html');
    }
    	res.writeHead(200, {
				'Content-Type': mime_type,
				'Content-Length': data.length
			});
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
   //console.log(socket.namespace.manager.handshaken);
   // socket.session_id = get_sid(socket.handshake.headers['cookie']);
   //console.log('Session ID: ' + socket.session_id);
   console.log(socket.id);
   if ( socket_users[socket.id]  !== undefined ) {
       socket.username = socket_users[socket.id].username;
       socket_users[socket.id].id = socket.id;
       //socket.emit('resumechat', 'Admin', socket_users[socket.session_id] + ' comes back to chat');
       socket.emit('updateusers', usernames);
       socket.emit('loadmessage', messages);
       socket.emit('updatechat', 'Admin', 'Your chat has been resumed.');
   }
  // when the client emits 'sendchat', this listens and executes
	socket.on('resume', function (id) {
        console.log('Resume chat for socket id: ' + id);
         if ( socket_users[id]  !== undefined ) {
                 socket.username = socket_users[id].username;
                 //update new id
                 socket_users[id].id = socket.id;
                 //socket.emit('resumechat', 'Admin', socket_users[socket.session_id] + ' comes back to chat');
                 socket.emit('updateusers', usernames);
                 socket.emit('loadmessage', messages);
                 socket.emit('updatechat', 'Admin', 'Your chat has been resumed.');
             }
             else {
                 console.log('User not found, trigger create new user, update cookie to current socket id');
                 socket.emit('register', {refer: 'resume'});
             }
             //else, trigger new user
	});
    
	socket.on('sendchat', function (data) {
        data = html_escape(data);
        var created = new Date();
		// we tell the client to execute 'updatechat' with 2 parameters
        var message  = {username: socket.username, data: data, created: created.getTime()};
        messages.push(message);
		//io.sockets.emit('updatechat', socket.username, data);
        // to all user include this user
		io.sockets.emit('newmessage', message);
	});

  // add user
  socket.on('adduser', function(username) {
		// we store the username in the socket session for this client
        socket_users[socket.id] = { username: username, id: socket.id };
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
        if ( socket_users[socket.id] !== undefined && socket_users[socket.id].id === socket.id) {
            delete socket_users[socket.id];
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

//http://psitsmike.com/2011/09/node-js-and-socket-io-chat-tutorial
//http://psitsmike.com/2011/10/node-js-and-socket-io-multiroom-chat-tutorial
//http://net.tutsplus.com/tutorials/javascript-ajax/real-time-chat-with-nodejs-socket-io-and-expressjs/
//http://socket.io/#how-to-use
//http://davidwalsh.name/websocket
//http://www.stoimen.com/blog/2010/12/02/diving-into-node-js-a-long-polling-example
//http://www.contentwithstyle.co.uk/content/long-polling-example-with-nodejs/
//http://book.mixu.net/ch3.html
//http://stackoverflow.com/questions/13329129/nodejs-long-polling-pushing-rejeverse-ajax-what-do-i-need-to-push-live-data-i
//https://go-left.com/blog/programming/long-polling-with-node-js/
//http://www.gianlucaguarini.com/blog/nodejs-and-a-simple-push-notification-server/
//http://blog.nemikor.com/2010/05/21/long-polling-in-nodejs/
//https://developer.mozilla.org/en-US/docs/XPCOM_Interface_Reference/nsISocketTransportService
