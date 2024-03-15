<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\PostCategory;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Item;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class PostsController extends Controller
{
    /**
     * Display a listig of the resource.
     *
     * @param mixed $type
     * @return \Illuminate\Http\RedirectResponse|Renderable.
     */
    public function list($type, Request $request)
    {
        if (!$request->user()->can('do_moderator')) {
            //access denied
            return redirect(url()->previous())->withErrors([
                'errors' => __('messages.No_Permission'),
            ]);
        }

        //allowed type
        $list = get_contents_list();
        if(in_array($type, $list))
        {
            $trans_val = ucfirst($type);
            $data['page_title'] = trans_choice("messages.{$trans_val}", 2);
            return view(get_theme_dir('contents/list', 'dashboard'))->with([
                'page_title' => $data['page_title'],
                'type' => $type,
            ]);
        }
    }

    /**
     * Show the form for creating a new resources.
     *
     * @param mixed $type, Request $request
     * @return Renderable|\Illuminate\Http\RedirectResponse.
     */
    public function add($type, Request $request)
    {
        if (!$request->user()->can('do_moderator')) {
            //access denied
            return redirect(url()->previous())->withErrors([
                'errors' => __('messages.No_Permission'),
            ]);
        }

        $create_prefit = trans_choice('messages.Add_New', 1) . ' ';

        $list = get_contents_list();
        if(in_array($type, $list))
        {
            $trans_val = ucfirst($type);
            $data['page_title'] = $create_prefit  . trans_choice("messages.{$trans_val}", 1);
            return view(get_theme_dir('contents/create', 'dashboard'))->with([
                'page_title' => $data['page_title'],
                'type' => $type,
            ]);
        }
        
    }

    /**
     * Show the form for editing a specified resource.
     *
     * @param  mixed $id, Request $request
     * @return Renderable.
     */
    public function edit($id, Request $request)
    {
        if (!$request->user()->can('do_moderator')) {
            //access denied
            return redirect(url()->previous())->withErrors([
                'errors' => __('messages.No_Permission'),
            ]);
        }

        $posts = Post::where('id', $id)->first();
        $data['page_title'] = __('messages.Edit') . ' >> ' . trans_choice('messages.' . ucfirst($posts->post_type), 1) . ' >> ' . get_content_locale($posts->post_title);

        if ($posts) {
            return view(get_theme_dir('contents/edit', 'dashboard'))->with([
                'page_title' => $data['page_title'],
                'posts' => $posts,
                'type' => $posts->type,
                'id' => $id,
            ]);
        } else {
            return redirect(url()->previous())->withErrors([
                'errors' => __('messages.Request_Failed'),
            ]);
        }
    }

    /**
     * Display DataTable of the specified resource.
     *
     * @param  mixed $type, int $user_id, Request $request
     * @return DataTables.
     */
    public function datatable($type, Request $request)
    {
        if ($request->ajax()) {
            //filter query request
            //if ($type == 'blog') {
            $query = Post::where('post_type', $type)->orderByDesc('created_at');
            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('action', function (Post $posts) {
                    $actionBtn = '-';
                    //settings
                    $role = Auth()->user()->role;
                    if ($role >= 4) {
                        $url = route('dashboard.posts.edit', ['id' => $posts->id]);
                        $url_delete = route('dashboard.posts.delete', ['id' => $posts->id]);
                        $actionBtn = "<a class='btn btn-sm btn-outline-primary m-1'
                           href='{$url}'><i class='fa fa-edit'></i> </a>";
                        $actionBtn .= "<a class='btn btn-sm btn-outline-primary m-1'
                           href='{$url_delete}'><i class='fa fa-trash'></i> </a>";
                    }

                    return $actionBtn;
                })
                ->editColumn('id', function (Post $posts) {
                    $url = route('dashboard.posts.edit', ['id' => $posts->id]);
                    $actionUrl = "<a  href='{$url}'>{$posts->id}</a>";
                    return $actionUrl;
                })
                ->editColumn('post_title', function (Post $posts) {
                    $url = route("page", ['slug' => $posts->post_slug]);
                    if ($posts->post_type == 'blog') {
                        $url = route("blog.post", ['slug' => $posts->post_slug]);
                    }
                    $post_title = get_content_locale($posts->post_title);
                    $type = ucfirst($posts->post_type);
                    $view =  trans_choice('messages.View', 1). ' ' . trans_choice("messages.{$type}", 1);
                    $actionBtn = "<br/><a target='_blank' class='btn btn-sm btn-outline-primary m-1'
                           href='{$url}'>$view</a>";
                    return ($post_title . $actionBtn);
                })

                ->editColumn('post_status', function (Post $posts) {
                    $status_name = get_status('posts', $posts->post_status);
                    $status = "<div class='badges'><span class='badge bg-" . get_status_color($posts->post_status, 'posts') . " font-12'>{$status_name}</span></div>";
                    return $status;
                })

                ->editColumn('created_at', function (Post $post) {
                    $created_at = Carbon::parse($post->created_at)->setTimezone(\Helpers::getUserTimeZone());
                    return $created_at;
                })
                ->editColumn('post_author', function (Post $post) {
                    $user = \App\Models\User::where('id', $post->post_author)->first();
                    if ($user->avatar) {
                        $avatar = '<div class="avatar  avatar-xlx me-3 bg-rgba-primary m-0 me-50"> <img src="' . asset($user->avatar) . '" class="avatar-lg rounded-circle p-1 img-thumbnail" srcset=""></div>';
                    } else {
                       
                        $avatar = $user->username;
                    }
                    return $avatar;
                })
                ->rawColumns(['id', 'post_status', 'post_title', 'action', 'post_author', 'created_at'])
                ->make(true);
            // }
        }
    }

    /**
     * Store newly created resources in storage.
     *
     * @param mixed $type, Request $request
     * @return  \Illuminate\Http\JsonResponse.
     */
    public function create($type, Request $request)
    {
        //Unauthorized access - only for admins/moderators
        if (!$request->user()->can('do_moderator')) {
            //access denied
            $resp = [
                'result' => 'failed',
                'messages' => __('messages.No_Permission'),
            ];
            return response()->json($resp);
        }

        $check_title = get_content_locale(json_encode($request->post_title));
        if (empty($check_title)) {
            $resp = [
                'result' => 'failed',
                'messages' => __('messages.Fill_Required_Field_First'),
            ];
            return response()->json($resp);
        }
        if (!empty($request->file('featured_image'))) {
            $validate = Validator::make($request->all(), [
                'featured_image' => 'required|image|mimes:jpg,png,jpeg,gif,svg,webp|max:2000',
            ]);
            if ($validate->fails()) {
                $resp = [
                    'result' => 'errors',
                    'messages' => $validate->errors(),
                ];
                return response()->json($resp);
            }
            $file = $request->file('featured_image');
            $date = date('Y/m', time());
            $destinationPath = "uploads/{$type}/{$date}/";
            $new_name = "{$type}-" . time() . '.' . $file->getClientOriginalExtension();
            //Move Uploaded File
            $file->move($destinationPath, $new_name);
            $post_img = $destinationPath . $new_name;
        }

        try {
            DB::beginTransaction();
            $post_slug = Str::slug(get_content_locale(json_encode($request->post_title)));
            //check slug
            if (Post::whereRaw("post_slug = '$post_slug'")->count()> 0) {
                //rename slug
                $post_slug = $post_slug .'-'. (Post::whereRaw("id >= 0")->orderByDesc('id')->limit(1)->value('id') + 1);
            }
            $create = Post::create([
                'post_type' => $type,
                'post_slug' => $post_slug,
                'post_title' => json_encode($request->post_title),
                'post_content' => json_encode($request->post_content),
                'post_excerpt' => json_encode($request->post_excerpt),
                'post_author' => Auth()->user()->id,
                'post_img' => isset($post_img) ? $post_img : '',
                'post_status' => $request->post_status,
            ]);
            if ($create) {
                if ($type == 'blog') {
                    if (!empty($request->post_cat)) {
                        foreach ($request->post_cat as $cat) {
                            $postcat = new PostCategory();
                            $postcat->category_id = $cat;
                            $postcat->post_id = $create->id;
                            $postcat->save();
                        }
                    }
                }
                DB::commit();
                Session::flash('form_response', __('messages.Created'));
                Session::flash('form_response_status', 'success');
                $resp = [
                    'result' => 'success',
                    'messages' => __('messages.Created'),
                    'redirect_url' => route('dashboard.posts', ['type' => $type]),
                ];
                return response()->json($resp);
            } else {
                DB::rollback();
                $resp = [
                    'result' => 'failed',
                    'messages' => __('messages.There_Was_Problem'),
                ];
                return response()->json($resp);
            }
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id, Request $request
     * @return  \Illuminate\Http\JsonResponse.
     */
    public function update($id, Request $request)
    {
        //Unauthorized access - only for admins/moderators
        if (!$request->user()->can('do_moderator')) {
            //access denied
            $resp = [
                'result' => 'failed',
                'messages' => __('messages.No_Permission'),
            ];
            return response()->json($resp);
        }
        $posts = Post::where('id', $id)->first();
        $type = $posts->post_type;
        $post_img = $posts->post_img;
        $post_slug = Str::slug($request->post_slug);
        $check_title = get_content_locale(json_encode($request->post_title));
        if (empty($check_title)) {
            $resp = [
                'result' => 'failed',
                'messages' => __('messages.Fill_Required_Field_First'),
            ];
            return response()->json($resp);
        }
        //check slug
        if (Post::whereRaw("post_slug = '$post_slug'  AND id != '$id'")->count()> 0) {
            //rename 
            $post_slug = $request->post_slug .'-'. $id;
        }
        if (!empty($request->file('featured_image'))) {
            $validate = Validator::make($request->all(), [
                'featured_image' => 'required|image|mimes:jpg,png,jpeg,gif,svg,webp|max:2000',
            ]);
            if ($validate->fails()) {
                $resp = [
                    'result' => 'errors',
                    'messages' => $validate->errors(),
                ];
                return response()->json($resp);
            }
            $file = $request->file('featured_image');
            $date = date('Y/m', time());
            $destinationPath = "uploads/{$type}/{$date}/";
            $new_name = "{$type}-" . time() . '.' . $file->getClientOriginalExtension();
            //Move Uploaded File
            if ($file->move($destinationPath, $new_name)) {
                //remove old file
               // unlink($post_img);
                //set new file
                $post_img = $destinationPath . $new_name;
            }
        }
        //no error insert into db
        try {
            if ($request->created_at != '') {
                $request->merge([
                    'created_at' => Carbon::parse($request->input('created_at'), \Helpers::getUserTimeZone())
                        ->setTimeZone(config('app.timezone'))
                        ->format('Y-m-d H:i:s'),
                ]);
            }
            
            DB::beginTransaction();
            $update = Post::where('id', $id)->update([
                'post_title' => json_encode($request->post_title),
                'post_slug' => $post_slug,
                'post_content' => json_encode($request->post_content),
                'post_excerpt' => json_encode($request->post_excerpt),
                'post_last_edited' => Auth()->user()->id,
                'post_status' => $request->post_status,
                'post_img' => isset($post_img) ? $post_img : '',
                'created_at' => $request->created_at,
            ]);
            if ($update) {
                if ($type == 'blog') {
                    //clean old categories data
                    $clean = PostCategory::where('post_id', $id)->delete();
                    if (!empty($request->post_cat)) {
                        //insert new categories data
                        foreach ($request->post_cat as $cat) {
                            
                            // if (PostCategory::where(['post_id' => $id, 'category_id' => $cat])->count() > 0) {
                            //     # code...
                            // } else {
                            //     # code...
                            // }
                            
                            $postcat = new PostCategory();
                            $postcat->category_id = $cat;
                            $postcat->post_id = $id;
                            $postcat->save();
                        }
                    }
                     
                }
                DB::commit();
                $resp = [
                    'result' => 'success',
                    'messages' => __('messages.Saved'),
                ];
                return response()->json($resp);
            } else {
                DB::rollback();
                $resp = [
                    'result' => 'failed',
                    'messages' => __('messages.There_Was_Problem'),
                ];
                return response()->json($resp);
            }
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
    }

    /**
     * Remove a specified resource from the storage.
     *
     * @param mixed $id, Request $request
     * @return  \Illuminate\Http\RedirectResponse.
     */
    public function delete($id, Request $request)
    {
        //;
        //Unauthorized access - only for admins/moderators
        if (!$request->user()->can('do_moderator')) {
            //access denied
            return redirect(url()->previous())->withErrors([
                'errors' => __('messages.No_Permission'),
            ]);
        }
        $posts = Post::where('id', $id)->first();
        $type = $posts->post_type;
        if ($request->confirm == '') {
            $data['page_title'] = __('messages.Delete') . ' >> ' . trans_choice('messages.' . ucfirst($type), 1) . ' >> ' . get_content_locale($posts->post_title);
            if ($posts) {
                return view(get_theme_dir('contents/delete', 'dashboard'))->with([
                    'page_title' => $data['page_title'],
                    'type' => $type,
                    'posts' => $posts,
                ]);
            } else {
                return redirect(url()->previous())->withErrors([
                    'errors' => __('messages.Request_Failed'),
                ]);
            }
        }

        if ($request->confirm == 1) {
            //delete data from db
            $delete = Post::where('id', $id)->delete();
            if ($delete) {
                //remove post categories data
                PostCategory::where('post_id', $id)->delete();
                Session::flash('form_response', __('messages.Deleted_Success'));
                return redirect(route('dashboard.posts', ['type' => $type]));
            } else {
                return redirect(url()->previous())->withErrors([
                    'errors' => __('messages.Operation_Failed'),
                ]);
            }
        }
    }

    /**
     * Store newly created resources in storage.
     *
     * @param mixed $type, Request $request
     * @return  \Illuminate\Http\JsonResponse.
     */
    public function category_create(Request $request)
    {
        ;
        //Unauthorized access - only for admins/moderators
        if (!$request->user()->can('do_moderator')) {
            //access denied
            $resp = [
                'result' => 'failed',
                'messages' => __('messages.No_Permission'),
            ];
            return response()->json($resp);
        }

        //validate input fields
        $validate = Validator::make($request->all(), [
            'category_name' => 'required',
        ]);
        //input has error(s)
        if ($validate->fails()) {
            $resp = [
                'result' => 'errors',
                'messages' => $validate->errors(),
            ];
            return response()->json($resp);
        }

        try {
            DB::beginTransaction();
            
            if ($request->quick_add == 1) {
                //Localization
                foreach (\App\Models\Languages::where('status', '1')->get() as $lang) {
                    $category_name[$lang->code] = $request->category_name;
                }
            } else {
                $category_name = $request->category_name;
            }
            
            $post_slug = json_encode($category_name);
            $post_slug = Str::slug(get_content_locale($post_slug));
            $create = Category::create([
                'slug' => $post_slug,
                'name' => json_encode($category_name),
                'parent' => $request->category_parent > 0 ? $request->category_parent : '0',
                'description' => json_encode($request->category_description),
                'img' => $request->category_img,
                'status' => $request->category_status ? $request->category_status : '1',
            ]);
            if ($create) {
                DB::commit();
                if ($request->quick_add != 1) {
                    Session::flash('form_response', __('messages.Category_Created'));
                    Session::flash('form_response_status', 'success');
                }
                $resp = [
                    'result' => 'success',
                    'messages' => __('messages.Category_Added'),
                    //'redirect_url' => route('dashboard.posts.category'),
                ];
                return response()->json($resp);
            } else {
                DB::rollback();
                $resp = [
                    'result' => 'failed',
                    'messages' => __('messages.There_Was_Problem'),
                ];
                return response()->json($resp);
            }
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
    }

    /**
     * Search the specified resource in storage.
     *
     * @param  Request $request
     * @return  \Illuminate\Http\JsonResponse.
     */
    public function category_search(Request $request)
    {
        $data = \App\Models\Category::select('id', 'name')
            ->where('status', 1)
            ->get();

        return response()->json($data);
    }
}