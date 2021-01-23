@extends('layout.app')
@section('title','Index')
@section('content')
  <style >
  /* Bottom hack for IE*/
svg{
width:100%;
padding-bottom: 55.55%;
height: 1px;
overflow: visible;
}

  </style>
<div class="container-fluid">
  <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" preserveAspectRatio="xMidYMin slice" viewBox="0 0 728 400">
  <!--Background-->
  <path d="M0 0h728v400H0z" fill="#fff"/>
  <!--Spiral path-->
  <defs>
    <path id="s" d="M363.32 203.973c3.65 3.65-3.119 6.72-6.066 6.066-7.986-1.773-9.27-12.002-6.066-18.198 5.731-11.082 20.612-12.38 30.33-6.065 14.26 9.267 15.584 29.339 6.065 42.46-12.686 17.49-38.107 18.828-54.592 6.067-20.745-16.06-22.09-46.897-6.066-66.725 19.408-24.015 55.695-25.365 78.856-6.066 27.294 22.744 28.648 64.502 6.066 90.988-26.071 30.58-73.313 31.935-103.12 6.066-33.869-29.394-35.225-82.127-6.066-115.252 32.713-37.16 90.944-38.518 127.384-6.065 40.455 36.028 41.813 99.762 6.065 139.515-39.342 43.75-108.581 45.11-151.646 6.065-47.048-42.655-48.408-117.402-6.066-163.778 45.966-50.346 126.224-51.706 175.91-6.066 53.645 49.277 55.005 135.047 6.066 188.042-52.587 56.945-143.87 58.305-200.174 6.066-60.244-55.895-61.605-152.693-6.066-212.306 59.204-63.545 161.518-64.906 224.438-6.065 53.59 50.116 66.879 131.92 33.787 197.072" />
  </defs>
  <!--Text & link to path-->
  <text font-family="monospace" font-size="20" fill="#1d1f20">
  <textPath id="text" xlink:href="#s"></textPath>
  </text>
</svg>

<span id="textval" style=" text-decoration: underline;"></span>
<br>
<br>
<br>
<button type="button" id="generate">Generate </button>
<button type="button" name="save" id="save">Save</button>
<button type="button" name="view" id="view">view</button>



</div>

@endsection
@section('script')
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

  <script type="text/javascript">
  $("body").bind("ajaxSend", function(elm, xhr, s){
     if (s.type == "POST") {
        xhr.setRequestHeader('X-CSRF-Token', getCSRFTokenValue());
     }
  });
           // $.ajaxSetup({
           //  headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
           //  });
  $("#generate").click(function() {

  $('#textval').text(makeid(5));
  });

  function makeid(length) {
     var result           = '';
     var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
     var charactersLength = characters.length;
     for ( var i = 0; i < length; i++ ) {
        result += characters.charAt(Math.floor(Math.random() * charactersLength));
     }
     return result;
  }

  $("#save").click(function() {
    var value =  $('#textval').text();

    $.ajax({
                    url : '{{route('exam.store')}}',
                    type : "POST",
                    headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                    data : {    "_token": "{{ csrf_token() }}",value :value },
                    async:false,
                    success : function(response){
                      if(response.status == false){
                        var values = '';
                          jQuery.each(response.msg, function (key, value) {
                              values += value
                          });
                          Swal.fire(
                              'Failed!',
                              values,
                              'error'
                          ).then((result) => {
                              // location.reload();
                          });

                      }else{
                          Swal.fire(
                              'Success!',
                              response.msg,
                              'success'
                          ).then((result) => {
                              // location.reload();
                          });
                      }
                    },

                });

  });

  $("#view").click(function() {

    $.ajax({
        url : '{{route('exam.create')}}',
          headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
        type: "GET",
        dataType: 'json',
        async: false,

        success: function(response) {

          if(response.status === true){

            // var values = '';
            //           jQuery.each(response.data, function (key, value) {
            //
            //               values += value
            //                   console.log(value.name);
            //           });

                      $.each(response.data, function(key, value){

          $("#text").append( + ": " + value.name + '<br>');
      });
      // $('#randomview').text();

          }else{
            Swal.fire(
                'Failed!',
                'something was wrong',
                'error'
            ).then((result) => {
                // location.reload();
            });
          }

        }
    });
    // $('#randomview').text();

  });

  document.addEventListener('DOMContentLoaded',function(event){
    window.onload = function() {

  // array with text to type
    var dataText = [ "Hello, here is some text typing along a spiral path. Hello, here is some text typing along a spiral path. Hello, here is some text typing along a spiral path. Hello, here is some text typing along a spiral path."];
    //text input caret
    var caret = "\u258B";

    // type a text
    // keep calling itself until the text is finished
    function type(text, i, fnCallback) {
      // chekc if text isn't finished yet
      if (i < (text.length)) {
        // add next character to text + caret
        document.querySelector("#text").textContent = text.substring(0, i+1) + caret;

        // delay and call this function again for next character
        setTimeout(function() {
          type(text, i + 1, fnCallback)
        }, 70);
      }
      // text finished, call callback if there is a callback function
      else if (typeof fnCallback == 'function') {
        // call callback after timeout
        setTimeout(fnCallback, 1500);
      }
    }
    // start animation for a text in the dataText array
     function StartAnimation(i) {
       if (typeof dataText[i] == 'undefined'){
          setTimeout(function() {
            StartAnimation(0);
          }, 1000);
       }
       // check if dataText[i] exists
      if (i < dataText[i].length) {
        // text exists! start typewriter animation
        type(dataText[i], 0, function(){
        // after callback (and whole text has been animated), start next text
        StartAnimation(i + 1);
       });
      }
    }
    // start the text animation
    StartAnimation(0);
    }
  });




  </script>
@endsection
