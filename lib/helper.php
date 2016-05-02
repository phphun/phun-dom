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
namespace phun\html {

    use \phun\dom as D;

    /**
     * Add arr elements into raw
     * @param raw the parent node
     * @param an array with the childs
     * @return raw
     */
    function add($raw, $arr) {
      return $raw->append(...$arr);
    }

    /**
     * Create a CData node
     * @param string data; the raw text
     * @return a CDATA node
     */
    function cdata(string $data) {
        return new D\CDATA($data);
    }

    /**
     * Create a PCData node
     * @param string data; the raw text
     * @return a PCDATA node
     */
    function pcdata(string $data) {
        return new D\PCDATA($data);
    }

    /**
     * Create an HTML5 Document
     * @param $title the title of the page
     * @param $charset the charset of the page ('utf-8' by default)
     * @param $lang the lang of the page (by default 'en')
     */
    function document(string $title, string $charset = 'utf-8', string $lang = 'en') {
      return D\html($title, $charset, $lang);
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

    function unsafe_pcdata($elt) {
        if(is_string($elt)) return pcdata($elt);
        return $elt;
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

    /**
     * Create a Span element
     * @param List of element to insert into the tag
     */
    function span(...$n) : D\Inline {
        $nodes = array_map(function($e) { return unsafe_pcdata($e); }, $n);
        return D\span()->append(...$nodes);
    }

    /**
     * Create a Strong element
     * @param List of element to insert into the tag
     */
    function strong(...$n) : D\Inline {
        $nodes = array_map(function($e) { return unsafe_pcdata($e); }, $n);
        return D\strong()->append(...$nodes);
    }

    /**
     * Create a Small element
     * @param List of element to insert into the tag
     */
    function small(...$n) : D\Inline {
        $nodes = array_map(function($e) { return unsafe_pcdata($e); }, $n);
        return D\small()->append(...$nodes);
    }

    /**
     * Create a Sub element
     * @param List of element to insert into the tag
     */
    function sub(...$n) : D\Inline {
        $nodes = array_map(function($e) { return unsafe_pcdata($e); }, $n);
        return D\sub()->append(...$nodes);
    }

    /**
     * Create a Sup element
     * @param List of element to insert into the tag
     */
    function sup(...$n) : D\Inline {
        $nodes = array_map(function($e) { return unsafe_pcdata($e); }, $n);
        return D\sup()->append(...$nodes);
    }

    /**
     * Create an U element
     * @param List of element to insert into the tag
     */
    function u(...$n) : D\Inline {
        $nodes = array_map(function($e) { return unsafe_pcdata($e); }, $n);
        return D\u()->append(...$nodes);
    }

    /**
     * Create an I element
     * @param List of element to insert into the tag
     */
    function i(...$n) : D\Inline {
        $nodes = array_map(function($e) { return unsafe_pcdata($e); }, $n);
        return D\i()->append(...$nodes);
    }

    /**
     * Create a B element
     * @param List of element to insert into the tag
     */
    function b(...$n) : D\Inline {
        $nodes = array_map(function($e) { return unsafe_pcdata($e); }, $n);
        return D\b()->append(...$nodes);
    }

    /**
     * Create an Iframe element
     * @param string src the target Document
     * @param string alt the message if browser doesn't support iframe
     */
    function iframe(string $src,
        string $alt = "Your browser does not support iframe") : D\Inline {
        return D\iframe()
            ->where('src', $src)
            ->append(pcdata($alt));
    }

    /**
     * Create <base href target> element
     * @param $href the uri of the base
     * @param $target the navigation context of the base, _self by default
     * @return <base> element
     */
    function base(string $href, string $target = '_self') {
      return D\base()
        ->where('href', $href)
        ->where('target', $target);
    }

    /**
     * Create a <link rel type href> element
     * @param $rel the relationship of the link
     * @param $type the mime type of the document
     * @param $href the location of the linked document
     * @return <link> element
     */
    function link(string $rel, string $type, string $href) {
      return D\link()
        ->where('rel', $rel)
        ->where('type', $type)
        ->where('href', $href);
    }

    /**
     * Create a <link rel="stylesheet" type="text/css" $href> element
     * @param $href
     * @return <link> element
     */
    function link_css(string $href) {
      return link('stylesheet', 'text/css', $href);
    }

    /**
     * Create a <meta name content> element
     * @param $name the name of the meta
     * @param $content the content of the meta
     * @return <meta name content>
     */
    function meta(string $name, string $content) {
      return D\meta()
        ->where('name', $name)
        ->where('content', $content);
    }

    /**
     * Create a <meta charset>  element
     * @param $charset the desired charset
     * @return <meta charset>
     */
    function charset(string $charset) {
      return D\meta()
        ->where('charset', $charset);
    }

    /**
     * Create a <meta http-equiv content> element
     * @param $equiv
     * @param $content
     * @return <meta http-equiv content> element
     */
    function http_equiv(string $equiv, $content) {
      return D\meta()
        ->where('http-equiv', $equiv)
        ->where('content', (string) $content);
    }

    /**
     * Create a <noscript>$content</noscript> element
     * @param $content
     * @return <noscript> element
     */
    function noscript(string $content = 'JavaScript not allowed') {
      return D\noscript()->append($content);
    }

    /**
     * Create a <script>$src</script> element
     * @param $src
     * @return <script> element
     */
    function script(string $src) {
      return D\script()->append($src);
    }

    /**
     * Create a <script src=$src type=$type> element
     * @param $src
     * @param $type (by default text/javascript)
     * @return <script>
     */
    function external_script(string $src, string $type = 'text/javascript') {
      return D\script()
        ->where('src', $src)
        ->where('type', $type);
    }

    /**
     * Create a <script src=$src type=$type async> element
     * @param $src
     * @param $type (by default text/javascript)
     * @return <script>
     */
    function async_script(string $src, string $type = 'text/javascript') {
      return external_script($src, $type)->where('async');
    }

    /**
     * Create a <script src=$src type=$type defer> element
     * @param $src
     * @param $type (by default text/javascript)
     * @return <script>
     */
    function defer_script(string $src, string $type = 'text/javascript') {
      return external_script($src, $type)->where('defer');
    }

    /**
     * Create a <style $type ?$media ?$scoped>$content</style> element
     * @param $type
     * @param $content
     * @param $media the media query
     * @param $scoped
     * @return <style>
     */
    function style(string $type, string $content, string $media = null, $scoped = false) {
      $style = D\style();
      if (is_string($media)) {
        $style->where('media', $media);
      }
      if ($scoped === true) {
        $style->where('scoped');
      }
      $style->append($content);
      return $style;
    }

    /**
     * Create a <style type=css ?$media ?$scoped>$content</style> element
     * @param $content
     * @param $media the media query
     * @param $scoped
     * @return <style>
     */
    function style_css(string $content, string $media = null, $scoped = false) {
      return style('text/css', $content, $media, $scoped);
    }

}
