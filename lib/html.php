<?php
/*
  This file is a part of Phun Project
  The MIT License (MIT)
  Copyright (c) 2015 Pierre Ruyter and Xavier Van de Woestyne
  Permission is hereby granted, free of charge, to any person obtaining a copy
  of this software and associated documentation files (the "Software"), to deal
  in the Software without restriction, including without limitation the rights
  to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
  copies of the Software, and to permit persons to whom the Software is
  furnished to do so, subject to the following conditions:
  The above copyright notice and this permission notice shall be included in all
  copies or substantial portions of the Software.
  THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
  IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
  FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
  AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
  LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
  OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
  SOFTWARE.
*/

declare(strict_types=1);



/**
 * Provide HTML's node representation
 * @author Van de Woestyne Xavier <xaviervdw@gmail.com>
 */
namespace phun\dom;

/**
 * Create a PCData node
 * @param string data; the raw text
 * @return a PCDATA node
 */
function pcdata(string $data) {
    return new PCDATA($data);
}

/**
 * Create a Leaf (hr, br) node
 * @param string the name of the tag ('hr', 'br') for example
 * @return a Leaf Node
 */
function leaf(string $name) {
    return new Leaf($name);
}

/**
 * Create an Inline  (span for example) node
 * @param string the name of the tag, 'span' for example
 * @return an Inlined Node
 */
function inline(string $name) {
    return new InlineNode($name);
}

/**
 * Create a Block  (div for example) node
 * @param string the name of the tag, 'div' for example
 * @return a Block Node
 */
function block(string $name) {
    return new block($name);
}

/**
 * Create an Header Element
 * @return Header object
 */
function head() {
    return new Header();
}

?>