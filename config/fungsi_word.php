<?php
function xml_attribute($object, $attribute)
{
		if(isset($object[$attribute]))
        return (string) $object[$attribute];
}
function word_file_import($Filepath){
		   
	$target_dir = "../word/";
	$target_file = $Filepath;      
	$info = pathinfo($target_file);
	$new_name=$info['filename'] . '.Zip'; 
	$new_name_path=$target_dir . $new_name;
	rename($target_file,$new_name_path);
	$zip = new ZipArchive;
	if ($zip->open($new_name_path) === TRUE) {
		  $zip->extractTo($target_dir);
		  $zip->close();
		 
		$word_xml=$target_dir."word/document.xml";
		$word_xml_relational=$target_dir."word/_rels/document.xml.rels";
		$content=file_get_contents($word_xml);
		$content = htmlentities(strip_tags($content,"<a:blip>"));
		$xml=simplexml_load_file($word_xml_relational);

		$supported_image = array(
			'gif',
			'jpg',
			'jpeg',
			'png'
		);

		$relation_image=array();
		foreach($xml as $key => $qjd){
		 $ext = strtolower(pathinfo($qjd['Target'], PATHINFO_EXTENSION));
			if (in_array($ext, $supported_image)) {
				$id=xml_attribute($qjd, 'Id');
				$target=xml_attribute($qjd, 'Target');
				$relation_image[$id]=$target;  
			} 
		}

		$word_folder=$target_dir."word";
		$prop_folder=$target_dir."docProps";
		$relat_folder=$target_dir."_rels";
		$content_folder=$target_dir."[Content_Types].xml";

		$rand_inc_number=1;
		foreach($relation_image as $key => $value){
			$rplc_str='&lt;a:blip r:embed=&quot;'.$key.'&quot; cstate=&quot;print&quot;/&gt;';
			$rplc_str2='&lt;a:blip r:embed=&quot;'.$key.'&quot;&gt;&lt;/a:blip&gt;';
			$rplc_str3='&lt;a:blip r:embed=&quot;'.$key.'&quot;/&gt;';
			 $ext_img = strtolower(pathinfo($value, PATHINFO_EXTENSION));
			$imagenew_name=time().$rand_inc_number.".".$ext_img;
			$old_path=$word_folder."/".$value;
			$new_path=$target_dir."../files".$imagenew_name;

			rename($old_path,$new_path);
			$img="<img src='../files/".$imagenew_name."'>";
			echo $rplc_str2."--".htmlentities($img);
			$content=str_replace($rplc_str,$img,$content);
			$content=str_replace($rplc_str2,$img,$content);
			$content=str_replace($rplc_str3,$img,$content);
			$rand_inc_number++;
		}

		rrmdir($word_folder);
		rrmdir($relat_folder);
		rrmdir($prop_folder);
		rrmdir($content_folder);
		rrmdir($new_name_path);
		$question_data=array();$option=array();
		$single_question="";
		$singlequestion_array=array();
		$expl=array_filter(preg_split($_POST['question_split'],$content));

		foreach($expl as $ekey =>  $value){
			 
		$quesions[]=array_filter(preg_split($_POST['option_split'],$value));

			foreach($quesions as $key => $options){
			$option_count=count($options);
			$question="";
			$option=array();

				foreach($options as $key_option => $val_option){
					if($option_count > 1){
						if($key_option == 0){
						$question=$val_option;
						}else{
							if($key_option == ($option_count-1)){
								if (preg_match($_POST['correct_split'], $val_option, $match)) {
									 
									 $correct=array_filter(preg_split($_POST['correct_split'],$val_option));
								$option[]=$correct['0'];

								$singlequestion_array[$key]['correct']=$correct['1'];

								 }else{
								$option[]=$val_option;
								$singlequestion_array[$key]['correct']="";
								}

							}else{
							$option[]=$val_option;
							}
						}

					}else if($option_count == "1"){
						if (preg_match($_POST['correct_split'], $val_option, $match)) {
						$correct=array_filter(preg_split($_POST['correct_split'],$val_option));

						$question=$correct['0'];
						$singlequestion_array[$key]['correct']=$correct['1'];

						}else{
						$question=$val_option;
						$singlequestion_array[$key]['correct']="";
						}
					}

				}
				 
				$question=array_filter(preg_split($_POST['description_split'],$question));
				$singlequestion_array[$key]['question']=$question[0];
				$singlequestion_array[$key]['description']=$question[1];
				$singlequestion_array[$key]['option']=$option;
				 
			}

		} 
		  
		return $singlequestion_array;
	} else {
	  return 'failed';
	}

} 
 function rrmdir($dir) { 
   if (is_dir($dir)) { 
     $objects = scandir($dir); 
     foreach ($objects as $object) { 
       if ($object != "." && $object != "..") { 
         if (filetype($dir."/".$object) == "dir") rrmdir($dir."/".$object); else unlink($dir."/".$object); 
       } 
     } 
		reset($objects); 
		if($dir!="uploads"){
			 rmdir($dir);
		} 
    }else{

	unlink($dir); 
	}
}
function import_ques($question){

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
								$this->db->insert("q_options",$insert_options);			
						}	
					}
				}
			}
		}

}
?>		