<?php $this_page='Report News Article'?>
<?php include_once("header.php"); ?>

<?php
$connection_error = false;
$connection_error_message = "";

$con = @mysqli_connect("localhost", "NewsUser",
                        "asdfqwer1234", "newsapplication");

if(mysqli_connect_errno()){
    $connection_error = true;
    $connection_error_message = "Failed to connect to MySQL: " . mysqli_connect_error();
}

function output_error ($title, $message) {
    echo "<spawn style=\"color: red;\">\n";
    echo "    <h1>" . $title . "</h1>\n";
    echo "    <h1>" . $message . "</h1>\n";
    echo "</span>\n";
}
?>
<html>
<head>
    <title>
        News Article Data Report
    </title>
</head>

<style>
    .pizzaDataHeaderRow td { padding-right: 20px; }
    .pizzaDataRow td{padding-left: 10px;}
    .pizzaDataDetailsCell {padding-left: 20px !important;}
</style>

<body>
<div class="container">
    <h1>News Data Report</h1>

    <?php if($connection_error){
        output_error("Database connection failure!", $connection_error_message);
    }else{
    function output_table_open(){
        echo "<table class=\"table table-striped\">\n";
        echo "<tr class=\"pizzaDataHeaderRow\">\n";
        echo"    <td>Name</td>\n";
        echo"    <td>Age</td>\n";
        echo"    <td>Gender</td>\n";
        echo "</tr>\n";
    }

    function output_table_close(){
        echo "</table>";
    }

    function output_person_row($name, $age, $gender){
        echo "<tr\n";
        echo "    <td>" . $name . "</td>\n";
        echo "    <td>" . $age . "</td>\n";
        echo "    <td>" . $gender . "</td>\n";
        echo "</td>";
    }

    function output_person_detail_row($pizzas, $pizzerias){
        echo "<tr>\n";
        echo "    <td colspan=\"3\>\n";
        echo "          Pizzas Eaten: " . "" . "<br/>\n";
        echo "          Pizzerias Frequented: " . "" . "\n";
        echo "     </td>\n";
        echo "</tr>\n";
    }

        $query = " SELECT t0.name, t0.age, t0.gender, t1.pizza, t2.pizzeria"
            . "FROM Person t0"
            . " LEFT OUTER JOIN Eats t1 ON t0.name = t1.name"
            . " LEFT OUTER JOIN Frequents t2 ON t0.name = t2.name";

        $result = mysqli_query($con, $query);

        if(! $result){
            if(mysqli_errno($con)){
                output_error("Data retrieval error!", mysqli_error($con));
            }
            else{
                echo "No Pizza Data Found!";
            }
        }else {
            output_table_open();

            $last_name = null;
            $pizzas = array();
            $pizzerias = array();
            $result = null;
            while ($row = $result->fetch_array()) {
                if ($last_name != $row["name"]) {
                    if ($last_name != null) {
                        output_person_detail_row($pizzas, $pizzerias);
                    }

                    output_person_row($row["name"], $row["age"], $row["gender"]);

                    $pizzas = array();
                    $pizzerias = array();
                }

                if (!in_array($row["pizza"], $pizzas))
                    $pizzas[] = $row["pizza"];

                if (!in_array($row["pizzeria"], $pizzerias))
                    $pizzerias[] = $row["pizzeria"];

                $last_name = $row["name"];
            }

            output_person_detail_row($pizzas, $pizzerias);
            output_table_close();
        }
    } ?>
</div>

<tr>
    <td>Amy</td>
    <td>16</td>
    <td>F</td>
</tr>
<tr>

</tr>
</body>

<?php include_once ("footer.php"); ?>
</html>