<?php

namespace App\Acme\Helpers;

use Cache;
use Illuminate\Http\Request;
use LinkPreview\LinkPreview;
use LinkPreview\Model\VideoLink;

class LinkPreviewHelper{

    static public function parse(Request $request)
    {
        $data = [];

        try{
            $linkPreview = new LinkPreview($request->get('url'));

            $data = Cache::remember('$linkPreview', 3600, function () use ($linkPreview)
            {
                $data = [];
                $parsed = $linkPreview->getParsed();
                foreach ($parsed as $parserName => $link) {
                    $images = [$link->getImage()];

                    $data = [
                        'title' => $link->getTitle(),
                        'url' => $link->getRealUrl(),
                        'description' => $link->getDescription()
                    ];

                    if ($link instanceof VideoLink) {
                        $data['video'] = $link->getEmbedCode();
                    } else {
                        $images = array_merge($images, $link->getPictures());
                    }

                    foreach ($images as $key => &$image) {
                        if (empty($image)) {
                            unset($images[$key]);
                            continue;
                        }


                        if (filter_var($image, FILTER_VALIDATE_URL) === FALSE)
                            $image = $link->getRealUrl() . $image;
                    }

                    $images = array_values($images);

                    $data['images'] = $images;
                }

                return $data;
            });

        } catch(\Exception $e) {

        }

        return response()->json($data,  200);
    }
}
