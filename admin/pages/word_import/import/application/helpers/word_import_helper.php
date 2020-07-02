<?php


function xml_attribute($object, $attribute)
{
    if(isset($object[$attribute]))
        return (string) $object[$attribute];
}
if ( ! function_exists('word_file_import')){
    function word_file_import($Filepath){
		$target_dir = "upload/";
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
			$new_path=$target_dir."../../../../../files/".$imagenew_name;
			rename($old_path,$new_path);
			$img=$imagenew_name;
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
		$question_data=array();
		$option=array();
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

