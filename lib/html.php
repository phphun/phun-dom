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
 * Direct append on element
 * @param Node base the receiver of the nodes
 * @param Nodes nodes list
 * @return the receiver
 */
function append($base, ...$nodes) {
    return $base->append(...$nodes);
}

/**
 * Direct prepend on element
 * @param Node base the receiver of the nodes
 * @param Nodes nodes list
 * @return the receiver
 */
function preped($base, ...$nodes) {
    return $base->prepend(...$nodes);
}

/**
 * Create a Document (HTML) with easy access to head and body. Title, lang and charset are
 * pre-saved and doesn't be specified.
 * @param string title the title of the page
 * @param string charset the charset of the page
 * @param string lang the language of the page
 * @return an instance of Document
 */
function html(string $title, string $charset = 'utf-8', string $lang = 'utf-8') {
    return new Document($title, $charset, $lang);
}

/**
 * Create an Header Element
 * @return Header object
 */
function head() {
    return new Header();
}

/**
 * Create a Body Element
 * @return Body object
 */
function body() {
    return new Body();
}


/**
 * Create a base Element
 * @return MetadataLeaf object
 */
function base() {
    return new MetadataLeaf('base');
}

/**
 * Create a link Element
 * @return MetadataLeaf object
 */
function link() {
    return new MetadataLeaf('link');
}

/**
 * Create a meta Element
 * @return MetadataLeaf object
 */
function meta() {
    return new MetadataLeaf('meta');
}

/**
 * Create a noscript Element
 * @return MetadataNode object
 */
function noscript() {
    return new MetadataNode('noscript');
}

/**
 * Create a script Element
 * @return MetadataNode object
 */
function script() {
    return new MetadataNode('script');
}

/**
 * Create a style Element
 * @return MetadataNode object
 */
function style() {
    return new MetadataNode('style');
}

/**
 * Create a template Element
 * @return Template object
 */
function template() {
    return new Template('template');
}

/**
 * Create a title Element
 * @return Plain object
 */
function title(string $value) {
    return (new Plain('title'))
        ->append(pcdata($value));
}

/**
 * Create an A element
 * @return MapElement element
 */
function a() {
    return new MapElement('a');
}

/**
 * Create an Area element
 * @return MapElement element
 */
function area() {
    return new MapElement('area');
}


/**
 * Create an abbreviation element
 * @param string the content (abbriged word)
 * @param string the sense of the abbrev
 * @return Plain object
 */
function abbr(string $content, string $abbrv) {
    return (new Plain('abbr'))
        ->where('title', $abbrv)
        ->append(pcdata($content));
}

/**
 * Create an address Block
 * @return BlockNode object
 */
function address() {
    return block('address');
}

/**
 * Create a Map Block
 * @return Map object
 */
function map() {
    return new Map();
}

/**
 * Create an Article Block
 * @return BlockNode object
 */
function article() {
    return block('article');
}

/**
 * Create an Aside Block
 * @return BlockNode object
 */
function aside() {
    return block('aside');
}

/**
 * Create a div Block
 * @return BlockNode object
 */
function div() {
    return block('div');
}

/**
 * Create an Audio Block
 * @return InlineNode object
 */
function audio() {
    return inline('audio');
}

/**
 * Create a video Block
 * @return InlineNode object
 */
function video() {
    return inline('video');
}

/**
 * Create a bold Block
 * @return InlineNode object
 */
function b() {
    return inline('b');
}

/**
 * Create a strong Block
 * @return InlineNode object
 */
function strong() {
    return inline('strong');
}


/**
 * Create a span Block
 * @return InlineNode object
 */
function span() {
    return inline('span');
}

/**
 * Create a bdi Block
 * @return InlineNode object
 */
function bdi() {
    return inline('bdi');
}

/**
 * Create a bdo Block
 * @return InlineNode object
 */
function bdo() {
    return inline('bdo');
}

/**
 * Create a blockquote Block
 * @return BlockNode object
 */
function blockquote() {
    return block('blockquote');
}

/**
 * Create a Br Block
 * @return Leaf object
 */
function br() {
    return leaf('br');
}

/**
 * Create a button Block
 * @return InlineNode object
 */
function button() {
    return inline('button');
}

/**
 * Create a Canvas Block
 * @return InlineNode object
 */
function canvas() {
    return inline('canvas');
}

/**
 * Create a Cite Block
 * @return InlineNode object
 */
function cite() {
    return inline('cite');
}

/**
 * Create a Code Block
 * @return InlineNode object
 */
function code() {
    return inline('code');
}

/**
 * Create a Data Element
 * @return Leaf object
 */
function data(string $value) {
    return leaf('data')
        ->where('value', $value);
}

/**
 * Create a Del Block
 * @return InlineNode object
 */
function del() {
    return inline('del');
}

/**
 * Create a Dfn Block
 * @return InlineNode object
 */
function dfn() {
    return inline('dfn');
}

/**
 * Create a em Block
 * @return InlineNode object
 */
function em() {
    return inline('em');
}

/**
 * Create a footer Block
 * @return BlockNode object
 */
function footer() {
    return block('footer');
}

/**
 * Create a header Block
 * @return BlockNode object
 */
function header() {
    return block('header');
}




