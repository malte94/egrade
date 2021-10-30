/* 
      _____               _      
     |  __ \             | |     
  ___| |  \/_ __ __ _  __| | ___ 
 / _ \ | __| '__/ _` |/ _` |/ _ \
|  __/ |_\ \ | | (_| | (_| |  __/
 \___|\____/_|  \__,_|\__,_|\___|
                                 
 
Code & Design (C) 2020 by Timo Nolze & Malte Hoch

*/

"use strict";

/* ################################################################### */
/* ##################### INIITAL CONFIGURATION  ###################### */
/* ################################################################### */

/* ##################### CFG ####################### */

var breakpointS = 690;
var breakpointL = 900;
var datetime = null,
        date = null;
        moment.locale('de');
toastr.options = {
    //"debug": false,
    "positionClass": "toast-bottom-right",
    //"onclick": null,
    //"fadeIn": 300,
    "fadeOut": 6000,
    "escapeHtml": true
    //"timeOut": 5000,
    //"extendedTimeOut": 1000
    }

/* ##################### GLOBAL FUNCTIONS ################### */

/* Load Scripts Async and Once (see routes.js for views) */

jQuery.loadScript = function (url, callback) {
    jQuery.ajax({
        url: url,
        dataType: 'script',
        success: callback,
        async: true
    });
}

var update = function () {
    date = moment(new Date())
    datetime.html(date.format('Do MMMM YYYY <br> HH:mm:ss'));
};

function isMobileDevice() {
    return window.innerWidth <= breakpointS || window.innerHeight <= breakpointS;
}

function isTabletDevice() {
    return window.innerWidth <= breakpointL || window.innerHeight <= breakpointL;
}

function MainMenu() {
    if (Cookies.get('menuToggled') == '1') {
        if (isMobileDevice()) {
            $('.grid-main').css('grid-template-columns', ""); // "" resets to default
            Cookies.set('menuToggled', '0');
            // I do this because after every initial load, the menu must be closed in mobile view.
        }
        else {
            $('.grid-main').css('grid-template-columns', ""); // "" resets to default
        }
    }
    else {
        if (isMobileDevice()) {
            $('.grid-main').attr('class', 'grid-main'); // Resets all sub-classes
            $('.grid-main').css('grid-template-columns', ""); // "" Resets to default value 
            $('.grid-main').toggleClass("closedMenu");
            $('.main-menu').css("display", "none");
        }
        else {
            $('.grid-main').attr('class', 'grid-main'); // Resets all sub-classes
            $('.grid-main').css('grid-template-columns', ""); // "" Resets to default value 
            $('.grid-main').toggleClass("smallMenu");
            $('.main-menu').css("display", "flex");
            $('nav span.mobileHandler').css('display', 'none');
        }
      }
    }

function makeid(length) {
    var result           = '';
    var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    var charactersLength = characters.length;
    for ( var i = 0; i < length; i++ ) {
        result += characters.charAt(Math.floor(Math.random() * charactersLength));
    }
    return result;
}

function MsgBox($message, $type, $time) {
    $("<div class='MsgBox  " + $type + " '><span>" + $message + "</span></div>").appendTo(".grid-main").hide().fadeIn(500);
        setTimeout(function() {
            $(".MsgBox ").fadeOut(500, function(){ 
                $(".MsgBox ").remove(); 
            });;
        }, $time);

}

function debouncer( func , timeout ) {
    var timeoutID , timeout = timeout || 200;
    return function () {
       var scope = this , args = arguments;
       clearTimeout( timeoutID );
       timeoutID = setTimeout( function () {
           func.apply( scope , Array.prototype.slice.call( args ) );
       } , timeout );
    }
 }

 function setZoom(zoom,el) {
      
    transformOrigin = [0,0];
      el = el || instance.getContainer();
      var p = ["webkit", "moz", "ms", "o"],
          s = "scale(" + zoom + ")",
          oString = (transformOrigin[0] * 100) + "% " + (transformOrigin[1] * 100) + "%";

      for (var i = 0; i < p.length; i++) {
          el.style[p[i] + "Transform"] = s;
          el.style[p[i] + "TransformOrigin"] = oString;
      }

      el.style["transform"] = s;
      el.style["transformOrigin"] = oString;
    
}

/* _________________ PRE-LOADING, USER-SETTINGS, MESSAGES, MSGBOX & COOKIE HANDLING ___________________ */

const urlReader = new URLSearchParams(window.location.search)

$(document).ready(function(){

if (urlReader.has('loggedin')) {
    toastr.success("Sie haben sich erfolgreich eingeloggt.");
    }

if (urlReader.has('printed')) {
    toastr.success("Sie wurden vom Druckdialog zurückgeleitet.");
    }
});

$(document).ready(function(){
    MainMenu();
});

$( window ).resize( debouncer( function ( e ) {
    MainMenu();
} ) );

/* ######################################################### */
/* ##################### DOM FUNCTIONS ##################### */
/* ######################################################### */

