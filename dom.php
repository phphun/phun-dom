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

namespace phun;


// Library inclusion
require_once 'lib/utils.php';
require_once 'lib/javascript_sandbox.php';
require_once 'lib/nodes.php';
require_once 'lib/dom.php';
require_once 'lib/helper.php';

$t = filemtime('.');

$p = html\span('Hello World');
$p->id = 'a_special_span';

$form = html\select('hello',
  html\option('yo', 'il faut dire YO'),
  html\option('yé', 'il faut dire Yé'),
  html\optgroup('Yeeee',
    html\option('yé2', 'il faut dire Yé 2x'),
    html\option('yo2', 'il faut dire YO 2x')
  )
);

$page = html\document('Hello World');
$page->body()->append(
  $p,
  html\br(),
  html\span($p->id),
  html\br(),
  html\time(time(), 'today !'),
  html\button('yoo'),
  html\br(),
  html\progress('a', 12.0, 24.0),
  html\meter('b', 50.0),
  html\unsafe_tag('pre')->append(
    html\unsafe_leaf('hr')
  ),
  html\img("http://www.warparadise.com/contenu/avatar/23017_mini-Jabba_the_Hutt.png"),
  html\input('text', 'test', '')->where('placeholder', 'uh'),
  html\textarea('test', 'yolow'),
  html\form('get', 'dom.php')->append($form),
  html\util\select('select', [
    'a' => 'A',
    'b' => 'C'
  ]),
  html\util\completable_input('autocomplete', [
    'Firefox', 'Google Chrome', 'Safari', 'Vivaldi'
  ])
);

echo $page;
