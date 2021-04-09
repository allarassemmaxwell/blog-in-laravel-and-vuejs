<?php

namespace App\Http\Controllers;
use App\Blog;
use App\Blogcategory;
use App\Blogtag;
use App\Category;
use App\Role;
use App\Tag;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
class AdminController extends Controller
{
    // ADD TAG
    public function index(Request $request) {
        if (!Auth::check() && $request->path() != 'login') {
            return redirect('/login');
        }
        if (!Auth::check() && $request->path() == 'login') {
            return view('welcome');
        }
        $user = Auth::user();
        if ($user->userType == 'User') {
            return redirect('/login');
        }
        if ($request->path() == '/login') {
            return redirect('/');
        } 
        return $this->checkForPermission($user, $request);
    }

    public function checkForPermission($user, $request)
    {
        $permission = json_decode($user->role->permission);
        $hasPermission = false;
        if (!$permission) return view('welcome');

        foreach ($permission as $p) {
            if ($p->name == $request->path()) {
                if ($p->read) {
                    $hasPermission = true;
                }
            }
        }
        if ($hasPermission) return view('welcome');

        return view('notfound');
    }
    // LOG OUT
    public function logout() {
        Auth::logout();
        return redirect('/login');
    }

    // ADD TAG
    public function addTag(Request $request) {
        $this->validate($request, [
            'tagName' => 'required'
        ]);
        return Tag::create([
            'tagName' => $request->tagName
        ]);
    }

    // EDIT TAG
    public function editTag(Request $request) {
        $this->validate($request, [
            'tagName' => 'required',
            'id'      => 'required'
        ]);
        Tag::where('id', $request->id)->update([
            'tagName' => $request->tagName
        ]);
    }

    // DELETE TAG
    public function deleteTag(Request $request) {
        $this->validate($request, [
            'id'      => 'required'
        ]);
        Tag::where('id', $request->id)->delete();
    }

    // GET TAGS
    public function getTag() {
        return Tag::orderBy('id', 'desc')->get();
    }

    // UPLOAD IMAGE
    public function upload(Request $request) {
        $this->validate($request, [
            'file' => 'required|mimes:jpeg,jpg,png'
        ]);
        $picName = time().'.'.$request->file->extension();
        $request->file->move(public_path('uploads'), $picName);
        return $picName;
    }

    // DELETE IMAGE
    public function deleteImage(Request $request) {
        $fileName = $request->imageName;
        $this->deleteFileFromServer($fileName, false);
        return 'Done';
    }
    // DELETE IMAGE
    public function deleteFileFromServer($fileName, $hasFullPath=false) {
        if (!$hasFullPath) {
            $filePath = public_path().'/uploads/'.$fileName;
        }
        if (file_exists($filePath)) {
            @unlink($filePath);
        }
        return;
    }


    // ADD CATEGORY
    public function addCategory(Request $request) {
        $this->validate($request, [
            'categoryName' => 'required',
            'iconImage' => 'required'
        ]);
        return Category::create([
            'categoryName' => $request->categoryName,
            'iconImage' => $request->iconImage
        ]);
    }

    // GET CATEGORIES
    public function getCategory() {
        return Category::orderBy('id', 'desc')->get();
    }

    // EDIT CATEGORIES
    public function editCategory(Request $request) {
        $this->validate($request, [
            'categoryName' => 'required',
            'iconImage' => 'required'
        ]);
        Category::where('id', $request->id)->update([
            'categoryName' => $request->categoryName,
            'iconImage' => $request->iconImage
        ]);
    }

    // DELETE CATEGORIES
    public function deleteCategory(Request $request) {
        $this->deleteFileFromServer($request->iconImage);
        $this->validate($request, [
            'id'      => 'required'
        ]);
        Category::where('id', $request->id)->delete();
    }

    // CREATE USER
    public function createUser(Request $request) {
        $this->validate($request, [
            'fullName' => 'required',
            'email'    => 'bail|required|email|unique:users',
            'password' => 'bail|required|min:6',
            'role_id'  => 'required'
        ]);
        $password = bcrypt($request->password);
        $user = User::create([
            'fullName' => $request->fullName,
            'email'    => $request->email,
            'password' => $request->password,
            'role_id'  => $request->role_id

        ]);
        return $user;
    }

    // GET USER
    public function getUsers() {
        return User::get();
    }

