<?php
//fill up the 20 x 20 array grid
$arr = [];
for ($i = 0; $i < 20; $i++) {
    $temp = [];
    for ($j = 0; $j < 20; $j++)
        $temp[] = generate_random_char();
    array_push($arr, $temp);
}

session_start();
//input words from text area every nextline
if (isset($_POST['words'])) {
    $_SESSION['words'] = null;
    $words_encoded = $_POST['words'];
    $words_arr = explode(PHP_EOL, $words_encoded);
    $_SESSION['words'] = $words_arr;
    $words = $_SESSION['words'];
    for ($i = 0; $i < count($words); $i++) {
        fill_matrix(strtoupper($words[$i]), $arr);
    }
}

//replay button
if (isset($_POST['replay'])) {
    if (!empty($_SESSION['words'])) {
        $words = $_SESSION['words'];
        for ($i = 0; $i < count($words); $i++) {
            fill_matrix(strtoupper($words[$i]), $arr);
        }
    }
}

function generate_random_char()
{
    $chars = 'abcdefjhigklmnopqrstuvwxyz';
    $len = strlen($chars);

    return $chars[rand(0, $len - 1)];
}


function fill_matrix($word, &$arr)
{
    $len = strlen($word);
    $x_max = 19;
    $y_max = 19;

    $x = ['leftRight', 'rightLeft'];
    $y = ['topBottom', 'bottomTop'];

    $horizontal = $x[rand(0, count($x) - 1)];

    $vertical = $y[rand(0, count($x) - 1)];

    $valid = false;

    while (!$valid) {
        //positions
        $x_pos = rand(0, $x_max);
        $y_pos = rand(0, $y_max);

        if ($horizontal == 'leftRight' && $x_pos + $len < 20) {
            if ($vertical == 'topBottom' && ($y_pos + $len < 20)) {
                $valid = true;
            }

            if ($vertical == 'bottomTop' && ($y_pos - $len >= 0)) {
                $valid = true;
            }
        }

        if ($horizontal == 'rightLeft' && $x_pos - $len >= 0) {
            if ($vertical == 'topBottom' && ($y_pos + $len < 20)) {
                $valid = true;
            }

            if ($vertical == 'bottomTop' && ($y_pos - $len >= 0)) {
                $valid = true;
            }
        }
    }

    //fill in the matrix with word
    for ($i = 0; $i < $len; $i++) {
        $arr[$y_pos][$x_pos] = $word[$i];

        if ($horizontal == 'leftRight')
            $x_pos++;
        if ($horizontal == 'rightLeft')
            $x_pos--;

        if ($vertical == 'topBottom')
            $y_pos++;
        if ($vertical == 'bottomTop')
            $y_pos--;
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        td {
            /* margin: 0 auto; */
            padding: 0.2em !important;
            text-align: center;
        }
    </style>
</head>

<body>
    
    <div class="container mb-3">
        <a href="page1.php" class="btn btn-secondary" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Redirect to page">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-return-left" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M14.5 1.5a.5.5 0 0 1 .5.5v4.8a2.5 2.5 0 0 1-2.5 2.5H2.707l3.347 3.346a.5.5 0 0 1-.708.708l-4.2-4.2a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 8.3H12.5A1.5 1.5 0 0 0 14 6.8V2a.5.5 0 0 1 .5-.5z" />
            </svg>
        </a>
    </div>

    <div class="text-center mb-2">
        <form action="page2.php" method="post">
            <button type="submit" name="replay" class="btn btn-success">Replay</button>
        </form>
    </div>

    <table class="table table-bordered border-primary">
        <?php
        $num = 20;
        for ($i = 0; $i < $num; $i++) {
            echo "<tr>";
            for ($j = 0; $j < $num; $j++) {
                echo "<td " . ((ctype_upper($arr[$i][$j]))  ? "style='font-weight: bold;'"  : '') . ">" . $arr[$i][$j] . "</td>";
            }
            echo "</tr>";
        }

        ?>
    </table>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>