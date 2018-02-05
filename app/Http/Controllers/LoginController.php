<?php

namespace App\Http\Controllers;

//use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Request;
use Illuminate\Foundation\Bus\DispatchesJobs;
//use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Coffee;
use App\Trigger;
use Request;
use Session;

use \DB;


class LoginController extends BaseController
{
    public function index() {
        return view('login'); 
    }
    
    protected $req;

    public function __construct(Request $req) {
        $this->req = $req;
    }

    
    public function login()
     {
      
     /* $username = $this->req->input('username');
      $password = $this->req->input('password');

      $checkLogin = DB::table('users')->where(['username'=>$username,'password'=>$password])->get();
      if(count($checkLogin)  >0)
      {
       echo "Login SuccessFull<br/>";
       return view('logout');
      }
      else
      {
       echo "Login Faield Wrong Data Passed";
      }
      * 
      */
      $coffees=Coffee::all();
      return view('admin')->with('coffees',$coffees);  
     }

    public function admin(){
        $coffees=Coffee::all();
        return view('blog')->with('coffees',$coffees);  
    }
    
    public function book($titlu){
         //select*from flowers where flower=$flower LIMIT 1
        $coffee=Coffee::where('titlu','=',$titlu)->first();
        return view('showcoffee',['coffee'=>$coffee]);
    }
    
    public function viewTrigger(){
        $coffees=Trigger::all();
        return view('showcoffee')->with('coffees',$coffees);  
    }
    
    public function add(){
        return view('addcoffee');
    }
    
    public function store(){
        //$input = Request::all();
        /*$book=new Book;
        $book->titlu=$this->req->input('titlu');
        $book->autor=$this->req->input('autor');
        $book->poza=$this->req->input('poza');
        $book->descriere=$this->req->input('descriere');
        $book->save();*/
        
        $poza=Request::file('poza');
        
         /*if($poza !=null)
            {
                $destinationPath="../themes/img";
                $extension=$poza->getClientOriginalExtension();
                $fileName=$poza->getClientOriginalName().'.'.$extension;
                $poza=move($destinationPath,$fileName);
                $pozan=$poza->getClientOriginalName();
                 echo $pozan;
            }
            else
            {
                $pozan='';
            }*/
                $titlu=Request::input('titlu');
                $tara=Request::input('tara');
                $descriere=Request::input('descriere');
                DB::insert("CALL InsertCoffees('{$titlu}','{$tara}','{$poza}','{$descriere}')");
                //echo $pozan;
       // Session::flash('message','Record stored!');
        return redirect('/admin');
    }
    
    public function delete($id){
      /* $book=Book::where('titlu','=',$titlu)->first();
       if($book->delete()){
           $book=Book::all();
           //Session::flash('message','Record stored!');
           return redirect('/admin');
       }else{
           //Session::flash('message','Error!Please try again!');
           return redirect('/admin');
       }*/
        DB::select("CALL DeleteCoffees('{$id}')");
         return redirect('/admin');
    }
    
    public function edit($id)
    {
        $coffee=Coffee::where('id','=',$id)->first();
        return view('editcoffee',['coffee'=>$coffee]);
    }
    
    public function updateData($id){
        /*Book::where('titlu',$titlu)->update(array(
            'titlu'=>$this->req->input('titlu'),
            'autor'=>$this->req->input('autor'),
            'poza'=>$this->req->input('poza'),
            'descriere'=>$this->req->input('descriere'),
        ));*/
        /*//Session::flash('message','Record update!');
        return redirect('/admin');
        * 
        */
        $poza=Request::file('poza');
        
         /*if($poza !=null)
                {
                    $destinationPath="../themes/img";
                    $extension=$poza->getClientOriginalExtension();
                    $fileName=$poza->getClientOriginalName().'.'.$extension;
                    $poza=move($destinationPath,$fileName);
                    $pozan=$poza->getClientOriginalName();
                }
                else
                {
                    $pozan='';
                }*/
                $titlu=Request::input('titlu');
                $tara=Request::input('tara');
                $descriere=Request::input('descriere');
                DB::select("CALL UpdateCoffees('{$titlu}','{$tara}','{$poza}','{$descriere}','{$id}')");
       // Session::flash('message','Record stored!');
        return redirect('/admin');
    }
    
}

