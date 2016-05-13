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
     * Create a generic and unsafe tag
     * @param string the tag name
     * @return an unsafe tag
     */
    function unsafe_tag(string $name) {
      return new D\UnsafeBlock($name);
    }

    /**
     * Create a generic and unsafe leaf
     * @param string the tag name
     * @return an unsafe leaf
     */
    function unsafe_leaf(string $name) {
      return new D\UnsafeLeaf($name);
    }

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
    function img(string $src, string $alt = 'An image') : D\InlineLeaf {
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
     * Create an em element
     * @param List of element to insert into the tag
     */
    function em(...$n) : D\Inline {
        $nodes = array_map(function($e) { return unsafe_pcdata($e); }, $n);
        return D\em()->append(...$nodes);
    }

    /**
     * Create a Bdo element
     * @param List of element to insert into the tag
     */
    function bdo(...$n) : D\Inline {
        $nodes = array_map(function($e) { return unsafe_pcdata($e); }, $n);
        return D\bdo()->append(...$nodes);
    }

    /**
     * Create a Bdi element
     * @param List of element to insert into the tag
     */
    function bdi(...$n) : D\Inline {
        $nodes = array_map(function($e) { return unsafe_pcdata($e); }, $n);
        return D\bdi()->append(...$nodes);
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

    /**
     * Create a <title>$title</title> element
     * @param $title
     * @return <title> element
     */
    function title(string $title) {
      return D\title($title);
    }

    /**
     * create <a href=$href>$content</a> element
     * @param $href
     * @param $content
     * @return <a> element
     */
    function a(string $href, ...$content) {
      $nodes = array_map(function($e) { return unsafe_pcdata($e); }, $content);
      return D\a()
        ->where('href', $href)
        ->append(...$nodes);
    }

    /**
     * Create an abbreviation element
     * @param string the content (abbriged word)
     * @param string the sense of the abbrev
     * @return <abbr> element
     */
    function abbr(string $content, string $abbrv) {
      return D\abbr($content, $abbrv);
    }

    /**
     * Create an <area $shape $coords $href $alt>
     * @param $shape
     * @param $coords an array
     * @param $href
     * @param $alt
     * @return <area> element
     */
    function area(string $shape, string $href, $coords, string $alt = '') {
      $c = join(',', $coords);
      return D\area()
        ->where('shape', $shape)
        ->where('coords', $c)
        ->where('href', $href)
        ->where('alt', $alt);
    }

    /**
     * Create a rect area
     */
    function rect_area(string $href, $x1, $y1, $x2, $y2, string $alt = '') {
      return area('rect', $href, [$x1, $y1, $x2, $y2], $alt);
    }

    /**
     * Create a circle area
     */
    function circle_area(string $href, $x, $y, $radius, string $alt = '') {
      return area('circle', $href, [$x, $y, $radius], $alt);
    }

    /**
     * Create a Poly Area
     */
    function poly_area(string $href, $coords, string $alt = '') {
      return area('poly', $href, $coords, $alt);
    }

    /**
     * Create <var>$content</var> element
     * @param $content
     * @return <var> element
     */
    function _var(string $content) {
      return D\_var($contenr);
    }

    /**
     * Create a <time $datetime>$content</time> element
     * @param $datetime string or timestamp
     * @param $content
     * @return <time> element
     */
    function time($datetime, string $content) {
      if(!is_string($datetime)) {
        $datetime = date('Y-m-d H:i', $datetime);
      }
      return D\time($content)->where('datetime', $datetime);
    }

    /**
     * Create an <address>$1 $2 $3</adress> element
     * @param $content list (...) of body
     * @return <adress> element
     */
    function address(...$n) {
      $nodes = array_map(function($e) { return unsafe_pcdata($e); }, $n);
      return D\address()->append(...$nodes);
    }

    /**
     * Create an <article>$1 $2 $3</article> element
     * @param $content list (...) of body
     * @return <article> element
     */
    function article(...$n) {
      $nodes = array_map(function($e) { return unsafe_pcdata($e); }, $n);
      return D\article()->append(...$nodes);
    }

    /**
     * Create an <aside>$1 $2 $3</aside> element
     * @param $content list (...) of body
     * @return <aside> element
     */
    function aside(...$n) {
      $nodes = array_map(function($e) { return unsafe_pcdata($e); }, $n);
      return D\aside()->append(...$nodes);
    }

    /**
     * Create an <div>$1 $2 $3</div> element
     * @param $content list (...) of body
     * @return <div> element
     */
    function div(...$n) {
      $nodes = array_map(function($e) { return unsafe_pcdata($e); }, $n);
      return D\div()->append(...$nodes);
    }

    /**
     * Create an <pre>$1 $2 $3</pre> element
     * @param $content list (...) of body
     * @return <pre> element
     */
    function pre(...$n) {
      $nodes = array_map(function($e) { return unsafe_pcdata($e); }, $n);
      return D\pre()->append(...$nodes);
    }

    /**
     * Create an <footer>$1 $2 $3</footer> element
     * @param $content list (...) of body
     * @return <footer> element
     */
    function footer(...$n) {
      $nodes = array_map(function($e) { return unsafe_pcdata($e); }, $n);
      return D\footer()->append(...$nodes);
    }

    /**
     * Create an <header>$1 $2 $3</header> element
     * @param $content list (...) of body
     * @return <header> element
     */
    function header(...$n) {
      $nodes = array_map(function($e) { return unsafe_pcdata($e); }, $n);
      return D\header()->append(...$nodes);
    }

    /**
     * Create an <section>$1 $2 $3</section> element
     * @param $content list (...) of body
     * @return <section> element
     */
    function section(...$n) {
      $nodes = array_map(function($e) { return unsafe_pcdata($e); }, $n);
      return D\section()->append(...$nodes);
    }

    /**
     * Create an <nav>$1 $2 $3</nav> element
     * @param $content list (...) of body
     * @return <nav> element
     */
    function nav(...$n) {
      $nodes = array_map(function($e) { return unsafe_pcdata($e); }, $n);
      return D\nav()->append(...$nodes);
    }

    /**
     * Create an <main>$1 $2 $3</main> element
     * @param $content list (...) of body
     * @return <main> element
     */
    function main(...$n) {
      $nodes = array_map(function($e) { return unsafe_pcdata($e); }, $n);
      return D\main()->append(...$nodes);
    }

    /**
     * Create an <p>$1 $2 $3</p> element
     * @param $content list (...) of body
     * @return <p> element
     */
    function p(...$n) {
      $nodes = array_map(function($e) { return unsafe_pcdata($e); }, $n);
      return D\p()->append(...$nodes);
    }

    /**
     * Create an <mark>$1 $2 $3</mark> element
     * @param $content list (...) of body
     * @return <mark> element
     */
    function mark(...$n) {
      $nodes = array_map(function($e) { return unsafe_pcdata($e); }, $n);
      return D\mark()->append(...$nodes);
    }

    /**
     * Create an <h1>$1 $2 $3</h1> element
     * @param $content list (...) of body
     * @return <h1> element
     */
    function h1(...$n) {
      $nodes = array_map(function($e) { return unsafe_pcdata($e); }, $n);
      return D\h1()->append(...$nodes);
    }

    /**
     * Create an <h2>$1 $2 $3</h2> element
     * @param $content list (...) of body
     * @return <h2> element
     */
    function h2(...$n) {
      $nodes = array_map(function($e) { return unsafe_pcdata($e); }, $n);
      return D\h2()->append(...$nodes);
    }

    /**
     * Create an <h3>$1 $2 $3</h3> element
     * @param $content list (...) of body
     * @return <h3> element
     */
    function h3(...$n) {
      $nodes = array_map(function($e) { return unsafe_pcdata($e); }, $n);
      return D\h3()->append(...$nodes);
    }

    /**
     * Create an <h4>$1 $2 $3</h4> element
     * @param $content list (...) of body
     * @return <h4> element
     */
    function h4(...$n) {
      $nodes = array_map(function($e) { return unsafe_pcdata($e); }, $n);
      return D\h4()->append(...$nodes);
    }

    /**
     * Create an <h5>$1 $2 $3</h5> element
     * @param $content list (...) of body
     * @return <h5> element
     */
    function h5(...$n) {
      $nodes = array_map(function($e) { return unsafe_pcdata($e); }, $n);
      return D\h5()->append(...$nodes);
    }

    /**
     * Create an <h6>$1 $2 $3</h6> element
     * @param $content list (...) of body
     * @return <h6> element
     */
    function h6(...$n) {
      $nodes = array_map(function($e) { return unsafe_pcdata($e); }, $n);
      return D\h6()->append(...$nodes);
    }

    /**
     * Create an <blockquote>$1 $2 $3</blockquote> element
     * @param $content list (...) of body
     * @return <blockquote> element
     */
    function blockquote(...$n) {
      $nodes = array_map(function($e) { return unsafe_pcdata($e); }, $n);
      return D\blockquote()->append(...$nodes);
    }

    /**
     * Create an <audio> element
     * @param $src
     * @param $controls
     * @param $msg
     * @todo append multiple source support
     * @return <audio> element
     */
    function audio(string $src,
      $controls = true,
      $msg = 'Your user agent does not support the HTML5 Audio element') {
      $audio = D\audio()->where('src', $src);
      if ($controls) {
        $audio->where('controls');
      }
      return $audio->append(D\pcdata($msg));
    }

    /**
     * Create a <video> element
     * @param $src
     * @param $controls
     * @param $msg
     * @todo append multiple source support
     * @return <video> element
     */
    function video(string $src,
      $controls = true,
      $msg = 'Your user agent does not support the HTML5 Video element') {
      $video = D\video()->where('src', $src);
      if ($controls) {
        $video->where('controls');
      }
      return $video->append(D\pcdata($msg));
    }

    /**
     * Create a <map $name>...$content</map> element
     * @param $name
     * @param $content list (...) of body
     * @return <map> element
     */
    function map(string $name, ...$content) {
      return D\map()->where('name', $name)->append(...$content);
    }

    /**
     * Create <br> element
     * @return <br> element
     */
    function br() {
      return D\br();
    }

    /**
     * Create <hr> element
     * @return <hr> element
     */
    function hr() {
      return D\hr();
    }

    /**
     * Create <wbr> element
     * @return <wbr> element
     */
    function wbr() {
      return D\wbr();
    }

    /**
     * create <button>$value</button>
     * @param $value
     * @return <button> element
     */
    function button(string $value) {
      return D\button()
        ->where('type', 'button')
        ->append(D\pcdata($value));
    }

    /**
     * Create <canvas $id>$message</canvas> element
     * @param $id
     * @param $message
     * @return <canvas> element
     */
    function canvas(
      string $id, string
      $message = 'Your browser does not support Canvas') {
      return D\canvas()->id($id)->append(D\pcdata($message));
    }

    /**
     * Create <cite>$nodes</cite>
     * @param $nodes
     * @return <cite> element
     */
    function cite(string $n) {
      $nodes = array_map(function($e) { return unsafe_pcdata($e); }, $n);
      return D\cite()->append(...$nodes);
    }

    /**
     * Create <code>$nodes</code>
     * @param $nodes
     * @return <code> element
     */
    function code(string $n) {
      $nodes = array_map(function($e) { return unsafe_pcdata($e); }, $n);
      return D\code()->append(...$nodes);
    }


    /**
     * create <data $value> element
     * @param $value
     * @return <data>
     */
    function data(string $value) {
      return D \data($value);
    }

    /**
     * create <del>$1 $2 $3</del> element
     * @param $n nodes list
     * @return <del> element
     */
    function del(...$n) {
      $nodes = array_map(function($e) { return unsafe_pcdata($e); }, $n);
      return D\del()->append(...$nodes);
    }

    /**
     * create <del $datetime>$1 $2 $3</del> element
     * @param $datetime (could be string or time())
     * @param $n nodes list
     * @return <del> element
     */
    function del_when($datetime, ...$n) {
      if(!is_string($datetime)) {
        $datetime = date('Y-m-d H:i', $datetime);
      }
      return del(...$n)->where('datetime', $datetime);
    }

    /**
     * create <q>$1 $2 $3</q> element
     * @param $n nodes list
     * @return <q> element
     */
    function q(...$n) {
      $nodes = array_map(function($e) { return unsafe_pcdata($e); }, $n);
      return D\q()->append(...$nodes);
    }

    /**
     * create <dfn $title>$n</dfn> element
     * @param $title
     * @param $nodes
     * @return <dfn>
     */
    function dfn(string $title, ...$n) {
      $nodes = array_map(function($e) { return unsafe_pcdata($e); }, $n);
      return D\dfn()->where('title', $title)->append(...$nodes);
    }

    /**
     * Create <form $method $action> element
     * @param $method
     * @param $action
     * @return <form> element
     */
    function form(string $method, string $action) {
      return D\form()
        ->where('method', $method)
        ->where('action', $action);
    }

    /**
     * Create <fieldset>$1 $2 $3</fieldset> element
     * @param $nodes
     * @return <fieldset> element
     */
    function fieldset(...$n) {
      $nodes = array_map(function($e) { return unsafe_pcdata($e); }, $n);
      return D\fieldset()->append(...$nodes);
    }

    /**
     * create <label $for>...$content</label>
     * @param string for
     * @param $nodes
     * @return <label> element
     */
    function label(string $for, ...$content) {
      return D\label()->where('for', $for)->append(...$content);
    }

    /**
     * Create <legend>$1 $2 $3</legend> element
     * @param $nodes
     * @return <legend> element
     */
    function legend(...$n) {
      $nodes = array_map(function($e) { return unsafe_pcdata($e); }, $n);
      return D\legend()->append(...$nodes);
    }

    /**
     * Create <input $type $name $value> element
     * @param $type
     * @param $name
     * @param $value
     * @return <input> element
     */
    function input(string $type, string $name, string $value = '') {
      return D\input()
        ->where('type', $type)
        ->where('name', $name)
        ->where('value', $value);
    }

    /**
     * Create <textarea $name>$text</textarea>
     * @param $name
     * @param $text
     * @return <textarea> element
     */
    function textarea(string $name, string $txt) {
      return D\textarea()->where('name', $name)->append(pcdata($txt));
    }

    /**
     * Create <keygen $name> element
     * @param $name
     * @return <keygen> elementa
     */
    function keygen(string $name) {
      return D\keygen()->where('name', $name);
    }

    /**
     * Create <output $name $for>$nodes</output>
     * @param $name
     * @param $for
     * @param ...$nodes
     * @return <output> element
     */
    function output(string $name, string $for, ...$n) {
      $nodes = array_map(function($e) { return unsafe_pcdata($e); }, $n);
      return D\output()
        ->where('name', $name)
        ->where('for', $for)
        ->append(...$nodes);
    }

    /**
     * Create <progress $name $value $max></progress> Element
     * @param string name
     * @param float value
     * @param float max
     * @return <progress> element
     */
    function progress(string $name, float $value, float $max = 100.0) {
      $value = (string) $value;
      $max = (string) $max;
      return D\progress()
        ->where('name', $name)
        ->where('value', $value)
        ->where('max', $max);
    }

    /**
     * Create <progress $name $value $max></progress> Element
     * @param string name
     * @param float value
     * @param float min
     * @param float max
     * @return <progress> element
     */
    function meter(string $name, float $value, float $min = 0.0, float $max = 100.0) {
      $value = (string) $value;
      $min = (string) $min;
      $max = (string) $max;
      return D\meter()
        ->where('name', $name)
        ->where('value', $value)
        ->where('min', $min)
        ->where('max', $max);
    }

}
