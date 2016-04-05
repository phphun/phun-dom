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
 * Provide some tools using in "phun"
 * @author Van de Woestyne Xavier <xaviervdw@gmail.com>
 */
namespace phun\utils;

/**
 * Create a "potential" uniq ID for tag marks
 * @param string prefix : the prefix of the uniq ID (maybe the tag name)
 * @param string suffix : the suffix of the uniq ID (for more uniqness)
 * @return A String as a potential uniq ID (using for mark the dom)
 */
function data_id(string $prefix = '', string $suffix = null) : string {
    $suffix = $suffix ?? time();
    $prefix = ($prefix === '') ? $prefix : $prefix . '-';
    $suffix = ($suffix === '') ? $suffix : '-' . $suffix;
    return uniqid($prefix) . $suffix;
}
