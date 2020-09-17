var langs =
[['Afrikaans',       ['af-ZA']],
 ['Bahasa Indonesia',['id-ID']],
 ['Bahasa Melayu',   ['ms-MY']],
 ['Català',          ['ca-ES']],
 ['Čeština',         ['cs-CZ']],
 ['Deutsch',         ['de-DE']],
 ['English',         ['en-AU', 'Australia'],
                     ['en-CA', 'Canada'],
                     ['en-IN', 'India'],
                     ['en-NZ', 'New Zealand'],
                     ['en-ZA', 'South Africa'],
                     ['en-GB', 'United Kingdom'],
                     ['en-US', 'United States']],
 ['Español',         ['es-AR', 'Argentina'],
                     ['es-BO', 'Bolivia'],
                     ['es-CL', 'Chile'],
                     ['es-CO', 'Colombia'],
                     ['es-CR', 'Costa Rica'],
                     ['es-EC', 'Ecuador'],
                     ['es-SV', 'El Salvador'],
                     ['es-ES', 'España'],
                     ['es-US', 'Estados Unidos'],
                     ['es-GT', 'Guatemala'],
                     ['es-HN', 'Honduras'],
                     ['es-MX', 'México'],
                     ['es-NI', 'Nicaragua'],
                     ['es-PA', 'Panamá'],
                     ['es-PY', 'Paraguay'],
                     ['es-PE', 'Perú'],
                     ['es-PR', 'Puerto Rico'],
                     ['es-DO', 'República Dominicana'],
                     ['es-UY', 'Uruguay'],
                     ['es-VE', 'Venezuela']],
 ['Euskara',         ['eu-ES']],
 ['Français',        ['fr-FR']],
 ['Galego',          ['gl-ES']],
 ['Hrvatski',        ['hr_HR']],
 ['IsiZulu',         ['zu-ZA']],
 ['Íslenska',        ['is-IS']],
 ['Italiano',        ['it-IT', 'Italia'],
                     ['it-CH', 'Svizzera']],
 ['Magyar',          ['hu-HU']],
 ['Nederlands',      ['nl-NL']],
 ['Norsk bokmål',    ['nb-NO']],
 ['Polski',          ['pl-PL']],
 ['Português',       ['pt-BR', 'Brasil'],
                     ['pt-PT', 'Portugal']],
 ['Română',          ['ro-RO']],
 ['Slovenčina',      ['sk-SK']],
 ['Suomi',           ['fi-FI']],
 ['Svenska',         ['sv-SE']],
 ['Türkçe',          ['tr-TR']],
 ['български',       ['bg-BG']],
 ['Pусский',         ['ru-RU']],
 ['Српски',          ['sr-RS']],
 ['한국어',            ['ko-KR']],
 ['中文',             ['cmn-Hans-CN', '普通话 (中国大陆)'],
                     ['cmn-Hans-HK', '普通话 (香港)'],
                     ['cmn-Hant-TW', '中文 (台灣)'],
                     ['yue-Hant-HK', '粵語 (香港)']],
 ['日本語',           ['ja-JP']],
 ['Lingua latīna',   ['la']]];


var lenguaje = 7;
var dialecto = 12;

var final_transcript = '';
var recognizing = false;
var ignore_onend;
var start_timestamp;

if (!('webkitSpeechRecognition' in window)) {
  //upgrade();
} else {
  var recognition = new webkitSpeechRecognition();
  recognition.continuous = true;
  recognition.interimResults = true;

  recognition.onstart = function() { // hablar
    recognizing = true;
    document.getElementById("microfono").className = "ti-microphone-alt";    
    // poner gif de animacion al hablar
  };

  recognition.onerror = function(event) {
    if (event.error == 'no-speech') {
      alert('Error');
      ignore_onend = true;
    }
    if (event.error == 'audio-capture') {
      alert("No se encontró el microfono");
      ignore_onend = true;
    }
    if (event.error == 'not-allowed') {
      if (event.timeStamp - start_timestamp < 100) {
        alert("Bloqueado")
      } else {
       alert("Denegado");
      }
      ignore_onend = true;
    }
  };

function getAudio(text, flag) {
    switch(flag) {
        case 1:
            text = text;
            break;
        default:
            text = "Creo que hay un error."
    }
    $.get('https://tts-token-server.mybluemix.net/token', function(token) {
        url = 'https://stream.watsonplatform.net/text-to-speech/api/v1/synthesize?voice=es-ES_LauraVoice&text='
        +text+'&watson-token='+ token;
        var audio = new Audio(url).play();
    })
}

  recognition.onend = function() {
    var watson_text = $('#text_nvo_mensaje').val();
    
    recognizing = false;
    if (ignore_onend) {
      return;
    }
    document.getElementById("microfono").className = "ti-microphone"; 
    //start_img.src = 'https://watsonservicestutor.mybluemix.net/assets/dist/img/mic.gif';
    if (!final_transcript) {
      console.log("empieza");
      return;
    }    
  };


  recognition.onresult = function(event) {

    var interim_transcript = '';
    for (var i = event.resultIndex; i < event.results.length; ++i) {
      if (event.results[i].isFinal) {
        final_transcript += event.results[i][0].transcript;
      } else {
        interim_transcript += event.results[i][0].transcript;
      }
    }

    $("#text_nvo_mensaje").val(linebreak(interim_transcript));
    final_transcript = capitalize(final_transcript);
    $("#text_nvo_mensaje").val(linebreak(final_transcript));    
  };
}

var two_line = /\n\n/g;
var one_line = /\n/g;
function linebreak(s) {
  return s.replace(two_line, '<p></p>').replace(one_line, '<br>');
}

var first_char = /\S/;
function capitalize(s) {
  return s.replace(first_char, function(m) { return m.toUpperCase(); });
}

function startButton(event) {
  if (recognizing) {
    recognition.stop();
    return;
  }
  console.log("empieza a hablar");
  final_transcript = '';
  recognition.lang = langs[lenguaje][dialecto];
  recognition.start();
  ignore_onend = false;
  start_timestamp = event.timeStamp;
}

