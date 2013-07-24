# HootURLs
---=

## Framework for HootSuite Technical Test

###Introduction
---
This framework was built at the behest of a technical test supplied by Hootsuite, those crazy social media people. There is an API available with 3 endpoints. There is also a client demo at http://www.linkmun.ch.

- If you make a POST to linkmun.ch/er/ asynchronously, or provide a link in the form of linkmun.ch/er/http://linkgoeshere.com in a browser, you will receive a shortened link back.
- If you make a POST to linkmun.ch/y asynchronously, or provide a link in the form of linkmun.ch/y/10d2e5 in a browser, you will receive the full link back.

Any POST Requests should include some data sent along in the form of:
    
    { "url": "linkoridhere" }

There is no auto-redirection upon providing a link, however, this may be easily implemented, as this app was built with extensibility in mind. I have built in a routing system, which points to a method in the URLController controller, as well as the Twig templating system from Symfony for providing any synchronous pages you may want to implement.

###Installation
---

####Composer
    
    {
        "require": {
            "soq/linkmunch": "dev-master"
        }
    }

####Git

    git clone http://github.com/six0h/linkmun.ch.git linkmunch/
            

###Usage
---

####Routing
Routing is handled on the server side, and defined directly in the index.php file in the /web directory.

How to add Routes is clearly defined in the index file itself, and follows the order of:

    $router->add('RouteName','URI','Method');

A simple *match* method is used after to match up the actual client URI with your routes:

    $router->match($_SERVER['REQUEST_URI']);
