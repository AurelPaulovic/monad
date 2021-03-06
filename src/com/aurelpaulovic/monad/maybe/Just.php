<?php
/**
 * Copyright 2014 Aurel Paulovic
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * @author Aurel Paulovic
 */

namespace com\aurelpaulovic\monad\maybe;

use com\aurelpaulovic\monad\MonadException;

class Just extends Maybe {
    private $val = null;

    public function __construct($val) {
        $this->val = $val;
    }

    public function __call($name, $arguments) {
        $return = $this->val->$name($arguments);

        if($return instanceof Maybe) return $return;
        else throw new MonadException("Method '$name' did not return a Maybe monad");
    }

    public function bind($func) {
        if(is_callable($func)) {
            $result = $func($this->val);
        } else {
            $result = call_user_func($func, $this->val);
        }

        if($result instanceof Maybe) return $result;
        else throw new MonadException("Method '$func' did not return a Maybe monad");
    }

} 