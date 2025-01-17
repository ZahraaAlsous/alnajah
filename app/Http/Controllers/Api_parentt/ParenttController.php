<?php

namespace App\Http\Controllers\Api_parentt;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Student;
use App\Models\Parentt;
use App\Models\Program_Student;
use App\Models\Subject;
use App\Models\Homework;
use App\Models\Note_Student;
use App\Models\Mark;
use App\Models\Image;
use App\Models\Accessories;

class ParenttController extends Controller
{
    //عرض جميع أبنائي المسجلين بالمعهد
    public function displayAllBaby(Request $request)
    {
    $parent = Parentt::where('id', auth()->user()->id)->with('student.user')->get();
    return $parent;
    }

    //برنامج الدوام الخاص بالابن المحدد
    public function displayPrograme($student_id)
    {
        $student = Student::where('id', $student_id)->first();
        $section_id = $student->section_id;
    $programe = Program_Student::all();

    if ($programe) {
        $result = [];

        foreach ($programe as $p) {
            if ($p->section_id == $student->section_id) {
                $img = Image::all();
                foreach ($img as $i) {
                    if ($p->id == $i->program_student_id) {
                        $imagePath = str_replace('\\', '/', public_path().'/upload/'.$i->path);
                        if (file_exists($imagePath)) {
                            $i->image_url = asset('/upload/' . $i->path);
                            $result[] = [
                                'info_program' => $p,
                                'image_info' => $i
                            ];
                        }
                    }
                }
            }
        }

        if (!empty($result)) {
            return response()->json([
                'status' => 'true',
                'images' => $result
            ]);
        } else {
            return response()->json([
                'status' => 'false',
                'message' => 'No images found'
            ]);
        }
    } else {
        return response()->json([
            'status' => 'false',
            'message' => 'Program not found for this student'
        ]);
    }
    }

    //عرض مواد ابني
    public function displaySubjectSun($student_id)
    {
        $student = Student::where('id', $student_id)->first();
        $subject = Subject::where('class_id', $student->class_id)->get();
        return $subject;
    }

    //عرض وظائف ابني لمادة محددة
    // public function homework_subject_my_sun($student_id, $subject_id)
    // {
    //     // $student = Student::where('id', $student_id)->with('user')->first();
    //     // $year = $student->user->year;
    //     // $homework = Homework::where('year',$year)->where('subject_id', $subject_id)->with('accessories')->get();        
    //     // return $homework;
        

    //     $student = Student::where('id', $student_id)->first();
    //     $year = $student->user->year;

    //     $homework = Homework::where('year',$year)->where('subject_id', $subject_id)->get();
    //     foreach ($homework as $h) {
    //         $accessori = Accessories::where('home_work_id',$h->id)->get();
    //         foreach ($accessori as $a) {
    //             $homework_path = str_replace('\\', '/', public_path().'/upload/'.$a->path);
    //                     //return response()->file($imagePath);
    //                     if (file_exists($homework_path)) {
    //                         $result[] = [
    //                             'homework_info' => $h,
    //                             'path' => $homework_path,
    //                             'file_image_info' => $a
                                
    //                         ];    
    //                     }
    //         }
    //     }
    //     //عم نشوف إذا في نتائج أو لاء
    //     if (!empty($result)) {
    //         // return response()->json([
    //         //     'status' => 'true',
    //         //     'images' => $result
    //         // ]);
    //         return $result;
    //     } else {
    //         return response()->json([
    //             'status' => 'false',
    //             'message' => 'No images found'
    //         ]);
    //     }

        
    //     // return $homework;

    // }


//     public function homework_subject_my_sun($student_id,$subject_id)
// {
//     $student = Student::where('id', $student_id)->first();
//     $year = $student->user->year;
//     $homework = Homework::where('year',$year)->where('subject_id', $subject_id)->get();
//     $result = [];
//     foreach ($homework as $h) {
//         $accessori = Accessories::where('home_work_id',$h->id)->get();
//         $homework_info = [
//             'homework_info' => $h,
//             'file_image_info' => []
//         ];
//         foreach ($accessori as $a) {
//             $homework_path = str_replace('\\', '/', public_path().'/upload/'.$a->path);
//             if (file_exists($homework_path)) {
//                 $homework_info['file_image_info'][] = [
//                     'path' => $homework_path,
//                     'file_image_info' => $a
//                 ];    
//             }
//         }
//         if (!empty($homework_info['file_image_info'])) {
//             $result[] = $homework_info;
//         }
//     }
    
//     if (!empty($result)) {
//         return $result;
//     } else {
//         return response()->json([
//             'status' => 'false',
//             'message' => 'No images found'
//         ]);
//     }
// }

public function homework_subject_my_sun($student_id,$subject_id)
{
    $student = Student::where('id', $student_id)->first();
    $year = $student->user->year;

    $homework = Homework::where('year', $year)->where('subject_id', $subject_id)->get();
    $result = [];

    foreach ($homework as $h) {
        $accessories = Accessories::where('home_work_id', $h->id)->get();
        $homework_info = [
            'homework_info' => $h,
            'file_image_info' => []
        ];

        foreach ($accessories as $a) {
            $homework_path = str_replace('\\', '/', public_path() . '/upload/' . $a->path);

            if (file_exists($homework_path)) {
                $a->image_url = asset('/upload/' . $a->path);
                $homework_info['file_image_info'][] = [
                    // 'path' => $homework_path,
                    'file_image_info' => $a
                ];
            }
        }

        $result[] = $homework_info;
    }

    if (!empty($result)) {
        return $result;
    } else {
        return response()->json([
            'status' => 'false',
            'message' => 'No images found'
        ]);
    }
}


    //عرض الملاحظات التي بحق الابن
    public function display_note($student_id)
    {
         $note= Note_Student::where('student_id', $student_id)->with('user')->get();
         return $note;
    }

    //عرض علامات الابن
    public function displayMark($student_id)
    {
        $mark = Mark::where('student_id', $student_id)->with('subject')->get();
        return $mark;
    }
}
