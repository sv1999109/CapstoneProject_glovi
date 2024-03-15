<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Models\PostCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Item;
use Illuminate\Support\Facades\Validator;
use App\Services\ShippoService;

use Shippo;
use Shippo_Object;
use Shippo_Address;
use Shippo_Parcel;
use Shippo_Shipment;
use Shippo_Transaction;

class FrontendController extends Controller

{



    public function index()

    {
        $data['page_title'] = get_content_locale(get_config('site_tagline'));
        return view(get_theme_dir('home.index'))->with([
            'page_title' => $data['page_title'],
        ]);
    }

    public function contact()

    {
        $data['page_title'] = __('messages.Contact_Us');
        return view(get_theme_dir('contents.contact'))->with([
            'page_title' => $data['page_title'],
        ]);
    }

    public function contact_submit(Request $request)

    {
        $validate = Validator::make($request->all(), [
            'email' => 'required|email',
            'message' => 'required',
            'name' => 'required|string|min:2|max:100',
            'status' => 'nullable',
        ]);
        if ($validate->fails()) {
            return back()
                ->withErrors($validate)
                ->withInput();
        }
        $subject = trans_choice('messages.New_Contact_Message', 1) . ': ' . $request->subject;

        // prepare mail contents
        $messages = trans_choice('messages.Name', 1) . ': ' . $request->name;
        $messages .= "\n";
        $messages .= trans_choice('messages.Email', 1) . ': ' . $request->email;
        $messages .= "\n";
        $messages .= "\n";
        $messages .= trans_choice('messages.Message', 1) . ': ' . $request->message;

        //mail support
        mail(get_config('site_email_support'),  $subject, $messages);
        return back()->with('message', trans_choice('messages.New_Contact_Message_Response', 1));
    }

    public function quote()

    {
        $data['page_title'] = __('messages.GET_A_QUOTE');
        return view(get_theme_dir('contents.quote'))->with([
            'page_title' => $data['page_title'],
        ]);
    }

    public function quote_submit(Request $request)

    {
        $validate = Validator::make($request->all(), [
            'email' => 'required|email',
            'Sender_Address' => 'required',
            'Receiver_Address' => 'required',
            'name' => 'nullable|string|min:2|max:100',
            'Weight_Kg' => 'required',
            'Dimension_L_H_W' => 'required',
        ]);
        if ($validate->fails()) {
            return back()
                ->withErrors($validate)
                ->withInput();
        }
        $subject = trans_choice('messages.New_Quote_Request', 1) . ': ' . $request->subject;

        // prepare mail contents
        $messages = trans_choice('messages.Dimension_L_H_W', 1) . ': ' . $request->Dimension_L_H_W;
        $messages .= "\n";
        $messages .= trans_choice('messages.Weight_Kg', 1) . ': ' . $request->Weight_Kg;
        $messages .= "\n";
        $messages .= trans_choice('messages.Sender_Address', 1) . ': ' . $request->Sender_Address;
        $messages .= "\n";
        $messages .= trans_choice('messages.Receiver_Address', 1) . ': ' . $request->Receiver_Address;
        $messages .= "\n";
        $messages .= trans_choice('messages.Name', 1) . ': ' . $request->name;
        $messages .= "\n";
        $messages .= trans_choice('messages.Email', 1) . ': ' . $request->email;
        $messages .= trans_choice('messages.Phone', 1) . ': ' . $request->phone;
        $messages .= "\n";
        $messages .= "\n";
        $messages .= trans_choice('messages.Message', 1) . ': ' . $request->message;

        //mail support
        mail(get_config('site_email_support'),  $subject, $messages);
        return back()->with('message', trans_choice('messages.New_Contact_Message_Response', 1));
    }


    public function show_posts(Request $request)

    {
        if ($request->cat) {
            $category = Category::where('id', $request->cat)->first();
            // does category exist
            if ($category) {
                $page_title = get_content_locale($category->name);
                $posts = $category->post()->latest()->paginate(10);
            } else {
                $page_title = trans_choice('messages.Blog', 2);
                $posts = Post::whereRaw("post_type = 'blog' AND post_status = '1'")->orderByDesc('created_at')->paginate(10);
            }
        } else {

            $posts = Post::whereRaw("post_type = 'blog' AND post_status = '1'")->orderByDesc('created_at')->paginate(10);
            $page_title = trans_choice('messages.Blog', 2);
        }

        return view(get_theme_dir('contents/index'), compact('posts', 'page_title'));
    }
    public function show_single_post($slug)

    {
        $post = Post::whereRaw("post_slug = '$slug'")->first();
        if (is_numeric($slug)) {
            $post = Post::whereRaw("id = '$slug'")->first();
        }
        if ($post) {
            $data['page_title'] = get_content_locale($post->post_title);

            //update views
            Post::where('post_slug', $slug)->update(['post_view' => $post->post_view + 1]);
            return view(get_theme_dir('contents/single'))->with([
                'page_title' => $data['page_title'],
                'post' => $post,
                'type' => $post->post_type
            ]);
        } else {
            return view('errors/404');
        }
    }


    public function show_page($page)

    {
        $list = get_contents_list();
        if (in_array($page, $list)) {
            $trans_val = ucfirst($page);
            $page_title = trans_choice("messages.{$trans_val}", 2);

            $pages = Post::where('post_type', $page)->orderByDesc('created_at')->paginate(10);

            return view(get_theme_dir('contents/page'), compact('pages', 'page', 'page_title'));
        } else {
            return view('errors/404');
        }
    }



