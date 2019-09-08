<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Vigenere Chiper</title>
    <link href="css/bootstrap.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-8 m-auto">
                <div class="card">
                    <h2 class="card-header text-center">Enkripsi - Dekripsi Vigenere Chiper</h2>
                    <div class="card-body">
                        <br>
                        <form action="" method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
                            <div class="form-group">
                                <label for="input_file">Masukkan File :</label>
                                <input type="file" name="inputFile" class="form-control-file" required>
                                <div class="valid-feedback">File Ok!</div>
                                <div class="invalid-feedback">Silahkan masukkan file</div>
                            </div>
                            <div class="form-group">
                                <label for="input_key">Masukkan Key :</label>
                                <input type="text" name="inputKey" class="form-control" required>
                                <div class="valid-feedback">Key Ok!</div>
                                <div class="invalid-feedback">Silahkan isi key</div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-5 m-auto">
                                    <input class="btn btn-primary btn-block" type="submit" name="Enkripsi" id="btnEnkripsi" value="Enkripsi">
                                </div>
                                <div class="col-5 m-auto">
                                    <input class="btn btn-primary btn-block" type="submit" name="Dekripsi" id="btnDekripsi" value="Dekripsi">
                                </div>
                            </div>
                            <!--
                            <p>Masukkan File : <input type="file" name="inputFile" required id="inputFile"></p>
                            <p>Masukkan Key : <input type="text" name="inputKey" required id="inputKey"></p>
                            <input type="submit" name="Enkripsi" value="Enkripsi">
                            <input type="submit" name="Dekripsi" value="Dekripsi">
                            -->
                            <?php
                                if (isset($_POST["Enkripsi"])) {
                                    $inputKey = $_POST['inputKey'];
                                    $inputFile = $_FILES['inputFile']['name'];
                                    $alphabet = array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z');

                                    $fp = fopen($inputFile, 'r');
                                    $data = strtolower(fread($fp,filesize($inputFile)));
                                    $tempatSpasi = 0;
                                    while ($tempatSpasi !== false) {
                                        $tempatSpasi = strpos($data," ",$tempatSpasi);
                                        if ($tempatSpasi !== false) {
                                            $spasi[] = $tempatSpasi;
                                            $tempatSpasi = $tempatSpasi + 1;
                                        }
                                    }
                                    for ($i=0;$i<count($spasi);$i++) {
                                        $spasi[$i] = $spasi[$i] - $i - 1;
                                    }

                                    $dataTanpaSpasi = str_replace(" ","",$data);
                                    $dataLength = strlen($dataTanpaSpasi);
                                    $keyLength = strlen($inputKey);
                                    
                                    function duplikatKey($inputKey, $dataLength, $keyLength) {
                                        $keyDuplikat = "";
                                        $mod = $dataLength % $keyLength;
                                        $a = ($dataLength - $mod) / $keyLength;
                                        for ($i=0;$i<$a;$i++) {
                                            $keyDuplikat .= $inputKey;
                                        }
                                        $keyDuplikat .= substr($inputKey,0,$mod);
                                        return $keyDuplikat;
                                    }

                                    function ubahJadiAngka($dataLength, $alphabet, $dataTanpaSpasi) {
                                        for ($i=0;$i<$dataLength;$i++) {
                                            for ($j=0;$j<count($alphabet);$j++) {
                                                if (substr($dataTanpaSpasi,$i,1) === $alphabet[$j]) {
                                                    $dataAngka[] = $j;
                                                    break;
                                                }
                                            }
                                        }
                                        return $dataAngka;
                                    }

                                    $keyDuplikat = duplikatKey($inputKey, $dataLength, $keyLength);
                                    $dataAngka = ubahJadiAngka($dataLength, $alphabet, $dataTanpaSpasi);
                                    $dataKey = ubahJadiAngka($dataLength, $alphabet, $keyDuplikat);

                                    for ($i=0;$i<$dataLength;$i++) {
                                        $hasilPenjumlahan[] = $dataAngka[$i] + $dataKey[$i];
                                        if ($hasilPenjumlahan[$i] > 25) {
                                            $hasilPenjumlahan[$i] = $hasilPenjumlahan[$i] - 26;
                                        }
                                        for ($j=0;$j<count($alphabet);$j++) {
                                            if ($hasilPenjumlahan[$i] === $j) {
                                                $hasil[] = $alphabet[$j];
                                                break;
                                            }
                                        }
                                    }

                                    $z=0;
                                    for ($i=0;$i<count($hasil);$i++) {
                                        if ($spasi[$z] === $i) {
                                            $hasil[$i] = $hasil[$i]." ";
                                            if ($z < count($spasi)-1) {
                                                $z++;
                                            }
                                        }
                                    }
                                    $hasilgabung = implode("",$hasil);

                                    $fp = fopen($inputFile, 'w') or die('Cannot open file:  '.$inputFile);
                                    fwrite($fp, $hasilgabung);
                                    fclose($fp);


                                } else if (isset($_POST["Dekripsi"])) {
                                    $key = $_POST['inputKey'];
                                    $file = $_FILES['inputFile']['name'];

                                    $inputKey = $_POST['inputKey'];
                                    $inputFile = $_FILES['inputFile']['name'];
                                    $alphabet = array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z');

                                    $fp = fopen($inputFile, 'r');
                                    $data = strtolower(fread($fp,filesize($inputFile)));
                                    $tempatSpasi = 0;
                                    while ($tempatSpasi !== false) {
                                        $tempatSpasi = strpos($data," ",$tempatSpasi);
                                        if ($tempatSpasi !== false) {
                                            $spasi[] = $tempatSpasi;
                                            $tempatSpasi = $tempatSpasi + 1;
                                        }
                                    }
                                    for ($i=0;$i<count($spasi);$i++) {
                                        $spasi[$i] = $spasi[$i] - $i - 1;
                                    }

                                    $dataTanpaSpasi = str_replace(" ","",$data);
                                    $dataLength = strlen($dataTanpaSpasi);
                                    $keyLength = strlen($inputKey);
                                    
                                    function duplikatKey($inputKey, $dataLength, $keyLength) {
                                        $keyDuplikat = "";
                                        $mod = $dataLength % $keyLength;
                                        $a = ($dataLength - $mod) / $keyLength;
                                        for ($i=0;$i<$a;$i++) {
                                            $keyDuplikat .= $inputKey;
                                        }
                                        $keyDuplikat .= substr($inputKey,0,$mod);
                                        return $keyDuplikat;
                                    }

                                    function ubahJadiAngka($dataLength, $alphabet, $dataTanpaSpasi) {
                                        for ($i=0;$i<$dataLength;$i++) {
                                            for ($j=0;$j<count($alphabet);$j++) {
                                                if (substr($dataTanpaSpasi,$i,1) === $alphabet[$j]) {
                                                    $dataAngka[] = $j;
                                                    break;
                                                }
                                            }
                                        }
                                        return $dataAngka;
                                    }

                                    $keyDuplikat = duplikatKey($inputKey, $dataLength, $keyLength);
                                    $dataAngka = ubahJadiAngka($dataLength, $alphabet, $dataTanpaSpasi);
                                    $dataKey = ubahJadiAngka($dataLength, $alphabet, $keyDuplikat);

                                    for ($i=0;$i<$dataLength;$i++) {
                                        $hasilPengurangan[] = $dataAngka[$i] - $dataKey[$i];
                                        if ($hasilPengurangan[$i] < 0) {
                                            $hasilPengurangan[$i] = $hasilPengurangan[$i] + 26;
                                        }
                                        for ($j=0;$j<count($alphabet);$j++) {
                                            if ($hasilPengurangan[$i] === $j) {
                                                $hasil[] = $alphabet[$j];
                                                break;
                                            }
                                        }
                                    }
                                    
                                    $z=0;
                                    for ($i=0;$i<count($hasil);$i++) {
                                        if ($spasi[$z] === $i) {
                                            $hasil[$i] = $hasil[$i]." ";
                                            if ($z < count($spasi)-1) {
                                                $z++;
                                            }
                                        }
                                    }
                                    $hasilgabung = implode("",$hasil);
                                    
                                    $fp = fopen($inputFile, 'w') or die('Cannot open file:  '.$inputFile);
                                    fwrite($fp, $hasilgabung);
                                    fclose($fp);
                                }
                            ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

        
        
    <script src="js/jquery-3.3.1.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.js"></script>
    <script>
    // Example starter JavaScript for disabling form submissions if there are
    // invalid fields
      (function() {
        'use strict';
        window.addEventListener('load', function() {
          // Fetch all the forms we want to apply custom Bootstrap validation styles to
          var forms = document.getElementsByClassName('needs-validation');
          var btnEnkripsi = document.getElementById('btnEnkripsi');
          var btnDekripsi = document.getElementById('btnDekripsi');
          // Loop over them and prevent submission
          var validation = Array.prototype.filter.call(forms, function(form) {
            form.addEventListener('submit', function(event) {
              if (form.checkValidity() === false) {
                event.preventDefault();
                event.stopPropagation();
              } else {
                alert("Berhasil");
              }
              form.classList.add('was-validated');
            }, false);
          });
        }, false);
      })();
    </script>
</body>
</html>