<?php

    function find_all_subjects(){
        global $db;

        $sql = "SELECT * FROM subjects ";
        $sql .= "ORDER BY position ASC";
//        echo $sql; // Troubleshooting
        $result = mysqli_query($db, $sql);
        confirm_result_set($result);
        return $result;
    }


    function find_subject_by_id($id) {
        global $db;

        $sql = "SELECT * FROM subjects ";
        $sql .= "WHERE id='" . $id ."'";
        $result = mysqli_query($db, $sql);
        confirm_result_set($result);
        $subject = mysqli_fetch_assoc($result);
        mysqli_free_result($result);

        return $subject; // returns an assoc. array
    }


    function insert_subject($subject) {
        global $db;

        $sql = "INSERT INTO subjects ";
        $sql .= "(menu_name, position, visible) ";
        $sql .= "Values (";
        $sql .= "'" . $subject['menu_name'] . "',";
        $sql .= "'" . $subject['position']. "',";
        $sql .= "'" . $subject['visible'] . "'";
        $sql .= ")";

        $result = mysqli_query($db, $sql);

        // For insert statements, $result is true/false
        if($result){
            return true;
        } else {
            // INSERT failed
            echo mysqli_error($db);
            db_disconnect($db);
            exit;
        }
    }


    function update_subject($subject) {
        global $db;

        $sql = "UPDATE subjects SET ";
        $sql .= "menu_name='" . $subject['menu_name'] . "',";
        $sql .= "position='" . $subject['position'] . "',";
        $sql .= "visible='" . $subject['visible'] . "' ";
        $sql .= "WHERE id='" . $subject['id'] . "' ";
        $sql .= "LIMIT 1";

        $result = mysqli_query($db, $sql);

        if($result){
            return true;
        } else {
            // Update failed
            echo mysqli_error($db);
            db_disconnect($db);
            exit;
        }
    }


    function delete_subject($id) {

        global $db;


        $sql = "DELETE FROM subjects ";
        $sql .= "WHERE id='" . $id ."' ";
        $sql .= "LIMIT 1";

        $result = mysqli_query($db, $sql);

        // For DELETE statements, $result is true/false
        if($result) {
            return true;
        } else {
            // Update failed
            echo mysqli_error($db);
            db_disconnect($db);
            exit;
        }
    }


    function find_all_pages() {
        global $db;

        $sql = "SELECT * FROM pages ";
        $sql .= "ORDER BY subject_id ASC, position ASC";
//        echo $sql; // Troubleshooting
        $result = mysqli_query($db, $sql);
        confirm_result_set($result);
        return $result;
    }

?>