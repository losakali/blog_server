<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
//    获取博客分类
    public function getBlogType(){
        try {
            $data = \DB::table('blog_type')->get();
            return ['data'=>$data,'status'=>200,'message'=>'获取分类成功！'];
        }catch (\Exception $e){
            return ['status'=>201,'message'=>'获取分类失败！'];
        }
    }
//    上传图片 文件
    public function upload(Request $request){
//        获取上传的文件
        $imge = $request->file('file');
        try {
            //        判断上传的文件是否存在
            if($imge){
//              存在的话执行以下操作
//              获取原文件名
                $name = $imge->getClientOriginalName();
//              获取文件的扩展名
                $extendname = $imge->getClientOriginalExtension();
//              获取文件的类型
                $type = $imge->getClientMimeType();
//              获取文件的绝对路径
                $path = $imge->getRealPath();
//              建立保存的文件名 时间+扩展名的组合
                $filename = date('Y-m-d').'/'.uniqid().'.'.$extendname;
//              保存文件
//              disk(文件存放的路径 即在disk配置中的tileImg数组)
//              Storage的put方法来保存文件 put('保存的文件名','上传文件的绝对路径客户端的绝对路径')
                $bool = \Storage::disk('tileImg')->put($filename,file_get_contents($path));
//              上传成功后直接返回保存时的文件名和 后端的图片的访问路径+文件名
                return [
                    'data'=>['tmp_path'=>$filename,'url'=>'http://localhost/laravel-airlock-sample/storage/app/public/tileImg/'.$filename],
                    'status'=>200,
                    'message'=>'上传成功！'
                ];
            }else{
                return [
                    'status'=>201,
                    'message'=>'上传失败'
                ];
            }
        }catch (\Exception $e){
               return [
                   'status'=>201,
                   'message'=>'上传出错'
               ];
        }
    }

//    删除文件
    public function delImg(Request $request){
        try {
//            使用 Storage::delete()方法删除文件 里面传文件的后端相对路径 成功返回 true 失败返回false
//            默认会在app/目录下开始移除 所以传进来的的路径是public/tileImg 从public开始就可以了
//            判断传进来的的博客id是否存在 存在就执行 不存在返回错误提示
//            has() 判断传入的值是否存在 如果前端有传入博客id说明需要进行博客的修改操作
            if($request->has('blog_id')){
//             获取传进来的博客id input() 获取请求的指定值
                $blog_id = $request->input('blog_id');
//             移除图片还涉及了修改博客模块 因为修改模块的更图片需要把数据库的 cover_image 字段的值给清空 这样才算完全删除
//                update([
//                    '字段名'=>'修改的值'
//                ]);
                $result = Blog::where('blog_id',$blog_id)->update([
                    'cover_image'=>''
                ]);
            }
//            删除后端文件夹中的图片 传入文件的后端相对路径即可
            \Storage::delete($request->input('filename'));
//            删除成功
            return ['status'=>200,'message'=>'移除成功'];
        }catch (\Exception $e){
//            移除失败
            return ['status'=>201,'message'=>'移除失败'];
        }
    }

//    新增博客
   public function addBlog(Request $request){
//        判断传进来的值是否都存在
       if($request->has(['userid','blog_content','blog_title','cover_image','blog_status','type_id'])){
//        进行新增操作 使用模型的 insert 方法进行插入操作 插入成功会返回新增的数据
           $data = Blog::insert($request->all());
//           返回数据
           return ['data'=>$data,'status'=>200,'message'=>'发布博客成功！'];
       }else{
//           发布失败 返回失败提示
           return ['status'=>201,'message'=>'发布失败'];
       }
   }

//   获取所有博客
   public function getAllBolg(Request $request){
//        获取前端发送过来的时间
       $blogTime = $request->input('query');
//       获取每页显示的条数
       $pageSize = $request->input('size');
       try {
//       判断传进来的 query 时间是否为空 为空不执行按时间返回的操作
//       empty 判断一个值是否为空 为空返回true
//       latest() 以某个字段正序输出 参数：字段
//       paginate() 参数：每页显示的条数 会自动识别传进来的 page当前页
//       在返回数据时会自动带上总页数total 和当前页码
           if(!empty($blogTime)){
               $data = Blog::where('create_time','like','%'.$blogTime.'%')->latest('create_time')->paginate($pageSize);
               return ['data'=>$data,'status'=>200,'message'=>'获取所有博客成功'];
           }else{
//           没有传入时间 按正常输出
               $data = Blog::latest('create_time')->paginate($pageSize);
               return ['data'=>$data,'status'=>200,'message'=>'获取所有博客成功'];
           }

       }catch (\Exception $e){
           return ['status'=>201,'message'=>'获取所有博客失败'];
       }
   }



