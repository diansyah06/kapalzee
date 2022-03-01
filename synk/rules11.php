 										
												<table width="100%" cellspacing="0" cellpadding="4" border="1" bordercolor="#CCCCCC" align="center">
                                <tr> 
								

					
								<?php 
				
								$ijo="Y";
								
								   	
	 ?>
                                  <td align="left" valign="middle" bgcolor="#FFFFCC">
		<ul id="browser" class="filetree">
			<li><span class="folder"><strong><a href="#" class="menunya">Part 0. General</a></strong></span>
						<?php
						$xml = simplexml_load_file("http://202.152.52.206:16700/rules_bki.xml")
	      			    or die("Error: Cannot create object"); ?>
		   				<ul>
					<?php  /*  */
					$ijo1=0;
					$ijo2=0; 
					$temp=array();
					$temp1=array();
					foreach ($xml->Part_0->data as $entry)
	   				    {
							 $vol=$entry['vol'];
							 $tipe=$entry['tipe'];
							 $idp=$entry['idp'];
							 $id=$entry['id'];
							 if ($ijo1!=0)
							    {
								   if (in_array($vol.$tipe.$idp.$id, $temp))
								      {
									      $temp1[$ijo2]=$vol.$tipe.$idp.$id;
										  $ijo2=$ijo2+1;
									  }
									  else
									  {  //gak ada di array
									      $temp[$ijo1]=$vol.$tipe.$idp.$id;
										  $ijo1=$ijo1+1;
									  }
								}
								else
							if ($ijo1==0)
							{
							 	
	   						 $temp[$ijo1]=$vol.$tipe.$idp.$id;
							 $ijo1=$ijo1+1;
							 }
							
						} //akhir for
				/*	*/	
					
					  array_unshift($temp1,""); //index ke awal / 0
					  unset($temp1[0]);
					  foreach ($xml->Part_0->data as $entry)
	   				       {
							 $vol=$entry['vol'];
							 $tipe=$entry['tipe'];
							 $idp=$entry['idp'];
							 $id=$entry['id'];
							 $jeni_u=$entry['jeni_u'];
							
										 
							 if($ijo=="Y")
								   { 
								     
										if (in_array($vol.$tipe.$idp.$id, $temp1))
								 			{
												if(($key = array_search($vol.$tipe.$idp.$id, $temp1)) != false) 
												   {
												      unset($temp1[$key]);
												   }
												  
											   echo "<li><span class=file>"; ?>
											   <a href="lain.php?menuku=lapan&idnya=88&rules=Y&vol=<?php echo $entry['vol']; ?>&tipe=<?php echo $entry['tipe']; ?>&idp=<?php echo $entry['idp']; ?>&id=<?php echo $entry['id']; ?>&thn=<?php echo $entry['tahun']; ?>&val=<?php echo $entry; ?>" ><?php echo substr($entry,0,strlen($entry)-4); ?></a>
											   <?php echo "</span><ul>";
												
												  
											}
											else
											{   echo "<li><span class=file>" ;
									
								   ?>
								      
						<a href="lain.php?menuku=lapan&idnya=88&rules=Y&vol=<?php echo $entry['vol']; ?>&tipe=<?php echo $entry['tipe']; ?>&idp=<?php echo $entry['idp']; ?>&id=<?php echo $entry['id']; ?>&thn=<?php echo $entry['tahun']; ?>&val=<?php echo $entry; ?>" ><?php echo substr($entry,0,strlen($entry)-4); ?></a>
								   <?php
								   
								         echo "</span></li>" ;
										 }
										 if ($jeni_u!='0')
										    echo "</ul>	</li>";
									  
									} // akhir ijo = Y
									else
									{
									      if (in_array($vol.$tipe.$idp.$id, $temp1))
								 			{
											    //echo "<li><span class=file></span><ul>";
  								   				
												if(($key = array_search($vol.$tipe.$idp.$id, $temp1)) != false) 
												   {
												      unset($temp1[$key]);
													}
												  echo "<li><span class=file>"; ?>
											   <a href="Login.php"><?php echo substr($entry,0,strlen($entry)-4); ?></a>
											   <?php echo "</span><ul>";
												
												  
											}
											else
											{   echo "<li><span class=file>" ;
									
								   ?>
								      
						<a href="Login.php"><?php echo substr($entry,0,strlen($entry)-4); ?></a>
								   <?php
								   
								         echo "</span></li>" ;
										 }
										 if ($jeni_u!='0')
										    echo "</ul>	</li>";
									
									} // akhir ijo else  
						//	if ($tutup)
						//	  echo "</ul></li>";
						} //akhir for
						?>
							   </ul>
							
						 </li>
									     					
				
		<li><span class="folder"><strong><a href="#" class="menunya">Part 1. Seagoing Ship</a></strong></span>
						
		   				<ul>
						
						
					<?php  /*  */
					$ijo1=0;
					$ijo2=0; 
					$temp=array();
					$temp1=array();
					foreach ($xml->Part_1->data as $entry)
	   				    {
							 $vol=$entry['vol'];
							 $tipe=$entry['tipe'];
							 $idp=$entry['idp'];
							 $id=$entry['id'];
							 if ($ijo1!=0)
							    {
								   if (in_array($vol.$tipe.$idp.$id, $temp))
								      {
									      $temp1[$ijo2]=$vol.$tipe.$idp.$id;
										  $ijo2=$ijo2+1;
									  }
									  else
									  {  //gak ada di array
									      $temp[$ijo1]=$vol.$tipe.$idp.$id;
										  $ijo1=$ijo1+1;
									  }
								}
								else
							if ($ijo1==0)
							{
							 	
	   						 $temp[$ijo1]=$vol.$tipe.$idp.$id;
							 $ijo1=$ijo1+1;
							 }
							
						} //akhir for
				/*	*/	
					
					  array_unshift($temp1,""); //index ke awal / 0
					  unset($temp1[0]);
					  foreach ($xml->Part_1->data as $entry)
	   				       {
							 $vol=$entry['vol'];
							 $tipe=$entry['tipe'];
							 $idp=$entry['idp'];
							 $id=$entry['id'];
							 $jeni_u=$entry['jeni_u'];
							
										 
							 if($ijo=="Y")
								   { 
								     
										if (in_array($vol.$tipe.$idp.$id, $temp1))
								 			{
												if(($key = array_search($vol.$tipe.$idp.$id, $temp1)) != false) 
												   {
												      unset($temp1[$key]);
												   }
												  
											   echo "<li><span class=file>"; ?>
											   <a href="lain.php?menuku=lapan&idnya=88&rules=Y&vol=<?php echo $entry['vol']; ?>&tipe=<?php echo $entry['tipe']; ?>&idp=<?php echo $entry['idp']; ?>&id=<?php echo $entry['id']; ?>&thn=<?php echo $entry['tahun']; ?>&val=<?php echo $entry; ?>" ><?php echo substr($entry,0,strlen($entry)-4); ?></a>
											   <?php echo "</span><ul>";
												
												  
											}
											else
											{   echo "<li><span class=file>" ;
									
								   ?>
								      
						<a href="lain.php?menuku=lapan&idnya=88&rules=Y&vol=<?php echo $entry['vol']; ?>&tipe=<?php echo $entry['tipe']; ?>&idp=<?php echo $entry['idp']; ?>&id=<?php echo $entry['id']; ?>&thn=<?php echo $entry['tahun']; ?>&val=<?php echo $entry; ?>" ><?php echo substr($entry,0,strlen($entry)-4); ?></a>
								   <?php
								   
								         echo "</span></li>" ;
										 }
										 if ($jeni_u!='0')
										    echo "</ul>	</li>";
									  
									} // akhir ijo = Y
									else
									{
									      if (in_array($vol.$tipe.$idp.$id, $temp1))
								 			{
											    //echo "<li><span class=file></span><ul>";
  								   				
												if(($key = array_search($vol.$tipe.$idp.$id, $temp1)) != false) 
												   {
												      unset($temp1[$key]);
													}
												  echo "<li><span class=file>"; ?>
											   <a href="Login.php"><?php echo substr($entry,0,strlen($entry)-4); ?></a>
											   <?php echo "</span><ul>";
												
												  
											}
											else
											{   echo "<li><span class=file>" ;
									
								   ?>
								      
						<a href="Login.php"><?php echo substr($entry,0,strlen($entry)-4); ?></a>
								   <?php
								   
								         echo "</span></li>" ;
										 }
										 if ($jeni_u!='0')
										    echo "</ul>	</li>";
									
									} // akhir ijo else  
						//	if ($tutup)
						//	  echo "</ul></li>";
						} //akhir for
						?>
							   </ul>
							
						 </li>
				
			<li><span class="folder"><strong><a href="Login.php" class="menunya">Part 2. Inland Waterway</a></strong></span>
						
		   				<ul>
						   
						<?php  /*  */
					$ijo1=0;
					$ijo2=0; 
					$temp=array();
					$temp1=array();
					foreach ($xml->Part_2->data as $entry)
	   				    {
							 $vol=$entry['vol'];
							 $tipe=$entry['tipe'];
							 $idp=$entry['idp'];
							 $id=$entry['id'];
							 if ($ijo1!=0)
							    {
								   if (in_array($vol.$tipe.$idp.$id, $temp))
								      {
									      $temp1[$ijo2]=$vol.$tipe.$idp.$id;
										  $ijo2=$ijo2+1;
									  }
									  else
									  {  //gak ada di array
									      $temp[$ijo1]=$vol.$tipe.$idp.$id;
										  $ijo1=$ijo1+1;
									  }
								}
								else
							if ($ijo1==0)
							{
							 	
	   						 $temp[$ijo1]=$vol.$tipe.$idp.$id;
							 $ijo1=$ijo1+1;
							 }
							
						} //akhir for
				/*	*/	
					
					  array_unshift($temp1,""); //index ke awal / 0
					  unset($temp1[0]);
					  foreach ($xml->Part_2->data as $entry)
	   				       {
							 $vol=$entry['vol'];
							 $tipe=$entry['tipe'];
							 $idp=$entry['idp'];
							 $id=$entry['id'];
							 $jeni_u=$entry['jeni_u'];
							
										 
							 if($ijo=="Y")
								   { 
								     
										if (in_array($vol.$tipe.$idp.$id, $temp1))
								 			{
												if(($key = array_search($vol.$tipe.$idp.$id, $temp1)) != false) 
												   {
												      unset($temp1[$key]);
												   }
												  
											   echo "<li><span class=file>"; ?>
											   <a href="lain.php?menuku=lapan&idnya=88&rules=Y&vol=<?php echo $entry['vol']; ?>&tipe=<?php echo $entry['tipe']; ?>&idp=<?php echo $entry['idp']; ?>&id=<?php echo $entry['id']; ?>&thn=<?php echo $entry['tahun']; ?>&val=<?php echo $entry; ?>" ><?php echo substr($entry,0,strlen($entry)-4); ?></a>
											   <?php echo "</span><ul>";
												
												  
											}
											else
											{   echo "<li><span class=file>" ;
									
								   ?>
								      
						<a href="lain.php?menuku=lapan&idnya=88&rules=Y&vol=<?php echo $entry['vol']; ?>&tipe=<?php echo $entry['tipe']; ?>&idp=<?php echo $entry['idp']; ?>&id=<?php echo $entry['id']; ?>&thn=<?php echo $entry['tahun']; ?>&val=<?php echo $entry; ?>" ><?php echo substr($entry,0,strlen($entry)-4); ?></a>
								   <?php
								   
								         echo "</span></li>" ;
										 }
										 if ($jeni_u!='0')
										    echo "</ul>	</li>";
									  
									} // akhir ijo = Y
									else
									{
									      if (in_array($vol.$tipe.$idp.$id, $temp1))
								 			{
											    //echo "<li><span class=file></span><ul>";
  								   				
												if(($key = array_search($vol.$tipe.$idp.$id, $temp1)) != false) 
												   {
												      unset($temp1[$key]);
													}
												  echo "<li><span class=file>"; ?>
											   <a href="Login.php"><?php echo substr($entry,0,strlen($entry)-4); ?></a>
											   <?php echo "</span><ul>";
												
												  
											}
											else
											{   echo "<li><span class=file>" ;
									
								   ?>
								      
						<a href="Login.php"><?php echo substr($entry,0,strlen($entry)-4); ?></a>
								   <?php
								   
								         echo "</span></li>" ;
										 }
										 if ($jeni_u!='0')
										    echo "</ul>	</li>";
									
									} // akhir ijo else  
						//	if ($tutup)
						//	  echo "</ul></li>";
						} //akhir for
						?>
							   </ul>
							
						 </li>	
				
				
			<li><span class="folder"><strong><a href="Login.php" class="menunya">Part 3. Special Ships</a></strong></span>
						
		   				<ul>
					<?php  /*  */
					$ijo1=0;
					$ijo2=0; 
					$temp=array();
					$temp1=array();
					foreach ($xml->Part_3->data as $entry)
	   				    {
							 $vol=$entry['vol'];
							 $tipe=$entry['tipe'];
							 $idp=$entry['idp'];
							 $id=$entry['id'];
							 if ($ijo1!=0)
							    {
								   if (in_array($vol.$tipe.$idp.$id, $temp))
								      {
									      $temp1[$ijo2]=$vol.$tipe.$idp.$id;
										  $ijo2=$ijo2+1;
									  }
									  else
									  {  //gak ada di array
									      $temp[$ijo1]=$vol.$tipe.$idp.$id;
										  $ijo1=$ijo1+1;
									  }
								}
								else
							if ($ijo1==0)
							{
							 	
	   						 $temp[$ijo1]=$vol.$tipe.$idp.$id;
							 $ijo1=$ijo1+1;
							 }
							
						} //akhir for
				/*	*/	
					
					  array_unshift($temp1,""); //index ke awal / 0
					  unset($temp1[0]);
					  foreach ($xml->Part_3->data as $entry)
	   				       {
							 $vol=$entry['vol'];
							 $tipe=$entry['tipe'];
							 $idp=$entry['idp'];
							 $id=$entry['id'];
							 $jeni_u=$entry['jeni_u'];
							
										 
							 if($ijo=="Y")
								   { 
								     
										if (in_array($vol.$tipe.$idp.$id, $temp1))
								 			{
												if(($key = array_search($vol.$tipe.$idp.$id, $temp1)) != false) 
												   {
												      unset($temp1[$key]);
												   }
												  
											   echo "<li><span class=file>"; ?>
											   <a href="lain.php?menuku=lapan&idnya=88&rules=Y&vol=<?php echo $entry['vol']; ?>&tipe=<?php echo $entry['tipe']; ?>&idp=<?php echo $entry['idp']; ?>&id=<?php echo $entry['id']; ?>&thn=<?php echo $entry['tahun']; ?>&val=<?php echo $entry; ?>" ><?php echo substr($entry,0,strlen($entry)-4); ?></a>
											   <?php echo "</span><ul>";
												
												  
											}
											else
											{   echo "<li><span class=file>" ;
									
								   ?>
								      
						<a href="lain.php?menuku=lapan&idnya=88&rules=Y&vol=<?php echo $entry['vol']; ?>&tipe=<?php echo $entry['tipe']; ?>&idp=<?php echo $entry['idp']; ?>&id=<?php echo $entry['id']; ?>&thn=<?php echo $entry['tahun']; ?>&val=<?php echo $entry; ?>" ><?php echo substr($entry,0,strlen($entry)-4); ?></a>
								   <?php
								   
								         echo "</span></li>" ;
										 }
										 if ($jeni_u!='0')
										    echo "</ul>	</li>";
									  
									} // akhir ijo = Y
									else
									{
									      if (in_array($vol.$tipe.$idp.$id, $temp1))
								 			{
											    //echo "<li><span class=file></span><ul>";
  								   				
												if(($key = array_search($vol.$tipe.$idp.$id, $temp1)) != false) 
												   {
												      unset($temp1[$key]);
													}
												  echo "<li><span class=file>"; ?>
											   <a href="Login.php"><?php echo substr($entry,0,strlen($entry)-4); ?></a>
											   <?php echo "</span><ul>";
												
												  
											}
											else
											{   echo "<li><span class=file>" ;
									
								   ?>
								      
						<a href="Login.php"><?php echo substr($entry,0,strlen($entry)-4); ?></a>
								   <?php
								   
								         echo "</span></li>" ;
										 }
										 if ($jeni_u!='0')
										    echo "</ul>	</li>";
									
									} // akhir ijo else  
						//	if ($tutup)
						//	  echo "</ul></li>";
						} //akhir for
						?>
							   </ul>
							
						 </li>		
				
				
			<li><span class="folder"><strong><a href="Login.php" class="menunya">Part 4. Special Equipment and Systems</a></strong></span>
						
		   				<ul>
					<?php  /*  */
					$ijo1=0;
					$ijo2=0; 
					$temp=array();
					$temp1=array();
					foreach ($xml->Part_4->data as $entry)
	   				    {
							 $vol=$entry['vol'];
							 $tipe=$entry['tipe'];
							 $idp=$entry['idp'];
							 $id=$entry['id'];
							 if ($ijo1!=0)
							    {
								   if (in_array($vol.$tipe.$idp.$id, $temp))
								      {
									      $temp1[$ijo2]=$vol.$tipe.$idp.$id;
										  $ijo2=$ijo2+1;
									  }
									  else
									  {  //gak ada di array
									      $temp[$ijo1]=$vol.$tipe.$idp.$id;
										  $ijo1=$ijo1+1;
									  }
								}
								else
							if ($ijo1==0)
							{
							 	
	   						 $temp[$ijo1]=$vol.$tipe.$idp.$id;
							 $ijo1=$ijo1+1;
							 }
							
						} //akhir for
				/*	*/	
					
					  array_unshift($temp1,""); //index ke awal / 0
					  unset($temp1[0]);
					  foreach ($xml->Part_4->data as $entry)
	   				       {
							 $vol=$entry['vol'];
							 $tipe=$entry['tipe'];
							 $idp=$entry['idp'];
							 $id=$entry['id'];
							 $jeni_u=$entry['jeni_u'];
							
										 
							 if($ijo=="Y")
								   { 
								     
										if (in_array($vol.$tipe.$idp.$id, $temp1))
								 			{
												if(($key = array_search($vol.$tipe.$idp.$id, $temp1)) != false) 
												   {
												      unset($temp1[$key]);
												   }
												  
											   echo "<li><span class=file>"; ?>
											   <a href="lain.php?menuku=lapan&idnya=88&rules=Y&vol=<?php echo $entry['vol']; ?>&tipe=<?php echo $entry['tipe']; ?>&idp=<?php echo $entry['idp']; ?>&id=<?php echo $entry['id']; ?>&thn=<?php echo $entry['tahun']; ?>&val=<?php echo $entry; ?>" ><?php echo substr($entry,0,strlen($entry)-4); ?></a>
											   <?php echo "</span><ul>";
												
												  
											}
											else
											{   echo "<li><span class=file>" ;
									
								   ?>
								      
						<a href="lain.php?menuku=lapan&idnya=88&rules=Y&vol=<?php echo $entry['vol']; ?>&tipe=<?php echo $entry['tipe']; ?>&idp=<?php echo $entry['idp']; ?>&id=<?php echo $entry['id']; ?>&thn=<?php echo $entry['tahun']; ?>&val=<?php echo $entry; ?>" ><?php echo substr($entry,0,strlen($entry)-4); ?></a>
								   <?php
								   
								         echo "</span></li>" ;
										 }
										 if ($jeni_u!='0')
										    echo "</ul>	</li>";
									  
									} // akhir ijo = Y
									else
									{
									      if (in_array($vol.$tipe.$idp.$id, $temp1))
								 			{
											    //echo "<li><span class=file></span><ul>";
  								   				
												if(($key = array_search($vol.$tipe.$idp.$id, $temp1)) != false) 
												   {
												      unset($temp1[$key]);
													}
												  echo "<li><span class=file>"; ?>
											   <a href="Login.php"><?php echo substr($entry,0,strlen($entry)-4); ?></a>
											   <?php echo "</span><ul>";
												
												  
											}
											else
											{   echo "<li><span class=file>" ;
									
								   ?>
								      
						<a href="Login.php"><?php echo substr($entry,0,strlen($entry)-4); ?></a>
								   <?php
								   
								         echo "</span></li>" ;
										 }
										 if ($jeni_u!='0')
										    echo "</ul>	</li>";
									
									} // akhir ijo else  
						//	if ($tutup)
						//	  echo "</ul></li>";
						} //akhir for
						?>
							   </ul>
							
						 </li>		
						 
						 
						 <li><span class="folder"><strong><a href="Login.php" class="menunya">Part 5. Offshore Technology</a></strong></span>
						
		   				<ul>
					<?php  /*  */
					$ijo1=0;
					$ijo2=0; 
					$temp=array();
					$temp1=array();
					foreach ($xml->Part_5->data as $entry)
	   				    {
							 $vol=$entry['vol'];
							 $tipe=$entry['tipe'];
							 $idp=$entry['idp'];
							 $id=$entry['id'];
							 if ($ijo1!=0)
							    {
								   if (in_array($vol.$tipe.$idp.$id, $temp))
								      {
									      $temp1[$ijo2]=$vol.$tipe.$idp.$id;
										  $ijo2=$ijo2+1;
									  }
									  else
									  {  //gak ada di array
									      $temp[$ijo1]=$vol.$tipe.$idp.$id;
										  $ijo1=$ijo1+1;
									  }
								}
								else
							if ($ijo1==0)
							{
							 	
	   						 $temp[$ijo1]=$vol.$tipe.$idp.$id;
							 $ijo1=$ijo1+1;
							 }
							
						} //akhir for
				/*	*/	
					
					  array_unshift($temp1,""); //index ke awal / 0
					  unset($temp1[0]);
					  foreach ($xml->Part_5->data as $entry)
	   				       {
							 $vol=$entry['vol'];
							 $tipe=$entry['tipe'];
							 $idp=$entry['idp'];
							 $id=$entry['id'];
							 $jeni_u=$entry['jeni_u'];
							
										 
							 if($ijo=="Y")
								   { 
								     
										if (in_array($vol.$tipe.$idp.$id, $temp1))
								 			{
												if(($key = array_search($vol.$tipe.$idp.$id, $temp1)) != false) 
												   {
												      unset($temp1[$key]);
												   }
												  
											   echo "<li><span class=file>"; ?>
											   <a href="lain.php?menuku=lapan&idnya=88&rules=Y&vol=<?php echo $entry['vol']; ?>&tipe=<?php echo $entry['tipe']; ?>&idp=<?php echo $entry['idp']; ?>&id=<?php echo $entry['id']; ?>&thn=<?php echo $entry['tahun']; ?>&val=<?php echo $entry; ?>" ><?php echo substr($entry,0,strlen($entry)-4); ?></a>
											   <?php echo "</span><ul>";
												
												  
											}
											else
											{   echo "<li><span class=file>" ;
									
								   ?>
								      
						<a href="lain.php?menuku=lapan&idnya=88&rules=Y&vol=<?php echo $entry['vol']; ?>&tipe=<?php echo $entry['tipe']; ?>&idp=<?php echo $entry['idp']; ?>&id=<?php echo $entry['id']; ?>&thn=<?php echo $entry['tahun']; ?>&val=<?php echo $entry; ?>" ><?php echo substr($entry,0,strlen($entry)-4); ?></a>
								   <?php
								   
								         echo "</span></li>" ;
										 }
										 if ($jeni_u!='0')
										    echo "</ul>	</li>";
									  
									} // akhir ijo = Y
									else
									{
									      if (in_array($vol.$tipe.$idp.$id, $temp1))
								 			{
											    //echo "<li><span class=file></span><ul>";
  								   				
												if(($key = array_search($vol.$tipe.$idp.$id, $temp1)) != false) 
												   {
												      unset($temp1[$key]);
													}
												  echo "<li><span class=file>"; ?>
											   <a href="Login.php"><?php echo substr($entry,0,strlen($entry)-4); ?></a>
											   <?php echo "</span><ul>";
												
												  
											}
											else
											{   echo "<li><span class=file>" ;
									
								   ?>
								      
						<a href="Login.php"><?php echo substr($entry,0,strlen($entry)-4); ?></a>
								   <?php
								   
								         echo "</span></li>" ;
										 }
										 if ($jeni_u!='0')
										    echo "</ul>	</li>";
									
									} // akhir ijo else  
						//	if ($tutup)
						//	  echo "</ul></li>";
						} //akhir for
						?>
							   </ul>
							
						 </li>		
						 
						 
						 
					 <li><span class="folder"><strong><a href="Login.php" class="menunya">Part 6. Statutory</a></strong></span>
						
		   				<ul>
					<?php  /*  */
					$ijo1=0;
					$ijo2=0; 
					$temp=array();
					$temp1=array();
					foreach ($xml->Part_6->data as $entry)
	   				    {
							 $vol=$entry['vol'];
							 $tipe=$entry['tipe'];
							 $idp=$entry['idp'];
							 $id=$entry['id'];
							 if ($ijo1!=0)
							    {
								   if (in_array($vol.$tipe.$idp.$id, $temp))
								      {
									      $temp1[$ijo2]=$vol.$tipe.$idp.$id;
										  $ijo2=$ijo2+1;
									  }
									  else
									  {  //gak ada di array
									      $temp[$ijo1]=$vol.$tipe.$idp.$id;
										  $ijo1=$ijo1+1;
									  }
								}
								else
							if ($ijo1==0)
							{
							 	
	   						 $temp[$ijo1]=$vol.$tipe.$idp.$id;
							 $ijo1=$ijo1+1;
							 }
							
						} //akhir for
				/*	*/	
					
					  array_unshift($temp1,""); //index ke awal / 0
					  unset($temp1[0]);
					  foreach ($xml->Part_6->data as $entry)
	   				       {
							 $vol=$entry['vol'];
							 $tipe=$entry['tipe'];
							 $idp=$entry['idp'];
							 $id=$entry['id'];
							 $jeni_u=$entry['jeni_u'];
							
										 
							 if($ijo=="Y")
								   { 
								     
										if (in_array($vol.$tipe.$idp.$id, $temp1))
								 			{
												if(($key = array_search($vol.$tipe.$idp.$id, $temp1)) != false) 
												   {
												      unset($temp1[$key]);
												   }
												  
											   echo "<li><span class=file>"; ?>
											   <a href="lain.php?menuku=lapan&idnya=88&rules=Y&vol=<?php echo $entry['vol']; ?>&tipe=<?php echo $entry['tipe']; ?>&idp=<?php echo $entry['idp']; ?>&id=<?php echo $entry['id']; ?>&thn=<?php echo $entry['tahun']; ?>&val=<?php echo $entry; ?>" ><?php echo substr($entry,0,strlen($entry)-4); ?></a>
											   <?php echo "</span><ul>";
												
												  
											}
											else
											{   echo "<li><span class=file>" ;
									
								   ?>
								      
						<a href="lain.php?menuku=lapan&idnya=88&rules=Y&vol=<?php echo $entry['vol']; ?>&tipe=<?php echo $entry['tipe']; ?>&idp=<?php echo $entry['idp']; ?>&id=<?php echo $entry['id']; ?>&thn=<?php echo $entry['tahun']; ?>&val=<?php echo $entry; ?>" ><?php echo substr($entry,0,strlen($entry)-4); ?></a>
								   <?php
								   
								         echo "</span></li>" ;
										 }
										 if ($jeni_u!='0')
										    echo "</ul>	</li>";
									  
									} // akhir ijo = Y
									else
									{
									      if (in_array($vol.$tipe.$idp.$id, $temp1))
								 			{
											    //echo "<li><span class=file></span><ul>";
  								   				
												if(($key = array_search($vol.$tipe.$idp.$id, $temp1)) != false) 
												   {
												      unset($temp1[$key]);
													}
												  echo "<li><span class=file>"; ?>
											   <a href="Login.php"><?php echo substr($entry,0,strlen($entry)-4); ?></a>
											   <?php echo "</span><ul>";
												
												  
											}
											else
											{   echo "<li><span class=file>" ;
									
								   ?>
								      
						<a href="Login.php"><?php echo substr($entry,0,strlen($entry)-4); ?></a>
								   <?php
								   
								         echo "</span></li>" ;
										 }
										 if ($jeni_u!='0')
										    echo "</ul>	</li>";
									
									} // akhir ijo else  
						//	if ($tutup)
						//	  echo "</ul></li>";
						} //akhir for
						?>
							   </ul>
							
						 </li>			 
					
						 
						 
						 
					 <li><span class="folder"><strong><a href="Login.php" class="menunya">Part 7. Class Notation</a></strong></span>
						
		   				<ul>
					<?php  /*  */
					$ijo1=0;
					$ijo2=0; 
					$temp=array();
					$temp1=array();
					foreach ($xml->Part_7->data as $entry)
	   				    {
							 $vol=$entry['vol'];
							 $tipe=$entry['tipe'];
							 $idp=$entry['idp'];
							 $id=$entry['id'];
							 if ($ijo1!=0)
							    {
								   if (in_array($vol.$tipe.$idp.$id, $temp))
								      {
									      $temp1[$ijo2]=$vol.$tipe.$idp.$id;
										  $ijo2=$ijo2+1;
									  }
									  else
									  {  //gak ada di array
									      $temp[$ijo1]=$vol.$tipe.$idp.$id;
										  $ijo1=$ijo1+1;
									  }
								}
								else
							if ($ijo1==0)
							{
							 	
	   						 $temp[$ijo1]=$vol.$tipe.$idp.$id;
							 $ijo1=$ijo1+1;
							 }
							
						} //akhir for
				/*	*/	
					
					  array_unshift($temp1,""); //index ke awal / 0
					  unset($temp1[0]);
					  foreach ($xml->Part_7->data as $entry)
	   				       {
							 $vol=$entry['vol'];
							 $tipe=$entry['tipe'];
							 $idp=$entry['idp'];
							 $id=$entry['id'];
							 $jeni_u=$entry['jeni_u'];
							
										 
							 if($ijo=="Y")
								   { 
								     
										if (in_array($vol.$tipe.$idp.$id, $temp1))
								 			{
												if(($key = array_search($vol.$tipe.$idp.$id, $temp1)) != false) 
												   {
												      unset($temp1[$key]);
												   }
												  
											   echo "<li><span class=file>"; ?>
											   <a href="lain.php?menuku=lapan&idnya=88&rules=Y&vol=<?php echo $entry['vol']; ?>&tipe=<?php echo $entry['tipe']; ?>&idp=<?php echo $entry['idp']; ?>&id=<?php echo $entry['id']; ?>&thn=<?php echo $entry['tahun']; ?>&val=<?php echo $entry; ?>" ><?php echo substr($entry,0,strlen($entry)-4); ?></a>
											   <?php echo "</span><ul>";
												
												  
											}
											else
											{   echo "<li><span class=file>" ;
									
								   ?>
								      
						<a href="lain.php?menuku=lapan&idnya=88&rules=Y&vol=<?php echo $entry['vol']; ?>&tipe=<?php echo $entry['tipe']; ?>&idp=<?php echo $entry['idp']; ?>&id=<?php echo $entry['id']; ?>&thn=<?php echo $entry['tahun']; ?>&val=<?php echo $entry; ?>" ><?php echo substr($entry,0,strlen($entry)-4); ?></a>
								   <?php
								   
								         echo "</span></li>" ;
										 }
										 if ($jeni_u!='0')
										    echo "</ul>	</li>";
									  
									} // akhir ijo = Y
									else
									{
									      if (in_array($vol.$tipe.$idp.$id, $temp1))
								 			{
											    //echo "<li><span class=file></span><ul>";
  								   				
												if(($key = array_search($vol.$tipe.$idp.$id, $temp1)) != false) 
												   {
												      unset($temp1[$key]);
													}
												  echo "<li><span class=file>"; ?>
											   <a href="Login.php"><?php echo substr($entry,0,strlen($entry)-4); ?></a>
											   <?php echo "</span><ul>";
												
												  
											}
											else
											{   echo "<li><span class=file>" ;
									
								   ?>
								      
						<a href="Login.php"><?php echo substr($entry,0,strlen($entry)-4); ?></a>
								   <?php
								   
								         echo "</span></li>" ;
										 }
										 if ($jeni_u!='0')
										    echo "</ul>	</li>";
									
									} // akhir ijo else  
						//	if ($tutup)
						//	  echo "</ul></li>";
						} //akhir for
						?>
							   </ul>
							
						 </li>			 
						 
						 
						 
						 	
				
			</ul>
								  
								  </td>
								  
                                  </tr>
                            	<?php 
													if((empty($_SESSION[userid]))and(empty($_SESSION[password])))
													{ ?>
													<tr> 
                            <td>
                              <b><font face="Verdana, Arial, Helvetica, sans-serif" size="2">
							  <a href="Login.php">
															Login for Download</a></font></b><br>
														</td>
                          </tr>
													<?php } ?>
                              </table>
   
<?php unset ($temp1);
unset ($temp); ?> 