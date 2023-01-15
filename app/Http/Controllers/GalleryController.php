<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGalleryRequest;
use App\Http\Requests\UpdateGalleryRequest;
use App\Models\Gallery;
use Buglinjo\LaravelWebp\Facades\Webp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class GalleryController extends Controller
{

    /**
     * @api {get} /gallery gallery.index
     * @apiName gallery.index
     * @apiGroup gallery
     * @apiParam {Number} [per_page=10] per page
     */
    public function index(Request $request)
    {
        $gallery = Gallery::query()->where('user_id', auth()->id())->latest()->paginate($request->input('per_page', 10));
        return response()->json($gallery);
    }


    /**
     * @api {post} /gallery gallery.store
     * @apiName gallery.store
     * @apiGroup gallery
     * @apiBody {File} file file
     * @apiBody {String} type type_consist of image or video or file
     */
    public function store(StoreGalleryRequest $request)
    {
        if (!$request->file('file')?->isValid()) {
            return response()->json(['message' => 'file is not valid'], 422);
        }

        if ($request->input('type') === 'image') {
            $name = Str::uuid() . '_' . Str::slug(Str::replaceLast($request->file('file')->getClientOriginalExtension(), '', $request->file('file')->getClientOriginalName())) . '.' . $request->file('file')->getClientOriginalExtension();
            $dirPath = auth()->id() . '/images/';
            $relativePath = $dirPath . $name;
            Storage::disk('public')
                ->putFileAs($dirPath, $request->file('file'), $name);
            $mime = $request->file('file')->getMimeType();

            switch ($mime) {
                case 'image/jpeg':
                    $im = imagecreatefromjpeg(storage_path('app/public/' . $relativePath));
                    $newImagePath = Str::replaceLast(".jpg", ".webp", storage_path('app/public/' . $relativePath));
                    imagewebp($im, $newImagePath, 70);
                    Storage::disk('public')->delete($relativePath);
                    break;
                case 'image/png':
                    $im = imagecreatefromjpeg(storage_path('app/public/' . $relativePath));
                    $newImagePath = Str::replaceLast(".png", ".webp", storage_path('app/public/' . $relativePath));
                    imagewebp($im, $newImagePath, 70);
                    Storage::disk('public')->delete($relativePath);
                    break;
                default:
                    return response()->json(['message' => 'file is not valid'], 422);

            }


        } elseif ($request->input('type') === 'video') {
            $name = Str::uuid() . '_' . $request->file('file')->getClientOriginalExtension();
            $dirPath = auth()->id() . '/video/';
            $relativePath = $dirPath . $name;
            Storage::disk('public')
                ->putFileAs($dirPath, $request->file('file'), $name);
        } else {
            $name = Str::uuid() . '_' . $request->file('file')->getClientOriginalExtension();
            $dirPath = auth()->id() . '/other/';
            $relativePath = $dirPath . $name;
            Storage::disk('public')
                ->putFileAs($dirPath, $request->file('file'), $name);
        }

        Gallery::query()->create([
            'path' => $relativePath,
            'full_path' => Storage::disk('public')->url($relativePath),
            'type' => $request->input('type'),
            'mime_type' => $request->file('file')->getMimeType(),
            'size' => $request->file('file')->getSize(),
            'user_id' => auth()->id(),
        ]);

        return response()->json(['message' => 'فایل شما با موفقیت آپلود شد']);

    }

    /**
     * @api {get} /gallery/:id gallery.show
     * @apiName gallery.show
     * @apiGroup gallery
     * @apiParam {Number} id model id
     */
    public function show(Gallery $gallery)
    {
        $gallery->delete();
        return response()->json(['message' => 'فایل شما با موفقیت حذف شد']);
    }

    /**
     * @api {delete} /gallery/{id} gallery.destroy
     * @apiName gallery.destroy
     * @apiGroup gallery
     */
    public function destroy(Gallery $gallery)
    {
        $gallery->delete();
        return response()->json(['message' => 'فایل شما با موفقیت حذف شد']);
    }

}
