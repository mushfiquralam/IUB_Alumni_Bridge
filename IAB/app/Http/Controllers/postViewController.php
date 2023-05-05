<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Admin;
use App\Models\Student;
use App\Models\CurrentStudent;
use App\Models\Alumni;
use App\Models\Post;
use App\Models\JobPost;
use App\Models\EventPost;
use App\Models\AwardPost;
use App\Models\QueryPost;
use App\Models\Comment;
use App\Models\Bookmark;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class postViewController extends Controller
{

    public function viewPosts()
    {
            // $posts=Post::all();
            $orderedPostIds = Post::orderByDesc('postID')->pluck('postID');
            $mergedResults = [];

            foreach ($orderedPostIds as $postId) {

                $queryData = QueryPost::where('postID', $postId)->first();
                if ($queryData) {
                    $mergedResults[] = [
                        'source' => 'query',
                        'data' => $queryData,
                    ];
                    continue;
                }

                $jobData = JobPost::where('postID', $postId)->first();
                if ($jobData) {
                    $mergedResults[] = [
                        'source' => 'job',
                        'data' => $jobData,
                    ];
                    continue;
                }

                $eventData = EventPost::where('postID', $postId)->first();
                if ($eventData) {
                    $mergedResults[] = [
                        'source' => 'event',
                        'data' => $eventData,
                    ];
                    continue;
                }
                
                $awardData = AwardPost::where('postID', $postId)->first();
                if ($awardData) {
                    $mergedResults[] = [
                        'source' => 'award',
                        'data' => $awardData,
                    ];
                    continue; 
                }
            }
        return $mergedResults;
        // return $posts;
    }
    public function viewEvents() {
        $data= EventPost::orderByDesc('eventStartDate')->get();
        return $data;
    }

    public function upcomingEvent() {
        $data = EventPost::where('eventStartDate', '>=', now()->toDateString())
            ->orderBy('eventStartDate', 'asc')->first();
        // dd($data);
        return $data;
    }

    public function getStudentsPosts(){
        return Student::join('posts', 'students.id', '=', 'posts.student_id')
        ->selectRaw('CONCAT(students.firstName, " ", students.lastName) as fullName, students.profilePictureURL, posts.postID')
        ->get();
    }

    public function getStudentComments(){
        return Comment::join('students', 'comments.userEmail', '=', 'students.userEmail')
        ->select('comments.commentID', 'comments.description', 'students.firstName', 'students.lastName', 'students.profilePictureURL')
        ->orderBy('comments.created_at', 'ASC')
        ->get();
    }

    public function getAllBookmarks(){Bookmark::select('bookmarkID', 'userEmail', 'postID')
        ->orderByDesc('created_at')
        ->orderByDesc('updated_at')
        ->get();
    }

    // public function viewJobs() {
    //     $data= JobPost::orderByDesc('eventDate')->get();;
    //     return $data;
    // }

//     public function viewQueries()
//     {
//         $queries = Query::latest('postDateTime')->get();
//         return $queries;
//     }
    
//     public function viewJobs()
//     {
//         $jobs = Job::latest('postDateTime')->get();
//         return $jobs;
//     }

//     public function viewEvents()
//     {
//         $events = Event::latest('postDateTime')->get();
//         return $events;
//     }
//     public function viewAwards()
//     {
//         $awards = Award::latest('postDateTime')->get();
//         return $awards;
//     }
    
}
