<?php
 include ( 'config.php' );
 include ( 'banner.php' );
 include ( 'html.php'   );
 include ( 'atomic.php' );
 $showing=intval($_GET['id']);
 $i=0;
 $mudlist=explode( "\n", file_get_contents( GRAVEYARD ));
 foreach ( $mudlist as $mud ) if ( $i++ == $showing ) {
  $mud=explode("|",$mud); $mud[0]="The tomb of " . $mud[0] . ' ... Died: ' . date("r",$mud[4]); $mud[4]='';
  echo html( "html/pagestart.html", array("###"), array("css/mud.css") );
  echo html( "html/mud.html", array ( "#name#", "#host#", "#port#", "#site#", "#flash#" ), $mud );
  $res="";
  if ( PRE_CACHE && file_exists("cache/" . $mud[1] . '.' . $mud[2]) ) $res = file_get_contents( "cache/" . $mud[1] . '.' . $mud[2], $res );
  if ( STRIP_ANSI ) {
  }
  else if ( USE_ANSILOVE ) {
   switch ( intval(date("N")) ) {
    case 4: case 0: $font="amiga"; break;
    case 5: case 1: $font="russian"; break;
    case 6: case 2: $font="80x50"; break;
    case 7: case 3: $font="80x25"; break;
      default: $font="russian"; break;
   }
   echo '<img src="'.ansi_love_path.'load_ansi.php?input='.$mud[1].'.'.$mud[2].'&font=' . $font . '&icecolors=1">';
  }
  else {
   echo '<table style=ansi text-align=left><tr><td><pre>' . str_replace( "\r", "", str_replace( "\n", "<br>",  $res )) . '</pre></td></tr></table>';
  }
 
  echo html( "html/pageend.html" );
  die();
 }
?>
