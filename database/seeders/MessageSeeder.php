<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class MessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $messages = [
            ["Alice", "Hey everyone, did you guys finish the math homework?"],
            ["Bob", "Not yet… it's so hard! I got stuck on question 5."],
            ["Charlie", "Same! I think we need to use the formula from last week's class."],
            ["David", "Wait, isn't it just Pythagoras' theorem?"],
            ["Emma", "Yes! I checked my notes, and it's basically a right triangle problem."],
            ["Frank", "So if I use a² + b² = c², I should get the answer?"],
            ["Grace", "Exactly! I got 13 as my final answer for Q5."],
            ["Harry", "Wait… did we have to submit this today? 😨"],
            ["Ivy", "Nope, it's due tomorrow before 5 PM."],
            ["Jack", "Phew! Thought I missed the deadline. Thanks, Ivy!"],
            ["Alice", "By the way, did anyone understand the physics lecture today?"],
            ["Bob", "Nope, I was completely lost. What even is quantum entanglement? 😵"],
            ["Charlie", "It's when two particles are linked, no matter how far apart they are."],
            ["David", "That sounds like sci-fi. Is this real??"],
            ["Emma", "Yep! If you change one particle, the other changes instantly. Crazy, right?"],
            ["Frank", "I should have paid more attention in class…"],
            ["Grace", "On a different note, anyone free for coffee later?"],
            ["Harry", "I’m in! Let's go after class."],
            ["Ivy", "I can’t, got to study for the history quiz. 😭"],
            ["Jack", "Oh no, I forgot about that! What’s it on?"],
            ["Alice", "The French Revolution! Main events, key figures, and dates."],
            ["Bob", "Ugh, memorizing dates is the worst. 😩"],
            ["Charlie", "Agreed. Just remember 1789 = start of the revolution."],
            ["David", "Ok, serious question: Pineapple on pizza—yes or no?"],
            ["Emma", "Absolutely not. That’s a crime. 😆"],
            ["Frank", "100% yes! It’s the perfect mix of sweet and salty."],
            ["Grace", "I think we just started a war. 😂"],
            ["Harry", "Alright, back to studying. Good luck on the quiz tomorrow!"],
            ["Ivy", "Thanks! Good luck everyone!"],
            ["Jack", "Night everyone! See you in class!"]
        ];

        foreach ($messages as $index => $message) {
            DB::table('messages')->insert([
                'username'  => $message[0],
                'content'   => $message[1],
                'created_at' => Carbon::now()->subMinutes(30 - $index),
                'updated_at' => Carbon::now()->subMinutes(30 - $index),
            ]);
        }
    }
}
