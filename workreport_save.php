<?php
require_once 'config/sessionname.php';
session_start();
require_once 'config/coreconfig.php';
require_once 'config/connectdb.php';
require_once 'lib/function.php';

checkadminlogin();

$action = $_POST['action'];

$wp_id = isset($_POST['wp_id']) ? $_POST['wp_id'] : '';
$wp_start_male = isset($_POST['wp_start_male']) ? $_POST['wp_start_male'] : '';
$wp_start_female = isset($_POST['wp_start_female']) ? $_POST['wp_start_female'] : '';
$wp_start_sum = isset($_POST['wp_start_sum']) ? $_POST['wp_start_sum'] : '';
$wp_break = isset($_POST['wp_break']) ? $_POST['wp_break'] : '';
$wp_quit = isset($_POST['wp_quit']) ? $_POST['wp_quit'] : '';
$wp_out = isset($_POST['wp_out']) ? $_POST['wp_out'] : '';
$wp_died = isset($_POST['wp_died']) ? $_POST['wp_died'] : '';
$wp_died_text = trim(isset($_POST['wp_died_text']) ? $_POST['wp_died_text'] : '');
$wp_no_contact = isset($_POST['wp_no_contact']) ? $_POST['wp_no_contact'] : '';
$wp_end_male = isset($_POST['wp_end_male']) ? $_POST['wp_end_male'] : '';
$wp_end_female = isset($_POST['wp_end_female']) ? $_POST['wp_end_female'] : '';
$wp_end_sum = isset($_POST['wp_end_sum']) ? $_POST['wp_end_sum'] : '';
$wp_scholarship = isset($_POST['wp_scholarship']) ? $_POST['wp_scholarship'] : '';
$wp_scholarship_other = isset($_POST['wp_scholarship_other']) ? $_POST['wp_scholarship_other'] : '';
$wp_event = isset($_POST['wp_event']) ? $_POST['wp_event'] : '';
$wp_glorification = isset($_POST['wp_glorification']) ? $_POST['wp_glorification'] : '';
$wp_lowgrade = isset($_POST['wp_lowgrade']) ? $_POST['wp_lowgrade'] : '';
$wp_meeting = isset($_POST['wp_meeting']) ? $_POST['wp_meeting'] : '';
$wp_counsel = isset($_POST['wp_counsel']) ? $_POST['wp_counsel'] : '';
$wp_counsel_count = isset($_POST['wp_counsel_count']) ? $_POST['wp_counsel_count'] : '';
$teacher_id = isset($_POST['teacher_id']) ? $_POST['teacher_id'] : '';
$timereport_id = isset($_POST['timereport_id']) ? $_POST['timereport_id'] : '';
$groupstu_id = isset($_POST['groupstu_id']) ? $_POST['groupstu_id'] : '';
$field_id = isset($_POST['field_id']) ? $_POST['field_id'] : '';

