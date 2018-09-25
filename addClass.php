<?php
require "../libs/Smarty.class.php";
require "mysql.class.php";
ini_set("display_errors", "on");

$smarty = new Smarty();
$mysql = new Mysql();

$course =[];
//更新
if(isset($_POST["course_name"])){
    if(isset($_GET["id"]) && $_GET["id"] != null){
   $course_id = $_GET["id"];
   $course_name = $_POST["course_name"];
   $course_hour = $_POST["course_hour"];
   $course_score = $_POST["course_score"];
   $course_desc = $_POST["course_desc"];
   if($_POST["kind"] == "required"){
       $required = "Y";
       $public = "N";
   }else if($_POST["kind"] == "public"){
      $required = "N";
      $public = "Y";
   }
   $selAca = $_POST["academy"];
   $selMaj = $_POST["major"];
   $sqlUp = "update tbcourse
   set course_name = '".$course_name."',
   course_score = $course_score,
   course_hour = $course_hour,
   course_desc = '".$course_desc."',
   course_required = '".$required."',
   course_public = '".$public."',
   academy_id = $selAca,
   major_id = $selMaj
   where course_id = $course_id ";
   $result = $mysql->query($sqlUp);
   if($result){
    echo "<script>alert('更新成功')</script>";
   }else{
    echo "<script>alert('更新失败')</script>";
   }
}else{
//插入数据
    $course_name = $_POST["course_name"];
    $course_hour = $_POST["course_hour"];
    $course_score = $_POST["course_score"];
    $course_desc = $_POST["course_desc"];
    if($_POST["kind"] == "required"){
        $required = "Y";
        $public = "N";
    }else if($_POST["kind"] == "public"){
       $required = "N";
       $public = "Y";
    }
    $selAca = $_POST["academy"];
    $selMaj = $_POST["major"];
    $sqlIn = "insert into tbcourse(course_name,course_score,course_hour,
    course_desc,course_required,course_public,academy_id,major_id) 
    value('".$course_name."','".$course_score."','".$course_hour."','".$course_desc."',
    '".$required."','".$public."','".$selAca."','".$selMaj."');";
    $result = $mysql->query($sqlIn);
    if($result){
        echo "<script>alert('插入成功')</script>";
    }else{
        echo "<script>alert('插入失败')</script>";
    }
}
}
//如果有id则调出相应的课程数据
if(isset($_GET["id"])){
    $id = $_GET["id"];
    $sql = "select * from tbcourse where course_id = $id";
    $course = mysqli_fetch_assoc($mysql->query($sql));
}else{
    $id = 0;
    $course = [
        "course_id" => null,
        "course_name" => null,
        "course_hour" => null,
        "course_score" => null,
        "course_desc" => null,
        "course_public" => null,
        "course_required" => null,
        "major_id" => null,
        "academy_id" => null
    ];
}
$smarty->assign("course",$course);
$smarty->assign("id",$id);
//院系的查询
$sqlAca = "select academy_id,academy_name from tbacademy";
$resAca = $mysql->query($sqlAca);
while($result = mysqli_fetch_assoc($resAca)){
     $academy[$result["academy_id"]] = $result["academy_name"];
}
//专业的查询
$sqlMaj = "select major_id ,major_name  from tbmajor";
$resMaj = $mysql->query($sqlMaj);
while($result = mysqli_fetch_assoc($resMaj)){
    $major[$result["major_id"]] = $result["major_name"];
}
$smarty->assign("academy",$academy);
$smarty->assign("major",$major);
$smarty->display("addClass.html");
?>