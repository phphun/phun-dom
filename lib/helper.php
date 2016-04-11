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
 * Helper for dom construction
 * @author Van de Woestyne Xavier <xaviervdw@gmail.com>
 */
namespace phun\HTML {

    use \phun\dom as D;

    /**
     * Create a PCData node
     * @param string data; the raw text
     * @return a PCDATA node
     */
    function pcdata(string $data) {
        return new D\PCDATA($data);
    }

    /**
     * Create an image (with his attributes)
     * @param $src String the url of the resource
     * @param $alt String the "alt" of the image
     * @return InlineNode
     */
    function img(string $src, string $alt = 'An image') : D\InlineNode {
        return D\img()
            ->where('src', $src)
            ->where('alt', $alt);
    }

    function to_li(D\Node $elt) {
        if($elt instanceof D\ListElt) return $elt;
        return D\li()
            ->append($elt);
    }

    /**
     * Create an Ul element
     * @param Node $n list of Node
     */
     function ul(D\Node...$n) : D\Enum {
        $nodes = array_map(function($e) { return to_li($e); }, $n);
        return D\ul()->append(...$nodes);
    }

    /**
     * Create an Ol element
     * @param Node $n list of Node
     */
    function ol(D\Node...$n) : D\Enum {
        $nodes = array_map(function($e) { return to_li($e); }, $n);
        return D\ol()->append(...$nodes);
    }

    /**
     * Create a Li element
     * @param Block $n list of Block
     */
    function li(D\Block ... $e) : D\ListElt {
        return D\li()->append(...$e);
    }

}
