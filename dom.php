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

namespace phun;

// Library inclusion
require_once 'lib/utils.php';
require_once 'lib/javascript_sandbox.php';
require_once 'lib/nodes.php';
require_once 'lib/html.php';
require_once 'lib/helper.php';

// Temp examples

$html = dom\html('Hello World');
$body = $html->body();

$body->append(HTML\ol(
    HTML\pcdata("Hello World"),
    HTML\pcdata("Hello foo"),
    HTML\li(dom\cdata("<strong>Yo</strong>")),
    HTML\span("yo")
));


echo $html;
?>
