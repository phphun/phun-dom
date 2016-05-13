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

use \phun\javascript as JS;
use phun\dom\CompositeNode;


// Interface for balise distinction
interface Block      {}
interface Inline     {}
interface Closed     {}
interface MetaHeader {}
interface InMap      {}
interface ListElt    {}
interface OptionElt  {}


// Generic Trait
trait AppendBlock {
    /**
     * Append nodes to the current element
     * @param ...Blocks Block, Inline or Closed
     * @return return the current instance of chaining
     */
    public function append(Block...$nodes) {
        $this->content = array_merge($this->content, $nodes);
        $this->reference(...$nodes);
        return $this;
    }

    /**
     * Prepend nodes to the current element
     * @param ...Blocks Block, Inline or Closed
     * @return return the current instance of chaining
     */
    public function prepend(Block ...$nodes) {
        $this->content = array_merge($nodes, $this->content);
        $this->reference(...$nodes);
        return $this;
    }
}

trait AppendText {
    /**
     * Append nodes to the current element
     * @param ...String, Inline or Closed
     * @return return the current instance of chaining
     */
    public function append(string...$nodes) {
        $this->content = array_merge($this->content, $nodes);
        $this->reference(...$nodes);
        return $this;
    }

    /**
     * Prepend nodes to the current element
     * @param ...String, Inline or Closde
     * @return return the current instance of chaining
     */
    public function prepend(string ...$nodes) {
        $this->content = array_merge($nodes, $this->content);
        $this->reference(...$nodes);
        return $this;
    }
}



/**
 * Abstract HTML's node representation
 */
abstract class Node {

    // Parameters
    protected $name;
    protected $uniq_id;
    protected $attributes;
    protected $atomic_attributes;

    // Use JavaScript Sandbox
    use JS\Sandbox;

    /**
     * Build a Generic Tag
     * @param string name the name of the tag. For example 'div'
     */
    public function __construct(string $name) {
        $this->name = $name;
        $this->attributes = [];
        $this->atomic_attributes = [];
        $this->newID();
        $this->init_sandbox();
    }

    /**
     * Check if a node is referenceable
     */
    public function isReferenceable() : bool {
        return true;
    }

    public function newID() {
        if ($this->name !== null)
            $this->uniq_id = \phun\utils\data_id($this->name);
    }

