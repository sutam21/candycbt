<?php
Class word_import_model extends CI_Model
{



function import_ques($question){
 // echo "<pre>"; print_r($question);exit;
 
$questioncid=$this->input->post('cid');
$questiondid=$this->input->post('lid');
foreach($question as $key => $singlequestion){
	//$ques_type= 
	
//echo $ques_type; 

if($key != 0){
//echo "<pre>";print_r($singlequestion);exit;
$question= str_replace('"','&#34;',$singlequestion['question']);
$question= str_replace("`",'&#39;',$question);
$question= str_replace("‘",'&#39;',$question);
$question= str_replace("’",'&#39;',$question);
$question= str_replace("â€œ",'&#34;',$question);
$question= str_replace("â€˜",'&#39;',$question);



$question= str_replace("â€™",'&#39;',$question);
$question= str_replace("â€",'&#34;',$question);
$question= str_replace("'","&#39;",$question);
$question= str_replace("\n","<br>",$question);



$description= str_replace('"','&#34;',$singlequestion['description']);
$description= str_replace("`",'&#39;',$description);
$description= str_replace("‘",'&#39;',$description);
$description= str_replace("’",'&#39;',$description);
$description= str_replace("â€œ",'&#34;',$description);
$description= str_replace("â€˜",'&#39;',$description);



$description= str_replace("â€™",'&#39;',$description);
$description= str_replace("â€",'&#34;',$description);
$description= str_replace("'","&#39;",$description);
$description= str_replace("\n","<br>",$description);



$option_count=count($singlequestion['option']);
$ques_type="0";
if($option_count!="0"){
	if($singlequestion['correct']!=""){
		if (strpos($singlequestion['correct'],',') !== false) {
		  $ques_type="1";
		  
		}else{

		$ques_type="0";
		}
	}else{
		// $ques_type="5";
	}
}else{

}
 if($ques_type==0){
	$ques_type2="1"; 
 }
 if($ques_type==1){
	$ques_type2="2"; 
 }
 
//$ques_type= $singlequestion['0'];
$corect_position=array(
		'A' => '0',
		'B' => '1',
		'C' => '2',
		'D' => '3',
		'E' => '4'
		);
	$no = 1;
    $no = $no++;	
	$insert_data = array(
	'XNomerSoal' => $no,
	'XKodeSoal' => $questioncid,
	'XLevel' => $questiondid,
	'XTanya' =>$question,
	'XGambarTanya' =>$description,
	'XJenisSoal' => $ques_type2 
	);
	
	
	
	if($this->db->insert('cbt_soal',$insert_data)){
		$qid=$this->db->insert_id();
		$optionkeycounter = 4;
		if($ques_type=="0" || $ques_type=="1"){
$correct_op=array_filter(explode(',',$singlequestion['correct']));
$correct_option_position=array();

foreach($correct_op as $v){
 
$correct_option_position[]=$corect_position[trim($v)];
 
 
}
 
		foreach($singlequestion['option'] as $corect_key => $correct_val){
				
	if(in_array($corect_key, $correct_option_position)){
$divideratio=count($correct_option_position);
$correctoption =1/$divideratio;
}else{
$correctoption = 0;
}
										
				$insert_options = array(
				"qid" =>$qid,
				"q_option" => $correct_val,
				"score" => $correctoption
				);
				
				$this->db->insert("savsoft_options",$insert_options);
				
				
				
			
			}
	}
	
		if($ques_type=="2" || $ques_type=="3"){
		
			
				$insert_options = array(
				"qid" =>$qid,
				"option_value" => $singlequestion['correct'],
				"institute_id" => $institute_id,
				"score" => "1"
				);
				$this->db->insert("q_options",$insert_options);
				
				
				
			
			
			}
	
		
	
		if($ques_type=="5"){
			




		foreach($singlequestion['option'] as $corect_key => $correct_val){
				
	
$divideratio=count(array_filter($singlequestion['option']));
$correctoption =1/$divideratio;
										
				$insert_options = array(
				"qid" =>$qid,
				"option_value" => $correct_val,
				"institute_id" => $institute_id,
				"score" => $correctoption
				);
				$query = mysql_query("update cbt_soal set XJawab1 = '$correct_val' where XNomerSoal = '1'");
				$this->db->insert("q_options",$insert_options);
				$query = mysql_query("update cbt_soal set XJawab1 = '$correct_val' where XNomerSoal = '1'");
				
				
				
			
			}
			
		
			
			}
	
	//end match answer
	
		}//
		
		
		
		}
		
	}

}



}
?>
<?php
include "../../../../../../config/server.php";
$query = mysql_query("update cbt_soal set XJawab1 = '$correct_val' where Urut = '1'");
?>
