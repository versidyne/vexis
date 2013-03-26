<?php

	// convert a decimal number into a string using $base 
	public function dec2string ($decimal, $base) { 
		//DebugBreak(); 
	   global $error; 
	   $string = null; 

	   $base = (int)$base; 
	   if ($base < 2 | $base > 36 | $base == 10) { 
		  echo 'BASE must be in the range 2-9 or 11-36'; 
		  exit; 
	   } // if 

	   // maximum character string is 36 characters 
	   $charset = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'; 

	   // strip off excess characters (anything beyond $base) 
	   $charset = substr($charset, 0, $base); 

	   if (!ereg('(^[0-9]{1,50}$)', trim($decimal))) { 
		  $error['dec_input'] = 'Value must be a positive integer with < 50 digits'; 
		  return false; 
	   } // if 

	   do { 
		  // get remainder after dividing by BASE 
		  $remainder = bcmod($decimal, $base); 

		  $char      = substr($charset, $remainder, 1);   // get CHAR from array 
		  $string    = "$char$string";                    // prepend to output 

		  //$decimal   = ($decimal - $remainder) / $base; 
		  $decimal   = bcdiv(bcsub($decimal, $remainder), $base); 

	   } while ($decimal > 0); 

	   return $string; 

	}
	
	// convert a string into a decimal number using $base 
	public function string2dec ($string, $base) { 

	   global $error; 
	   $decimal = 0; 

	   $base = (int)$base; 
	   if ($base < 2 | $base > 36 | $base == 10) { 
		  echo 'BASE must be in the range 2-9 or 11-36'; 
		  exit; 
	   } // if 

	   // maximum character string is 36 characters 
	   $charset = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'; 

	   // strip off excess characters (anything beyond $base) 
	   $charset = substr($charset, 0, $base); 

	   $string = trim($string); 
	   if (empty($string)) { 
		  $error[] = 'Input string is empty'; 
		  return false; 
	   } // if 

	   do { 
		  $char   = substr($string, 0, 1);    // extract leading character 
		  $string = substr($string, 1);       // drop leading character 

		  $pos = strpos($charset, $char);     // get offset in $charset 
		  if ($pos === false) { 
			 $error[] = "Illegal character ($char) in INPUT string"; 
			 return false; 
		  } // if 

		  //$decimal = ($decimal * $base) + $pos; 
		  $decimal = bcadd(bcmul($decimal, $base), $pos); 

	   } while($string <> null); 

	   return $decimal; 

	}

?>
