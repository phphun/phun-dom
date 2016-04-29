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
function prepend($base, ...$nodes) {
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
function html(string $title, string $charset = 'utf-8', string $lang = 'en') {
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
 * Create a Var element
 * @return Plain object
 */
function _var(string $content) {
    return (new Plain('var'))
        ->append(pcdata($content));
}

/**
 * Create a Time element
 * @return Plain object
 */
function time(string $content) {
    return (new Plain('time'))
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
 * Create a sup Block
 * @return InlineNode object
 */
function sup() {
    return inline('sup');
}

/**
 * Create a sub Block
 * @return InlineNode object
 */
function sub() {
    return inline('sub');
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
 * Create a Wbr Block
 * @return Leaf object
 */
function wbr() {
    return leaf('wbr');
}

/**
 * Create a Hr Block
 * @return Leaf object
 */
function hr() {
    return leaf('hr');
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
 * Create a img Block
 * @return InlineNode object
 */
function img() {
    return inline('img');
}

/**
 * Create a Small Block
 * @return InlineNode object
 */
function small() {
    return inline('small');
}



/**
 * Create a I Block
 * @return InlineNode object
 */
function i() {
    return inline('i');
}

/**
 * Create a Mark Block
 * @return InlineNode object
 */
function mark() {
    return inline('mark');
}

/**
 * Create a U Block
 * @return InlineNode object
 */
function u() {
    return inline('u');
}

/**
 * Create a Q Block
 * @return InlineNode object
 */
function q() {
    return inline('q');
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

/**
 * Create a section Block
 * @return BlockNode object
 */
function section() {
    return block('section');
}


/**
 * Create a nav Block
 * @return BlockNode object
 */
function nav() {
    return block('nav');
}

/**
 * Create a h1 Block
 * @return BlockNode object
 */
function h1() {
    return block('h1');
}

/**
 * Create a h2 Block
 * @return BlockNode object
 */
function h2() {
    return block('h2');
}


/**
 * Create a h3 Block
 * @return BlockNode object
 */
function h3() {
    return block('h3');
}

/**
 * Create a h4 Block
 * @return BlockNode object
 */
function h4() {
    return block('h4');
}

/**
 * Create a h5 Block
 * @return BlockNode object
 */
function h5() {
    return block('h5');
}

/**
 * Create a h6 Block
 * @return BlockNode object
 */
function h6() {
    return block('h6');
}

/**
 * Create an Ins Block
 * @return BlockNode object
 */
function ins() {
    return block('ins');
}

/**
 * Create an Main Block
 * @return BlockNode object
 */
function main() {
    return block('main');
}

/**
 * Create a P Block
 * @return BlockNode object
 */
function p() {
    return block('p');
}

/**
 * Create a Pre Block
 * @return BlockNode object
 */
function pre() {
    return block('pre');
}


/**
 * Create a Ol Block
 * @return Enum object
 */
function ol() {
    return new Enum('ol');
}

/**
 * Create a Ul Block
 * @return Enum object
 */
function ul() {
    return new Enum('ul');
}


/**
 * Create a li Block
 * @return EnumElt object
 */
function li() {
    return new EnumElt('li');
}

/**
 * Create an Iframe Block
 * @return Inline object
 */
function iframe() {
    return inline('iframe');
}

/**
 * Create a Form Block
 * @return Block A formlet
 */
 function form() {
   return block('form');
 }

 /**
  * Create a Fieldset Block
  * @return Block A Fieldset
  */
  function fieldset() {
    return block('fieldset');
  }

 /**
  * Create a Label tag
  * @return Inline object
  */
 function label() {
     return inline('label');
 }

 /**
  * Create a legend tag
  * @todo this tag is not well typed ... :'( 
  * @return Inline object
  */
 function legend() {
     return inline('legend');
 }

 /**
  * Create an input tag
  * @return Inline object
  */
 function input() {
     return inline('input');
 }

 /**
  * Create an textarea tag
  * @return Inline object
  */
 function textarea() {
     return inline('textarea');
 }

 /**
  * Create a keygen tag
  * @return Inline object
  */
 function keygen() {
     return inline('keygen');
 }

 /**
  * Create an output tag
  * @return Inline object
  */
 function output() {
     return inline('output');
 }

 /**
  * Create a progress tag
  * @return Inline object
  */
 function progress() {
     return inline('progress');
 }

 /**
  * Create a meter tag
  * @return Inline object
  */
 function meter() {
     return inline('meter');
 }

 /**
  * Create a datalist tag
  * @return Inline object
  */
 function datalist() {
     return new FormOption('datalist');
 }

 /**
  * Create a select tag
  * @return Inline object
  */
 function select() {
     return new FormOption('select');
 }

 /**
  * Create an Option tag
  * @return Inline object
  */
 function option() {
     return new Option('option');
 }

 /**
  * Create an OptionGroup tag
  * @return Inline object
  */
 function optgroup() {
     return new Option('optgroup');
 }
