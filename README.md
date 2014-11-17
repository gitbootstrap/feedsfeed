# feedsfeed

Combine multiple RSS feeds into one

## Installation

1. Clone the repository `git clone https://github.com/gitbootstrap/feedsfeed`
2. Install [Composer](https://getcomposer.org) dependencies `composer install`
3. Install [npm](https://www.npmjs.org/) dependencies `npm install`
4. Run build task `gulp make`

## Configuration

All settings can be made inside `config.php`

## feeds.json

By default, the feeds are loaded from `feeds.json` (name and location can be modified). Here's a look at what this file can look like.

```json
[  
  {  
    "name":    "Bootstrap",
    "website": "https://getbootstrap.com",
    "channel": {
      "commits":  "https://github.com/twbs/bootstrap/master.atom",
      "releases": "https://github.com/twbs/bootstrap/releases.atom"
    }
  },
  {  
    "name":    "Font Awesome",
    "website": "http://fontawesome.io",
    "channel": {
      "commits":  "https://github.com/FortAwesome/Font-Awesome/commits/master.atom",
      "releases": "https://github.com/FortAwesome/Font-Awesome/releases.atom"
    }
  },
]
```

The important key is `channel`, which can contain any number of sub-keys. The default channel is defined in `config.php`.

## License

The MIT License (MIT)

Copyright (c) 2014 Jan T. Sott

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.