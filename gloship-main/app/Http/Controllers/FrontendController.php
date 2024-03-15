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
    public function oops()
    {

        $data['page_title'] = trans_choice('messages.There_Was_Problem', 1);
        //$s = $request->s;
        return view(get_theme_dir('oops', 'dashboard'))->with([
            'page_title' => $data['page_title'],
            
        ]);
    }
}