//   根据用户id获取博客
   public function myBlog(Request $request){
       $id = $request->input('id');
       $pageSize = $request->input('size');
       try {
           $data = Blog::where('userid',$id)->latest('create_time')->paginate($pageSize);
           if(!$data->isEmpty()){
               return ['data'=>$data,'status'=>200,'message'=>'获取博客成功'];
           }else{
               return ['data'=>$data,'status'=>201,'message'=>'没有博客'];
           }
       }catch (\Exception $e){
           return ['status'=>201,'message'=>'获取博客失败'];
       }
   }


    //    修改博客
    public function upBlog(Request $request){
        try{
            $id = $request->input('blog_id');
            $blog = $request->all();
            $data = Blog::where('blog_id',$id)->update($blog);
            if($data){
                return ['data'=>$data,'status'=>200,'message'=>'修改成功'];
            }else{
                return ['data'=>$request->input(),'status'=>201,'message'=>'修改失败'];
            }
        }catch (\Exception $e){
            return ['data'=>$request->input(),'status'=>201,'message'=>'修改失败'];
        }
    }

    //    根据博客id获取博客
    public function  blogId(Request $request,$id){
        try {
            $comment = DB::table('comment')->where('blog_id',$id)->get();
            $data = Blog::where('blog_id',$id)->get();
            if(!$data->isEmpty()){
                return ['data'=>$data,'comment'=>$comment,'status'=>200,'message'=>'获取成功'];
            }else{
                return ['data'=>$data,'status'=>201,'message'=>'没有查询到该博客'];
            }
        }catch (\Exception $e){
            return ['status'=>201,'message'=>'获取失败'];
        }
    }


//    删除图片
    public function imgdel(Request $request){
        try{
//            Storage::delete(’文件所在路径)  删除文件 成功会返回true 否则 false
//            默认会从app/ 目录下开始移除 比如这里要移除tileImg文件夹下的文件 就是 public/tileImg/...
            if($request->has('blog_id')){
                $blog_id = $request->input('blog_id');
                $result = Blog::where('blog_id',$blog_id)->update([
                    'cover_image'=>''
                ]);
            }
//            判断是否存在用户id 如果有则表示要更改用户头像 把数据库中保存用户头像的字段清空即可
            if($request->has('id')){
                $id = $request->input('id');
                $result = User::where('id',$id)->update([
                    'avatar'=>''
                ]);
            }
            Storage::delete($request->filename);

            return ['message'=>'移除成功','status'=>200];
        } catch (\Exception $e) {
            return ['message'=>'图片路径出错','status'=>201];
        }
    }


//    删除博客
    //    删除博客
    public function delblog(Request $request){
        try {
            $blog_id = $request->input('blog_id');
            $result = Blog::where('blog_id',$blog_id)->delete();
            return ['data'=>$result,'status'=>200,'message'=>'删除成功'];
        }catch (\Exception $e){
            return ['status'=>201,'message'=>'删除失败'];
        }
    }


//    发布评论
    public function content(Request $request){
        try {
            $result = DB::table('comment')->insert($request->all());
            return ['data'=>$result,'status'=>200,'message'=>'评论成功'];
        }catch (\Exception $e){
            return ['data'=>$request->input(),'status'=>201,'message'=>'评论失败'];
        }
    }

//    新增/修改用户图片
    public function addUserImg(Request $request){
        $avatar = $request->input('avatar');
        $id = $request->input('id');
//        如果想要判断一个值在请求中是否存在，并且不为空，需要使用 filled 方法 为空返回false
        if($request->filled('avatar')){
//            插入图片
             User::where('id',$id)->update([
                 'avatar'=>$avatar
             ]);
            return ['data'=>$avatar,'status'=>200];
        }else{
            return ['data'=>$avatar,'status'=>201,'message'=>'操作失败'];
        }
    }

//    新增/修改 用户简介
   public function addJianJie(Request $request){
        if($request->filled('id')){
            $id = $request->input('id');
            $jianjie = $request->input('jianjie');
            $data = User::where('id',$id)->update([
                'jianjie'=>$jianjie
            ]);
            return ['data'=>$data,'status'=>200,'message'=>'修改简介成功'];
        }else{
            return ['status'=>201,'message'=>'修改简介失败'];
        }
   }


//   获取用户信息
   public function getUser(Request $request){
        if($request->filled('id')){
            $id = $request->input('id');
            $data = User::where('id',$id)->get();
            return ['data'=>$data,'status'=>200,'message'=>'获取用户信息成功'];
        }else{
            return ['status'=>201,'message'=>'获取用户信息失败'];
        }
   }

//   搜索博客
    public function sousuo(Request $request){
        if($request->filled('sousuo')){
            $sousuo = $request->input('sousuo');
            //       获取每页显示的条数
            $pageSize = $request->input('size');
            try {
                    $data = Blog::where('blog_title','like','%'.$sousuo.'%')->latest('create_time')->paginate($pageSize);
                    return ['data'=>$data,'status'=>200,'message'=>'获取所有博客成功'];
            }catch (\Exception $e){
                return ['status'=>201,'message'=>'获取所有博客失败'];
            }
        }else{
            return ['status'=>201,'message'=>'你输入的内容为空！'];
        }
    }

//    根据博客类型获取博客
    public function getTypeBlog(Request $request){
        if($request->filled('type_id')){
            $type_id = $request->input('type_id');
            //       获取每页显示的条数
            $pageSize = $request->input('size');
            try {
                $data = Blog::where('type_id',$type_id)->latest('create_time')->paginate($pageSize);
                return ['data'=>$data,'status'=>200,'message'=>'获取博客成功'];
            }catch (\Exception $e){
                return ['status'=>201,'message'=>'获取博客失败'];
            }
        }else{
            return ['status'=>201,'message'=>'获取博客类型出错！'];
        }
    }
}
