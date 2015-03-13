<?php
 include_once 'config.php';
 include_once 'atomic.php';
 include_once 'banner.php';
 include_once 'html.php';
 if ( USE_ANSILOVE ) include ansi_love_path . 'ansilove.php';
 $muds=explode("\n",file_get_contents( "lists/big.txt" ));
 $digest="";
 foreach ($muds as $m) {
  if ( trim(strlen($m)) < 1 ) continue;
  $m=explode("|",$m);
  if ( !file_exists( "cache/".$m[1].'.'.$m[2] ) ) file_put_contents( "cache/".$m[1].'.'.$m[2], mud_validate($m[1],$m[2]) );
  $s=@stat("cache/".$m[1].'.'.$m[2]);
  $d="\n <small>Added: " . date("r",$s[9]) . "</small> |" . (intval($m[4])==0 ? "<i>Verified last night</i>" : "Last connected: " . date("r",intval($m[4]))) . "\n" ;
  if ( USE_ANSILOVE && ANSI_DIGEST )
   $digest.="\n\nName: <h1>$m[0]</h1>\n".$d."telnet://$m[1]:$m[2]\n$m[3]\n\n" . @file_get_contents( "cache/".$m[1].'.'.$m[2] );
  else if ( USE_ANSILOVE )
   $digest.="\n\nName: <h1>$m[0]</h1>\n".$d."telnet://$m[1]:$m[2]\n$m[3]\n\n<img src=\"".ansi_love_path."load_ansi.php?input=".$m[1].'.'.$m[2]."&font=80x50\">";
  else if ( STRIP_ANSI )
   $digest.="\n\nName: <h1>$m[0]</h1>\n".$d."telnet://$m[1]:$m[2]\n$m[3]\n\n" . @file_get_contents( "cache/".$m[1].'.'.$m[2] );
  else
   $digest.="\n\nName: <h1>$m[0]</h1>\n".$d."telnet://$m[1]:$m[2]\n$m[3]\n\n" . $file_get_contents( "cache/".$m[1].'.'.$m[2] );
 }
 echo html( "html/pagestart.html", array( "digest<", "###" ), array( "<", "css/mud.css" ) );
 if ( USE_ANSILOVE && ANSI_DIGEST ) { // requires a ton of memory
  file_put_contents_atomic( "cache/digest.txt", $digest );
  load_ansi( "cache/digest.txt", "cache/digest.png", "80x50", 8, 1 );
  echo '<img src="cache/digest.png"><br>';
 } else {
  
  echo str_replace( array( "Name:", "\n" ), array( "", "<br>" ), $digest );
 }
 echo html( "html/pageend.html" );
?>
