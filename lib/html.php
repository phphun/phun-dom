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

