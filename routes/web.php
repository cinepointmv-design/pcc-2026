<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\NavigationController;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/owner-login', [ClientController::class,'index'] );
Route::get('/clients', [ClientController::class,'view'] );
Route::match(['get', 'post'],'/delete/clients', [ClientController::class,'delete'] );
Route::match(['get', 'post'],'/delete-client/{id}', [ClientController::class,'deleteSingleClient'] );
Route::post('/create-client-3', [ClientController::class,'store'] );
Route::get('/create-client-1', [ServiceController::class, 'getservice']);
Route::get('/create-client-2', [ServiceController::class, 'storeservice']);
Route::post('/create-client-4', [ServiceController::class, 'storepayment']);
Route::get('/save-client', [ServiceController::class, 'savedata']);
Route::get('/clients-create-3', function(){
   return view('clients-create-3'); 
});
Route::get('/clients-create-4', function(){
   return view('clients-create-4'); 
});
Route::get('/clients-edit-4', function(){
   return view('clients-edit-4'); 
});
Route::get('/edit-service/{id}', [ServiceController::class, 'editService']);
Route::post('/update-service/{id}', [ServiceController::class, 'updateService']);
Route::get('/getserviceprice',[ServiceController::class, 'getServicePrice']);
Route::get('/service',[ServiceController::class, 'viewservice']);
Route::get('/add-service', function(){
   return view('add-service'); 
});
Route::post('/save-service', [ServiceController::class, 'saveservice']);
Route::post('/remove-service', [ServiceController::class,'removeservice'] );
Route::get('/client-service', [ServiceController::class,'payment'] );
Route::get('/client-service-edit/{id}', [ServiceController::class,'paymentedit']);
Route::get('/clients-edit/{id}', [ServiceController::class,'clientsEdit1'] );
Route::post('/clients-edit-2', [ServiceController::class, 'clientsEdit2']);

Route::match(['get', 'post'],'/clients-edit-3', [ClientController::class,'clientsEdit3'] );
Route::get('/', function(){
   return view('clients-login'); 
});
Route::post('/admin-dashboard', [ClientController::class,'login'] );
Route::get('/admin-dashboard', [ClientController::class,'adminDashboard'] );
Route::get('/getallserviceid',  [ServiceController::class, 'getServiceId']); 
Route::get('/getallservices',  [ServiceController::class, 'getAllServices']);
Route::post('/clients-edit-4',  [ServiceController::class, 'editstorepayment']);
Route::get('/save-edit-client',  [ServiceController::class, 'clientsEdit4']);
Route::post('/savepaymentedit',  [ServiceController::class, 'savepaymentedit']);
Route::post('/delete-service', [ServiceController::class, 'deleteService']);

Route::get('/signout', [ClientController::class, 'signOut']);
Route::get('/enquiry',[ClientController::class, 'viewenquiry']);
Route::get('/create-enquiry',[ClientController::class, 'createEnquiry']);
Route::post('/save-enquiry',[ClientController::class, 'saveEnquiry']);
Route::get('/edit-enquiry/{id}', [ClientController::class, 'editEnquiry']);
Route::post('/update-enquiry/{id}', [ClientController::class, 'updateEnquiry']);
Route::match(['get', 'post'], '/remove-enquiry', [ClientController::class,'removeEnquiry'] );
Route::get('/courses',[ClientController::class, 'viewcourse']);
Route::get('/add-course', [ClientController::class, 'addcourse']);
Route::post('/save-course', [ClientController::class, 'savecourse']);
Route::get('/edit-course/{id}', [ClientController::class, 'editCourse']);
Route::post('/update-course/{id}', [ClientController::class, 'updateCourse']);
Route::post('/remove-course', [ClientController::class,'removeCourse'] );
Route::get('/batches',[ClientController::class, 'viewbatches']);
Route::get('/students',[ClientController::class, 'viewStudents']);
Route::get('/view-students/{id}', [ClientController::class, 'viewMoreStudents']);
Route::get('/add-students/{id?}', [ClientController::class, 'addStudents']);
Route::get('/save-students',[ClientController::class, 'saveStudents']);
Route::get('/edit-students/{id}', [ClientController::class, 'editStudents']);
Route::get('/save-edit-students', [ClientController::class, 'saveEditStudents']);
Route::post('/update-students/{id}', [ClientController::class, 'updateStudents']);
Route::get('/delete-followups/{id}', [ClientController::class, 'deleteFollowups']);
Route::match(['get', 'post'],'/remove-students', [ClientController::class,'removeStudents'] );
Route::post('/delete-single-student/{id}', [ClientController::class,'deleteSingleStudent'] );

