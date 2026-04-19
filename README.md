# PHPDocumentor Bootstrap Template

A clean and modern Bootstrap-based template for phpDocumentor, designed to improve readability, navigation, and overall developer experience.

[![PHP Version](https://img.shields.io/badge/php-^8.3-777BB4?logo=php&logoColor=white)](https://www.php.net/releases/)
[![Composer Package](https://img.shields.io/badge/composer-fast--forward%2Fphpdoc--bootstrap--template-F28D1A.svg?logo=composer&logoColor=white)](https://packagist.org/packages/fast-forward/phpdoc-bootstrap-template)
[![License](https://img.shields.io/github/license/php-fast-forward/phpdoc-bootstrap-template?color=64748B)](LICENSE)
[![GitHub Sponsors](https://img.shields.io/github/sponsors/php-fast-forward?logo=githubsponsors&logoColor=white&color=EC4899)](https://github.com/sponsors/php-fast-forward)

## Features

- Modern UI built with Bootstrap 5
- Improved navigation and layout
- Clean typography and spacing
- Enhanced "On this page" sidebar
- Better search UI integration
- Responsive and mobile-friendly
- Styled code blocks and documentation elements
- Improved tables of contents and element listings
- Automatic homepage redirect to the guides index when guides are available

## Installation

Install the template with Composer:

```bash
composer require --dev fast-forward/phpdoc-bootstrap-template
```

## Usage

Reference the template from vendor in your phpdoc.xml:

```xml
<?xml version="1.0" encoding="UTF-8" ?>
<phpdocumentor
    configVersion="3"
    xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
    xsi:noNamespaceSchemaLocation="https://docs.phpdoc.org/latest/phpdoc.xsd"
>
    <paths>
        <output>build/docs</output>
    </paths>

    <version number="1.0.0">
        <api>
            <source dsn=".">
                <path>src</path>
            </source>
        </api>
    </version>

    <template name="vendor/fast-forward/phpdoc-bootstrap-template" />
</phpdocumentor>
```

You can also generate documentation directly from the command line:

```bash
vendor/bin/phpdoc --template vendor/fast-forward/phpdoc-bootstrap-template
```

Or with a config file:

```bash
vendor/bin/phpdoc --config phpdoc.xml
```

## Requirements

- PHP 8.3+
- phpDocumentor 3+

## Customization

You can customize the template by overriding Twig files in your own project or by forking this package.

Typical customization points include:

- layout structure
- sidebar navigation
- search UI
- cards and content sections
- Bootstrap styling

## Contributing

Contributions are welcome. Please open an issue or submit a pull request.

## 📄 License

This package is licensed under the MIT License. See the [LICENSE](LICENSE) file for more details.
