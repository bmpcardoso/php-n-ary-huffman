<?php   
   
   require "nary_huffman.php";
   
   use bmpcardoso\coding\huffman\NAryHuffman;
   
   $string = "ABBCCCDDDDEEEEEFFFFFF";   
   
   $coding_symbols = ["X", "Y", "Z"];
   $tree = NAryHuffman::get_huffman_tree( $string, count( $coding_symbols ) );
   $encoding = NAryHuffman::get_coding_tables( $tree, $coding_symbols );
   var_dump( $encoding );
   
   $coding_symbols = ["0", "1"];
   $tree = NAryHuffman::get_huffman_tree( $string, count( $coding_symbols ) );
   $encoding = NAryHuffman::get_coding_tables( $tree, $coding_symbols );
   var_dump( $encoding );
   
?>