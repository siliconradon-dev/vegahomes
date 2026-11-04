<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $query = Project::query()->ordered();

        if ($request->filled('status')) {
            $query->where('status', $request->query('status'));
        }
        if ($q = trim((string) $request->query('q'))) {
            $query->where(fn ($w) => $w->where('title', 'like', "%{$q}%")->orWhere('location', 'like', "%{$q}%"));
        }

        return view('admin.projects.index', [
            'projects' => $query->paginate(12)->withQueryString(),
            'counts'   => Project::selectRaw('status, count(*) as aggregate')->groupBy('status')->pluck('aggregate', 'status'),
            'filters'  => $request->only(['q', 'status']),
        ]);
    }

    public function create()
    {
        return view('admin.projects.form', [
            'project' => new Project(['status' => 'ongoing', 'is_published' => true, 'sort_order' => 0, 'progress' => 0]),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['slug']   = Project::uniqueSlug($data['title']);
        $data['images'] = $this->storeUploads($request);

        Project::create($data);

        return redirect()->route('admin.projects.index')->with('status', 'Project added.');
    }

    public function edit(Project $project)
    {
        return view('admin.projects.form', ['project' => $project]);
    }

    public function update(Request $request, Project $project)
    {
        $data   = $this->validated($request);
        $images = $project->images ?? [];

        // 1) remove images the admin ticked
        $remove = (array) $request->input('remove_images', []);
        foreach ($remove as $path) {
            if (in_array($path, $images, true)) {
                $this->deleteFile($path);
            }
        }
        $images = array_values(array_diff($images, $remove));

        // 2) add new uploads
        $images = array_merge($images, $this->storeUploads($request));

        // 3) chosen cover goes first
        $cover = $request->input('cover');
        if ($cover && in_array($cover, $images, true)) {
            $images = array_values(array_unique(array_merge([$cover], $images)));
        }

        $data['images'] = $images;
        $data['slug']   = Project::uniqueSlug($data['title'], $project->id);

        $project->update($data);

        return redirect()->route('admin.projects.index')->with('status', '“' . $project->title . '” updated.');
    }

    /** Quick actions from the list: change status / publish toggle. */
    public function status(Request $request, Project $project)
    {
        $data = $request->validate([
            'status' => ['nullable', Rule::in(array_keys(Project::STATUSES))],
            'toggle' => ['nullable', 'in:publish'],
        ]);

        if (!empty($data['status'])) {
            $update = ['status' => $data['status']];
            if ($data['status'] === 'completed') {
                $update['progress']     = 100;
                $update['completed_on'] = $project->completed_on ?: now();
            }
            $project->update($update);
        }
        if (($data['toggle'] ?? null) === 'publish') {
            $project->update(['is_published' => !$project->is_published]);
        }

        return back()->with('status', '“' . $project->title . '” updated.');
    }

    public function destroy(Project $project)
    {
        foreach ($project->images ?? [] as $path) {
            $this->deleteFile($path);
        }
        $project->delete();

        return redirect()->route('admin.projects.index')->with('status', 'Project deleted.');
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'title'          => ['required', 'string', 'max:160'],
            'status'         => ['required', Rule::in(array_keys(Project::STATUSES))],
            'location'       => ['nullable', 'string', 'max:160'],
            'description'    => ['nullable', 'string', 'max:5000'],
            'progress'       => ['nullable', 'integer', 'min:0', 'max:100'],
            'started_on'     => ['nullable', 'date'],
            'completed_on'   => ['nullable', 'date'],
            'sort_order'     => ['nullable', 'integer', 'min:0', 'max:9999'],
            'images'         => ['nullable', 'array', 'max:60'],
            'images.*'       => ['image', 'mimes:jpg,jpeg,png,webp', 'max:6144'], // 6 MB each
        ], [
            'images.*.image' => 'Each file must be an image (JPG, PNG or WEBP).',
            'images.*.mimes' => 'Images must be JPG, PNG or WEBP.',
            'images.*.max'   => 'Each image must be 6 MB or smaller.',
        ]);

        unset($data['images']);

        $data['sort_order']   = (int) ($data['sort_order'] ?? 0);
        $data['is_published'] = $request->boolean('is_published');

        if ($data['status'] === 'completed') {
            $data['progress'] = 100;
        } elseif ($data['status'] === 'design') {
            $data['progress'] = null;
        }

        return $data;
    }

    /** @return array<int, string> stored paths, relative to /public */
    private function storeUploads(Request $request): array
    {
        $dir = public_path(Project::UPLOAD_DIR);
        File::ensureDirectoryExists($dir);

        $paths = [];
        foreach (Arr::wrap($request->file('images', [])) as $file) {
            $name = now()->format('ymd') . '-' . Str::lower(Str::random(10)) . '.' . $file->extension();
            $file->move($dir, $name);
            $paths[] = Project::UPLOAD_DIR . '/' . $name;
        }

        return $paths;
    }

    /** Only ever deletes files that were uploaded through the admin panel. */
    private function deleteFile(string $path): void
    {
        if (str_starts_with($path, Project::UPLOAD_DIR . '/') && !str_contains($path, '..')) {
            File::delete(public_path($path));
        }
    }
}
