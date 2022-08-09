<?php
namespace App\Http\Controllers;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

use League\CommonMark\Inline\Element\Strong;

class AttachmentController extends Controller
{
    //localhost:8088/download_public/?file=yvan.jpg
    /**
     * Retrieve file from storage
     * @param string $attachment_name
     * @return mixed
     */
    public function downloadLocalFile(Request $request) {
        
        if(Storage::disk('local')->exists("customers/$request->file")) {
        
            $path = Storage::disk('local')->path("customers/$request->file");
            $content = file_get_contents($path);
            //ob_end_clean();
            return response($content)->withHeaders(['Content-Type' => mime_content_type($path)]);
        }
        return redirect('/404');
    }

    /**
         * Retrieve file from storage
         * @param string $attachment_name
         * @return mixed
         */
        public function downloadPublicFile(Request $request) {
        
            if(Storage::disk('public')->exists("customers/$request->file")) {
        
                $path = Storage::disk('public')->path("customers/$request->file");
                $content = file_get_contents($path);
                //ob_end_clean();
                return response($content)->withHeaders(['Content-Type' => mime_content_type($path)]);
            }
            return redirect('/404');
        }
}
