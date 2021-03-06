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


/**
 * @TODO fix indentation :'(
 */

declare (strict_types = 1);

/**
 * Provide HTML's node representation.
 *
 * @author Van de Woestyne Xavier <xaviervdw@gmail.com>
 */

namespace phun\dom;

use phun\javascript as JS;

// Interface for balise distinction
interface Block
{
}
interface Inline
{
}
interface Closed
{
}
interface MetaHeader
{
}
interface InMap
{
}
interface ListElt
{
}
interface OptionElt
{
}

// Generic Trait
trait AppendBlock
{
    /**
   * Append nodes to the current element.
   *
   * @param ...Blocks Block, Inline or Closed
   *
   * @return return the current instance of chaining
   */
  public function append(Block ...$nodes)
  {
      $this->content = array_merge($this->content, $nodes);
      $this->reference(...$nodes);

      return $this;
  }

  /**
   * Prepend nodes to the current element.
   *
   * @param ...Blocks Block, Inline or Closed
   *
   * @return return the current instance of chaining
   */
  public function prepend(Block ...$nodes)
  {
      $this->content = array_merge($nodes, $this->content);
      $this->reference(...$nodes);

      return $this;
  }
}

trait AppendText
{
    /**
   * Append nodes to the current element.
   *
   * @param ...String, Inline or Closed
   *
   * @return return the current instance of chaining
   */
  public function append(string ...$nodes)
  {
      $this->content = array_merge($this->content, $nodes);
      $this->reference(...$nodes);

      return $this;
  }

  /**
   * Prepend nodes to the current element.
   *
   * @param ...String, Inline or Closde
   *
   * @return return the current instance of chaining
   */
  public function prepend(string ...$nodes)
  {
      $this->content = array_merge($nodes, $this->content);
      $this->reference(...$nodes);

      return $this;
  }
}

/**
 * Abstract HTML's node representation.
 */
abstract class Node
{
    // name of the node <name>
  protected $name;
  // an uniq id for Js wrapping
  protected $uniq_id;
  // attributes with values
  protected $attributes;
  // attributes without values
  protected $atomic_attributes;
  // JavaScript properties
  protected $props;

  // Use JavaScript Sandbox
  use JS\Sandbox;
  // Use Props Helper
  use JS\Props;

  /**
   * Build a Generic Tag.
   *
   * @param string name the name of the tag. For example 'div'
   */
  public function __construct(string $name)
  {
      $this->name = $name;
      $this->attributes = [];
      $this->atomic_attributes = [];
      $this->newID();
      $this->props = [];
      $this->init_sandbox();
  }

  /**
   * Check if a node is referenceable.
   */
  public function isReferenceable() : bool
  {
      return true;
  }

  /**
   * Generate a new ID (data-phun-id)
   */
  public function newID()
  {
      if ($this->name !== null) {
          $this->uniq_id = \phun\util\data_id($this->name);
      }
  }

  /**
   * Wrapper for cloning element
   */
  public function __clone()
  {
      $this->newID();
  }

  /**
   * Add an attribute to the node. Erase old attribute if exists.
   *
   * @param string key the name of the attribute
   * @param value the value of the attribute
   *
   * @return return the current instance, for chaining operation
   */
  public function addAttribute(string $key, $value)
  {
      $this->attributes[$key] = $value;

      return $this;
  }

