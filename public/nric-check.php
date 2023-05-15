<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8" />
  <title>Singapore NRIC Validator</title>
</head>

<body>


  <label for="nric" class="inline-label">NRIC:</label>
  <input type="text" maxlength="256" name="nric" placeholder="S8888888A" id="nric" required="" />
  <div id="validateIcon"></div>
  


  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
  <script src="nric.js" type="text/javascript"></script>

  <script>
    function validate(ic) {
      var icArray = new Array(9);
      for (i = 0; i < 9; i++) {
        icArray[i] = ic.charAt(i);
      }
      icArray[1] *= 2;
      icArray[2] *= 7;
      icArray[3] *= 6;
      icArray[4] *= 5;
      icArray[5] *= 4;
      icArray[6] *= 3;
      icArray[7] *= 2;
      var weight = 0;
      for (i = 1; i < 8; i++) {
        weight += parseInt(icArray[i], 10);
      }
      var offset = (icArray[0] == "T" || icArray[0] == "G") ? 4 : (icArray[0] == "M") ? 3 : 0;
      var temp = (offset + weight) % 11;
      if (icArray[0] == "M") temp = 10 - temp;
      var st = Array("J", "Z", "I", "H", "G", "F", "E", "D", "C", "B", "A");
      var fg = Array("X", "W", "U", "T", "R", "Q", "P", "N", "M", "L", "K");
      var m = Array("K", "L", "J", "N", "P", "Q", "R", "T", "U", "W", "X");
      var theAlpha;
      if (icArray[0] == "S" || icArray[0] == "T") theAlpha = st[temp];
      else if (icArray[0] == "F" || icArray[0] == "G") theAlpha = fg[temp];
      else if (icArray[0] == "M") theAlpha = m[temp];
      return (icArray[8] == theAlpha);
    }

    Webflow.push(function() {
      valIcon = $('#validateIcon');
      $('#nric').on('keyup paste', function() {
        var nric_num = $(this).val();
        nric_num = nric_num.replace(/[^0-9 a-z A-Z]+/g, "").replace(/(^\s||\s$)+/, "").toUpperCase();
        $(this).val(nric_num);
        //valIcon.removeClass("valid").attr("title", "Not Valid!");
        if (nric_num.length == 9 && validate(nric_num)){
          $('#validateIcon').text("Valid");
        }else{
          $('#validateIcon').text("Notvalid");
        }
      });
      // $('#nric-val-form').submit(function() {
      //   return false;
      // });
    });
  </script>
</body>

</html>