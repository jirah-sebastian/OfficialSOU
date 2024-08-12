<?php
Use App\Http\Controllers\Sois\StudentOrganizationController;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


Route::get('/', function () { return redirect('/sois'); });
Route::get('/test', function () { return view('mail.so-register'); });
Auth::routes();

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth', 'admin','redirectIfNotSet']], function () {
    
    Route::get('/', 'HomeController@index')->name('home');

    //custom routes
    Route::post('/so-approval', 'SoRegistrationController@approval')->name('so.approval');
    //Route::get('/user-approval/{id}/{status}', 'UsersController@approval');
    Route::get('/solist-approval/{id}/{status}', 'SoListController@approval');

    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::resource('users', 'UsersController');
    Route::get('/user-restore/{id}/{action}','UsersController@restore')->name('user.restore');
    Route::get('/user-approve/{id}/{action}','UsersController@approval')->name('user.approve');

    // Audit Logs
    Route::resource('audit-logs', 'AuditLogsController', ['except' => ['create', 'store', 'edit', 'update', 'destroy']]);

    // Activity
    Route::delete('activities/destroy', 'ActivityController@massDestroy')->name('activities.massDestroy');
    Route::post('activities/media', 'ActivityController@storeMedia')->name('activities.storeMedia');
    Route::post('activities/ckmedia', 'ActivityController@storeCKEditorImages')->name('activities.storeCKEditorImages');
    Route::resource('activities', 'ActivityController');
    Route::get('/activity-restore/{id}/{action}','ActivityController@restore')->name('activity.restore');
    Route::get('/activity-approve/{id}/{action}','ActivityController@approve')->name('activity.approve');


    // Announcement
    Route::delete('announcements/destroy', 'AnnouncementController@massDestroy')->name('announcements.massDestroy');
    Route::post('announcements/media', 'AnnouncementController@storeMedia')->name('announcements.storeMedia');
    Route::post('announcements/ckmedia', 'AnnouncementController@storeCKEditorImages')->name('announcements.storeCKEditorImages');
    Route::resource('announcements', 'AnnouncementController');
    Route::get('/announcement-restore/{id}/{action}','AnnouncementController@restore')->name('announcement.restore');

    // Resources
    Route::delete('resources/destroy', 'ResourcesController@massDestroy')->name('resources.massDestroy');
    Route::post('resources/media', 'ResourcesController@storeMedia')->name('resources.storeMedia');
    Route::post('resources/ckmedia', 'ResourcesController@storeCKEditorImages')->name('resources.storeCKEditorImages');
    Route::resource('resources', 'ResourcesController');
    Route::get('/resource-restore/{id}/{action}','ResourcesController@restore')->name('resource.restore');

    // So Category
    Route::delete('so-categories/destroy', 'SoCategoryController@massDestroy')->name('so-categories.massDestroy');
    Route::resource('so-categories', 'SoCategoryController');
    Route::get('/so-categories-restore/{id}/{action}', 'SoCategoryController@restore')->name('so-categories.restore');

    // So List
    Route::delete('so-lists/destroy', 'SoListController@massDestroy')->name('so-lists.massDestroy');
    Route::post('so-lists/media', 'SoListController@storeMedia')->name('so-lists.storeMedia');
    Route::post('so-lists/ckmedia', 'SoListController@storeCKEditorImages')->name('so-lists.storeCKEditorImages');
    Route::resource('so-lists', 'SoListController');
    Route::get('/so-list-restore/{id}/{action}','SoListController@restore')->name('so-list.restore');
    Route::get('/so-list-approve/{id}/{action}','SoListController@approve')->name('so-list.approve');

    // So Registration`
    Route::delete('so-registrations/destroy', 'SoRegistrationController@massDestroy')->name('so-registrations.massDestroy');
    // Route::post('so-registrations/media', 'SoRegistrationController@storeMedia')->name('so-registrations.storeMedia');
    // Route::post('so-registrations/ckmedia', 'SoRegistrationController@storeCKEditorImages')->name('so-registrations.storeCKEditorImages');
    Route::resource('so-registrations', 'SoRegistrationController');
    Route::get('/so-registrations-pres-approval/{id}/{action}','SoRegistrationController@presapproval')->name('so-registration.presapproval');
    Route::get('/so-registrations-admin-approval/{id}/{action}','SoRegistrationController@adminapproval')->name('so-registration.adminapproval');
    Route::get('/so-registrations/restore/{id}/{action}', 'SoRegistrationController@restore')->name('so-registrations.restore');


    // About
    Route::delete('abouts/destroy', 'AboutController@massDestroy')->name('abouts.massDestroy');
    Route::post('abouts/media', 'AboutController@storeMedia')->name('abouts.storeMedia');
    Route::post('abouts/ckmedia', 'AboutController@storeCKEditorImages')->name('abouts.storeCKEditorImages');
    Route::resource('abouts', 'AboutController');

    // Title
    Route::delete('titles/destroy', 'TitleController@massDestroy')->name('titles.massDestroy');
    Route::resource('titles', 'TitleController');

    // Organization Application Form
    Route::delete('organization-application-forms/destroy', 'OrganizationApplicationFormController@massDestroy')->name('organization-application-forms.massDestroy');
     Route::post('organization-application-forms/media', 'OrganizationApplicationFormController@storeMedia')->name('organization-application-forms.storeMedia');
    Route::post('organization-application-forms/ckmedia', 'OrganizationApplicationFormController@storeCKEditorImages')->name('organization-application-forms.storeCKEditorImages');
    Route::resource('organization-application-forms', 'OrganizationApplicationFormController');
});

