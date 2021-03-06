<?php
function getSubjects($connection,$fields = array("*"),$a = array()){
	$response = array();
	$condition = "";
	if(@$a['course']){
		$condition .= " AND course = '".$a['course']."' ";
	}
	if(@$a['semester']){
		$condition .= " AND semester = '".$a['semester']."' ";
	}
	if(@$a['limit']){
		$condition .= "  limit ".$a['limit']." ";
	}

	$sqlstmt = "SELECT ".implode(",",$fields)." from subjects WHERE 1 ".$condition." ";
	#echo $sqlstmt;
	$getSubjectsRes = mysql_query($sqlstmt,$connection);
	while($getSubjects = mysql_fetch_assoc($getSubjectsRes)){
		$response[] = $getSubjects;
	}
	return $response;
}
function getSubjectsCount($connection,$course,$semester){
	$response = array();
	$condition = "";
	$sqlstmt = "SELECT subjects from subjects WHERE course='".$course."' AND semester='".$semester."' LIMIT 1";
	#echo $sqlstmt;
	$getSubjectsRes = mysql_query($sqlstmt,$connection);
	$getSubjects = mysql_fetch_assoc($getSubjectsRes);
	$response['count'] = count(json_decode($getSubjects['subjects'],true));
	
	return $response;
}
function getCourse($connection,$fields = array("*"),$a = array()){
	$response = array();
	$condition = "";

	if(@$a['abbrcourse']){
		$condition .= " AND abbrCourse = '".$a['abbrcourse']."' ";
	}
	if(@$a['id']){
		$condition .= " AND id = '".$a['id']."' ";
	}
	if(@$a['limit']){
		$condition .= "  limit ".$a['limit']." ";
	}
	
	$sqlstmt = "SELECT ".implode(",",$fields)." from course WHERE 1 ".$condition." ";
	#echo $sqlstmt;
	$getCourseRes = mysql_query($sqlstmt,$connection);
	while($getCourse = mysql_fetch_assoc($getCourseRes)){
		$response[] = $getCourse;
	}
	return $response;
}
function getReport($connection,$fields = array("*"),$a = array()){
	$response = array();
	$condition = "";
	if(@$a['course']){
		$condition .= " AND course = '".$a['course']."' ";
	}
	if(@$a['semester']){
		$condition .= " AND semester = '".$a['semester']."' ";
	}
	if(@$a['passingyear']){
		$condition .= " AND monthYear LIKE '%".$a['passingyear']."' ";
	}
	if(@$a['limit']){
		$condition .= "  limit ".$a['limit']." ";
	}
	if(@$a['id']){
		$condition .= "AND  id IN(".$a['id'].") ";
	}

	$sqlstmt = "SELECT ".implode(",",$fields)." from studentreport WHERE 1 ".$condition." ";
	 #echo $sqlstmt;
	$getSubjectsRes = mysql_query($sqlstmt,$connection);
	while($getSubjects = mysql_fetch_assoc($getSubjectsRes)){
		$response[] = $getSubjects;
	}
	return $response;
}

function validateMarks($actual=array(),$obt=array(),$type="insert"){
	$returnVal = 0;
	if($type =="update"){
		$iCount = count($obt);
	}
	else{
		$iCount = count($actual);
	}
	for($i=0;$i<$iCount;$i++){
		if(($obt[$i]['external'] > $actual[$i]['external']) || ($obt[$i]['internal'] > $actual[$i]['internal']) || $obt[$i]['external']=='' || $obt[$i]['internal']=='')
			$returnVal = 1;

	}
	return $returnVal;
}
function CheckEmptyMarks(array $subjectArray){
	$empty = 0;
	if (count($subjectArray) > 1){
		foreach($subjectArray as $key=>$val){
			if(empty($val['subject']) || empty($val['internal']) || empty($val['external'])){
				$empty = 1;
				break;
			}
		}
	}
	return $empty;
}
?>