    // EDIT USER
    public function editUser(Request $request) {
        $this->validate($request, [
            'fullName' => 'required',
            'email'    => "bail|required|email|unique:users,email,$request->id",
            'password' => 'min:6',
            'userType' => 'required'
        ]);
        $data = [
            'fullName' => $request->fullName,
            'email'    => $request->email,
            'userType' => $request->userType
        ];
        if ($request->password) {
            $password = bcrypt($request->password);
            $data['password'] = $password;
        }
        $user = User::where('id', $request->id)->update($data);
        return $user;
    }

    // ADMIN LOGIN
    public function adminLogin(Request $request) {
        $this->validate($request, [
            'email'    => 'bail|required|email',
            'password' => 'bail|required|min:6'
        ]);
        if (Auth::attempt(['email'=>$request->email, 'password'=>$request->password])) {
            $user = Auth::user();
            // \Log.info($user->role);
            if ($user->role->isAdmin == 0) {
                Auth::logout();
                return response()->json([
                    'msg' => 'Incorrect login details'
                ], 401);
            }
            return response()->json([
                'msg' => 'You are logged in',
                'user' => $user
            ]);
        } else {
            return response()->json([
                'msg' => 'Incorrect login details'
            ], 401);
        }
    }

    // ADD TAG
    public function addRole(Request $request) {
        $this->validate($request, [
            'roleName' => 'required'
        ]);
        return Role::create([
            'roleName' => $request->roleName
        ]);
    }

    // GET ROLES
    public function getRole() {
        return Role::orderBy('id', 'desc')->get();
    }

    // EDIT ROLE
    public function editRole(Request $request) {
        $this->validate($request, [
            'roleName' => 'required',
            'id'      => 'required'
        ]);
        Role::where('id', $request->id)->update([
            'roleName' => $request->roleName
        ]);
    }

    // ASSIGN ROLE
    public function assignRole(Request $request) {
        $this->validate($request, [
            'permission' => 'required',
            'id' => 'required'
        ]);
        Role::where('id', $request->id)->update([
            'permission' => $request->permission
        ]);
    }



    // ASSIGN ROLE
    public function uploadEditorImage(Request $request) {
        $this->validate($request, [
            'image' => 'required|mimes:jpeg,jpg,png'
        ]);
        $picName = time().'.'.$request->image->extension();
        $request->image->move(public_path('uploads'), $picName);
        return response()->json([
            'success' => 1,
            'file' => [
                'url' => 'http://127.0.0.1:8000/uploads/$picName'
            ]
        ]);
        // return $picName;
    }


    // START GENERATING UNIQUE SLUG
    public function slug() {
        $title = 'This is a nice title changed';
        $slug = $this->setSlugAttribute($title);
        return Blog::create([
            'title' => $title,
            'post' => 'some post',
            'post_excerpt' => 'aead',
            'slug' => $slug,
            'user_id' => 1,
            'metaDescription' => 'aead',
        ]);
        return $title;
    }

    public function setSlugAttribute($title){
        return $this->uniqueSlug($title);
    }

    private function uniqueSlug($title){
        $slug = Str::slug($title, '-');
        $count = Blog::where('slug', 'LIKE', "{$slug}%")->count();
        $newCount = $count > 0 ? ++$count : '';
        return $newCount > 0 ? "$slug-$newCount" : $slug;
    }
    // END OF GENERATING UNIQUE SLUG


    // CREATE BLOG
    public function createBlog(Request $request) {
        $categories = $request->category_id;
        $tags = $request->tag_id;
        $blogCategories = [];
        $blogTags = [];
        DB::beginTransaction();
        try {
            $blog = Blog::create([
                'title' => $request->title,
                'post'  => $request->post,
                'post_excerpt' => $request->post_excerpt,
                'user_id' => Auth::user()->id,
                'metaDescription' => $request->metaDescription,
                'jsonData' => $request->jsonData
            ]);
            // INSERT BOG CATEGORIES
            foreach($categories as $c) {
                array_push($blogCategories, ['category_id' => $c, 'blog_id' => $blog->id]);
            }
            $Blogcategory::insert($blogCategories);
            // INSERT BLOG ID
            foreach($tags as $t) {
                array_push($blogTags, ['tag_id' => $t, 'blog_id' => $blog->id]);
            }
            $Blogtag::insert($blogTags);
            DB::comit();
            return 'done';
        } catch(\Throwable $th) {
            BD::rollback();
            return 'Not done';
        }
        
    }
}