  /**
   * Remove attributes from a node.
   *
   * @param list of attributes names
   *
   * @return eturn the current instance, for chaining operation
   */
  public static function removeAttributes(string ...$keys)
  {
      foreach ($keys as $key) {
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
   * Same of addAttribute, but merge the existing attributes.
   *
   * @see addAttribute
   *
   * @param string key the name of the attribute
   * @param value the value of the attribute
   * @param string strategy (the separator of data)
   *
   * @return return the current instance, for chaining operation
   */
  public function mergeAttribute(string $key, $value, string $strategy = ' ')
  {
      if (array_key_exists($key, $this->attributes)) {
          $this->attributes[$key] .= $strategy.$value;
      } else {
          $this->attributes[$key] = $value;
      }

      return $this;
  }

  /**
   * @see mergeAttribute
   */
  public function where(string $key, $value = null, string $strategy = ' ')
  {
      if ($value === null) {
          $this->atomic_attributes[] = $key;

          return $this;
      }

      return $this->mergeAttribute($key, $value, $strategy);
  }

  /**
   * Set an ID to a node (shortcut for $elt->where('id', $name)).
   *
   * @param the ID
   *
   * @return the current instance
   */
  public function id(string $name)
  {
      return $this->addAttribute('id', $name);
  }

  /**
   * Coers attributes to string.
   *
   * @return an internal representation of attributes
   */
  protected function attrToString() : string
  {
      $result = ' data-phun-id="'.$this->uniq_id.'"';
      foreach ($this->attributes as $key => $value) {
          $result .= ' '.$key.'="'.$value.'"';
      }
      foreach (array_unique($this->atomic_attributes) as $elt) {
          $result .= ' '.$elt;
      }

      return $result;
  }

  /**
   * Coers the base of a tag to String.
   *
   * @return an internal representation of an unclosed tag
   */
  protected function baseTagToString() : string
  {
      return '<'.$this->name.$this->attrToString();
  }

  /**
   * Return the UID of a node.
   */
  public function getUID() : string
  {
      return $this->uniq_id;
  }

  // Magic methods

  /**
   * Magic overloading for easy attributes access.
   */
  public function __get($attribute)
  {
      if (array_key_exists($attribute, $this->attributes)) {
          return $this->attributes[$attribute];
      }

      return in_array($attribute, $this->atomic_attributes);
  }

  /**
   * Magic overloading for easy attributes modificator.
   */
  public function __set($name, $value)
  {
      if ($value === true) {
          $this->where($name);

          return;
      }
      $this->addAttribute($name, $value);
  }
}

// An atomic blog representation
class Leaf extends Node implements Closed, Block
{
    /**
   * Build an atomic Tag.
   *
   * @param string name the name of the tag. For example 'hr'
   */
  public function __construct(string $name)
  {
      parent::__construct($name);
  }

  /**
   * Magic string coersion.
   *
   * @return a String representation of a Leaf
   */
  public function __toString() : string
  {
      return $this->baseTagToString().'/>';
  }
}

// InlineLeaf
class InlineLeaf extends Leaf implements Inline
{
}

// Wrapper for TypeSafe dom representation
abstract class CompositeNode extends Node
{
    // Attributes
  protected $content;

  /**
   * Build a Generic Composite Tag.
   *
   * @param string name the name of the tag. For example 'div' or 'span'
   */
  public function __construct(string $name)
  {
      parent::__construct($name);
      $this->content = [];
  }

  /**
   * Magic string coersion.
   *
   * @return a String representation of a Composite Node
   */
  public function __toString() : string
  {
      $result = $this->baseTagToString().'>';
      foreach ($this->content as $elt) {
          $result .= $elt;
      }
      $result .= '</'.$this->name.'>';

      return $result;
  }

  /**
   * Process cloning
   */
  public function __clone()
  {
      $this->newID();
      $this->content = array_map(
        function ($e) {
          return clone $e;
        }, $this->content
      );
  }
}

// Typed Inline
class InlineNode extends CompositeNode implements Inline, Closed, Block
{
    /**
   * Append nodes to the current element.
   *
   * @param ...Inline Nodes
   *
   * @return return the current instance of chaining
   */
  public function append(Inline ...$nodes)
  {
      $this->content = array_merge($this->content, $nodes);
      $this->reference(...$nodes);

      return $this;
  }

  /**
   * Prepend nodes to the current element.
   *
   * @param ...Inline nodes
   *
   * @return return the current instance of chaining
   */
  public function prepend(Inline ...$nodes)
  {
      $this->content = array_merge($nodes, $this->content);
      $this->reference(...$nodes);

      return $this;
  }
}

// Typed Block
class BlockNode extends CompositeNode implements Block
{
    use AppendBlock;
}

// PCData (raw text)
class PCDATA extends Node implements Inline, Block, OptionElt
{
    // Attributes
  protected $raw;

  /**
   * Build a PCDATA.
   *
   * @param string the value of PCData
   */
  public function __construct(string $data)
  {
      $this->raw = $data;
  }

  /**
   * Magic string coersion.
   *
   * @return a String representation of a PCDATA
   */
  public function __toString() : string
  {
      return $this->raw;
  }

    public function isReferenceable() : bool
    {
        return false;
    }
}

// CData (raw unparsed text)
class CDATA extends PCDATA
{
    /**
   * Magic string coersion.
   *
   * @return a String representation of a PCDATA
   */
  public function __toString() : string
  {
      return htmlspecialchars($this->raw);
  }
}

// Meta-decoration of balise
class MetadataLeaf extends Leaf implements MetaHeader, Inline, Block
{
}
class Template     extends BlockNode implements MetaHeader
{
}
class MetadataNode extends CompositeNode implements MetaHeader, Inline, Block
{
    use AppendText;
}

// Header block
class Header extends CompositeNode
{
    public function __construct()
    {
        parent::__construct('head');
    }

  /**
   * Append nodes to the current element.
   *
   * @param ...MetaHeader
   *
   * @return return the current instance of chaining
   */
  public function append(MetaHeader ...$nodes)
  {
      $this->content = array_merge($this->content, $nodes);
      $this->reference(...$nodes);

      return $this;
  }

  /**
   * Prepend nodes to the current element.
   *
   * @param ...Blocks Block, Inline or Closde
   *
   * @return return the current instance of chaining
   */
  public function prepend(MetaHeader ...$nodes)
  {
      $this->content = array_merge($nodes, $this->content);
      $this->reference(...$nodes);

      return $this;
  }
}

// Body Block
class Body extends CompositeNode
{
    public function __construct()
    {
        parent::__construct('body');
    }
    use AppendBlock;
}

// Plain Balise
class Plain extends CompositeNode implements MetaHeader, Inline, Block
{
    /**
   * Append nodes to the current element.
   *
   * @param ...PCDATA
   *
   * @return return the current instance of chaining
   */
  public function append(PCDATA ...$nodes)
  {
      $this->content = array_merge($this->content, $nodes);

      return $this;
  }

  /**
   * Prepend nodes to the current element.
   *
   * @param ...Blocks Block, Inline or Closde
   *
   * @return return the current instance of chaining
   */
  public function prepend(PCDATA ...$nodes)
  {
      $this->content = array_merge($nodes, $this->content);

      return $this;
  }
}

/**
 * Create a PCData node.
 *
 * @param string data; the raw text
 *
 * @return a PCDATA node
 */
function pcdata(string $data)
{
    return new PCDATA($data);
}

/**
 * Create a CData node.
 *
 * @param string data; the raw text
 *
 * @return a CDATA node
 */
function cdata(string $data)
{
    return new CDATA($data);
}

/**
 * Create a Leaf (hr, br) node.
 *
 * @param string the name of the tag ('hr', 'br') for example
 *
 * @return a Leaf Node
 */
function leaf(string $name)
{
    return new Leaf($name);
}

/**
 * Create an Inline  (span for example) node.
 *
 * @param string the name of the tag, 'span' for example
 *
 * @return an Inlined Node
 */
function inline(string $name)
{
    return new InlineNode($name);
}

/**
 * Create an InlineLeaf  (img for example) node.
 *
 * @param string the name of the tag, 'img' for example
 *
 * @return an InlinedLeaf Node
 */
function inlineLeaf(string $name)
{
    return new InlineLeaf($name);
}

/**
 * Create a Block  (div for example) node.
 *
 * @param string the name of the tag, 'div' for example
 *
 * @return a Block Node
 */
function block(string $name)
{
    return new BlockNode($name);
}

/**
 * Represent a complete HTML Document.
 */
class Document extends CompositeNode
{
    // Attributes

  protected $head;
    protected $body;
    protected $title;
    protected $hash;
    protected $client;

  /**
   * Create a Document (HTML) with easy access to head and body. Title, lang and charset are
   * pre-saved and doesn't be specified.
   *
   * @param string title the title of the page
   * @param string charset the charset of the page
   * @param string lang the language of the page
   *
   * @return an instance of Document
   */
  public function __construct(string $title, string $charset = 'utf-8', string $lang = 'en')
  {
      parent::__construct('html');
      $this->addAttribute('lang', $lang);
      $meta = (new MetadataLeaf('meta'))->where('charset', $charset);
      $title = (new Plain('title'))->append(pcdata($title));
      $this->head = (new Header())->prepend($meta)->append($title);
      $this->body = new Body();
      $this->client = [];
  }

  /**
   * Append a client Side procedure
   * @param an unit callback to be executed (returns Js code)
   * @return $this
   */
   public function client($callback)
   {
       $this->client[] = $callback;
   }

  /**
   * Returns the header reference.
   *
   * @return Header header element
   */
  public function head()
  {
      return $this->head;
  }

  /**
   * Returns the body reférence.
   *
   * @return Body body element
   */
  public function body()
  {
      return $this->body;
  }


  /**
   * Returns all referenced Html
   * @return an array with all nodes
   */
  public function referenced()
  {
      return array_merge($this->head->referenced(), $this->body->referenced());
  }

  /**
   * Create the Hash with all referenced nodes
   */
  protected function createJSHash()
  {
      $content = 'var '. JS\elements .'={' . "\n";
      foreach ($this->referenced() as $elt => $value) {
          if ($value->is_colored()) {
              $querySel = '[data-phun-id="'.$elt.'"]';
              $content .= "\t".'"'.$elt.'":[document.querySelector(\''.$querySel.'\'),';
              $content .= '{';
              foreach ($value->get_all_props() as $k => $v) {
                  $content .= '"'.$k.'":'.$v.',';
              }
              $content .= "}]\n";
          }
      }
      $content .= '};'."\n";

      return $content;
  }

  /**
   * Create a Script Sandobox
   */
  protected function createSandbox()
  {
      $script = new MetadataNode('script');
      $result = '';
      foreach ($this->client as $proc) {
          $result .= $proc->call($this);
      }
      $script->append($this->createJSHash());
      $script->append($result);

      return $script;
  }

  /**
   * Get an element on client side
   * @param Node an Html Node
   *
   * @return A JavaScript Element
   */
   public function js($element)
   {
       $element->colorize();
       return new JS\Element($element->getUID(), $element->get_all_props());
   }

  /**
   * Set props on client side
   */
  public function props($element, string $key, $value)
  {
      $element->set_props($key, $value);
      //$this->client(function () {
      //  return JS\elements .'["'.$element->getUID().'"][1].'.$key.'='.$value.';\n';
      //});
  }

  /**
   * Magic string coersion.
   *
   * @return a String representation of an HTML Document
   */
  public function __toString() : string
  {
      $this->body->append($this->createSandbox());
      $this->content = [$this->head, $this->body];
      return '<!doctype html>'.(parent::__toString());
  }
}

// TypeFix class
class MapElement extends InlineNode implements InMap
{
}

class Map extends CompositeNode implements Block
{
    public function __construct()
    {
        parent::__construct('map');
    }

  /**
   * Append nodes to the current element.
   *
   * @param ...InMap
   *
   * @return return the current instance of chaining
   */
  public function append(InMap ...$nodes)
  {
      $this->content = array_merge($this->content, $nodes);
      $this->reference(...$nodes);

      return $this;
  }

  /**
   * Prepend nodes to the current element.
   *
   * @param ...Blocks Block, Inline or Closde
   *
   * @return return the current instance of chaining
   */
  public function prepend(InMap ...$nodes)
  {
      $this->content = array_merge($nodes, $this->content);
      $this->reference(...$nodes);

      return $this;
  }
}

class Option extends CompositeNode implements OptionElt
{
    /**
   * Append nodes to the current element.
   *
   * @param ...MetaHeader
   *
   * @return return the current instance of chaining
   */
  public function append(OptionElt ...$nodes)
  {
      $this->content = array_merge($this->content, $nodes);
      $this->reference(...$nodes);

      return $this;
  }

  /**
   * Prepend nodes to the current element.
   *
   * @param ...Blocks Block, Inline or Closde
   *
   * @return return the current instance of chaining
   */
  public function prepend(OptionElt ...$nodes)
  {
      $this->content = array_merge($nodes, $this->content);
      $this->reference(...$nodes);

      return $this;
  }
}
class FormOption extends CompositeNode implements Inline, Block
{
    /**
   * Append nodes to the current element.
   *
   * @param ...MetaHeader
   *
   * @return return the current instance of chaining
   */
  public function append(OptionElt ...$nodes)
  {
      $this->content = array_merge($this->content, $nodes);
      $this->reference(...$nodes);

      return $this;
  }

  /**
   * Prepend nodes to the current element.
   *
   * @param ...Blocks Block, Inline or Closde
   *
   * @return return the current instance of chaining
   */
  public function prepend(OptionElt ...$nodes)
  {
      $this->content = array_merge($nodes, $this->content);
      $this->reference(...$nodes);

      return $this;
  }
}

// Ol/ul/li
class Enum extends CompositeNode implements Block
{
    /**
   * Append nodes to the current element.
   *
   * @param ...MetaHeader
   *
   * @return return the current instance of chaining
   */
  public function append(ListElt ...$nodes)
  {
      $this->content = array_merge($this->content, $nodes);
      $this->reference(...$nodes);

      return $this;
  }

  /**
   * Prepend nodes to the current element.
   *
   * @param ...Blocks Block, Inline or Closde
   *
   * @return return the current instance of chaining
   */
  public function prepend(ListElt ...$nodes)
  {
      $this->content = array_merge($nodes, $this->content);
      $this->reference(...$nodes);

      return $this;
  }
}

class EnumElt extends CompositeNode implements ListElt
{
    use AppendBlock;
}

// Unsafe Leaf
class UnsafeLeaf extends Leaf
implements Inline, MetaHeader, InMap, ListElt
{
}

// Unsafe Block
class UnsafeBlock extends BlockNode
implements Inline, MetaHeader, InMap, ListElt
{
}
