<?php

namespace App;

use Illuminate\Database\Eloquent\Model as Eloquent;


class Model extends Eloquent
{

        protected $guarded= []; //If you give an empty array it means that you allow all
//         protected $fillable = ['body','post_id','title','user_id'];


//    protected $fillable= ['title','body']; //You specify the fields that you allow
//    protected $guarded= ['user_id']; //You specify the fields that you don't allow

//    protected $guarded= []; //If you give an empty array it means that you allow all
//    protected $fillable= []; //If you give an empty array it means that you don't allow any

}
