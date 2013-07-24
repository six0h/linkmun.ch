# HootURLs
---=

## Framework for HootSuite Technical Test

#▇ ▅ █ ▅ ▇ ▂ ▃ ▁ ▁ ▅ ▃ ▅ ▅ ▄ ▅ ▇

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

####The Controller
This whole shebang is controlled through one class, the Controller/URLController.php file contains this class, and all methods should be mapped to from the Routing system. If you dont want a method mapped for now, then dont add it to the routing system.

Taking a look through the demo code in this file should be fairly clear, once you have seen the routes that are defined in the routing system. Make sure you look at the routing system before you look at the controllers, so you know what youre looking at as far as methods go.

####Templating
A class has been created to abstract away the Twig API. You may call the Template class from Library/Template.php, which provides a render method in the form of:

    $tpl = new Template();
    $tpl->render('index.html.twig', array('paramtopass'=>'valtopass','anotherparam'=>'anotherval'));

####Models
Currently, the framework contains only one model, which is contained in the Model/URLModel.php file. Care to take 3 guesses at what happens here? THE MAGIC BABY! Business Logic happens here.

###Transport
---
SURPRISE, this baby is packing zeromq, with a whack of workers to whip up some wizardry. Our current demo client POSTs to our API Endpoints, which then relays through ZeroMQ Router,Dealer,Replier, and last (but not least!) Requestor.

Thanks to ZMQ, our messaging happens at breakneck speeds. The client could be optimized to react faster on higher performing hosts, but is currently throttled as far as responses go, to make sure data is properly committed before updating the client display.
