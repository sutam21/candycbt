<?php
Class word_import_model extends CI_Model
{


function import_ques($question){
 // echo "<pre>"; print_r($question);exit;
 
$questioncid=$this->input->post('cid');
$questiondid=$this->input->post('lid');
foreach($question as $key => $singlequestion){
	if($key != 0){

		$question= str_replace('"','&#34;',$singlequestion['question']);

		$question= str_replace("‘",'&#39;',$question);
		$question= str_replace("’",'&#39;',$question);
		$question= str_replace("â€œ",'&#34;',$question);
		$question= str_replace("â€˜",'&#39;',$question);



		$question= str_replace("â€™",'&#39;',$question);
		$question= str_replace("â€",'&#34;',$question);
		$question= str_replace("'","&#39;",$question);
		$question= str_replace("\n","<br>",$question);

		$description= str_replace('"','&#34;',$singlequestion['description']);
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
			$ques_type2="Multiple Choice Single Answer"; 
		 }
		 if($ques_type==1){
			$ques_type2="Multiple Choice Multiple Answer"; 
		 }
		 
		//$ques_type= $singlequestion['0'];
		$corect_position=array(
				'A' => '0',
				'B' => '1',
				'C' => '2',
				'D' => '3',
				'E' => '4'
				);
			$insert_data = array(
			'cid' => $questioncid,
			'lid' => $questiondid,
			'question' =>$question,
			'description' =>$description,
			'question_type' => $ques_type2 
			);
			
			if($this->db->insert('savsoft_qbank',$insert_data)){
				$qid=$this->db->insert_id();
				$optionkeycounter = 4;
				if($ques_type=="0" || $ques_type=="1"){
					$correct_op=array_filter(explode(',',$singlequestion['correct']));
					$correct_option_position=array();

					foreach($correct_op as $v){
					 
					$correct_option_position[]=$corect_position[trim($v)];
					 
					 
					}
			 
					foreach($singlequestion['option'] as $corect_key => $correct_val){
						$correct_val=array_filter(preg_split($_POST['option_file'],$correct_val));
						$description= str_replace('"','&#34;',$correct_val[1]);
						$description= str_replace("‘",'&#39;',$description);
						$description= str_replace("’",'&#39;',$description);
						$description= str_replace("â€œ",'&#34;',$description);
						$description= str_replace("â€˜",'&#39;',$description);
						$description= str_replace("â€™",'&#39;',$description);
						$description= str_replace("â€",'&#34;',$description);
						$description= str_replace("'","&#39;",$description);
						$description= str_replace("\n","<br>",$description);
						if(in_array($corect_key, $correct_option_position)){
							$divideratio=count($correct_option_position);
							$correctoption =1/$divideratio;
						}else{
							$correctoption = 0;
						}										
							$insert_options = array(
							"qid" =>$qid,
							"q_option" => $correct_val[0],
							"score" => $correctoption,
							"q_option_match" => $description
							);
							$this->db->insert("savsoft_options",$insert_options);
							
							
						
					}
				}
			
				
			
				
				}//
			}
	}

}



}
?>
