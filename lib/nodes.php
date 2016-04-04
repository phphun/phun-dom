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
 * Abstract HTML's node representation
 */
abstract class Node {

    protected $name;
    protected $uniq_id;
    protected $content;
    protected $attributes;
    protected $data_attributes;

    public function __construct(string $name) {
        $this->name = $name;
        $this->uniq_id = \phun\utils\data_id($name);
        $this->content = [];
        $this->attributes = [];
        $this->data_attributes = [];
    }


    /**
     * Add an attribute to the node. Erase old attribute if exists
     * @param string key the name of the attribute
     * @param value the value of the attribute
     * @return return the current instance, for chaining operation
     */
    public function addAttribute(string $key, $value) {
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


}

