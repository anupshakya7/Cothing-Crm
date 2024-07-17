<?php

use Illuminate\Database\Seeder;
use Illuminate\Http\Request;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('posts')->truncate();

      DB::table('posts')->insert([

       [
       'author_id' => 2,
       'category_id' => 7,
       'title' => "Facebook fake IDs to be a thing of the past",
       'slug'   => 'facebook-fake-ids-to-be-a-thing-of-the-past',
       'image' => 'facebook_hand.jpg',
       'body'   => "Social networking giant Facebook is working on a new tool to detect and subsequently block fake IDs created using others’ personal information and photos. The latest tool is still in the testing phase and once finally ready, the tool can be used to identify fake accounts. According to reports by Mashable and The Next Web, if someone creates a new account using your photo and personal information, the new tool will send you a notification informing you of the activity.Facebook has been working on this feature since last November and the social networking site has said ensuring privacy of its users is one of their top priorities. Once the tool is ready, it will be available for 75% of Facebook users.Fake Ids are often created with the purpose of carrying out illegal and fraudulent activities. The latest Facebook tool will also help the concerned authorities to take legal actions against those perpetrators",
       'published_at' => date('Y-m-d H:i:s', strtotime('+2 weeks')),
       'language' => 'en'

       ],
       [
       'author_id' => 3,
       'category_id' => 6,
       'title' => 'Example post 3',
       'slug'   => 'example-post-3',
       'image' => 'facebook_hand.jpg',
       'body'   => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna liqua. Ut enim ad minim veniam, quis nostrud exercitation llamco laboris nisi ut aliquip ex ea commodo consequat. Duis ute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat upidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
       'published_at' => null,
       'language' => 'en'

       ],[
       'author_id' => 1,
       'category_id' => 6,
       'title' => 'What’s the best way to set up a Windows 10 machine?',
       'slug' 	=> "what-s-the-best-way-to-set-up-a-windows-10-machine",
       'image' => 'windows_ten.jpg',
       'body' 	=> "Windows has changed a lot in the past decade, and now it’s a mobile operating system. If your daughter has some experience with Google Android, she’ll probably cope quite well. Many of Windows 10’s main features came from the mobile world. These include sandboxed apps installed and updated from an online store, log-on PINs, touch screens, notifications, a voice-aware intelligent assistant (Cortana), location awareness and a “Find my device” feature.",
       'published_at' => date('Y-m-d H:i:s', strtotime('now')),
       'language' => 'en'
       ],

       [
       'author_id' => 1,
       'category_id' => 6,
       'title' => '5 Ways Your Old Blogs Can Generate New Leads',
       'slug'   => "5-Ways-Your-Old-Blogs-Can-Generate-New-Leads",
       'image' => 'old_blog.jpg',
       'body'   => "You’ve probably invested a lot of time and money into your blog. Perhaps you’ve hired freelancers to contribute content, or you’ve spent hours pouring over analytics to find that sweet spot in your content marketing that generates results. Given the investment in your blog, it makes sense to revisit old posts and make them new again. Optimizing old blog content to generate more leads can have great results.",
       'published_at' => date('Y-m-d H:i:s', strtotime('now')),
       'language' => 'en'
       ],
       [
       'author_id' => 2,
       'category_id' => 8,
       'title' => "Here's Why You Should Quit Reading and Start Doing",
       'slug'   => "here-s-why-you-should-quit-reading-and-start-doing",
       'image' => 'quit_reading.jpg',
       'body'   => "When we moved to the mountains, we had absolutely no idea what we were getting ourselves into. During one storm we lost power for days and a landslide shut down the freeway. There were flash floods, deck umbrellas flying over the house and heavy metal lounge chairs ending up in the swimming pool.",
       'published_at' => date('Y-m-d H:i:s', strtotime('now')),
       'language' => 'en'
       ],
       [
       'author_id' => 2,
       'category_id' => 7,
       'title' => "8 Tips To Avoid Customers Falling Asleep Reading Your Blog",
       'slug'   => "8-tips-to-avoid-customers-falling-asleep-reading-your-blog",
       'image' => 'asleep_reading.jpg',
       'body'   => "Content creation in business is a vital part of keeping the business afloat. According to a recent survey nearly 61% of consumers made big purchases based upon a blog post. Additionally 57% of companies survived reported that they have gained new customers from a blog. Yet, turning a profit from a blog can be a bit tricky, especially if you are new to blogging. Here are a few tips to help your numbers and your revenue add up. 1. Make your message clear",
       'published_at' => date('Y-m-d H:i:s', strtotime('now')),
       'language' => 'en'
       ],
       [
       'author_id' => 2,
       'category_id' => 9,
       'title' => "Amazon Echo: 6 interesting Alexa skills to try with your new speaker",
       'slug'   => "Amazon-Echo-6-interesting-Alexa-skills-to-try-withyour-new -speaker",
       'image' => 'amazon_echo.jpg',
       'body'   => "Amazon Echo offers several integrations, aka \"skills\", allowing you to fully leverage the power of Alexa.Millions of Alexa-enabled devices were sold this holiday season, according to a recent announcement from Amazon. With all those people suddenly asking Alexa to look up things or complete tasks for them, don't be surprised if more companies begin releasing their own unique skills through the Alexa marketplace.",
       'published_at' => date('Y-m-d H:i:s', strtotime('now')),
       'language' => 'en'
       ],

       [
       'author_id' => 2,
       'category_id' => 9,
       'title' => "Apple iPhone 8 News & Update: All You Need To Know",
       'slug'   => "apple-iphone-8-news-&-update:-all-you-need-to-know",
       'image' => 'iphone_design.jpg',
       'body'   => "AWhile the vast majority of Apple's fans is still focused on waiting for the iPhone 7, it's the iPhone 8 set for a 2017 release date that might be more interesting to wait for. The cutting-edge gadget will come to celebrate the iPhone's 10th anniversary with radical redesign and packed with stunning features and specs. iPhone 8 Radical Redesign The iPhone 7 might disappoint those waiting for radical changes. But for those Apple fans willing to wait it out, the iPhone 8 set to come on the market in 2017 could be an incredibly intriguing device, according to a report published by BGR. Echoing previous rumors and speculations, a new report from Bloomberg suggests that the iPhone 8 will discontinue the mechanical home button that has been an Apple brand image staple until now.",
       'published_at' => date('Y-m-d H:i:s', strtotime('now')),
       'language' => 'en'
       ],

       ]);




File::copy(public_path('themes/default/assets/images/posts/facebook_hand.jpg'), public_path('/upload/posts/'.'facebook_hand.jpg'));

File::copy(public_path('themes/default/assets/images/posts/windows_ten.jpg'), public_path('/upload/posts/'.'windows_ten.jpg'));

File::copy(public_path('themes/default/assets/images/posts/old_blog.jpg'), public_path('/upload/posts/'.'old_blog.jpg'));

File::copy(public_path('themes/default/assets/images/posts/quit_reading.jpg'), public_path('/upload/posts/'.'quit_reading.jpg'));

File::copy(public_path('themes/default/assets/images/posts/asleep_reading.jpg'), public_path('/upload/posts/'.'asleep_reading.jpg'));

File::copy(public_path('themes/default/assets/images/posts/amazon_echo.jpg'), public_path('/upload/posts/'.'amazon_echo.jpg'));

File::copy(public_path('themes/default/assets/images/posts/iphone_design.jpg'), public_path('/upload/posts/'.'iphone_design.jpg'));


}
}
