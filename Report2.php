<?php $this_page='Report News Article'?>
<?php include_once("header.php"); ?>

<?php
$connection_error = false;
$connection_error_message = "";

$con = @mysqli_connect("localhost", "newsfella",
    "password", "sakila");

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
</style>

<body>
<div class="container">
    <h1>User Data Report</h1>

    <?php
    if($connection_error){
        output_error("Database connection failure!", $connection_error_message);
    }
    else {
        function output_table_open()
        {
            echo "<table class=\"table table-striped\">\n";
            echo "<tr class=\"pizzaDataHeaderRow\">\n";
            echo "    <td>UserID</td>\n";
            echo "    <td>First Name</td>\n";
            echo "    <td>Last Name</td>\n";
            echo "    <td>Username</td>\n";
            echo "    <td>Password</td>\n";
            echo "    <td>Email Address</td>\n";
            echo "</tr>\n";
        }

        function output_table_close()
        {
            echo "</table>";
        }

        function output_user_row($UserID, $FirstName, $LastName, $Username, $Password, $EmailAddress)
        {
            echo "<tr\n>";
            echo "    <td>" . $UserID . "</td>\n";
            echo "    <td>" . $FirstName . "</td>\n";
            echo "    <td>" . $LastName . "</td>\n";
            echo "    <td>" . $Username . "</td>\n";
            echo "    <td>" . $Password . "</td>\n";
            echo "    <td>" . $EmailAddress . "</td>\n";
            echo "</td>";
        }

        function output_user_detail_row($Comment, $Subscription)
        {

            $comment_str = "None";
            if ($Comment[0] != NULL) {
                $comment_str = "Comment #" . $Comment[0] . " on article " . $Comment[1] . ", \"" . $Comment[2] . "\", " . $Comment[3] . " likes.\n";
            }

            $subscription_str = "None";
            if (sizeof($Subscription) > 0) {
                $subscription_str = "Subscription type " . $Subscription[1] . ", paying $" . $Subscription[2] . " " . $Subscription[3] . "\n";
            }

            echo "<tr>\n";
            echo "    <td style='padding-left: 100px' colspan='7'>\n";
            echo $comment_str . "\n<br/>";
            echo $subscription_str . "\n<br/>";
            echo "     </td>\n";
            echo "</tr>\n";
        }

        $query = " SELECT * "
            . "FROM user t0"
            . " LEFT OUTER JOIN comment t1 ON t0.UserID = t1.User"
            . " LEFT OUTER JOIN subscription t2 ON t0.Subscription = t2.SubscriptionID";

        $result = mysqli_query($con, $query);

        if (!$result) {
            if (mysqli_errno($con)) {
                output_error("Data retrieval error!", mysqli_error($con));
            } else {
                echo "No Article Data Found!";
            }
        } else {
            output_table_open();

            $last_user = null;
            $comments = array();
            $subscription = array();

            while ($row = $result->fetch_array()) {
                if ($last_user != $row["UserID"]) {
                    if ($last_user != null) {
                        output_user_detail_row($comments, $subscription);
                    }

                    output_user_row($row["UserID"], $row["FirstName"], $row["LastName"], $row["Username"], $row["Password"], $row["EmailAddress"]);
                    $comments = array($row["CommentID"], $row["Article"], $row["Text"], $row["Likes"]);
                    $subscription = array($row["SubscriptionID"], $row["Title"], $row["Price"], $row["RenewalPeriod"]);

                }

                if (!in_array($row["CommentID"], $comments)) {
                    $comments = array($row["CommentID"], $row["Article"], $row["Text"], $row["Likes"]);
                }
                if (!in_array($row["SubscriptionID"], $subscription)) {
                    $subscription = array($row["SubscriptionID"], $row["Title"], $row["Price"], $row["RenewalPeriod"]);
                }
                $last_user = $row["UserID"];


            }

            output_user_detail_row($comments, $subscription);
            output_table_close();
        }

    }?>
</div>

</body>

<?php include_once ("footer.php"); ?>
</html>}