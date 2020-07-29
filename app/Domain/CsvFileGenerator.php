<?php

declare(strict_types=1);

namespace App\Domain;

use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * This class will generate and stream a csv file to the browser. Why did I make the majority of the methods protected
 * when they could have easily been private? Unit testability without resorting to reflection methods. Of course I
 * didn't have time to actually write unit tests, but tried to structure the code to make it easier to do so.
 *
 * Class CsvFileGenerator
 * @package App\Domain
 */
class CsvFileGenerator
{
    const FILE_NAME = 'sample_user_import_file.csv';
    const NUMBER_OF_LINES = 15;

    private $fileHandler;

    /**
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function generateAndStreamFile(): StreamedResponse
    {
        return $this->buildNewStreamedResponse();
    }

    /**
     * Open stream file handler
     */
    protected function openFileHandler(): void
    {
        $this->fileHandler = fopen('php://output', 'w');
    }

    /**
     * Close stream file handler
     */
    protected function closeFileHandler(): void
    {
        fclose($this->fileHandler);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    protected function buildNewStreamedResponse(): StreamedResponse
    {
        return new StreamedResponse(function (){
            $this->openFileHandler();
            $this->writeContentHeaderLine();
            $this->generateData();
            $this->closeFileHandler();
        }, Response::HTTP_OK, $this->getResponseHeaders());
    }

    /**
     * Fill CSV file with data
     */
    protected function generateData(): void
    {
        $numLines = $this->getNumberOfLinesToGenerate();
        for($i=1; $i<=$numLines; $i++) {
            $this->generateDataLine($i);
        }
    }

    /**
     * @param int $line
     */
    protected function generateDataLine(int $line): void
    {
        $email = $this->provideNullValue() ? null : "email_$line@example.com";
        $firstName = $this->provideNullValue() ? null : "first_name_$line";
        $lastName = $this->provideNullValue() ? null : "last_name_$line";
        $postalCode = $this->provideNullValue() ? null : '92064';
        $optIn = $this->provideNullValue() ? null : $this->getRandomOptInValue();
        $tags = $this->provideNullValue() ? null : $this->buildTagLine($line);

        $this->writeLine([
            $email,
            $firstName,
            $lastName,
            $postalCode,
            $optIn,
            $tags
        ]);
    }

    /**
     * Method that in theory returns true 1/50 times called
     * @return bool
     */
    protected function provideNullValue(): bool
    {
        return (rand(1, 50) === 42);
    }

    /**
     * Method that in theory returns 'Yes' 50% of the time and 'No' 50% of the time
     * @return string
     */
    protected function getRandomOptInValue(): string
    {
        return (rand(1, 2) === 1 ? 'Yes' : 'No');
    }

    /**
     * @param int $line
     * @return string
     */
    protected function buildTagLine(int $line): string
    {
        return implode(',', [
            "TagA$line",
            "TagB$line",
            "TagC$line",
            "TagD$line",
            "TagE$line"
        ]);
    }

    /**
     * @return int
     */
    protected function getNumberOfLinesToGenerate(): int
    {
        return static::NUMBER_OF_LINES;
    }

    /**
     * Write the content header line (not response header)
     */
    protected function writeContentHeaderLine(): void
    {
        $this->writeLine([
            'Email',
            'First_Name',
            'Last_Name',
            'Postal_Code',
            'Opt_In',
            'Tags'
        ]);
    }

    /**
     * Write one line to file handler
     * @param array $data
     */
    protected function writeLine(array $data): void
    {
        fputcsv($this->fileHandler, $data);
    }

    /**
     * Return array of response headers
     * @return array|string[]
     */
    protected function getResponseHeaders(): array
    {
        return [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="'. static::FILE_NAME .'"',
        ];
    }
}
