var app = {
    session_id: null,
    flash_timer: false,
    orginal_title: document.title,
    user_left_window: false,
    flashAppTitle: function(newMessageTitle) {
        document.title = (document.title === app.orginal_title) ? newMessageTitle : app.orginal_title;
    },
    goto_last_message: function() {
        var convst = $("#conversation");
        //.attr("scrollHeight") for jqueyry version that is lower than 1.6
        convst.animate({scrollTop: convst.prop("scrollHeight") - convst.height()}, 500);
    },
    user_leave: function(leave) {
        app.user_left_window = leave;
    },
    startFlash: function(message) {
        app.flash_timer = setInterval("app.flashAppTitle('" + message + "')", 800);
    },
    unFlash: function() {
        if (app.flash_timer) {
            clearInterval(app.flash_timer);
            document.title = app.orginal_title;
        }
    },
    setCookie: function(name, value, days) {
        var exdate = new Date();
        exdate.setDate(exdate.getDate() + days); // expiry next 3 days
        document.cookie = name + '=' + escape(value) + '; expires=' + exdate.toUTCString() + '; path=/';
    },
    getCookie: function(name) {
        var cookies = document.cookie.split(';'), length = cookies.length, i, cookie, nameEQ = name + '=';
        for (i = 0; i < length; i += 1) {
            cookie = cookies[i];
            while (cookie.charAt(0) === ' ') {
                cookie = cookie.substring(1, cookie.length);
            }
            if (cookie.indexOf(nameEQ) === 0) {
                return cookie.substring(nameEQ.length, cookie.length);
            }
        }
        return null;
    },
    deleteCookie: function(name) {
        app.setCookie(name, '', -1);
    },
    log: function(data) {
        try {
            console.log(data);
        } catch (e) {
        }
    },
    prettyDate: function (time){
        //var date = new Date((time || "").replace(/-/g,"/").replace(/[TZ]/g," ")),
        var date = new Date();
        date.setTime(time);
        var diff = (((new Date()).getTime() - date.getTime()) / 1000),
            day_diff = Math.floor(diff / 86400);

        if ( isNaN(day_diff) || day_diff < 0 || day_diff >= 31 )
            return;

        return day_diff == 0 && (
                diff < 60 && "just now" ||
                diff < 120 && "1 minute ago" ||
                diff < 3600 && Math.floor( diff / 60 ) + " minutes ago" ||
                diff < 7200 && "1 hour ago" ||
                diff < 86400 && Math.floor( diff / 3600 ) + " hours ago") ||
            day_diff == 1 && "Yesterday" ||
            day_diff < 7 && day_diff + " days ago" ||
            day_diff < 31 && Math.ceil( day_diff / 7 ) + " weeks ago";
        },
         message: { 
                    tpl : function(message) {
                            var time_ago = app.prettyDate(message.created);
                            app.log(time_ago);
                            if (time_ago === undefined) {
                                time_ago= 'just now';
                            }
                            return '<p class="clearfix"><span class="username">' + message.username + 
                                    '</span><span class="message_item">' + message.data + 
                                    '</span><span class="message_date" title="'+message.created+'">'+time_ago+'</span></p>';
                    }
            } 

};

// on load of page
var socket = io.connect('http://nodejs-box-19648.apne1.actionbox.io:8080');
// on connection to server, ask for user's name with an anonymous callback
socket.on('connect', function() {
    app.log(socket.socket.sessionid);

    app.session_id = app.getCookie('SID');
    app.log('SESSION FROM CLIENT: ' + app.session_id);


    if (app.session_id === null) {
        app.setCookie('SID', socket.socket.sessionid, 1);
        // call the server-side function 'adduser' and send one parameter (value of prompt)
        $('#loading_chat').hide();
        $('#user_info').show();
    }
    else {
        // resuming chat for current user
        app.log('Resume chat for : ' + app.session_id);
        socket.emit('resume', app.session_id);
    }

});
// register new customer
socket.on('register', function(data) {
    $('#loading_chat').hide();
    $('#user_info').show();
    app.session_id = socket.socket.sessionid;
    app.setCookie('SID', app.session_id, 1);
});



// listener, whenever the server emits 'updatechat', this updates the chat body
socket.on('updatechat', function(username, data) {
    if (username === 'Admin') {
        $('#conversation').append('<p class="system_notify"><span>' + username + '</span> ' + data + '</p>');
    }
    else {
        $('#conversation').append('<p><span>' + username + '</span> ' + data + '</p>');
        // user does not active windows
        if (app.user_left_window) {
            app.unFlash();
            app.startFlash(username + ' messaged you');
        }

    }
    app.goto_last_message();
});
socket.on('newmessage', function(message) {
        $('#conversation').append(app.message.tpl(message));
        // user does not active windows
        if (app.user_left_window) {
            app.unFlash();
            app.startFlash(message.username + ' messaged you');
        }
    app.goto_last_message();
});

socket.on('loadmessage', function(messages) {
    // hide loading if it is visible
    $('#loading_chat').hide();
    for (i in messages) {
        $('#conversation').append(app.message.tpl(messages[i]));
    }
    $('#user_info').hide();
    $('#chat_area').show();
    app.goto_last_message();
    //update realtime date
    //$("span.message_date").prettyDate();
    setInterval(function(){ $("span.message_date").prettyDate(); }, 5000);
});

// listener, whenever the server emits 'updateusers', this updates the username list
socket.on('updateusers', function(data) {
    $('#users').empty();
    $.each(data, function(key, value) {
        $('#users').append('<li>' + key + '</li>');
    });
});

jQuery.fn.prettyDate = function(){
    return this.each(function(){
        //var date = prettyDate(this.title);
        var date = app.prettyDate(jQuery(this).attr('title'));
        if ( date ) {
            jQuery(this).text( date );
        }
    });
};
    
//----------- jQuery ----------------------
jQuery(function($) {
    //user leave windows
    $(window).blur(function() {
        app.user_leave(true);
    });
    // end flash new message
    $(window).focus(function() {
        app.user_leave(false);
        app.unFlash();
    });

    // when the client clicks Sign
    $('#sign_chat').click(function() {
        var username = $('#username').val();
        $('#username').val('');
        // tell server to execute 'sendchat' and send along one parameter
        socket.emit('adduser', username);
    });
    // when the client clicks SEND
    $('#datasend').click(function() {
        var message = $('#data').val().trim();
        // tell server to execute 'sendchat' and send along one parameter
        if (message !== '') {
            $('#data').val('');
            socket.emit('sendchat', message);

        }
    });

    // when the client hits ENTER on their keyboard
    $('#data').keypress(function(e) {
        if (e.which === 13) {
            $(this).blur();
            $('#datasend').focus().trigger('click');
            $(this).focus();
            return false;

        }
    });

});
