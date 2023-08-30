<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use App\Models\News;
use App\Models\NewsCarousel;
use App\Models\NewsCategories;
use App\Models\NewsTags;
use App\Models\Tags;
use Carbon\Carbon;
use Cocur\Slugify\Slugify;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    public function __construct(Request $request)
    {
        parent::__construct($request);
    }

    public function index()
    {
        return view('admin.news', [
            'news' => News::orderBy('id', 'desc')->get(),
            'categories' => Categories::orderBy('id', 'desc')->get(),
            'tags' => Tags::orderBy('id', 'desc')->get(),
        ]);
    }

    public function info()
    {
        $validator = Validator::make($this->request->all(), [
            'id' => ['required', 'numeric']
        ]);

        if ($validator->fails()) {
            return jsonResponse(['error' => concatErrors($validator->errors()->getMessages())]);
        }

        $news = News::find($this->request->id);
        if ($news == null) {
            return jsonResponse(['error' => 'Новость не существует!']);
        }

        $news['categories'] = $news->categories;
        $news['tags'] = $news->tags;
        $news['carousel'] = $news->carousel;

        return jsonResponse($news);
    }

    public function delete()
    {
        $validator = Validator::make($this->request->all(), [
            'id' => ['required', 'numeric', 'min:1'],
        ]);

        if ($validator->fails()) {
            return jsonResponse(['error' => concatErrors($validator->errors()->getMessages())]);
        }

        $news = News::find($this->request->id);
        if ($news == null) {
            return jsonResponse(['error' => 'Новость не существует!']);
        }

        $deleted = $news->delete();
        if ($deleted) {
            NewsTags::where('news_id', $this->request->id)->delete();
            NewsCategories::where('news_id', $this->request->id)->delete();
            return jsonResponse(['success' => 'Вы успешно удалили новость!']);
        }

        return jsonResponse(['error' => 'Не удалось удалить новость!']);
    }

    public function add()
    {
        $toValidate = [
            'short_descr' => ['required', 'string', 'min:1', 'max:1000'],
            'full_descr' => ['required', 'string', 'min:1'],
            'type' => ['required', 'string', 'min:1', 'max:20'],
        ];

        if (isset($this->request->asset)) {
            $toValidate['asset'] = ['required', 'mimes:jpeg,png,jpg,gif,svg,webp,gif,mp4,ogg,webm', 'max:30720'];
        }

        if (isset($this->request->full_image)) {
            $toValidate['full_image'] = ['required', 'mimes:jpeg,png,jpg,gif,svg,webp,gif', 'max:8096'];
        }

        $validator = Validator::make($this->request->all(), $toValidate, [], [
            'short_descr' => 'Крактое описание',
            'full_descr' => 'Полное описание',
            'type' => 'Тип новости',
            'asset' => 'Фото/видео'
        ]);

        if ($validator->fails()) {
            return jsonResponse(['error' => concatErrors($validator->errors()->getMessages())]);
        }

        if (empty($this->request->tags)) {
            return jsonResponse(['error' => 'Вы должны указать хотя бы один тэг!']);
        }
        if (empty($this->request->categories)) {
            return jsonResponse(['error' => 'Вы должны указать хотя бы одну тематику!']);
        }

        $assetUrl = null;
        if (isset($this->request->asset)) {
            $filename = 'asset-' . time() . '-' . Str::random(
                    24
                ) . '.' . $this->request->asset->getClientOriginalExtension();
            $stored = $this->request->file('asset')->storeAs('public/news_assets/', $filename);

            if ($stored) {
                $assetUrl = url('') . '/storage/news_assets/' . $filename;
            }
        }

        $fullImage = null;
        if (isset($this->request->full_image)) {
            $filename = 'full-asset-' . time() . '-' . Str::random(
                    24
                ) . '.' . $this->request->full_image->getClientOriginalExtension();
            $stored = $this->request->file('full_image')->storeAs('public/news_assets/', $filename);

            if ($stored) {
                $fullImage = url('') . '/storage/news_assets/' . $filename;
            }
        }

        $data = $this->request->all();
        $data['asset_url'] = $assetUrl;
        $data['full_image'] = $fullImage;
        $data['created_at'] = Carbon::now()->toDateTimeString();

        if (empty($data['slug'])) {
            $slugify = new Slugify();
            $data['slug'] = $slugify->slugify(substr($data['short_descr'],0, 150));
        }

        $saved = News::create($data);
        if ($saved) {
            $tags = [];
            $categories = [];
            if (isset($this->request->tags)) {
                foreach ($this->request->tags as $tag) {
                    $tags[] = [
                        'news_id' => $saved->id,
                        'tag_id' => $tag,
                    ];
                }
            }

            if (isset($this->request->categories)) {
                foreach ($this->request->categories as $category) {
                    $categories[] = [
                        'news_id' => $saved->id,
                        'category_id' => $category,
                    ];
                }
            }

            NewsTags::insert($tags);
            NewsCategories::insert($categories);

            if (isset($this->request->gallery)) {
                $this->saveGallery($this->request->gallery, $saved->id);
            }

            return jsonResponse(['success' => 'Вы успешно создали новость!']);
        }

        return jsonResponse(['error' => 'Не удалось создать новость. Перепроверьте входные данные и повторите попытку!']
        );
    }

    public function edit(News $newsObject)
    {
        $toValidate = [
            'short_descr' => ['required', 'string', 'min:1', 'max:1000'],
            'full_descr' => ['required', 'string', 'min:1'],
            'type' => ['required', 'string', 'min:1', 'max:20'],
        ];

        if (isset($this->request->asset)) {
            $toValidate['asset'] = ['required', 'mimes:jpeg,png,jpg,gif,svg,webp,gif,mp4,ogg,webm', 'max:30720'];
        }

        if (isset($this->request->full_image)) {
            $toValidate['full_image'] = ['required', 'mimes:jpeg,png,jpg,gif,svg,webp,gif', 'max:8096'];
        }

        $validator = Validator::make($this->request->all(), $toValidate, [], [
            'short_descr' => 'Крактое описание',
            'full_descr' => 'Полное описание',
            'type' => 'Тип новости',
            'asset' => 'Фото/видео'
        ]);

        if ($validator->fails()) {
            return jsonResponse(['error' => concatErrors($validator->errors()->getMessages())]);
        }

        $news = News::find($this->request->id);
        if ($news == null) {
            return jsonResponse(['error' => 'Новость не существует для редактирования!']);
        }

        $data = $this->request->all();

        $currentAsset = $news->asset_url;
        $currentFullImage = $news->full_image;

        $assetUrl = null;
        if (isset($this->request->asset)) {
            $filename = 'asset-' . time() . '-' . Str::random(
                    24
                ) . '.' . $this->request->asset->getClientOriginalExtension();
            $stored = $this->request->file('asset')->storeAs('public/news_assets/', $filename);

            if ($stored) {
                $assetUrl = url('') . '/storage/news_assets/' . $filename;
                $data['asset_url'] = $assetUrl;
                if ($currentAsset != null) {
                    $newsObject->clearAsset($currentAsset);
                }
            }
        } else {
            if (intval($this->request->del_asset) == 1 && $currentAsset != null) {
                $newsObject->clearAsset($currentAsset);
                $data['asset_url'] = null;
            }
        }

        $fullImage = null;
        if (isset($this->request->full_image)) {
            $filename = 'full-asset-' . time() . '-' . Str::random(
                    24
                ) . '.' . $this->request->full_image->getClientOriginalExtension();
            $stored = $this->request->file('full_image')->storeAs('public/news_assets/', $filename);

            if ($stored) {
                $fullImage = url('') . '/storage/news_assets/' . $filename;
                $data['full_image'] = $fullImage;
                if ($currentFullImage != null) {
                    $newsObject->clearAsset($currentFullImage);
                }
            }
        } else {
            if (intval($this->request->del_full_image) == 1 && $currentFullImage != null) {
                $newsObject->clearAsset($currentFullImage);
                $data['full_image'] = null;
            }
        }

        //$data['asset_url'] = $assetUrl;
        //$data['full_image'] = $fullImage;

        $data = $this->request->all();

        if (empty($data['slug'])) {
            $slugify = new Slugify();
            $data['slug'] = $slugify->slugify(substr($data['short_descr'],0, 150));
        }

        $updated = $news->fill($data)->save();
        if ($updated) {
            NewsTags::where('news_id', $this->request->id)->delete();
            NewsCategories::where('news_id', $this->request->id)->delete();

            $tags = [];
            $categories = [];
            if (isset($this->request->tags)) {
                foreach ($this->request->tags as $tag) {
                    $tags[] = [
                        'news_id' => $news->id,
                        'tag_id' => $tag,
                    ];
                }
            }

            if (isset($this->request->categories)) {
                foreach ($this->request->categories as $category) {
                    $categories[] = [
                        'news_id' => $news->id,
                        'category_id' => $category,
                    ];
                }
            }

            NewsTags::insert($tags);
            NewsCategories::insert($categories);

            if (isset($this->request->gallery)) {
                $this->saveGallery($this->request->gallery, $news->id);
            }

            // Delete images if need
            if (isset($this->request->delete_images)) {
                foreach ($this->request->delete_images as $key => $image) {
                    $assetToClear = NewsCarousel::find($image);
                    if ($assetToClear != null) {
                        $assetToClear->delete();
                        $newsObject->clearAsset($assetToClear->asset_url);
                    }
                }
            }
            return jsonResponse(['success' => 'Вы успешно обновили новость!']);
        }

        return jsonResponse(
            ['error' => 'Не удалось обновить новость. Перепроверьте входные данные и повторите попытку!']
        );
    }

    private function saveGallery($gallery, $newsId)
    {
        foreach ($gallery as $key => $value) {
            $filename = 'gallery_asset-' . microtime() . '-' . Str::random(
                    3
                ) . '.' . $value->getClientOriginalExtension();
            $stored = $value->storeAs('public/news_assets/', $filename);

            if ($stored) {
                $assetUrl = url('') . '/storage/news_assets/' . $filename;
                NewsCarousel::create([
                    'news_id' => $newsId,
                    'asset_url' => $assetUrl
                ]);
            }
        }
    }
}
