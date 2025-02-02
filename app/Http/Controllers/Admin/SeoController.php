<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Option;
use App\Traits\Uploader;
use Cache;
use Illuminate\Http\Request;

class SeoController extends Controller
{
    use Uploader;

    public function __construct()
    {
        $this->middleware('permission:seo');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Option::where('key', 'LIKE', '%seo%')->get()->map(function ($query) {
            $data['key'] = str_replace('_', ' ', str_replace('seo_', '', $query->key));
            $data['id'] = $query->id;
            $data['content'] = json_decode($query->value);

            return $data;
        });

        return view('admin.seo.index', compact('posts'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $seo = Option::where('key', 'LIKE', '%seo%')->findOrFail($id);
        $contents = json_decode($seo->value ?? '');

        return view('admin.seo.show', compact('id', 'contents'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'image' => ['image', 'max:1024'],
        ]);

        $meta = $request->metadata ?? '';

        $option = Option::where('id', $id)->first();
        $contents = json_decode($seo->value ?? '');

        if ($request->hasFile('image')) {
            $newImage = $this->saveFile($request, 'image');
            $meta['preview'] = $newImage;

            if (isset($contents->preview)) {
                if (! empty($contents->preview)) {
                    $this->removeFile($contents->preview);
                }
            }

        }

        $option->value = json_encode($meta);
        $option->save();

        Cache::forget($option->key);

        return response()->json([
            'message' => __('SEO settings updated successfully.'),
        ]);
    }
}
