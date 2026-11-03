<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class PackageController extends Controller
{
    public function index()
    {
        return view('admin.packages.index', [
            'packages' => Package::orderBy('sort_order')->orderBy('id')->get(),
        ]);
    }

    public function create()
    {
        return view('admin.packages.form', [
            'package' => new Package(['is_active' => true, 'sort_order' => (Package::max('sort_order') ?? 0) + 1]),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['slug'] = $this->uniqueSlug($data['name']);

        Package::create($data);

        return redirect()->route('admin.packages.index')->with('status', 'Package created.');
    }

    public function edit(Package $package)
    {
        return view('admin.packages.form', ['package' => $package]);
    }

    public function update(Request $request, Package $package)
    {
        $package->update($this->validated($request));

        return redirect()->route('admin.packages.index')->with('status', $package->name . ' package updated.');
    }

    public function destroy(Package $package)
    {
        // Past enquiries keep their own snapshot of the package name/rate, so deleting is safe.
        $package->delete();

        return redirect()->route('admin.packages.index')->with('status', 'Package deleted.');
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'name'       => ['required', 'string', 'max:80'],
            'tagline'    => ['nullable', 'string', 'max:255'],
            'rate'       => ['required', 'integer', 'min:1', 'max:10000000'],
            'features'   => ['nullable', 'string', 'max:2000'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:999'],
        ]);

        $lines = preg_split('/\r\n|\r|\n/', (string) ($data['features'] ?? ''));
        $data['features'] = array_values(array_filter(array_map('trim', $lines)));

        $data['sort_order']       = (int) ($data['sort_order'] ?? 0);
        $data['is_starting_rate'] = $request->boolean('is_starting_rate');
        $data['is_featured']      = $request->boolean('is_featured');
        $data['is_active']        = $request->boolean('is_active');

        return $data;
    }

    private function uniqueSlug(string $name): string
    {
        $base = Str::slug($name) ?: 'package';
        $slug = $base;
        $i    = 2;

        while (Package::where('slug', $slug)->exists()) {
            $slug = $base . '-' . $i++;
        }

        return $slug;
    }
}
