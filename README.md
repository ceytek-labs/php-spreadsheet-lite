<p align="center">
    <img src="https://raw.githubusercontent.com/ceytek-labs/php-spreadsheet-lite/refs/heads/1.x/art/banner.png" width="400" alt="FtpDownloader - Simple FTP File Downloader">
    <p align="center">
        <a href="https://packagist.org/packages/ceytek-labs/php-spreadsheet-lite"><img alt="Total Downloads" src="https://img.shields.io/packagist/dt/ceytek-labs/php-spreadsheet-lite"></a>
        <a href="https://packagist.org/packages/ceytek-labs/php-spreadsheet-lite"><img alt="Latest Version" src="https://img.shields.io/packagist/v/ceytek-labs/php-spreadsheet-lite"></a>
        <a href="https://packagist.org/packages/ceytek-labs/php-spreadsheet-lite"><img alt="Size" src="https://img.shields.io/github/repo-size/ceytek-labs/php-spreadsheet-lite"></a>
        <a href="https://packagist.org/packages/ceytek-labs/php-spreadsheet-lite"><img alt="License" src="https://img.shields.io/packagist/l/ceytek-labs/php-spreadsheet-lite"></a>
    </p>
</p>

------

# PhpSpreadsheetLite - Lightweight Spreadsheet Utility

**PhpSpreadsheetLite** is a lightweight library designed to simplify creating and reading spreadsheets in CSV or XLSX formats using [PhpSpreadsheet](https://github.com/PHPOffice/PhpSpreadsheet). It provides an intuitive API for quick and efficient spreadsheet operations.

## Requirements

- PHP 8.1 or higher
- PhpSpreadsheet library (automatically installed via Composer)

## Installation

Install the package via Composer. This will also install **phpoffice/phpspreadsheet** automatically:

```bash
composer require ceytek-labs/php-spreadsheet-lite
```

## Usage

Here’s an example of how to use **PhpSpreadsheetLite**:

### Creating and Saving a Spreadsheet

```php
use CeytekLabs\PhpSpreadsheetLite\PhpSpreadsheetLite;
use CeytekLabs\PhpSpreadsheetLite\SpreadsheetFormat;

try {
    PhpSpreadsheetLite::make()
        ->setHeaders(['ID', 'Name', 'Email']) // Set the headers
        ->setContent([
            [1, 'John Doe', 'john.doe@example.com'],
            [2, 'Jane Smith', 'jane.smith@example.com'],
        ]) // Add your data
        ->setDirectory('/path/to/save') // Specify directory
        ->setFilename('example') // Specify file name
        ->setFileFormat(SpreadsheetFormat::XLSX) // Supported formats: XLSX, CSV
        ->createSpreadsheet();

    echo "Spreadsheet created successfully.";
} catch (\Exception $exception) {
    echo "Error: " . $exception->getMessage();
}
```

### Reading a Spreadsheet

```php
use CeytekLabs\PhpSpreadsheetLite\PhpSpreadsheetLite;
use CeytekLabs\PhpSpreadsheetLite\SpreadsheetFormat;

try {
    $data = PhpSpreadsheetLite::make()
        ->setDirectory('/path/to/spreadsheet') // Specify directory
        ->setFilename('example') // Specify file name
        ->setFileFormat(SpreadsheetFormat::XLSX) // Match the file format
        ->readSpreadsheet();

    print_r($data);
} catch (\Exception $exception) {
    echo "Error: " . $exception->getMessage();
}
```

### Enum for File Formats

The **SpreadsheetFormat** enum helps you specify supported file formats consistently:

```php
enum SpreadsheetFormat: string
{
    case XLSX = 'xlsx';
    case CSV = 'csv';
}
```

## Contributing

Feel free to submit a **pull request** or report an issue. Any contributions and feedback are highly appreciated!

## License

This project is licensed under the MIT License.