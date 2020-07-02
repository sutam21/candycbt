<?php

 echo "
											<div class='box box-danger'>
												<div class='box-header with-border'>
													<h3 class='box-title'>Backup Data</h3>
													
												</div><!-- /.box-header -->
												<div class='box-body'>
													<p>Klik Tombol dibawah ini untuk membackup database </p>
													<form action='' method='post'>
														<button  name='backup' class='btn btn-lg btn-success'><i class='fa fa-database'></i> Backup Data</button>
													</form>
                                                    
												</div><!-- /.box-body -->
											</div><!-- /.box -->";
                //Download file backup ============================================
                if(isset($_GET['nama_file']))
                {
                    $file = $back_dir.$_GET['nama_file'];
 
                    if (file_exists($file))
                    {
                        header('Content-Description: File Transfer');
                        header('Content-Type: application/octet-stream');
                        header('Content-Disposition: attachment; filename='.basename($file));
                        header('Content-Transfer-Encoding: binary');
                        header('Expires: 0');
                        header('Cache-Control: private');
                        header('Pragma: private');
                        header('Content-Length: ' . filesize($file));
                        ob_clean();
                        flush();
                        readfile($file);
                        exit;
 
                    }
                    else
                    {
                        echo "file {$_GET['nama_file']} sudah tidak ada.";
                    }
 
                }
 
                //Backup database =================================================
                if(isset($_POST['backup']))
                {
                    backup($file);
 
					echo 'Backup database telah selesai <a style="cursor:pointer" href="'.$file.'" title="Download">Download file database</a>';
 
                    echo "<pre>";
                    print_r($return);
                    echo "</pre>";
                }
                else
                {
                    unset($_POST['backup']);
                }
 
                //Restore database ================================================
                if(isset($_POST['restore']))
                {
                    restore($_FILES['datafile']);
 
                    echo "<pre>";
                    print_r($lines);
                    echo "</pre>";
                }
                else
                {
                    unset($_POST['restore']);
                }
 
                ?>
 
 
            <?php
 
            
            ?>