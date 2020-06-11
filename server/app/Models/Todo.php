<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Intervention\Image\Facades\Image;
use Carbon\Carbon;
use App\Models\User;

class Todo extends Model
{
    protected $guarded = ['id'];

    public function todos()
    {
        return $this->belongsTo(User::class);
    }

    public static function checkOverDueDate($due_date)
    {
        $dt = Carbon::now();
        $today = $dt->format('Y-m-d');
        return ($due_date <= $today) ? true : false;
    }

    public function generateOgp($id)
    {
        $content = $this->getWordwrapedBody();
        $image = Image::make(resource_path('images/ogp.png'));
        $image->text($content, 300, 90, function($font){
            $font->file(resource_path('fonts/MPLUS1p-Regular.ttf'));
            $font->size(20);
            $font->color('#272A2C');
            $font->align('center');
            $font->valign('top');
        });
        $image->resize(600, 355);
        $save_path = storage_path('ogp/' . $id . '.jpg');
        $image->save($save_path);
        return $image;
    }

    private function getWordwrapedBody()
    {
        $lines = explode("\n", $this->content);
        $result = [];
        foreach ($lines as $line) {
            $length = mb_strlen($line);
            for ($start = 0; $start < $length; $start += 20) {
                $result[] = mb_substr($line, $start, 20);
            }
        }
        return join("\n", $result);
    }
}
