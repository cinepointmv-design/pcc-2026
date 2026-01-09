<?php

namespace App\Http\Controllers;

use Twilio\Rest\Clients;
use App\Models\Followup;
use App\Models\StudentFees;
use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Client;
use App\Models\OwnerLogin;
use App\Models\AllService;
use App\Models\Courses;
use App\Models\Students;
use App\Models\StudentCourse;
use App\Models\Batch;
use App\Models\Enquiry;
use App\Models\Lab;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;
use Illuminate\Validation\ValidationException;
use App\Models\ClientPayments;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Log;


class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {  
       
        // Session::flush();
        return view('owner-login');
    }
    
    public function adminDashboard()
{  
    $client_id = session('client_id');
    $studentsCount = Students::where('client_id',$client_id)->count();
    $inquiriesCount = Enquiry::where('client_id',$client_id)->where('status', '!=', 'lead')->count();
    $coursesCount = Courses::where('client_id',$client_id)->count();
    $labsCount = Lab::where('client_id',$client_id)->count();

    // Pass the counts to the view
    return view('admin-dashboard', compact('studentsCount', 'inquiriesCount', 'coursesCount', 'labsCount'));
}

    public function dashboard()
    {  
        $studentsCount = Client::count();
    $inquiriesCount = Service::count();
 
    // Pass the counts to the view
    return view('dashboard', compact('studentsCount', 'inquiriesCount'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function view()
    {
        $clients = Client::orderBy('id', 'Desc')->paginate(50);

        // Pass the client data to the view
        return view('clients')->with('clients', $clients);
    }

    public function login(Request $request)
    {
        $request->validate([
            'login' => 'required',
            'password' => 'required',
        ]);
        
        $credentials = $request->only('login', 'password');
    
        // Check if the input matches either the email or username
        $user = Client::where('email', $credentials['login'])
            ->orWhere('username', $credentials['login'])
            ->first();
    
        if ($user && $user->password === $credentials['password']) {
            // Check if the user has the 'CRM' service
            $crmService = $user->services()
            ->whereRaw('LOWER(service) = ?', [strtolower('CRM')])
            ->first();
    
            if ($crmService) {
                // Check if the service has expired
                $isExpired = now()->isAfter($crmService->expiry_date); // Assuming 'expiration_date' is the field in the service table
    
                if (!$isExpired) {
                    // Authentication passed, the user has CRM service and the service is not expired
                    Auth::login($user);
    
                    // Fetching the user's name based on the username
                    $userDetails = Client::where('username', $user->username)->first();
                    $name = $userDetails->name; // Assuming 'name' is the field containing the user's name
                    $client_id = $userDetails->id;
                    // Storing the name in the session after successful login
                    $request->session()->put('name', $name);
                    $request->session()->put('client_id', $client_id);
                    return redirect('/admin-dashboard'); // Redirect to the intended page after login
                } else {
                    return redirect('/')->withErrors(['service' => 'Your CRM service has expired. Please contact support.']); // Service expired, redirect to clients-login
                }
            } else {
                return redirect()->back()->withErrors(['service' => 'You do not have access to the CRM service']); // No CRM service
            }
        } else {
            return redirect()->back()->withErrors(['login' => 'Invalid Username and password']); // Failed login attempt
        }
    }
    

    public function signOut()
    {
        Auth::logout(); // This will clear the authentication information in the session
        Session::forget('name');
        Session::forget('client_id');
        return redirect('/'); // Redirect to the login page or any other desired page
    }


    public function adminlogin(Request $request)
    {
        $request->validate([
            'login' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('login', 'password');
    
        // Fetch the user by email or username
        $user = OwnerLogin::where('email', $credentials['login'])->first();
    
        if ($user && $user->password === $credentials['password']) {
            // Login successful
            Auth::login($user);
    
            // Store user details in session
            $request->session()->put('admin_name', $user->name);
            $request->session()->put('admin_id', $user->id);
    
            return redirect('/dashboard'); // Redirect to the dashboard route upon successful login
        } else {
            // Failed login attempt
            return redirect()->back()->withErrors(['login' => 'Invalid Username or Password']);
        }
    }
    

    public function adminsignOut()
    {
        Auth::logout(); // This will clear the authentication information in the session
        Session::forget('admin_name');
        Session::forget('admin_id');
        return redirect('/owner-login'); // Redirect to the login page or any other desired page
    }


   

    public function createEnquiry()
    {   
        $client_id = session('client_id');
        $courses = Courses::where('client_id', $client_id)->get();
        return view('admin-create-enquiry')->with('courses', $courses);
    }

    public function viewenquiry()
    {
        $client_id = session('client_id');
    
        $enquiry = Enquiry::where('client_id', $client_id)
                          ->where('status', '!=', 'lead')
                          ->with('course')
                          ->orderBy('created_at', 'desc')
                          ->paginate(50);
    
        return view('admin-enquiry')->with('enquiry', $enquiry);
    }

    public function saveEnquiry(Request $request)
{   
    $client_id = session('client_id');

    // Validate incoming request data
    $validatedData = $request->validate([
        'name' => 'required',
        'email' => 'nullable|unique:enquiries,email', // Unique email validation
        'phone' => 'required|unique:enquiries',
        'whatsapp_number' => 'nullable',
        'reference' => 'nullable',
        'address' => 'nullable',
        'demo_date' => 'required',
        'enquirydate' => 'nullable',
        'followup_date' => 'required',
        'description' => 'nullable',
        'course' => 'required|array', // Modify this line to expect an array
        'client_id' => 'required',
    ]);

    // dd($validatedData['course']);

    // If validation passes, create and save the Enquiry model
    $enquiry = new Enquiry();
    $enquiry->name = $validatedData['name'];
    $enquiry->email = $validatedData['email'];
    $enquiry->phone = $validatedData['phone'];
    $enquiry->whatsapp_number = $validatedData['whatsapp_number'];
    $enquiry->reference = $validatedData['reference'];
    $enquiry->address = $validatedData['address'];
    $enquiry->enquirydate = $validatedData['enquirydate'];
    $enquiry->demo_date = $validatedData['demo_date'];
    $enquiry->followup_date = $validatedData['followup_date'];
    $enquiry->description = $validatedData['description'];
    $enquiry->course_id = json_encode($validatedData['course']);
    $enquiry->client_id = $validatedData['client_id'];
    $enquiry->save();

    $followup = new Followup();
    $followup->enquiry_id = $enquiry->id;
    $followup->save();

    return response()->json(['success' => true, 'whatsapp_number' => $enquiry->whatsapp_number, 'name'=> $enquiry->name]);
}

    

    public function editEnquiry($id)
    {
        $client_id = session('client_id');
        $enquiry = Enquiry::findOrFail($id);
        $courses = Courses::where('client_id', $client_id)->get();
        return view('edit-enquiry', compact('enquiry','courses'));
    }

    public function updateEnquiry(Request $request, $id)
    {   
        $EnquiryData = $request->all();
        $enquiry = Enquiry::findOrFail($id);
        $currentDate = date("Y-m-d"); // Retrieves current date in YYYY-MM-DD format
        $currentTime = date("H:i:s");

        $enquiry->name = $EnquiryData['name'];
        $enquiry->email = $EnquiryData['email'];
        $enquiry->phone = $EnquiryData['phone'];
        $enquiry->whatsapp_number = $EnquiryData['whatsapp_number'];
        $enquiry->reference = $EnquiryData['reference'];
        $enquiry->address = $EnquiryData['address'];
        $enquiry->enquirydate = $EnquiryData['enquirydate'];
        $enquiry->demo_date = $EnquiryData['demo_date'];
        $enquiry->followup_date = $EnquiryData['followup_date'];
        $enquiry->description = $EnquiryData['description'];
        $enquiry->course_id = json_encode($EnquiryData['course']);
        $enquiry->status = $EnquiryData['status'];
        $enquiry->save();

        $followups = new Followup();
        $followups->enquiry_id = $id;
        $followups->status = $EnquiryData['status'];
        $followups->save();

        $status = $EnquiryData['status'];

        if ($status == 'lead') {
            return redirect('/add-students/' . $id);
        }
    
        if ($status == 'close') {
            Followup::where('enquiry_id',$id)->delete();
    
            return redirect('/enquiry');
        }

        return redirect('/enquiry')->with('success', 'Courses updated successfully');
    }

    public function removeEnquiry(Request $request)
    {   
        $selectedService = $request->input('selected_enquiries');

        if ($selectedService) {
            Enquiry::whereIn('id', $selectedService)->delete();

            Followup::where('enquiry_id', $selectedService)->delete();

            return redirect()->back()->with('success', 'Selected Enquiry have been deleted.');
        }



        return redirect()->back()->with('error', 'No Enquiry were selected for deletion.');
    }
      
    public function deleteFollowups(Request $request,$id)
    {   
        $selectedService = $id;

        // dd($selectedService);

        if ($selectedService) {
            Enquiry::where('id', $selectedService)->delete();

            Followup::where('enquiry_id', $selectedService)->delete();

            return redirect()->back()->with('success', 'Selected Enquiry have been deleted.');
        }



        return redirect()->back()->with('error', 'No Enquiry were selected for deletion.');
    }

    public function followupDetail()
    {
    
        return view('followup-detail');
    }

    public function filterEnquiry(Request $request)
    {
        // Get filter criteria from the request
        $status = $request->input('status');
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');

        $client_id = session('client_id');
    
        // Query to fetch filtered data based on status and date range
        $query = Enquiry::where('client_id', $client_id);
    
        // Add status filter if a specific status other than "All" is selected
        if ($status && $status == 'All') {
            $query->where('status', $status);
        }

        if ($status && $status == 'open') {
            $query->where('status', $status);
        }

        if ($status && $status == 'close') {
            $query->where('status', $status);
        }

        if ($status && $status == 'lead') {
            $query->where('status', $status);
        }
    
        // Add date range filter if both start and end dates are provided
        if ($startDate && $endDate) {
            $query->whereBetween('followup_date', [$startDate, $endDate]);
        }
    
        // Fetch the filtered data
        $filteredData = $query->paginate(50);
    
        // Return a JSON response
        return response()->json(['enquiries' => $filteredData]);
    }

    
    public function followup()
    {
        $client_id = session('client_id');
        $currentDate = now();
    
        $enquiryIds = Enquiry::where('client_id', $client_id)
        ->where('status', 'open')
            ->where(function ($query) use ($currentDate) {
                $query->whereDate('followup_date', '<=', $currentDate->toDateString())
                    ->orWhereDate('followup_date', $currentDate->toDateString());
            })
            ->pluck('id');
    
        $followups = Followup::whereIn('enquiry_id', $enquiryIds)
            ->whereNull('call')
            ->whereNull('time')
            ->latest('created_at')
            ->get()
            ->unique('enquiry_id') // Ensure only one record per unique enquiry_id
            ->values(); // Re-index the array keys
    
        return view('followup')->with('enquiries', $followups);
    }
    



public function viewfollowup($id)
{
    $client_id = session('client_id');
    
    $enquiry_id = $id;

    $enquiry = Enquiry::where('id', $enquiry_id)->with('course')->get();

    $followup = Followup::where('enquiry_id', $enquiry_id)
    ->whereNotNull('call')
    ->whereNotNull('time')
    ->get();
        
    return view('view-followup')->with(['enquiry' => $enquiry , 'followup' => $followup]);
}


public function updatefollowup(Request $request,$id)
{
    
    $enquiry_id = $id;

    $current_time = date("H:i:s");

    $followup = Enquiry::findOrFail($enquiry_id);
    $currentDate = date("Y-m-d"); // Retrieves current date in YYYY-MM-DD format
    $currentTime = date("H:i:s");
    $followup->description = $request->input('followupDescription');
    $status = $request->input('status');

    if ($followup) {
        $followup->followup_date = $request->input('followup_date');
        $followup->status = $request->input('status');
        $followup->save();

        $followups = new Followup();
        $followups->enquiry_id = $enquiry_id;
        $followups->call = $currentDate;
        $followups->time = $currentTime ;
        $followups->status = $request->input('status');
        $followups->description = $request->input('followupDescription');
        $followups->save();
    }

    if ($status == 'lead') {
        return redirect('/add-students/' . $enquiry_id);
    }

   

    return redirect('/view-followup/' . $enquiry_id);
}

    public function viewcourse()
    {   
        $client_id = session('client_id');
        $courses = Courses::where('client_id', $client_id)->with('lab')->orderBy('created_at', 'desc')->paginate(50);
        return view('courses')->with('courses', $courses);
    }

    public function addcourse()
    {   
        $client_id = session('client_id');
        $labs = Lab::where('client_id', $client_id)->get();
        
        return view('add-course', ['labs' => $labs]);

    }

    public function getBatchesByLabNumber($labNumber)
{
    
    $course = Courses::find($labNumber);
    
    // Check if course exists
    if ($course) {
        // Return course details as JSON response
        $batch = Batch::where('lab_id',$course->lab_number)->get();
      

        return response()->json([
            'batch' => $batch,
           
        ]);
    } else {
        // Course not found, return an error
        return response()->json(['error' => 'Course not found'], 404);
    }
}

    public function getLabDetails($labNumber)
{  
    $client_id = session('client_id');
    // Retrieve lab details based on the lab number
    $lab = Lab::where('id', $labNumber)->where('client_id', $client_id)->first();

    $batch = Batch::where('lab_id', $lab->id)->get();

    // Initialize a variable to store the sum of pending seats
    $pendingSeatsSum = 0;

    // Loop through each batch and accumulate the pending seats
    foreach ($batch as $batchData) {
        $pendingSeatsSum += (int) $batchData->pending_seats;
    }

    // Prepare the response with lab details and the sum of pending seats
    $response = [
        'total_seats' => $pendingSeatsSum,
    ];

    // Return the JSON response
    return response()->json($response);
}
    
    public function savecourse(Request $request)
    {
        // Retrieve data stored in different steps from the session
        $CourseData = $request->all();
        $course = new Courses();
        $course->course_name = $CourseData['course_name'];
        $course->fees = $CourseData['fees'];
        $course->duration = $CourseData['duration'];
        $course->lab_number = $request->input('lab_number');
        $course->client_id = $request->input('client_id');
        $course->save();

        return redirect('/courses');
    }

    public function editCourse($id)
    {
        $course = Courses::findOrFail($id);
        $client_id = session('client_id');
        $labs = Lab::where('client_id', $client_id)->get();
        return view('edit-course', compact('course','labs'));
    }

    public function updateCourse(Request $request, $id)
    {
        $course = Courses::findOrFail($id);

        $course->course_name = $request->input('course_name');
        $course->fees = $request->input('fees');
        $course->duration = $request->input('duration');
        $course->lab_number = $request->input('lab_number');
        $course->save();

        return redirect('/courses')->with('success', 'Courses updated successfully');
    }
     
    public function removeCourse(Request $request)
    {   
        $selectedService = $request->input('selected_course');

        if ($selectedService) {
            Courses::whereIn('id', $selectedService)->delete();

            return redirect()->back()->with('success', 'Selected Service have been deleted.');
        }

        return redirect()->back()->with('error', 'No Service were selected for deletion.');
    }


    public function viewStudents()
    {   
        $client_id = session('client_id');
    
        $students = Students::where('client_id', $client_id)
                             ->with('studentCourses')
                             ->orderBy('created_at', 'desc') 
                             ->paginate(50);
    
        return view('students')->with('students', $students);
    }

    public function viewMoreStudents(Request $request,$id)
    {   
        $students = Students::where('id', $id)
        ->with('studentCourses')
        ->get();

       return view('student-view',compact('students'));
    }

    public function addStudents(Request $request,$id = null)
    {   
        $request->session()->forget('studentData');
        $request->session()->forget('student_courses');
        $client_id = session('client_id');
        $courses = Courses::where('client_id', $client_id)->with('lab')->get();
        $enquiryData = null;
        if ($id) {
            // Fetch data from Enquiries based on provided ID
            $enquiryData = Enquiry::find($id);
        }
        return view('add-students', [
            'courses' => $courses,
            'enquiryData' => $enquiryData,
        ]);
    }

    public function saveStudents(Request $request)
    {    
        $client_id = session('client_id');

        $validatedstudentData = $request->validate([
            'client_id' => 'required',
            'name' => 'required',
            'email' => 'nullable|unique:students,email',
            'phone' => 'required|unique:students,phone',
            'whatsapp_number' => 'nullable',
            'fathername' => 'nullable',
            'joiningdate' => 'nullable',
            'DOB' => 'nullable|date',
            'gender' => 'nullable',
            'address' => 'nullable',
            'city' => 'nullable',
            'pincode' => 'nullable|numeric',
            'community' => 'nullable',
            'qualification' => 'nullable',
            // Add validation rules for other fields as needed
        ]);

         $validatedData = $request->all();
        
    
          // If email and username are unique, store the data in the session
          $request->session()->put('studentData', $validatedstudentData);

         $courses = Courses::where('client_id', $client_id)->get();
         
        // Fetch course_id from the validated data
        $courseId = $validatedData['course'];

        // If course_id exists, proceed to the next step (select-course)
        if ($courseId) {
            return view('select-course')->with('courses', $courses)->with('course_id', $courseId);
            
        }else {
            return view('select-course')->with('courses', $courses);
        }
 
        
         

    }


    public function saveStudentData(Request $request)
{
    // Retrieve the courses data from the request
    $courses = $request->input('courses');
    
    if (!empty($courses) && is_array($courses)) {
        $request->session()->forget('courses');
   
        $studentCourses = [];
        
    // Process the received courses to prevent duplicates
    foreach ($courses as $course) {

        if (isset($course['course'])) {
            $studentCourses[] = $course;
        }         
    }

    // Store the updated course data in the session with 'student_courses' key
    $request->session()->put('student_courses', $studentCourses);
    
}

    return view('course_payment');
}



    
    public function studentRegister(Request $request)
    {
        $studentData = $request->session()->get('studentData');
        $studentCourses = $request->session()->get('student_courses');


        if (is_array($studentCourses) && count($studentCourses) > 0) {
            $selectedBatches = []; // Array to store selected batch IDs
            
            foreach ($studentCourses as $courseBatch) {
                $batchId = $courseBatch['batch'];
                
                // Check if the batch is already selected for another course
                if (in_array($batchId, $selectedBatches)) {
                    return response()->json(['error' => 'Both courses cannot have the same batch.']);
                }
        
                // Add the batch to the selected batches array
                $selectedBatches[] = $batchId;

                 // Check if there is more than one batch selected
                if (count($selectedBatches) > 1) {
                    foreach ($selectedBatches as $batchId) {
                        // Check if there are available seats
                        $availableSeats = Batch::where('id', $batchId)->value('pending_seats');
            
                        if ($availableSeats === 0) {
                            // If there are no available seats, show an error message
                            return response()->json(['error' => 'Choose only one course, as both courses share the same batch with no available seats.']);
                        }
                    }
                }
            }
        
        
            // Now proceed with decrementing the seat counts since everything is valid
            foreach ($selectedBatches as $batchId) {
                // Decrement the seat count
                Batch::where('id', $batchId)->decrement('pending_seats', 1);
            }
        }
        

        $enquiry_id = session('enquiry_id');
        if ($enquiry_id) {
            
        // Followup::where('enquiry_id',$enquiry_id)->delete();

        $enquiry = Enquiry::findOrFail($enquiry_id);


        $enquiry->status = "lead";
        $enquiry->save();

        }
       
        
        $total_fees = $request->input('total_fees');
        $total_paid_fees = $request->input('total_paid_fees');
        $pending_fees = $request->input('pending_fees');

        $next_due_date = $request->input('next_due_date');
        $payable_fees = $request->input('pay_amount');
        $currentDate = date("Y-m-d");

        
       
        $student = new Students();
        $student->name = $studentData['name'];
        $student->email = $studentData['email'];
        $student->phone = $studentData['phone'];
        $student->whatsapp_number = $studentData['whatsapp_number'];
        $student->city = $studentData['city'];
        $student->fathername = $studentData['fathername'];
        $student->DOB = $studentData['DOB'];
        $student->joiningdate = $studentData['joiningdate'];
        $student->gender = $studentData['gender'];
        $student->address = $studentData['address'];
        $student->pincode = $studentData['pincode'];
        $student->community = $studentData['community'];
        $student->qualification = $studentData['qualification'];
        $student->client_id = $studentData['client_id'];
        $student->save();

        $studentId = $student->id;

        $fees = new StudentFees();
            $fees->student_id = $studentId;
            $fees->total_fees = $total_fees;
            $fees->total_paid_fees = $total_paid_fees;
            $fees->pending_fees = $pending_fees;
            if ($total_fees == $total_paid_fees) {
                $fees->next_due_date = null;
            } else {
                $fees->next_due_date = $next_due_date;
            }
            $fees->payment_date = $currentDate;
            $fees->pay_amount = $total_paid_fees;
            $fees->save();

        // If studentCourses exist and is an array
    if (is_array($studentCourses) && count($studentCourses) > 0) {
        foreach ($studentCourses as $courseData) {

            $startBatch = $courseData['start_batch'];  
            $endBatch = $courseData['end_batch'];

            // Format the batch timing into the desired format ('H:i') to store in the database
            $formattedBatchTiming = $startBatch . ' to ' . $endBatch;

            // Create a new instance of the StudentCourse model and save the data
            $newStudentCourse = new StudentCourse();
            $newStudentCourse->course_id = $courseData['course'];
            $newStudentCourse->batch = $courseData['batch'];
            $newStudentCourse->fees = $courseData['fees'];
            $newStudentCourse->student_id = $studentId;
            $newStudentCourse->save();

            

        }
    }

     // Clear the session data after saving
     $request->session()->forget('studentData'); 
     $request->session()->forget('student_courses');
     $request->session()->forget('enquiry_id');
 
    // // Redirect or return a view as needed
    // return redirect('/student-register-done');

    
    }

    public function deleteSingleStudent(Request $request, $id)
{   
    $client_id = session('client_id');
    $selectedStudent = $id;

    if ($selectedStudent) {
        // Get the course IDs associated with the selected student
        $courseIDs = StudentCourse::where('student_id', $selectedStudent)->pluck('course_id')->toArray();

        // Get distinct batches associated with the selected student
        $studentBatches = StudentCourse::where('student_id', $selectedStudent)->distinct()->pluck('batch')->toArray();

       

        // Array to keep track of batches for which seats have already been incremented
        $processedBatches = [];

        // Get the courses with the corresponding labs
        $coursesWithLab = Courses::where('client_id', $client_id)
            ->with('lab')
            ->whereIn('id', $courseIDs)
            ->get();

        foreach ($coursesWithLab as $course) {
            $lab = $course->lab_number;
            
            // Get all batches associated with the lab
            $labBatches = Batch::where('lab_id', $lab)->pluck('batch')->toArray();

            // Find batches that match both lab batches and student batches
            $matchingBatches = array_intersect($labBatches, $studentBatches);

            // Increment seats for the matching batches, but only for batches that haven't been processed yet
            foreach ($studentBatches as $batch) {
                if (!in_array($batch, $processedBatches)) {
                    Batch::where('id', $batch)->increment('pending_seats', 1);
                    $processedBatches[] = $batch;
                }
            }
        }

        // Delete the student and related entries
        Students::where('id', $selectedStudent)->delete();
        StudentFees::where('student_id', $selectedStudent)->delete();
        StudentCourse::where('student_id', $selectedStudent)->delete();

        return redirect('/students')->with('success', 'Selected Student has been deleted.');
    }

    return redirect()->back()->with('error', 'No Student was selected for deletion.');
}  

public function getBatchesByCourse($course_id)
{
    // Retrieve batches based on the course ID
    $batches = StudentCourse::where('course_id', $course_id)->get();

    dd($batches);

    // Return the batches as a JSON response
    return response()->json(['batches' => $batches]);
}

    public function removeStudents(Request $request)
    {   
        $client_id = session('client_id');
        $selectedStudent = $request->input('selected_students');

        if ($selectedStudent) {

            $courseIDs = StudentCourse::whereIn('student_id', $selectedStudent)->pluck('course_id')->toArray();

            $studentBatches = StudentCourse::where('student_id', $selectedStudent)->distinct()->pluck('batch')->toArray();

            // Array to keep track of batches for which seats have already been incremented
        $processedBatches = [];

            // Get the courses with the corresponding labs
            $coursesWithLab = Courses::where('client_id',$client_id)->with('lab')->whereIn('id', $courseIDs)->get();

           
                foreach ($studentBatches as $batch) {
                    if (!in_array($batch, $processedBatches)) {
                        Batch::where('id', $batch)->increment('pending_seats', 1);
                        $processedBatches[] = $batch;
                    }
                }
            
    
            
            Students::whereIn('id', $selectedStudent)->delete();
            StudentFees::whereIn('student_id', $selectedStudent)->delete();

            // Delete related entries from student_course table based on student_id
            StudentCourse::whereIn('student_id', $selectedStudent)->delete();

            return redirect()->back()->with('success', 'Selected Service have been deleted.');
        }

        return redirect()->back()->with('error', 'No Service were selected for deletion.');
    }

    public function editStudents(Request $request , $id)
    {   
        // Clear the session data after saving
        $request->session()->forget('studentData');
        $request->session()->forget('student_courses');
        $students = Students::findOrFail($id);
        return view('edit-students', compact('students'));
    }

    public function saveEditStudents(Request $request)
{
    $student_id = $request->input('student_id');

    // Retrieve the student
    $student = Students::findOrFail($student_id);

    // Get all courses associated with this student along with their batches
    $coursesWithBatches = $student->courses()->with('studentCourses')->with('lab')->get();

    $batches= [];
    $data = StudentCourse::where('student_id',$student_id)->get();


    // Loop through each course
    foreach ($data as $course) {
        
        $batches = $course->batch;
        
    }
    
    $validatedData = $request->all();

    $request->session()->put('studentData', $validatedData);
    // Pass $batches and other required data to the view
    return view('edit-student-course', compact('coursesWithBatches', 'batches','student_id'));
}

public function saveEditStudentCourse(Request $request){
   // Retrieve the courses data from the request
   $courses = $request->input('courses');

   $studentData = $request->session()->get('studentData');

   if (is_array($studentData) && !empty($studentData)) {

   $feesdetail = StudentFees::where('student_id',$studentData['student_id'])->latest('created_at')->first();
   }
   if (!empty($courses) && is_array($courses)) {
    $request->session()->forget('courses');

    $studentCourses = [];
    
// Process the received courses to prevent duplicates
foreach ($courses as $course) {

    if (isset($course['course'])) {
        $studentCourses[] = $course;
    }         
}

// Store the updated course data in the session with 'student_courses' key
$request->session()->put('student_courses', $studentCourses);

}

     return view('edit_course_payment', ['feesdetail'=> $feesdetail ]);

}

public function editStudentRegister(Request $request)
    {
        $studentData = $request->session()->get('studentData');
        $studentCourses = $request->session()->get('student_courses');


        $total_fees = $request->input('total_fees');
        $total_paid_fees = $request->input('total_paid_fees');
        $pending_fees = $request->input('pending_fees');
        $next_due_date = $request->input('next_due_date');
        $payable_fees = $request->input('pay_amount');
        $currentDate = date("Y-m-d");

        if (is_array($studentData) && !empty($studentData)) {
            $student = Students::find($studentData['student_id']);

        if ($student) {

        $student->name = $studentData['name'];
        $student->email = $studentData['email'];
        $student->phone = $studentData['phone'];
        $student->whatsapp_number = $studentData['whatsapp_number'];
        $student->city = $studentData['city'];
        $student->fathername = $studentData['fathername'];
        $student->DOB = $studentData['DOB'];
        $student->joiningdate = $studentData['joiningdate'];
        $student->gender = $studentData['gender'];
        $student->address = $studentData['address'];
        $student->pincode = $studentData['pincode'];
        $student->community = $studentData['community'];
        $student->qualification = $studentData['qualification'];
        // $student->board = $studentData['board'];
        // $student->passing_year = $studentData['passing_year'];
        // $student->percentage = $studentData['percentage'];
        // $student->subjects = $studentData['subjects'];
        $student->save();

        $studentId = $student->id;

            $fees = StudentFees::where('student_id',$studentId)->latest('created_at')->first();
            $fees->student_id = $studentId;
            $fees->total_fees = $total_fees;
            $fees->total_paid_fees = $total_paid_fees;
            $fees->pending_fees = $pending_fees;
            if ($total_fees == $total_paid_fees) {
                $fees->next_due_date = null;
            } else {
                $fees->next_due_date = $next_due_date;
            }
            $fees->payment_date = $currentDate;
            $fees->pay_amount = $total_paid_fees;
            $fees->save();

          // Find all services belonging to the specific student
          $existingCourses = StudentCourse::where('student_id', $studentId)->pluck('course_id')->toArray();

          if (is_array($studentCourses) && count($studentCourses) > 0) {
              foreach ($studentCourses as $course) {
                $startBatch = $course['start_batch'];  
            $endBatch = $course['end_batch'];

            // Format the batch timing into the desired format ('H:i') to store in the database
            $formattedBatchTiming = $startBatch . ' to ' . $endBatch;

                  // Check if 'course' key exists in the current course data
                  if (isset($course['course']) && !empty($course['course'])) {
                    // Check if the course already exists for the student
                    if (in_array($course['course'], $existingCourses)) {
                        // Update the batch for the existing course
                        $existingCourse = StudentCourse::where('student_id', $studentId)
                                                        ->where('course_id', $course['course'])
                                                        ->first();                             
                       
                        $existingCourse->batch = $course['batch'];
                        $existingCourse->fees = $course['fees'];
                        $existingCourse->save();
                    } else {

                        
                        // The course does not exist, so proceed to add it
                        $newStudentCourse = new StudentCourse();
                        $newStudentCourse->course_id = $course['course'];
                        $newStudentCourse->batch = $course['batch'];
                        $newStudentCourse->fees = $course['fees'];
                        $newStudentCourse->student_id = $studentId;
                        $newStudentCourse->save();

                        if (is_array($studentCourses) && count($studentCourses) > 0) {
                            $selectedBatches = []; // Array to store selected batch IDs
                            
                            foreach ($studentCourses as $courseBatch) {
                                $batchId = $courseBatch['batch'];
                                
                                // Check if the batch is already selected for another course
                                if (in_array($batchId, $selectedBatches)) {
                                    return response()->json(['error' => 'Both courses cannot have the same batch.']);
                                }
                        
                                // Add the batch to the selected batches array
                                $selectedBatches[] = $batchId;

                               
                
                                 // Check if there is more than one batch selected
                                if (count($selectedBatches) > 1) {
                                    foreach ($selectedBatches as $batchId) {
                                        // Check if there are available seats
                                        $availableSeats = Batch::where('id', $batchId)->value('pending_seats');
                            
                                        if ($availableSeats === 0) {
                                            // If there are no available seats, show an error message
                                            return response()->json(['error' => 'Choose only one course, as both courses share the same batch with no available seats.']);
                                        }
                                    }
                                }
                            }
                        
                        
                            // Now proceed with decrementing the seat counts since everything is valid
                            foreach ($selectedBatches as $batchId) {
                                // Decrement the seat count
                                Batch::where('id', $batchId)->decrement('pending_seats', 1);
                            }
                        }
                     }
                    }
                }
            }

    }}


    

     // Clear the session data after saving
     $request->session()->forget('studentData');
     $request->session()->forget('student_courses');

    // Redirect or return a view as needed
    return redirect('/student-register-done');

    
    }

    public function clientsEdit4(Request $request)
    {
        // Retrieve data stored in different steps from the session
        $serviceData = $request->session()->get('storedServices');
        $clientData = $request->session()->get('clientData');

        // Find all services belonging to the specific username
        $existingServices = Service::where('username', $clientData['username'])->get();

        // Check if $serviceData is an array and existingServices has data
        if (is_array($serviceData) && count($serviceData) > 0) {
            foreach ($serviceData as $service) {
                // Check if 'service_id' exists in the current service data
                if (isset($service['service_id']) && !empty($service['service_id'])) {
                    // Update existing service based on service ID
                    $existingService = $existingServices->where('id', $service['service_id'])->first();
                    if ($existingService) {
                        // $existingService->duration_months = $service['duration'];
                        $durationInMonths = $service['duration'];
                        $currentDate = Carbon::now();
                        $expiry_date = $currentDate->addMonths($durationInMonths);
                        $existingService->duration_months = $service['duration'];
                        $existingService->expiry_date = $expiry_date;
                        $existingService->charges = $service['charges'];
                        $existingService->description = $service['description'];
                        $existingService->save();
                    }
                } else {
                    // Insert a new service
                    $newService = new Service();
                    $newService->username = $clientData['username'];
                    $newService->service = $service['service'];
                    $durationInMonths = $service['duration'];
                    $currentDate = Carbon::now();
                    $expiry_date = $currentDate->addMonths($durationInMonths);
                    $newService->duration_months = $service['duration'];
                    $newService->expiry_date = $expiry_date;
                    $newService->charges = $service['charges'];
                    $newService->description = $service['description'];
                    $newService->save();
                }
            }
        }



        // Update client data in the Client model based on the ID (assuming $clientData is not null)
        if (is_array($clientData) && !empty($clientData)) {
            $client = Client::find($clientData['user_id']);

            if ($client) {
                // Update username in Service table
                Service::where('username', $clientData['username'])->update(['username' => $clientData['username']]);
                $client->name = $clientData['name'];
                $client->username = $clientData['username'];
                $client->email = $clientData['email'];
                $client->phone = $clientData['phone'];
                $client->business_name = $clientData['business_name'];
                $client->password = $clientData['password'];
                $client->location = $clientData['location'];
                $client->whatsapp_number = $clientData['whatsapp_number'];
                $client->whatsapp_api = $clientData['whatsapp_api'];
                $client->sms_api = $clientData['sms_api'];
                $client->save();

            }
        }

        // Clear the session data after saving
        $request->session()->forget('storedServices');
        $request->session()->forget('payment');
        $request->session()->forget('clientData');

        // Redirect or return a view as needed
        return view('clients-edit-4');
    }


    public function updateStudents(Request $request, $id)
    {
        $course = Courses::findOrFail($id);

        $course->course_name = $request->input('course_name');
        $course->fees = $request->input('fees');
        $course->duration = $request->input('duration');
        $course->seats = $request->input('seats');
        $course->lab_number = $request->input('lab_number');
        $course->save();

        return redirect('/courses')->with('success', 'Courses updated successfully');
    }
    

    public function getCourseDetails($id)
{

    $course = Courses::find($id);
    

    // Check if course exists
    if ($course) {
        // Return course details as JSON response
        $lab = Lab::where('id',$course->lab_number)->value('lab_name');
        $seats = Lab::where('id',$course->lab_number)->value('seats');
        return response()->json([
            'fees' => $course->fees,
            'duration' => $course->duration,
            'lab_number' => $lab,
            'seats' => $seats,
        ]);
    } else {
        // Course not found, return an error
        return response()->json(['error' => 'Course not found'], 404);
    }
}

public function fetchSearchCourseName($courseId)
    {
        $course = Courses::find($courseId);

        if ($course) {
            return response()->json(['course_name' => $course->course_name]);
        } else {
            return response()->json(['course_name' => 'N/A']);
        }
    }


public function getMultipleCourseDetails($ids)
{
    // Decode the IDs from the URL parameters
    $decodedIds = explode(',', $ids);

    $courseDetails = [];

    foreach ($decodedIds as $id) {
        $course = Courses::find($id);

        if ($course) {
            // Return course details as part of the array
            $lab = Lab::where('id', $course->lab_number)->value('lab_name');
            $seats = Lab::where('id', $course->lab_number)->value('seats');
            $courseDetails[] = [
                'fees' => $course->fees,
                'duration' => $course->duration,
                'lab_number' => $lab,
                'seats' => $seats,
            ];
        } else {
            // Course not found, return an error for that course
            return response()->json(['error' => 'Course not found for id ' . $id], 404);
        }
    }

    // Return the array of course details
    return response()->json($courseDetails);
}



public function deleteEditSelectCourse(Request $request)
{

    $courseId = $request->input('courseId');
    $studentId = $request->input('studentId');

    try {
      
    
        // Find the student course record that matches both course_id and student_id
        $studentCourse = StudentCourse::where('course_id', $courseId)
            ->where('student_id', $studentId)
            ->first(); // Use first() instead of get()
    
            // Access batch property directly on the model instance
            $batchId = $studentCourse->batch;
    
            // Increment pending_seats for the corresponding batch
            Batch::where('id', $batchId)->increment('pending_seats', 1);
    
           
        $studentCourse->delete();

        return response()->json(['success' => true, 'message' => 'Service deleted successfully']);
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => 'Unable to delete service'], 500);
    }


}

public function getCourseList()
    {   
        $client_id = session('client_id');
        // Fetch courses from the database
        $courses = Courses::where('client_id',$client_id)->get(); // Or use any query to retrieve your courses
        
        // Return the courses as JSON response
        return response()->json($courses);
    }

    public function viewbatches()
    {
        $batches = Courses::paginate(10);
        return view('batch')->with('courses', $batches);
    }




    public function store(Request $request)
{
    $validatedData = $request->validate([
        'name' => 'required',
        'username' => 'required|unique:clients', // Assuming 'clients' is the table name
        'email' => 'required|email|unique:clients', // Assuming 'clients' is the table name
        'phone' => 'required|unique:clients',
        'business_name' => 'required',
        'location' => 'required',
        'password' => 'required',
        'whatsapp_number' => 'nullable',
        'whatsapp_api' => 'nullable',
        'sms_api' => 'nullable',
    ]);

    // Check if the email already exists in the database
    $existingEmail = Client::where('email', $validatedData['email'])->first();
    if ($existingEmail) {
        // Email already exists, return with an error message
        return redirect('/create-client-2')->withErrors(['email' => 'Email already exists.'])->withInput($request->except('email'));
    }

    // Check if the username already exists in the database
    $existingUsername = Client::where('username', $validatedData['username'])->first();
    if ($existingUsername) {
        // Username already exists, return with an error message
        return redirect('/create-client-2')->withErrors(['username' => 'Username already exists.'])->withInput($request->except('username'));
    }

    // If email and username are unique, store the data in the session
    $request->session()->put('clientData', $validatedData);
    session(['clientinfo' => $validatedData]);

    return view('clients-create-3');
}


    public function clientsEdit3(Request $request)
    {

        $clientdata = $request->all();

        // dd($clientdata);

        $client_id = $clientdata['user_id'];

        $clientPayment = ClientPayments::where('client_id',$client_id)->latest('created_at')->first();

       
        $request->session()->put('clientData', $clientdata);
        session(['clientinfo' => $clientdata]);

        return view('clients-edit-3',['clientPayment' => $clientPayment]);
    }


    public function delete(Request $request)
    {
        $selectedClients = $request->input('selected_clients');

        if ($selectedClients) {
            $clients = Client::whereIn('id', $selectedClients)->get();

            if ($clients) {
                foreach ($clients as $client) {
                    // Delete associated services based on username
                    Service::where('username', $client->username)->delete();
                    ClientPayments::where('client_id', $client->id)->delete();
                    Courses::where('client_id', $client->id)->delete();
                    Lab::where('client_id', $client->id)->delete();
                    Enquiry::where('client_id', $client->id)->with('followups')->delete();
                    Students::where('client_id', $client->id)->with('studentCourses','fees')->delete();
                }

                // Delete selected clients
                Client::whereIn('id', $selectedClients)->delete();

                return redirect()->back()->with('success', 'Selected clients and associated services have been deleted.');
            }
        }

        return redirect()->back()->with('error', 'No clients were selected for deletion.');
    }

    public function deleteSingleClient(Request $request,$id)
    {

        if ($id) {
            $clients = Client::where('id', $id)->get();

            if ($clients) {
                foreach ($clients as $client) {
                    // Delete associated services based on username
                    Service::where('username', $client->username)->delete();
                    ClientPayments::where('client_id', $client->id)->delete();
                    Courses::where('client_id', $client->id)->delete();
                    Lab::where('client_id', $client->id)->delete();
                    Enquiry::where('client_id', $client->id)->with('followups')->delete();
                    Students::where('client_id', $client->id)->with('studentCourses','fees')->delete();
                }

                // Delete selected clients
                Client::where('id', $id)->delete();

                return redirect()->back()->with('success', 'Client Deleted Succesfully');
            }
        }

        return redirect()->back()->with('error', 'No clients were selected for deletion.');
    }

    public function searchClients(Request $request)
{
    $search = $request->input('searchText');
    
    // Perform the search using the query
    $clients = Client::where('name', 'LIKE', "%$search%")
                    ->orWhere('email', 'LIKE', "%$search%")
                    ->orWhere("phone", "LIKE", "%$search%")
                    ->get();

    if ($clients->isNotEmpty()) {

        // Pass the retrieved data to the view for rendering
        return response()->json(['clients' => $clients,'query' => $search]);
    } else {
        // Handle case when the student with the given number is not found
        return response()->json(['error' => 'Enquiry not found']);
    }
}

public function searchEnquiry(Request $request)
{
    $client_id = session('client_id');
    $search = $request->input('searchText');


    $enquiry = Enquiry::where('client_id', $client_id)->with('course')
    ->where(function ($query) use ($search) {
        $query->where("name", "LIKE", "%$search%")
            ->orWhere("phone", "LIKE", "%$search%");
    });

    $enquiries = $enquiry->get();


    if ($enquiries->isNotEmpty()) {
           
        // Pass the retrieved data to the view for rendering
        return response()->json(['enquiry' => $enquiries,'query' => $search]);
    } else {
        // Handle case when the student with the given number is not found
        return response()->json(['error' => 'Enquiry not found']);
    }
    
    

}



public function searchStudents(Request $request)
{   
    
    $client_id = session('client_id');
    $search = $request->input('searchText');

    $student = Students::where('client_id', $client_id)->with('studentCourses','courses')
    ->where(function ($query) use ($search) {
        $query->where("name", "LIKE", "%$search%")
            ->orWhere("email", "LIKE", "%$search%")
            ->orWhere("phone", "LIKE", "%$search%");
    });

    $students = $student->get();


    if ($students->isNotEmpty()) {
           
        // Pass the retrieved data to the view for rendering
        return response()->json(['students' => $students,'query' => $search]);
    } else {
        // Handle case when the student with the given number is not found
        return response()->json(['error' => 'Student not found']);
    }
    

}



public function viewlabs()
{   
    $client_id = session('client_id');
    
    $labs = Lab::where('client_id', $client_id)->paginate(50);
    return view('lab')->with('labs', $labs);
}

public function addlab()
{
    $courses = Courses::all();
    return view('add-lab', ['courses' => $courses]);

}

public function fetchSeats($batchId)
{
    $batch = Batch::where('id', $batchId)->first();

    if (!$batch) {
        return response()->json(['error' => 'Batch not found'], 404);
    }

    $totalSeats = $batch->total_seats;
    $pendingSeats = $batch->pending_seats;

    return response()->json([
        'total_seats' => $totalSeats,
        'pending_seats' => $pendingSeats,
    ]);
}



public function savelab(Request $request)
{
    // Validate incoming request data
    $validatedData = $request->validate([
        'lab_name' => 'required',
        'start_batch' => 'required|array',
        'end_batch' => 'required|array',
        'seats' => 'required|array',
        'client_id' => 'required',
    ]);

    // Create a new Lab entry
    $lab = new Lab();
    $lab->lab_name = $validatedData['lab_name'];
    $lab->client_id = $validatedData['client_id'];
    $lab->save();

    // Extract batch and seat data
    $startBatches = $validatedData['start_batch'];
    $endBatches = $validatedData['end_batch'];
    $seats = $validatedData['seats'];

    // Loop through each batch and save it
    foreach ($startBatches as $index => $startBatch) {
        // Format the batch timing into the desired format ('H:i') to store in the database
        $formattedBatchTiming = $startBatch . ' to ' . $endBatches[$index];

        // Create a new Batch entry for each batch
        $batch = new Batch();
        $batch->batch = $formattedBatchTiming;
        $batch->pending_seats = $seats[$index];
        $batch->total_seats = $seats[$index];
        $batch->lab_id = $lab->id; // Associate the batch with the newly created lab
        $batch->client_id = $validatedData['client_id'];
        $batch->save();
    }

    return redirect('/labs');
}




public function editlab($id)
{
    $labs = Lab::findOrFail($id);
    $batch = Batch::where('lab_id',$id)->get();
    return view('edit-lab', compact('labs','batch'));
}

public function deleteBatch($id)
    {
        $batch = Batch::find($id);
        if (!$batch) {
            return response()->json(['success' => false, 'message' => 'Batch not found'], 404);
        }

        $batch->delete();
        return response()->json(['success' => true, 'message' => 'Batch deleted successfully']);
    }

public function updateLab(Request $request, $id)
{   
    // Validate incoming request data
    $validatedData = $request->validate([
        'lab_name' => 'required',
        'start_batch' => 'required|array',
        'end_batch' => 'required|array',
        'seats' => 'required|array',
        'pending_seats' => 'array',
        'batch_id' => 'array',
    ]);

    // dd($validatedData);
   
    // Create a new Lab entry
    $lab = Lab::findOrFail($id);
    $lab->lab_name = $validatedData['lab_name'];
    $lab->save();

    // Extract batch and seat data
    $startBatches = $validatedData['start_batch'];
    $endBatches = $validatedData['end_batch'];
    $seats = $validatedData['seats'];
    $pending_seats = $validatedData['pending_seats'];
    $batch_id = $validatedData['batch_id'];

 

    // Loop through each batch and save it
    foreach ($startBatches as $index => $startBatch) {
        // Format the batch timing into the desired format ('H:i') to store in the database
        $formattedBatchTiming = $startBatch . ' to ' . $endBatches[$index];

        // Check if batch ID exists
        if (isset($batch_id[$index]) && $batch_id[$index] !== '') {
            // Update existing batch
            $batch = Batch::findOrFail($batch_id[$index]);
            $batch->batch = $formattedBatchTiming;
            $batch->pending_seats = $pending_seats[$index];
            $batch->total_seats = $seats[$index];
            $batch->save();
        } else {
            // Create a new Batch entry for each batch without a batch ID
            $newBatch = new Batch();
            $newBatch->batch = $formattedBatchTiming;
            $newBatch->pending_seats = $seats[$index];
            $newBatch->total_seats = $seats[$index];
            $newBatch->lab_id = $lab->id;
            $newBatch->client_id = $lab->client_id; // You may need to adjust this depending on your application logic
            $newBatch->save();
        }
    }



    return redirect('/labs');
}

 
public function removelab(Request $request)
{   
    $selectedService = $request->input('selected_lab');

    if ($selectedService) {
        Lab::whereIn('id', $selectedService)->delete();
        Batch::whereIn('lab_id', $selectedService)->delete();

        return redirect()->back()->with('success', 'Selected Service have been deleted.');
    }

    return redirect()->back()->with('error', 'No Service were selected for deletion.');
}

public function fees(){
    $client_id = session('client_id');
    $courses = Courses::where('client_id', $client_id)->get();
    return view('fees')->with('courses',$courses);
}

public function feesdetail(Request $request ){
   
    $student_id = $request->query('student_id');

    $students = Students::where('id',$student_id)->with('courses')->get();

    foreach ($students as $student) {
        // Access the courses collection for the current student
        $courses = $student->courses;
    
        // Loop through each course for the current student
        foreach ($courses as $course) {
            // Access the course name from the course object
            $courseName = $course->course_name;
          
        }

    }

    return view('fees-detail',compact('students'));
}

public function GetStudentsThroughNumber(Request $request)
    {   
        $client_id = session('client_id');
        // Retrieve input data from AJAX request
        $studentNumber = $request->input('studentNumber');
        $courseId = $request->input('courseId');
        $labNumber = $request->input('labNumber');
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');

        // Initialize the query for students
    $studentsQuery = Students::where('client_id', $client_id);

    // Check if the course ID is provided and not equal to 0
    if ($courseId !== '0' && !empty($courseId)) {
        // Filter students based on the selected course
        $studentsQuery->whereHas('courses', function ($query) use ($courseId) {
            $query->where('course_id', $courseId);
        });
    }

    // Check if both start date and end date are provided
    if (!empty($startDate) && !empty($endDate)) {
        $studentsQuery->whereHas('studentCourses', function ($query) use ($startDate, $endDate) {
            $query->where(function ($query) use ($startDate, $endDate) {
                $query->whereBetween('created_at', [$startDate, $endDate])
                    ->orWhereDate('created_at', $startDate)
                    ->orWhereDate('created_at', $endDate);
            });
        });
    }
    

    // Filter students by phone number
    $studentsQuery->where("phone", "LIKE", "%$studentNumber%");

    // Get the students matching the criteria
    $student = $studentsQuery->with('courses')->get();

    $labs = collect(); // Create an empty collection to store unique lab records

    foreach ($student as $data) {
        $courses = $data->courses;

        foreach ($courses as $key) {
            $lab = Lab::where('id', $key->lab_number)->first(); // Retrieve lab data for the course
            if ($lab) {
                $labs->push($lab); // Add the lab data to the collection
            }
        }
    }
    // $lab = $student->courses->lab_number;


        if ($student->isNotEmpty()) {
           
            // Pass the retrieved data to the view for rendering
            return response()->json(['student' => $student,'lab' => $labs]);
        } else {
            // Handle case when the student with the given number is not found
            return response()->json(['error' => 'Student not found']);
        }
    }


    public function addnewfees(Request $request){

        $student_id = $request->input('student_id');
        $total_paid_fees = $request->input('total_paid_fees');
        $pending_fees = $request->input('pending_fees');
        $next_due_date = $request->input('next_due_date');
        $totalFees = $request->input('totalFees');
        $payable_fees = $request->input('payable_fees');
        $currentDate = date("Y-m-d");
        
        $fees = new StudentFees();
        $fees->student_id = $student_id;
        $fees->total_paid_fees = $total_paid_fees;
        $fees->pending_fees = $pending_fees;
        $fees->next_due_date = $next_due_date;
        $fees->payment_date = $currentDate;
        $fees->total_fees = $totalFees;
        $fees->pay_amount = $payable_fees;
        $fees->save();

        return response()->json(['total_paid_fees' => $total_paid_fees,'pending_fees'=>$pending_fees]);

    }

    public function editnewfees(Request $request){

        $student_id = $request->input('student_id');
        $total_paid_fees = $request->input('total_paid_fees');
        $pending_fees = $request->input('pending_fees');
        $next_due_date = $request->input('next_due_date');
        $totalFees = $request->input('totalFees');
        $payable_fees = $request->input('payable_fees');
        $currentDate = date("Y-m-d");
        
        $fees =  StudentFees::where('student_id',$student_id)->latest('created_at')->first();
        $fees->total_paid_fees = $total_paid_fees;
        $fees->pending_fees = $pending_fees;
        $fees->next_due_date = $next_due_date;
        $fees->payment_date = $currentDate;
        $fees->total_fees = $totalFees;
        $fees->pay_amount = $payable_fees;
        $fees->save();

        return response()->json(['total_paid_fees' => $total_paid_fees,'pending_fees'=>$pending_fees]);

    }

    public function getupcomingfees(Request $request)
    {
        $clientId = session('client_id');
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');
        $feeType = $request->input('feeType');
    
        $students = StudentFees::whereHas('student', function ($query) use ($clientId) {
            $query->where('client_id', $clientId);
        })
            ->with('student')
            ->with('studentcourse.course')
            ->when($feeType === 'upcoming', function ($query) use ($startDate, $endDate) {
                $query->whereBetween('next_due_date', [$startDate, $endDate]);
            })
            ->when($feeType === 'upcoming', function ($query) use ($startDate, $endDate) {
                $query->whereIn('id', function ($query) use ($startDate, $endDate) {
                    $query->selectRaw('MAX(id) as max_id')
                        ->from('fees')
                        ->whereBetween('created_at', [$startDate, $endDate])
                        ->groupBy('student_id');
                });
            })
            ->when($feeType === 'paid', function ($query) use ($startDate, $endDate) {
                $query->whereBetween('payment_date', [$startDate, $endDate]);
            })
            ->when($feeType === 'pending', function ($query) {
                $query->where('pending_fees', '>', 0);
            })
            ->when($feeType === 'completed', function ($query) {
                $query->where('pending_fees', '=', 0);
            })
            ->when($feeType !== 'upcoming', function ($query) {
                $query->whereIn('id', function ($query) {
                    $query->selectRaw('MAX(id) as max_id')
                        ->from('fees')
                        ->groupBy('student_id');
                });
            })
            ->get();
    
        return response()->json(['students' => $students]);
    }
    

public function upcomingbirthdays(Request $request)
{  
    $client_id = session('client_id');
    // Get the current day and month
    $currentDay = now()->format('d');
    $currentMonth = now()->format('m');

    // Fetch students from the students table whose birth day and month match the current day and month
    $students = Students::whereRaw('DAY(DOB) = ? AND MONTH(DOB) = ?', [$currentDay, $currentMonth])
        ->where('client_id',$client_id)
        ->get();

    return view('upcoming-birthdays')->with('students',$students);
}


public function sendBirthdayMessage(Request $request, $number)
{
    // Your Twilio API credentials
    $sid = 'ACc110dc8918fb1c19d991801d3aae5c30';
    $token = '3cc4484781588f20692d6dc56243a654';
    $twilio_number = '+15025120048'; // Use your Twilio phone number

    $client = new \Twilio\Rest\Client($sid, $token);

    // Assuming you receive the student's phone number via the request
    $studentPhoneNumber = '+91' . $number; // Concatenating country code

    // Check if phone number is not null before sending the message
    if ($studentPhoneNumber !== null) {
        try {
            // Send a birthday message via SMS
            $message = $client->messages->create(
                $studentPhoneNumber, // Student's phone number
                [
                    'from' => $twilio_number,
                    'body' => 'Happy Birthday! 🎉🎂' // Your birthday message
                ]
            );

            // Redirect back with a success message
            return back()->with('success', 'Birthday message sent successfully');
        } catch (\Exception $e) {
            // Redirect back with an error message
            return back()->with('error', 'Failed to send birthday message: ' . $e->getMessage());
        }
    } else {
        // Redirect back with a message if phone number is null
        return back()->with('error', 'Recipient phone number is empty');
    }
}

public function goDashboard() {
    return view('dashboard');
}

public function clientDashboard() {
    return view('admin-dashboard');
}

public function getPaymentLogs($studentId)
{
    // Fetch payment details based on the student ID
    $fees = StudentFees::where('student_id', $studentId)->get();

    // Return a JSON response
    return response()->json([
        'success' => true,
        'paymentLogs' => $fees,
    ]);
}




}
