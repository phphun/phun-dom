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


// Interface for balise distinction
interface Block      {}
interface Inline     {}
interface Closed     {}
interface MetaHeader {}
interface InMap      {}
interface ListElt    {}


/**
 * Abstract HTML's node representation
 */
abstract class Node {

    // Parameters
    protected $name;
    protected $uniq_id;
    protected $attributes;


    /**
     * Build a Generic Tag
     * @param string name the name of the tag. For example 'div'
     */
    public function __construct(string $name) {
        $this->name = $name;
        $this->uniq_id = \phun\utils\data_id($name);
        $this->attributes = [];
    }


    /**
     * Add an attribute to the node. Erase old attribute if exists
     * @param string key the name of the attribute
     * @param value the value of the attribute
     * @return return the current instance, for chaining operation
     */
    public function addAttribute(string $key, $value)  {
        $this->attributes[$key] = $value;
        return $this;
    }


    /**
     * Same of addAttribute, but merge the existing attributes
     * @see addAttribute
     * @param string key the name of the attribute
     * @param value the value of the attribute
     * @param string strategy (the separator of data)
     * @return return the current instance, for chaining operation
     */
    public function mergeAttribute(string $key, $value, string $strategy = ' ') {
        if (array_key_exists($key, $this->attributes)) {
            $this->attributes[$key] .= $strategy . $value;
        } else {
            $this->attributes[$key] = $value;
        }
        return $this;
    }

    /**
     * @see mergeAttribute
     */
    public function where(string $key, $value, string $strategy = ' ') {
        return $this->mergeAttribute($key, $value, $strategy);
    }


    /**
     * Coers attributes to string
     * @return an internal representation of attributes
     */
    protected function attrToString() : string {
        $result = ' data-phun-id="' . $this->uniq_id . '"';
        foreach($this->attributes as $key => $value) {
            $result .= ' ' . $key . '="' . $value . '"' ;
        }
        return $result;
    }


    /**
     * Coers the base of a tag to String
     * @return an internal representation of an unclosed tag
     */
    protected function baseTagToString() : string {
        return '<' . $this->name . $this->attrToString() ;
    }

}

// An atomic blog representation
class Leaf extends Node implements Closed, Block{

    /**
     * Build an atomic Tag
     * @param string name the name of the tag. For example 'hr'
     */
    public function __construct(string $name) {
        parent::__construct($name);
    }

    /**
     * Magic string coersion
     * @return a String representation of a Leaf
     */
    public function __toString() : string {
        return $this->baseTagToString() . '/>';
    }

}

// Wrapper for TypeSafe dom representation
abstract class CompositeNode extends Node {

    // Attributes
    protected $content;

    /**
     * Build a Generic Composite Tag
     * @param string name the name of the tag. For example 'div' or 'span'
     */
    public function __construct(string $name) {
        parent::__construct($name);
        $this->content = [];
    }

    /**
     * Magic string coersion
     * @return a String representation of a Composite Node
     */
    public function __toString() : string {
        $result = $this->baseTagToString() . '>';
        foreach($this->content as $elt) {
            $result .= $elt;
        }
        $result .= '</'.$this->name.'>';
        return $result;
    }


}

// Typed Inline
class InlineNode extends CompositeNode implements Inline, Closed, Block {


    /**
     * Append nodes to the current element
     * @param ...Inline Nodes
     * @return return the current instance of chaining
     */
    public function append(Inline...$nodes) {
        $this->content = array_merge($this->content, $nodes);
        return $this;
    }

    /**
     * Prepend nodes to the current element
     * @param ...Inline nodes
     * @return return the current instance of chaining
     */
    public function prepend(Inline ...$nodes) {
        $this->content = array_merge($nodes, $this->content);
        return $this;
    }

}

// Typed Block
class BlockNode extends CompositeNode implements Block {
    /**
     * Append nodes to the current element
     * @param ...Blocks Block, Inline or Closed
     * @return return the current instance of chaining
     */
    public function append(Block...$nodes) {
        $this->content = array_merge($this->content, $nodes);
        return $this;
    }

    /**
     * Prepend nodes to the current element
     * @param ...Blocks Block, Inline or Closde
     * @return return the current instance of chaining
     */
    public function prepend(Block ...$nodes) {
        $this->content = array_merge($nodes, $this->content);
        return $this;
    }
}

// PCData (raw text)
class PCDATA implements Inline, Block {

    // Attributes
    protected $raw;

    /**
     * Build a PCDATA
     * @param string the value of PCData
     */
    public function __construct(string $data) {
        $this->raw = $data;
    }

