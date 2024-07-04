<?php

namespace App\Http\Controllers;

use App\Http\Requests\FileRequest;
use Illuminate\Support\Facades\File as FileFacade;
use Illuminate\Support\Str;
use App\Models\File;
use ZipArchive;

class FileController extends Controller
{
    /**
     * Upload the files
     */
    public function upload(FileRequest $request)
    {
        $fileName = Str::uuid() . '.' . $request->file->extension();

        try {
            $request->file->move(public_path('uploads'), $fileName);

            $file = File::create([
                'ip' => request()->ip(),
                'name' => $request->file->getClientOriginalName(),
                'source' => $fileName
            ]);
        } catch (\Exception $e) {
            // If an error occurs, delete the moved file
            if (FileFacade::exists(public_path('uploads') . '/' . $fileName)) {
                FileFacade::delete(public_path('uploads') . '/' . $fileName);
            }

            return response()->errorMessage('Uploading Failed !');
        }

        return response()->success([
            'file' => [
                'id' => $file->id,
                'name' => $file->name,
                'source' => $file->source
            ]
        ]);
    }

    /**
     * Delete the file
     */
    public function delete(string $id)
    {
        $file = File::where([
            'id' => $id,
            'ip' => request()->ip()
        ])->first();

        if ($file) {
            $filePath = public_path('uploads/' . $file->source);

            // Delete file if exists
            if (FileFacade::exists($filePath)) {
                FileFacade::delete($filePath);
            }

            $file->delete();
            return response()->successMessage('File Deleted Successfully !');
        }

        return response()->errorMessage('File not found !');
    }

    /**
     * Delete all uploaded files
     */
    public function deleteAll()
    {
        $files = File::where('ip', request()->ip())->get();

        foreach ($files as $file) {
            $filePath = public_path('uploads/' . $file->source);

            // Delete file if exists
            if (FileFacade::exists($filePath)) {
                FileFacade::delete($filePath);
            }
        }

        // Delete records from database
        File::where('ip', request()->ip())->delete();
        return response()->successMessage('Files Deleted Successfully !');
    }

    /**
     * Downlaod All files
     */
    public function downloadAll()
    {
        // Fetch the list of files based on IP address
        $files = File::where('ip', request()->ip())->pluck('source')->toArray();

        // Create a temporary file to store the zip archive
        $zipFileName = 'files.zip';
        $zipFilePath = public_path('uploads/' . $zipFileName);

        // Initialize ZipArchive
        $zip = new ZipArchive;

        if ($zip->open($zipFilePath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
            // Add each file to the zip archive
            foreach ($files as $file) {
                $filePath = public_path('uploads/' . $file);

                if (file_exists($filePath)) {
                    $zip->addFile($filePath, basename($file));
                }
            }
            $zip->close();
        } else {
            return response()->json(['error' => 'Failed to create zip file'], 500);
        }

        // Prepare the response for downloading the zip file
        return response()->download($zipFilePath)->deleteFileAfterSend(true);
    }
}
