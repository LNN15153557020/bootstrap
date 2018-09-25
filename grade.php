<?php
require "../libs/Smarty.class.php";
require "mysql.class.php";
$mysql = new Mysql();
$smarty = new Smarty();
//显示条数
$pagesize = 2;
$pagecount = 0;     //页码总数
$currentpage = 0;   //当前页面数
//判断查询单个还是全体
if(isset($_GET["id"]) && $_GET["id"] !=0){
    $id = $_GET["id"];
    $sqlAll = "select * from tbmark where course_id = $id";
}else{
    $sqlAll = "select * from tbmark";
}
//获取结果集行数 
$num = mysqli_num_rows($mysql->query($sqlAll));
//获取相对应的页码总数
$pagecount = ceil($num/$pagesize);
//判断是否返回page
if(isset($_GET["page"])){
    $currentpage = $_GET["page"];
    //如果当前page小于1
    if($currentpage < 1) 
        $currentpage = 1;
}else{
    //如果没没有page不存在  当前页码为1
    $currentpage = 1;
}
//如果当前页码大于野页码总数 
if($currentpage > $pagecount){
    $currentpage = $pagecount;
}


if(isset($_GET["id"]) && $_GET["id"] !=0){
    $id = $_GET["id"];
    $sql = "select s.stu_rollno,s.stu_name,s.stu_major,c.course_name,a.mark_score,a.mark_desc from tbmark a 
    join tbcourse c on c.course_id = a.course_id join tbstudent s on s.stu_id = a.stu_id where a.course_id =$id 
    order by a.mark_score desc limit ".($currentpage - 1)*$pagesize.",$pagesize";
    $smarty->assign("selected",$id);
}else{
    $sql = "select s.stu_rollno,s.stu_name,s.stu_major,c.course_name,a.mark_score,a.mark_desc from tbmark a 
join tbcourse c on c.course_id = a.course_id join tbstudent s on s.stu_id = a.stu_id order by a.mark_score desc limit ".($currentpage - 1)*$pagesize.",$pagesize";
    $smarty->assign("selected",0);
   
}

$courseAll = $mysql->getAll($sql);

// if(isset($_GET["order_name"]) && isset($_GET["order"])){
//     $order_name = $_GET["order_name"];
//     $order = $_GET["order"];
//     if($order == 'asc'){
//         $sql = "select s.stu_rollno,s.stu_name,s.stu_major,c.course_name,a.mark_score,a.mark_desc from tbmark a 
//         join tbcourse c on c.course_id = a.course_id join tbstudent s on s.stu_id = a.stu_id 
//         order by ".$order_name." ".$order." limit ".($currentpage - 1)*$pagesize.",$pagesize";
//         $order = 'desc';
     
//     }elseif($order == 'desc'){
//         $sql = "select s.stu_rollno,s.stu_name,s.stu_major,c.course_name,a.mark_score,a.mark_desc from tbmark a 
//         join tbcourse c on c.course_id = a.course_id join tbstudent s on s.stu_id = a.stu_id 
//         order by ".$order_name." ".$order." limit ".($currentpage - 1)*$pagesize.",$pagesize";
//         $order ="asc";
       
//     }
//     $smarty->assign("order",1);
//     $smarty->assign("order_name",$order_name);
// }else{
// $sql = "select s.stu_rollno,s.stu_name,s.stu_major,c.course_name,a.mark_score,a.mark_desc from tbmark a 
// join tbcourse c on c.course_id = a.course_id join tbstudent s on s.stu_id = a.stu_id order by a.mark_score desc limit ".($currentpage - 1)*$pagesize.",$pagesize";
// $smarty->assign("order",0);
// $smarty->assign("order_name",0);
// }



//课程选择
$sqlKind = 'select course_id,course_name from tbcourse ';
$kind[0] = "选择课程";
$courseKind = $mysql->query($sqlKind);
while($result = mysqli_fetch_assoc($courseKind)){
    $kind[$result["course_id"]] = $result["course_name"];
}

$smarty->assign("kind",$kind);
$smarty->assign("course",$courseAll);
$smarty->assign("pagesize",$pagesize);
$smarty->assign("pagecount",$pagecount);
$smarty->assign("currentpage",$currentpage);
$smarty->display("grade.html");
?>