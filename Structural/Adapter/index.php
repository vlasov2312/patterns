<?php

interface Social
{
    public function send($msg);
}

class Twitter
{
    public function send($msg) {
        echo $msg;
    }
}


class twitterAdapter implements Social
{
    private $twitter;

    public function __construct(Twitter $twitter) {
        $this->twitter = $twitter;
    }

    public function send($msg) {
        $this->twitter->send($msg);
    }
}

$twitter = new twitterAdapter(new Twitter());
$twitter->send('Posting to Twitter');
