<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyPostRequest;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\ContentCategory;
use App\Models\ContentPage;
use App\Models\Post;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class PostController extends Controller
{
    use MediaUploadingTrait, CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('post_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $posts = Post::with(['pages', 'categories', 'media'])->get();

        $content_pages = ContentPage::get();

        $content_categories = ContentCategory::get();

        return view('frontend.posts.index', compact('content_categories', 'content_pages', 'posts'));
    }

    public function create()
    {
        abort_if(Gate::denies('post_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $pages = ContentPage::pluck('title', 'id');

        $categories = ContentCategory::pluck('name', 'id');

        return view('frontend.posts.create', compact('categories', 'pages'));
    }

    public function store(StorePostRequest $request)
    {
        $post = Post::create($request->all());
        $post->pages()->sync($request->input('pages', []));
        $post->categories()->sync($request->input('categories', []));
        if ($request->input('feature_image', false)) {
            $post->addMedia(storage_path('tmp/uploads/' . basename($request->input('feature_image'))))->toMediaCollection('feature_image');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $post->id]);
        }

        return redirect()->route('frontend.posts.index');
    }

    public function edit(Post $post)
    {
        abort_if(Gate::denies('post_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $pages = ContentPage::pluck('title', 'id');

        $categories = ContentCategory::pluck('name', 'id');

        $post->load('pages', 'categories');

        return view('frontend.posts.edit', compact('categories', 'pages', 'post'));
    }

    public function update(UpdatePostRequest $request, Post $post)
    {
        $post->update($request->all());
        $post->pages()->sync($request->input('pages', []));
        $post->categories()->sync($request->input('categories', []));
        if ($request->input('feature_image', false)) {
            if (! $post->feature_image || $request->input('feature_image') !== $post->feature_image->file_name) {
                if ($post->feature_image) {
                    $post->feature_image->delete();
                }
                $post->addMedia(storage_path('tmp/uploads/' . basename($request->input('feature_image'))))->toMediaCollection('feature_image');
            }
        } elseif ($post->feature_image) {
            $post->feature_image->delete();
        }

        return redirect()->route('frontend.posts.index');
    }

    public function show(Post $post)
    {
        abort_if(Gate::denies('post_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $post->load('pages', 'categories');

        return view('frontend.posts.show', compact('post'));
    }

    public function destroy(Post $post)
    {
        abort_if(Gate::denies('post_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $post->delete();

        return back();
    }

    public function massDestroy(MassDestroyPostRequest $request)
    {
        $posts = Post::find(request('ids'));

        foreach ($posts as $post) {
            $post->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('post_create') && Gate::denies('post_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Post();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
