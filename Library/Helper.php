<?php

###########
# Author: Cody Halovich
# Client: Hootsuite
##########

namespace Library;

/**
 * A Helper class for general duties around the framework
 */
class Helper {

    /**
     * Remove leading slash from any string
     */
    public static function removeLeadingSlash($item) {
        return substr($item, 1);
    }

}
