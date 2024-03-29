<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientsController;
use App\Http\Controllers\CompaniesController;
use App\Http\Controllers\MastersController;
use App\Http\Controllers\FunnelController;
use App\Http\Controllers\BrandsController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\CostController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\TasksController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\CostCategoriesController;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\FinanceController;
use App\Http\Controllers\WoocommerceController;
use App\Http\Controllers\FeedbacksController;
use Illuminate\Http\Request;

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

Route::group(['middleware' => 'auth'], function () {
    
    // mainpage
    Route::get('/', function () {
        $sales = App\Models\Sales::whereDate('created_at', today() ) -> count();
        $funnels = App\Models\Funnel::whereDate('created_at', today() ) -> count();
        return view('mainpage', compact('sales', 'funnels'));
    });
    
    Route::resource('client-base', ClientsController::class );
    
    Route::resource('companies-base', CompaniesController::class );
    
    Route::resource('masters-base', MastersController::class); 
    
    Route::resource('funnel', FunnelController::class); 

    Route::resource('brands', BrandsController::class); 

    Route::resource('categories', CategoriesController::class);

    Route::resource('products', ProductsController::class);

    Route::resource('tasks', TasksController::class);

    Route::get('/analytics',  [AnalyticsController::class, 'index' ]);
    Route::get('/analytics/funnel',  [AnalyticsController::class, 'funnel' ]);

    Route::resource('/woocommerce', WoocommerceController::class);
    // feedbacks
    route::group(['prefix'=>'feedbacks'],function(){
        Route::get('/pending',          [FeedbacksController::class,    'pending']);
        Route::get('/ask',              [FeedbacksController::class,    'ask']);
        Route::get('/asked',            [FeedbacksController::class,    'asked']);
        Route::get('/reviewed',         [FeedbacksController::class,    'reviewed']);
        Route::get('/will-not-review',  [FeedbacksController::class,    'willNotReview']);
        Route::get('/{id}/edit',        [FeedbacksController::class,    'edit'])    ->name('feedbacks.edit');
        Route::put('/{id}/update/',     [FeedbacksController::class,    'update'])  ->name('feedbacks.update');
        Route::put('/{id}/set-as-will-not-review',     [FeedbacksController::class,    'SetAsWillNotReview'])  ->name('feedbacks.set');
        Route::put('/{id}/back',     [FeedbacksController::class,    'back'])  ->name('feedbacks.back');
    });
    
    


    // only for admins
    Route::group(['middleware' => 'admin'], function () {
        Route::get('/finance',  [FinanceController::class, 'index' ]);
        Route::get('/finance/plan',  [FinanceController::class, 'plan' ]);
        Route::post('/finance/plan',  [FinanceController::class, 'storePlan' ]);
        Route::delete('/finance/plan/{id}',  [FinanceController::class, 'destroyPlan' ]);
        Route::get('/finance/annual',  [FinanceController::class, 'annual' ]);
        Route::get('/finance/brand',  [FinanceController::class, 'brand' ]);
        Route::get('/finance/category',  [FinanceController::class, 'category' ]);
        Route::get('/finance/products{filter?}', [FinanceController::class, 'product'])->name('products-filter');
        
        Route::resource('sales', SalesController::class);

        Route::resource('costs', CostController::class);

        Route::resource('currency', CurrencyController::class);

        Route::resource('cost-categories', CostCategoriesController::class);
    });
    // not admin page
    route::get('/notAdmin', function(){
        return view('notAdmin');
    });
    
    // ta have api token for users
    Route::get('/get-api-token', function(Request $request) {
        $token = $request->user()->createToken('app');
        return ['token' => $token->plainTextToken];
    });

});


// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';