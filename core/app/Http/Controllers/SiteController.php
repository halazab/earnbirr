<?php

namespace App\Http\Controllers;

use App\Models\Frontend;
use App\Models\Page;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    public function index()
    {
        $pageTitle = 'Home';
        $sections = Page::where('slug', '/')->where('status', 1)->first();
        return view('templates.basic.home', compact('pageTitle', 'sections'));
    }

    public function contact()
    {
        $pageTitle = 'Contact Us';
        $content = getContent('contact_us', true);
        return view('templates.basic.contact', compact('pageTitle', 'content'));
    }

    public function contactSubmit(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'message' => 'required|string',
        ]);
        return back()->with('success', 'Message sent successfully.');
    }

    public function changeLanguage($lang = null)
    {
        $locales = config('app.locales', []);
        if ($lang && array_key_exists($lang, $locales)) {
            session()->put('locale', $lang);
        }
        return redirect()->back();
    }

    public function pages($slug)
    {
        $page = Page::where('slug', $slug)->where('status', 1)->firstOrFail();
        $pageTitle = $page->name;
        return view('templates.basic.pages', compact('pageTitle', 'page'));
    }

    public function policyPages($slug)
    {
        $pageTitle = 'Policy';
        return view('templates.basic.policy', compact('pageTitle'));
    }

    public function faq()
    {
        $pageTitle = 'FAQ';
        return view('templates.basic.faq', compact('pageTitle'));
    }

    public function about()
    {
        $pageTitle = 'About Us';
        $content = getContent('about_us', true);
        return view('templates.basic.about', compact('pageTitle', 'content'));
    }

    public function support()
    {
        $pageTitle = 'Support';
        $content = getContent('support', true);
        return view('templates.basic.support', compact('pageTitle', 'content'));
    }

    public function terms()
    {
        $pageTitle = 'Terms & Conditions';
        $content = getContent('terms_conditions', true);
        return view('templates.basic.terms', compact('pageTitle', 'content'));
    }

    public function privacy()
    {
        $pageTitle = 'Privacy Policy';
        $content = getContent('privacy_policy', true);
        return view('templates.basic.privacy', compact('pageTitle', 'content'));
    }

    public function maintenance()
    {
        $pageTitle = 'Maintenance Mode';
        return view('templates.basic.maintenance', compact('pageTitle'));
    }

    public function placeholderImage($size)
    {
        return response()->file(public_path('assets/templates/basic/images/default.png'));
    }
}
