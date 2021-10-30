/* 
      _____               _      
     |  __ \             | |     
  ___| |  \/_ __ __ _  __| | ___ 
 / _ \ | __| '__/ _` |/ _` |/ _ \
|  __/ |_\ \ | | (_| | (_| |  __/
 \___|\____/_|  \__,_|\__,_|\___|
                                 
 
Code & Design (C) 2020 by Timo Nolze & Malte Hoch

*/

// TODO: Rewrite AJAX to JavaScript Fetch.

/* globalRouting nutzt eine Funktion, die "click"-Handler global registiert. Diese ist angedacht für die grundsätzliche
Navigation von eGrade, führt gleichermaßen aber zu Problemen, wenn einzelne Views eine gescopte Routing-Funktion haben sollen:
Click-Handler sind global. Eine Alternative hierfür wäre es noch, den Click-Handler zu deregistrieren.

viewRouting wird hingegen verwendet für Routing-Funktionen, die nur durch eine View übergeben werden. Sie werden nicht
global registriert, sondern folgen dem Grundsatz des Event Registration Models, können also nur ausgeführt werden,
wenn der HTML-Code bereits existiert */

/* Using $('#myDiv').click(function(){ is better as it follows standard event registration model. 
(jQuery internally uses addEventListener and attachEvent).
Basically registering an event in modern way is the unobtrusive way of handling events. 
Also to register more than one event listener for the target you can call addEventListener() for the same target. 

*/

const routeMe = function (URL, Data, appendType, appendToContainer, appendFromContainer, pushUrl) {
    return function (e) {
      if ($(this).attr("target") || $(this).attr("no-ajax")) {
        return;
      }
      let promise = false;
      $('body').append('<div class="loading"></div>');
      //$('html').off(); // Unbind events, to avoid double-calling. May need improvement.
      if ($(this).attr("hiddenHref")) {
        URL = $(this).attr("hiddenHref");
      } else if ($(this).attr("href")) {
        URL = $(this).attr("href");
      } else {
        // Do nothing, take from function
      }
      if (Data == "") { } else { URL = '' }; // If Data is not empty, URL will be removed from AJAX Call. This is to use "data" instead of "URL" in the call.
      try {
        e.preventDefault();
        } catch(ex) {
        console.warn(ex + '. Routing probably loaded directly.');
      }
      $.ajax({
        async: true,
        url: URL,
        data: Data,
        dataType: "text",
        timeout: 8000
      })
        .always(function () {
          promise = true; // This is set to "true" before it can actually fail. Thus .done is not executed when .fail or .catch occurred.
        })
        .fail(function (xhr, textStatus, error) {
          toastr.error("Die Verbindung konnte nicht hergestellt werden.");
          $(".loading").fadeOut(500, function () { $(this).remove(); });
          promise = false;
          return;
        })
        .catch(function (e) {
          if (e.statusText == 'timeout') {
            toastr.error("Timeout: Die Verbindungsgeschwindigkeit ist stark beeinträchtigt oder nicht verfügbar.");
          }
            $(".loading").fadeOut(500, function () { $(this).remove(); });
            promise = false;
            return;
        })
        .done(function (data) {
          if (promise == true) {
            if (appendType == 1) {
              $('html').off(); // Unbind everything here. That's no problem since each new view re-registers its "global listeners".    
              $(appendToContainer).empty();
              $(appendToContainer).replaceWith($(data).find(appendFromContainer)); // Certain div: .replaceWith to replace container. For PHP files.
            } else if (appendType == 2) {
              $('html').off(); // Unbind everything here. That's no problem since each new view re-registers its "global listeners".    
              $(appendToContainer).empty();
              $(appendToContainer).html($(data).find(appendFromContainer)); // Certain div: .html to append HTML. For PHP files.   
            } else if (appendType == 3) {
              $(appendToContainer).append($(data)); // Whole document: is loaded in this case. For dialogues with PHP/AJAX e.g.
            } else {
              $('html').off(); // Unbind everything here. That's no problem since each new view re-registers its "global listeners".    
              $(appendToContainer).empty();
              $(appendToContainer).replaceWith($(data).find(appendFromContainer)); // Replace container by default
            }
            $(".loading").fadeOut(500, function () { $(this).remove(); });
            if (pushUrl !== false ) {
            history.pushState(null, null, URL);
            }
            console.log('Called: ' + URL + ' ' + Data + ' with type: ' + appendType);
            URL = ""; // URL will be emptied again to wait either for User call, or another URL.
            return;
          }
        })
    };
  };
  
  function globalRouting(Listener, URL, Data, appendType, appendToContainer, appendFromContainer, pushUrl) {
    $(document).on('click', Listener, routeMe(URL, Data, appendType, appendToContainer, appendFromContainer, pushUrl));
  }

  function directRouting(URL, Data, appendType, appendToContainer, appendFromContainer, pushUrl) {
    routeMe(URL, Data, appendType, appendToContainer, appendFromContainer, pushUrl)();
  }
  
  function viewRouting(Listener, URL, Data, appendType, appendToContainer, appendFromContainer, pushUrl) {
    $(Listener).click(routeMe(URL, Data, appendType, appendToContainer, appendFromContainer, pushUrl));
  }

  function historyRouting(URL, Data, appendType, appendToContainer, appendFromContainer) {
  $(document).on('click', Listener, routeMe(URL, Data, appendType, appendToContainer, appendFromContainer));
  }

  // __________________________________ GLOBAL ROUTES _________________________________________

  globalRouting('nav a[href], main a[href], .dialogue-content a[href], .sub-menu a.fetch', '', '', 1, 'main', 'main'); 
  globalRouting('.sub-menu a.show-dialogue', '', '', 3, 'body', '.dialogue', false); 

