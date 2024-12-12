<?php

Broadcast::channel('chat.{toUserId}', function ($user, $toUserId) {
    return $user->id === (int) $toUserId || $user->id === (int) $user->id;
});
