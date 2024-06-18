<?php

namespace App\Http\Controllers\Api_out_user;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Teacher;
use App\Models\Course;
use App\Models\Teacher_subject;
use App\Models\Subject;

class DisplayController extends BaseController
{
    /*------------------------teacher------------------------*/
    public function all_teatcher()
    {
        $teatcher = Teacher::with('user')->get();
        return $teatcher;
    }

    public function info_teatcher($teatcher_id)
    {
        $teacher = Teacher::where('id', $teatcher_id)->first();
        $teacher_subject = Teacher_subject::where('teacher_id', $teacher->id)->get();

        foreach ($teacher_subject as $subject) {
            $info_subject = Subject::where('id', $subject->subject_id)->get();
            $result[] = $info_subject;
        }
        return [$teacher, $result];
    }

    /*------------------------course------------------------*/
    public function all_course()
    {
        $course = Course::with('subject')->with('classs')->with('teacher.user')->get();
        return $course;
    }

    public function info_course($id_course)
    {
        $course = Course::where('id', $id_course)->with('subject')->with('classs')->with('teacher.user')->get();
        return $course;
    }

    //عرض الإعلانات
    public function publish()
    {
    //     //عرض إعلانات
    // Route::get('/publish',[DisplayController::class,'publish']);
$publish = Publish::all();
$result = [];

foreach ($publish as $p) {
    $images = Image::where('publish_id', $p->id)->get();
    $imageData = [];

    foreach ($images as $i) {
        $imagePath = str_replace('\\', '/', public_path().'/upload/'.$i->path);
        
        if (file_exists($imagePath)) {
            $imageData[] = [
                'path' => $imagePath,
                'file_info' => $i
            ];
        }
    }
    
    $result[] = [
        'ad_info' => $p,
        'images' => $imageData
    ];
}

if (!empty($result)) {
    return response()->json([
        'status' => 'true',
        'ads' => $result
    ]);
} else {
    return response()->json([
        'status' => 'false',
        'message' => 'No images found'
    ]);
}
    } 
}