if ($action == 'add') {

    $sql = 'INSERT INTO tb_workreport 
            (wp_start_male, wp_start_female, wp_start_sum, wp_break, wp_quit, wp_out, wp_died, wp_died_text, wp_no_contact, wp_end_male, wp_end_female, wp_end_sum, wp_scholarship, wp_scholarship_other, wp_event, wp_glorification, wp_lowgrade, wp_meeting, wp_counsel, wp_counsel_count, wp_createdate, teacher_id, timereport_id, groupstu_id, field_id) 
            VALUES 
            ("' . $wp_start_male . '", "' . $wp_start_female . '", "' . $wp_start_sum . '", "' . $wp_break . '", "' . $wp_quit . '", "' . $wp_out . '", "' . $wp_died . '", "' . $wp_died_text . '", "' . $wp_no_contact . '", "' . $wp_end_male . '", "' . $wp_end_female . '", "' . $wp_end_sum . '", "' . $wp_scholarship . '", "' . $wp_scholarship_other . '", "' . $wp_event . '", "' . $wp_glorification . '", "' . $wp_lowgrade . '", "' . $wp_meeting . '", "' . $wp_counsel . '", "' . $wp_counsel_count . '", NOW(), "' . $teacher_id . '", "' . $timereport_id . '", "' . $groupstu_id . '", "' . $field_id . '")';
    $insert = mysqli_query($con, $sql);

    if ($insert) {
        $last_id = mysqli_insert_id($con);

        for ($i = 0; $i <= 100; $i++) {
            if (isset($_POST['student_problems_problem_' . $i])) {
                $sql = 'INSERT INTO tb_student_problems (student_problems_problem, student_problems_solution, wp_id) VALUES ("' . nl2br(trim($_POST['student_problems_problem_' . $i])) . '", "' . nl2br(trim($_POST['student_problems_solution_' . $i])) . '", "' . $last_id . '")';
                mysqli_query($con, $sql);
            }
        }

        for ($i = 0; $i <= 100; $i++) {
            if (isset($_POST['student_problem_no_problem_' . $i])) {
                $sql = 'INSERT INTO tb_student_problem_no (student_problem_no_problem, wp_id) VALUES ("' . nl2br(trim($_POST['student_problem_no_problem_' . $i])) . '", "' . $last_id . '")';
                mysqli_query($con, $sql);
            }
        }


        for ($i = 0; $i <= 100; $i++) {
            if (isset($_POST['event_text_' . $i])) {
                $sql = 'INSERT INTO tb_event (event_text, wp_id) VALUES ("' . nl2br(trim($_POST['event_text_' . $i])) . '", "' . $last_id . '")';
                mysqli_query($con, $sql);
            }
        }

        for ($i = 0; $i <= 100; $i++) {
            if (isset($_POST['comment_text_' . $i])) {
                $sql = 'INSERT INTO tb_comment (comment_text, wp_id) VALUES ("' . nl2br(trim($_POST['comment_text_' . $i])) . '", "' . $last_id . '")';
                mysqli_query($con, $sql);
            }
        }

        echo json_encode(['success' => '1', 'msg' => 'บันทึกข้อมูลเรียบร้อยแล้ว']);
        exit();
    } else {
        echo json_encode(['success' => '0', 'msg' => 'เกิดข้อผิดพลาด ไม่สามารถบันทึกข้อมูลได้' . mysqli_error($con)]);
        exit();
    }
}

