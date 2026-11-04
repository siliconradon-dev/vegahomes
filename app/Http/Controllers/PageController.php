<?php

namespace App\Http\Controllers;

use App\Models\DesignPackage;
use App\Models\Package;
use App\Models\Project;

class PageController extends Controller
{
    public function home()
    {
        return view('pages.home', ['packages' => $this->packages(), 'designPackages' => DesignPackage::active()->get()]);
    }

    public function about()
    {
        return view('pages.about');
    }

    public function services()
    {
        return view('pages.services', ['packages' => $this->packages(), 'designPackages' => DesignPackage::active()->get()]);
    }

    public function projects()
    {
        return view('pages.projects', [
            'projects' => Project::published()->ordered()->get(),
        ]);
    }

    public function contact()
    {
        return view('pages.contact');
    }

    private function packages()
    {
        return Package::active()->get();
    }
}
