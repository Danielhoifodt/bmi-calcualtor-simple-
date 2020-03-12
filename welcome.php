<?php
require_once 'login_config.php';

session_start();
if (isset($_GET["del"])) {
    $del = $_GET["del"];
    $stmt_del = $pdo->prepare("DELETE FROM bmi_table WHERE id = :id");
    $stmt_del->bindParam(':id', $del);
    $stmt_del->execute();
}

if(isset($_SESSION["id"])){
    $userID = $_SESSION["id"];

    $stmt_get = $pdo->prepare("SELECT * FROM bmi_table WHERE userID=:userID");
    $stmt_get->bindParam(":userID", $userID);
    $stmt_get->execute(); 
    
    $data_get = $stmt_get->fetchAll();
}

if(isset($_POST["submit"]))
{
    $weight = $_POST["weight"];
    $height = $_POST["height"];

    $stmt_post = $pdo->prepare("INSERT INTO bmi_table (weight, height, userID) VALUE (:weight, :height, :userID)");
    $stmt_post->bindParam(":weight", $weight);
    $stmt_post->bindParam(":height", $height);
    $stmt_post->bindParam(":userID", $userID);
    $stmt_post->execute();
    header("Refresh:0");
}
$graph_type = "bar";
if(isset($_POST["submit_select"])){
$graph_type = $_POST["graph"];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script
        src="https://code.jquery.com/jquery-3.4.1.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
        crossorigin="anonymous"></script>
    <script src="scripts/chart.min.js"></script>
    
    <title>BMI Calculator</title>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-7">
        <h1 class="mt-5 mb-5">BMI Kalkulator og graf</h1>
        <form action="welcome.php" method="post">
        <div class="form-group">
        <label>Høyde (cm)</label>
        <input type="text" class="form-control" name="height">
        </div>
        <div class="form-group">
        <label>Vekt (kg)</label>
        <input type="text" class="form-control" name="weight">
        </div>
        <div class="form-group">
        <input type="submit" class="btn btn-dark form-control" name="submit" value="Send inn og vis i graf">
        </div>
        </form>
        <form action="welcome.php" method="post">
            <div class="form-group">
                <select name="graph">
                <option class="form-control" value="bar" selected>Bar</option>
                <option class="form-control" value="line">Linje</option>
                </select>
                <input type="submit" class="form-control" name="submit_select" value="Godta graf">
            </div>
        </form>
        </div>
        <div class="col-5">
        <div style="height:125px;"></div>
        <table class="table mt-5">
            <thead>
            <tr>
                <th>Høyde(cm)</th>
                <th>Vekt(kg)</th>
                <th>BMI</th>
            </tr>
            </thead>
            <tbody>
            <?php 
            foreach($data_get as $row){
            $weight = $row["weight"];
            $height = $row["height"];
            $id = $row["id"];
            $height_cm = $height / 100;
            $bmi = $weight / pow($height_cm, 2);
            $bmi_round = number_format((float)$bmi, 2, '.', '');
            ?>
            <tr>
            <td><?php echo $height;?></td>
            <td><?php echo $weight;?></td>
            <td><?php echo $bmi_round;?></td>
            <td><a style="color:red;" href="welcome.php?del=<?php echo $id;?>">Slette</a></td>
            </tr>
            <?php } ?>
            </tbody>
        </table>
        </div>
    </div>
    <br><br>
<a style="text-align:center;" href="logout.php">Logg ut</a><span class="text-muted float-right">Velkommen <?php echo $_SESSION["username"];?></span>
<br><br>
</div>


<br><br>
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                <canvas id="myChart" width="400" height="400"></canvas>
                </div>
            </div>
        </div>
     </div>     
</div>




<script>
var ctx = document.getElementById('myChart');
var myChart = new Chart(ctx, {
    type: '<?php echo $graph_type;?>',
    data: {
        labels: [<?php
                foreach($data_get as $row1){
                    $date = $row1["date"];
                    echo '"';
                    echo $date;
                    echo '"';
                    echo ',';
                }
                ?>],
        datasets: [{
            label: 'Din BMI over tid',
            
            data:[
            <?php
            foreach($data_get as $row2){
            $weight = $row2["weight"];
            $height = $row2["height"];
            $height_cm = $height / 100;
            $bmi = $weight / pow($height_cm, 2);
            echo $bmi;
            echo ',';
            }
            ?>],
            backgroundColor: [
            ],
            borderColor: [
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
});
</script>
</body>
</html>