/*_______________________ FIRST LAUNCH _________________________ */

$(document).ready(function() { 

    if (Cookies.get('mobileFirstLaunched') !== '1') {

        if (isMobileDevice()) {

            Cookies.set('mobileFirstLaunched', '1', { expires: 365 });

            $(".grid-main").css("z-index", "-1");
            $("body").prepend('\
                <div class="egrade-first-launch-wrapper">\
                <div class="content">\
                <p>Willkommen bei <h2>eGrade</h2></p>\
                </div>\
                </div>\
                <div class="egrade-first-launch">\
                <div class="title">\
                <h1>eGrade</h1>\
                <h3>Upgrade<br> Your School!</h3>\
                <div class="egrade-first-launch-exit"></div>\
                </div>\
                <div class="content">\
                <h3>Herzlich willkommen! 😃</h3>\
                <p>Sie führen die App anscheinend das erste Mal von diesem mobilen Endgerät aus. Wir empfehlen Ihnen, ein App-Icon auf dem Startbildschirm zu hinterlegen, um die Anwendung\
                im Vollbildmodus auszuführen.</p>\
                <h3>Google Chrome</h3>\
                <img src="./template/img/tutorial-android.jpg">\
                <p>Tippen Sie in <b>Google Chrome</b> auf das <b>Drei-Punkte-Menü</b>. Anschließend tippen Sie auf <b>"zum Startbildschirm hinzufügen"</b></p>\
                </div>\
                </div>'
            );

            $(".egrade-first-launch-exit").click(function() {
                $(".egrade-first-launch").fadeOut(1000, function(){
                    $(this).remove();
                    });
                $(".egrade-first-launch-wrapper").remove();
                $(".grid-main").css("z-index", "1");
        
            });       

        }

    } 

});

/* _________________ Full Dialogue Message Box ______________ */

var dialoguePreventEsc = false;

    // Pressing Escape-Key = Close
    $(document).keydown(function(e) {
    if (dialoguePreventEsc == false) {
        if (e.keyCode == 27) {
            $(".dialogue").fadeOut(200, function(){
                    $(this).remove();
                    });
            subMenuToggled = false;
        }
    }
});

window.addEventListener("hashchange", function(e) {
    $(".dialogue").fadeOut(200, function(){
        $(this).remove();
        });
});

// Closing of Dialogue

$(document).on('click', '.dialogue, .dialogue-content a, .close-message, .submit-message', function(){ 
    if ( !jQuery(event.target).is('.dialogue, .dialogue-content a, .close-message, .submit-message') ) {
        return false;
    } 
    $(".dialogue").fadeOut(200, function(){
        $(this).remove();
    })
}).on('click', 'input, textarea, label', function(e) {
    e.stopPropagation();
});

$(document).on('click', '.dialogue-icon-close', function(){ 
    $(".dialogue").fadeOut(200, function(){
        $(this).remove();
    })
});

// Close Dialogue Function

function closeDialogue() {
    $(".dialogue").fadeOut(200, function(){
        $(this).remove();
    })
}


/* _________________ Main Menu Toggling _________________ */

$(document).on('click', 'a.header-burger-menu', function(){ 
    
    $('.grid-main').attr('class', 'grid-main'); // Resets all sub-classes
    $('.grid-main').css('grid-template-columns', ""); // "" Resets to default value 
    $('.main-menu').css("display", "flex");

    if (Cookies.get('menuToggled') == '1') {
        if (isMobileDevice()) {
            $('.grid-main').toggleClass("closedMenu");
            $('.main-menu').css("display", "none");

        }
        else {
            $('.grid-main').toggleClass("smallMenu");
        }

        $('nav span.mobileHandler').css('display', 'none');
        Cookies.set('menuToggled', '0', { expires: 30 });
    }
    else {
        if (isMobileDevice()) {
            $('.grid-main').toggleClass("bigMenu");
            $('.main-menu').css("display", "flex");
        }
        else {
            $('.grid-main').css('grid-template-columns', ""); // "" resets to default value 
        }

        $('nav span.mobileHandler').css('display', 'block');
        Cookies.set('menuToggled', '1', { expires: 30 });
      }
});

$(document).on('click', 'nav a', function(){
    if (isMobileDevice()) {
    $('.grid-main').toggleClass("closedMenu");
    $('.main-menu').css("display", "none");
    Cookies.set('menuToggled', '0', { expires: 30 });
    }
});

/* _________________ Live Status Toggling _________________ */

var liveStatusMsgSent = false;

