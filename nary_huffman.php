<?php
   namespace bmpcardoso\coding\huffman;
   
   use SplMinHeap;
   
   // ==============================================================================================================================
   class PriorityQueue extends SplMinHeap {
      public function compare( $node1, $node2 ) {
         if ($node1->weight === $node2->weight) return 0;         
         return ($node1->weight < $node2->weight) ? 1 : -1;
      }
   }
   
   // ==============================================================================================================================
   class Node {
      public $symbol;      
      public $weight;
      public $children;      
   
      function __construct( $symbol, $weight, $children=[] ) {         
         $this->symbol = $symbol;
         $this->weight = $weight;
         $this->children = $children;         
      }
   }
   
   // ==============================================================================================================================
   class NAryHuffman {
      
      // Public methods ------------------------------------------------------------------------------------------------------------
      public static function get_huffman_tree( $message, $target_alphabet_size ) {
         $symbol_frequency = self::char_frequency( $message );
         $priority_queue = new PriorityQueue();
         foreach( $symbol_frequency as $symbol => $frequency )
            $priority_queue->insert( new Node( $symbol, $frequency ) );
         return self::create_tree( $priority_queue, $target_alphabet_size );         
      }
      
      public static function get_coding_tables( $root, $alphabet ) {
         $tables = (object) [ "encoding" => null, "decoding" => null ];
         self::extract_codes( $root, "", $tables, $alphabet );
         return $tables;
      }
      
      // Private stuff -------------------------------------------------------------------------------------------------------------
      private static function char_frequency( $message ) {
         $symbol_frequency = [];
         for( $i = 0 ; $i < strlen( $message ) ; $i++ ) {
            $symbol = $message[ $i ];
            if( !array_key_exists( $symbol, $symbol_frequency ) )
               $symbol_frequency[ $symbol ] = 0;
            $symbol_frequency[ $symbol ]++;
         }
         return $symbol_frequency;
      }
      
      private static function create_tree( $queue, $target_alphabet_size ) {
         // all we need is the amount of symbols in the target alphabet
         if( is_array( $target_alphabet_size ) )
            $target_alphabet_size = count( $target_alphabet_size );         
         // grow the tree using based on the nodes in the priority queue 
         $node_children_count = ( count( $queue )-2 ) % ( $target_alphabet_size-1 ) + 2;
         self::grow_tree( $queue, $node_children_count );
         while( count( $queue ) > 1 )
            self::grow_tree( $queue, $target_alphabet_size );         
         // this last node will be the encoding tree root
         return $queue->extract();
      }
      
      private static function grow_tree( $queue, $node_children_count ) {         
         $node_children_weight = 0;
         $node_children = [];
         while( $node_children_count-- > 0 ) {            
            $child = $queue->extract();            
            $node_children[] = $child;
            $node_children_weight += $child->weight;
         }
         $node = new Node( null, $node_children_weight, $node_children );
         $queue->insert( $node ); 
      }
      
      private static function extract_codes( $node, $code, &$codes, $alphabet ) {
         if( $node->symbol != null ) {
            $codes->encoding[ $node->symbol ] = $code;
            $codes->decoding[ $code ] = $node->symbol;
         }
         else
            foreach( $node->children as $index => $child )
               self::extract_codes( $child, $code . $alphabet[ $index ], $codes, $alphabet );
      }
      
   }

?>