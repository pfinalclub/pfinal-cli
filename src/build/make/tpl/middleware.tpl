<?php
        namespace {{NAMESPACE}};
        class {{NAME}}{
	        //执行中间件
	        public function run($next) {
                echo "中间件执行了";
                $next();
	        }
        }