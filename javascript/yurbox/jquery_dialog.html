<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>dialog demo</title>
        <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css">
        <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
        <script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
        <style type="text/css">
            .no-close .ui-dialog-titlebar-close {
                display: none;
            }
        </style>
    </head>
    <body>
        <button id="opener">open the dialog</button>
        <div id="dialog" title="Dialog Title">I'm a dialog</div>
        <script>

            var dialog_html = $("<div title='My Dialog'>Hello world <a href='#' onclick='$(this).parent().dialog(\"close\");'>close</a></div>");
            $("#dialog").dialog({autoOpen: false, draggable: false});
            $("#opener").click(function() {
                $("#dialog").dialog("open");

                dialog_html.dialog({dialogClass: "no-close", position: ['top', 50],
                    minHeight: 100, minWidth: 400, draggable: false, closeOnEscape: false,
                    modal: true, title: "My Dialog Title", buttons: [{text: "Ok", click: function() {
                                $(this).dialog("close");
                            }}, {text: "Cancel", click: function() {
                                $(this).dialog("close");
                            }}]

                });
                //$( ".selector" ).dialog({ buttons: [ { text: "Ok", click: function() { $( this ).dialog( "close" ); } } ] });
            });


            $(window).resize(function() {
                $("#dialog").dialog("option", "position", "center");
                dialog_html.dialog("option", "position", "center");
                dialog_html.dialog("option", "position", "center");
                dialog_html.dialog({
                    position: ['top', 50]
                });
            });

            $(window).resize(function() {
                var wWidth = $(window).width();
                var dWidth = wWidth * 0.9;
                var wHeight = $(window).height();
                var dHeight = wHeight * 0.9;
                $("#data-dialog-id").dialog("option", "width", dWidth);
                $("#data-dialog-id").dialog("option", "height", dHeight);
            });

        </script>
        <!-- another dialog -->
        <p><a href="javascript:void(null);" onclick="showDialog();">Open</a></p>

        <div id="dialog-modal" title="Basic modal dialog" style="display: none;"></div>

        <script type="text/javascript">
            function showDialog()
            {
                $("#dialog-modal").dialog({
                    width: 600,
                    height: 400,
                    open: function(event, ui)
                    {
                        var textarea = $('<textarea style="height: 276px;">');
                        $(this).html(textarea);
                        $(textarea).redactor({autoresize: false});
                        $(textarea).setCode('<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>');
                    }
                });
            }
        </script>

    </body>
</html>