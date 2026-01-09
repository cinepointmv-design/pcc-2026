<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Client;
use App\Models\AllService;
use App\Models\ClientPayments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class ServiceController extends Controller
{
    public function create()
    {
    }

    public function storeservice(Request $request)
{
    // Retrieve service form data from the request
    $serviceData = $request->input('serviceData');

    // Ensure $serviceData is not null and is an array before proceeding
    if (!empty($serviceData) && is_array($serviceData)) {
        // Reset the previously stored services in the session
        $request->session()->forget('storedServices');
        
        // Initialize an empty array for storing services
        $storedServices = [];

        // Add the new service data to the stored services array
        foreach ($serviceData as $newService) {
            // Check if $newService has the necessary keys
            if (isset($newService['service_name'])) {
                $storedServices[] = $newService;
            }
        }

        // Store the updated array back in the session
        $request->session()->put('storedServices', $storedServices);
    }

    return view('clients-create'); // Return the desired view after storing the data
}


    public function viewservice()
    {
        $service = AllService::paginate(50);
        // Pass the client data to the view
        return view('service')->with('service', $service);
    }

    public function saveservice(Request $request)
    {
        // Retrieve data stored in different steps from the session
        $serviceData = $request->all();
        $service = new AllService();
        $service->name = $serviceData['service'];
        $service->price = $serviceData['charges'];
        $service->save();
        return redirect('/service');
    }

    public function editService($id)
    {
        $service = AllService::findOrFail($id);
        return view('edit-service', compact('service'));
    }

    public function updateService(Request $request, $id)
    {
        $service = AllService::findOrFail($id);

        $service->name = $request->input('service');
        $service->price = $request->input('charges');

        $service->save();

        return redirect('/service')->with('success', 'Service updated successfully');
    }


    public function payment()
    {
        $clients = Client::with('services')->paginate(50);

        // Pass the client data with associated services to the view
        return view('payments')->with('clients', $clients);
    }



    public function removeservice(Request $request)
    {   
        $selectedService = $request->input('selected_service');

        if ($selectedService) {
            AllService::whereIn('id', $selectedService)->delete();

            return redirect()->back()->with('success', 'Selected Service have been deleted.');
        }

        return redirect()->back()->with('error', 'No Service were selected for deletion.');
    }


    public function getservice(Request $request)
    {   
        // Clear the session data after saving
        $request->session()->forget('storedServices');
        $request->session()->forget('payment');
        $request->session()->forget('clientData');

        $serviceName = AllService::all(); // Fetch all services from the database

        return view('clients-create-2')->with('serviceName', $serviceName);
    }

    public function getServicePrice(Request $request)
    {
        $serviceId = $request->input('service_id');
        $duration = $request->input('duration');

        $service = AllService::find($serviceId);

        if ($service) {
            $price = $service->price * $duration; // Multiply service price by duration
            return response()->json(['success' => true, 'price' => $price]);
        }

        return response()->json(['success' => false]);
    }


    public function storepayment(Request $request)
    {


        // Retrieve the values from the request
        $total_fees = $request->input('total_payment');
        $pending_fees = $request->input('pending_amount');
        $next_due_date = $request->input('next_due_date');
        $payable_fees = $request->input('payable_amount');
        $currentDate = date("Y-m-d");

        // Create an array containing the payment details
        $payment = [
            'total_payment' => $total_fees,
            'pending_amount' => $pending_fees,
            'next_due_date' => $next_due_date,
            'payable_amount' => $payable_fees,
            'current_date' => $currentDate,
        ];

        // Store the payment details in the session
        $request->session()->put('payment', $payment);

        
        // Redirect to a confirmation page or any other view
        return redirect('/save-client');
    }

    public function editstorepayment(Request $request)
    {

        // Retrieve the values from the request
        $total_fees = $request->input('total_payment');
        $total_paid_amount = $request->input('total_paid_amount');
        $pending_fees = $request->input('pending_amount');
        $next_due_date = $request->input('next_due_date');
        $payable_fees = $request->input('payable_amount');
        $currentDate = date("Y-m-d");

        // Create an array containing the payment details
        $payment = [
            'total_payment' => $total_fees,
            'total_paid_amount' => $total_paid_amount,
            'pending_amount' => $pending_fees,
            'next_due_date' => $next_due_date,
            'payable_amount' => $payable_fees,
            'current_date' => $currentDate,
        ];

        // Store the payment details in the session
        $request->session()->put('payment', $payment);

        
        // Redirect to a confirmation page or any other view
        return redirect('/save-edit-client');
    }

    public function savedata(Request $request)
    {
        // Retrieve data stored in different steps from the session
        $serviceData = $request->session()->get('storedServices');
        $paymentData = $request->session()->get('payment');
        $clientData = $request->session()->get('clientData');

        if ($serviceData && $paymentData && $clientData) {

             // Check if $serviceData is an array before iterating through it
    if (is_array($serviceData) && count($serviceData) > 0) {
        foreach ($serviceData as $service) {
            // Save service to the database
            $newService = new Service();
            $newService->username = $clientData['username'];
            $newService->service = $service['service_name']; // Access 'service_name' key for service name
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

        // Save client data to the Client model (assuming $clientData is not null)
        if (is_array($clientData) && !empty($clientData)) {
            $client = new Client();
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

            $client_id = $client->id;

            $payment = new ClientPayments();
            $payment->client_id = $client_id;
            // $payment->total_payment = $paymentData['total_payment'];
            // $payment->total_paid_amount = $paymentData['payable_amount'];
            // $payment->pending_amount = $paymentData['pending_amount'];
            // $payment->next_due_date = $paymentData['next_due_date'];
            // $payment->payment_date = $currentDate;
            // $payment->pay_amount = $paymentData['payable_amount'];
            // $payment->save();

            if ($payment) {
                $payment->total_payment = $paymentData['total_payment'];
                $payment->total_paid_amount = $paymentData['payable_amount'];
                $payment->pay_amount = $paymentData['payable_amount'];
                $payment->pending_amount = $paymentData['pending_amount'];
            
                if ($paymentData['total_payment'] == $paymentData['payable_amount']) {
                    $payment->next_due_date = null;
                } else {
                    $payment->next_due_date = $paymentData['next_due_date'];
                }
                $payment->payment_date = $currentDate;
                $payment->save();
            }
        }

        // Clear the session data after saving
        $request->session()->forget('storedServices');
        $request->session()->forget('payment');
        $request->session()->forget('clientData');

        // Redirect or return a view as needed
        return redirect('/clients-create-4');

        }else{
          
          echo "error";  

        }    


       
    }


    public function clientsEdit1($id)
    {
        $client = Client::find($id);

        if ($client) {
            $services = $client->services;
            return view('clients-edit-2', compact('services', 'client'));
        } else {
            echo "not found";
        }
    }

    public function paymentedit($id)
    {
        $client = Client::find($id);
        $servicePrices = []; // Array to store service prices

        if ($client) {
            $services = Service::where('username', $client->username)->get();

            foreach ($services as $service) {
                $allService = AllService::where('name', $service->service)->first();

                if ($allService) {
                    $servicePrices[$service->service] = $allService->price;
                } else {
                    $servicePrices[$service->service] = null;
                }
            }

            return view('clients-payment-edit', compact('services', 'client', 'servicePrices'));
        } else {
            return "Client not found";
        }
    }



    public function clientsEdit2(Request $request)
    {
        $user_id = $request->input('user_id');

        $client = Client::findOrFail($user_id);

        // Retrieve service form data from the request
        $serviceData = $request->input('services');

        // Ensure $serviceData is not null and is an array before proceeding
        if (!empty($serviceData) && is_array($serviceData)) {
            // Reset the previously stored services in the session
            $request->session()->forget('storedServices');

            // Check if any of the services in $serviceData already exist in $storedServices
            foreach ($serviceData as $newService) {
                // Check if $newService has the necessary keys
                if (isset($newService['service'])) {
                    // Add the new service data to the existing array of services
                    $storedServices[] = $newService;
                    
                }
            }

            // Store the updated array back in the session
            $request->session()->put('storedServices', $storedServices);
        }
        
        return view('clients-edit', compact('client'));
  }

    public function deleteService(Request $request)
    {
        $serviceId = $request->input('service_id');

        try {
            $service = Service::findOrFail($serviceId);
            // Perform deletion logic
            $service->delete();

            return response()->json(['success' => true, 'message' => 'Service deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Unable to delete service'], 500);
        }
    }



    public function clientsEdit4(Request $request)
    {  
    
        // Retrieve data stored in different steps from the session
        $serviceData = $request->session()->get('storedServices');
        $clientData = $request->session()->get('clientData');
        $paymentData = $request->session()->get('payment');

        // dd($paymentData);

        if ($serviceData && $paymentData && $clientData) {

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

                $payment = ClientPayments::where('client_id',$clientData['user_id'])->latest('created_at')->first();
                if ($payment) {
                    $payment->total_payment = $paymentData['total_payment'];
                    $payment->total_paid_amount = $paymentData['payable_amount'];
                    $payment->pay_amount = $paymentData['payable_amount'];
                       
                
                    if ($paymentData['total_payment'] == $paymentData['payable_amount']) {
                        $payment->next_due_date = null;
                    } else {
                        $payment->next_due_date = $paymentData['next_due_date'];
                    }
                    
                    $payment->pending_amount = $paymentData['pending_amount'];
                    $payment->payment_date = $currentDate;
                    $payment->save();
                }

            }
        }

        // Clear the session data after saving
        $request->session()->forget('storedServices');
        $request->session()->forget('payment');
        $request->session()->forget('clientData');

        // Redirect or return a view as needed
        return redirect('/clients-edit-4');

    } else {
        
        return redirect()->back()->withErrors(['error' => "Student Not Updated"]);
    }

    }



    public function getServiceId(Request $request)
    {
        $serviceName = $request->input('service_name');


        try {
            $service = AllService::where('name', $serviceName)->first();

            if ($service) {
                return response()->json([
                    'success' => true,
                    'service_id' => $service->id
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'error' => 'Service not found'
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage() // Log the error message
            ]);
        }
    }

    public function getAllServices()
    {
        $services = AllService::all(); // Fetch all services from the AllService model

        return response()->json([
            'success' => true,
            'services' => $services
        ]);
    }

    public function savepaymentedit(Request $request)
    {
        $serviceData = $request->input('serviceData');

        if ($serviceData && is_array($serviceData)) {
            foreach ($serviceData as $data) {
                $service = Service::find($data['service_id']); // Assuming 'service_id' exists in the $serviceData array

                if ($service) {
                    // Update service details
                    $durationInMonths = $data['duration'];
                    $currentDate = Carbon::now();
                    $expiry_date = $currentDate->addMonths($durationInMonths);
                    $service->duration_months = $data['duration'];
                    $service->expiry_date = $expiry_date;
                    $service->charges = $data['charges'];
                    $service->description = $data['description'];
                    $service->save();
                }
            }

            // Redirect or return response after updating services
            return redirect('/client-service'); // For redirecting back to the previous page
        }

        return redirect('/client-service');
    }


    public function viewClientPayment(){

        $client_id = ClientPayments::whereNotNull('next_due_date')
                               ->latest('created_at') 
                               ->pluck('client_id');

        $clients = Client::where('id',$client_id)->with('services','payments')->get();  

        return view('view-client-payment')->with('clients', $clients);

    }

    public function addNewPayment($id){

        $clients = Client::where('id',$id)->with('services','payments')->get();  

        return view('add-client-payment')->with('clients', $clients);

    }





}