    /**
     * Magic string coersion
     * @return a String representation of a PCDATA
     */
    public function __toString() : string {
        return $this->raw;
    }

}

// Meta-decoration of balise
class MetadataLeaf extends Leaf implements MetaHeader, Inline          {}
class MetadataNode extends CompositeNode implements MetaHeader, Inline {}
class Template     extends BlockNode implements MetaHeader             {}

// Header block
class Header extends CompositeNode {

    public function __construct() {
        parent::__construct('head');
    }

    /**
     * Append nodes to the current element
     * @param ...MetaHeader
     * @return return the current instance of chaining
     */
    public function append(MetaHeader...$nodes) {
        $this->content = array_merge($this->content, $nodes);
        return $this;
    }

    /**
     * Prepend nodes to the current element
     * @param ...Blocks Block, Inline or Closde
     * @return return the current instance of chaining
     */
    public function prepend(MetaHeader ...$nodes) {
        $this->content = array_merge($nodes, $this->content);
        return $this;
    }
}

// Body Block
class Body extends CompositeNode {

    public function __construct() {
        parent::__construct('body');
    }

    /**
     * Append nodes to the current element
     * @param ...Node
     * @return return the current instance of chaining
     */
    public function append(Node...$nodes) {
        $this->content = array_merge($this->content, $nodes);
        return $this;
    }

    /**
     * Prepend nodes to the current element
     * @param ...Blocks Block, Inline or Closde
     * @return return the current instance of chaining
     */
    public function prepend(Node ...$nodes) {
        $this->content = array_merge($nodes, $this->content);
        return $this;
    }
}

// Plain Balise
class Plain extends CompositeNode implements MetaHeader, Inline {
    /**
     * Append nodes to the current element
     * @param ...PCDATA
     * @return return the current instance of chaining
     */
    public function append(PCDATA...$nodes) {
        $this->content = array_merge($this->content, $nodes);
        return $this;
    }

    /**
     * Prepend nodes to the current element
     * @param ...Blocks Block, Inline or Closde
     * @return return the current instance of chaining
     */
    public function prepend(PCDATA ...$nodes) {
        $this->content = array_merge($nodes, $this->content);
        return $this;
    }
}


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
    return new BlockNode($name);
}

/**
 * Represent a complete HTML Document
 */
class Document extends CompositeNode {

    // Attributes

    protected $head;
    protected $body;
    protected $title;

    /**
     * Create a Document (HTML) with easy access to head and body. Title, lang and charset are
     * pre-saved and doesn't be specified.
     * @param string title the title of the page
     * @param string charset the charset of the page
     * @param string lang the language of the page
     * @return an instance of Document
     */
    public function __construct(string $title, string $charset = 'utf-8', string $lang = 'en') {
        parent::__construct('html');
        $this->addAttribute('lang', $lang);
        $meta = (new MetadataLeaf('meta'))->where('charset', $charset);
        $title = (new Plain('title'))->append(pcdata($title));
        $this->head = (new Header())->prepend($meta)->append($title);
        $this->body = new Body();
    }

    /**
     * Returns the header reférence
     * @return Header header element
     */
    public function head() {
        return $this->head;
    }

    /**
     * Returns the body reférence
     * @return Body body element
     */
    public function body() {
        return $this->body;
    }

    /**
     * Magic string coersion
     * @return a String representation of an HTML Document
     */
    public function __toString() : string {
        $this->content = [$this->head, $this->body];
        return '<!doctype html>' . (parent::__toString());
    }

}

// TypeFix class
class MapElement extends InlineNode implements InMap {}

class Map extends CompositeNode implements Block {
    public function __construct() {
        parent::__construct('map');
    }

    /**
     * Append nodes to the current element
     * @param ...InMap
     * @return return the current instance of chaining
     */
    public function append(InMap...$nodes) {
        $this->content = array_merge($this->content, $nodes);
        return $this;
    }

    /**
     * Prepend nodes to the current element
     * @param ...Blocks Block, Inline or Closde
     * @return return the current instance of chaining
     */
    public function prepend(InMap ...$nodes) {
        $this->content = array_merge($nodes, $this->content);
        return $this;
    }
}

// Ol/ul/li
class Enum extends BlockNode {
    /**
     * Append nodes to the current element
     * @param ...MetaHeader
     * @return return the current instance of chaining
     */
    public function append(ListElt...$nodes) {
        $this->content = array_merge($this->content, $nodes);
        return $this;
    }

    /**
     * Prepend nodes to the current element
     * @param ...Blocks Block, Inline or Closde
     * @return return the current instance of chaining
     */
    public function prepend(ListElt ...$nodes) {
        $this->content = array_merge($nodes, $this->content);
        return $this;
    }
}

