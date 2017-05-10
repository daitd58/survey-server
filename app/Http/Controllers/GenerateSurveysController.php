<?php

namespace App\Http\Controllers;

use App\Learners;
use App\Surveys;
use App\Officers;
use App\ClassStudent;
use App\Classes;
use App\Subjects;
use Illuminate\Http\Request;
use Excel;

class GenerateSurveysController extends Controller
{
	public function getExcel( Request $request ) {
		$data = $request->only('file');
		$files = $data['file'];
		if ( $files == null ) {
			return response()->json(['data' => ['message' => 'No file submit']], 400);
		} else {
			foreach ($files as $file) {
				$extension = $file->getClientOriginalExtension();
				if ( $extension != 'xls' and $extension != 'xlsx' ) {
					return response()->json(['data' => ['message' => 'File invalid']], 400);
				}
				Excel::load($file, function ($reader) use ($data) {
					$results = $reader->get();
					$objWorksheet = $reader->setActiveSheetIndex( 0 );
					$highestRow = $objWorksheet->getHighestRow();
					$yearInfo = $objWorksheet->getCellByColumnAndRow(0, 5);
					$year = substr($yearInfo, 11, 9);
					$semester = substr($yearInfo, -1);
					$teacherCode = $objWorksheet->getCellByColumnAndRow(5, 7)->getValue();
					$classCode = $objWorksheet->getCellByColumnAndRow(2, 9);
					$subjectCode = substr($classCode, 0, -2);
					$subjectName = $objWorksheet->getCellByColumnAndRow(2, 10);
					$time = $objWorksheet->getCellByColumnAndRow(2, 8);
					$studentCode = array();
					for($row = 12; $row <= $highestRow; ++$row) {
						array_push($studentCode, $objWorksheet->getCellByColumnAndRow(1, $row)->getValue());
					}
					$teachId = Officers::where('officerCode', $teacherCode)->first()->id;
					$subject = Subjects::where('subject_code', $subjectCode)->first();
					if($subject == null) {
						$subject = new Subjects();
						$subject->subject_code = $subjectCode;
						$subject->subject_name = $subjectName;
						$subject->save();
					}
					$template = Surveys::getTemplateDefault();
					$survey = new Surveys();
					$survey->title = $subjectName . ' ' . $classCode;
					$survey->isTemplate = 0;
					$survey->content = $template[0]->content;
					$survey->default = false;
					$survey->result = '';
					$survey->save();
					$class = new Classes();
					$class->subject_id = $subject->id;
					$class->survey_id = $survey->id;
					$class->teacher_id = $teachId;
					$class->year = $year;
					$class->semester = $semester;
					$class->save();
					for($i = 0; $i < count($studentCode); ++$i) {
						$student = Learners::where('learnerCode', $studentCode[$i])->first();
						if($student) {
							$classStudent             = new ClassStudent();
							$classStudent->class_id   = $class->id;
							$classStudent->student_id = $student->id;
							$classStudent->save();
						}
					}
				});
			}
		}

		return response()->json(['data' => ['message' => 'success']], 200);
	}
}