// __________________________________ FORM ROUTING FOR EGRADE __________________________________

function autoSubmit (formID, changeTrigger, initialSubmit) {

  if (initialSubmit == true) {

    $( document ).ready(function() {                     
        $.ajax({
        url : $(formID).attr('action'),
        type: "POST",
        data: $(formID).serialize(),
        success: function (data) {
        console.log("Form initially submitted: " + formID);
        },
        error: function (jXHR, textStatus, errorThrown) {
          toastr.error(errorThrown);
        }
        });
    }); 

  }

    $(changeTrigger).change(function() {                        
        $.ajax({
        url : $(formID).attr('action'),
        type: "POST",
        data: $(formID).serialize(),
        success: function (data) {
            console.log("Form on change submitted: " + formID);
        },
        error: function (jXHR, textStatus, errorThrown) {
        toastr.error("Datenbankfehler: Ihre Eingaben konnten nicht gespeichert werden.");
        console.log(jXHR + textStatus + errorThrown);
        }
        });
    });

    window.onbeforeunload = function () {
        $.ajax({
            url : $(formID).attr('action'),
            type: "POST",
            data: $(formID).serialize(),
            success: function (data) {
                console.log("Form on exit submitted: " + formID);
            },
            error: function (jXHR, textStatus, errorThrown) {console.log(jXHR + textStatus + errorThrown)}
            });
    };
}

function submit (formID, message) {                      
      $.ajax({
      type: "POST",
      url : $(formID).attr('action'),
      data: $(formID).serialize(),
      success: function (data) {
          console.log("Form submitted: " + formID);
          if (!!message) {
            toastr.success(message);
          }
      },
      error: function (jXHR, textStatus, errorThrown) {
      toastr.error("Datenbankfehler: Ihre Eingaben konnten nicht gespeichert werden.");
      console.log(jXHR + textStatus + errorThrown);
      }
      });
}

function submit2(form, bindingCallback)
{
    $.ajax({
        type: "POST",
        url : $(form).attr('action'),
        data: $(form).serialize(),
        success: function (data) {

            if(data.success == true)
            {
                if(!!data.message)
                {
                    toastr.success(data.message);
                }else{
                    toastr.success("Formular erfolgreich gespeichert.");
                }

            }else{
                if(!!data.message)
                {
                    toastr.error(data.message);
                }else{
                    toastr.error("Beim Speichern des Formulars ist ein Fehler aufgetreten!");
                }
            }

            if(typeof bindingCallback !== 'undefined')
            {
                bindingCallback(form, data);
            }

        },
        error: function (jXHR, textStatus, errorThrown) {
            toastr.error("Datenbankfehler: Ihre Eingaben konnten nicht gespeichert werden.");
            console.log(jXHR + textStatus + errorThrown);
        }
    });

}


//binds json response in form of
// {
//     "success":true,
//     "message":"Pinboard erfolgreich gespeichert",
//     "data":{
//     "info":"asdf",
//         "announcements":"asdfg"
// }
// }

function bindForm(form, data)
{
    if(!!data.success)
    {
        if(data.success == true)
        {
                //properties from data.data shall bey passed to forms elements.
                $('input').each(function(i, input){
                    $(input).val(data.data[$(input).prop("name")]);
                });

                $('textarea').each(function(i, textarea){
                    var key = $(textarea).prop('id');

                    if(key in data.data)
                    {
                        $(textarea).val(data.data[key]);

                        //check if we use tinymce for this textarea
                        if(typeof tinyMCE !== 'undefined')
                        {
                            //if this is a tinymce textarea, update the corresponding editor content as well if key exists
                            if(typeof tinyMCE.editors[key] !== 'undefined')
                            {
                                tinyMCE.editors[key].setContent(data.data[key]);
                            }
                        }

                    }

                });

        }
    }
}

/* CHECK IF A VIEW HAS ALREADY BEEN LOADED */

var wasLoaded = {
  admin_school: false,
  create_reports: false,
  main: false,
  my_classes: false,
  pinboard: false,
  schoolclass_details: false,
  student_details: false,
};