    // playground
    public function createShipment(Request $request, ShippoService $shippoService)
    {

        // $tracking = $shippoService->TrackShipment([
        //     'id' => 'SHIPPO_DELIVERED',
        //     'carrier' => 'shippo'
        // ]);
        // echo $tracking ."<br><br>";
        // exit;


        // Retrieve shipment details from the request
        // $shipmentDetails = [
        //     'address_from' => [
        //         'object_state' => 'VALID',
        //         'name' => 'Endy Code',
        //         'street1' => 'Rue Walthere Jamar 147',
        //         'city' => 'Ans',
        //         'state' => 'Liège',
        //         'zip' => '4430',
        //         'country' => 'BE',
        //         'phone' => $request->input('from_phone'),
        //         'email' => $request->input('from_email')
        //     ],
        //     'address_to' => [
        //         'name' => $request->input('from_name'),
        //         'street1' => $request->input('from_street'),
        //         'city' => $request->input('from_city'),
        //         'state' => $request->input('from_state'),
        //         'zip' => $request->input('from_zip'),
        //         'country' => $request->input('from_country'),
        //         'phone' => $request->input('from_phone'),
        //         'email' => $request->input('from_email')
        //     ],
        //     'parcels' => [
        //         [
        //             'length' => $request->input('parcel_length'),
        //             'width' => $request->input('parcel_width'),
        //             'height' => $request->input('parcel_height'),
        //             'distance_unit' => 'in',
        //             'weight' => $request->input('parcel_weight'),
        //             'mass_unit' => 'lb'
        //         ],
        //     ]
        // ];

        $shipmentDetails = [
            // 'address_from' => [
            //     'object_state' => 'VALID',
            //     'name' => 'Endy Doe',
            //     'street1' => '25 Rue du Faubourg Saint-Honoré',
            //     'city' => 'Paris',
            //     'state' => 'Paris',
            //     'zip' => '75008',
            //     'country' => 'FR',
            //     'phone' => '+33 1 98 76 54 32',
            //     'email' => 'joe.doe@example.com',

            // ],
            // 'address_to' => [
            //     'object_state' => 'VALID',
            //     'name' => 'John Doe',
            //     'street1' => '456 Robson Street',
            //     'city' => 'Vancouver',
            //     'state' => 'BC',
            //     'zip' => 'V6B 2B2',
            //     'country' => 'CA',
            //     'phone' => '+1 604-555-5678',
            //     'email' => 'john.doe@example.com'

            // ],
            'address_from' => '127b1fedc050408c8c3532c01cb5aeff',
            'address_to' => '285f7b1621c245f786c886d12ad1339f',
            'parcels' => [
                [
                    'length' => 10,
                    'width' => 6,
                    'height' => 4,
                    'distance_unit' => 'in',
                    'weight' => 2,
                    'mass_unit' => 'lb'
                ]
                
            ]
        ];
        

        // Make API request to create the shipment
        // $shipment = $shippoService->createShipment($shipmentDetails);
        // echo $shipment;
        $shipment = json_decode(get_config('testshippo'), true);
        print_r($shipment);
       // exit;

        // if ($shipment['is_complete'] !== true) {
        //     print_r($shipment['object_id']);
        // }
        // else {

        // }
        
        // address data
        $addressData = [
            'name' => 'Endy Doe',
            'street1' => '456 Robson Street',
                'city' => 'Vancouver',
                'state' => 'BC',
                'zip' => 'V6B 2B2',
                'country' => 'CA',
                'phone' => '+1 604-555-5678',
                'email' => 'john.doe@example.com',
            // 'street1' => 'Karl-Liebknecht-Str. 25',
            // 'city' => 'Berlin',
            // 'state' => 'Berlin',
            // 'zip' => '10178',
            // 'country' => 'DE',
            // 'phone' => '+49 30 987654321',
            // 'email' => 'joe.doe@example.com',
            "validate" => true
        ];

    //    $addressDataReseult =  $shippoService->createAddress($addressData);
        //  $addressDataReseult =  $shippoService->ValidateAddress('285f7b1621c245f786c886d12ad1339f');


        //echo ("<br><br>".  ($addressDataReseult));


        // Rates are stored in the `rates` array inside the shipment object
        // $rates = $shipment['rates'];
        
        $rates = $shipment['rates'];
        // Process the shipment response and return it
        echo "Available rates:" . "\n";
        foreach ($rates as $rate) {
            echo "--> " . $rate['object_id'] . " - " . $rate['provider'] . " - " . $rate['servicelevel']['name'] . "<br>\n";
            echo "  --> " . "Amount: "             . $rate['amount'] . "<br>\n";
            echo "  --> " . "Days to delivery: "   . $rate['estimated_days'] . "<br>\n";
            echo "<img src='" . $rate['provider_image_75'] . "'>";
            echo "<br><br>\n";

            echo'';
        }
        echo "<br><br><br><br>\n";

        // This would be the index of the rate selected by the user
        $selected_rate_index = count($rates) - 1;
        $selected_rate_index = 0;


        // After the user has selected a rate, use the corresponding object_id
        // $selected_rate = $rates[$selected_rate_index];
        // $selected_rate_object_id = $selected_rate['object_id'];
        // echo $selected_rate_object_id;
        // $transaction  = $shippoService->createTransaction([
        //     'rate' => $selected_rate_object_id
        // ]);

        // // Print the shipping label from label_url
        // // Get the tracking number from tracking_number

        // if ($transaction['status'] == 'SUCCESS') {
        //     echo "--> " . "Shipping label url: " . $transaction['label_url'] . "\n";
        //     echo "--> " . "Shipping tracking number: " . $transaction['tracking_number'] . "\n";
        // } else {
        //     echo "Transaction failed with messages:" . "\n";
        //     foreach ($transaction['messages'] as $message) {
        //         echo "--> " . $message . "\n";
        //     }
        // }

        //return ($shipment);
    }
}
