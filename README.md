# sy/html

HTML components

## Installation

Install the latest version with

```bash
$ composer require sy/html
```

## Basic Usage

```php
<?php

use Sy\Component\Html\Page;

$page = new Page();
$page->setTitle('Page example');
$page->setBody('Hello world!');
echo $page;
```

Outpu:
```html
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<title>Page example</title>
</head>
<body>
Hello world!
</body>
</html>
```