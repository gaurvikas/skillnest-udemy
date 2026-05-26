<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CertificateController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\CourseReviewController;
use App\Http\Controllers\Admin\EnrollmentController;
use App\Http\Controllers\Admin\LessonController;
use App\Http\Controllers\Admin\LessonProgressController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Frontend\Auth\AccountController;
use App\Http\Controllers\Frontend\Auth\AuthController;
use App\Http\Controllers\Frontend\Auth\InstructorController;
use App\Http\Controllers\Frontend\Auth\LoginController;
use App\Http\Controllers\Frontend\Auth\RegisterController;
use App\Http\Controllers\Frontend\BuyNowController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\Course\CourseController as FrontendCourseController;
use App\Http\Controllers\Frontend\CourseInstructor\CourseInstructorController;
use App\Http\Controllers\Frontend\CoursePlayerController;
use App\Http\Controllers\Frontend\Discussion\DiscussionController;
use App\Http\Controllers\Frontend\GenerateCertificateController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\MyLearningController;
use App\Http\Controllers\Frontend\ReviewController;
use App\Http\Controllers\Frontend\WishlistController;
use App\Http\Controllers\InstructorStripeController;
use App\Http\Controllers\Settings;
use App\Http\Controllers\StripeWebhookController;
use App\Http\Middleware\IsAdminMiddleware;
use App\Http\Middleware\IsInstructorMiddleware;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

// ====================Dashboard====================
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified', IsAdminMiddleware::class])
    ->name('dashboard');

// ====================Admin Routes====================
Route::middleware(['auth', IsAdminMiddleware::class])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('users', UserController::class);
    Route::resource('roles', RoleController::class);
    Route::post('roles/store-permission', [RoleController::class, 'storePermission'])->name('roles.store-permission');
    Route::resource('courses', CourseController::class);
    Route::resource('lessons', LessonController::class);
    Route::resource('enrollments', EnrollmentController::class);
    Route::resource('lesson-progress', LessonProgressController::class);
    Route::resource('course-reviews', CourseReviewController::class);
    Route::resource('certificates', CertificateController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('coupons', CouponController::class);
    Route::resource('contacts', ContactController::class);
    Route::get('courses/{course}/sections', function (Course $course) {
        return $course->sections()->select('id', 'title')->get();
    })->name('courses.sections');
});

// ====================Auth Routes====================
Route::get('login', [LoginController::class, 'login'])->name('login');
Route::post('login', [LoginController::class, 'store'])->name('login.store');
Route::get('register', [RegisterController::class, 'index'])->name('register');
Route::post('register', [RegisterController::class, 'store'])->name('register.store');

// ====================Google OAuth====================
Route::get('/auth/google', fn () => Socialite::driver('google')->redirect())->name('auth.google');
Route::get('/auth/google/callback', [AuthController::class, 'googleCallback'])->name('auth.google.callback');

// ====================Home====================
Route::get('/', [HomeController::class, 'index'])->name('index');
Route::get('about', fn () => view('frontend.pages.about'))->name('about');

// ====================Courses====================
Route::get('courses/search', [HomeController::class, 'list'])->name('courses.search');
Route::get('course/{slug}', [HomeController::class, 'course'])->name('courses.show');

// ====================Categories====================
Route::get('categories', [FrontendCourseController::class, 'category'])->name('categories.index');
Route::get('category/{slug}', [FrontendCourseController::class, 'categoryCourse'])->name('categories.show');

// ====================Cart====================
Route::get('cart', [CartController::class, 'index'])->name('cart.index');
Route::post('cart', [CartController::class, 'store'])->name('cart.store');
Route::delete('cart/{courseId}', [CartController::class, 'destroy'])->name('cart.destroy');
Route::post('cart/coupon/apply', [CartController::class, 'applyCoupon'])->name('cart.coupon.apply');
Route::delete('cart/coupon/remove', [CartController::class, 'removeCoupon'])->name('cart.coupon.remove');

