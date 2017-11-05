<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>BINGO</title>
  <!-- css -->
  <link href="<?= base_url('assets/css/style.css'); ?>" rel="stylesheet" type="text/css">
  <!-- js -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script type="text/javascript">
    /**
    * Variale sebagai record untuk data bingo dari controller
    */
    var randomRange = <?= json_encode($bingo);?>;
    (function ($) {
    $(document).ready(function () {
    /**
     * Helper
     *
     * @return {Boolean}
     */
    function in_array(key, array) {
        return array.indexOf(key) > -1;
    }
    /**
     * periksa kesesuaian vertical
     */
    function checkBingoVertical(arrays) {
        // getting offset
        for (var i = 0; randomRange.length > i;i++) {
            var offset = -1;
            for (var h=0; arrays.length > h;h++) {
                // setiap array value harus berupa type number
                if (randomRange[i].indexOf(arrays[h]) > -1) {
                    offset = randomRange[i].indexOf(arrays[h]);
                    break
                }
            }
            // apabila ada nilai pada loop randomRange[i] array values
            if (offset > -1) {
                var matches = [];
                for (var x = 0;randomRange.length > x;x++) {
                    var currentOffset = randomRange[x][offset]; // undefined
                    // apabila currentOffset adalah bertype (number)
                    if (typeof currentOffset === 'number'
                      // apabila currentOffset belum ada di @var matches
                      && !in_array(currentOffset, matches)
                      // apabila currentOffset terdapat di @param arrays value
                      && in_array(currentOffset, arrays)
                    ) {
                        // maka push / insert ke matches var
                        matches.push(currentOffset);
                    }
                }
                // end result
                return matches.length === 5;
            }
        }
        return false;
    }
    /**
     * Validasikan Kesesuaian secara Horizontal
     */
    function checkBingoHorizontal(arrays) {
      // getting offset
      for (var i = 0; randomRange.length > i;i++) {
        var offset = -1;
        for (var h=0; arrays.length > h;h++) {
          // setiap array value harus berupa type number
          if (typeof arrays[h] !== "number") {
            return false;
          }
          if (randomRange[i].indexOf(arrays[h]) > -1) {
            offset = randomRange[i].indexOf(arrays[h]);
            break
          }
        }
        if (offset > -1) {
          var matches = [];
          for (var x = 0;randomRange[i].length > x;x++) {
            if (in_array(randomRange[i][x], arrays)
              && ! in_array(randomRange[i][x], matches)
            ) {
                matches.push(randomRange[i][x]);
            }
          }
          // end result
          return matches.length === 5;
        }
      }
      return false;
    }
    /**
     * Check kesesuaian diagonal
     */
    function checkBingoDiagonal(arrays) {
      // kesesuaian Horizontal
      var matchesZR = [];
      // kesesuaian Vertical
      var matchesZL = [];
      for (var i = 0; randomRange.length > i;i++) {
        for (var x= 0; arrays.length > x;x++) {
          var index = randomRange[i].indexOf(arrays[x]);
          // apabila index sesuai / ada dan bukan -1
          if (index > -1) {
            // apabila pada matchesZR tidak terdapat record index
            if (! in_array(index, matchesZR))  {
              matchesZR.push(index);
            }
            // apabila pada matchesZL tidak terdapat record i
            if (! in_array(i, matchesZL))  {
              matchesZL.push(i);
            }
          }
        }
      }
      var matches = [];
      for (var i = 0; matchesZR.length > i;i++) {
        if (!in_array(matchesZR[i], matchesZL)) {
          return false;
        }
        matches.push(matchesZR[i]);
      }
      return matches.length === 5;
    }
    /**
     *  Validasi apabila BINGO
     *  verical, horizon, diagonal
     */
    function checkBingo(arrays) {
        return checkBingoVertical(arrays) || checkBingoHorizontal(arrays) || checkBingoDiagonal(arrays);
    }
    // barisan array untuk nilai nilai yang di klik
    // cached variable
    var clickedValue = [];
    /**
     * Tambahkan event handler click pada TD
     */
    $('td').on('click', function () {
        // apabila telah 5 kali atau lebih di klik berhenti disini
        if (clickedValue.length >= 5) {
            // stop / unbind event click on td
            $('td').unbind('click');
            // stop
            return;
        }
        // increment
        var currentValue = parseInt($(this).html());
        // apabila nilai HTML / Nomor telah ada di clickedValues
        // maka berhenti di sini
        if (clickedValue.indexOf(currentValue) > -1) {
            return;
        }
        clickedValue.push(currentValue);
        $(this).addClass('selected');
        // apabila telah mendapat posisi 5 maka check
        if (clickedValue.length === 5) {
            var $status = $('#status');
            $status.addClass('show');
            $status.click(function (e) {
                e.preventDefault();
                window.location.reload();
            });
            var $status = $('#status');
            $status.addClass('show');
            $status.click(function (e) {
                e.preventDefault();
                window.location.reload();
            });
            if (checkBingo(clickedValue) === true) {
                $status.html('Anda Berhasil');
                $status.addClass('bingo');
                $('thead').addClass('bingo');
            } else {
                $status.html('Anda Gagal');
                $('thead').addClass('fail');
            }
            // ajax
            $status.append('<br/><small>Muat Ulang</small>');
          }
        })
      })
    })(window.jQuery);
  </script>
</head>
<body>
  <div id="page">
    <table>
      <thead>
        <tr>
          <th>B</th>
          <th>I</th>
          <th>N</th>
          <th>G</th>
          <th>O</th>
        </tr>
      </thead>
      <tbody>
<?php
        foreach ($bingo as $key => $numbersArray) {
            echo "  <tr>\n";
            /**
             * @var array $numbersArray
             */
            foreach ($numbersArray as $number) {
                // print nomor
                echo "    <td>{$number}</td>\n";
            }
            echo "  </tr>\n";
        }
?>
      <td colspan="5">
        <div id="status"></div>
      </td>
      </tbody>
    </table>
  </div>
</body>
</html>