Route::post('admin/so-registrations/media', 'Admin\\SoRegistrationController@storeMedia')->name('admin.so-registrations.storeMedia');
Route::post('admin/so-registrations/ckmedia', 'Admin\\SoRegistrationController@storeCKEditorImages')->name('admin.so-registrations.storeCKEditorImages');
Route::post('admin/so-registrations','Admin\\SoRegistrationController@store')->name('admin.so-registrations.store');
Route::post('admin/users/media', 'Admin\\UsersController@storeMedia')->name('admin.users.storeMedia');
Route::post('admin/users/ckmedia', 'Admin\\UsersController@storeCKEditorImages')->name('admin.users.storeCKEditorImages');

Route::group(['prefix' => 'profile', 'as' => 'profile.', 'namespace' => 'Auth', 'middleware' => ['auth']], function () {
    // Change password
    if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php'))) {
        Route::get('password', 'ChangePasswordController@edit')->name('password.edit');
        Route::post('password', 'ChangePasswordController@update')->name('password.update');
        Route::post('profile', 'ChangePasswordController@updateProfile')->name('password.updateProfile');
        Route::post('profile/destroy', 'ChangePasswordController@destroy')->name('password.destroyProfile');
    }
});
Route::group(['as' => 'frontend.', 'namespace' => 'Frontend', 'middleware' => ['auth']], function () {
    Route::get('/home', 'HomeController@index')->name('home');

    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::post('users/media', 'UsersController@storeMedia')->name('users.storeMedia');
    Route::post('users/ckmedia', 'UsersController@storeCKEditorImages')->name('users.storeCKEditorImages');
    Route::resource('users', 'UsersController');

    // Activity
    Route::delete('activities/destroy', 'ActivityController@massDestroy')->name('activities.massDestroy');
    Route::post('activities/media', 'ActivityController@storeMedia')->name('activities.storeMedia');
    Route::post('activities/ckmedia', 'ActivityController@storeCKEditorImages')->name('activities.storeCKEditorImages');
    Route::resource('activities', 'ActivityController');

    // Announcement
    Route::delete('announcements/destroy', 'AnnouncementController@massDestroy')->name('announcements.massDestroy');
    Route::post('announcements/media', 'AnnouncementController@storeMedia')->name('announcements.storeMedia');
    Route::post('announcements/ckmedia', 'AnnouncementController@storeCKEditorImages')->name('announcements.storeCKEditorImages');
    Route::resource('announcements', 'AnnouncementController');

    // Resources
    Route::delete('resources/destroy', 'ResourcesController@massDestroy')->name('resources.massDestroy');
    Route::post('resources/media', 'ResourcesController@storeMedia')->name('resources.storeMedia');
    Route::post('resources/ckmedia', 'ResourcesController@storeCKEditorImages')->name('resources.storeCKEditorImages');
    Route::resource('resources', 'ResourcesController');

    // So Category
    Route::delete('so-categories/destroy', 'SoCategoryController@massDestroy')->name('so-categories.massDestroy');
    Route::resource('so-categories', 'SoCategoryController');

    // So List
    Route::delete('so-lists/destroy', 'SoListController@massDestroy')->name('so-lists.massDestroy');
    Route::post('so-lists/media', 'SoListController@storeMedia')->name('so-lists.storeMedia');
    Route::post('so-lists/ckmedia', 'SoListController@storeCKEditorImages')->name('so-lists.storeCKEditorImages');
    Route::resource('so-lists', 'SoListController');

    // So Registration
    Route::delete('so-registrations/destroy', 'SoRegistrationController@massDestroy')->name('so-registrations.massDestroy');
    Route::post('so-registrations/media', 'SoRegistrationController@storeMedia')->name('so-registrations.storeMedia');
    Route::post('so-registrations/ckmedia', 'SoRegistrationController@storeCKEditorImages')->name('so-registrations.storeCKEditorImages');
    Route::resource('so-registrations', 'SoRegistrationController');


    // About
    Route::delete('abouts/destroy', 'AboutController@massDestroy')->name('abouts.massDestroy');
    Route::post('abouts/media', 'AboutController@storeMedia')->name('abouts.storeMedia');
    Route::post('abouts/ckmedia', 'AboutController@storeCKEditorImages')->name('abouts.storeCKEditorImages');
    Route::resource('abouts', 'AboutController');

    // Title
    Route::delete('titles/destroy', 'TitleController@massDestroy')->name('titles.massDestroy');
    Route::resource('titles', 'TitleController');

    // Organization Application Form
    Route::delete('organization-application-forms/destroy', 'OrganizationApplicationFormController@massDestroy')->name('organization-application-forms.massDestroy');
    Route::post('organization-application-forms/media', 'OrganizationApplicationFormController@storeMedia')->name('organization-application-forms.storeMedia');
    Route::post('organization-application-forms/ckmedia', 'OrganizationApplicationFormController@storeCKEditorImages')->name('organization-application-forms.storeCKEditorImages');
    Route::resource('organization-application-forms', 'OrganizationApplicationFormController');

    Route::get('frontend/profile', 'ProfileController@index')->name('profile.index');
    Route::post('frontend/profile', 'ProfileController@update')->name('profile.update');
    Route::post('frontend/profile/destroy', 'ProfileController@destroy')->name('profile.destroy');
    Route::post('frontend/profile/password', 'ProfileController@password')->name('profile.password');
});

Route::group(['prefix' => 'sois','namespace' => 'Sois', 'as' => 'sois.'], function () {
    Route::resource('/', AboutController::class);
    Route::resource('/activities', ActivityController::class);
    Route::resource('/announcements', AnnouncementController::class);
    Route::resource('/resources', ResourceController::class);
    Route::resource('/student-organizations', StudentOrganizationController::class);
    Route::resource('/dashboard', DashboardController::class);
    Route::get('/student-organization/apply/{id}',[StudentOrganizationController::class,'apply']);

    // Route::get('/forgot', [AuthController::class,'forgot'])->name('forgot');
    // Route::get('/login', [AuthController::class,'login'])->name('login');
    // Route::get('/register', [AuthController::class,'register'])->name('register');
    // Route::get('/reset', [AuthController::class,'reset'])->name('reset');
});

// Route::get('/resource/{id}', function ($id){
//     $media = Media::findOrFail($id);

//     return response()->download($media->getPath());
// })->name('resource');