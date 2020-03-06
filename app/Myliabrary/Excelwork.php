<?php
namespace blog\Myliabrary;

use blog\Http\Requests;
use Illuminate\Http\Request;
use Input;
use blog\Post;
use DB;
use Session;
use Excel;

class ExcelController extends Controller
{
    public function importExport()
    {
        return view('importExport');
    }
    public function downloadExcel($type)
    {
        $data = Post::get()->toArray();
        return Excel::create('laravelcode', function($excel) use ($data) {
            $excel->sheet('mySheet', function($sheet) use ($data)
            {
                $sheet->fromArray($data);
            });
        })->download($type);
    }
    public function importExcel(Request $request)
    {
        if($request->hasFile('import_file')){
            Excel::load($request->file('import_file')->getRealPath(), function ($reader) {
                foreach ($reader->toArray() as $key => $row) {
                    $data['title'] = $row['title'];
                    $data['description'] = $row['description'];

                    if(!empty($data)) {
                        DB::table('post')->insert($data);
                    }
                }
            });
        }

        Session::put('success', 'Youe file successfully import in database!!!');

        return back();
    }
}