if ($action == 'edit') {

    $sql = 'UPDATE tb_workreport SET 
                wp_start_male = "' . $wp_start_male . '", 
                wp_start_female = "' . $wp_start_female . '", 
                wp_start_sum = "' . $wp_start_sum . '", 
                wp_break = "' . $wp_break . '", 
                wp_quit = "' . $wp_quit . '", 
                wp_out = "' . $wp_out . '", 
                wp_died = "' . $wp_died . '", 
                wp_died_text = "' . $wp_died_text . '", 
                wp_no_contact = "' . $wp_no_contact . '", 
                wp_end_male = "' . $wp_end_male . '", 
                wp_end_female = "' . $wp_end_female . '", 
                wp_end_sum = "' . $wp_end_sum . '", 
                wp_scholarship = "' . $wp_scholarship . '", 
                wp_scholarship_other = "' . $wp_scholarship_other . '", 
                wp_event = "' . $wp_event . '", 
                wp_glorification = "' . $wp_glorification . '", 
                wp_lowgrade = "' . $wp_lowgrade . '", 
                wp_meeting = "' . $wp_meeting . '", 
                wp_counsel = "' . $wp_counsel . '", 
                wp_counsel_count = "' . $wp_counsel_count . '" 
            WHERE 
                wp_id = "' . $wp_id . '"';
    $rs = mysqli_query($con, $sql);

    if ($rs) {
        $sql = 'DELETE FROM tb_comment WHERE wp_id = "' . $wp_id . '"';
        mysqli_query($con, $sql);

        $sql = 'DELETE FROM tb_event WHERE wp_id = "' . $wp_id . '"';
        mysqli_query($con, $sql);

        $sql = 'DELETE FROM tb_student_problem_no WHERE wp_id = "' . $wp_id . '"';
        mysqli_query($con, $sql);

        $sql = 'DELETE FROM tb_student_problems WHERE wp_id = "' . $wp_id . '"';
        mysqli_query($con, $sql);

        for ($i = 0; $i <= 100; $i++) {
            if (isset($_POST['student_problems_problem_' . $i])) {
                $sql = 'INSERT INTO tb_student_problems (student_problems_problem, student_problems_solution, wp_id) VALUES ("' . nl2br(trim($_POST['student_problems_problem_' . $i])) . '", "' . nl2br(trim($_POST['student_problems_solution_' . $i])) . '", "' . $wp_id . '")';
                mysqli_query($con, $sql);
            }
        }

        for ($i = 0; $i <= 100; $i++) {
            if (isset($_POST['student_problem_no_problem_' . $i])) {
                $sql = 'INSERT INTO tb_student_problem_no (student_problem_no_problem, wp_id) VALUES ("' . nl2br(trim($_POST['student_problem_no_problem_' . $i])) . '", "' . $wp_id . '")';
                mysqli_query($con, $sql);
            }
        }


        for ($i = 0; $i <= 100; $i++) {
            if (isset($_POST['event_text_' . $i])) {
                $sql = 'INSERT INTO tb_event (event_text, wp_id) VALUES ("' . nl2br(trim($_POST['event_text_' . $i])) . '", "' . $wp_id . '")';
                mysqli_query($con, $sql);
            }
        }

        for ($i = 0; $i <= 100; $i++) {
            if (isset($_POST['comment_text_' . $i])) {
                $sql = 'INSERT INTO tb_comment (comment_text, wp_id) VALUES ("' . nl2br(trim($_POST['comment_text_' . $i])) . '", "' . $wp_id . '")';
                mysqli_query($con, $sql);
            }
        }

        echo json_encode(['success' => '1', 'msg' => 'บันทึกข้อมูลเรียบร้อยแล้ว']);
        exit();
    } else {
        echo json_encode(['success' => '0', 'msg' => 'เกิดข้อผิดพลาด ไม่สามารถบันทึกข้อมูลได้' . mysqli_error($con)]);
        exit();
    }
}

if ($action == 'approved') {
    $sql = 'UPDATE tb_workreport SET 
                manager_id = "' . $_SESSION['user_id'] . '",
                wp_approveddate = NOW()  
            WHERE 
                wp_id = "' . $wp_id . '"';
    $rs = mysqli_query($con, $sql);
    if ($rs) {
        echo json_encode(['success' => '1', 'msg' => 'บันทึกข้อมูลเรียบร้อยแล้ว']);
        exit();
    } else {
        echo json_encode(['success' => '0', 'msg' => 'เกิดข้อผิดพลาด ไม่สามารถบันทึกข้อมูลได้']);
        exit();
    }
}

if ($action == 'delete') {
    $sql = 'DELETE FROM tb_comment WHERE wp_id = "' . $wp_id . '"';
    mysqli_query($con, $sql);

    $sql = 'DELETE FROM tb_event WHERE wp_id = "' . $wp_id . '"';
    mysqli_query($con, $sql);

    $sql = 'DELETE FROM tb_student_problem_no WHERE wp_id = "' . $wp_id . '"';
    mysqli_query($con, $sql);

    $sql = 'DELETE FROM tb_student_problems WHERE wp_id = "' . $wp_id . '"';
    mysqli_query($con, $sql);

    $sql = 'DELETE FROM tb_workreport WHERE wp_id = "' . $wp_id . '"';
    mysqli_query($con, $sql);

    echo json_encode(['success' => '1', 'msg' => 'ลบข้อมูลเรียบร้อยแล้ว']);
    exit();
}
