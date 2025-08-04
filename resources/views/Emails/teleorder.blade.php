<?php
// Use the public path instead of asset() to ensure images are accessible outside the app.
$imageUrl = public_path('images/inmed_logo.png');
?>
<style>
img {
  display: block;
  margin-left: auto;
  margin-right: auto;
  width: 40%;
}
</style>

<x-mail::message>
<img src="{{ $message->embed($imageUrl) }}"></img>

# Message

TeleOrder has been approved.

</x-mail::message>
