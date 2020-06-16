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

    public function scopeIncomplete($query, $user)
    {
        return $query->where('user_id', $user->id)
                    ->where('status', '0')
                    ->orderBy('due_date', 'asc');
    }

    public static function checkOverDueDate($due_date)
    {
        $today = Carbon::now()->format('Y-m-d');
        return ($due_date <= $today) ? true : false;
    }

    public static function checkLimitDayTomorrowTodo($user)
    {
        $tomorrow = Carbon::now()->addDay()->format('Y-m-d');
        $todo = Todo::where('user_id', $user->id)
                    ->where('due_date', $tomorrow)
                    ->where('status', '0');
        $todo_count = $todo->count();
        $todo_get   = $todo->get();
        return [$todo_count, $todo_get];
    }

    public static function dangerTodoBool($status, $over_day)
    {
        return ($status == '0' && $over_day) ? true : false;
    }

    public function generateOgp($id)
    {
        //画像の生成
        $image = Image::make(resource_path('images/ogp.png'));
        list($gakkari_men, $gakkari_woman) = $this->gakkariImageGene();
        //Content部分
        $content = $this->content;
        $image->text($content, 300, 90, function($font) {
            $font->file(resource_path('fonts/MPLUS1p-Regular.ttf'));
            $font->size(27);
            $font->color('#dc143c');
            $font->align('center');
            $font->valign('middle');
        });
        //Template部分
        $template = "を期日までに終わらせることが\nできませんでした...";
        $image->text($template, 300, 175, function($font) {
            $font->file(resource_path('fonts/MPLUS1p-Regular.ttf'));
            $font->size(25);
            $font->color('#272A2C');
            $font->align('center');
            $font->valign('middle');
        });
        //画像のinsert
        $image->insert($gakkari_men, 'bottom-left', 5, 1);
        $image->insert($gakkari_woman, 'bottom-right', 5, 1);
        $image->resize(600, 355);
        $save_path = storage_path('ogp/' . $id . '.jpg');
        $image->save($save_path);
        return $image;
    }

    private function gakkariImageGene()
    {
        $gakkari_man   = Image::make(resource_path('images/gakkari_tameiki_man.png'));
        $gakkari_woman = Image::make(resource_path('images/gakkari_tameiki_woman.png'));
        $gakkari_man->resize(180, 180);
        $gakkari_woman->flip()->resize(180, 180);
        return [$gakkari_man, $gakkari_woman];
    }
}
