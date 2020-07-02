<?php    
    function insert($koneksi, $table,$data=null) {
        $command = 'INSERT INTO '.$table;
        $field = $value = null;
        foreach($data as $f => $v) {
            $field	.= ','.$f;
            $value	.= ", '".$v."'";
        }
        $command .=' ('.substr($field,1).')';
        $command .=' VALUES('.substr($value,1).')';
        $exec = mysqli_query($koneksi, $command);
        ($exec) ? $status = 'OK' : $status = 'NO';
        return $status;
    }
    
    function update($koneksi, $table,$data=null,$where=null) {
        $command = 'UPDATE '.$table.' SET ';
        $field = $value = null;
        foreach($data as $f => $v) {
            $field	.= ",".$f."='".$v."'";
        }
        $command .= substr($field,1);
		if($where!=null) {
			foreach($where as $f => $v) {
				$value .= "#".$f."='".$v."'";
			}
			$command .= ' WHERE '.substr($value,1);
			$command = str_replace('#',' AND ',$command);
		}
        $exec = mysqli_query($koneksi, $command);
        ($exec) ? $status = 'OK' : $status = 'NO';
        return $status;
    }
    
    function delete($koneksi, $table,$where=null) {
        $command = 'DELETE FROM '.$table;
		if($where!=null) {
			$value = null;
			foreach($where as $f => $v) {
				$value .= "#".$f."='".$v."'";
			}
			$command .= ' WHERE '.substr($value,1);
			$command = str_replace('#',' AND ',$command);
		}
        $exec = mysqli_query($koneksi, $command);
        ($exec) ? $status = 'OK' : $status = 'NO';
        return $status;
    }
    
    function fetch($koneksi, $table,$where=null) {
        $command = 'SELECT * FROM '.$table;
		if($where!=null) {
			$value = null;
			foreach($where as $f => $v) {
				$value .= "#".$f."='".$v."'";
			}
			$command .= ' WHERE '.substr($value,1);
			$command = str_replace('#',' AND ',$command);
        }
        $sql = mysqli_query($koneksi, $command);
        $exec = mysqli_fetch_assoc($sql);
        return $exec;
    }
    
    function select($koneksi, $table,$where=null,$order=null,$limit=null) {
        $command = 'SELECT * FROM '.$table;
        if($where!=null) {
            $value = null;
            foreach($where as $f => $v) {
                $value .= "#".$f."='".$v."'";
            }
            $command .= ' WHERE '.substr($value,1);
            $command = str_replace('#',' AND ',$command);
        }
        ($order!=null) ? $command .= ' ORDER BY '.$order :null;
        ($limit!=null) ? $command .= ' LIMIT '.$limit :null;
        $result = array();
        $sql = mysqli_query($koneksi, $command);
        while($field = mysqli_fetch_assoc($sql)) {
            $result[] = $field;
        }
        return $result;
    }
    
    function rowcount($koneksi, $table,$where=null) {
        $command = 'SELECT * FROM '.$table;
		if($where!=null) {
			$value = null;
			foreach($where as $f => $v) {
				$value .= "#".$f."='".$v."'";
			}
			$command .= ' WHERE '.substr($value,1);
			$command = str_replace('#',' AND ',$command);
		}
        $exec = mysqli_num_rows(mysqli_query($koneksi, $command));
        return $exec;
    }
    
    function truncate($koneksi, $table) {
        $command = 'TRUNCATE '.$table;
        $exec = mysqli_query($koneksi, $command);
        ($exec) ? $status = 'OK' : $status = 'NO';
        return $status;
    }