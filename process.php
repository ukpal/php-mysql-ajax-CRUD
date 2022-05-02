<?php
require 'connection.php';

if (isset($_POST)) {

    if (isset($_POST['action']) && $_POST['action'] == 'create') {

        $sql = "insert into users(name,email,phone) values('" . $_POST['name'] . "','" . $_POST['email'] . "','" . $_POST['phone'] . "')";
        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    if (isset($_POST['action']) && $_POST['action'] == 'read') {
        $sql = "select * from users order by id desc";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $data=[];
            while ($row = $result->fetch_assoc()) {
                $data[]=$row;
            }
            echo json_encode($data);
        }
    }

    if (isset($_POST['action']) && $_POST['action'] == 'delete') {
        $sql = "delete from users where id=".$_POST['id'];
        if ($conn->query($sql) === TRUE) {
            echo "record deleted successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    if (isset($_POST['action']) && $_POST['action'] == 'edit') {
        $sql = "select * from users where id=".$_POST['id'];
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            echo json_encode($row);           
        }
    }

    if (isset($_POST['action']) && $_POST['action'] == 'update') {
        $sql = "update users set name='".$_POST['name']."',email='".$_POST['email']."',phone='".$_POST['phone']."' where id=".$_POST['id'];
        $result = $conn->query($sql);
        if ($conn->query($sql) === TRUE) {
            echo "record updated successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}
