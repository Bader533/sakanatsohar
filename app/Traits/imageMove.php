<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait imageMove
{
    protected function moveImage($request, $pathFile, $roomId, $images)
    {
        $image = [];
        foreach ($request as $key => $multi_image) {
            $file_name = str::random(10) . $key . time() . str::random(10) . '.' . $multi_image->getClientOriginalExtension();
            $path = $pathFile;
            $multi_image->move($path, $file_name);
            $image[] = $file_name;
        }
        foreach ($image as $image) {
            for ($i = 0; $i < count($roomId); $i++) {
                $images = new RoomImage();
                $images->image_url = $image;
                $images->room_id = $roomId[$i];
                $isSaved = $images->save();
            }
        }
    }
}
