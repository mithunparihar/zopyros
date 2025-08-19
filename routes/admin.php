<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['admin.guest'])->controller(\App\Http\Controllers\Admin\Auth\LoginController::class)->group(function () {
    Route::get('/login', 'create')->name('login');
    Route::post('/login', 'store')->name('adminlogin');

    Route::post('/send-forgot-password-link', 'sendforgotpasswordlink')->name('sendforgotpasswordlink');
    Route::get('/forgot', 'forgotpassword')->name('forgotpassword');
    Route::get('/reset/{token}', 'resetpasswordget')->name('resetpasswordget');

});

Route::middleware(['isAdmin'])->group(function () {

    /// Two Factor Auth
    Route::controller(\App\Http\Controllers\Admin\Auth\TwoFactorController::class)->group(function () {
        Route::get('two-steps-verification', 'twostepsverification')->name('twostepsverification');
        Route::get('resend-two-steps-verification', 'resendtwostepsverification')->name('resendtwostepsverification');
        Route::post('/check-two-steps-verification', 'checktwostepsverification')->name('checktwostepsverification');
    });

    Route::middleware(['2Factor'])->group(function () {
        Route::controller(\App\Http\Controllers\Admin\HomeController::class)->group(function () {
            Route::post('/editor-upload', 'ckeditorupload')->name('ckeditor.upload');

            Route::get('/', function () {
                return redirect()->route('admin.dashboard');
            })->name('home');
            Route::get('/dashboard', 'index')->name('dashboard');

            Route::get('setting/{id?}', 'setting')->name('setting');
        });

        Route::resource('cms', App\Http\Controllers\Admin\CmsController::class, ['only' => ['edit']]);

        /// Contact Us
        Route::resource('contact-information', App\Http\Controllers\Admin\ContactController::class, ['only' => ['edit', 'index']]);

        /// Banner & Slider
        Route::resource('banner', App\Http\Controllers\Admin\BannerController::class);
        Route::controller(App\Http\Controllers\Admin\BannerController::class)->name('banner.')->group(function () {
            Route::post('banner/{banner}/publish', 'publish')->name('publish');
            Route::post('banner/remove', 'destory')->name('remove');
        });

        /// Countries
        Route::resource('countries', App\Http\Controllers\Admin\CountryController::class, ['only' => ['index']]);
        Route::post('countries/{countries}/publish', [App\Http\Controllers\Admin\CountryController::class, 'publish'])->name('countries.publish');
        Route::post('countries/{countries}/active-currency', [App\Http\Controllers\Admin\CountryController::class, 'activeCurrency'])->name('countries.active-currency');

        Route::resource('countries/{countries}/states', App\Http\Controllers\Admin\StateController::class, ['only' => ['index']]);
        Route::post('countries/{countries}/states/{states}/publish', [App\Http\Controllers\Admin\StateController::class, 'publish'])->name('states.publish');

        Route::resource('countries/{countries}/states/{states}/cities', App\Http\Controllers\Admin\CityController::class, ['only' => ['index']]);
        Route::post('countries/{countries}/states/{states}/cities/{cities}/publish', [App\Http\Controllers\Admin\CityController::class, 'publish'])->name('cities.publish');

        /// Career
        Route::resource('career', App\Http\Controllers\Admin\CareerController::class);
        Route::controller(App\Http\Controllers\Admin\CareerController::class)->name('career.')->group(function () {
            Route::post('career/{career}/publish', 'publish')->name('publish');
            Route::post('career/remove', 'destory')->name('remove');
            Route::post('career/sequence', 'sequence')->name('sequence');
        });

        /// FAQs
        Route::resource('faq-category', App\Http\Controllers\Admin\FaqCategoryController::class);
        Route::post('faq-category/{faq_category}/publish', [App\Http\Controllers\Admin\FaqCategoryController::class, 'publish'])->name('faq-category.publish');
        Route::post('faq-category/remove', [App\Http\Controllers\Admin\FaqCategoryController::class, 'destory'])->name('faq-category.remove');

        Route::resource('faq', App\Http\Controllers\Admin\FaqController::class);
        Route::controller(App\Http\Controllers\Admin\FaqController::class)->name('faq.')->group(function () {
            Route::post('faq/{faq}/publish', 'publish')->name('publish');
            Route::post('faq/{faq}/home/publish', 'homePublish')->name('home.publish');
            Route::post('faq/remove', 'destory')->name('remove');
        });

        /// Testimonial
        Route::resource('testimonial', App\Http\Controllers\Admin\TestimonialController::class);
        Route::controller(App\Http\Controllers\Admin\TestimonialController::class)->name('testimonial.')->group(function () {
            Route::post('testimonial/{testimonial}/publish', 'publish')->name('publish');
            Route::post('testimonial/{testimonial}/home/publish', 'homePublish')->name('home.publish');
            Route::post('testimonial/remove', 'destory')->name('remove');
        });

        /// Team
        Route::resource('team', App\Http\Controllers\Admin\TeamController::class);
        Route::controller(App\Http\Controllers\Admin\TeamController::class)->name('team.')->group(function () {
            Route::post('team/{team}/publish', 'publish')->name('publish');
            Route::post('team/{team}/home/publish', 'homePublish')->name('home.publish');
            Route::post('team/remove', 'destory')->name('remove');
            Route::post('team/sequence', 'sequence')->name('sequence');
        });

        /// Awards & Recognitions
        Route::resource('awards', App\Http\Controllers\Admin\AwardController::class, ['only' => ['index']]);

        ///Variants
        Route::resource('variants', App\Http\Controllers\Admin\VariantController::class);
        Route::controller(App\Http\Controllers\Admin\VariantController::class)->name('variants.')->prefix('variants')->group(function () {
            Route::post('{variant}/publish', 'publish')->name('publish');
            Route::post('{variant}/home/publish', 'homePublish')->name('home.publish');
            Route::post('remove', 'destory')->name('remove');
        });

        ///Products
        Route::resource('products', App\Http\Controllers\Admin\ProductController::class);
        Route::controller(App\Http\Controllers\Admin\ProductController::class)->name('products.')->prefix('products')->group(function () {
            Route::post('{product}/publish', 'publish')->name('publish');
            Route::post('{product}/home/publish', 'homePublish')->name('home.publish');
            Route::post('remove', 'destory')->name('remove');
        });

        /// Categories
        Route::resource('categories', App\Http\Controllers\Admin\CategoroyController::class);
        Route::post('categories/{categories}/publish', [App\Http\Controllers\Admin\CategoroyController::class, 'publish'])->name('categories.publish');
        Route::post('categories/{categories}/publish/home', [App\Http\Controllers\Admin\CategoroyController::class, 'homePublish'])->name('categories.home.publish');
        Route::post('categories/{categories}/publish/featured', [App\Http\Controllers\Admin\CategoroyController::class, 'featuredPublish'])->name('categories.featured.publish');
        Route::post('categories/{categories}/publish/menu', [App\Http\Controllers\Admin\CategoroyController::class, 'menuPublish'])->name('categories.menu.publish');
        Route::post('categories/{categories}/publish/footer', [App\Http\Controllers\Admin\CategoroyController::class, 'footerPublish'])->name('categories.footer.publish');
        Route::post('categories/remove', [App\Http\Controllers\Admin\CategoroyController::class, 'destory'])->name('categories.remove');
        Route::post('categories/sequence', [App\Http\Controllers\Admin\CategoroyController::class, 'sequence'])->name('categories.sequence');
        Route::post('categories/bulk/remove', [App\Http\Controllers\Admin\CategoroyController::class, 'bulkdestroy'])->name('categories.bulkdestroy');

        Route::get('categories/{categories}/faq', [App\Http\Controllers\Admin\CategoryFaqController::class, 'index'])->name('categories.faq.index');
        Route::get('categories/{categories}/faq/create', [App\Http\Controllers\Admin\CategoryFaqController::class, 'create'])->name('categories.faq.create');
        Route::get('categories/{categories}/faq/{faq}/edit', [App\Http\Controllers\Admin\CategoryFaqController::class, 'edit'])->name('categories.faq.edit');
        Route::post('categories/{categories}/faq/{faq}/publish', [App\Http\Controllers\Admin\CategoryFaqController::class, 'publish'])->name('categories.faq.publish');
        Route::post('categories/{categories}/faq/remove', [App\Http\Controllers\Admin\CategoryFaqController::class, 'destory'])->name('categories.faq.remove');

        Route::get('categories/{category}/variants', [App\Http\Controllers\Admin\CategoryVariantController::class, 'index'])->name('categories.variants.index');
        Route::get('categories/{category}/variants/create', [App\Http\Controllers\Admin\CategoryVariantController::class, 'create'])->name('categories.variants.create');
        Route::get('categories/{category}/variants/{variant}/edit', [App\Http\Controllers\Admin\CategoryVariantController::class, 'edit'])->name('categories.variants.edit');
        Route::post('categories/{category}/variants/{variant}/publish', [App\Http\Controllers\Admin\CategoryVariantController::class, 'publish'])->name('categories.variants.publish');
        Route::post('categories/{category}/variants/remove', [App\Http\Controllers\Admin\CategoryVariantController::class, 'destory'])->name('categories.variants.remove');

        // Project
        Route::resource('projects', App\Http\Controllers\Admin\ProjectController::class);
        Route::controller(App\Http\Controllers\Admin\ProjectController::class)->name('projects.')->group(function () {
            Route::post('projects/{project}/publish', 'publish')->name('publish');
            Route::post('projects/remove', 'destory')->name('remove');
            Route::post('projects/sequence', 'sequence')->name('sequence');
            Route::post('projects/{project}/home/publish', 'homepublish')->name('home.publish');

        });

        /// BLOGS
        Route::resource('blog', App\Http\Controllers\Admin\BlogController::class);
        Route::controller(App\Http\Controllers\Admin\BlogController::class)->name('blog.')->group(function () {
            Route::post('blog/{blog}/publish', 'publish')->name('publish');
            Route::post('blog/remove', 'destory')->name('remove');
        });

        Route::resource('blog-category', App\Http\Controllers\Admin\BlogCategoryController::class);
        Route::controller(App\Http\Controllers\Admin\BlogCategoryController::class)->name('blog-category.')->group(function () {
            Route::post('blog-category/{blog_category}/publish', 'publish')->name('publish');
            Route::post('blog-category/remove', 'destory')->name('remove');
        });

        /// Social Media
        Route::controller(App\Http\Controllers\Admin\SocialMediaController::class)->group(function () {
            Route::get('social-media', 'socialMedia')->name('socialMedia');
            Route::get('social-media/edit/{info}', 'socialMediaEdit')->name('socialMedia.edit');
            Route::post('social-media/update', 'socialMediaUpdate')->name('socialMedia.update');
        });

        // Meta Management
        Route::resource('meta', App\Http\Controllers\Admin\MetaController::class);

        Route::controller(App\Http\Controllers\Admin\ProfileController::class)->group(function () {
            Route::get('profile', 'index')->name('profile');
            Route::get('notifications', 'notifications')->name('notifications');
            Route::get('notifications/{id}/remove', 'removeNotification')->name('notifications.remove');
        });

        Route::controller(App\Http\Controllers\Admin\SecurityController::class)->group(function () {
            Route::get('security', 'index')->name('security');
            Route::post('country-states', 'countryStates')->name('countryStates');
            Route::post('states-city', 'statesCity')->name('statesCity');
        });

        // Enquiry Management
        Route::controller(App\Http\Controllers\Admin\EnquiryController::class)->group(function () {
            Route::get('enquiry/subscribe', 'subscribeEnquiry')->name('enquiry.subscribe');
            Route::post('enquiry/subscribe/remove', 'destorySubscribeEnquiry')->name('enquiry.subscribe.remove');
            Route::post('enquiry/subscribe/bulk/remove', 'bulkdestroySubscribeEnquiry')->name('enquiry.subscribe.bulkdestroy');

            Route::get('enquiry/contact', 'contactEnquiry')->name('enquiry.contact');
            Route::post('enquiry/contact/remove', 'destoryContactEnquiry')->name('enquiry.contact.remove');
            Route::post('enquiry/contact/bulk/remove', 'bulkdestroyContactEnquiry')->name('enquiry.contact.bulkdestroy');

            Route::get('enquiry/career', 'careerEnquiry')->name('enquiry.career');
            Route::post('enquiry/career/remove', 'destoryCareerEnquiry')->name('enquiry.career.remove');
            Route::post('enquiry/career/bulk/remove', 'bulkdestroyCareerEnquiry')->name('enquiry.career.bulkdestroy');

            Route::get('enquiry/free-estimation', 'quoteEnquiry')->name('enquiry.quote');
            Route::post('enquiry/free-estimation/remove', 'destoryQuoteEnquiry')->name('enquiry.quote.remove');
            Route::post('enquiry/free-estimation/bulk/remove', 'bulkdestroyQuoteEnquiry')->name('enquiry.quote.bulkdestroy');

        });

    });

});
