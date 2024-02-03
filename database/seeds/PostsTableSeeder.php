<?php

use Illuminate\Database\Seeder;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('posts')->insert([
            [
                'post' => 'ステキなアイディアや制作ログなど、自由にアウトプットしてみましょう！',
                'user_id' => '1',
                'tag' => '#テストタグ１ #テストタグ２',
            ],
            [
                'post' => 'デジタルイラストを描きました。使用した道具は、ペンタブレットとIllustratorです。',
                'user_id' => '2',
                'tag' => '#イラスト',
            ],
            [
                'post' => 'JavaScriptを使ってタイマーを作りました。停止ボタンで一時停止することができます。',
                'user_id' => '3',
                'tag' => '#プログラミング #JavaScript',
            ],
            [
                'post' => 'レザークラフトに挑戦しました。コバは丁寧に磨くのがコツです。',
                'user_id' => '4',
                'tag' => '',
            ]
        ]);
    }
}