$(document).ready(function() { 

    window.setInterval(function(){
        if (navigator.onLine) {
            $(".header-online-status").removeClass("online").removeClass("offline").addClass("online");
            liveStatusMsgSent = false;
        } else {
            if (liveStatusMsgSent == false) {
            $(".header-online-status").removeClass("online").removeClass("offline").addClass("offline");
            toastr.error("Cloud-Verbindung unterbrochen.");
            //$("html").append("<div class='dialogue'><div class='message'><h3>Verbindung unterbrochen.</h3> <p>Ihre Verbindung wurde unterbrochen. Ihre letzten Eingaben wurden kürzlich synchronisiert. </p> <p> Sie können die App oder Seite neu laden, um Ihre Arbeit fortzusetzen. </p> <p> Sollte das Neuladen fehlschlagen, verfügt Ihr Gerät derzeit über keine Internetverbindung. </p> </div></div>");
            liveStatusMsgSent = true;
            //dialoguePreventEsc = true;
            }
        }
    }, 2000);

$(".header-online-status").hover(function() {

    if (navigator.onLine) {
        $(this).append("<div class='online-status'><span class='material-icons'>check</span> Cloud-Verbindung etabliert.</div>");
        var left = event.pageX - $(this).offset().left + 140;
        var top = event.pageY - $(this).offset().top + 60;
        $('.online-status').css({top: top,left: left});
        $(".online-status").hide().fadeIn(200);
    } else {
        $(this).append("<div class='online-status'><span class='material-icons'>error</span> Cloud-Verbindung fehlerhaft. </div>");
        var left = event.pageX - $(this).offset().left + 140;
        var top = event.pageY - $(this).offset().top + 60;
        $('.online-status').css({top: top,left: left});
        $(".online-status").hide().fadeIn(200);
    }

}, function() {
    $(".online-status").css( 'pointer-events', 'none' );
    $(".online-status").fadeOut(200, function() {
        $(this).remove();
    })
});

});

/* _________________ Tooltips _________________ */

function Tooltip(hoverHandler, message) {

    $(hoverHandler).hover(function() {
        $(this).append('<div class="tooltip">'+message+'</div>');
        var left = event.pageX - $(this).offset().left + 140;
        var top = event.pageY - $(this).offset().top + 60;
        $('.tooltip').css({top: top,left: left});
        $('.tooltip').css({top: top,left: left});
        $(".tooltip").hide().fadeIn(200);
    }, function() {
        $(".tooltip").css( 'pointer-events', 'none' );
        $(".tooltip").fadeOut(200, function() {
            $(this).remove();
        })
});

}


/*_________________ Sub Menu Toggling _________________*/

var subMenuToggled = false;

$(document).ready(function() { 

    // Clicking on anywhere in DOM

    $(document).on("click", function(event) {
        if(!$(event.target).is('a.header-login')) { // to only exclude button
            if (subMenuToggled == true) {
                $(".sub-menu").fadeOut(200, function(){
                    $(".sub-menu").css("display", "none");
                });
        subMenuToggled = false;
            }
        }
    })
    
    // Clicking on a.header-login - Main-Button
    /* I would prefer .on over .click because the former can use less memory and work for dynamically added elements. */

    $("header").on("click", "a.header-login", function() {
        if (subMenuToggled == false) {
            $(".sub-menu")
            .css("display", "block")
            .hide() 
            .fadeIn(200);
            subMenuToggled = true;
        }
        else {
            $(".sub-menu").fadeOut(200, function(){
                $(".sub-menu").css("display", "none");
            });
            subMenuToggled = false;
        }
    })

    // Clicking on a.item = Close

    $("header").on("click", "a.item", function(){
        $(".sub-menu").fadeOut(200, function(){
            $(".sub-menu").css("display", "none");
        });
        subMenuToggled = false;
    })

    // Pressing Escape-Key = Close

    $(document).keydown(function(e) {
        if (e.keyCode == 27) {
            $(".sub-menu").fadeOut(200, function(){
                $(".sub-menu").css("display", "none");
            });
            subMenuToggled = false;
        }
    });
});

/* _________________ Header Chat _________________ */

$(document).on('click', 'a.header-chat', function(){ 
        $(".message-notification").remove();
        toastr.info("Die Chat-Funktion ist nicht verfügbar.");
  
});   

/* _________________ Live Date _________________ */

$(document).ready(function(){
    datetime = $('#datetime')
    update();
    setInterval(update, 1000);
});

/* _________________ Android scrolling _________________ */

$(document).ready(function(){
    if(navigator.userAgent.match(/Android/i)){
        window.scrollTo(0,1);
     }
});

/* _________________ Save bar handling _________________ */

$(document).ready(function() {
        jQuery(function($) {
            $("main").ready(function(){
                if($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight) {
                    $('.save-bar').css('display', 'block');
                }
            })
        });
});

/* ____________ Direct-Label: Toggle next input __________ */

/* ________________ Prevent Context Menu ________________ 

window.addEventListener('contextmenu', function (e) { 
    e.preventDefault(); 
  }, false); */

/* ________________ Prevent CTRL + S _____________________ */

$(document).bind('keydown', function(e) {
    if(e.ctrlKey && (e.which == 83)) {
      e.preventDefault();
      return false;
    }
  });

/* ________________ Trigger Date Input Fields ____________ */

$(document).on("click","input[type='date']", function(){      
    $(this).focus();
});