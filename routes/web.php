<?php

use App\Cars;
use App\User;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    $cards = [
        (object)['img' => '/storage/img/car.svg', 'text' => 'ЛЕГКОВОЙ АВТО', 'tel' => '+79346489535', 'price' => '1000'],
        (object)['img' => '/storage/img/jeep.svg', 'text' => 'ВНЕДОРОЖНИК', 'tel' => '+79346489535', 'price' => '1500'],
        (object)['img' => '/storage/img/truck.svg', 'text' => 'ГАЗЕЛЬ, МИКРОАВТОБУС, ПОГРУЗЧИК, СПЕЦТЕХНИКА', 'tel' => '+79346489535', 'price' => '2000'],
    ];
    return view('welcome', compact('cards'));
})->name('index');

Route::get('logout', function () {
    auth()->logout();
    return redirect(\route('index'));
})->name('logout');

Auth::routes();


Route::prefix('/')->middleware('auth')->group(function () {
    Route::get('home', function () {
        return view('home',['fines'=>\App\Fine::with('getCar')->whereHas('getCar',function ($query){
            $query->where('user_id',auth()->id());
        })->get()]);
    })->name('home');

    Route::prefix('add-car')->group(function () {
        Route::get('/', function () {
            return view('add-car', ['cars' => Cars::where('user_id', auth()->id())->paginate(14)]);
        })->name('add-car');
        Route::post('/', function (\Illuminate\Http\Request $request) {
            Cars::create(['user_id' => auth()->id(), 'number' => $request->number]);
            return redirect(\route('add-car'));
        });
    });

});
Route::prefix('admin')->middleware('admin')->group(function () {
    Route::get('/', function () {
        $users = User::with('getRole')->whereHas('getRole', function ($query) {
            $query->where('role_id', 0);
        })->count();
        return view('admin.index', compact('users'));
    })->name('admin.index');
    Route::get('users', function () {
        $users = User::with(['getRole', 'getCar'])->paginate(15);
        return view('admin.users', compact('users'));
    })->name('admin.users');

    Route::prefix('fine')->group(function () {
        Route::get('/{id?}/{number?}', function ($id = null, $number = null) {

            $query = Cars::where('user_id', $id);
            if ($number) {
                $query = $query->where('number', $number);
            }

            return view('admin.fine', ['fines' =>\App\Fine::with('getCar')->whereIn('car_id',$query->get()->pluck('id'))->paginate(15),'user'=>User::with('getCar')->where('id', $id)->first()]);
        })->name('admin.fine');
        Route::post('/', function (\Illuminate\Http\Request $request) {
            \App\Fine::create($request->only(['car_id', 'text', 'price']));
            $car = Cars::where('id', $request->car_id)->first();
            return redirect(\route('admin.fine', ['id' => $car->user_id, 'number' => $car->number]));
        });
    });
});
