<?php
/*
* Simple request-reply broker
* @author Ian Barber <ian(dot)barber(at)gmail(dot)com>
*/

//  Prepare our context and sockets
error_log("Starting Broker");
$context = new ZMQContext();
$frontend = new ZMQSocket($context, ZMQ::SOCKET_ROUTER);
$backend = new ZMQSocket($context, ZMQ::SOCKET_DEALER);
$frontend->bind("tcp://127.0.0.1:5559");
error_log("Frontend Ready");
$backend->bind("tcp://127.0.0.1:5560");
error_log("Backend Ready");

//  Initialize poll set
$poll = new ZMQPoll();
$poll->add($frontend, ZMQ::POLL_IN);
$poll->add($backend, ZMQ::POLL_IN);
$readable = $writeable = array();

//  Switch messages between sockets
while (true) {
    $events = $poll->poll($readable, $writeable);

    foreach ($readable as $socket) {
        if ($socket === $frontend) {
            //  Process all parts of the message
            while (true) {
                $message = $socket->recv();
                error_log("Data");
                //  Multipart detection
                $more = $socket->getSockOpt(ZMQ::SOCKOPT_RCVMORE);
                $backend->send($message, $more ? ZMQ::MODE_SNDMORE : null);
                if (!$more) {
                    break; //  Last message part
                }
            }
        } elseif ($socket === $backend) {
            $message = $socket->recv();
            error_log("Data Back");
            //  Multipart detection
            $more = $socket->getSockOpt(ZMQ::SOCKOPT_RCVMORE);
            $frontend->send($message, $more ? ZMQ::MODE_SNDMORE : null);
            if (!$more) {
                break; //  Last message part
            }
        }
    }
}
?>
