<?php

namespace CeytekLabs\PhpSpreadsheetLite;

use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as XlsxReader;
use PhpOffice\PhpSpreadsheet\Reader\Csv as CsvReader;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx as XlsxWriter;
use PhpOffice\PhpSpreadsheet\Writer\Csv as CsvWriter;

class PhpSpreadsheetLite
{
    private array $headers;

    private array $content;

    private string $directory;

    private string $filename;

    private SpreadsheetFormat $fileFormat;

    public static function make(): self
    {
        return new self;
    }

    public function setHeaders(array $headers): self
    {
        $this->headers = [$headers];

        return $this;
    }

    public function setContent(array $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function setDirectory(string $directory): self
    {
        $this->directory = $directory;

        return $this;
    }

    public function setFilename(string $filename): self
    {
        $this->filename = $filename;

        return $this;
    }

    public function setFileFormat(SpreadsheetFormat $fileFormat): self
    {
        $this->fileFormat = $fileFormat;

        return $this;
    }

    public function createSpreadsheet(): array
    {
        if (!isset($this->headers)) {
            throw new \Exception('Headers are empty');
        }

        if (!isset($this->content)) {
            throw new \Exception('Content is empty');
        }

        if (!isset($this->directory)) {
            throw new \Exception('Directory is empty');
        }

        if (!isset($this->filename)) {
            throw new \Exception('Filename is empty');
        }

        if (!isset($this->fileFormat)) {
            throw new \Exception('File format is empty');
        }

        $data = array_merge($this->headers, $this->content);

        $spreadsheet = new Spreadsheet;

        $sheet = $spreadsheet->getActiveSheet();

        foreach ($data as $rowIndex => $row) {
            foreach ($row as $cellIndex => $cell) {
                $cellAddress = Coordinate::stringFromColumnIndex(intval($cellIndex) + 1).(intval($rowIndex) + 1);

                $sheet->setCellValue($cellAddress, $cell);
            }
        }

        if (!file_exists($this->directory)) {
            mkdir($this->directory, 0777, true);
        }

        switch ($this->fileFormat) {
            case SpreadsheetFormat::CSV:
                $writer = new CsvWriter($spreadsheet);
                break;
            case SpreadsheetFormat::XLSX:
                $writer = new XlsxWriter($spreadsheet);
                break;
            default:
                throw new \Exception('Unsupported format: '.$this->fileFormat->value);
        }

        $filePath = $this->directory.'/'.$this->filename.'.'.$this->fileFormat->value;

        $writer->save($filePath);

        return ['file_path' => $filePath];
    }

    public function readSpreadsheet(): array
    {
        if (!isset($this->directory)) {
            throw new \Exception('Directory is empty');
        }

        if (!isset($this->filename)) {
            throw new \Exception('Filename is empty');
        }

        if (!isset($this->fileFormat)) {
            throw new \Exception('File format is empty');
        }

        switch ($this->fileFormat) {
            case SpreadsheetFormat::CSV:
                $reader = new CsvReader;
                break;
            case SpreadsheetFormat::XLSX:
                $reader = new XlsxReader;
                break;
            default:
                throw new \Exception('Unsupported file format: '.$this->fileFormat);
        }

        $filePath = $this->directory.'/'.$this->filename.'.'.$this->fileFormat->value;

        $spreadsheet = $reader->load($filePath);

        $sheet = $spreadsheet->getActiveSheet();

        $data = [];

        foreach ($sheet->getRowIterator() as $row) {
            $cellIterator = $row->getCellIterator();

            $cells = [];

            foreach ($cellIterator as $cell) {
                $cells[] = $cell->getValue();
            }

            $data[] = $cells;
        }

        return $data;
    }
}
