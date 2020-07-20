<?php
    use App\Models\User;
    /** @var User $user */
?>
Welcome {{$user->first_name}} {{$user->last_name}}!
Thank you for signing up on {{$user->created_at->format('D, F jS Y')}}
