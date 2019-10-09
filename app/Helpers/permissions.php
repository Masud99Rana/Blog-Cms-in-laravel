<?php

function check_user_permissions($request, $actionName = NULL, $id = NULL)
{
    //get current user
    $currentUser = $request->user();

    //get current action name
    if($actionName){
        $currentActionName = $actionName;
    }else{

        // get current action name
        // dd($request->route()->getActionName());
        $currentActionName = $request->route()->getActionName();
    }

    list($controller, $method) = explode('@', $currentActionName);
    $controller = str_replace(["App\\Http\\Controllers\Backend\\", "Controller"],"", $controller);

    // dd("C: $controller M: $method");  //"C: Blog M: edit"

    $crudPermissionMap =[

        // 'create' => ['create', 'store'],
        // 'update' => ['edit', 'update'],
        // 'delete' => ['destroy', 'restore', 'forceDestroy'],
        // 'read' => ['index', 'view']
        
        'crud' =>['create', 'store', 'edit', 'update', 'destroy', 'restore', 'forceDestroy', 'index', 'view']
    ];

    $classesMap = [
        'Blog' => 'post',
        'Users' => 'user',
        'Categories' => 'category',
    ];

    foreach ($crudPermissionMap as $permission => $methods) {
        //if the current method exists in methods list,
        //we'll check the permission
        
        if(in_array($method, $methods) && isset($classesMap[$controller])){
            
            $className = $classesMap[$controller];
            // dd($className);//-> post
            // dd("{$permission}-{$className}"); // ->"crud-post"
            // 
            // if the user has not permission don't allow next request
            if($className =='post' && in_array($method, ['edit', 'update', 'destroy', 'restore','forceDestroy'])){
                // dd("current user try to edit/delete a post");
                // if the current user has not update-others-post/delete-others-post permission
                // make sure he/she only modify his/her own post
                
                $id= !is_null($id)? $id : $request->route("blog");

                if( $id && (!$currentUser->can('update-others-post') || !$currentUser->can('delete-others-post')) ){
                    $post = \App\Post::withTrashed()->find($id);
                    if($post->author_id !== $currentUser->id){
                        // dd("cannot update/delete others post");
                        return false;
                    }
                }

            }elseif( ! $currentUser->can("{$permission}-{$className}")){
                return false;
                // abort(403, "Forbidden access!");
            }
            break;
        }
    }
    return true;
}