    function __clone() {
        $this->newID();
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
     * Remove attributes from a node
     * @param list of attributes names
     * @return eturn the current instance, for chaining operation
     */
    public static function removeAttributes(string...$keys) {
      foreach($keys as $key) {
        if (array_key_exists($key, $this->attributes)) {
          unset($this->attributes[$key]);
        }
        if ($index = array_search($key, $this->atomic_attributes)) {
          unset($this->atomic_attributes[$index]);
        }
      }
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
    public function where(string $key, $value = null, string $strategy = ' ') {
        if ($value === null) {
          $this->atomic_attributes[] = $key;
          return $this;
        }
        return $this->mergeAttribute($key, $value, $strategy);
    }

    /**
     * Set an ID to a node (shortcut for $elt->where('id', $name))
     * @param the ID
     * @return the current instance
     */
    public function id(string $name) {
      return $this->addAttribute('id', $name);
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
        foreach(array_unique($this->atomic_attributes) as $elt) {
          $result .= ' ' . $elt;
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

    /**
     * Return the UID of a node
     */
    public function getUID() : string {
        return $this->uniq_id;
    }

    // Magic methods

    /**
     * Magic overloading for easy attributes access
     */
    public function __get($attribute) {
      if (array_key_exists($attribute, $this->attributes))
        return $this->attributes[$attribute];
      return (in_array($attribute, $this->atomic_attributes));
    }

    /**
     * Magic overloading for easy attributes modificator
     */
    public function __set($name, $value) {
      if ($value === true) {
        $this->where($name);
        return;
      }
      $this->addAttribute($name, $value);
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

// InlineLeaf
class InlineLeaf extends Leaf implements Inline {}

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

    function __clone() {
        $this->newID();
        $this->content = array_map(function($e) {
            return clone $e;},
            $this->content
        );
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
        $this->reference(...$nodes);
        return $this;
    }

    /**
     * Prepend nodes to the current element
     * @param ...Inline nodes
     * @return return the current instance of chaining
     */
    public function prepend(Inline ...$nodes) {
        $this->content = array_merge($nodes, $this->content);
        $this->reference(...$nodes);
        return $this;
    }

}

// Typed Block
class BlockNode extends CompositeNode implements Block {
    use AppendBlock;
}

// PCData (raw text)
class PCDATA extends Node implements Inline, Block {

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

    public function isReferenceable() : bool {
        return false;
    }

}

// CData (raw unparsed text)
class CDATA extends PCDATA {
    /**
     * Magic string coersion
     * @return a String representation of a PCDATA
     */
    public function __toString() : string {
        return htmlspecialchars($this->raw);
    }

}

// Meta-decoration of balise
class MetadataLeaf extends Leaf      implements MetaHeader, Inline, Block  {}
class Template     extends BlockNode implements MetaHeader                 {}
class MetadataNode extends CompositeNode implements MetaHeader, Inline, Block {
    use AppendText;
}

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
        $this->reference(...$nodes);
        return $this;
    }

    /**
     * Prepend nodes to the current element
     * @param ...Blocks Block, Inline or Closde
     * @return return the current instance of chaining
     */
    public function prepend(MetaHeader ...$nodes) {
        $this->content = array_merge($nodes, $this->content);
        $this->reference(...$nodes);
        return $this;
    }
}

// Body Block
class Body extends CompositeNode {

    public function __construct() {
        parent::__construct('body');
    }
    use AppendBlock;
}

// Plain Balise
class Plain extends CompositeNode implements MetaHeader, Inline, Block {
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
 * Create a CData node
 * @param string data; the raw text
 * @return a CDATA node
 */
function cdata(string $data) {
    return new CDATA($data);
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
 * Create an InlineLeaf  (img for example) node
 * @param string the name of the tag, 'img' for example
 * @return an InlinedLeaf Node
 */
function inlineLeaf(string $name) {
    return new InlineLeaf($name);
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
    protected $hash;
    protected $client;

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
        $this->client = [];
        $this->hash = uniqid('$PHUN_INTERNAL_');
    }

    /**
     * Returns the header reference
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
        $this->body->append($this->createSandbox());
        $this->content = [$this->head, $this->body];
        return '<!doctype html>' . (parent::__toString());
    }

    public function referenced() {
        return array_merge(
            $this->head->referenced(),
            $this->body->referenced()
        );
    }

    protected function createSandbox() {
        $script = new MetadataNode('script');
        $content = $this->hash . '={};';
        $script->append($content);
        return $script;
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
        $this->reference(...$nodes);
        return $this;
    }

    /**
     * Prepend nodes to the current element
     * @param ...Blocks Block, Inline or Closde
     * @return return the current instance of chaining
     */
    public function prepend(InMap ...$nodes) {
        $this->content = array_merge($nodes, $this->content);
        $this->reference(...$nodes);
        return $this;
    }
}

class Option extends CompositeNode implements Inline {
  use AppendBlock;
}
class FormOption extends CompositeNode implements Inline, Block {
    /**
     * Append nodes to the current element
     * @param ...MetaHeader
     * @return return the current instance of chaining
     */
    public function append(Option...$nodes) {
        $this->content = array_merge($this->content, $nodes);
        $this->reference(...$nodes);
        return $this;
    }

    /**
     * Prepend nodes to the current element
     * @param ...Blocks Block, Inline or Closde
     * @return return the current instance of chaining
     */
    public function prepend(Option ...$nodes) {
        $this->content = array_merge($nodes, $this->content);
        $this->reference(...$nodes);
        return $this;
    }
}

// Ol/ul/li
class Enum extends CompositeNode implements Block {
    /**
     * Append nodes to the current element
     * @param ...MetaHeader
     * @return return the current instance of chaining
     */
    public function append(ListElt...$nodes) {
        $this->content = array_merge($this->content, $nodes);
        $this->reference(...$nodes);
        return $this;
    }

    /**
     * Prepend nodes to the current element
     * @param ...Blocks Block, Inline or Closde
     * @return return the current instance of chaining
     */
    public function prepend(ListElt ...$nodes) {
        $this->content = array_merge($nodes, $this->content);
        $this->reference(...$nodes);
        return $this;
    }
}

class EnumElt extends CompositeNode implements ListElt {
    use AppendBlock;
}

// Unsafe Leaf
class UnsafeLeaf extends Leaf
  implements Inline, MetaHeader, InMap, ListElt {}

// Unsafe Block
class UnsafeBlock extends BlockNode
  implements Inline, MetaHeader, InMap, ListElt {}
