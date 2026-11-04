<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DesignPackage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class DesignPackageController extends Controller
{
    public function index()
    {
        return view('admin.design-packages.index', [
            'packages' => DesignPackage::orderBy('sort_order')->orderBy('id')->get(),
        ]);
    }

    public function create()
    {
        return view('admin.design-packages.form', [
            'package' => new DesignPackage([
                'is_active' => true, 'pricing_type' => 'per_sqft', 'construction_rate' => 16500,
                'sort_order' => (DesignPackage::max('sort_order') ?? 0) + 1,
            ]),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['slug'] = $this->uniqueSlug($data['name']);

        DesignPackage::create($data);

        return redirect()->route('admin.design-packages.index')->with('status', 'Design package created.');
    }

    public function edit(DesignPackage $designPackage)
    {
        return view('admin.design-packages.form', ['package' => $designPackage]);
    }

    public function update(Request $request, DesignPackage $designPackage)
    {
        $designPackage->update($this->validated($request));

        return redirect()->route('admin.design-packages.index')->with('status', $designPackage->name . ' design package updated.');
    }

    public function destroy(DesignPackage $designPackage)
    {
        // Past enquiries keep their own snapshot, so deleting is safe.
        $designPackage->delete();

        return redirect()->route('admin.design-packages.index')->with('status', 'Design package deleted.');
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'name'              => ['required', 'string', 'max:80'],
            'tagline'           => ['nullable', 'string', 'max:255'],
            'note'              => ['nullable', 'string', 'max:255'],
            'pricing_type'      => ['required', Rule::in(['per_sqft', 'percent'])],
            'rate'              => ['required', 'numeric', 'min:0.01', 'max:1000000'],
            'construction_rate' => ['required', 'integer', 'min:1', 'max:10000000'],
            'features'          => ['nullable', 'string', 'max:3000'],
            'sort_order'        => ['nullable', 'integer', 'min:0', 'max:999'],
        ]);

        $lines = preg_split('/\r\n|\r|\n/', (string) ($data['features'] ?? ''));
        $data['features']    = array_values(array_filter(array_map('trim', $lines)));
        $data['sort_order']  = (int) ($data['sort_order'] ?? 0);
        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_active']   = $request->boolean('is_active');

        return $data;
    }

    private function uniqueSlug(string $name): string
    {
        $base = Str::slug($name) ?: 'design-package';
        $slug = $base;
        $i    = 2;

        while (DesignPackage::where('slug', $slug)->exists()) {
            $slug = $base . '-' . $i++;
        }

        return $slug;
    }
}
