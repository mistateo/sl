<?php

namespace App\Http\Controllers;

use App\Domain\CsvFileGenerator;
use App\Domain\CsvFileUploader;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class CsvFileController extends Controller
{
    /**
     * @var \App\Domain\CsvFileGenerator
     */
    private $csvFileGenerator;

    private $csvFileUploader;

    /**
     * TODO::investigate alternate methods of dependency injection. This seems inefficient.
     *
     * CsvFileController constructor.
     * @param \App\Domain\CsvFileGenerator $csvFileGenerator
     * @param \App\Domain\CsvFileUploader $csvFileUploader
     */
    public function __construct(CsvFileGenerator $csvFileGenerator, CsvFileUploader $csvFileUploader)
    {
        $this->csvFileGenerator = $csvFileGenerator;
        $this->csvFileUploader = $csvFileUploader;
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(): View
    {
        $data = [];
        return view('csv_file', $data);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function generateCsvFile(): StreamedResponse
    {
        return $this->csvFileGenerator->generateAndStreamFile();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function uploadCsvFile(Request $request)
    {
        return back()->with('success','File Upload Success.');
    }
}
