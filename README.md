# DateChallenge


## Running this code

Use **git** to clone this repository into a web accessible directory on a web server running at least PHP 5.6 - operating system and web server should be agnostic, although this was developed on a Windows machine running a WAMP stack.

If you have phpunit and its in your path, you can run the unit test as follows
> cd *directory_you_cloned_to*
> 
> phpunit --bootstrap DateChallenge.php Tests

There is an interactive testing script for use in a web browser in **index.php** - point your web browser at the URL in the directory you git cloned into and append /index.php 

E.g, if you git cloned to **/var/www/html/kath_datechallenge**, and your webserver public root directory is **/var/www/html**, you'd access http://*your_server_name*/kath_datechallenge/index.php.

## Assumptions/Notes:
- I haven't used PHPUnit before this challenge, however I love it now that I know about it!  I'm sure it's probably even more awesome and useful when you've had some practice thinking up tests for it
- The UTC timezone is used internally, which *will* throw out weekday determinations in some cases.
- The classes *DateChallengeFrontend* and *DateChallengeResult* don't have unit tests largely because I considered them non-functional "developer tools" (e.g used by me while writing and testing) rather than part of the deliverable.
