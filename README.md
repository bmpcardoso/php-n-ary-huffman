# php-n-ary-huffman
A PHP implementation of the n-ary Huffman coding.

## What is it?
Huffman coding was proposed in a paper by David A. Huffman, "A Method for the Construction of Minimum-Redundancy Codes", back in 1952 (link [here](https://ieeexplore.ieee.org/document/4051119)). It is an algorithm for lossless data compression based on prefix codes (i.e., the code used to represent a symbol is never a prefix in any of the codes representing any other symbol). You can find more information in the Wikipedia [page](https://en.wikipedia.org/wiki/Huffman_coding).

While the most common form of Huffman encoding is binary - a way to compress information from a given alphabet (arbitrary collection of symbols) into an optimal binary (0/1) representation -, this is an implementation of its n-ary variant, compressing information from a given alphabet into an optimal, n-ary representation composed of n symbols.

## Algorithm
This algorithm is an adaptation of Tewi's D-ary Huffman Coding ([here](https://github.com/Tewi/PrefixFreeCodes/wiki/D%E2%80%90ary-Huffman-Coding)) - kudos, Tewi! It goes like this:

For an input message `MSG` and an output alphabet of `N` symbols: 

1. Get the frequency of all symbols in `MSG`
2. Instantiate a min-heap (or some other type of priority queue - all we need is a way to easily get the symbols with the least weight first)
2. Create a node for each **unique** symbol in `MSG` as `(symbol=the symbol in MSG, children=empty, weight=symbol frequency)` and add them to the min-heap
3. Extract `(N-2)%(D-1)+2` nodes from the mean-heap
4. Create a new node as `(symbol=don't care, children=the extracted nodes, weight=sum of children's weight)`
5. Add the new node to the min-heap
6. While there is more than one node in the min-heap:
   1. Extract `N` nodes from the heap
   2. Create a new node as `(symbol=don't care, children=the extracted nodes, weight=sum of children's weight)`
   3. Add the new node to the min-heap
7. Done! The remaining node in the min-heap is the root of the Huffman coding tree.

# How to use
Easy, just add this to your script files:

```php
require "nary_huffman.php";   
use bmpcardoso\coding\huffman\NAryHuffman;
```

There's just two static methods in this implementation:
```php
// @param $string the message you want to compress
// @param $target_alphabet_size the number of symbols in the target alphabet (binary would be 2)
// @returns the Huffman coding tree
NAryHuffman::get_huffman_tree( $string, $target_alphabet_size )
```
and 
```php
// @param $tree the Huffman encoding tree
// @param $target_alphabet an array containing the symbols of the target alphabet (binary would be [0,1])
// @returns an object with two properties: 
//   "encoding" - an associative array from symbols in the original alphabet to the code written in the target alphabet, and
//   "decoding" - vice-versa
NAryHuffman::get_coding_tables( $tree, $target_alphabet )
```
Still have questions? Just have a look at the `test.php` file!