Route::get('/get-course-details/{id}', [ClientController::class,'getCourseDetails']);
Route::get('/get-multiple-course-details/{ids}',[ClientController::class,'getMultipleCourseDetails']);
Route::get('/fetch-search-course-name/{courseId}', [ClientController::class, 'fetchSearchCourseName']);

Route::get('/save-student-data', [ClientController::class,'SaveStudentData']);
Route::post('/student-register', [ClientController::class,'studentRegister']);
Route::get('/student-register-done', function(){
   return view('student-register'); 
});
Route::post('/delete-edit-select-course', [ClientController::class, 'deleteEditSelectCourse']);
Route::get('/get-course-list', [ClientController::class,'getCourseList']);
Route::get('/save-edit-student-course', [ClientController::class,'saveEditStudentCourse']);
Route::post('/edit-student-register', [ClientController::class,'editStudentRegister']);
Route::post('/search-enquiry', [ClientController::class, 'searchEnquiry']);
Route::get('/fetch-course-name/{course_id}', [ClientController::class, 'fetchCourseName']);
Route::post('/search-clients', [ClientController::class, 'searchClients']);
Route::post('/search-students', [ClientController::class, 'searchStudents']);

Route::get('/labs',[ClientController::class, 'viewlabs']);
Route::get('/add-lab', [ClientController::class, 'addlab']);
Route::post('/save-lab', [ClientController::class, 'savelab']);
Route::get('/edit-lab/{id}', [ClientController::class, 'editlab']);
Route::post('/update-lab/{id}', [ClientController::class, 'updatelab']);
Route::post('/remove-lab', [ClientController::class,'removelab'] );
Route::get('/get-lab-details/{labNumber}', [ClientController::class,'getLabDetails'] );
Route::get('/fees', [ClientController::class, 'fees']);
Route::get('/fees-detail', [ClientController::class, 'feesdetail']);
Route::Post('/get-students-through-number', [ClientController::class, 'GetStudentsThroughNumber']);
Route::post('/addnewfees', [ClientController::class, 'addnewfees']);
Route::get('/editnewfees', [ClientController::class, 'editnewfees']);
Route::get('/followup',[ClientController::class, 'followup']);
Route::get('/view-followup/{id}', [ClientController::class, 'viewfollowup']);
Route::post('/update-followup/{id}', [ClientController::class, 'updatefollowup']);
Route::post('/set-enquiry-id', function (Request $request) {
   $enquiryId = $request->input('enquiryId');
   Session::put('enquiry_id', $enquiryId);
   return response()->json(['message' => 'Enquiry ID stored in session']);
});
Route::get('/upcoming-fees',function(){
   return view('upcoming-fees');
});

Route::get('/get-upcoming-fees', [ClientController::class, 'getupcomingfees']);
Route::get('/upcoming-birthdays', [ClientController::class, 'upcomingbirthdays']);
Route::get('/send-birthday-message/{number}', [ClientController::class, 'sendBirthdayMessage']);
Route::post('/admin-login', [ClientController::class,'adminlogin'] );
Route::get('/dashboard',[ClientController::class,'dashboard'] );
Route::get('/adminsignout', [ClientController::class, 'adminsignOut']);
Route::get('/client-payment', [ServiceController::class, 'viewClientPayment']);
Route::get('/add-new-payment/{id}', [ServiceController::class,'addNewPayment']);
Route::get('/go-dashboard', [ClientController::class,'goDashboard']);
Route::get('/client-dashboard', [ClientController::class,'clientDashboard']);
Route::get('/student-payment-logs/{studentId}', [ClientController::class, 'getPaymentLogs']);
Route::get('/all-followups-detail', [ClientController::class,'followupDetail']);
Route::get('/filter-enquiry', [ClientController::class,'filterEnquiry']);
Route::get('/fetch-seats/{batch_id}', [ClientController::class, 'fetchSeats']);
Route::get('/delete-batch/{id}', [ClientController::class, 'deleteBatch']);
Route::get('/get-batches-by-lab-number/{labNumber}', [ClientController::class, 'getBatchesByLabNumber']);
Route::get('/get-batches-by-course/{course_id}', [ClientController::class, 'getBatchesByCourse']);



