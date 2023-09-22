<?php
class user
{
    public $id = 1;
    public $uname;
    public $callname;
    public $age;
    public $height;
    public $verifykey;
    public $creator;
    public $fav_color;
    public $fav_food;
    public $remeberit;


    public function user_info($conn)
    {
        $sql = "SELECT * FROM users WHERE id = ?;";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("location: ../signup.php?error=stmtfailed");
            exit();
        }
        $id = 1;
        mysqli_stmt_bind_param($stmt, "s", $id);
        mysqli_stmt_execute($stmt);
        $result_data = mysqli_stmt_get_result($stmt);
        if ($row = mysqli_fetch_assoc($result_data)) {


            $this->uname = $row['uname'];
            $this->callname = $row['callname'];
            $this->age = $row['age'];
            $this->height = $row['height'];
            $this->verifykey = $row['verifykey'];
            $this->creator = $row['creator'];
            $this->fav_color = $row['fav_color'];
            $this->fav_food = $row['fav_food'];
            $this->remeberit = $row['remeberit'];

        }
    }
    public function user_changeing($lastword, $conn)
    {
        $sql = "UPDATE users SET callname = ?;";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $lastword);
        $result = $stmt->execute();

        if ($result) {
            echo "Record updated successfully.";
        } else {
            echo "Error updating record: " . $stmt->error;
        }

        // Close the connection
        $stmt->close();
        $conn->close();


    }
    public function remember($result, $conn)
    {
        $sql = "UPDATE users SET remeberit = ?;";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $result);
        $result = $stmt->execute();

        if ($result) {
            echo "Record updated successfully.";
        } else {
            echo "Error updating record: " . $stmt->error;
        }

        // Close the connection
        $stmt->close();
        $conn->close();
    }

}