// ====================Wishlist====================
Route::get('wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
Route::post('wishlist/{courseId}', [WishlistController::class, 'store'])->name('wishlist.store');
Route::delete('wishlist/{courseId}', [WishlistController::class, 'remove'])->name('wishlist.destroy');

// ====================Checkout====================
Route::get('checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('checkout', [CheckoutController::class, 'store'])->name('checkout.store');
Route::get('checkout/success', fn (Request $request) => to_route('index'))->name('checkout.success');

// ====================Stripe Webhook====================
Route::post('stripe/webhook', [StripeWebhookController::class, 'handleWebhook'])->name('stripe.webhook');

// ====================Buy Now====================

// routes/web.php
Route::middleware('auth')->group(function () {
    Route::get('buy/{course}', [BuyNowController::class, 'index'])->name('buy.index');
    Route::post('buy/{course}', [BuyNowController::class, 'store'])->name('buy.store');
    Route::post('buy/{course}/coupon', [BuyNowController::class, 'applyCoupon'])->name('buy.coupon.apply'); // ← add
});
// ====================Authenticated Routes====================
Route::middleware(['auth'])->group(function () {

    // My Learning
    Route::get('my-learning', [MyLearningController::class, 'index'])->name('my-learning.index');

    // Course Player
    Route::get('course/{course}/learn', [CoursePlayerController::class, 'learn'])->name('course.learn');
    Route::get('course/{course}/learn/lesson/{lesson}', [CoursePlayerController::class, 'learn'])->name('course.learn.lesson');
    Route::post('lesson/{lesson}/complete', [CoursePlayerController::class, 'markComplete'])->name('lesson.complete');
    Route::post('lesson/{lesson}/progress', [CoursePlayerController::class, 'updateProgress'])->name('lesson.progress');

    // Certificate
    Route::get('certificate/{slug}', [GenerateCertificateController::class, 'index'])->name('certificate.show');
    Route::get('certificate/{slug}/download', [GenerateCertificateController::class, 'download'])->name('certificate.download');

    // Profile
    Route::get('profile', [AccountController::class, 'index'])->name('profile.index');
    Route::put('profile', [AccountController::class, 'update'])->name('profile.update');

    // Settings
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('profile', [Settings\ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('profile', [Settings\ProfileController::class, 'update'])->name('profile.update');
        Route::delete('profile', [Settings\ProfileController::class, 'destroy'])->name('profile.destroy');
        Route::get('password', [Settings\PasswordController::class, 'edit'])->name('password.edit');
        Route::put('password', [Settings\PasswordController::class, 'update'])->name('password.update');
        Route::get('appearance', [Settings\AppearanceController::class, 'edit'])->name('appearance.edit');
    });

    // Instructor Dashboard
    Route::get('instructor/dashboard', [CourseInstructorController::class, 'dashboard'])->name('instructor.dashboard');
});

// ====================Reviews====================
Route::get('course/{course}/review', [ReviewController::class, 'index'])->name('reviews.index');
Route::post('course/{course}/review', [ReviewController::class, 'store'])->name('reviews.store');

// ====================Discussion====================
Route::get('discussion', [DiscussionController::class, 'index'])->name('discussion.index');
Route::post('discussion', [DiscussionController::class, 'store'])->name('discussion.store');
Route::post('discussion/{discussion}/reply', [DiscussionController::class, 'reply'])->name('discussion.reply');
Route::delete('discussion/reply/{reply}', [DiscussionController::class, 'deleteReply'])->name('discussion.reply.destroy');

// ====================Read Notification====================
Route::post('read-all-notifications', function () {
    auth()->user()->unreadNotifications->markAsRead();

    return back();
})->name('read-all-notifications');

// ====================Course Export====================
Route::get('/courses/export', [CourseController::class, 'export'])->name('courses.export');

// ====================Course Import====================
Route::post('/courses/import', [CourseController::class, 'import'])->name('courses.import');

Route::get('contact-us', [HomeController::class, 'contact'])->name('contact-us');
Route::post('contact-us', [HomeController::class, 'store'])->name('contact-us.store');

Route::post('contacts/{contact}/reply', [ContactController::class, 'reply'])->name('contacts.reply');

Route::middleware(['auth', IsInstructorMiddleware::class])->prefix('instructor/stripe')->group(function () {
    Route::get('/onboard', [InstructorStripeController::class, 'onboard'])->name('instructor.stripe.onboard');
    Route::get('/success', [InstructorStripeController::class, 'success'])->name('instructor.stripe.success');
    Route::get('/dashboard', [InstructorStripeController::class, 'dashboard'])->name('instructor.stripe.dashboard');
});

// ====================Instructor====================
Route::get('instructor/login', [InstructorController::class, 'instructorLogin'])->name('instructor.login');
Route::post('instructor/login', [InstructorController::class, 'store'])->name('instructor.login.store');
Route::resource('instructor', CourseInstructorController::class)
    ->parameters(['instructor' => 'course'])
    ->middleware(['auth', IsInstructorMiddleware::class]);

require __DIR__.'/auth.php';
