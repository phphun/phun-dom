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

declare (strict_types=1);


/**
 * Provide a Javascript Sandbox for Dom manipulation
 * @author Van de Woestyne Xavier <xaviervdw@gmail.com>
 */
namespace phun\javascript;

// Variables where object are stored
const elements = '$PHUN_INTERNAL_ELEMENTS';

trait Sandbox
{
    // Attributes
    protected $referenced_nodes;
    protected $colored;

    /**
     * Initialize de sandbox
     */
    protected function init_sandbox()
    {
        $this->referenced_nodes = [];
        $this->colored = false;
    }

    /**
     * Check if a node is used in JavaScript
     */
    protected function is_colored()
    {
        return $this->colored;
    }

    /**
     * Get all referenced nodes
     */
    public function referenced()
    {
        return $this->referenced_nodes;
    }

    /**
     * Colorize a node
     */
     public function colorize()
     {
         $this->colored = true;
     }

    /**
     * Low level binding for referencing node
     */
    protected function reference(...$nodes)
    {
        foreach ($nodes as $node) {
            if (!is_string($node) && $node->isReferenceable()) {
                $this->referenced_nodes[$node->getUID()] = $node;
                $this->reference(...array_values($node->referenced()));
            }
        }
    }
}

trait Props
{
    /**
   * Set a props usable in JavaScript
   */
  public function set_props(string $key, $value)
  {
      $this->props[$key] = $value;
      return $this;
  }

  /**
   * Get props
   */
   public function get_props(string $key)
   {
       return $this->props[$key];
   }

   /**
    * Get All props
    */
    public function get_all_props()
    {
        return $this->props;
    }
}

class Element
{
    // Use Props
  use Props;

  // Props
  protected $props;
  // UID
  protected $uid;

  /**
   * Construct a CLient's side element
   * @param props
   * @param uid
   * @param colored
   */
   public function __construct($uid, $props = [])
   {
       $this->uid = $uid;
       $this->props = $props;
   }

   /**
    * Return a string representation of the element
    * @return string
    */
    public function __toString() : string
    {
        return elements . '[' . $this->uid . ']';
    }
}
