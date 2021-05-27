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
    Route::get('parking',function (){
        return view('parking',['cars'=>Cars::with('getParking')->where('user_id',auth()->id())->whereHas('getParking')->paginate(15)]);
    })->name('parking');
});
Route::prefix('admin')->middleware('admin')->group(function () {
Route::get('/', function () {
        $users = User::with('getRole')->whereHas('getRole', function ($query) {
            $query->where('role_id', 0);
        })->count();
        $cars=Cars::with('getParking')->whereHas('getParking')->count();
        $orders=\App\Fine::all()->count();
        return view('admin.index', compact('users','cars','orders'));
    })->name('admin.index');
    Route::get('users', function () {
        $users = User::with(['getRole', 'getCar'])->paginate(15);
        return view('admin.users', compact('users'));
    })->name('admin.users');

    Route::prefix('fine')->group(function () {
        Route::get('delete/{id}',function ($id){
            \App\Fine::where('id',$id)->delete();
            return redirect()->back();
        })->name('admin.fine-delete');
        Route::get('/{id?}/{number?}', function ($id = null, $number = null) {
            if (!$id){
                $fines=\App\Fine::with('getCar')->whereIn('car_id',Cars::all()->pluck('id'))->paginate(15);
                return view('admin.fine', ['fines' =>$fines,'user'=>null]);
            }else{
                $query = Cars::where('user_id', $id);
                if ($number) {
                    $query = $query->where('number', $number);
                }
                $fines=\App\Fine::with('getCar')->whereIn('car_id',$query->get()->pluck('id'))->paginate(15);
                return view('admin.fine', ['fines' =>$fines,'user'=>User::with('getCar')->where('id', $id)->first()]);
            }
        })->name('admin.fine');
        Route::post('/{id?}/{car_id?}', function ($car_id=null,$id=null,\Illuminate\Http\Request $request) {
            $id?\App\Fine::where('id',$id)->update($request->only(['text', 'price','adr'])):
                \App\Fine::create($request->only(['car_id', 'text', 'price','adr']));
            $car = Cars::where('id', $car_id)->first();
            return redirect(\route('admin.fine', ['id' => $car->user_id, 'number' => $car->number]));
        });
        Route::get('delete',function (){dd(123);});
    });

    Route::get('parking/{id?}',function ($id=null){
        if ($id){
            \App\Parking::where('id',$id)->delete();
            return redirect(\route('admin.parking'));
        }
        $cars=Cars::with('getParking')->whereHas('getParking')->paginate(15);
        return view('admin.parking',['cars'=>$cars,'all'=>Cars::with('getParking')->whereDoesntHave('getParking',null)->get()]);
    })->name('admin.parking');
    Route::post('parking',function (\Illuminate\Http\Request $request){
        \App\Parking::create($request->only('car_id'));
        return redirect()->back();
    });

    Route::get('exel',function (){

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Номер машины');
        $sheet->setCellValue('B1', 'Штраф');
        $sheet->setCellValue('C1', 'Стоимость');
        $sheet->setCellValue('D1', 'Дата');
        $sheet->setCellValue('E1', 'Адрес');

        $fines=\App\Fine::with('getCar')->whereHas('getCar')->get();

        for($i=0;$i<$fines->count();$i++){
            $col=$i+2;
            $sheet->setCellValue('A'.$col, $fines[$i]->getCar->number);
            $sheet->setCellValue('B'.$col, $fines[$i]->text);
            $sheet->setCellValue('C'.$col, $fines[$i]->price);
            $sheet->setCellValue('D'.$col, $fines[$i]->created_at->format('H:i d/m/Y'));
            $sheet->setCellValue('E'.$col, $fines[$i]->adr);
        }

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save('exel.xlsx');

        return response()->download('exel.xlsx');
    })->name('admin.download');

});
