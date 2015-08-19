<?php

1. array_keys($array)  //takes array keys; array(a=>2,b=>3) to array(0=>a,1=>b);
2. array_values($array)  //takes array values; array(a=>2,b=>3) to array(0=>2,1=>3);
3. array_pop($array)  //remove last value from array; array(a=>2,b=>3,c=>4) to array(a=>2,b=>3);
4. array_push($array,4)  //add an element last value from array; array(a=>2,b=>3,c=>4) to array(a=>2,b=>3,0=>4);
5. array_shift($array)  //remove first element from array; array(a=>2,b=>3,0=>4) to array(b=>3,0=>4);
6. array_unshift($array,5)  //add an element first into array; array(a=>2,b=>3,0=>4) to array(1=>5,b=>3,0=>4);
7. array_flip($array)  //swapping array value to key into array; array(a=>2,b=>3,0=>4) to array(2=>a,3=>b,4=>0);
8. array_reverse($array)  //reverse array element; array(a=>2,b=>3,0=>4,d=>2) to array(d=>2,0=>4,b=>3,a=>2);
9. array_search(4,$array)  //check an element is prsent to array; array(a=>2,b=>3,0=>4,d=>2) to present;
10. array_unique($array)  // keeps unique values to array; array(a=>2,b=>3,0=>4,d=>2,e=>4) to array(a=>2,b=>3,0=>4);
11. str_word_count("How many words do I have?")  //Outputs: 5
12. levenshtein($str1, $str2); // Determine how different two words are;$str1 = "carrot"; $str2 = "carrrott";// Outputs:2;
13. get_defined_vars() // Shows list of all defined variables used in the system.
14. escapeshellcmd() // escape shell command like exec() or system();
15. checkdate() // check a date is valid or invalid.
